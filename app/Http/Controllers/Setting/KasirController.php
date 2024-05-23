<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();

        return view('setting.kasir.index',[
            'user' => $user
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
            'name'      => 'required|min:3|max:255',
            'username'  => 'required',
            'is_active' => 'required|in:1,0'
        ]);

        if($request->id) {
            $validated = $request->validate([
                'password'              => 'nullable|min:6',
                'password_confirmation' => 'nullable|same:password',
            ]);
        }

        User::updateOrCreate(['id' => $request->id], [
            'name'      => $request->name,
            'username'  => $request->username,
            'password'  => Hash::make($request->password),
            'is_active' => $request->is_active,
            'role'      => 'kasir'
        ]);

        return redirect()->route('kasir.index')->with('success', 'Data berhasil ditambahkan');
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
        return User::find($id);
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
        User::destroy($id);

        return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);

    }
}
