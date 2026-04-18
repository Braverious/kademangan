<?php

namespace App\Http\Controllers;

use App\Models\RunningText;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $runningTexts = RunningText::where('is_active', 1)->get()->keyBy('position');
        return view('home', [
            'title' => 'Kelurahan Kademangan',
            'runningTexts' => $runningTexts
        ]);
    }
}
