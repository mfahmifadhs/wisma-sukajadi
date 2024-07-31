<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BukutamuController extends Controller
{
    public function index()
    {
        $tamu = BukuTamu::get();
        return view('pages.buku_tamu.show', compact('tamu'));
    }

    public function create()
    {
        return view('pages.buku_tamu.create');
    }

    public function store(Request $request)
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

        if (Auth::user()) {
            return redirect()->route('buku_tamu.show')->with('success', 'Berhasil mengisi buku tamu');
        } else {
            return view('m_buku_tamu')->with('success', 'Berhasil mengisi buku tamu');
        }
    }

    public function edit($id)
    {
        $tamu = BukuTamu::where('id_tamu', $id)->first();
        return view('pages.buku_tamu.show', compact('tamu'));
    }

    public function update(Request $request, $id)
    {
        BukuTamu::where('id_tamu', $id)->update([
            'nama_tamu'     => $request->nama_tamu,
            'no_hp'         => $request->no_hp,
            'instansi'      => $request->instansi,
            'nama_instansi' => $request->nama_instansi,
            'no_kendaraan'  => $request->no_kendaraan,
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()->route('buku_tamu.show')->with('success', 'Berhasil memperbaharui informasi');
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return redirect()->route('user.show')->with('success', 'Berhasil menghapus data tamu');
    }
}
