<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Auth;
use DB;

class DashboardController extends Controller
{

    public function index()
    {
        $pendapatan = json_encode($this->showPendapatan());
        $reservasi  = Reservasi::get();
        return view('pages.dashboard.show', compact('reservasi','pendapatan'));

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
        $result = Reservasi::select(DB::raw("(DATE_FORMAT(created_at, '%m')) as month"), DB::raw('sum(total_pembayaran) as pendapatan'))
                    ->groupBy('month')
                    ->get();

        return response()->json($result);
    }
}
