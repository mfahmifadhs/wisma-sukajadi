<?php

namespace App\Http\Controllers;

use App\Model\submissionModel;
use App\Models\Pegawai;
use App\Models\Status;
use App\Models\UnitKerja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    public function show()
    {
        $pegawai = Pegawai::get();
        return view('pages.pegawai.show', compact('pegawai'));
    }

    public function selectPegawai($id)
    {
        $result = Pegawai::where('unit_kerja_id', $id)->get();
        return response()->json($result);
    }

    public function create()
    {
        $unitKerja = UnitKerja::orderBy('nama_unit_kerja','ASC')->get();
        $status    = Status::where('kategori','pegawai')->get();

        return view('pages.pegawai.create', compact('unitKerja','status'));
    }

    public function edit($id)
    {
        $status    = Status::where('kategori','pegawai')->get();
        $unitKerja = UnitKerja::orderBy('nama_unit_kerja','ASC')->get();
        $pegawai   = Pegawai::where('id_pegawai', $id)->first();

        return view('pages.pegawai.edit', compact('status','unitKerja','pegawai'));
    }

    public function store(Request $request)
    {
        $pegawai   = Pegawai::count();
        $format    = str_pad($pegawai + 1, 3, 0, STR_PAD_LEFT);
        $idPegawai = Carbon::now()->isoFormat('DDMMYY').$format;


        $tambah = new Pegawai();
        $tambah->id_pegawai    = $idPegawai;
        $tambah->unit_kerja_id = $request->unit_kerja_id;
        $tambah->nip           = $request->nip;
        $tambah->nama_pegawai  = $request->nama_pegawai;
        $tambah->jabatan       = $request->jabatan;
        $tambah->status_id     = $request->status_id;
        $tambah->save();

        return redirect()->route('pegawai.show')->with('success', 'Berhasil Menambah Baru');
    }

    public function update(Request $request, $id)
    {
        Pegawai::where('id_pegawai', $id)->update([
            'unit_kerja_id' => $request->unit_kerja_id,
            'nip'           => $request->nip,
            'nama_pegawai'  => $request->nama_pegawai,
            'jabatan'       => $request->jabatan,
            'status_id'     => $request->status_id
        ]);

        User::where('pegawai_id', $id)->update([
            'username'   => $request->nip
        ]);

        return redirect()->route('pegawai.edit', $id)->with('success', 'Berhasil Memperbaharui');
    }

    public function delete($id)
    {
        Pegawai::where('id_pegawai',$id)->delete();

        return redirect()->route('pegawai.show')->with('success', 'Berhasil Menghapus');
    }
}
