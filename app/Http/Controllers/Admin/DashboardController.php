<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // View yang dipanggil akan menggunakan data statis untuk sementara
        return view('admin.dashboard', [
            'title' => 'Dashboard Kelurahan Kademangan'
        ]);
    }
}
