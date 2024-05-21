<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'member';

    protected $fillable = [
        'kode',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'foto',
        'no_hp',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'alamat',
        'total_point',
        'keterangan',
        'tanggal_registrasi',
        'tanggal_expired',
        'register_by',
    ];
}
