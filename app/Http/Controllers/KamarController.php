<?php

namespace App\Http\Controllers;

use App\Model\submissionModel;
use App\Models\Kamar;
use App\Models\Pegawai;
use App\Models\StatusPegawai;
use App\Models\TarifSewa;
use App\Models\UnitKerja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KamarController extends Controller
{
    public function show($id)
    {
        $totalKamar = Kamar::withTrashed()->whereNull('deleted_at')->get();
        if ($id == 'daftar') {
            $kamar  = Kamar::withTrashed()->whereNull('deleted_at')->get();
        } else {
            $kamar  = Kamar::where('status_kamar', $id)->whereNull('deleted_at')->get();
        }

        return view('pages.kamar.show', compact('totalKamar','kamar'));
    }

    public function detail($id)
    {
        $kamar = Kamar::where('id_kamar', $id)->first();
        return view('pages.kamar.detail', compact('kamar'));
    }

    public function create()
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        if ($request->process == 'kamar') {
            Kamar::where('id_kamar', $id)->update([
                'nama_kamar'   => $request->nama_kamar,
                'kapasitas'    => $request->kapasitas,
                'status_kamar' => $request->status_kamar
            ]);
        } else {
            $tarifSewa = $request->id_tarif_sewa;
            foreach($tarifSewa as $i => $tarif_sewa_id)
            {
                $nilai = str_replace(".", "", $request->harga_sewa[$i]);
                $nilai = (int) $nilai;
                TarifSewa::where('id_tarif_sewa', $tarif_sewa_id)
                    ->update([
                        'harga_sewa' => $nilai
                    ]);
            }
        }
        return redirect()->route('kamar.detail', $id)->with('success', 'Berhasil menyimpan perubahan');
    }

    public function delete($id)
    {
        //
    }

    public function selectKamar(Request $request)
    {
        $data  = Kamar::where('status_kamar', '5');
        $kamar = $request->data == [] ? $data->get() : $data->whereNotIn('id_kamar', $request->data)->get();

        $tarif  = TarifSewa::select('kategori_tamu')->groupBy('kategori_tamu')->get();

        $array['kamar'] = $kamar;
        $array['tarif'] = $tarif;

        return response()->json($array);
    }
}
