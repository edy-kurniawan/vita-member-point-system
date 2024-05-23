<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Menu\DashboardController;
use App\Http\Controllers\Menu\PointController;

use App\Http\Controllers\Master\MemberController;
use App\Http\Controllers\Master\RewardController;

use App\Http\Controllers\Setting\KasirController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\Setting\LogController;

use App\Http\Controllers\Api\WilayahIndonesiaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('dashboard', DashboardController::class);
Route::resource('point', PointController::class);
Route::resource('member', MemberController::class);
Route::resource('reward', RewardController::class);
Route::resource('kasir', KasirController::class);
Route::resource('setting', SettingController::class);
Route::resource('log', LogController::class);

// route group prefix api
Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
    // Route get provinsi
    Route::get('provinsi', [WilayahIndonesiaController::class, 'getProvince'])->name('provinsi');
    // Route get kabupaten
    Route::get('kabupaten', [WilayahIndonesiaController::class, 'getRegency'])->name('kabupaten');
    // Route get kecamatan
    Route::get('kecamatan', [WilayahIndonesiaController::class, 'getDistrict'])->name('kecamatan');
    // Route get kelurahan
    Route::get('kelurahan', [WilayahIndonesiaController::class, 'getVillage'])->name('kelurahan');
});

Route::get('/', function () {
    return view('layouts.template');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
