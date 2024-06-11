<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Transaksi_point;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penukaran_point    = Transaksi_point::where('total_point', '<', 0)->where('tanggal_transaksi', date('Y-m-d'))->where('transaksi_by', Auth()->user()->id)->get();
        $pengumpulan        = Transaksi_point::where('total_point', '>', 0)->where('tanggal_transaksi', date('Y-m-d'))->where('transaksi_by', Auth()->user()->id)->get();
        $total_member       = Member::count();

        $total_transaksi = Transaksi_point::selectRaw('CAST(SUM(total_pembelian) AS UNSIGNED) as total_pembelian, DATE_FORMAT(tanggal_transaksi, "%M") as bulan')
                            ->where('tanggal_transaksi', '>=', date('Y-01-01'))
                            ->where('tanggal_transaksi', '<=', date('Y-12-31'))
                            ->groupBy('bulan')
                            ->get();

        $bulan = $total_transaksi->pluck('bulan');
        $total_pembelian = $total_transaksi->pluck('total_pembelian');

        return view('menu.dashboard.index',[
            'penukaran_point'   => $penukaran_point->count(),
            'pengumpulan'       => $pengumpulan->count(),
            'total_member'      => $total_member,
            'bulan'             => $bulan,
            'total_pembelian'   => $total_pembelian
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
