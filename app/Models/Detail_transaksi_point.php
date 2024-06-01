<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_transaksi_point extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi_point';

    protected $fillable = [
        'transaksi_point_id',
        'reward_id',
        'qty',
        'point',
    ];
}
