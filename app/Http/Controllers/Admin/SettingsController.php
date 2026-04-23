<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SettingsController extends Controller
{
    public function settings()
    {
        $siteData = SiteSetting::firstOrNew(['id' => 1]);

        $title = 'Konfigurasi Aplikasi';

        $breadcrumbs = [
            ['label' => 'Pengaturan', 'url' => null],
            ['label' => $title, 'url' => route('admin.settings.index')],
        ];

        $settings = [
            'about_html'    => $siteData->about_html,
            'related_links' => $siteData->related_links ?? [],
            'social_links'  => $siteData->social_links ?? [],
            'favicon'       => $siteData->favicon,
            'youtube_link'  => $siteData->youtube_link,
        ];

        return view('admin.settings', compact('title', 'breadcrumbs', 'settings'));
    }

    // Mengubah footerSave() menjadi settingsSave()
    public function settingsSave(Request $request)
    {
        $request->validate([
            'favicon' => 'nullable|image|mimes:ico,png,jpg,jpeg|max:2048',
            'youtube_link' => 'nullable|url',
        ]);

        // Gunakan firstOrNew agar tidak error jika ID 1 belum ada
        $settings = SiteSetting::firstOrNew(['id' => 1]);
        $faviconPath = $settings->favicon;

        if ($request->hasFile('favicon')) {
            // Hapus file lama jika ada
            if ($faviconPath && Storage::disk('public')->exists($faviconPath)) {
                Storage::disk('public')->delete($faviconPath);
            }
            // Simpan file baruke public/uploads/settings dan simpan path-nya ke database
            $faviconPath = $request->file('favicon')->store('uploads/settings', 'public');
        }

        $allowed_tags = '<p><b><strong><i><em><u><br><ul><ol><li><a><small><span><h1><h2><h3><h4><h5><h6>';
        $about_html_raw = $request->input('about_html', '');
        $about_html = trim(strip_tags($about_html_raw, $allowed_tags));

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

        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'about_html'    => trim(strip_tags($request->about_html, '<p><b><strong><i><em><u><br><ul><ol><li><a><small><span><h1><h2><h3><h4><h5><h6>')),
                'related_links' => $related_links,
                'social_links'  => $social_links,
                'favicon'       => $faviconPath,
                'youtube_link'  => $request->youtube_link,
            ]
        );

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
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
