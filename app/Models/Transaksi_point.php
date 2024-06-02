<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi_point extends Model
{
    use HasFactory;

    protected $table = 'transaksi_point';

    protected $fillable = [
        'kode',
        'member_id',
        'transaksi_by',
        'tanggal_transaksi',
        'total_pembelian',
        'total_point',
        'keterangan',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'transaksi_by', 'id');
    }

    public function detail_transaksi()
    {
        return $this->hasMany(Detail_transaksi_point::class, 'transaksi_point_id', 'id');
    }

}