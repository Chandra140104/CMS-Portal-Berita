@extends('layouts.admin-section.master')
@section('content')

<div class="p-6">
{{-- HEADER 1 BARIS --}}
<div class="bg-white border border-gray-200 rounded-xl shadow-sm px-5 py-4 mb-4">
    <div class="flex items-center justify-between gap-4 flex-nowrap overflow-x-auto">

        {{-- LEFT: Title --}}
        <div class="flex-shrink-0">
            <h1 class="text-xl font-bold text-gray-900 whitespace-nowrap">
                Laporan Kasus
            </h1>
            <p class="text-xs text-gray-500 whitespace-nowrap">
                Kelola laporan & export Excel
            </p>
        </div>

        {{-- RIGHT: Controls --}}
        <form method="GET" class="flex items-center gap-2 flex-nowrap">

            {{-- SEARCH --}}
            <input
                type="text"
                name="q"
                value="{{ $q ?? '' }}"
                class="w-[320px] rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Cari laporan..."
            >

            {{-- SORT --}}
            <select
                name="sort"
                class="w-[160px] rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            >
                <option value="new" {{ ($sort ?? 'new') === 'new' ? 'selected' : '' }}>
                    Terbaru
                </option>
                <option value="old" {{ ($sort ?? 'new') === 'old' ? 'selected' : '' }}>
                    Terlama
                </option>
            </select>

            {{-- BUTTON CARI --}}
            <button
                type="submit"
                class="rounded-lg bg-blue-700 px-4 py-2 text-white text-sm font-semibold hover:bg-blue-800 whitespace-nowrap"
            >
                Cari
            </button>

            {{-- RESET --}}
            <a
                href="{{ route('admin.laporan-kasus.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 whitespace-nowrap"
            >
                Reset
            </a>

            {{-- EXPORT --}}
            <a
                href="{{ route('admin.laporan-kasus.export', ['q' => ($q ?? ''), 'sort' => ($sort ?? 'new')]) }}"
                class="rounded-lg bg-green-700 px-4 py-2 text-white text-sm font-semibold hover:bg-green-800 whitespace-nowrap"
            >
                Export Excel
            </a>

        </form>
    </div>
</div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nomor Laporan</th>
                    <th class="px-4 py-3 text-left">Terlapor</th>
                    <th class="px-4 py-3 text-left">Lokasi Kejadian</th>
                    <th class="px-4 py-3 text-left">Jenis</th>
                    <th class="px-4 py-3 text-left">Peran</th>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($laporans as $i => $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            {{ $laporans->firstItem() + $i }}
                        </td>

                        <td class="px-4 py-3 font-semibold">
                            {{ $item->nomor_laporan ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="font-semibold text-gray-900">{{ $item->terlapor_nama }}</div>
                            <div class="text-xs text-gray-500">{{ $item->terlapor_alamat }}</div>
                        </td>

                        <td class="px-4 py-3">
                            <div class="font-semibold text-gray-900">
                                {{ $item->kecamatan_kejadian ?? '-' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $item->kelurahan_kejadian ?? '-' }}
                            </div>
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->jenis_narkoba }}
                            @if($item->jenis_narkoba === 'Lainnya' && $item->jenis_narkoba_lainnya)
                                ({{ $item->jenis_narkoba_lainnya }})
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->peran_terlapor }}
                            @if($item->peran_terlapor === 'Lainnya' && $item->peran_terlapor_lainnya)
                                ({{ $item->peran_terlapor_lainnya }})
                            @endif
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}
                        </td>

                        <td class="px-4 py-3">
                            <a href="{{ route('admin.laporan-kasus.show', $item->id) }}"
                               class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-white text-xs font-semibold hover:bg-gray-800">
                                Lihat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                            Belum ada laporan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{-- supaya q & sort tetap kebawa saat pindah halaman --}}
        {{ $laporans->appends(request()->query())->links() }}
    </div>
</div>

@endsection
