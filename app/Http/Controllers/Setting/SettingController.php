<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $point_from_trx         = Setting::where('key', 'point_from_trx')->first();
        $range_expired_member   = Setting::where('key', 'range_expired_member')->first();

        return view('setting.setting.index',[
            'point_from_trx'        => $point_from_trx,
            'range_expired_member'  => $range_expired_member
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
        $validated = $request->validate([
            'point_from_trx'        => 'required|numeric|min:0|max:100',
            'range_expired_member'  => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {

            Setting::updateOrCreate(['key' => 'point_from_trx'], [
                'value' => $request->point_from_trx
            ]);

            Setting::updateOrCreate(['key' => 'range_expired_member'], [
                'value' => $request->range_expired_member
            ]);

            // add logs
            $text = 'Mengubah setting point dari transaksi menjadi ' . $request->point_from_trx . ' dan range expired member menjadi ' . $request->range_expired_member;
            Logs::create([
                'text'       => $text,
                'created_by' => auth()->user()->id,
                'body'       => json_encode($request->all())
            ]);

            DB::commit();

            return redirect()->route('setting.index')->with('success', 'Data berhasil disimpan !');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('setting.index')->with('error', 'Data gagal disimpan !');
        }

        return redirect()->route('setting.index')->with('success', 'Data berhasil diubah !');
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
