<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Detail_transaksi_point;
use App\Models\Reward;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Logs;
use App\Models\Transaksi_point;
use Intervention\Image\Facades\Image;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //datatable
        if (request()->ajax()) {

            $data = Reward::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('foto', function ($row) {
                    $foto = '<center><a href="' . asset('storage/images/reward/' . $row->foto) . '" target="_blank"><img src="' . asset('storage/images/reward/' . $row->foto) . '" width="50px" height="50px"></a></center>';

                    return $foto;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                            <center>
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="editButton(' . $row->id . ')"><i class="fas fa-edit"></i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteButton(' . $row->id . ')"><i class="fas fa-trash"></i></a>
                            </center>
                        ';

                    return $actionBtn;
                })
                ->rawColumns(['foto', 'action'])
                ->make(true);
        }


        return view('master.reward.index');
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
        if ($request->id) {

            $validator = Validator::make($request->all(), [
                'nama'              => 'required',
                'kode'              => 'required|numeric',
                'point'             => 'required|numeric|min:1',
                'foto'              => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            $reward = Reward::find($request->id);

            if ($request->hasFile('foto')) {
                // resize foto
                $img = Image::make($request->foto->path());
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('storage/images/reward/' . time() . '.' . $request->foto->extension());

                $imageName = time() . '.' . $request->foto->extension();

                // hapus foto lama
                $oldImage = 'storage/images/reward/' . $reward->foto;
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            } else {
                $imageName = $reward->foto;
            }

            DB::beginTransaction();

            try {

                Reward::where('id', $request->id)->update([
                    'kode'              => $request->kode,
                    'nama'              => $request->nama,
                    'point'             => $request->point,
                    'foto'              => $imageName,
                    'keterangan'        => $request->keterangan,
                ]);

                // add log
                $text = 'Mengubah data reward ' . $request->nama . ' (' . $request->kode . ')';
                Logs::create([
                    'text'       => $text,
                    'created_by' => auth()->user()->id,
                    'body'       => json_encode($request->all())
                ]);

                DB::commit();
                return response()->json(['status' => true, 'message' => 'Data berhasil diupdate']);
            } catch (\Exception $e) {

                DB::rollback();

                return response()->json(['status' => false, 'message' => 'Data gagal diupdate !']);
            }
        } else {

            $validator = Validator::make($request->all(), [
                'nama'              => 'required',
                'kode'              => 'required|numeric',
                'point'             => 'required|numeric|min:1',
                'foto'              => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            if ($request->hasFile('foto')) {
                // resize foto
                $img = Image::make($request->foto->path());
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('storage/images/reward/' . time() . '.' . $request->foto->extension());

                $imageName = time() . '.' . $request->foto->extension();
            }

            DB::beginTransaction();

            try {

                Reward::updateOrCreate(['id' => $request->id], [
                    'kode'              => $request->kode,
                    'nama'              => $request->nama,
                    'point'             => $request->point,
                    'foto'              => $imageName,
                    'keterangan'        => $request->keterangan,
                ]);

                // add log
                $text = 'Menambah data reward ' . $request->nama . ' (' . $request->kode . ')';
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Reward::find($id));
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
        // check transaksi
        $transaksi = Detail_transaksi_point::where('reward_id', $id)->first();
        if ($transaksi) {
            return response()->json(['status' => false, 'message' => 'Data tidak bisa dihapus, karena sudah digunakan di transaksi']);
        }

        $reward = Reward::find($id);
        // remove image in storage
        $image = 'storage/images/reward/' . $reward->foto;

        if (file_exists($image)) {
            unlink($image);
        }

        $reward->delete();

        // add log
        $text = 'Menghapus data reward ' . $reward->nama . ' (' . $reward->kode . ')';

        Logs::create([
            'text'       => $text,
            'created_by' => auth()->user()->id
        ]);

        return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
    }
}
