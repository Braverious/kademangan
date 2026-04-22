<?php

namespace App\Http\Controllers;

use App\Models\RunningText;
use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Pengumuman;

class HomeController extends Controller
{
    public function index()
    {
        $layanan = Layanan::orderByDesc('id')->get();

        $pengumuman = Pengumuman::getActive(5);

        $runningTexts = RunningText::where('is_active', 1)->get()->keyBy('position');

        return view('home', [
            'title' => 'Home',
            'layanan' => $layanan,
            'pengumuman' => $pengumuman,
            'runningTexts' => $runningTexts,
        ]);
    }
}
