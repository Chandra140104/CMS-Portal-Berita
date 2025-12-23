<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PortalBeritaController extends Controller
{
    public function index()
    {
        $nav = Kategori::query()
            ->limit(4)
            ->get();

        $nav2 = Kategori::query()
            ->orderBy('nama_kategori', 'asc')
            ->get();

        $carousel = Berita::query()
            ->with('kategori')
            ->where('status_berita', 'headline')
            ->where('status_publish', 'publish')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $trending = Berita::query()
            ->with('kategori')
            ->orderBy('views', 'desc')
            ->where('status_publish', 'publish')
            ->limit(5)
            ->get();

        $headline = Berita::query()
            ->with('kategori')
            ->where('status_berita', 'headline')
            ->where('status_publish', 'publish')
            ->orderBy('created_at', 'desc')
            ->offset(3)
            ->limit(6)
            ->get();

        $hariIni = Berita::query()
            ->with('kategori')
            ->where('status_publish', 'publish')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', compact('nav', 'nav2', 'carousel', 'trending', 'headline', 'hariIni'));
    }

    public function showAll(Request $request)
    {
        $nav = Kategori::query()
            ->limit(4)
            ->get();

        $nav2 = Kategori::query()
            ->orderBy('nama_kategori', 'asc')
            ->get();

        if ($request->has('search')) {
            $beritas = Berita::query()
                ->with('kategori')
                ->orderBy('created_at', 'desc')
                ->where('judul', 'LIKE', '%' . $request->search . '%')
                ->orWhere('slug', 'LIKE', '%' . $request->search . '%')
                ->where('status_publish', 'publish')
                ->paginate(20)
                ->onEachSide(2);
        } else {
            $beritas = Berita::query()
                ->with('kategori')
                ->orderBy('created_at', 'desc')
                ->where('status_publish', 'publish')
                ->paginate(20)
                ->onEachSide(2);
        }

        return view('all-news', compact('nav', 'nav2', 'beritas'));
    }

    public function show($slug)
    {
        $nav = Kategori::query()
            ->limit(4)
            ->get();

        $nav2 = Kategori::query()
            ->orderBy('nama_kategori', 'asc')
            ->get();

        // ✅ ambil berita + kategori, kalau tidak ada -> 404 (lebih aman)
        $beritas = Berita::query()
            ->with('kategori')
            ->where('slug', $slug)
            ->firstOrFail();

        // view + 1
        $beritas->increment('views');

        // ✅ rekomendasi berita headline (beberapa saja) + exclude berita ini
        $rekomendasiHeadline = Berita::query()
            ->with('kategori')
            ->where('status_publish', 'publish')
            ->where('status_berita', 'headline')
            ->where('id', '!=', $beritas->id)
            ->orderBy('created_at', 'desc')
            ->limit(4) // atur jumlah rekomendasi
            ->get();

        return view('news', compact('nav', 'nav2', 'beritas', 'rekomendasiHeadline'));
    }

    public function newsPerCategory($id)
    {
        $nav = Kategori::query()
            ->limit(4)
            ->get();

        $nav2 = Kategori::query()
            ->orderBy('nama_kategori', 'asc')
            ->get();

        $beritas = Berita::query()
            ->with('kategori')
            ->where('kategori_id', $id)
            ->where('status_publish', 'publish')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->onEachSide(2);

        $kategori = Berita::query()
            ->where('kategori_id', $id)
            ->first();

        return view('news-per-category', compact('nav', 'nav2', 'beritas', 'kategori'));
    }
}
