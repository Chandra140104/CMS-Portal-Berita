<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\BeritaComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeritaCommentController extends Controller
{
    /**
     * Simpan komentar (guest boleh, tanpa reply/parent_id).
     * Route: POST /berita/{slug}/komentar
     */
    public function store(Request $request, $slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();

        // Validasi umum
        $validated = $request->validate([
            'content' => ['required', 'string', 'min:2'],
            'guest_name' => ['nullable', 'string', 'max:120'],
            'guest_email' => ['nullable', 'email', 'max:190'],
        ]);

        // Jika guest (tidak login) → wajib isi nama
        if (!Auth::check()) {
            $request->validate([
                'guest_name' => ['required', 'string', 'max:120'],
                'guest_email' => ['nullable', 'email', 'max:190'],
            ]);
        }

        BeritaComment::create([
            'berita_id' => $berita->id,
            'user_id' => Auth::id(),
            'guest_name' => Auth::check() ? null : $validated['guest_name'],
            'guest_email' => Auth::check() ? null : ($validated['guest_email'] ?? null),
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Komentar berhasil dikirim.');
    }
}
