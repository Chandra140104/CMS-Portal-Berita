@extends('layouts.admin-section.master')

@section('title', 'Admin Dashboard')
@section('nav-title', 'Dashboard')

@section('content')
@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
@endphp

<div class="p-6">

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ $isAdmin ? '4' : '2' }} gap-6">

        <!-- BERITA -->
        <div class="bg-red-100 rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-semibold mb-1">
                        {{ $beritaCount }}
                    </div>
                    <div class="text-sm font-medium text-gray-400">
                        Berita yang ditayangkan
                    </div>
                </div>
                <div class="text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375
                                 c.621 0 1.125.504 1.125 1.125V18
                                 a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18
                                 a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875
                                 c0-.621-.504-1.125-1.125-1.125H4.125
                                 C3.504 3.75 3 4.254 3 4.875V18
                                 a2.25 2.25 0 0 0 2.25 2.25h13.5" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- KATEGORI -->
        <div class="bg-green-100 rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-semibold mb-1">
                        {{ $kategorisCount }}
                    </div>
                    <div class="text-sm font-medium text-gray-400">
                        Jumlah Kategori
                    </div>
                </div>
                <div class="text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318
                                 c0 .597.237 1.17.659 1.591l9.581 9.581
                                 c.699.699 1.78.872 2.607.33
                                 a18.095 18.095 0 0 0 5.223-5.223
                                 c.542-.827.369-1.908-.33-2.607
                                 L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- PENGGUNA (ADMIN ONLY) --}}
        @if ($isAdmin)
            <div class="bg-blue-100 rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-2xl font-semibold mb-1">
                            {{ $usersCount }}
                        </div>
                        <div class="text-sm font-medium text-gray-400">
                            Jumlah Pengguna Aktif
                        </div>
                    </div>
                    <div class="text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 6a3.75 3.75 0 1 1-7.5 0
                                     3.75 3.75 0 0 1 7.5 0ZM4.501 20.118
                                     a7.5 7.5 0 0 1 14.998 0
                                     A17.933 17.933 0 0 1 12 21.75
                                     c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- LAPORAN KASUS (ADMIN ONLY) --}}
            <a href="{{ route('admin.laporan-kasus.index') }}"
               class="block bg-yellow-100 rounded-md border border-gray-100 p-6
                      shadow-md shadow-black/5 hover:scale-[1.02] transition">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-2xl font-semibold mb-1">
                            {{ $laporanCount }}
                        </div>
                        <div class="text-sm font-medium text-gray-400">
                            Jumlah Laporan Kasus
                        </div>
                    </div>
                    <div class="text-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 3c.132 0 .263.003.393.008
                                     a9.004 9.004 0 1 1-9.385 9.385
                                     A9.003 9.003 0 0 1 12 3Zm0 6v3.75
                                     m0 3.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                </div>
            </a>
        @endif
    </div>

    {{-- CHART (ADMIN ONLY) --}}
    @if ($isAdmin)
        <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Kecamatan (BAR) --}}
            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold">Diagram Kecamatan Kejadian</h2>
                    <span class="text-xs text-gray-500">Total laporan per kecamatan</span>
                </div>
                <div class="h-72">
                    <canvas id="chartKecamatan"></canvas>
                </div>
            </div>

            {{-- Kelurahan (PIE) --}}
            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold">Diagram Kelurahan Kejadian</h2>
                    <span class="text-xs text-gray-500">Persentase (Top 15 kelurahan)</span>
                </div>
                <div class="h-72">
                    <canvas id="chartKelurahan"></canvas>
                </div>
            </div>

        </div>

        {{-- Chart.js --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

        <script>
            const kecLabels = @json($kecamatanLabels ?? []);
            const kecData   = @json($kecamatanCounts ?? []);

            const kelLabels = @json($kelurahanLabels ?? []);
            const kelData   = @json($kelurahanCounts ?? []);

            // ===== Kecamatan Chart (BAR) - Y bulat saja =====
            new Chart(document.getElementById('chartKecamatan'), {
                type: 'bar',
                data: {
                    labels: kecLabels,
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: kecData,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => ` ${ctx.raw} laporan`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,  // bilangan bulat
                                stepSize: 1    // tidak ada 0.5 / 1.5
                            },
                            title: { display: true, text: 'Jumlah Laporan' }
                        },
                        x: {
                            title: { display: true, text: 'Kecamatan' }
                        }
                    }
                }
            });

            // ===== Kelurahan Chart (PIE) - persentase =====
            new Chart(document.getElementById('chartKelurahan'), {
                type: 'pie',
                data: {
                    labels: kelLabels,
                    datasets: [{
                        data: kelData,
                        backgroundColor: [
                            '#60a5fa','#34d399','#f87171','#fbbf24','#a78bfa',
                            '#fb7185','#22d3ee','#c084fc','#4ade80','#f97316',
                            '#38bdf8','#facc15','#e879f9','#818cf8','#fb923c'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const arr = context.dataset.data || [];
                                    const total = arr.reduce((a, b) => a + Number(b || 0), 0);
                                    const value = Number(context.raw || 0);
                                    const pct = total > 0 ? ((value / total) * 100).toFixed(1) : '0.0';
                                    return ` ${context.label}: ${value} (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endif

    <!-- ABOUT SECTION -->
    <div class="mt-10 bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
        <div class="flex flex-col md:flex-row items-center">
            <div class="w-full md:w-1/3 mb-6 md:mb-0">
                <img src="{{ asset('images/logo2.png') }}"
                     alt="Logo BNN Kota Kediri"
                     class="w-full h-auto rounded-md">
            </div>
            <div class="w-full md:w-2/3 md:pl-6">
                <h2 class="text-xl font-semibold mb-2">Tentang</h2>
                <p class="text-gray-600">
                    Dashboard System Portal Berita BNN Kota Kediri digunakan
                    untuk mengelola berita, kategori, pengguna, serta memantau
                    laporan kasus penyalahgunaan narkoba yang masuk dari masyarakat.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
