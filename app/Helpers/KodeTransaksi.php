<?php

use App\Models\Transaksi_point;
use Illuminate\Support\Facades\Auth;

function KodeTransaksi()
{
    // get last record
    $last = Transaksi_point::whereDate('tanggal_transaksi', date('Y-m-d'))->orderBy('id', 'desc')->first();

    // increment id
    if(!$last){
        $id = 1;
    }else{
        $id = $last->id + 1;
    }

    // generate kode
    $kode = date('Ymdhi').Auth::user()->id.$id;
    return $kode;
}