<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Reservasi;
use App\Models\ReservasiDetail;
use App\Models\Status;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class LaporanController extends Controller
{
    public function index(Request $request, $id)
    {
        $listStatus = Status::whereIn('id_status',[10,11,12,13,14])->orderBy('nama_status','ASC');
        $bulan      = [];
        $bulanPick  = [];

        for ($i = 1; $i <= 12; $i++) {
            $listBulan[] = [
                'id'         => $i,
                'nama_bulan' => Carbon::now()->locale('id')->month($i)->isoFormat('MMMM')
            ];
        }

        if ($id == 'pendapatan') {
            $data = Reservasi::select(DB::raw("(DATE_FORMAT(tanggal_reservasi, '%d-%m-%Y')) as date"), DB::raw('sum(total_pembayaran) as pendapatan'))
                    ->groupBy('date')
                    ->where('status_reservasi', 14);
        }

        if ($id == 'reservasi') {
            $kamar = Kamar::get();
            $data  = ReservasiDetail::join('t_reservasi','id_reservasi','reservasi_id')->orderBy('tanggal_reservasi', 'DESC');
        }

        if ($id == 'pnbp') {
            $reservasi = Reservasi::select('id_reservasi','kode_biling', DB::raw("(DATE_FORMAT(tanggal_reservasi, '%d-%m-%Y')) as date"))->get();
            $data = Reservasi::select(DB::raw("(DATE_FORMAT(tanggal_reservasi, '%d-%m-%Y')) as date"), DB::raw('count(kode_biling) as kode_biling'))
                    ->groupBy('date')
                    ->where('kode_biling', '!=', null)
                    ->where('status_reservasi', 14);
        }


        if($request->bulan) {
            if ($request->bulan) {
                $selectedBulan = explode(',', $request->bulan);
                $bulan = $listBulan;
                $bulanPick = collect($listBulan)->filter(function ($item) use ($selectedBulan) {
                    return in_array($item['id'], $selectedBulan);
                });

                $search = $data->where(DB::raw("DATE_FORMAT(tanggal_reservasi, '%c')"), $request->bulan);
            } else { $bulan    = $listBulan; }

            $result = $search->get();

        } else {
            $bulan  = $listBulan;
            $result = $data->get();
        }

        if ($id == 'pendapatan') {
            return view('pages.laporan.pendapatan.show', compact('result','bulanPick','bulan'));
        } elseif ($id == 'reservasi') {
            return view('pages.laporan.reservasi.show', compact('result','bulanPick','bulan','kamar'));
        } elseif ($id == 'pnbp') {
            return view('pages.laporan.pnbp.show', compact('reservasi','result','bulanPick','bulan'));
        }

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
