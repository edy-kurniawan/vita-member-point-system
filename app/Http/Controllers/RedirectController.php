<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\User;

class RedirectController extends Controller
{
    public function redirectDashboard()
    {
        // check is active
        if (Auth()->user()->is_active == '0') {
            abort(403, 'Akun anda tidak aktif, silahkan hubungi administrator');
        }

        // update last active
        User::where('id', Auth()->user()->id)->update(['last_active' => date('Y-m-d H:i:s')]);

        // save log
        Logs::create([
            'text'          => Auth()->user()->name . ' login ke aplikasi',
            'created_by'    => Auth()->user()->id,
            'body'          => json_encode(Auth()->user())
        ]);

        return redirect()->route('dashboard.index');
    }
}
