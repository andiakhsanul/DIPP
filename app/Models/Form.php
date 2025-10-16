<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan.
     */
    protected $table = 'pendaftaran_pekerti';

    /**
     * Kolom yang boleh diisi (mass assignable).
     */
    protected $fillable = [
        'nama_lengkap',
        'nidn_nidk_nuptk',
        'institusi',
        'nomor_hp',
        'email',
        'bukti_transfer',
        'npwp_ktp',
        'surat_tugas',
        'tanda_tangan',
    ];

    /**
     * Kolom yang otomatis di-cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
