<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKasus extends Model
{
    protected $table = 'laporan_kasus';

    protected $fillable = [
        'nomor_laporan',

        'pelapor_nama',
        'pelapor_email',
        'pelapor_telepon',
        'pelapor_alamat',

        'terlapor_nama',
        'terlapor_alamat',

        'kecamatan_kejadian',
        'kelurahan_kejadian',

        'foto_lokasi_path',

        'jenis_narkoba',
        'jenis_narkoba_lainnya',
        'jumlah_narkoba',

        'peran_terlapor',
        'peran_terlapor_lainnya',

        'terlapor_profesi',
        'kantor_alamat',

        'uraian_transaksi',
        'lokasi_transaksi',
        'lokasi_sering_terlihat',
        'sumber_informasi',
    ];
}
