<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'isi',
        'tipe',
        'mulai_tayang',
        'berakhir_tayang',
        'status',
        'created_by',
    ];

    public $timestamps = true;

    /* ===== AUTO DEFAULT ===== */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->judul = trim($model->judul ?? '');
            $model->isi = trim($model->isi ?? '');
            $model->tipe = $model->tipe ?? 'info';
            $model->status = $model->status ?? 'publish';

            if (empty($model->mulai_tayang)) {
                $model->mulai_tayang = now();
            }

            if (empty($model->berakhir_tayang)) {
                $model->berakhir_tayang = Carbon::parse($model->mulai_tayang)->addHours(24);
            }
        });
    }

    /* ===== ACTIVE DATA ===== */
    public static function getActive($limit = 5)
    {
        $now = now();

        return self::where('status', 'publish')
            ->where('mulai_tayang', '<=', $now)
            ->where(function ($q) use ($now) {
                $q->whereNull('berakhir_tayang')
                  ->orWhere('berakhir_tayang', '>', $now);
            })
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }
}