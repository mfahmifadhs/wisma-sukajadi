<?php

namespace App\Http\Controllers;

use App\Models\KritikSaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KritikSaranController extends Controller
{
    public function show()
    {
        $data = KritikSaran::get();
        return view('pages.kritik_saran.show', compact('data'));
    }

    public function store(Request $request)
    {
        $id = KritikSaran::withoutTrashed()->count();

        $tambah = new KritikSaran();
        $tambah->id_kritik_saran = $id + 1;
        $tambah->nama            = $request->nama;
        $tambah->no_hp           = $request->no_hp;
        $tambah->tgl_menginap    = $request->tgl_menginap;
        $tambah->no_kamar        = $request->no_kamar;
        $tambah->pesan           = $request->pesan;
        $tambah->created_at      = Carbon::now();
        $tambah->save();

        return view('m_kontak')->with('success', 'Berhasil Mengirim Kritik dan Saran');
    }
}
