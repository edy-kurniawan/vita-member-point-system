<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kasir = User::where('role', 'kasir')->get();

        return view('setting.logs.index',[
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

            $data = Logs::with([
                'user:id,name'
                ])
                ->when($request->created_by != 'all', function ($query) use ($request) {
                    $query->where('created_by', $request->created_by);
                })
                ->when($request->start, function ($query) use ($request) {
                    $query->whereDate('created_at', '>=', date('Y-m-d', strtotime($request->start)))
                        ->whereDate('created_at', '<=', date('Y-m-d', strtotime($request->end)));
                })
                ->when($request->keyword, function ($query) use ($request) {
                    $query->where('text', 'like', '%'.$request->keyword.'%')->orWhere('body', 'like', '%'.$request->keyword.'%');
                })
                ->latest();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($row) {
                    $tanggal = date('d/m/Y H:i:s', strtotime($row->created_at));

                    return $tanggal;
                })
                ->make(true);
        }
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
