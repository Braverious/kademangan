<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SettingsController extends Controller
{
    public function footer()
    {
        // Ambil data ID 1. Jika belum ada di database, buat instance baru yang kosong
        $settings = SiteSetting::firstOrNew(['id' => 1]);

        return view('admin.settings', [
            'title' => 'Web Settings',
            'footer' => [
                'about_html' => $settings->about_html,
                'related_links' => $settings->related_links ?? [],
                'social_links' => $settings->social_links ?? [],
            ]
        ]);
    }

    public function footerSave(Request $request)
    {
        // Bersihkan tag HTML
        $allowed_tags = '<p><b><strong><i><em><u><br><ul><ol><li><a><small><span><h1><h2><h3><h4><h5><h6>';
        $about_html_raw = $request->input('about_html', '');
        $about_html = trim(strip_tags($about_html_raw, $allowed_tags));

        // Proses Tautan Terkait
        $related_links = [];
        $links_title = $request->input('links_title', []);
        $links_url   = $request->input('links_url', []);
        
        foreach ($links_title as $i => $title) {
            $title = trim($title);
            $url   = trim($links_url[$i] ?? '');
            if ($title === '' && $url === '') continue;
            
            $related_links[] = [
                'title' => $title,
                'url'   => $this->normalizeUrl($url),
            ];
        }

        // Proses Sosial Media
        $social_links = [];
        $social_icon  = $request->input('social_icon', []);
        $social_label = $request->input('social_label', []);
        $social_url   = $request->input('social_url', []);
        
        foreach ($social_icon as $i => $icon) {
            $icon  = trim($icon);
            $label = trim($social_label[$i] ?? '');
            $url   = trim($social_url[$i] ?? '');
            if ($icon === '' && $url === '' && $label === '') continue;
            
            $social_links[] = [
                'icon'  => $icon,
                'label' => $label,
                'url'   => $this->normalizeUrl($url),
            ];
        }

        // Simpan ke database (otomatis update jika ID 1 sudah ada)
        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'about_html'    => $about_html ?: null,
                'related_links' => $related_links,
                'social_links'  => $social_links,
            ]
        );

        return redirect()->route('admin.settings.footer')->with('success', 'Footer berhasil disimpan.');
    }

    private function normalizeUrl($url)
    {
        if ($url === '') return '';
        if (!preg_match('~^https?://~i', $url)) {
            $url = 'https://' . ltrim($url, '/');
        }
        return $url;
    }
}