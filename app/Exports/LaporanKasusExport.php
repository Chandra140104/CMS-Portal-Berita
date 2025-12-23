<?php

namespace App\Exports;

use App\Models\LaporanKasus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanKasusExport implements FromCollection, WithHeadings
{
    private ?string $q;

    public function __construct(?string $q = null)
    {
        $this->q = $q;
    }

    public function collection()
    {
        $q = $this->q;

        return LaporanKasus::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nomor_laporan', 'like', "%{$q}%")
                        ->orWhere('pelapor_nama', 'like', "%{$q}%")
                        ->orWhere('pelapor_email', 'like', "%{$q}%")
                        ->orWhere('pelapor_telepon', 'like', "%{$q}%")
                        ->orWhere('pelapor_alamat', 'like', "%{$q}%")
                        ->orWhere('terlapor_nama', 'like', "%{$q}%")
                        ->orWhere('terlapor_alamat', 'like', "%{$q}%")
                        ->orWhere('kecamatan_kejadian', 'like', "%{$q}%")
                        ->orWhere('kelurahan_kejadian', 'like', "%{$q}%")
                        ->orWhere('terlapor_profesi', 'like', "%{$q}%")
                        ->orWhere('kantor_alamat', 'like', "%{$q}%")
                        ->orWhere('jenis_narkoba', 'like', "%{$q}%")
                        ->orWhere('peran_terlapor', 'like', "%{$q}%")
                        ->orWhere('lokasi_transaksi', 'like', "%{$q}%")
                        ->orWhere('lokasi_sering_terlihat', 'like', "%{$q}%")
                        ->orWhere('sumber_informasi', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('created_at')
            ->get([
                'nomor_laporan',

                'pelapor_nama',
                'pelapor_email',
                'pelapor_telepon',
                'pelapor_alamat',

                'terlapor_nama',
                'terlapor_alamat',

                'kecamatan_kejadian',
                'kelurahan_kejadian',

                'terlapor_profesi',
                'kantor_alamat',

                'jenis_narkoba',
                'jenis_narkoba_lainnya',
                'jumlah_narkoba',

                'peran_terlapor',
                'peran_terlapor_lainnya',

                'uraian_transaksi',
                'lokasi_transaksi',
                'lokasi_sering_terlihat',
                'sumber_informasi',

                'created_at',
            ]);
    }

    public function headings(): array
    {
        return [
            'Nomor Laporan',

            'Nama Pelapor',
            'Email Pelapor',
            'Telepon Pelapor',
            'Alamat Pelapor',

            'Nama Terlapor',
            'Alamat Terlapor',

            'Kecamatan Kejadian',
            'Kelurahan Kejadian',

            'Profesi Terlapor',
            'Alamat Kantor',

            'Jenis Narkoba',
            'Jenis Narkoba (Lainnya)',
            'Jumlah Narkoba',

            'Peran Terlapor',
            'Peran Terlapor (Lainnya)',

            'Uraian Transaksi',
            'Lokasi Transaksi',
            'Lokasi Sering Terlihat',
            'Sumber Informasi',

            'Tanggal Laporan',
        ];
    }
}
