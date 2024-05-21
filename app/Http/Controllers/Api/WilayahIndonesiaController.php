<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;

class WilayahIndonesiaController extends Controller
{
    function getProvince()
    {
        $provinces = Province::select('id','name')->get();
        return response()->json($provinces);
    }

    function getRegency(Request $request)
    {
        $regencies = Regency::where('province_id', $request->province_id)->get();
        return response()->json($regencies);
    }

    function getDistrict(Request $request)
    {
        $districts = District::where('regency_id', $request->regency_id)->get();
        return response()->json($districts);
    }

    function getVillage(Request $request)
    {
        $villages = Village::where('district_id', $request->district_id)->get();
        return response()->json($villages);
    }
}
