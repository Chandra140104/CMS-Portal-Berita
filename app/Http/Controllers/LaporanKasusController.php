<?php

namespace App\Http\Controllers;

use App\Models\LaporanKasus;
use App\Services\TelegramService;
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
     * Simpan laporan ke database + upload file (opsional),
     * lalu kirim notifikasi ke Telegram admin.
     */
    public function store(Request $request, TelegramService $telegram)
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
            'jenis_narkoba'         => ['required', 'in:Sabu,Ganja,Ekstasi,Heroin,Obat-obatan,Lainnya'],
            'jenis_narkoba_lainnya' => ['nullable', 'string', 'max:255'],

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
            'uraian_transaksi'       => ['required', 'string'],
            'lokasi_transaksi'       => ['required', 'string'],
            'lokasi_sering_terlihat' => ['required', 'string'],
            'sumber_informasi'       => ['required', 'string'],
        ]);

        // Jika pilih "Lainnya" tapi tidak isi keterangannya
        if ($validated['jenis_narkoba'] === 'Lainnya' && empty($validated['jenis_narkoba_lainnya'])) {
            return back()->withErrors([
                'jenis_narkoba_lainnya' => 'Wajib diisi jika memilih "Lainnya".'
            ])->withInput();
        }

        if ($validated['peran_terlapor'] === 'Lainnya' && empty($validated['peran_terlapor_lainnya'])) {
            return back()->withErrors([
                'peran_terlapor_lainnya' => 'Wajib diisi jika memilih "Lainnya".'
            ])->withInput();
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

        // ===== KIRIM TELEGRAM =====
        try {
            $jenisTambahan = ($laporan->jenis_narkoba === 'Lainnya' && $laporan->jenis_narkoba_lainnya)
                ? " ({$laporan->jenis_narkoba_lainnya})"
                : "";

            $peranTambahan = ($laporan->peran_terlapor === 'Lainnya' && $laporan->peran_terlapor_lainnya)
                ? " ({$laporan->peran_terlapor_lainnya})"
                : "";

            $msg = "<b>📩 Laporan Kasus Baru Masuk</b>\n"
                . "━━━━━━━━━━━━━━━━━━\n"
                . "<b>Pelapor:</b> {$laporan->pelapor_nama}\n"
                . "<b>Telepon:</b> {$laporan->pelapor_telepon}\n"
                . "<b>Email:</b> {$laporan->pelapor_email}\n"
                . "<b>Alamat:</b> {$laporan->pelapor_alamat}\n"
                . "━━━━━━━━━━━━━━━━━━\n"
                . "<b>Terlapor:</b> {$laporan->terlapor_nama}\n"
                . "<b>Alamat Terlapor:</b> {$laporan->terlapor_alamat}\n"
                . "━━━━━━━━━━━━━━━━━━\n"
                . "<b>Jenis Narkoba:</b> {$laporan->jenis_narkoba}{$jenisTambahan}\n"
                . "<b>Jumlah:</b> {$laporan->jumlah_narkoba}\n"
                . "<b>Peran:</b> {$laporan->peran_terlapor}{$peranTambahan}\n"
                . "<b>Profesi:</b> {$laporan->terlapor_profesi}\n"
                . "<b>Alamat Kantor:</b> " . ($laporan->kantor_alamat ?: '-') . "\n"
                . "━━━━━━━━━━━━━━━━━━\n"
                . "<b>Lokasi Transaksi:</b>\n{$laporan->lokasi_transaksi}\n"
                . "<b>Lokasi Sering Terlihat:</b>\n{$laporan->lokasi_sering_terlihat}\n"
                . "<b>Sumber Informasi:</b>\n{$laporan->sumber_informasi}\n"
                . "━━━━━━━━━━━━━━━━━━\n"
                . "<b>Cara Pengedaran/Transaksi:</b>\n{$laporan->uraian_transaksi}\n";

            $telegram->sendMessage($msg);
        } catch (\Throwable $e) {
            \Log::error('Telegram gagal: '.$e->getMessage());
        }

        return redirect()
            ->route('laporan-kasus.create')
            ->with('success', 'Laporan berhasil dikirim. Terima kasih atas partisipasi Anda.');
    }
}
