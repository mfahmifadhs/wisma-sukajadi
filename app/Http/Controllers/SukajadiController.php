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
use DB;
use PDF;
use Carbon\Carbon;
use Validator;

class SukajadiController extends Controller
{
    public function index()
    {
        $room_av      = DB::table('tbl_rooms')->where('room_status','tersedia')->count();
        $room_notav   = DB::table('tbl_rooms')->where('room_status','tidak tersedia')->count();
        $room_mtc     = DB::table('tbl_rooms')->where('room_status','maintenance')->count();
        $total_income = DB::table('tbl_reservations')
                            ->select(DB::raw("(DATE_FORMAT(reservation_date, '%m')) as month"), DB::raw('sum(payment_total) as total_income'))
                            ->groupBy('month')
                            ->get();
        $visitor      = DB::table('tbl_visits')->limit(5)->get();
        $reservasi    = DB::table('tbl_reservations')
                            ->join('tbl_visitors','tbl_visitors.id_visitor','tbl_reservations.visitor_id')
                            ->limit(5)->get();
        return view('v_admin_sukajadi.index', compact('room_av','room_notav','room_mtc','total_income','visitor','reservasi'));
    }

    public function showProfile($id)
    {
        $user = DB::table('users')
                    ->join('tbl_roles','tbl_roles.id_role','users.role_id')
                    ->where('id', $id)->first();
        return view('v_admin_sukajadi.profil_pengguna', compact('user'));
    }

    // RESERVASI ===================================
    public function menuReservation($id)
    {
        if ($id == 'buat') {

            $room       = DB::table('tbl_rooms')->where('room_status','tersedia')->get();
            $price      = DB::table('tbl_rental_rates')->select('rental_rate_ctg')->groupBy('rental_rate_ctg')->get();
            $price_ctg  = DB::table('tbl_rental_rates')->select('price_ctg')->groupBy('price_ctg')->get();
            return view('v_admin_sukajadi.tambah_reservasi', compact('room','price','price_ctg'));

        }elseif($id == 'daftar'){

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
            return view('v_admin_sukajadi.daftar_reservasi', compact('reservasi'));

        }elseif($id == 'laporan'){

            $reservasi  = DB::table('tbl_reservations_details')
                            ->join('tbl_reservations', 'tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                            ->join('tbl_rental_rates','tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                            ->join('tbl_rooms','tbl_rooms.id_room','tbl_rental_rates.room_id')
                            ->join('tbl_visitors', 'tbl_visitors.id_visitor','tbl_reservations.visitor_id')
                            ->orderby('reservation_date', 'DESC')
                            ->get();

            return view('v_admin_sukajadi.laporan_reservasi', compact('reservasi'));

        }else{

        }
    }

    public function processReservation(Request $request, $process, $idreservation)
    {
        if ($process == 'bayar' || $process == 'detail') {
            $reservasi  = DB::table('tbl_reservations_details')
                            ->join('tbl_reservations', 'tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                            ->join('tbl_rental_rates','tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                            ->join('tbl_rooms','tbl_rooms.id_room','tbl_rental_rates.room_id')
                            ->join('tbl_visitors', 'tbl_visitors.id_visitor','tbl_reservations.visitor_id')
                            ->where('id_reservation', $idreservation)
                            ->first();

            $detail     = DB::table('tbl_reservations_details')
                            ->join('tbl_reservations', 'tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                            ->join('tbl_rental_rates','tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                            ->join('tbl_rooms','tbl_rooms.id_room','tbl_rental_rates.room_id')
                            ->where('id_reservation', $idreservation)
                            ->get();

            $room       = DB::table('tbl_rooms')->where('room_status','tersedia')->get();
            $price      = DB::table('tbl_rental_rates')->select('rental_rate_ctg')->groupBy('rental_rate_ctg')->get();
            $price_ctg  = DB::table('tbl_rental_rates')->select('price_ctg')->groupBy('price_ctg')->get();

            return view('v_admin_sukajadi.detail_reservasi', compact('reservasi','detail','room','price','price_ctg'));
        }elseif ($process == 'proses-pembayaran') {
            // Update kamar
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
            ReservationModel::where('id_reservation', $idreservation)
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
                                ->where('reservation_id', $idreservation)->first();
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
            $history->reservation_id    = $idreservation;
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

            return redirect('admin-sukajadi/reservasi/daftar')->with('success','Berhasil menambah pembayaran');
        }elseif ($process == 'checkin'){

            ReservationModel::where('id_reservation', $idreservation)
                ->update([
                    'status_reservation' => 'checkin'
                ]);

            return redirect('admin-sukajadi/reservasi/daftar')->with('success','Berhasil Chcek In');

        }elseif ($process == 'checkout'){

            ReservationModel::where('id_reservation', $idreservation)
                ->update([
                    'status_reservation' => 'checkout'
                ]);

            $roomid = DB::table('tbl_reservations_details')->select('id_room')
                        ->join('tbl_reservations','tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                        ->join('tbl_rental_rates', 'tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                        ->join('tbl_rooms', 'tbl_rooms.id_room','tbl_rental_rates.room_id')
                        ->where('id_reservation', $idreservation)
                        ->get();

            foreach($roomid as $room)
            {
                RoomModel::where('id_room', $room->id_room)
                    ->update([
                        'room_status' => 'maintenance'
                    ]);
            }



            return redirect('admin-sukajadi/kwitansi/buat/'. $idreservation)->with('success','Berhasil Check Out');
        }elseif ($process == 'batal') {
            ReservationModel::where('id_reservation', $idreservation)
                ->update([
                    'status_reservation' => 'cancel'
                ]);

            return redirect('admin-sukajadi/reservasi/daftar')->with('success','Berhasil Membatalkan Reservasi');
        }
    }

    public function postReservation(Request $request)
    {
        $valid_img  = Validator::make($request->all(), [
            'identity_img'  => 'mimes: jpg,png,jpeg|max:4096',
            'payment_img'   => 'mimes: jpg,png,jpeg|max:4096',
        ]);
        if ($valid_img->fails()) {
            return redirect('admin-sukajadi/reservasi/buat')->with('failed', 'Format foto tidak sesuai, mohon cek kembali');
        }else{
            // Tambah tanggal pnbp
            $cekpnbp = DB::table('tbl_pnbp')->where(DB::raw("(DATE_FORMAT(pnbp_date, '%Y-%m-%d'))"), Carbon::now()->format('Y-m-d'))->count();
            if ($cekpnbp == 0) {
                $addpnbp = new PnbpModel();
                $addpnbp->pnbp_date = Carbon::now();
                $addpnbp->pnbp_status = 'belum';
                $addpnbp->save();
            }

            // Tambah informasi pengunjung
            $visitor = new VisitorModel();
            if ($request->hasfile('identity_img')){
                $file = $request->file('identity_img');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('images/admin/pengunjung/', $filename);
                $visitor->identity_img = $filename;
            } else {
                return $request;
                $visitor->identity_img='';
            }

            $visitor_img = $visitor->identity_img;
            $visitor->id_visitor             = $request->input('id_visitor');
            $visitor->identity_num           = strtolower($request->input('identity_num'));
            $visitor->identity_img           = $visitor_img;
            $visitor->visitor_name           = strtolower($request->input('visitor_name'));
            $visitor->visitor_birthdate      = strtolower($request->input('visitor_birthdate'));
            $visitor->visitor_phone_number   = strtolower($request->input('visitor_phone_number'));
            $visitor->visitor_address        = strtolower($request->input('visitor_address'));
            $visitor->visitor_instance       = strtolower($request->input('visitor_instance'));
            $visitor->visitor_description    = strtolower($request->input('visitor_description'));
            $visitor->save();

            // Detail reservasi
            $total_price  = 0;
            $rentalrateid = $request->rental_rate_id;
            foreach ($rentalrateid as $i => $rental_rate_id) {
                $duration = Carbon::parse($request->checkin[$i])->diffInDays(Carbon::parse($request->checkout[$i]));
                $res_detail[] = [
                    'id_detail_reservation'    => random_int(10000,99999),
                    'reservation_id'           => $request->id_reservation,
                    'rental_rate_id'           => $rental_rate_id,
                    'check_in'                 => $request->checkin[$i],
                    'check_out'                => $request->checkout[$i],
                    'duration'                 => $duration,
                    'detail_reservation_price' => $request->price[$i] * $duration
                ];
                $total_price += $request->price[$i] * $duration;
            }

            ReservationDetailModel::insert($res_detail);

            $reservation = new ReservationModel();
            if ($request->payment_img != null) {
                if ($request->hasfile('payment_img')){
                $file       = $request->file('payment_img');
                $extension  = $file->getClientOriginalExtension();
                $filename   = $file->getClientOriginalName();
                $file->move('images/admin/bukti-pembayaran/', $filename);
                $reservation->payment_img = $filename;
                } else {
                    return $request;
                    $reservation->payment_img='';
                }
                $payment_img = $reservation->payment_img;
            }else{
                $payment_img = $request->payment_img;
            }

            if ($request->assignment_letter != null) {
                if ($request->hasfile('assignment_letter')){
                $file       = $request->file('assignment_letter');
                $extension  = $file->getClientOriginalExtension();
                $filename   = $file->getClientOriginalName();
                $file->move('images/admin/surat-tugas/', $filename);
                $reservation->assignment_letter = $filename;
                } else {
                    return $request;
                    $reservation->assignment_letter='';
                }
                $assignment_letter = $reservation->assignment_letter;
            }else{
                $assignment_letter = $request->assignment_letter;
            }

            // Payment dan reservasi
            $reservation->id_reservation    = $request->input('id_reservation');
            $reservation->visitor_id        = strtolower($request->input('id_visitor'));
            $reservation->assignment_letter = $assignment_letter;
            $reservation->total_room        = count($request->rental_rate_id);
            $reservation->billing_code      = $request->input('billing_code');
            $reservation->payment_total     = $total_price;
            $reservation->payment_img       = $payment_img;
            $reservation->reservation_date  = Carbon::now();

            if ($request->billing_code == null) {
                $reservation->status_reservation = 'payment';
                $reservation->payment_status     = 'belum bayar';
            }else{
                $reservation->status_reservation = 'reserved';
                $reservation->payment_status     = 'sudah bayar';

                // Update kamar
                $roomid = $request->room_id;
                foreach($roomid as $i => $room_id)
                {
                    RoomModel::where('id_room', $room_id)
                        ->update([
                            'room_status'       => 'tidak tersedia'
                        ]);
                }
            }

            $reservation->save();

            if ($request->billing_code != null) {
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

                // Update History Kamar
                $total_rooms = DB::table('tbl_rooms')->select('room_status', DB::raw('count(room_status) as total_room'))->groupBy('room_status')->get();
                $room_reserved = DB::table('tbl_reservations_details')->select(DB::raw('count(reservation_id) as room_reserved'))
                                    ->where('reservation_id', $request->id_reservation)->first();
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
                $history->reservation_id    = $request->id_reservation;
                $history->history_date      = Carbon::now();
                $history->total_room        = $room_avail + $room_notavail + $room_maintenance;
                $history->room_reserved     = $room_reserved->room_reserved;
                $history->room_notavailable = $room_maintenance;
                $history->room_available    = $room_avail;
                $history->save();
            }

            return redirect('admin-sukajadi/reservasi/daftar')->with('success','Berhasil melakukan reservasi');
        }
    }

    // KAMAR ========================================
    public function menuRoom(Request $request, $id)
    {
        if ($id == 'daftar') {

            $total = DB::table('tbl_rooms')->select('room_status', DB::raw('count(id_room) as total_room'))
                        ->groupBy('room_status')->get();
            $rooms = RoomModel::with('rentalrate')->paginate(6);

            return view('v_admin_sukajadi.daftar_kamar', compact('rooms','total'));

        }elseif ($id == 'tersedia') {

            $total = DB::table('tbl_rooms')->select('room_status', DB::raw('count(id_room) as total_room'))
                        ->groupBy('room_status')->get();
            $rooms = RoomModel::with('rentalrate')->where('room_status','tersedia')->paginate(6);

            return view('v_admin_sukajadi.daftar_kamar', compact('rooms','total'));

        }elseif ($id == 'tidak tersedia') {

            $total = DB::table('tbl_rooms')->select('room_status', DB::raw('count(id_room) as total_room'))
                        ->groupBy('room_status')->get();
            $rooms = RoomModel::with('rentalrate')->where('room_status','tidak tersedia')->paginate(6);

            return view('v_admin_sukajadi.daftar_kamar', compact('rooms','total'));

        }elseif ($id == 'maintenance') {

            $total = DB::table('tbl_rooms')->select('room_status', DB::raw('count(id_room) as total_room'))
                        ->groupBy('room_status')->get();
            $rooms = RoomModel::with('rentalrate')->where('room_status','maintenance')->paginate(6);

            return view('v_admin_sukajadi.daftar_kamar', compact('rooms','total'));

        }elseif($id == 'laporan'){
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

            return view('v_admin_sukajadi.laporan_kamar', compact('rooms'));

        }

    }

    public function detailRoom(Request $request, $aksi, $id)
    {
        if ($aksi == 'detail') {
            $room       = DB::table('tbl_rooms')->where('id_room', $id)->first();
            $rentalrate = DB::table('tbl_rental_rates')->where('room_id', $id)->get();
            $reservasi  = DB::table('tbl_reservations_details')
                            ->join('tbl_reservations','tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                            ->join('tbl_rental_rates','tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                            ->join('tbl_rooms','tbl_rooms.id_room','tbl_rental_rates.room_id')
                            ->where('id_room', $id)->get();

            return view('v_admin_sukajadi.detail_kamar', compact('room','rentalrate','reservasi'));

        }elseif($aksi == 'update'){
            if ($id == 'informasi-kamar') {
                RoomModel::where('id_room', $request->room_id)
                        ->update([
                            'room_name'     => $request->room_name,
                            'room_capacity' => $request->room_capacity,
                            'room_status'   => $request->room_status,
                        ]);

                return redirect('admin-sukajadi/kamar/detail/'. $request->room_id)->with('success','Berhasil memperbarui informasi kamar');
            }else{
                $rentalrateid = $request->id_rental_rate;
                foreach($rentalrateid as $i => $rental_rate_id)
                {
                    RentalrateModel::where('id_rental_rate', $rental_rate_id)
                        ->update([
                            'price' => $request->price[$i]
                        ]);
                }

                return redirect('admin-sukajadi/kamar/detail/'. $request->room_id)->with('success','Berhasil memperbarui tarif sewa');
            }

        }elseif($aksi == 'keterangan'){
            $reservasi  = DB::table('tbl_reservations')
                            ->join('tbl_visitors','tbl_visitors.id_visitor','tbl_reservations.visitor_id')
                            ->where('id_reservation', $id)->first();

            $room       = DB::table('tbl_reservations_details')
                                ->join('tbl_reservations','tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                                ->join('tbl_rental_rates','tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                                ->join('tbl_rooms','tbl_rooms.id_room','tbl_rental_rates.room_id')
                                ->where('id_reservation', $id)->get();

            return view('v_admin_sukajadi.tambah_catatan', compact('reservasi','room'));
        }elseif($aksi == 'tambah-keterangan'){
            foreach($request->id_detail_reservation as $i => $idreservationdetail )
            {
                ReservationDetailModel::where('id_detail_reservation', $idreservationdetail)
                    ->update([
                        'notes' => $request->room_notes[$i]
                    ]);
            }
            return redirect('admin-sukajadi/kamar/keterangan/'. $id)->with('success','Berhasil menambah keterangan');
        }

    }

    // PNPB ========================================
    public function showIncome(Request $request)
    {
        $income = DB::table('tbl_pnbp')->get();
        return view('v_admin_sukajadi.daftar_pendapatan', compact('income'));
    }

    public function detailIncome($id)
    {
        $income = DB::table('tbl_reservations')
                    ->where('status_reservation', '!=','cancel')
                    ->where('reservation_date', $id)
                    ->get();
        return view('v_admin_sukajadi.detail_pendapatan', compact('id','income'));
    }

    public function menuPnbp(Request $request, $id)
    {
        if ($id == 'laporan') {
            if ($request->all() == []) {
                $pnbp = DB::table('tbl_pnbp')->get();
            }else{
                $pnbp = DB::table('tbl_pnbp')->whereBetween('pnbp_date', [$request->start_dt, $request->end_dt])->get();
            }

            return view('v_admin_sukajadi.laporan_pnbp', compact('pnbp'));
        }elseif($id == 'setor-pnbp'){

            $pnbp = new PnbpModel();
            if ($request->hasfile('transaction_img')){
                $file       = $request->file('transaction_img');
                $extension  = $file->getClientOriginalExtension();
                $filename   = $file->getClientOriginalName();
                $file->move('images/admin/bukti-setor-pnbp/', $filename);
                $pnbp->transaction_img = $filename;
            } else {
                return $request;
                $pnbp->transaction_img='';
            }
            $transaction_img = $pnbp->transaction_img;

            PnbpModel::where('id_pnbp', $request->id_pnbp)
                ->update([
                    'transaction_num'    => $request->transaction_num,
                    'transaction_date'   => $request->date.' '.$request->time,
                    'transaction_img'    => $transaction_img,
                    'pnbp_total_room'    => $request->pnbp_total_room,
                    'pnbp_total_income'  => $request->pnbp_total_income,
                    'pnbp_note'          => $request->pnbp_note,
                    'pnbp_date'          => $request->pnbp_date,
                    'pnbp_status'        => 'sudah'
                ]);

            return redirect('admin-sukajadi/pendapatan')->with('success','Berhasil menyetorkan pendapatan ke pnbp');

        }else{
            $pnbp = DB::table('tbl_pnbp')->where('id_pnbp', $id)->first();
            return view('v_admin_sukajadi.setor_pnbp', compact('pnbp'));
        }
    }

    // VISIT ========================================
    public function showVisit()
    {
        $visit = DB::table('tbl_visits')->get();
        return view('v_admin_sukajadi.daftar_pengunjung', compact('visit'));
    }

    // PNPB ========================================
    public function showReceipt($aksi, $id)
    {
        if ($aksi == 'buat') {
            $reservasi       = DB::table('tbl_reservations')
                                ->join('tbl_visitors', 'tbl_visitors.id_visitor','tbl_reservations.visitor_id')
                                ->where('id_reservation', $id)
                                ->first();
            $reservasidetail = DB::table('tbl_reservations_details')
                                ->join('tbl_reservations','tbl_reservations.id_reservation','tbl_reservations_details.reservation_id')
                                ->join('tbl_rental_rates','tbl_rental_rates.id_rental_rate','tbl_reservations_details.rental_rate_id')
                                ->join('tbl_rooms','tbl_rooms.id_room','tbl_rental_rates.room_id')
                                ->where('id_reservation', $id)->get();
            return view('v_admin_sukajadi.tambah_kwitansi', compact('reservasi','reservasidetail'));

        }elseif($aksi == 'cetak'){
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
            $pdf = PDF::loadView('v_admin_sukajadi.cetak_kwitansi', compact('reservasi','reservasidetail'))->setPaper($customPaper, 'landscape');

            return view('v_admin_sukajadi.cetak_kwitansi', compact('reservasi','reservasidetail'));
        }
    }

    // JSON =========================================
    public function jsonGetCategory(Request $request)
    {
        $result = DB::table('tbl_rental_rates')
                    ->select('price_ctg')
                    ->where('rental_rate_ctg', $request->rentalrateid)
                    ->groupBy('price_ctg')
                    ->pluck('price_ctg','price_ctg');

        return response()->json($result);
    }

    public function jsonGetPrice(Request $request)
    {
        if ($request ->categoryid == 'null') {
            $categoryid = null;
        }else{
            $categoryid = $request->categoryid;
        }

        $result = DB::table('tbl_rental_rates')
                    ->select('id_rental_rate','price')
                    ->where('rental_rate_ctg', $request->rentalrateid)
                    ->where('room_id', $request->roomid)
                    ->where('price_ctg', $categoryid)
                    ->groupBy('id_rental_rate','price')
                    ->pluck('price','id_rental_rate');

        return response()->json($result);
    }

    public function jsonGetRoom(Request $request)
    {
        $room       = DB::table('tbl_rooms')
                        ->whereNotIn('id_room', $request->dataroom)
                        ->where('room_status', 'tersedia')
                        ->get();
        $price      = DB::table('tbl_rental_rates')->select('rental_rate_ctg')->groupBy('rental_rate_ctg')->get();
        $price_ctg  = DB::table('tbl_rental_rates')->select('price_ctg')->groupBy('price_ctg')->get();

        $array['room']      = $room;
        $array['price']     = $price;
        $array['price_ctg'] = $price_ctg;

        return response()->json($array);
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
}

?>
