{{-- resources/views/admin/berita/show.blade.php --}}
@extends('layouts.admin-section.master')

@section('title', 'Lihat Berita')
@section('nav-title', 'Lihat Berita')

@section('content')
<div class="p-6 flex flex-col gap-6">

    {{-- HEADER --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-md shadow-black/5 p-6">
        <h1 class="font-bold text-center text-3xl md:text-5xl mb-4">
            {{ $beritas->judul }}
        </h1>

        <div class="text-center text-sm text-gray-600 font-semibold mb-6">
            <span class="inline-flex items-center gap-2">
                <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-700">
                    {{ $beritas->kategori?->nama_kategori ?? '-' }}
                </span>

                <span>•</span>

                <span>
                    {{ \Carbon\Carbon::parse($beritas->created_at)->format('j F Y, H:i') }} WIB
                </span>

                <span>•</span>

                <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700">
                    {{ strtoupper($beritas->status_publish ?? '-') }}
                </span>

                <span class="px-2 py-0.5 rounded-full bg-yellow-50 text-yellow-700">
                    {{ strtoupper($beritas->status_berita ?? '-') }}
                </span>

                <span class="px-2 py-0.5 rounded-full bg-green-50 text-green-700">
                    Views: {{ (int) ($beritas->views ?? 0) }}
                </span>
            </span>
        </div>

        {{-- THUMBNAIL --}}
        <div class="w-full flex justify-center">
            @if ($beritas->thumbnail)
                <img
                    src="{{ asset('storage/' . $beritas->thumbnail) }}"
                    alt="{{ $beritas->judul }}"
                    class="w-full md:w-2/3 lg:w-1/2 object-cover rounded-lg border border-gray-200 shadow-sm"
                >
            @else
                <img
                    src="{{ asset('images/banner.jpg') }}"
                    alt="{{ $beritas->judul }}"
                    class="w-full md:w-2/3 lg:w-1/2 object-cover rounded-lg border border-gray-200 shadow-sm"
                >
            @endif
        </div>

        {{-- DESKRIPSI --}}
        <div class="mt-8">
            <h2 class="text-lg font-bold mb-2">Deskripsi</h2>
            <p class="font-normal text-justify text-md whitespace-pre-wrap text-gray-800 leading-relaxed">
                {{ $beritas->deskripsi }}
            </p>
        </div>

        {{-- ACTIONS --}}
        <div class="mt-8 flex flex-wrap gap-2 justify-between items-center">
            <a href="{{ route('berita') }}"
               class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                ← Kembali
            </a>

            <div class="flex gap-2">
                <a href="{{ route('edit-berita', $beritas->id) }}"
                   class="inline-flex items-center rounded-lg bg-yellow-300 px-4 py-2 text-sm font-semibold text-black hover:bg-yellow-400">
                    Edit Berita
                </a>

                {{-- OPTIONAL: hapus (kalau memang ada route destroy) --}}
                @if (Route::has('hapus-berita'))
                    <form action="{{ route('hapus-berita', $beritas->id) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus berita ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                            Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- KOMENTAR --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-md shadow-black/5 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold">
                Komentar
                <span class="text-sm font-semibold text-gray-500">
                    ({{ $beritas->comments?->count() ?? 0 }})
                </span>
            </h2>

            {{-- OPTIONAL: tombol menuju halaman publik --}}
            @if (Route::has('satu-berita'))
                <a href="{{ route('satu-berita', $beritas->slug) }}" target="_blank"
                   class="text-sm font-semibold text-blue-700 hover:underline">
                    Lihat di portal →
                </a>
            @endif
        </div>

        @php
            $comments = $beritas->comments ?? collect();
        @endphp

        @if ($comments->count() === 0)
            <div class="text-sm text-gray-500">
                Belum ada komentar pada berita ini.
            </div>
        @else
            <div class="space-y-4">
                @foreach ($comments as $c)
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-2">
                            <div>
                                <div class="font-semibold text-gray-900">
                                    {{ $c->guest_name ?? ($c->user?->name ?? 'Anonim') }}
                                </div>
                                <div class="text-xs text-gray-600">
                                    {{ $c->guest_email ?? ($c->user?->email ?? '-') }}
                                </div>
                            </div>

                            <div class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($c->created_at)->format('d-m-Y H:i') }} WIB
                            </div>
                        </div>

                        <div class="mt-3 text-sm text-gray-800 whitespace-pre-line">
                            {{ $c->content }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
