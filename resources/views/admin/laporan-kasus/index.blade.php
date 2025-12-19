@extends('layouts.admin-section.master')
@section('content')

<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-gray-900">Laporan Kasus</h1>

        <form method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ $q }}"
                   class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Cari nomor/pelapor/terlapor/jenis...">
            <button class="rounded-lg bg-blue-700 px-4 py-2 text-white font-semibold hover:bg-blue-800">
                Cari
            </button>
        </form>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nomor Laporan</th>
                    <th class="px-4 py-3 text-left">Terlapor</th>
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
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                            Belum ada laporan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $laporans->links() }}
    </div>
</div>

@endsection
