<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index()
    {
        $pendapatan = json_encode($this->showPendapatan());
        $reservasi  = Reservasi::where(DB::raw("DATE_FORMAT(tanggal_pembayaran, '%Y')"), Carbon::now()->format('Y'))->orderBy('tanggal_masuk', 'ASC')->get();
        $book       = Reservasi::where('status_reservasi', 10)->orderBy('id_reservasi', 'ASC')->get();
        return view('pages.dashboard.show', compact('reservasi','pendapatan','book'));

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

    public function showPendapatan()
    {
        $result = Reservasi::select(DB::raw("(DATE_FORMAT(tanggal_pembayaran, '%m')) as month"), DB::raw('sum(total_pembayaran) as pendapatan'))
                    ->groupBy('month')
                    ->where('status_reservasi', 14)
		            ->where(DB::raw("DATE_FORMAT(tanggal_pembayaran, '%Y')"), Carbon::now()->format('Y'))
                    ->get();

        return response()->json($result);
    }
}
