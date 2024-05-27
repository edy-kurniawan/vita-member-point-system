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

            if ($request->table == 'reward') {

                $data = Reward::where('point', '<=', $request->total_point_member)->orderBy('nama');

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
                    ->rawColumns(['foto', 'action', 'reward'])
                    ->make(true);
            } else if ($request->table == 'cart') {

                $data = Cart::with(['reward'])
                        ->where('user_id', Auth()->user()->id)
                        ->where('member_id', $request->member_id)
                        ->get();

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('foto', function ($row) {
                        $foto = '<a href="' . asset('storage/images/reward/' . $row->reward->foto) . '" target="_blank"><img src="' . asset('storage/images/reward/' . $row->reward->foto) . '" width="50px" height="50px"></a>';

                        return $foto;
                    })
                    ->addColumn('nama', function ($row) {
                        $reward = '<h5 class="font-size-14 text-truncate">' . $row->reward->nama . '</h5>';
                        $reward .= '<p class="text-muted mb-0"> Deskripsi : <span class="fw-medium">' . $row->reward->keterangan . '</span></p>';

                        return $reward;
                    })
                    ->addColumn('input_qty', function ($row) {
                        $input_qty = '<input type="number" class="form-control" value="' . $row->qty . '" id="qty_' . $row->reward->id . '" onchange="updateQty(' . $row->reward->id . ')">';

                        return $input_qty;
                    })
                    ->addColumn('total_point', function ($row) {
                        $total_point = $row->reward->point * $row->qty;

                        return $total_point;
                    })
                    ->addColumn('action', function ($row) {
                        $actionBtn = '
                            <center>
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="deleteCart(' . $row->id . ')"><i class="fas fa-trash"></i></a>
                            </center>
                        ';

                        return $actionBtn;
                    })
                    ->rawColumns(['foto', 'action', 'nama', 'input_qty'])
                    ->make(true);
            } else {
            }
        }

        // reset cart
        Cart::where('user_id', Auth()->user()->id)->delete();

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
        // check if reward already in cart
        $cart = Cart::where('reward_id', $request->reward_id)
                    ->where('member_id', $request->member_id)
                    ->where('user_id', Auth()->user()->id)
                    ->first();
        if ($cart) {
            // jika ada request qty
            if ($request->qty) {
                // check total point member apakah cukup
                $total_point = $request->qty * Reward::find($request->reward_id)->point;
                if ($total_point > $request->total_point_member) {
                    return response()->json([
                        'status'    => false,
                        'message'     => 'Point member tidak cukup'
                    ]);
                }
                // update qty
                $cart->update([
                    'qty' => $request->qty,
                ]);
            } else {
                // check total point member apakah cukup
                $total_point = ($cart->qty + 1) * Reward::find($request->reward_id)->point;
                if ($total_point > $request->total_point_member) {
                    return response()->json([
                        'status'        => false,
                        'message'       => 'Point member tidak cukup'
                    ]);
                }
                // update qty
                $cart->update([
                    'qty'       => $cart->qty + 1,
                ]);
            }
        } else {
            // check total point member apakah cukup
            $total_point = 1 * Reward::find($request->reward_id)->point;
            if ($total_point > $request->total_point_member) {
                return response()->json([
                    'status'    => false,
                    'message'     => 'Point member tidak cukup'
                ]);
            }
            // add to cart
            Cart::create([
                'reward_id' => $request->reward_id,
                'qty'       => 1,
                'user_id'   => Auth()->user()->id,
                'member_id' => $request->member_id,
            ]);
        }

        return response()->json([
            'status'    => true,
            'success'   => 'Berhasil menambahkan reward ke keranjang'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        // delete cart
        Cart::where('id', $request->cart_id)
            ->where('user_id', Auth()->user()->id)
            ->delete();

        return response()->json([
            'status'    => true,
            'success'   => 'Berhasil menghapus reward dari keranjang'
        ]);
    }
}
