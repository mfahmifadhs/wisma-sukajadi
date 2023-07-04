<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use App\Models\UnitUtama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitkerjaController extends Controller
{
    public function show()
    {
        $unitKerja = UnitKerja::get();
        return view('pages.unit_kerja.show', compact('unitKerja'));
    }

    public function selectUnitkerja(Request $request)
    {
        $search = $request->search;

        if($search == ''){
            $unitKerja = UnitKerja::orderBy('nama_unit_kerja','ASC')->get();
        }else{
            $unitKerja = UnitKerja::orderBy('nama_unit_kerja','ASC')->where('nama_unit_kerja', 'like', '%' .$search . '%')->get();
        }

        $response = array();
        foreach($unitKerja as $data){
            $response[] = array(
                "id"    =>  $data->id_unit_kerja,
                "text"  =>  strtoupper($data->nama_unit_kerja)
            );
        }

        return response()->json($response);
    }

    public function create()
    {
        $unitUtama = UnitUtama::orderBy('nama_unit_utama','ASC')->get();
        return view('pages.unit_kerja.create', compact('unitUtama'));
    }

    public function edit ($id)
    {
        $unitUtama = UnitUtama::orderBy('nama_unit_utama','ASC')->get();
        $unitKerja = UnitKerja::where('id_unit_kerja', $id)->first();
        return view('pages.unit_kerja.edit', compact('unitUtama','unitKerja'));
    }

    public function store(Request $request)
    {
        $tambah = new UnitKerja();
        $tambah->unit_utama_id   = $request->unit_utama_id;
        $tambah->kode_unit_kerja = $request->kode_unit_kerja;
        $tambah->nama_unit_kerja = $request->nama_unit_kerja;
        $tambah->save();

        return redirect()->route('unit_kerja.show')->with('success', 'Berhasil Menambah Baru');
    }

    public function update(Request $request, $id)
    {
        $nilai = str_replace(".", "", $request->alokasi_anggaran);
        $nilai = (int) $nilai;

        UnitKerja::where('id_unit_kerja', $id)->update([
            'unit_utama_id'    => $request->unit_utama_id,
            'kode_unit_kerja'  => $request->kode_unit_kerja,
            'nama_unit_kerja'  => $request->nama_unit_kerja,
            'alokasi_anggaran' => $nilai
        ]);

        return redirect()->route('unit_kerja.edit', $id)->with('success', 'Berhasil Memperbaharui');
    }

    public function delete($id)
    {
        UnitKerja::where('id_unit_kerja',$id)->delete();

        return redirect()->route('unit_kerja.show')->with('success', 'Berhasil Menghapus');
    }
}
