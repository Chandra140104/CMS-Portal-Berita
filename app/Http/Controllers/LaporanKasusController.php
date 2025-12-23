<?php

namespace App\Http\Controllers;

use App\Models\LaporanKasus;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LaporanKasusController extends Controller
{
    public function create()
    {
        return view('laporan-kasus.create');
    }

    public function store(Request $request, TelegramService $telegram)
    {
        $validated = $request->validate([
            // Pelapor
            'pelapor_nama'    => ['required', 'string', 'max:255'],
            'pelapor_email'   => ['required', 'email', 'max:255'],
            'pelapor_telepon' => ['required', 'string', 'max:20'],
            'pelapor_alamat'  => ['required', 'string', 'max:255'],

            // Terlapor
            'terlapor_nama'   => ['required', 'string', 'max:255'],
            'terlapor_alamat' => ['required', 'string', 'max:255'],

            // Lokasi Kejadian (BARU)
            'kecamatan_kejadian' => ['required', 'in:Mojoroto,Kota,Pesantren'],
            'kelurahan_kejadian' => ['required', 'in:Balowerti,Banaran,Bandar Kidul,Bandar Lor,Bangsal,Banjarmlati,Banjaran,Blabak,Burengan,Campurejo,Dandangan,Gayam,Jamsaren,Kaliombo,Kampung Dalem,Karanganyar,Ketami,Kwadungan,Lirboyo,Manisrenggo,Mrican,Mojoroto,Ngadirejo,Ngronggo,Pakelan,Pakunden,Panglungan,Pesantren,Pojok,Rejomulyo,Ringinanom,Semampir,Setono Gedong,Setono Pande,Singonegaran,Sukorame,Tamanan,Tempurejo,Tinalan,Tosaren'],

            // Foto
            'foto_lokasi' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

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

            // Uraian
            'uraian_transaksi'       => ['required', 'string'],
            'lokasi_transaksi'       => ['required', 'string'],
            'lokasi_sering_terlihat' => ['required', 'string'],
            'sumber_informasi'       => ['required', 'string'],
        ]);

        // Validasi tambahan untuk opsi "Lainnya"
        if ($validated['jenis_narkoba'] === 'Lainnya' && empty($validated['jenis_narkoba_lainnya'])) {
            return back()->withErrors(['jenis_narkoba_lainnya' => 'Wajib diisi jika memilih "Lainnya".'])->withInput();
        }
        if ($validated['peran_terlapor'] === 'Lainnya' && empty($validated['peran_terlapor_lainnya'])) {
            return back()->withErrors(['peran_terlapor_lainnya' => 'Wajib diisi jika memilih "Lainnya".'])->withInput();
        }

        // ===== UPLOAD FOTO (SEBELUM TRANSAKSI) =====
        $fotoLokasiPath = null;
        if ($request->hasFile('foto_lokasi')) {
            $fotoLokasiPath = $request->file('foto_lokasi')->store('laporan-kasus/foto-lokasi', 'public');
        }

        $nomorLaporan = null;
        $laporan = null;

        // ===== GENERATE NOMOR LAPORAN + SIMPAN DB =====
        DB::transaction(function () use (&$nomorLaporan, $validated, $fotoLokasiPath, &$laporan) {
            $bulanRomawi = [1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',7=>'VII',8=>'VIII',9=>'IX',10=>'X',11=>'XI',12=>'XII'];
            $bulan = (int) now()->format('n');
            $tahun = (int) now()->format('Y');

            $countBulanIni = LaporanKasus::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->lockForUpdate()
                ->count();

            $urut  = $countBulanIni + 1;
            $urut2 = str_pad((string) $urut, 2, '0', STR_PAD_LEFT);

            $nomorLaporan = "LP/A/{$urut2}/{$bulanRomawi[$bulan]}/{$tahun}/PEMBERANTASAN/BNNK KOTA KEDIRI/BNNP JAWA TIMUR";

            $laporan = LaporanKasus::create([
                ...$validated,
                'nomor_laporan'    => $nomorLaporan,
                'foto_lokasi_path' => $fotoLokasiPath,
            ]);
        });

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
                . "<b>No. Laporan:</b> {$laporan->nomor_laporan}\n"
                . "<b>Tanggal:</b> " . now()->format('d-m-Y H:i') . " WIB\n"
                . "━━━━━━━━━━━━━━━━━━\n"
                . "<b>Pelapor:</b> {$laporan->pelapor_nama}\n"
                . "<b>Telepon:</b> {$laporan->pelapor_telepon}\n"
                . "<b>Email:</b> {$laporan->pelapor_email}\n"
                . "<b>Alamat:</b> {$laporan->pelapor_alamat}\n"
                . "━━━━━━━━━━━━━━━━━━\n"
                . "<b>Terlapor:</b> {$laporan->terlapor_nama}\n"
                . "<b>Alamat Terlapor:</b> {$laporan->terlapor_alamat}\n"
                . "━━━━━━━━━━━━━━━━━━\n"
                . "<b>Kecamatan Kejadian:</b> {$laporan->kecamatan_kejadian}\n"
                . "<b>Kelurahan Kejadian:</b> {$laporan->kelurahan_kejadian}\n"
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

            if (!empty($laporan->foto_lokasi_path)) {
                $abs = storage_path('app/public/' . $laporan->foto_lokasi_path);
                if (file_exists($abs)) {
                    $telegram->sendPhoto($abs, "<b>📍 Foto Lokasi {$laporan->nomor_laporan}</b>");
                }
            }
        } catch (\Throwable $e) {
            Log::error('Telegram gagal: ' . $e->getMessage());
        }

        return redirect()
            ->route('laporan-kasus.create')
            ->with('success', 'Laporan berhasil dikirim. Terima kasih atas partisipasi Anda.');
    }
}
