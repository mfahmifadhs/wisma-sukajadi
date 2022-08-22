<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\SukajadiController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PnbpController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

// Authentication
Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('halaman-masuk', [AuthController::class, 'index'])->name('halamanMasuk');
Route::get('halaman-daftar', [AuthController::class, 'Pendaftaran'])->name('halamanDaftar');

Route::post('masuk', [AuthController::class, 'Masuk'])->name('masuk'); 
Route::post('daftar', [AuthController::class, 'Daftar'])->name('daftar'); 
Route::get('keluar', [AuthController::class, 'Keluar'])->name('keluar');

Route::group(['prefix' => 'beranda', 'as' => 'beranda.'], 
    function () {
        Route::get('masuk', function() { return view('auth.masuk'); });
        Route::get('tentang', function() { return view('m_tentang'); });
        Route::get('kamar/{id}', [MainController::class, 'menuRoom']);
        Route::get('tarif-sewa/{id}', [MainController::class, 'menuRoom']);
        Route::get('kunjungan/{id}', [MainController::class, 'menuVisit']);
        
        Route::post('kunjungan/{id}', [MainController::class, 'menuVisit']);

        Route::get('detail_kamar', function() { return view('m_detail_kamar'); });
        Route::get('testimoni', function() { return view('m_testimoni'); });
        Route::get('faq', function() { return view('m_faq'); });
        Route::get('kontak', function() { return view('m_kontak'); });
    });


Route::group(['middleware' => ['role:admin-master'], 'prefix' => 'admin-master', 'as' => 'admin-master.'], function () {

    Route::get('dashboard', [MasterController::class, 'index']);
    Route::get('laporan/{id}', [MasterController::class, 'showReport']);
    Route::get('pengguna/{aksi}/{id}', [MasterController::class, 'showUser']);
    Route::get('detail/{aksi}/{id}', [MasterController::class, 'showDetail']);
    Route::get('reservasi/{aksi}/{id}', [MasterController::class, 'showReservation']);
    Route::get('pendapatan/{aksi}/{id}', [MasterController::class, 'showIncome']);
    Route::get('kamar/{aksi}/{id}', [MasterController::class, 'showRoom']);
    Route::get('kwitansi/{aksi}/{id}', [MasterController::class, 'showReceipt']);


    Route::get('reservasi/{aksi}/{id}', [MasterController::class, 'showReservation']);
    Route::get('pendapatan/{aksi}/{id}', [MasterController::class, 'showIncome']);
    Route::get('kamar/{aksi}/{id}', [MasterController::class, 'showRoom']);
    Route::post('pengguna/{aksi}/{id}', [MasterController::class, 'showUser']);
    Route::post('laporan/{id}', [MasterController::class, 'showReport']);
    Route::get('chart-visitor', [MasterController::class,'getChartVisitor']);
    Route::get('chart-income', [MasterController::class,'getChartIncome']);
    
});

Route::group(['middleware' => ['role:admin-pnbp'], 'prefix' => 'admin-pnbp', 'as' => 'admin-pnbp.'], function () {

    Route::get('dashboard', [PnbpController::class, 'index']);
    Route::get('laporan/{id}', [PnbpController::class, 'showReport']);
    Route::get('pengguna/{aksi}/{id}', [PnbpController::class, 'showUser']);
    Route::get('detail/{aksi}/{id}', [PnbpController::class, 'showDetail']);
    Route::get('reservasi/{aksi}/{id}', [PnbpController::class, 'showReservation']);
    Route::get('pendapatan/{aksi}/{id}', [PnbpController::class, 'showIncome']);
    Route::get('kamar/{aksi}/{id}', [PnbpController::class, 'showRoom']);
    Route::get('kwitansi/{aksi}/{id}', [PnbpController::class, 'showReceipt']);


    Route::post('reservasi/{aksi}/{id}', [PnbpController::class, 'showReservation']);
    Route::post('pendapatan/{aksi}/{id}', [PnbpController::class, 'showIncome']);
    Route::post('kamar/{aksi}/{id}', [PnbpController::class, 'showRoom']);
    Route::post('pengguna/{aksi}/{id}', [PnbpController::class, 'showUser']);
    Route::post('laporan/{id}', [PnbpController::class, 'showReport']);
    Route::get('chart-visitor', [PnbpController::class,'getChartVisitor']);
    Route::get('chart-income', [PnbpController::class,'getChartIncome']);
    
});

Route::group(['middleware' => ['role:admin-sukajadi'], 'prefix' => 'admin-sukajadi', 'as' => 'admin-sukajadi.'], function () {

    Route::get('dashboard', [SukajadiController::class, 'index']);
    Route::get('profil/{id}', [SukajadiController::class, 'showProfile']);
    Route::get('buku-tamu', [SukajadiController::class, 'showVisit']);
    Route::get('check-in', [SukajadiController::class, 'createCheckin']);
    Route::get('pendapatan', [SukajadiController::class, 'showIncome']);
    Route::get('kamar/{id}', [SukajadiController::class, 'menuRoom']);
    Route::get('pnbp/{id}', [SukajadiController::class, 'menuPnbp']);
    Route::get('detail-pendapatan/{id}', [SukajadiController::class, 'detailIncome']);
    Route::get('reservasi/{id}', [SukajadiController::class, 'menuReservation']);
    Route::get('kamar/{aksi}/{id}', [SukajadiController::class, 'detailRoom']);
    Route::get('reservasi/{proses}/{id}', [SukajadiController::class, 'processReservation']);
    Route::get('kwitansi/{aksi}/{id}', [SukajadiController::class, 'showReceipt']);

    Route::post('pendapatan', [SukajadiController::class, 'showIncome']);
    Route::post('pnbp/{id}', [SukajadiController::class, 'menuPnbp']);
    Route::post('kamar/{id}', [SukajadiController::class, 'menuRoom']);
    Route::post('kamar/{aksi}/{id}', [SukajadiController::class, 'detailRoom']);
    Route::post('reservasi/{proses}/{id}', [SukajadiController::class, 'processReservation']);
    Route::post('tambah-reservasi', [SukajadiController::class, 'postReservation']);
    Route::get('json-get-room', [SukajadiController::class, 'jsonGetRoom']);
    Route::get('json-get-category', [SukajadiController::class, 'jsonGetCategory']);
    Route::get('json-get-price', [SukajadiController::class, 'jsonGetPrice']);
    Route::get('chart-visitor', [SukajadiController::class,'getChartVisitor']);
    
});
