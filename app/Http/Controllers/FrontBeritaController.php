<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class FrontBeritaController extends Controller
{
    public function index()
    {
        $berita_list = Berita::with('user')
            ->orderByDesc('tgl_publish')
            ->paginate(6);

        return view('berita.index', [
            'title' => 'Berita Kelurahan',
            'berita_list' => $berita_list,
        ]);
    }

    public function detail(string $slug)
    {
        $berita = Berita::with('user')
            ->where('slug_berita', $slug)
            ->firstOrFail();

        $related = Berita::with('user')
            ->where('kategori', $berita->kategori)
            ->where('id_berita', '!=', $berita->id_berita)
            ->orderByDesc('tgl_publish')
            ->take(5)
            ->get();

        $latest = Berita::with('user')
            ->where('id_berita', '!=', $berita->id_berita)
            ->orderByDesc('tgl_publish')
            ->take(5)
            ->get();

        return view('berita.detail', [
            'title' => $berita->judul_berita,
            'berita' => $berita,
            'related' => $related,
            'latest' => $latest,
        ]);
    }
}