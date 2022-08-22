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
use Carbon\Carbon;
use Auth;
use DB;
use Hash;
use PDF;
use Validator;

class PnbpController extends Controller
{
    public function index()
    {
    	$visitor        = DB::table('tbl_visits')->limit(5)->orderby('visit_date', 'DESC')->get();
        $income         = DB::table('tbl_pnbp')->limit(5)->orderby('pnbp_date', 'DESC')->get();
        $reservasi      = DB::table('tbl_reservations')
                            ->join('tbl_visitors','tbl_visitors.id_visitor','tbl_reservations.visitor_id')
                            ->orderby('reservation_date', 'DESC')
                            ->limit(5)->get();
        $total_income   = DB::table('tbl_reservations')
                            ->select(DB::raw("(DATE_FORMAT(reservation_date, '%m')) as month"), DB::raw('sum(payment_total) as total_income'))
                            ->groupBy('month')
                            ->get();

        $total_visitor  = DB::table('tbl_visits')
                            ->select(DB::raw("(DATE_FORMAT(visit_date, '%m')) as month"), DB::raw("count(id_visit) as total_visitor "))
                            ->groupBy('month')
                            ->get();

        return view('v_admin_pnbp.index', compact('visitor','income','reservasi','total_income','total_visitor'));
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

            return view('v_admin_pnbp.daftar_kamar', compact('rooms','total'));

        }elseif ($id == 'tersedia') {
            
            $total = DB::table('tbl_rooms')->select('room_status', DB::raw('count(id_room) as total_room'))
                        ->groupBy('room_status')->get();
            $rooms = RoomModel::with('rentalrate')->where('room_status','tersedia')->paginate(6);

            return view('v_admin_pnbp.daftar_kamar', compact('rooms','total'));

        }elseif ($id == 'tidak tersedia') {
            
            $total = DB::table('tbl_rooms')->select('room_status', DB::raw('count(id_room) as total_room'))
                        ->groupBy('room_status')->get();
            $rooms = RoomModel::with('rentalrate')->where('room_status','tidak tersedia')->paginate(6);

            return view('v_admin_pnbp.daftar_kamar', compact('rooms','total'));

        }elseif ($id == 'maintenance') {
            
            $total = DB::table('tbl_rooms')->select('room_status', DB::raw('count(id_room) as total_room'))
                        ->groupBy('room_status')->get();
            $rooms = RoomModel::with('rentalrate')->where('room_status','maintenance')->paginate(6);

            return view('v_admin_pnbp.daftar_kamar', compact('rooms','total'));
        }elseif ($aksi == 'detail') {
            $room       = DB::table('tbl_rooms')->where('id_room', $id)->first();
            $rentalrate = DB::table('tbl_rental_rates')->where('room_id', $id)->get();
            $reservasi  = DB::table('tbl_reservations_details')
                            ->join('tbl_reservations','tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                            ->join('tbl_rental_rates','tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                            ->join('tbl_rooms','tbl_rooms.id_room','tbl_rental_rates.room_id')
                            ->where('id_room', $id)->get();

            return view('v_admin_pnbp.detail_kamar', compact('room','rentalrate','reservasi'));
        }
    }

    /*===============================================================
                               PENDAPATAN
    ===============================================================*/

    public function showIncome(Request $request, $aksi, $id)
    {
        if ($aksi == 'daftar') {
            $income = DB::table('tbl_pnbp')->get();
            return view('v_admin_pnbp.daftar_pendapatan', compact('income'));
        }elseif($aksi == 'detail') {
            $income = DB::table('tbl_reservations')
                    ->where('status_reservation', '!=','cancel')
                    ->where('reservation_date', $id)
                    ->get();
            return view('v_admin_pnbp.detail_pendapatan', compact('id','income'));
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
            return view('v_admin_pnbp.cek_kwitansi', compact('reservasi','reservasidetail'));

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
            $pdf = PDF::loadView('v_admin_pnbp.cetak_kwitansi', compact('reservasi','reservasidetail'))->setPaper($customPaper, 'landscape');     

            return view('v_admin_pnbp.cetak_kwitansi', compact('reservasi','reservasidetail'));

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
            return view('v_admin_pnbp.daftar_reservasi', compact('reservasi'));
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

                return view('v_admin_pnbp.detail_reservasi', compact('reservasi','detail','room','price','price_ctg'));
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