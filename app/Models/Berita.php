<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Berita extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // ===============================
    // RELASI KOMENTAR (FLAT - TANPA parent_id)
    // ===============================
    public function comments()
    {
        return $this->hasMany(\App\Models\BeritaComment::class, 'berita_id')
            ->latest();
    }

    // ===============================
    // SLUGGABLE
    // ===============================
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'judul'
            ]
        ];
    }
}
