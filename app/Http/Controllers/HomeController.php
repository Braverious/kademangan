<?php

namespace App\Http\Controllers;

use App\Models\RunningText;
use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Pengumuman;
use App\Models\Galeri;
use App\Models\Berita;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function index()
    {
        $setting = SiteSetting::where('id', 1)->first();
        $homeContent = [
            'title' => $setting->home_title ?? 'Layanan Publik Kelurahan yang Mudah & Transparan',
            'description' => $setting->home_description ?? 'Akses informasi, ajukan layanan, dan baca berita terbaru seputar kelurahan Anda dalam satu halaman.',
        ];

        $berita_list = Berita::with('user')->orderByDesc('tgl_publish')->take(3)->get();

        $layanan = Layanan::orderByDesc('id')->get();

        $pengumuman = Pengumuman::getActive(5);

        $runningTexts = RunningText::where('is_active', 1)->get()->keyBy('position');

        $settings = SiteSetting::find(1);

        $galeri = Galeri::latest('tgl_upload')->get();

        $youtube_link = $settings->youtube_link ?? '';

        $video_id = '';
        if ($youtube_link) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtube_link, $match);
            $video_id = $match[1] ?? '';
        }

        $video_meta = [
            'title' => 'Video Kelurahan Kademangan',
            'author_name' => 'Kelurahan Kademangan'
        ];

        // Opsional: Jika ingin ambil judul asli dari YouTube (oEmbed)
        if ($video_id) {
            $oembed_url = "https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v={$video_id}&format=json";
            $oembed_data = @file_get_contents($oembed_url);
            if ($oembed_data) {
                $oembed = json_decode($oembed_data, true);
                $video_meta['title'] = $oembed['title'] ?? $video_meta['title'];
                $video_meta['author_name'] = $oembed['author_name'] ?? $video_meta['author_name'];
            }
        }

        $botSettings = \App\Models\ChatbotSetting::pluck('value', 'key');

        return view('home', [
            'title' => 'Home',
            'layanan' => $layanan,
            'pengumuman' => $pengumuman,
            'runningTexts' => $runningTexts,
            'galeri' => $galeri,
            'berita_list' => $berita_list,
            'video_id' => $video_id,
            'video_meta' => $video_meta,
            'botSettings' => $botSettings,
            'homeContent' => $homeContent,
            'setting' => $setting,
        ]);
    }
}
