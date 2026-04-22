<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SettingsController extends Controller
{
    // Mengubah footer() menjadi settings()
    public function settings()
    {
        $settings = SiteSetting::firstOrNew(['id' => 1]);

        return view('admin.settings', [
            'title' => 'Web Settings',
            'footer' => [
                'about_html' => $settings->about_html,
                'related_links' => $settings->related_links ?? [],
                'social_links' => $settings->social_links ?? [],
                'favicon'       => $settings->favicon,
                'youtube_link'  => $settings->youtube_link,
            ]
        ]);
    }

    // Mengubah footerSave() menjadi settingsSave()
    public function settingsSave(Request $request)
    {
        $request->validate([
            'favicon' => 'nullable|image|mimes:ico,png,jpg,jpeg|max:2048',
            'youtube_link' => 'nullable|url',
        ]);
        $settings = SiteSetting::find(1);

        $faviconPath = $settings->favicon ?? null;

        if ($request->hasFile('favicon')) {
            // Hapus favicon lama jika ada
            if ($faviconPath) {
                Storage::disk('public')->delete($faviconPath);
            }

            // Simpan file baru ke folder public/uploads/settings
            $file = $request->file('favicon');
            $faviconPath = $file->store('uploads/settings', 'public');
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
                'youtube_link'  => $request->input('youtube_link'),
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
