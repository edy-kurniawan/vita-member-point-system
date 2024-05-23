<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

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
                    $foto = '<a href="' . asset('storage/images/reward/' . $row->foto) . '" target="_blank"><img src="' . asset('storage/images/reward/' . $row->foto) . '" width="50px" height="50px"></a>';

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
                ->rawColumns(['foto','action'])
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
        if($request->id){
            
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
                // upload foto baru
                $imageName = time() . '.' . $request->foto->extension();
                $request->foto->storeAs('public/images/reward', $imageName);
                $reward->foto = $imageName;
    
                // hapus foto lama
                $oldImage = 'storage/images/reward/' . $reward->foto;
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }else{
                $imageName = $reward->foto;
            }
    
            Reward::where('id', $request->id)->update([
                'kode'              => $request->kode,
                'nama'              => $request->nama,
                'point'             => $request->point,
                'foto'              => $imageName,
                'keterangan'        => $request->keterangan,
            ]);
    
            return response()->json(['status' => true, 'message' => 'Data berhasil diupdate']);

        }else{

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
                $imageName = time() . '.' . $request->foto->extension();
                $request->foto->storeAs('public/images/reward', $imageName);
            }
    
            Reward::updateOrCreate(['id' => $request->id], [
                'kode'              => $request->kode,
                'nama'              => $request->nama,
                'point'             => $request->point,
                'foto'              => $imageName,
                'keterangan'        => $request->keterangan,
            ]);
    
            return response()->json(['status' => true, 'message' => 'Data berhasil disimpan']);

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
        $reward = Reward::find($id);
        // remove image in storage
        $image = 'storage/images/reward/' . $reward->foto;

        if (file_exists($image)) {
            unlink($image);
        }

        $reward->delete();

        return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
    }
}
