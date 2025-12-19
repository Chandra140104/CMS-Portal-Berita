@extends('layouts.admin-section.master')
@section('content')

<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-gray-900">Detail Laporan</h1>

        <a href="{{ route('admin.laporan-kasus.index') }}"
           class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
            Kembali
        </a>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="text-xs text-gray-500">Nomor Laporan</div>
                <div class="font-semibold">{{ $laporan->nomor_laporan ?? '-' }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-500">Tanggal</div>
                <div class="font-semibold">{{ \Carbon\Carbon::parse($laporan->created_at)->format('d-m-Y H:i') }}</div>
            </div>
        </div>

        <hr>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="font-bold mb-2">Pelapor</h2>
                <div class="text-sm space-y-1">
                    <div><b>Nama:</b> {{ $laporan->pelapor_nama }}</div>
                    <div><b>Email:</b> {{ $laporan->pelapor_email }}</div>
                    <div><b>Telepon:</b> {{ $laporan->pelapor_telepon }}</div>
                    <div><b>Alamat:</b> {{ $laporan->pelapor_alamat }}</div>
                </div>
            </div>

            <div>
                <h2 class="font-bold mb-2">Terlapor</h2>
                <div class="text-sm space-y-1">
                    <div><b>Nama:</b> {{ $laporan->terlapor_nama }}</div>
                    <div><b>Alamat:</b> {{ $laporan->terlapor_alamat }}</div>
                    <div><b>Profesi:</b> {{ $laporan->terlapor_profesi }}</div>
                    <div><b>Alamat Kantor:</b> {{ $laporan->kantor_alamat ?: '-' }}</div>
                </div>
            </div>
        </div>

        <hr>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="font-bold mb-2">Informasi Narkoba</h2>
                <div class="text-sm space-y-1">
                    <div>
                        <b>Jenis:</b>
                        {{ $laporan->jenis_narkoba }}
                        @if($laporan->jenis_narkoba === 'Lainnya' && $laporan->jenis_narkoba_lainnya)
                            ({{ $laporan->jenis_narkoba_lainnya }})
                        @endif
                    </div>
                    <div><b>Jumlah:</b> {{ $laporan->jumlah_narkoba }}</div>
                    <div>
                        <b>Peran Terlapor:</b>
                        {{ $laporan->peran_terlapor }}
                        @if($laporan->peran_terlapor === 'Lainnya' && $laporan->peran_terlapor_lainnya)
                            ({{ $laporan->peran_terlapor_lainnya }})
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <h2 class="font-bold mb-2">Bukti Foto</h2>
                @if($laporan->foto_lokasi_path)
                    <a href="{{ asset('storage/' . $laporan->foto_lokasi_path) }}" target="_blank"
                       class="text-blue-700 font-semibold hover:underline">
                        Lihat Foto Lokasi
                    </a>
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $laporan->foto_lokasi_path) }}"
                             class="rounded-lg border border-gray-200 max-h-72"
                             alt="Foto Lokasi">
                    </div>
                @else
                    <div class="text-sm text-gray-500">Tidak ada foto.</div>
                @endif
            </div>
        </div>

        <hr>

        <div class="space-y-4">
            <div>
                <h2 class="font-bold mb-2">Uraian Cara Pengedaran/Transaksi</h2>
                <div class="text-sm text-gray-700 whitespace-pre-line">{{ $laporan->uraian_transaksi }}</div>
            </div>
            <div>
                <h2 class="font-bold mb-2">Lokasi Transaksi</h2>
                <div class="text-sm text-gray-700 whitespace-pre-line">{{ $laporan->lokasi_transaksi }}</div>
            </div>
            <div>
                <h2 class="font-bold mb-2">Lokasi Terlapor Sering Terlihat</h2>
                <div class="text-sm text-gray-700 whitespace-pre-line">{{ $laporan->lokasi_sering_terlihat }}</div>
            </div>
            <div>
                <h2 class="font-bold mb-2">Sumber Informasi</h2>
                <div class="text-sm text-gray-700 whitespace-pre-line">{{ $laporan->sumber_informasi }}</div>
            </div>
        </div>
    </div>
</div>

@endsection
