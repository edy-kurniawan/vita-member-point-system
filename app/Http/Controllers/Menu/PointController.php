<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Detail_transaksi_point;
use App\Models\Logs;
use App\Models\Member;
use App\Models\Reward;
use App\Models\Setting;
use App\Models\Transaksi_point;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\Datatables\Datatables;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //datatable
        if (request()->ajax()) {

            if ($request->type == 'transaksi') {

                $data = Transaksi_point::with([
                    'detail_transaksi',
                    'member',
                    'kasir'
                ])
                    ->when($request->start, function ($query) use ($request) {
                        $query->whereDate('tanggal_transaksi', '>=', date('Y-m-d', strtotime($request->start)))
                            ->whereDate('tanggal_transaksi', '<=', date('Y-m-d', strtotime($request->end)));
                    })
                    ->when($request->created_by != 'all', function ($query) use ($request) {
                        $query->where('transaksi_by', $request->created_by);
                    })
                    ->when($request->created_at, function ($query) use ($request) {
                        $query->whereDate('created_at', $request->created_at);
                    })
                    ->when($request->transaksi != 'all', function ($query) use ($request) {
                        $query->where('keterangan', $request->transaksi);
                    })
                    ->latest()
                    ->get();

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal_transaksi', function ($row) {
                        $tanggal = date('d/m/Y', strtotime($row->tanggal_transaksi));

                        return $tanggal;
                    })
                    ->addColumn('kode', function ($row) {
                        return '<a href="javascript:void(0)" onclick="modalTransaksi(' . $row->id . ')">' . $row->kode . '</a><small class="d-block text-muted">Kasir : ' . $row->kasir->name . '</small>';
                    })
                    ->addColumn('aksi', function ($row) {
                        // retur transaksi
                        $aksi = '
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="returButton(' . $row->id . ')"><i class="fas fa-backspace"></i></a>
                    ';

                        return $aksi;
                    })
                    ->rawColumns(['kode', 'aksi'])
                    ->make(true);
            } else {
            }
        }

        $kasir = User::where('role', 'kasir')->get();

        return view('menu.point.index', [
            'kasir' => $kasir
        ]);
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

        $kode = KodeTransaksi();

        return view('menu.point.create', [
            'kode' => $kode
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // pengumpulan point
        if ($request->type == "pengumpulan_point") {

            $validator = Validator::make($request->all(), [
                'member_id'         => 'required|exists:member,id',
                'total_pembelian'   => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => $validator->errors()
                ]);
            }

            DB::beginTransaction();

            try {

                // point from trx
                $point = Setting::where('key', 'point_from_trx')->first();
                $point = $point->value ?? 0;
                $point = $point / 100;

                // check total point
                $total_point = $request->total_pembelian * $point;

                // add point
                $kode = KodeTransaksi();

                Transaksi_point::create([
                    'kode'              => $kode,
                    'tanggal_transaksi' => date('Y-m-d'),
                    'member_id'         => $request->member_id,
                    'total_pembelian'   => $request->total_pembelian,
                    'total_point'       => $total_point,
                    'keterangan'        => 'Pengumpulan Point',
                    'transaksi_by'      => Auth()->user()->id,
                ]);

                Member::where('id', $request->member_id)->increment('total_point', $total_point);

                Logs::create([
                    'created_by'    => Auth()->user()->id,
                    'text'          => 'Pengumpulan Point Member ' . Member::find($request->member_id)->nama,
                    'body'          => json_encode($request->all()),
                ]);

                DB::commit();

                return response()->json([
                    'status'    => true,
                    'success'   => 'Data berhasil disimpan !'
                ]);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json([
                    'status'    => false,
                    'message'   => $e->getMessage()
                ]);
            }
        } else {

            $validator = Validator::make($request->all(), [
                'member_id'         => 'required|exists:member,id',
                'type'              => 'required|in:pengumpulan_point,penukaran_point',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => $validator->errors()
                ]);
            }

            DB::beginTransaction();

            try {

                // check total cart
                $total_cart = Cart::with(['reward'])
                    ->where('user_id', Auth()->user()->id)
                    ->where('member_id', $request->member_id)
                    ->get();

                if ($total_cart->count() == 0) {
                    return response()->json([
                        'status'    => false,
                        'message'   => 'Keranjang masih kosong'
                    ]);
                }

                // check total point
                $total_point = 0;
                foreach ($total_cart as $cart) {
                    $total_point += $cart->reward->point * $cart->qty;
                }

                // check total point member
                $member = Member::find($request->member_id);
                if ($total_point > $member->total_point) {
                    return response()->json([
                        'status'    => false,
                        'message'   => 'Point member tidak cukup'
                    ]);
                }

                // - point member
                Member::where('id', $request->member_id)->decrement('total_point', $total_point);

                // save transaksi point
                $kode = KodeTransaksi();

                $total_point = 0 - $total_point;

                $transaksi = Transaksi_point::create([
                    'kode'              => $kode,
                    'tanggal_transaksi' => date('Y-m-d'),
                    'member_id'         => $request->member_id,
                    'total_pembelian'   => 0,
                    'total_point'       => $total_point,
                    'keterangan'        => 'Penukaran Point',
                    'transaksi_by'      => Auth()->user()->id,
                ]);

                // loop cart insert to detail transaksi point
                foreach ($total_cart as $cart) {
                    Detail_transaksi_point::create([
                        'transaksi_point_id'    => $transaksi->id,
                        'reward_id'             => $cart->reward_id,
                        'qty'                   => $cart->qty,
                        'point'                 => $cart->reward->point * $cart->qty,
                    ]);
                }

                // delete cart
                Cart::where('user_id', Auth()->user()->id)->where('member_id', $request->member_id)->delete();

                Logs::create([
                    'created_by'    => Auth()->user()->id,
                    'text'          => 'Penukaran Point Member ' . $member->nama,
                    'body'          => json_encode($request->all()),
                ]);

                DB::commit();

                return response()->json([
                    'status'    => true,
                    'success'   => 'Data berhasil disimpan !'
                ]);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json([
                    'status'    => false,
                    'message'   => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // point from trx
        $point = Setting::where('key', 'point_from_trx')->first();
        $point = $point->value ?? 0;
        $point = $point / 100;
        $kode = KodeTransaksi();

        return view('menu.point.show', [
            'point' => $point,
            'kode'  => $kode
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        if ($request->type == 'transaksi') {

            $data = Transaksi_point::with([
                'detail_transaksi.reward',
                'member',
                'kasir'
            ])->find($id);

            return response()->json([
                'status'    => true,
                'data'      => $data
            ]);
        } else {

            DB::beginTransaction();

            try {

                // retur transaksi
                $transaksi = Transaksi_point::find($id);
                $member = Member::find($transaksi->member_id);

                // + point member
                Member::where('id', $transaksi->member_id)->increment('total_point', $transaksi->total_point);

                // delete detail transaksi
                Detail_transaksi_point::where('transaksi_point_id', $transaksi->id)->delete();

                // save log
                Logs::create([
                    'created_by'    => Auth()->user()->id,
                    'text'          => 'Retur Transaksi Point Member ' . $member->nama,
                    'body'          => json_encode($transaksi),
                ]);

                // delete transaksi
                $transaksi->delete();

                DB::commit();

                return response()->json([
                    'status'    => true,
                    'success'   => 'Berhasil menghapus transaksi'
                ]);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json([
                    'status'    => false,
                    'message'   => $e->getMessage()
                ]);
            }
        }
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
