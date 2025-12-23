<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\User;
use App\Models\LaporanKasus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // ====== FITUR LAMA (TETAP) ======
        $usersCount = User::query()->count();

        $kategorisCount = Kategori::query()->count();

        $beritaCount = Berita::query()
            ->where('status_publish', 'publish')
            ->count();

        // JUMLAH LAPORAN KASUS
        $laporanCount = LaporanKasus::query()->count();

        // ====== FITUR BARU: DATA DIAGRAM ======

        // Diagram Kecamatan Kejadian
        $kecamatanAgg = LaporanKasus::query()
            ->select('kecamatan_kejadian', DB::raw('COUNT(*) as total'))
            ->whereNotNull('kecamatan_kejadian')
            ->where('kecamatan_kejadian', '!=', '')
            ->groupBy('kecamatan_kejadian')
            ->orderByDesc('total')
            ->get();

        // Diagram Kelurahan Kejadian (Top 15 biar tidak kepanjangan)
        $kelurahanAgg = LaporanKasus::query()
            ->select('kelurahan_kejadian', DB::raw('COUNT(*) as total'))
            ->whereNotNull('kelurahan_kejadian')
            ->where('kelurahan_kejadian', '!=', '')
            ->groupBy('kelurahan_kejadian')
            ->orderByDesc('total')
            ->limit(15)
            ->get();

        // Siapkan untuk ChartJS
        $kecamatanLabels = $kecamatanAgg->pluck('kecamatan_kejadian')->toArray();
        $kecamatanCounts = $kecamatanAgg->pluck('total')->toArray();

        $kelurahanLabels = $kelurahanAgg->pluck('kelurahan_kejadian')->toArray();
        $kelurahanCounts = $kelurahanAgg->pluck('total')->toArray();

        return view(
            'admin.index',
            compact(
                'usersCount',
                'kategorisCount',
                'beritaCount',
                'laporanCount',

                // variabel baru untuk chart
                'kecamatanLabels',
                'kecamatanCounts',
                'kelurahanLabels',
                'kelurahanCounts'
            )
        );
    }
}
