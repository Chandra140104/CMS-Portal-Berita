<?php

namespace App\Http\Controllers;

use App\Models\LaporanKasus;
use Illuminate\Http\Request;

class LaporanKasusAdminController extends Controller
{
    public function index(Request $request)
    {
        $q    = $request->get('q');
        $sort = $request->get('sort', 'new'); // default terbaru

        $query = LaporanKasus::query();

        // SEARCH
        if (!empty($q)) {
            $query->where(function ($sub) use ($q) {
                $sub->where('nomor_laporan', 'like', "%{$q}%")
                    ->orWhere('pelapor_nama', 'like', "%{$q}%")
                    ->orWhere('pelapor_email', 'like', "%{$q}%")
                    ->orWhere('pelapor_telepon', 'like', "%{$q}%")
                    ->orWhere('terlapor_nama', 'like', "%{$q}%")
                    ->orWhere('kecamatan_kejadian', 'like', "%{$q}%")
                    ->orWhere('kelurahan_kejadian', 'like', "%{$q}%")
                    ->orWhere('jenis_narkoba', 'like', "%{$q}%")
                    ->orWhere('jenis_narkoba_lainnya', 'like', "%{$q}%")
                    ->orWhere('peran_terlapor', 'like', "%{$q}%")
                    ->orWhere('peran_terlapor_lainnya', 'like', "%{$q}%");
            });
        }

        // SORT TANGGAL
        $query->orderBy('created_at', $sort === 'old' ? 'asc' : 'desc');

        $laporans = $query->paginate(10)->onEachSide(2);

        return view('admin.laporan-kasus.index', compact('laporans', 'q', 'sort'));
    }

    public function show(LaporanKasus $laporan)
    {
        return view('admin.laporan-kasus.show', compact('laporan'));
    }

    /**
     * ✅ EXPORT (CSV yang bisa dibuka Excel)
     * - ikut filter q & sort
     * - aman UTF-8 (pakai BOM)
     */
    public function exportExcel(Request $request)
{
    $q    = $request->get('q');
    $sort = $request->get('sort', 'new');

    $query = LaporanKasus::query();

    if (!empty($q)) {
        $query->where(function ($sub) use ($q) {
            $sub->where('nomor_laporan', 'like', "%{$q}%")
                ->orWhere('pelapor_nama', 'like', "%{$q}%")
                ->orWhere('pelapor_email', 'like', "%{$q}%")
                ->orWhere('pelapor_telepon', 'like', "%{$q}%")
                ->orWhere('terlapor_nama', 'like', "%{$q}%")
                ->orWhere('kecamatan_kejadian', 'like', "%{$q}%")
                ->orWhere('kelurahan_kejadian', 'like', "%{$q}%")
                ->orWhere('jenis_narkoba', 'like', "%{$q}%")
                ->orWhere('jenis_narkoba_lainnya', 'like', "%{$q}%")
                ->orWhere('peran_terlapor', 'like', "%{$q}%")
                ->orWhere('peran_terlapor_lainnya', 'like', "%{$q}%")
                // ✅ tambahan supaya bisa dicari juga
                ->orWhere('terlapor_profesi', 'like', "%{$q}%")
                ->orWhere('kantor_alamat', 'like', "%{$q}%")
                ->orWhere('uraian_transaksi', 'like', "%{$q}%")
                ->orWhere('lokasi_transaksi', 'like', "%{$q}%")
                ->orWhere('lokasi_sering_terlihat', 'like', "%{$q}%")
                ->orWhere('sumber_informasi', 'like', "%{$q}%");
        });
    }

    $query->orderBy('created_at', $sort === 'old' ? 'asc' : 'desc');

    $rows = $query->get();

    $filename = 'laporan_kasus_' . now()->format('Ymd_His') . '.csv';

    $headers = [
        'Content-Type'        => 'text/csv; charset=UTF-8',
        'Content-Disposition' => "attachment; filename={$filename}",
    ];

    return response()->streamDownload(function () use ($rows) {
        $out = fopen('php://output', 'w');

        // BOM biar Excel kebaca UTF-8
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // ✅ Header kolom (tambahkan yang kamu minta)
        fputcsv($out, [
            'Nomor Laporan',
            'Pelapor Nama',
            'Pelapor Email',
            'Pelapor Telepon',
            'Pelapor Alamat',

            'Terlapor Nama',
            'Terlapor Telepon',
            'Terlapor Alamat',
            'Terlapor Profesi',     // ✅
            'Kantor Alamat',        // ✅

            'Kecamatan Kejadian',
            'Kelurahan Kejadian',

            'Jenis Narkoba',
            'Peran Terlapor',

            'Uraian Transaksi',     // ✅
            'Lokasi Transaksi',     // ✅
            'Lokasi Sering Terlihat', // ✅
            'Sumber Informasi',     // ✅

            'Tanggal Dibuat',
        ]);

        foreach ($rows as $r) {
            $jenis = $r->jenis_narkoba;
            if ($jenis === 'Lainnya' && !empty($r->jenis_narkoba_lainnya)) {
                $jenis = 'Lainnya - ' . $r->jenis_narkoba_lainnya;
            }

            $peran = $r->peran_terlapor;
            if ($peran === 'Lainnya' && !empty($r->peran_terlapor_lainnya)) {
                $peran = 'Lainnya - ' . $r->peran_terlapor_lainnya;
            }

            // ✅ Data row (pastikan field-field ini memang ada di tabel)
            fputcsv($out, [
                $r->nomor_laporan,
                $r->pelapor_nama,
                $r->pelapor_email,
                $r->pelapor_telepon,
                $r->pelapor_alamat,

                $r->terlapor_nama,
                $r->terlapor_telepon,
                $r->terlapor_alamat,
                $r->terlapor_profesi,        // ✅
                $r->kantor_alamat,           // ✅

                $r->kecamatan_kejadian,
                $r->kelurahan_kejadian,

                $jenis,
                $peran,

                $r->uraian_transaksi,        // ✅
                $r->lokasi_transaksi,        // ✅
                $r->lokasi_sering_terlihat,  // ✅
                $r->sumber_informasi,        // ✅

                optional($r->created_at)->format('d-m-Y H:i'),
            ]);
        }

        fclose($out);
    }, $filename, $headers);
}
}
