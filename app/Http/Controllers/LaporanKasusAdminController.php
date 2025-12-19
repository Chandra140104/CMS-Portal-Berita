<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LaporanKasus;
use Illuminate\Http\Request;

class LaporanKasusAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $laporans = LaporanKasus::query()
            ->when($q, function ($query) use ($q) {
                $query->where('nomor_laporan', 'like', "%{$q}%")
                      ->orWhere('pelapor_nama', 'like', "%{$q}%")
                      ->orWhere('pelapor_email', 'like', "%{$q}%")
                      ->orWhere('pelapor_telepon', 'like', "%{$q}%")
                      ->orWhere('terlapor_nama', 'like', "%{$q}%")
                      ->orWhere('terlapor_alamat', 'like', "%{$q}%")
                      ->orWhere('jenis_narkoba', 'like', "%{$q}%")
                      ->orWhere('peran_terlapor', 'like', "%{$q}%");
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
}
