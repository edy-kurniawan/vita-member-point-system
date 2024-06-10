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

        return view('menu.dashboard.index',[
            'penukaran_point'   => $penukaran_point->count(),
            'pengumpulan'       => $pengumpulan->count(),
            'total_member'      => $total_member
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
