<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Reward;
use Yajra\Datatables\Datatables;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //datatable
        if (request()->ajax()) {

            $data = Reward::orderBy('nama');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('foto', function ($row) {
                    $foto = '<a href="' . asset('storage/images/reward/' . $row->foto) . '" target="_blank"><img src="' . asset('storage/images/reward/' . $row->foto) . '" width="50px" height="50px"></a>';

                    return $foto;
                })
                ->addColumn('reward', function ($row) {
                    $reward = '<h5 class="font-size-14 text-truncate">' . $row->nama . '</h5>';
                    $reward .= '<p class="text-muted mb-0"> Deskripsi : <span class="fw-medium">' . $row->keterangan . '</span></p>';

                    return $reward;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                            <center>
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="cartButton(' . $row->id . ')"><i class="fas fa-cart-plus"></i></a>
                            </center>
                        ';

                    return $actionBtn;
                })
                ->rawColumns(['foto','action','reward'])
                ->make(true);
        }

        return view('menu.point.create');
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
        // add to cart
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
