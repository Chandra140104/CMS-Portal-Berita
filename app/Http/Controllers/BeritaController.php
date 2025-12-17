<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // Tambahkan ini

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $beritas = Berita::query()
                ->with('kategori')
                ->orderBy('created_at', 'desc')
                ->where('judul', 'LIKE', '%' . $request->search . '%')
                ->orWhere('slug', 'LIKE', '%' . $request->search . '%')
                ->paginate(10)
                ->onEachSide(2);
        } else {
            $beritas = Berita::query()
                ->with('kategori')
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->onEachSide(2);
        }
        Session::put('halaman_url', request()->fullUrl());
        return view('admin.berita.index', compact('beritas'));
    }

    public function show($id)
    {
        $beritas = Berita::findOrFail($id);
        return view('admin.berita.show', compact('beritas'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.berita.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => ['required', 'min:3'],
            'slug' => ['required', 'min:3'],
            'deskripsi' => ['required', 'min:3'],
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png', 'file', 'max:2048'],
            'kategori' => ['required'],
            'status_berita' => ['required'],
            'status_publish' => ['required'],
        ]);
    
        // Mengambil ekstensi asli dari thumbnail
        $extension = $request->file('thumbnail')->getClientOriginalExtension();
        $thumbnailName = str_replace(" ", "-", $request->slug . "_gambar-berita." . $extension);
    
        // Simpan berita baru
        Berita::create([
            'judul' => $request->judul,
            'slug' => $request->slug,
            'deskripsi' => $request->deskripsi,
            'thumbnail' => $request->file('thumbnail')->storeAs('news-images', $thumbnailName, 'public'),
            'kategori_id' => $request->kategori,
            'status_berita' => $request->status_berita,
            'status_publish' => $request->status_publish,
            'views' => 0,
        ]);
    
        return redirect()->route('berita');
    }
    

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Berita::class, 'slug', $request->judul);
        return response()->json(['slug' => $slug]);
    }

    public function edit($id)
    {
        $kategoris = Kategori::all();
        $beritas = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('kategoris', 'beritas'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => ['required', 'min:3'],
            'slug' => ['required', 'min:3'],
            'deskripsi' => ['required', 'min:3'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'file', 'max:2048'],
            'kategori' => ['required'],
            'status_berita' => ['required'],
            'status_publish' => ['required'],
        ]);

        $berita = Berita::findOrFail($id);
        $berita->judul = $request->judul;
        $berita->slug = $request->slug;
        $berita->deskripsi = $request->deskripsi;
        $berita->kategori_id = $request->kategori;
        $berita->status_berita = $request->status_berita;
        $berita->status_publish = $request->status_publish;

        if ($request->hasFile('thumbnail')) {
            $thumbnailName = str_replace(" ", "-", $request->slug . "_" . "gambar-berita." . $request->file('thumbnail')->getClientOriginalExtension());
            $berita->thumbnail = $request->file('thumbnail')->storeAs('news-images', $thumbnailName, 'public');
        }

        $berita->save();

        return redirect()->route('berita');
    }

    public function destroy($id)
    {
        $beritas = Berita::findOrFail($id);

        if ($beritas->thumbnail) {
            // Dapatkan path lengkap menggunakan storage_path
            $thumbnailPath = storage_path('app/public/' . $beritas->thumbnail);
            
            // Cek apakah file ada sebelum menghapus
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            } else {
                // Log error jika file tidak ditemukan
                Log::error("File not found for deletion: " . $thumbnailPath);
            }
        }

        $beritas->delete();

        return redirect()->back();
    }
}
