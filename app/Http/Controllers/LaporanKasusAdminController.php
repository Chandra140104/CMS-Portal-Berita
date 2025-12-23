<?php

namespace App\Http\Controllers;

use App\Models\LaporanKasus;
use Illuminate\Http\Request;
use App\Exports\LaporanKasusExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanKasusAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $laporans = LaporanKasus::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nomor_laporan', 'like', "%{$q}%")
                        ->orWhere('pelapor_nama', 'like', "%{$q}%")
                        ->orWhere('pelapor_email', 'like', "%{$q}%")
                        ->orWhere('pelapor_telepon', 'like', "%{$q}%")
                        ->orWhere('terlapor_nama', 'like', "%{$q}%")
                        ->orWhere('terlapor_alamat', 'like', "%{$q}%")
                        ->orWhere('jenis_narkoba', 'like', "%{$q}%")
                        ->orWhere('peran_terlapor', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.laporan-kasus.index', compact('laporans', 'q'));
    }

    public function show(LaporanKasus $laporan)
    {
        return view('admin.laporan-kasus.show', compact('laporan'));
    }

    /**
     * Export Excel (Admin only)
     * - ikutkan filter pencarian q jika ada
     */
    public function exportExcel(Request $request)
    {
        $q = $request->query('q');

        $filename = 'laporan-kasus-' . now()->format('Y-m-d_H-i') . '.xlsx';

        return Excel::download(new LaporanKasusExport($q), $filename);
    }
}
