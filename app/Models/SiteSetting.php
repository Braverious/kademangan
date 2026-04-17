<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    // Karena nama tabel Anda bukan bentuk jamak bahasa Inggris standar
    protected $table = 'site_settings';

    protected $fillable = [
        'about_html', 
        'related_links', 
        'social_links'
    ];

    // Ini akan otomatis mengubah array menjadi JSON di database, dan sebaliknya
    protected $casts = [
        'related_links' => 'array',
        'social_links' => 'array',
    ];
}