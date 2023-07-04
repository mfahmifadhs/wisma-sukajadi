<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitorModel;
use App\Models\RoomHistoryModel;
use App\Models\RoomModel;
use App\Models\RentalrateModel;
use App\Models\ReservationModel;
use App\Models\ReservationDetailModel;
use App\Models\PnbpModel;
use App\Models\User;
use Auth;
use DB;
use Hash;
use PDF;
use Validator;

class MasterController extends Controller
{
    public function index()
    {
        $visitor        = DB::table('tbl_visits')->limit(5)->orderby('visit_date', 'DESC')->get();
        $income         = DB::table('tbl_pnbp')->limit(5)->orderby('pnbp_date', 'DESC')->get();
        $reservasi      = DB::table('tbl_reservations')
                            ->join('tbl_visitors','tbl_visitors.id_visitor','tbl_reservations.visitor_id')
                            ->limit(5)->get();
        $total_income   = DB::table('tbl_reservations')
                            ->select(DB::raw("(DATE_FORMAT(reservation_date, '%m')) as month"), DB::raw('sum(payment_total) as total_income'))
                            ->groupBy('month')
                            ->get();

        $total_visitor  = DB::table('tbl_visits')
                            ->select(DB::raw("(DATE_FORMAT(visit_date, '%m')) as month"), DB::raw("count(id_visit) as total_visitor "))
                            ->groupBy('month')
                            ->get();

        return view('v_admin_master.index', compact('visitor','income','reservasi','total_income','total_visitor'));
    }

    /*===============================================================
                               KAMAR
    ===============================================================*/

    public function showRoom(Request $request, $aksi, $id)
    {
        if ($id == 'keseluruhan') {

            $total = DB::table('tbl_rooms')->select('room_status', DB::raw('count(id_room) as total_room'))
                        ->groupBy('room_status')->get();
            $rooms = RoomModel::with('rentalrate')->paginate(6);

            return view('v_admin_master.daftar_kamar', compact('rooms','total'));

        }elseif ($id == 'tersedia') {

            $total = DB::table('tbl_rooms')->select('room_status', DB::raw('count(id_room) as total_room'))
                        ->groupBy('room_status')->get();
            $rooms = RoomModel::with('rentalrate')->where('room_status','tersedia')->paginate(6);

            return view('v_admin_master.daftar_kamar', compact('rooms','total'));

        }elseif ($id == 'tidak tersedia') {

            $total = DB::table('tbl_rooms')->select('room_status', DB::raw('count(id_room) as total_room'))
                        ->groupBy('room_status')->get();
            $rooms = RoomModel::with('rentalrate')->where('room_status','tidak tersedia')->paginate(6);

            return view('v_admin_master.daftar_kamar', compact('rooms','total'));

        }elseif ($id == 'maintenance') {

            $total = DB::table('tbl_rooms')->select('room_status', DB::raw('count(id_room) as total_room'))
                        ->groupBy('room_status')->get();
            $rooms = RoomModel::with('rentalrate')->where('room_status','maintenance')->paginate(6);

            return view('v_admin_master.daftar_kamar', compact('rooms','total'));
        }elseif ($aksi == 'detail') {
            $room       = DB::table('tbl_rooms')->where('id_room', $id)->first();
            $rentalrate = DB::table('tbl_rental_rates')->where('room_id', $id)->get();
            $reservasi  = DB::table('tbl_reservations_details')
                            ->join('tbl_reservations','tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                            ->join('tbl_rental_rates','tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                            ->join('tbl_rooms','tbl_rooms.id_room','tbl_rental_rates.room_id')
                            ->where('id_room', $id)->get();

            return view('v_admin_master.detail_kamar', compact('room','rentalrate','reservasi'));
        }
    }

    /*===============================================================
                               PENDAPATAN
    ===============================================================*/

    public function showIncome(Request $request, $aksi, $id)
    {
        if ($aksi == 'daftar') {
            $income = DB::table('tbl_pnbp')->get();
            return view('v_admin_master.daftar_pendapatan', compact('income'));
        }elseif($aksi == 'detail') {
            $income = DB::table('tbl_reservations')
                    ->where('status_reservation', '!=','cancel')
                    ->where('reservation_date', $id)
                    ->get();
            return view('v_admin_master.detail_pendapatan', compact('id','income'));
        }
    }

    /*===============================================================
                               KWITANSI
    ===============================================================*/

    public function showReceipt(Request $request, $aksi, $id)
    {
        if ($aksi == 'cek') {

            $reservasi       = DB::table('tbl_reservations')
                                ->join('tbl_visitors', 'tbl_visitors.id_visitor','tbl_reservations.visitor_id')
                                ->where('id_reservation', $id)
                                ->first();
            $reservasidetail = DB::table('tbl_reservations_details')
                                ->join('tbl_reservations','tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                                ->join('tbl_rental_rates','tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                                ->join('tbl_rooms','tbl_rooms.id_room','tbl_rental_rates.room_id')
                                ->where('id_reservation', $id)->get();
            return view('v_admin_master.cek_kwitansi', compact('reservasi','reservasidetail'));

        }elseif($aksi == 'cetak') {

            $reservasi       = DB::table('tbl_reservations')
                                ->join('tbl_visitors', 'tbl_visitors.id_visitor','tbl_reservations.visitor_id')
                                ->where('id_reservation', $id)
                                ->first();
            $reservasidetail = DB::table('tbl_reservations_details')
                                ->join('tbl_reservations','tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                                ->join('tbl_rental_rates','tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                                ->join('tbl_rooms','tbl_rooms.id_room','tbl_rental_rates.room_id')
                                ->where('id_reservation', $id)->get();

            $customPaper = array(0,0,567.00,283.80);
            $pdf = PDF::loadView('v_admin_master.cetak_kwitansi', compact('reservasi','reservasidetail'))->setPaper($customPaper, 'landscape');

            return view('v_admin_master.cetak_kwitansi', compact('reservasi','reservasidetail'));

        }
    }

    /*===============================================================
                               PENGGUNA
    ===============================================================*/

    public function showUser(Request $request, $aksi, $id)
    {
        if ($aksi == 'daftar') {
            $role = DB::table('tbl_roles')->where('id_role','!=',1)->get();
            $user = DB::table('users')
                        ->where('role_id','!=',1)
                        ->join('tbl_roles','tbl_roles.id_role','users.role_id')
                        ->get();
            return view('v_admin_master.daftar_pengguna', compact('role','user'));
        }elseif ($aksi == 'detail') {
            $role = DB::table('tbl_roles')->get();
            $user = DB::table('users')
                        ->where('id', $id)
                        ->join('tbl_roles','tbl_roles.id_role','users.role_id')
                        ->first();
            return view('v_admin_master.detail_pengguna', compact('role','user'));
        }elseif($aksi == 'ubah') {
            if ($request->username != null) {
                $valid_username  = Validator::make($request->all(), [
                    'username'  => 'unique:users',
                ]);

                if ($valid_username->fails()) {
                    return redirect('admin-master/pengguna/daftar/keseluruhan')->with('failed', 'Username telah terdaftar');
                }else{
                    User::where('id', $id)
                        ->update([
                            'name'      => $request->name,
                            'username'  => $request->username,
                            'role_id'   => $request->role_id,
                            'status'    => $request->status
                        ]);
                    return redirect('admin-master/pengguna/daftar/keseluruhan')->with('success', 'Berhasil mengubah informasi pengguna');
                }
            }else{
                User::where('id', $id)
                        ->update([
                            'name'      => strtolower($request->name),
                            'username'  => $request->old_username,
                            'role_id'   => $request->role_id,
                            'status'    => strtolower($request->status)
                        ]);
                return redirect('admin-master/pengguna/daftar/keseluruhan')->with('success', 'Berhasil mengubah informasi pengguna');
            }
        }elseif($aksi == 'tambah') {

            $cekusername  = Validator::make($request->all(), [
                'username'  => 'unique:users',
            ]);

            if ($cekusername->fails()) {
                return redirect('admin-master/pengguna/daftar/keseluruhan')->with('failed', 'Username telah terdaftar');
            }else{
                $user = new User();
                $user->username = $request->input('username');
                $user->password = Hash::make($request->input('password'));
                $user->name     = $request->input('name');
                $user->role_id  = $request->input('role_id');
                $user->status   = $request->input('status');
                $user->save();

                return redirect('admin-master/pengguna/daftar/keseluruhan')->with('success','Berhasil menambah pengguna baru');

            }
        }elseif($aksi == 'ganti-password') {
            $cekpass = DB::table('users')->where('id', $id)->first();
            if(\Hash::check($request->old_pass, $cekpass->password)){
                User::where('id', $id)
                    ->update([
                        'password' => Hash::make($request->new_pass)
                    ]);

                return redirect('admin-master/pengguna/detail/'. $id)->with('success', 'Berhasil mengubah password');
            }else{
                return redirect('admin-master/pengguna/daftar/keseluruhan')->with('failed', 'Password lama anda salah');
            }
        }
    }

    /*===============================================================
                               RESERVASI
    ===============================================================*/

    public function showReservation(Request $request, $aksi, $id)
    {
        if ($aksi == 'daftar') {
            $reservasi  = DB::table('tbl_reservations_details')
                            ->select('id_reservation','visitor_name','visitor_phone_number','identity_img','status_reservation','payment_status',
                              'reservation_date','payment_total',DB::raw('count(reservation_id) as total_room'))
                            ->join('tbl_reservations', 'tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                            ->join('tbl_rental_rates','tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                            ->join('tbl_rooms','tbl_rooms.id_room','tbl_rental_rates.room_id')
                            ->join('tbl_visitors', 'tbl_visitors.id_visitor','tbl_reservations.visitor_id')
                            ->groupBy('id_reservation','visitor_name','visitor_phone_number','identity_img','status_reservation','payment_status',
                                      'reservation_date','payment_total')
                            ->orderby('reservation_date', 'DESC')
                            ->get();
            return view('v_admin_master.daftar_reservasi', compact('reservasi'));
        }elseif ($aksi == 'pembayaran' || $aksi == 'detail'){
            $reservasi  = DB::table('tbl_reservations_details')
                                ->join('tbl_reservations', 'tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                                ->join('tbl_rental_rates','tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                                ->join('tbl_rooms','tbl_rooms.id_room','tbl_rental_rates.room_id')
                                ->join('tbl_visitors', 'tbl_visitors.id_visitor','tbl_reservations.visitor_id')
                                ->where('id_reservation', $id)
                                ->first();

                $detail     = DB::table('tbl_reservations_details')
                                ->join('tbl_reservations', 'tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                                ->join('tbl_rental_rates','tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                                ->join('tbl_rooms','tbl_rooms.id_room','tbl_rental_rates.room_id')
                                ->where('id_reservation', $id)
                                ->get();

                $room       = DB::table('tbl_rooms')->where('room_status','tersedia')->get();
                $price      = DB::table('tbl_rental_rates')->select('rental_rate_ctg')->groupBy('rental_rate_ctg')->get();
                $price_ctg  = DB::table('tbl_rental_rates')->select('price_ctg')->groupBy('price_ctg')->get();

                return view('v_admin_master.detail_reservasi', compact('reservasi','detail','room','price','price_ctg'));
        }elseif ($aksi == 'proses-pembayaran') {
            $total_price = 0;
            $idresdetail = $request->res_detail_id;
            foreach($idresdetail as $i => $id_res_detail)
            {
                // Mengambil harga kamar terbaru
                if ($request->new_rental_rate_id[$i] != null) {
                    $rentalrateid = $request->new_rental_rate_id[$i];
                    $price        = (int)$request->new_price[$i];
                }else{
                    $rentalrateid = $request->old_rental_rate_id[$i];
                    $price        = (int)$request->old_price[$i];
                }
                // Update Detail Reservasi
                ReservationDetailModel::where('id_detail_reservation', $id_res_detail)
                    ->update([
                        'rental_rate_id'           => $rentalrateid,
                        'detail_reservation_price' => $price * $request->duration[$i]
                    ]);

                $total_price += $price * $request->duration[$i];
                RoomModel::where('id_room', $request->room_id[$i])
                    ->update([
                        'room_status'       => 'tidak tersedia'
                    ]);
            }

            $reservasi = new ReservationModel();
            if ($request->payment_img == null) {
                $payment_img = null;
            }else{
                if ($request->hasfile('payment_img')){
                    $file = $request->file('payment_img');
                    $extension = $file->getClientOriginalExtension();
                    $filename = $file->getClientOriginalName();
                    $file->move('images/admin/bukti-pembayaran/', $filename);
                    $reservasi->payment_img = $filename;
                } else {
                    return $request;
                    $reservasi->payment_img='';
                }

                $payment_img = $reservasi->payment_img;
            }


            // Update Pembayaran
            ReservationModel::where('id_reservation', $id)
                ->update([
                    'billing_code'       => $request->billing_code,
                    'status_reservation' => 'reserved',
                    'payment_status'     => 'sudah bayar',
                    'payment_img'        => $payment_img,
                    'payment_total'      => $total_price
                ]);

            // Update Ketersediaan Kamar
            RoomModel::where('id_room', $request->room_id)
                ->update([
                    'room_status'       => 'tidak tersedia'
                ]);

            // Update History Kamar
            $total_rooms   = DB::table('tbl_rooms')->select('room_status', DB::raw('count(room_status) as total_room'))->groupBy('room_status')->get();
            $room_reserved = DB::table('tbl_reservations_details')->select(DB::raw('count(reservation_id) as room_reserved'))
                                    ->where('reservation_id', $id)->first();
            $room_maintenance = 0;
            foreach($total_rooms as $total_room)
            {
                if ($total_room->room_status == 'tersedia'){
                    $room_avail         = $total_room->total_room;
                }elseif($total_room->room_status == 'tidak tersedia'){
                    $room_notavail      = $total_room->total_room;
                }elseif($total_room->room_status == 'maintenance'){
                    $room_maintenance   = $total_room->total_room;
                }
            }

            $history = new RoomHistoryModel();
            $history->reservation_id    = $id;
            $history->history_date      = Carbon::now();
            $history->total_room        = $room_total = $room_avail + $room_notavail + $room_maintenance;
            $history->room_reserved     = $room_reserved->room_reserved;
            $history->room_notavailable = $room_maintenance;
            $history->room_available    = $room_avail;
            $history->save();

            // Update Pendapatan
            $income = DB::table('tbl_reservations')
                        ->select(DB::raw("(DATE_FORMAT(reservation_date, '%y-%m-%d')) as date"), DB::raw('sum(payment_total) as total_income'),
                                 DB::raw('sum(total_room) as total_room'))
                        ->where('billing_code','!=', null)
                        ->groupBy('date')
                        ->get();

            foreach($income as $income)
            {
                PnbpModel::where('pnbp_date', $income->date)
                        ->update([
                            'pnbp_total_room'   => $income->total_room,
                            'pnbp_total_income' => $income->total_income
                        ]);

            }

            return redirect('admin-pnbp/reservasi/daftar/keseluruhan')->with('success','Berhasil menambah pembayaran');
        }
    }

    /*===============================================================
                                LAPORAN
    ===============================================================*/

    public function showReport(Request $request, $id)
    {
        if ($id == 'kamar') {

            if ($request->all() == []) {
                $rooms = DB::table('tbl_room_historys')
                        ->join('tbl_reservations','tbl_reservations.id_reservation','tbl_room_historys.reservation_id')
                        ->select('id_reservation','billing_code','tbl_room_historys.total_room','history_date','room_reserved','room_notavailable',
                                 'room_available')
                        ->orderby('id_room_history','ASC')
                        ->get();
            }else{
                $rooms = DB::table('tbl_room_historys')
                            ->join('tbl_reservations','tbl_reservations.id_reservation','tbl_room_historys.reservation_id')
                            ->select('id_reservation','billing_code','tbl_room_historys.total_room','history_date','room_reserved','room_notavailable',
                                     'room_available')
                            ->whereBetween(DB::raw("(DATE_FORMAT(history_date, '%Y-%m-%d'))"), [$request->start_dt, $request->end_dt])
                            ->orderby('id_room_history','ASC')
                            ->get();
            }


            return view('v_admin_master.laporan_kamar', compact('rooms'));
        }elseif ($id == 'pnbp') {

            if ($request->all() == []) {
                $pnbp = DB::table('tbl_pnbp')->orderby('pnbp_date','DESC')->get();
            }else{
                $pnbp = DB::table('tbl_pnbp')->whereBetween('pnbp_date', [$request->start_dt, $request->end_dt])->get();
            }

            return view('v_admin_master.laporan_pnbp', compact('pnbp'));

        }elseif ($id == 'reservasi') {

            $reservasi  = DB::table('tbl_reservations_details')
                            ->join('tbl_reservations', 'tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                            ->join('tbl_rental_rates','tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                            ->join('tbl_rooms','tbl_rooms.id_room','tbl_rental_rates.room_id')
                            ->join('tbl_visitors', 'tbl_visitors.id_visitor','tbl_reservations.visitor_id')
                            ->orderby('reservation_date', 'DESC')
                            ->get();

            return view('v_admin_master.laporan_reservasi', compact('reservasi'));
        }elseif ($id == 'buku-tamu') {
            $visit = DB::table('tbl_visits')->get();
            return view('v_admin_master.laporan_pengunjung',compact('visit'));
        }

    }

    public function showDetail(Request $request, $aksi, $id)
    {
        if ($aksi == 'pendapatan') {
            $income = DB::table('tbl_reservations')
                    ->where('status_reservation', '!=','cancel')
                    ->where('reservation_date', $id)
                    ->get();
            return view('v_admin_master.detail_pendapatan', compact('income', 'id'));
        }
    }

    // ================
    // Bar Chart
    // ================

    public function getChartVisitor()
    {
        $result     = DB::table('tbl_visits')
                        ->select(DB::raw("(DATE_FORMAT(visit_date, '%M %Y')) as month"), DB::raw("count(id_visit) as total_visitor "))
                        ->groupBy('month')
                        ->get();

        return response()->json($result);
    }

    public function getChartIncome()
    {
        $result     = DB::table('tbl_reservations')
                         ->select(DB::raw("(DATE_FORMAT(reservation_date, '%M')) as month"), DB::raw('sum(payment_total) as total_income'))
                        ->groupBy('month')
                        ->get();

        return response()->json($result);
    }
}
