<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Info BNN Kota kediri</title>

    <!-- Favicon --->
    <link rel="icon" href="{{ url('/images/favicon2.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />

    <style>
        * { font-family: 'Poppins', sans-serif; }

        /* ===============================
           HALAMAN DETAIL BERITA - GRID ABU
           =============================== */
        .page-grid {
            background-color: #ffffff;
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        /* Card komentar biar lebih lembut */
        .comment-card {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 14px;
        }

        /* Clamp (fallback) - kalau tailwind line-clamp belum terpasang */
        .clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    </style>

    @vite('resources/css/app.css')
</head>

<body class="page-grid">

    <!-- NAV BAR -->
    <div class="sticky top-0 z-50">
        <nav class="bg-white border-gray-200 dark:bg-gray-900">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
                <a href="{{ route('welcome') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="/images/logo2.png" class="h-8" alt="Portal Berita Logo">
                    <span style="color:darkblue"
                          class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">
                        INFO BNN KOTA KEDIRI
                    </span>
                </a>

                <div class="flex items-center space-x-6 rtl:space-x-reverse">
                    <a href="{{ route('semua-berita') }}" type="button"
                       class="text-black hover:text-gray-700 border border-black hover:border-gray-700 hover:bg-slate-100 focus:ring-4 focus:outline-none focus:ring-black font-medium rounded-lg text-sm px-5 py-1 text-center me-2 mt-1">
                        Cari Berita
                    </a>

                    @auth
                        <form action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" onclick="return confirm('Apakah anda yakin ingin keluar?')"
                                    class="text-sm text-blue-600 dark:text-blue-500 hover:underline">
                                Logout
                            </button>
                        </form>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}"
                           class="text-sm text-blue-600 dark:text-blue-500 hover:underline">
                            Login
                        </a>
                    @endguest
                </div>
            </div>
        </nav>

        <nav class="bg-gray-50 dark:bg-gray-700">
            <div class="max-w-screen-xl px-4 py-3 mx-auto">
                <div class="flex items-center">
                    <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                        <li>
                            <a href="{{ route('welcome') }}"
                               class="text-gray-900 dark:text-white hover:underline"
                               aria-current="page">
                                Beranda
                            </a>
                        </li>

                        @foreach ($nav as $item)
                            <li>
                                <a href="{{ route('berita-per-kategori', $item->id) }}"
                                   class="text-gray-900 dark:text-white hover:underline">
                                    {{ $item->nama_kategori }}
                                </a>
                            </li>
                        @endforeach

                        <li>
                            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                                    class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                                Kategori Selengkapnya
                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div id="dropdownNavbar"
                                 class="z-50 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-400"
                                    aria-labelledby="dropdownLargeButton">
                                    @foreach ($nav2 as $item)
                                        <li>
                                            <a href="{{ route('berita-per-kategori', $item->id) }}"
                                               class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                {{ $item->nama_kategori }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- END OF NAV BAR -->

    <div class="container w-5/6 flex flex-warp mx-auto py-5 gap-4">
        <div class="mx-auto p-6 flex flex-col gap-2 w-full">
            <div class="mx-auto w-full p-6">

                <h1 class="font-bold text-center text-3xl md:text-5xl mb-5">
                    {{ $beritas->judul }}
                </h1>

                <h3 class="font-semibold text-center text-sm mb-5">
                    <a href="{{ route('berita-per-kategori', $beritas->kategori_id) }}"
                       class="text-blue-500 hover:text-blue-600">
                        {{ $beritas->kategori->nama_kategori }}
                    </a>
                    -
                    {{ date('j F Y, H:i', strtotime($beritas->created_at)) }} WIB
                </h3>

                @if ($beritas->thumbnail)
                    <img src="{{ asset('storage/' . $beritas->thumbnail) }}"
                         alt="{{ $beritas->judul }}"
                         class="mx-auto object-cover w-full md:w-2/4 rounded-lg shadow">
                @else
                    <img src="/images/banner.jpg"
                         alt="{{ $beritas->judul }}"
                         class="mx-auto object-cover w-full md:w-2/4 rounded-lg shadow">
                @endif

                <p class="font-normal text-justify text-md mt-10 whitespace-pre-wrap">
                    {{ $beritas->deskripsi }}
                </p>

                <!-- ===============================
                     KOMENTAR (FORM SAJA)
                     =============================== -->
                <div class="mt-14">
                    <h2 class="text-2xl font-bold mb-4">Komentar</h2>

                    @if (session('success'))
                        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800 border border-green-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-800 border border-red-200">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- FORM KOMENTAR (Nama + Email WAJIB) -->
                    <form action="{{ route('berita.komentar.store', $beritas->slug) }}"
                          method="POST"
                          class="comment-card p-5 shadow-sm">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-semibold mb-1">Nama</label>
                                <input type="text" name="guest_name" value="{{ old('guest_name') }}" required
                                       class="w-full p-2.5 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Nama Anda">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Email</label>
                                <input type="email" name="guest_email" value="{{ old('guest_email') }}" required
                                       class="w-full p-2.5 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="nama@email.com">
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="block text-sm font-semibold mb-1">Komentar</label>
                            <textarea name="content" rows="4" required
                                      class="w-full p-2.5 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Tulis komentar...">{{ old('content') }}</textarea>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <p class="text-xs text-gray-500">
                                Dengan mengirim komentar, Anda menyetujui untuk tidak menulis konten yang melanggar norma.
                            </p>
                            <button type="submit"
                                    class="px-5 py-2.5 rounded-lg bg-blue-700 text-white font-semibold hover:bg-blue-800 transition">
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
                <!-- END KOMENTAR -->

                {{-- ===============================
                   REKOMENDASI HEADLINE (GRID 4)
                   =============================== --}}
                @if(isset($rekomendasiHeadline) && $rekomendasiHeadline->count())
                    <div class="mt-14">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-2xl font-bold">Rekomendasi Berita Headline</h2>
                            <a href="{{ route('semua-berita') }}"
                               class="text-sm font-semibold text-blue-600 hover:underline">
                                Lihat lainnya
                            </a>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($rekomendasiHeadline as $item)
                                <a href="{{ route('satu-berita', $item->slug) }}"
                                   class="group block rounded-xl border border-gray-200 bg-white overflow-hidden hover:shadow-md transition">

                                    {{-- Thumbnail kecil --}}
                                    <div class="aspect-[16/9] bg-gray-100 overflow-hidden">
                                        @if($item->thumbnail)
                                            <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                                 alt="{{ $item->judul }}"
                                                 class="w-full h-full object-cover group-hover:scale-[1.03] transition duration-300">
                                        @else
                                            <img src="{{ asset('images/banner.jpg') }}"
                                                 alt="{{ $item->judul }}"
                                                 class="w-full h-full object-cover group-hover:scale-[1.03] transition duration-300">
                                        @endif
                                    </div>

                                    <div class="p-3">
                                        <div class="text-[11px] text-gray-500 mb-1">
                                            {{ optional($item->kategori)->nama_kategori ?? '-' }}
                                            • {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                        </div>

                                        {{-- Clamp 2 baris (pakai tailwind line-clamp jika ada, fallback clamp-2 jika tidak) --}}
                                        <div class="font-semibold text-gray-900 leading-snug line-clamp-2 clamp-2">
                                            {{ $item->judul }}
                                        </div>

                                        <div class="mt-2 text-xs font-semibold text-blue-600 group-hover:underline">
                                            Baca →
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="block text-sm text-gray-500 sm:text-center dark:text-gray-400 mb-10 mt-20">
        <span>© 2025 - Info BNN Kota Kediri</span>
    </div>
    <!-- END OF FOOTER -->

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
</body>

</html>
