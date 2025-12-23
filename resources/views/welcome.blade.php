<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Info BNN Kota Kediri</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ url('/images/favicon2.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* ===============================
           BACKGROUND DARK BLUE GRID
           =============================== */
        .bg-tech {
            background-color: #0a1f44;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                radial-gradient(circle at top, rgba(59, 130, 246, 0.25), transparent 60%);
            background-size: 40px 40px, 40px 40px, 100% 100%;
            background-attachment: fixed;
        }

        /* Animasi masuk halaman */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-fadeInUp { animation: fadeInUp 0.9s ease-out forwards; }
        .animate-fadeIn { animation: fadeIn 1.2s ease-out forwards; }

        /* Underline animasi menu */
        .menu-link {
            position: relative;
            display: inline-block;
        }
        .menu-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: -4px;
            left: 0;
            background: #3b82f6;
            transition: width 0.4s ease;
        }
        .menu-link:hover::after { width: 100%; }

        /* Hover kartu berita */
        .news-card {
            transition: all 0.4s ease;
        }
        .news-card:hover {
            transform: translateY(-12px) scale(1.04);
            box-shadow: 0 20px 30px rgba(0,0,0,0.15);
        }

        /* Tombol pulse */
        .pulse-button {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.06); }
        }
        /* ===============================
   CARD PUTIH DENGAN GARIS GRID
   =============================== */
.card-grid {
    background-color: #ffffff;
    background-image:
        linear-gradient(rgba(0, 0, 0, 0.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0, 0, 0, 0.06) 1px, transparent 1px);
    background-size: 28px 28px;
}
/* ===============================
   FOOTER GRID ABU-ABU
   =============================== */
.footer-grid {
    background-color: rgba(255, 255, 255, 0.95);
    background-image:
        linear-gradient(rgba(0, 0, 0, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
    background-size: 32px 32px;
}
/* ===============================
   FOOTER DOT PATTERN
   =============================== */



    </style>

    @vite('resources/css/app.css')
</head>

<section class="bg-tech">
<body>
<!-- HERO BANNER -->
<div class="w-full">
    <div class="relative w-full h-[260px] md:h-[420px] overflow-hidden">
        <!-- Gambar Banner -->
        <img
            src="/images/banner-hero.jpg"
            alt="Banner BNN Kota Kediri"
            class="absolute inset-0 w-full h-full object-cover"
        />

        <!-- Overlay biar teks kebaca -->
        <div class="absolute inset-0 bg-black/25"></div>

        <!-- Konten banner (opsional) -->
        <div class="absolute inset-0 flex items-end">
            <div class="w-full max-w-screen-xl mx-auto px-6 md:px-10 pb-6 md:pb-10">
                <div class="inline-block bg-white/90 backdrop-blur px-4 py-2 md:px-6 md:py-3 rounded-lg shadow">
                    <div class="text-xs md:text-sm font-semibold text-gray-700">
                        Badan Narkotika Nasional Kota Kediri
                    </div>
                    <div class="text-lg md:text-2xl font-extrabold text-gray-900 leading-snug">
                        Bersama Wujudkan Indonesia Bersinar, Bersih Narkoba
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END HERO BANNER -->

    <!-- NAV BAR -->
    <div class="sticky top-0 z-50 shadow-md transition-shadow duration-300">
        <nav class="bg-white border-gray-200 dark:bg-gray-900">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
                <a href="{{ route('welcome') }}" class="flex items-center space-x-3 rtl:space-x-reverse transition-transform duration-300 hover:scale-105">
                    <img src="/images/logo2.png" class="h-8" alt="Portal Berita Logo">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white" style="color:darkblue;">INFO BNN KOTA KEDIRI</span>
                </a>
                <div class="flex items-center space-x-6 rtl:space-x-reverse">
                    <a href="{{ route('semua-berita') }}" type="button"
                        class="pulse-button text-black hover:text-gray-700 border border-black hover:border-gray-700 hover:bg-slate-100 focus:ring-4 focus:outline-none focus:ring-black font-medium rounded-lg text-sm px-5 py-1 text-center me-2 mt-1 transition-all duration-300 hover:scale-110 hover:shadow-lg">
                        Cari Berita
                    </a>
                    <!-- BUTTON LAPOR PENYALAHGUNAAN -->
                    <a href="{{ route('laporan-kasus.create') }}"
                    class="pulse-button bg-red-600 text-white
                            hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300
                            font-semibold rounded-lg text-sm px-5 py-1 text-center
                            transition-all duration-300 hover:scale-110 hover:shadow-lg">
                        🚨 Lapor Penyalahgunaan
                    </a>
                    @auth
                        <form action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" onclick="return confirm('Apakah anda yakin ingin keluar?')"
                                class="text-sm text-blue-600 dark:text-blue-500 hover:underline transition-colors duration-300 hover:text-blue-800">Logout</button>
                        </form>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}"
                            class="text-sm text-blue-600 dark:text-blue-500 hover:underline transition-colors duration-300 hover:text-blue-800">Login</a>
                    @endguest
                </div>
            </div>
        </nav>
        <nav class="bg-gray-50 dark:bg-gray-700">
            <div class="max-w-screen-xl px-4 py-3 mx-auto">
                <div class="flex items-center">
                    <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                        <li>
                            <a href="{{ route('welcome') }}" class="menu-link text-gray-900 dark:text-white transition-colors duration-300" aria-current="page">Beranda</a>
                        </li>
                        @foreach ($nav as $item)
                            <li>
                                <a href="{{ route('berita-per-kategori', $item->id) }}"
                                    class="menu-link text-gray-900 dark:text-white transition-colors duration-300">{{ $item->nama_kategori }}</a>
                            </li>
                        @endforeach
                        <li>
                            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                                class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 transition-all duration-300">
                                Kategori Selengkapnya
                                <svg class="w-2.5 h-2.5 ms-2.5 transition-transform duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="dropdownNavbar" class="z-50 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 transition-all duration-300">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                                    @foreach ($nav2 as $item)
                                        <li>
                                            <a href="{{ route('berita-per-kategori', $item->id) }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white transition-colors duration-200">{{ $item->nama_kategori }}</a>
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

    <!-- MAIN SECTION 1 -->
    <div class="container w-5/6 flex mx-auto py-5 gap-4 animate-fadeIn">
        <!-- CAROUSEL -->
        <div id="controls-carousel" class="relative w-full" data-carousel="slide">
            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                @foreach ($carousel as $item)
                    <div class="hidden duration-1000 ease-in-out transition-opacity" data-carousel-item>
                        @if ($item->thumbnail)
                            <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="{{ $item->judul }}">
                        @else
                            <img src="/images/banner.jpg"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="{{ $item->judul }}">
                        @endif
                        <div class="absolute w-full h-24 py-2.5 bottom-0 inset-x-0 bg-gray-800/[.6] text-white hover:text-slate-200 text-lg text-center leading-5 transition-all duration-500 hover:bg-gray-800/[.8]">
                            <a href="{{ route('satu-berita', $item->slug) }}">{{ $item->judul }}</a>
                            <div class="block text-xs mt-3">
                                <a href="{{ route('berita-per-kategori', $item->kategori_id) }}"
                                    class="text-white hover:text-blue-400">{{ $item->kategori->nama_kategori }}</a>
                                -
                                {{ date('j F Y, H:i', strtotime($item->created_at)) }} WIB
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none transition-transform duration-300 hover:scale-110" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none transition-transform duration-300 hover:scale-110" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>

        <!-- SIDEBAR 1 -->
        <div class="container w-96 h-96 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 overflow-hidden overflow-y-scroll animate-fadeInUp">
            <h1 class="text-xl font-black">#Terpopuler</h1>
            <hr class="w-full mb-3">
            <ol class="list-decimal list-inside flex flex-col gap-3">
                @foreach ($trending as $item)
                    <li class="transition-all duration-300 hover:translate-x-3">
                        <a href="{{ route('satu-berita', $item->slug) }}"
                            class="font-semibold text-black hover:text-blue-800 transition-colors duration-300">{{ $item->judul }}</a>
                        <div class="block text-xs mt-3">
                            <a href="{{ route('berita-per-kategori', $item->kategori_id) }}"
                                class="text-blue-300 hover:text-blue-400">{{ $item->kategori->nama_kategori }}</a>
                            -
                            {{ date('j F Y, H:i', strtotime($item->created_at)) }} WIB
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>

    <!-- BERITA UTAMA -->
    <div class="container w-5/6 flex mx-auto py-0.5 gap-x-2 animate-fadeInUp">
        @foreach ($headline as $item)
            <div class="w-64 news-card bg-white card-grid border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                <a href="{{ route('satu-berita', $item->slug) }}">
                    @if ($item->thumbnail)
                        <img class="rounded-t-lg" src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->judul }}" />
                    @else
                        <img class="rounded-t-lg" src="/images/banner.jpg" alt="{{ $item->judul }}" />
                    @endif
                </a>
                <div class="p-5">
                    <a href="{{ route('satu-berita', $item->slug) }}">
                        <h5 class="mb-2 text-md leading-5 font-bold tracking-tight text-black hover:text-blue-800 dark:text-white transition-colors duration-300">
                            {{ $item->judul }}
                        </h5>
                    </a>
                    <div class="block text-xs mt-3">
                        <a href="{{ route('berita-per-kategori', $item->kategori_id) }}"
                            class="text-blue-300 hover:text-blue-400">{{ $item->kategori->nama_kategori }}</a>
                        -
                        {{ date('j F Y, H:i', strtotime($item->created_at)) }} WIB
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- MAIN SECTION 2 -->
    <div class="container w-5/6 mx-auto py-14 animate-fadeInUp">
        <h1 class="text-3xl font-bold" style="color:white">Apa yang terjadi hari ini?</h1>
        <hr class="w-full mt-2 mb-2 border-t-2 border-gray-300 animate-fadeIn">
    </div>

    <div class="container flex w-5/6 mx-auto">
        <div class="flex flex-wrap w-screen gap-2">
            @foreach ($hariIni as $item)
                <div class="w-64 news-card bg-white card-grid border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                    <a href="{{ route('satu-berita', $item->slug) }}">
                        @if ($item->thumbnail)
                            <img class="rounded-t-lg" src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->judul }}" />
                        @else
                            <img class="rounded-t-lg" src="/images/banner.jpg" alt="{{ $item->judul }}" />
                        @endif
                    </a>
                    <div class="p-5">
                        <a href="{{ route('satu-berita', $item->slug) }}">
                            <h5 class="mb-2 text-md leading-5 font-bold tracking-tight text-black hover:text-blue-800 dark:text-white transition-colors duration-300">
                                {{ $item->judul }}
                            </h5>
                        </a>
                        <div class="block text-xs mt-3">
                            <a href="{{ route('berita-per-kategori', $item->kategori_id) }}"
                                class="text-blue-300 hover:text-blue-400">{{ $item->kategori->nama_kategori }}</a>
                            -
                            {{ date('j F Y, H:i', strtotime($item->created_at)) }} WIB
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- LIHAT SEMUA BERITA -->
    <div class="container flex w-5/6 mx-auto py-5 animate-fadeInUp">
        <a href="{{ route('semua-berita') }}"
            class="pulse-button flex justify-between w-60 bg-white text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 transition-all duration-500 hover:scale-110 hover:shadow-xl">

            Lihat semua berita
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 transition-transform duration-300 group-hover:translate-x-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
            </svg>
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer class="mt-6 bg-white/95 backdrop-blur footer-grid">



    <div class="max-w-screen-xl mx-auto px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

            <!-- KIRI: SOSIAL MEDIA -->
            <div class="text-center md:text-left md:pl-16">
                <h2 class="text-lg font-bold text-gray-900 mb-4">
                    Ikuti kami
                </h2>

                <ul class="space-y-3 text-gray-700">

                    <li class="flex justify-center md:justify-start">
                        <a href="https://www.instagram.com/infobnn_kotakediri/"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="flex gap-3 hover:text-blue-700 transition-colors duration-300">
                            <span class="font-semibold">Instagram</span>
                            <span class="text-gray-500 hover:text-blue-600">
                                @infobnn_kotakediri
                            </span>
                        </a>
                    </li>

                    <li class="flex justify-center md:justify-start">
                        <a href="https://www.tiktok.com/@infobnn_kotakediri"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="flex gap-3 hover:text-blue-700 transition-colors duration-300">
                            <span class="font-semibold">TikTok</span>
                            <span class="text-gray-500 hover:text-blue-600">
                                @infobnn_kotakediri
                            </span>
                        </a>
                    </li>

                    <li class="flex justify-center md:justify-start">
                        <a href="https://www.youtube.com/@humasbnnkotakediri7036"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="flex gap-3 hover:text-blue-700 transition-colors duration-300">
                            <span class="font-semibold">YouTube</span>
                            <span class="text-gray-500 hover:text-blue-600">
                                Humas BNN Kota Kediri
                            </span>
                        </a>
                    </li>

                    <li class="flex justify-center md:justify-start">
                        <a href="https://x.com/bnn_kotakediri"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="flex gap-3 hover:text-blue-700 transition-colors duration-300">
                            <span class="font-semibold">X</span>
                            <span class="text-gray-500 hover:text-blue-600">
                                @bnn_kotakediri
                            </span>
                        </a>
                    </li>

                </ul>

                <div class="mt-6 text-sm text-gray-500 text-center md:text-left">
                    © 2025 - Info BNN Kota Kediri
                </div>
            </div>

            <!-- KANAN: LOGO -->
            <div class="flex justify-center md:justify-end">
                <img
                    src="{{ asset('images/logo2.png') }}"
                    alt="Logo BNN Kota Kediri"
                    class="w-72 md:w-80 h-auto">
            </div>

        </div>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
</body>

</html>
