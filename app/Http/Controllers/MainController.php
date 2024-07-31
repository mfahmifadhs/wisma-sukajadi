<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;
use App\Models\RoomModel;
use App\Models\VisitModel;
use Carbon\Carbon;

class MainController extends Controller
{
    public function index()
    {
        return view('admin-master.app');
    }

    public function menuRoom($id)
    {
        if ($id == 'daftar') {
            $rooms = Kamar::get();
            return view('m_kamar', compact('rooms'));
        }else{
            $rooms = RoomModel::with('rentalrate')->where('id_room', $id)->get();
            return view('m_detail_kamar', compact('rooms'));
        }
    }

    public function menuVisit(Request $request, $menu)
    {
        if ($menu == 'buku-tamu') {
            return view('m_buku_tamu');
        }elseif($menu == 'tambah-kunjungan')
        {
            $visit                     = new VisitModel();
            $visit->visit_date         = Carbon::now();
            $visit->visit_name         = $request->input('visit_name');
            $visit->visit_phone_num    = $request->input('visit_phone_num');
            $visit->visit_vehicle_num  = $request->input('visit_vehicle_num');
            $visit->visit_description  = $request->input('visit_description');
            $visit->save();

            return redirect('beranda/kunjungan/buku-tamu')->with('success', 'Terima kasih telah mengisi buku tamu');
        }
    }


}
