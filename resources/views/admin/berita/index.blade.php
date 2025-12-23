@extends('layouts.admin-section.master')
@section('title', 'Daftar Berita')
@section('nav-title', 'Daftar Berita')

@section('content')
    <div class="p-6">
        <div class="relative overflow-x-auto sm:rounded-lg">

            <div
                class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">

                {{-- LEFT: Tambah + Reset --}}
                <div class="flex items-center gap-2">
                    <a href="{{ route('tambah-berita') }}"
                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                        type="button">
                        Tambah Berita
                    </a>

                    {{-- Reset filter + search --}}
                    <a href="{{ route('berita') }}"
                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Reset
                    </a>
                </div>

                {{-- RIGHT: Filter Kategori + Search --}}
                <div class="flex items-center gap-3 flex-wrap">

                    {{-- FILTER KATEGORI --}}
                    <form action="{{ route('berita') }}" method="GET">
                        {{-- pertahankan search --}}
                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <select name="kategori" onchange="this.form.submit()"
                            class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Semua Kategori</option>

                            {{-- pastikan controller kirim $kategoris --}}
                            @isset($kategoris)
                                @foreach ($kategoris as $k)
                                    <option value="{{ $k->id }}"
                                        {{ (string) request('kategori') === (string) $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </form>

                    {{-- SEARCH --}}
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>

                        <form action="{{ route('berita') }}" method="GET">
                            @csrf
                            {{-- pertahankan kategori --}}
                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">

                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Cari berita...">
                        </form>
                    </div>
                </div>
            </div>

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">No</th>
                        <th scope="col" class="p-4">Tanggal</th>
                        <th scope="col" class="p-4">Thumbnail</th>
                        <th scope="col" class="px-6 py-3">Judul Berita</th>
                        <th scope="col" class="px-6 py-3">Kategori</th>
                        <th scope="col" class="px-6 py-3">Dilihat</th>
                        <th scope="col" class="px-6 py-3">Status Berita</th>
                        <th scope="col" class="px-6 py-3">Status Publish</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($beritas as $index => $item)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                {{ $beritas->firstItem() + $index }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->created_at }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($item->thumbnail)
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->slug }}"
                                        class="w-10">
                                @else
                                    <img src="/images/banner.jpg" alt="{{ $item->slug }}" class="w-10">
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->judul }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->kategori->nama_kategori ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->views }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->status_berita }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->status_publish }}
                            </td>

                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('lihat-berita', $item->id) }}"
                                    class="rounded bg-blue-300 p-2 text-black hover:bg-blue-400 hover:text-slate-100">
                                    lihat
                                </a>
                                <a href="{{ route('edit-berita', $item->id) }}"
                                    class="rounded bg-yellow-300 p-2 text-black hover:bg-yellow-400 hover:text-slate-100">
                                    edit
                                </a>
                                <a href="{{ route('hapus-berita', $item->id) }}"
                                    onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                    class="rounded bg-red-500 p-2 text-white hover:bg-red-400 hover:text-slate-100">
                                    hapus
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination: pertahankan query filter/search --}}
        <div class="mt-4">
            {{ $beritas->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
