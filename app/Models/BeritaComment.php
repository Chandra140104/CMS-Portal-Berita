<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaComment extends Model
{
    use HasFactory;

    protected $table = 'berita_comments';

    protected $fillable = [
        'berita_id',
        'user_id',
        'guest_name',
        'guest_email',
        'content',
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class, 'berita_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
