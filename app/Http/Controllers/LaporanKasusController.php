<?php

namespace App\Http\Controllers;

use App\Models\LaporanKasus;
use Illuminate\Http\Request;

class LaporanKasusController extends Controller
{
    /**
     * Tampilkan form laporan.
     */
    public function create()
    {
        return view('laporan-kasus.create');
    }

    /**
     * Simpan laporan ke database + upload file (opsional).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Pelapor
            'pelapor_nama'    => ['required', 'string', 'max:255'],
            'pelapor_email'   => ['required', 'email', 'max:255'],
            'pelapor_telepon' => ['required', 'string', 'max:20'],
            'pelapor_alamat'  => ['required', 'string', 'max:255'],

            // Terlapor
            'terlapor_nama'    => ['required', 'string', 'max:255'],
            'terlapor_telepon' => ['nullable', 'string', 'max:20'],
            'terlapor_alamat'  => ['required', 'string', 'max:255'],

            // Foto (opsional) - 1 file saja tiap jenis
            'foto_lokasi'     => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'foto_kendaraan'  => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            // Narkoba
            'jenis_narkoba'           => ['required', 'in:Sabu,Ganja,Ekstasi,Heroin,Obat-obatan,Lainnya'],
            'jenis_narkoba_lainnya'   => ['nullable', 'string', 'max:255'],

            // Jumlah
            'jumlah_narkoba' => ['required', 'string', 'max:120'],

            // Peran
            'peran_terlapor'         => ['required', 'in:Pengguna,Pengedar,Bandar,Kurir,Produsen,Lainnya'],
            'peran_terlapor_lainnya' => ['nullable', 'string', 'max:255'],

            // Profesi / kantor
            'terlapor_profesi' => ['required', 'string', 'max:255'],
            'kantor_alamat'    => ['nullable', 'string', 'max:255'],

            // Kendaraan
            'kendaraan_info_plat' => ['required', 'string', 'max:255'],

            // Uraian
            'uraian_transaksi'      => ['required', 'string'],
            'lokasi_transaksi'      => ['required', 'string'],
            'lokasi_sering_terlihat'=> ['required', 'string'],
            'sumber_informasi'      => ['required', 'string'],
        ]);

        // Jika pilih "Lainnya" tapi tidak isi keterangannya
        if ($validated['jenis_narkoba'] === 'Lainnya' && empty($validated['jenis_narkoba_lainnya'])) {
            return back()->withErrors(['jenis_narkoba_lainnya' => 'Wajib diisi jika memilih "Lainnya".'])->withInput();
        }

        if ($validated['peran_terlapor'] === 'Lainnya' && empty($validated['peran_terlapor_lainnya'])) {
            return back()->withErrors(['peran_terlapor_lainnya' => 'Wajib diisi jika memilih "Lainnya".'])->withInput();
        }

        // Upload file (opsional)
        $fotoLokasiPath = null;
        if ($request->hasFile('foto_lokasi')) {
            $fotoLokasiPath = $request->file('foto_lokasi')->store('laporan-kasus/foto-lokasi', 'public');
        }

        $fotoKendaraanPath = null;
        if ($request->hasFile('foto_kendaraan')) {
            $fotoKendaraanPath = $request->file('foto_kendaraan')->store('laporan-kasus/foto-kendaraan', 'public');
        }

        // Simpan ke DB
        $laporan = LaporanKasus::create([
            ...$validated,
            'foto_lokasi_path'    => $fotoLokasiPath,
            'foto_kendaraan_path' => $fotoKendaraanPath,
        ]);

        // Redirect sukses (ke halaman form atau beranda, bebas)
        return redirect()
            ->route('laporan-kasus.create')
            ->with('success', 'Laporan berhasil dikirim. Terima kasih atas partisipasi Anda.');
    }
}
