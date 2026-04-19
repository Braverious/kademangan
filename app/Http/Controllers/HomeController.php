<?php

namespace App\Http\Controllers;

use App\Models\RunningText;
use Illuminate\Http\Request;
use App\Models\Layanan;

class HomeController extends Controller
{
    public function index()
    {
        $layanan = Layanan::where('aktif', 1)
            ->orderBy('urut')
            ->orderByDesc('id')
            ->get();

        return view('home', [
            'title' => 'Home',
            'layanan' => $layanan,
            // 'runningTexts' => $this->getRunningText()
        ]);
    }
}
