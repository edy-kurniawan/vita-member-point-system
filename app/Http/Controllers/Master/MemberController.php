<?php

namespace App\Http\Controllers\Master;

use App\Exports\MemberExport;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Province;
use App\Models\Setting;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Logs;
use App\Models\Transaksi_point;

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
                    return date('d-m-Y', strtotime($row->tanggal_registrasi)) . ' s/d ' . date('d-m-Y', strtotime($row->tanggal_expired));
                })
                ->addColumn('jenis_kelamin', function ($row) {
                    if ($row->jenis_kelamin == 'L') {
                        $badge = '<span class="badge badge-pill badge-soft-danger font-size-11">Laki-laki</span>';
                    } else {
                        $badge = '<span class="badge badge-pill badge-soft-primary font-size-11">Perempuan</span>';
                    }

                    return $badge;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                            <center>
                                <a href="https://wa.me/' . $row->no_hp . '" target="_blank" class="btn btn-success btn-sm"><i class="fab fa-whatsapp"></i></a>
                                <a href="/member/' . $row->id . '" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                            </center>
                        ';

                    return $actionBtn;
                })
                ->rawColumns(['action', 'jenis_kelamin'])
                ->make(true);
        }

        $province = Province::select('id', 'name')->get();

        $kode = $this->generate_kode_member();

        return view('master.member.index', [
            'provinsi' => $province,
            'kode'     => $kode
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Excel::download(new MemberExport, 'data_member' . date('Ymdhis') . '.xlsx');
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

        DB::beginTransaction();

        try {

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

            // add log
            if ($request->id) {
                $text = 'Mengubah data member ' . $request->nama . ' (' . $request->kode . ')';
            } else {
                $text = 'Menambah data member ' . $request->nama . ' (' . $request->kode . ')';
            }

            Logs::create([
                'text'       => $text,
                'created_by' => auth()->user()->id,
                'body'       => json_encode($request->all())
            ]);

            DB::commit();

            return response()->json(['status' => true, 'message' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => false, 'message' => 'Data gagal disimpan']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = Member::with([
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan'
        ])
        ->where('id', $id)
        ->firstOrFail();

        $province = Province::select('id', 'name')->get();

        $pengumpulan_point = Transaksi_point::where('member_id', $id)->where('total_point', '>', 0)->count();
        $penukaran_point = Transaksi_point::where('member_id', $id)->where('total_point', '<', 0)->count();
        $transaksi = Transaksi_point::with(['kasir'])->where('member_id', $id)->latest()->get();

        return view('master.member.detail', [
            'member'    => $member,
            'provinsi'  => $province,
            'pengumpulan_point' => $pengumpulan_point,
            'penukaran_point'   => $penukaran_point,
            'transaksi'         => $transaksi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        $data = Member::select('id', 'kode', 'nama as text', 'total_point', 'tanggal_expired')
            ->where('kode', 'like', '%' . $request->get('keyword') . '%')
            ->where('tanggal_expired', '>=', date('Y-m-d'))
            ->orWhere('nama', 'like', '%' . $request->get('keyword') . '%')
            ->where('tanggal_expired', '>=', date('Y-m-d'))
            ->orderBy('nama')
            ->limit(5)
            ->get();

        return response()->json($data);
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
        // check transaksi
        $transaksi = Transaksi_point::where('member_id', $id)->count();
        if ($transaksi > 0) {
            return response()->json(['status' => false, 'message' => 'Data tidak dapat dihapus karena sudah ada transaksi']);
        }

        $member = Member::find($id);
        $member->delete();
        return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
    }

    public function generate_kode_member()
    {
        // get last member
        $last_member = Member::orderBy('kode', 'desc')->first();

        // check kode member
        if ($last_member) {
            $kode = $last_member->kode + 1;
        } else {
            $kode = 1;
        }

        // check length kode
        if (strlen($kode) == 1) {
            $kode = '0000' . $kode;
        } elseif (strlen($kode) == 2) {
            $kode = '000' . $kode;
        } elseif (strlen($kode) == 3) {
            $kode = '00' . $kode;
        }elseif (strlen($kode) == 4) {
            $kode = '0' . $kode;
        }else{
            $kode = '00001';
        }

        return $kode;
    }
}
