
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukutamuController;
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

Route::get('/info', function () {
    return view('pages.info');
});

// Authentication
// Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::get('halaman-masuk', [AuthController::class, 'index'])->name('login');
Route::get('halaman-daftar', [AuthController::class, 'Pendaftaran'])->name('halamanDaftar');
Route::get('auth/sso/redirect', [AuthController::class, 'redirect']);
Route::get('auth/sso/callback', [AuthController::class, 'callback']);

Route::post('masuk', [AuthController::class, 'Masuk'])->name('masuk');
Route::post('masuk/pegawai', [AuthController::class, 'Masuk'])->name('masuk');
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




use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\UnitkerjaController;
use App\Http\Controllers\UnitutamaController;
// HOME

Route::get('masuk', function() { return view('auth.masuk'); });
Route::get('tentang', function() { return view('m_tentang'); });
Route::get('kamar/{id}', [MainController::class, 'menuRoom']);
Route::get('tarif-sewa/{id}', [MainController::class, 'menuRoom']);
// Route::get('buku-tamu', [HomeController::class, 'showBukuTamu'])->name('home.buku_tamu');


// Route::post('buku-tamu', [HomeController::class, 'storeBukuTamu'])->name('home.buku_tamu');
Route::post('buku-tamu/tambah', [BukutamuController::class, 'store'])->name('buku_tamu.store');

Route::get('detail_kamar', function() { return view('m_detail_kamar'); });
Route::get('testimoni', function() { return view('m_testimoni'); });
Route::get('faq', function() { return view('m_faq'); });
Route::get('kontak', function() { return view('m_kontak'); });

// DASHBOARD
Route::group(['middleware' => 'auth'], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('pendapatan', [DashboardController::class, 'showPendapatan'])->name('pendapatan');

    // akses oleh admin
    Route::group(['middleware' => ['access:admin']], function () {

        Route::get('reservasi/tambah/{id}', [ReservasiController::class, 'create'])->name('reservasi.tambah');
        Route::get('reservasi/edit/{id}', [ReservasiController::class, 'edit'])->name('reservasi.edit');
        Route::get('kamar/select', [KamarController::class, 'selectKamar']);
        Route::post('kamar/select', [KamarController::class, 'selectKamar']);
        Route::post('reservasi/tambah', [ReservasiController::class, 'store'])->name('reservasi.store');
        Route::post('reservasi/update/{id}', [ReservasiController::class, 'update'])->name('reservasi.update');

    });

    // Akses super admin, super user, admin
    Route::group(['middleware' => ['access:public']], function () {
        // Buku Tamu
        Route::get('buku-tamu', [BukutamuController::class, 'index'])->name('buku_tamu.show');

        // Laporan
        Route::get('laporan/{id}', [LaporanController::class, 'index'])->name('laporan.show');
        Route::post('laporan/{id}', [LaporanController::class, 'index'])->name('laporan.show');
        // Reservasi
        Route::get('reservasi', [ReservasiController::class, 'show'])->name('reservasi.show');
        Route::get('reservasi/{id}', [ReservasiController::class, 'detail'])->name('reservasi.detail');
        Route::get('reservasi/kwitansi/cetak/{id}', [ReservasiController::class, 'print'])->name('reservasi.kwitansi');
        Route::post('reservasi', [ReservasiController::class, 'index'])->name('reservasi.show');
        // Kamar
        Route::get('kamar/{id}', [KamarController::class, 'show'])->name('kamar');
        Route::get('kamar/detail/{id}', [KamarController::class, 'detail'])->name('kamar.detail');
        Route::post('kamar/edit/{id}', [KamarController::class, 'update'])->name('kamar.edit');

    });

    // Akses super admin
    Route::group(['middleware' => ['access:private']], function () {
        // Hapus usulan
        Route::get('reservasi/hapus/{id}', [ReservasiController::class, 'destroy'])->name('reservasi.delete');
        // User atau pengguna
        Route::get('pengguna', [UserController::class, 'show'])->name('user.show');
        Route::get('pengguna/detail/{id}', [UserController::class, 'detail'])->name('user.detail');
        Route::get('pengguna/tambah', [UserController::class, 'create'])->name('user.create');
        Route::get('pengguna/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::get('pengguna/hapus/{id}', [UserController::class, 'delete'])->name('user.delete');
        Route::post('pengguna/tambah', [UserController::class, 'store'])->name('user.post');
        Route::post('pengguna/edit/{id}', [UserController::class, 'update'])->name('user.edit');

        // Pegawai
        Route::get('pegawai', [PegawaiController::class, 'show'])->name('pegawai.show');
        Route::get('pegawai/select/{id}', [PegawaiController::class, 'selectPegawai']);
        Route::get('pegawai/detail/{id}', [PegawaiController::class, 'detail'])->name('pegawai.detail');
        Route::get('pegawai/tambah', [PegawaiController::class, 'create'])->name('pegawai.create');
        Route::get('pegawai/edit/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::get('pegawai/hapus/{id}', [PegawaiController::class, 'delete'])->name('pegawai.delete');
        Route::post('pegawai/tambah', [PegawaiController::class, 'store'])->name('pegawai.post');
        Route::post('pegawai/edit/{id}', [PegawaiController::class, 'update'])->name('pegawai.edit');

        // Unit Kerja
        Route::get('unit-kerja', [UnitkerjaController::class, 'show'])->name('unit_kerja.show');
        Route::get('unit-kerja/tambah', [UnitkerjaController::class, 'create'])->name('unit_kerja.create');
        Route::get('unit-kerja/edit/{id}', [UnitkerjaController::class, 'edit'])->name('unit_kerja.edit');
        Route::get('unit-kerja/hapus/{id}', [UnitkerjaController::class, 'delete'])->name('unit_kerja.delete');
        Route::post('unit-kerja/tambah', [UnitkerjaController::class, 'store'])->name('unit_kerja.store');
        Route::post('unit-kerja/edit/{id}', [UnitkerjaController::class, 'update'])->name('unit_kerja.edit');
        Route::post('unit-kerja/select', [UnitkerjaController::class, 'selectUnitkerja']);

        // Unit Utama
        Route::get('unit-utama', [UnitutamaController::class, 'show'])->name('unit_utama.show');
        Route::get('unit-utama/tambah', [UnitutamaController::class, 'create'])->name('unit_utama.create');
        Route::get('unit-utama/edit/{id}', [UnitutamaController::class, 'edit'])->name('unit_utama.edit');
        Route::get('unit-utama/hapus/{id}', [UnitutamaController::class, 'delete'])->name('unit_utama.delete');
        Route::post('unit-utama/tambah', [UnitutamaController::class, 'store'])->name('unit_utama.store');
        Route::post('unit-utama/edit/{id}', [UnitutamaController::class, 'update'])->name('unit_utama.edit');
    });
});


