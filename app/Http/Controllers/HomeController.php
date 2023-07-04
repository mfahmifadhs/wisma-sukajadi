<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        //
    }

    public function showTentang()
    {
        //
    }

    public function showBukuTamu()
    {
        return view('home.buku_tamu.show');
    }

    public function storeBukuTamu(Request $request)
    {
        $tambah = new BukuTamu();
        $tambah->nama_tamu     = ucwords($request->input('nama_tamu'));
        $tambah->no_hp         = $request->input('no_hp');
        $tambah->instansi      = ucwords($request->input('instansi'));
        $tambah->nama_instansi = ucwords($request->input('nama_instansi'));
        $tambah->no_kendaraan  = strtoupper($request->input('no_kendaraan'));
        $tambah->keterangan    = $request->input('keterangan');
        $tambah->created_at    = Carbon::now();
        $tambah->save();

        return redirect()->route('home.buku_tamu')->with('success', 'Terima kasih telah mengisi buku tamu');
    }
}
