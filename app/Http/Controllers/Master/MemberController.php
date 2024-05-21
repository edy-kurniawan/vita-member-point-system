<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Province;
use App\Models\Setting;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //datatable
        if (request()->ajax()) {

            $data = Member::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal_berlaku', function ($row) {
                    return date('d-m-Y', strtotime($row->tanggal_registrasi)) . ' s/d ' . date('d-m-Y', strtotime($row->tanggal_berlaku));
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                            <center>
                                <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editMember"><i class="fas fa-edit"></i></a>
                                <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteMember"><i class="fas fa-trash"></i></a>
                            </center>
                        ';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $province = Province::select('id', 'name')->get();

        return view('master.member.index',[
            'provinsi' => $province
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
        $validator = Validator::make($request->all(), [
            'nama'              => 'required',
            'jenis_kelamin'     => 'required|in:L,P',
            'no_hp'             => 'required|numeric|digits_between:10,13',
            'alamat'            => 'required',
            'provinsi_id'       => 'required|numeric',
            'kabupaten_id'      => 'required|numeric',
            'kecamatan_id'      => 'required|numeric',
            'kelurahan_id'      => 'required|numeric',
            'tanggal_registrasi' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // cari range tanggal expired
        $range = Setting::where('key', 'range_expired_member')->first();

        $tanggal_expired = date('Y-m-d', strtotime($request->tanggal_registrasi . ' + ' . $range->value . ' days'));

        Member::updateOrCreate(['id' => $request->id], [
            'kode'              => $request->kode,
            'foto'              => 'default.jpg', //default image 'default.jpg
            'tanggal_lahir'     => $request->tanggal_lahir,
            'nama'              => $request->nama,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'no_hp'             => $request->no_hp,
            'alamat'            => $request->alamat,
            'provinsi_id'       => $request->provinsi_id,
            'kabupaten_id'      => $request->kabupaten_id,
            'kecamatan_id'      => $request->kecamatan_id,
            'kelurahan_id'      => $request->kelurahan_id,
            'tanggal_registrasi' => $request->tanggal_registrasi,
            'keterangan'        => $request->keterangan,
            'tanggal_expired'   => $tanggal_expired,
            'total_point'       => 0,
            'register_by'       => 'admin',
        ]);

        return response()->json(['success' => 'Data berhasil disimpan.']);
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
