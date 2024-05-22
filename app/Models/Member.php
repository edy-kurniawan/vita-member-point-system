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

    public function provinsi()
    {
        return $this->belongsTo(Province::class, 'provinsi_id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Regency::class, 'kabupaten_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(District::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Village::class, 'kelurahan_id');
    }
}
