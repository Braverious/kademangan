<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CitizenDetail;
use App\Models\LoginLog;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;
use App\Models\StaffDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        $title = "Registrasi Warga - Kelurahan Kademangan";

        return view('auth.register', compact('title'));
    }
    public function showLoginWarga()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        // Arahkan ke view login warga
        return view('auth.login_warga', ['title' => 'Login Warga - Kelurahan Kademangan']);
    }

    public function showLoginStaff()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        // Arahkan ke view login staff
        return view('auth.login_staff', ['title' => 'Login Staff - Admin Kelurahan']);
    }
    public function aksi_login(Request $request)
    {
        $throttleKey = Str::lower($request->input('username')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            return back()->withErrors([
                'username' => "Terlalu banyak percobaan login. Silakan coba lagi dalam $minutes menit."
            ])->withInput($request->only('username'));
        }

        $request->validate([
            'username'             => ['required'],
            'password'             => ['required'],
            'g-recaptcha-response' => ['required', 'recaptcha'],
        ], [
            'g-recaptcha-response.required' => 'Silakan centang kotak "Saya bukan robot" terlebih dahulu.',
            'g-recaptcha-response.recaptcha' => 'Captcha tidak valid atau Anda terdeteksi robot.',
        ]);

        $credentials = $request->only('username', 'password');

        // ==========================================
        // 1. PERSIAPAN DATA LOG (Ditaruh di luar agar bisa dipakai saat Gagal)
        // ==========================================
        $agent = new Agent();
        $ip = $request->ip();
        $location = 'Unknown';

        if ($ip != '127.0.0.1') {
            try {
                $geo = Http::timeout(3)->get("http://ip-api.com/json/{$ip}")->json();
                if ($geo['status'] === 'success') {
                    $location = $geo['city'] . ', ' . $geo['country'];
                }
            } catch (\Exception $e) {
                // Abaikan jika API timeout/error
            }
        }

        $logData = [
            'username'   => $request->username,
            'ip_address' => $ip,
            'location'   => $location,
            'user_agent' => $request->userAgent(),
            'browser'    => $agent->browser() . ' ' . $agent->version($agent->browser()),
            'device'     => $agent->isDesktop() ? 'Laptop/PC' : ($agent->isMobile() ? 'Smartphone' : 'Tablet'),
        ];

        // ==========================================
        // 2. PROSES LOGIN
        // ==========================================
        if (Auth::attempt($credentials)) {
            RateLimiter::clear($throttleKey);
            $user = Auth::user();

            // JIKA AKUN DIBLOKIR / TIDAK AKTIF
            if (!$user->is_active) {
                // [MISSING CODE SEBELUMNYA]: Catat ke DB sebagai FAILED
                $logData['user_id'] = $user->id;
                $logData['status']  = 'FAILED';
                LoginLog::create($logData);

                Auth::logout(); // Keluarkan pengguna

                return redirect()->route('login')->withErrors([
                    'username' => 'Akun Anda telah dinonaktifkan. Alasan: ' . ($user->inactive_reason ?? 'Melanggar ketentuan layanan.')
                ]);
            }

            // JIKA LOGIN SUKSES NORMAL
            // [MISSING CODE SEBELUMNYA]: Catat ke DB sebagai SUCCESS
            $logData['user_id'] = $user->id;
            $logData['status']  = 'SUCCESS';
            LoginLog::create($logData);

            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        // ==========================================
        // 3. JIKA LOGIN GAGAL (Salah Password/Username)
        // ==========================================
        RateLimiter::hit($throttleKey, 300);

        // Cari tahu apakah username-nya benar ada di sistem, agar log-nya punya user_id
        $checkUser = \App\Models\User::where('username', $request->username)->first();

        // [MISSING CODE SEBELUMNYA]: Catat ke DB sebagai FAILED
        $logData['user_id'] = $checkUser ? $checkUser->id : null;
        $logData['status']  = 'FAILED';
        LoginLog::create($logData);

        return back()
            ->withErrors(['username' => 'Identitas atau Password salah!'])
            ->withInput($request->only('username'));
    }

    public function aksi_register(Request $request)
    {
        $request->validate([
            'is_kademangan'    => 'required|boolean',
            'nik'              => 'required|unique:citizen_details,nik|digits:16',
            'no_kk'            => 'required|digits:16',
            'full_name'        => 'required|string|max:150',
            'email'            => 'nullable|email|unique:users,email',
            'notelp'           => 'required|string|max:15',
            'password'         => 'required|min:6|confirmed',

            // Data Detail Kependudukan
            'birth_place'      => 'required|string|max:100',
            'birth_date'       => 'required|date',
            'religion'         => 'required|in:Islam,Kristen,Katolik,Hindu,Budha,Khonghucu',
            'marital_status'   => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'occupation'       => 'required|string',
            'address'          => 'required|string|max:255',
            'rt'               => 'required|string|max:3',
            'rw'               => 'required|string|max:3',
            'family_head_name' => 'nullable|string|max:150',

            // Alamat (Jika Luar Kademangan)
            'province'         => 'required_if:is_kademangan,0',
            'village'          => 'required_if:is_kademangan,0',
            'district'         => 'required_if:is_kademangan,0',
            'city'             => 'required_if:is_kademangan,0',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'username'  => $request->nik,
                'password'  => Hash::make($request->password),
                'role'      => 'citizen',
                'level_id'  => 3,
                'is_active' => true,
                'created_by' => User::setCreator(),
                'notelp'    => $request->notelp,
                'email'     => $request->email,
            ]);

            $detailData = $request->only([
                'nik',
                'full_name',
                'no_kk',
                'birth_place',
                'birth_date',
                'religion',
                'marital_status',
                'occupation',
                'address',
                'rt',
                'rw',
                'family_head_name'
            ]);

            $detailData['user_id'] = $user->id;

            // Otomatisasi Atribut
            $detailData['nationality'] = 'WNI';
            $detailData['ktp_expiry']  = 'Seumur Hidup';

            if ($request->is_kademangan == 1) {
                $detailData['province'] = 'Banten';
                $detailData['city']     = 'Tangerang Selatan';
                $detailData['district'] = 'Setu';
                $detailData['village']  = 'Kademangan';
            } else {
                $detailData['province'] = $request->province;
                $detailData['city']     = $request->city;
                $detailData['district'] = $request->district;
                $detailData['village']  = $request->village;
            }

            CitizenDetail::create($detailData);

            DB::commit();
            Auth::login($user);
            return redirect()->route('home')->with('success', 'Akun warga berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Registrasi Gagal: ' . $e->getMessage());
        }
    }

    protected function redirectByRole()
    {
        $role = Auth::user()->role;
        if ($role === 'staff') {
            return redirect()->intended('admin/dashboard');
        }
        return redirect()->intended('/');
    }

    public function profilWarga()
    {
        $user = User::with('citizenDetail')->findOrFail(Auth::id());
        $title = "Profil Saya";
        return view('warga.profil', compact('user', 'title'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
