<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Pengunjung;
use App\Models\Reservasi;
use App\Models\ReservasiDetail;
use App\Models\Status;
use App\Models\TarifSewa;
use App\Models\UnitKerja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Http;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $listStatus = Status::whereIn('id_status', [10, 11, 12, 13, 14])->orderBy('nama_status', 'ASC');
        $reservasi  = Reservasi::orderBy('t_reservasi.tanggal_reservasi', 'DESC')->whereYear('tanggal_reservasi', 2024);
        $bulan      = [];
        $bulanPick  = [];
        $statusPick = [];

        for ($i = 1; $i <= 12; $i++) {
            $listBulan[] = [
                'id'         => $i,
                'nama_bulan' => Carbon::now()->locale('id')->month($i)->isoFormat('MMMM')
            ];
        }

        // filter
        if ($request->bulan || $request->status || $request->date) {
            if ($request->bulan) {
                $selectedBulan = explode(',', $request->bulan);
                $bulan = collect($listBulan)->where('id', '!=', $request->bulan)->all();
                $bulanPick = collect($listBulan)->filter(function ($item) use ($selectedBulan) {
                    return in_array($item['id'], $selectedBulan);
                });

                $search = $reservasi->where(DB::raw("DATE_FORMAT(t_reservasi.tanggal_reservasi, '%c')"), $request->bulan);
            } else {
                $bulan    = $listBulan;
            }


            if ($request->status) {
                $search     = $reservasi->where('status_reservasi', $request->status);
                $status     = $listStatus->get();
                $statusPick = Status::where('id_status', $request->status)->first();
            } else {
                $status = $listStatus->get();
            }

            if ($request->date) {
                $search     = $reservasi->where(DB::raw("DATE_FORMAT(tanggal_reservasi, '%d-%m-%Y')"), $request->date);
            }

            $reservasi = $search->get();
            $tab       = 2;
        } else {
            $status    = $listStatus->get();
            $bulan     = $listBulan;
            $reservasi = $reservasi->get();
        }

        return view('pages.reservasi.show', compact('reservasi', 'bulanPick', 'bulan', 'statusPick', 'status'));
    }

    public function show()
    {
        $reservasi  = Reservasi::orderBy('t_reservasi.tanggal_reservasi', 'DESC')->orderBy('status_reservasi', 'ASC')
            ->whereYear('tanggal_reservasi', 2024)->get();
        return view('pages.reservasi.data', compact('reservasi'));
    }

    public function create($id)
    {
        $kamar = [];
        $tarif = [];
        $unitKerja = UnitKerja::get();
        $reservasi = Reservasi::where('id_reservasi', $id)->first();

        if ($reservasi) {
            $kamar  = Kamar::get();
            $tarif  = TarifSewa::groupBy('kategori_tamu')->pluck('kategori_tamu');
            $status = $reservasi->status_reservasi;
        } else {
            $status = '';
        }

        return view('pages.reservasi.create', compact('unitKerja', 'id', 'reservasi', 'kamar', 'tarif', 'status'));
    }

    public function store(Request $request)
    {
        if (!$request->status) {
            $pengunjung   = str_pad(Pengunjung::withTrashed()->count() + 1, 4, 0, STR_PAD_LEFT);
            $idPengunjung = (int) Carbon::now()->isoFormat('YYMMDD') . $pengunjung;

            $tPengunjung  = new Pengunjung();
            $tPengunjung->id_pengunjung     = $idPengunjung;
            $tPengunjung->unit_kerja_id     = $request->unit_kerja_id;
            $tPengunjung->nik               = $request->nik;
            $tPengunjung->nama_pengunjung   = $request->nama_pengunjung;
            $tPengunjung->tanggal_lahir     = $request->tanggal_lahir;
            $tPengunjung->no_hp             = $request->no_hp;
            $tPengunjung->alamat            = $request->alamat;
            $tPengunjung->instansi          = $request->instansi;
            $tPengunjung->keterangan        = $request->instansi == 'kemenkes' ? $request->jabatan : $request->keterangan;
            $tPengunjung->created_at        = Carbon::now();
            $tPengunjung->save();

            if ($request->foto_ktp) {
                $file  = $request->file('foto_ktp');
                $filename = $file->getClientOriginalName();
                $foto = $file->storeAs('public/files/foto_ktp', $filename);
                $foto_ktp = Crypt::encrypt($filename);
                Pengunjung::where('id_pengunjung', $idPengunjung)->update(['foto_ktp' => $foto_ktp]);
            }

            $reservasi   = str_pad(Reservasi::withTrashed()->count() + 1, 4, 0, STR_PAD_LEFT);
            $idReservasi = (int) Carbon::now()->isoFormat('YYMMDD') . $reservasi;

            $tReservasi = new Reservasi();
            $tReservasi->id_reservasi     = $idReservasi;
            $tReservasi->pengunjung_id    = $idPengunjung;
            $tReservasi->status_reservasi = 10;
            $tReservasi->tanggal_reservasi = $request->tgl_reservasi;
            $tReservasi->created_at       = Carbon::now();
            $tReservasi->save();

            if ($request->surat_tugas) {
                $file  = $request->file('surat_tugas');
                $filename = $file->getClientOriginalName();
                $surat = $file->storeAs('public/files/surat_tugas', $filename);
                $surat_tugas = Crypt::encrypt($filename);
                Reservasi::where('id_reservasi', $idReservasi)->update(['surat_tugas' => $surat_tugas]);
            }
        }

        if ($request->status == 10) {
            $totalPembayaran = 0;
            $idReservasi = $request->id_reservasi;
            $kamar = $request->kamar_id;
            foreach ($kamar as $i => $kamar_id) {
                $durasi  = Carbon::parse($request->check_in[$i])->diffInDays(Carbon::parse($request->check_out[$i]));
                $tarif   = TarifSewa::where('kamar_id', $kamar_id)->where('kategori_tamu', $request->tarif[$i])->first();
                $tDetail = new ReservasiDetail();
                $tDetail->reservasi_id      = $idReservasi;
                $tDetail->tarif_sewa_id     = $tarif->id_tarif_sewa;
                $tDetail->tanggal_check_in  = $request->check_in[$i];
                $tDetail->tanggal_check_out = $request->check_out[$i];
                $tDetail->total_harga       = $tarif->harga_sewa * $durasi;
                $tDetail->keterangan        = $request->keterangan;
                $tDetail->created_at        = Carbon::now();
                $tDetail->save();
                $totalPembayaran += $tarif->harga_sewa * $durasi;
            }

            Reservasi::where('id_reservasi', $idReservasi)->update([
                'status_reservasi' => 11,
                'total_pembayaran' => $totalPembayaran
            ]);
        }

        if ($request->status == 11) {
            $idReservasi = $request->id_reservasi;
            if ($request->bukti_bayar) {
                $file  = $request->file('bukti_bayar');
                $maxFileSize = 5 * 1024 * 1024; // 2 MB dalam bytes

                if ($file->getSize() > $maxFileSize) {
                    return back()->with('Ukuran file lebih dari 5 MB');
                }

                $filename = $file->getClientOriginalName();
                $foto = $file->storeAs('public/files/bukti_pembayaran', $filename);
                $bukti_bayar = Crypt::encrypt($filename);
                Reservasi::where('id_reservasi', $idReservasi)->update([
                    'bukti_pembayaran' => $bukti_bayar
                ]);
            }

            Reservasi::where('id_reservasi', $idReservasi)->update([
                'tanggal_pembayaran' => $request->tgl_bayar,
                'kode_biling'      => $request->kode_biling,
                'status_reservasi' => 12
            ]);

            foreach ($request->kamar_id as $i => $kamar_id) {
                Kamar::where('id_kamar', $kamar_id)->update(['status_kamar' => 6]);
            }
        }

        if ($request->status == 12 || $request->status == 13) {
            $idReservasi = $request->id_reservasi;
            Reservasi::where('id_reservasi', $idReservasi)->update([
                'status_reservasi' => $request->status + 1
            ]);
            $id_detail = $request->id_detail;
            foreach ($id_detail as $i => $id) {
                $detail = ReservasiDetail::where('id_detail', $id)->first();
                ReservasiDetail::where('id_detail', $id)->update([
                    'waktu_check_in'  => Carbon::now(),
                    'waktu_check_out' => $request->status == 13 ? Carbon::now() : null
                ]);

                if ($request->status == 13) {
                    $tarif = TarifSewa::where('id_tarif_sewa', $detail->tarif_sewa_id)->first();
                    Kamar::where('id_kamar', $tarif->kamar_id)->update(['status_kamar' => 7]);
                }
            }
        }

        return redirect()->route('reservasi.show')->with('success', 'Berhasil memproses reservasi');
    }

    public function detail($id)
    {
        $kamar  = [];
        $tarif  = [];
        $status = Status::whereIn('id_status', [10, 11, 12, 13, 14])->get();
        $reservasi = Reservasi::where('id_reservasi', $id)->first();

        return view('pages.reservasi.detail', compact('id', 'reservasi', 'kamar', 'tarif', 'status'));
    }

    public function edit($id)
    {
        $kamar = [];
        $tarif = [];
        $unitKerja = UnitKerja::get();
        $reservasi = Reservasi::where('id_reservasi', $id)->first();

        if ($reservasi) {
            $kamar  = Kamar::get();
            $tarif  = TarifSewa::groupBy('kategori_tamu')->pluck('kategori_tamu');
            $status = $reservasi->status_reservasi;
        } else {
            $status = '';
        }

        return view('pages.reservasi.edit', compact('unitKerja', 'id', 'reservasi', 'kamar', 'tarif', 'status'));
    }

    public function update(Request $request, $id)
    {
        $reservasi  = Reservasi::where('id_reservasi', $id)->first();
        $pengunjung = Pengunjung::where('id_pengunjung', $reservasi->pengunjung_id)->first();
        // Update informasi pengunjung
        Pengunjung::where('id_pengunjung', $pengunjung->id_pengunjung)->update([
            'unit_kerja_id'   => $request->unit_kerja_id,
            'nik'             => $request->nik,
            'nama_pengunjung' => $request->nama_pengunjung,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'no_hp'           => $request->no_hp,
            'alamat'          => $request->alamat,
            'instansi'        => $request->instansi,
            'keterangan'      => $request->instansi == 'kemenkes' ? $request->jabatan : $request->keterangan
        ]);

        if ($request->foto_ktp) {
            $file  = $request->file('foto_ktp');
            $filename = $file->getClientOriginalName();
            $foto = $file->storeAs('public/files/foto_ktp', $filename);
            $foto_ktp = Crypt::encrypt($filename);

            if ($pengunjung->foto_ktp) {
                Storage::delete('public/files/foto_ktp/' . Crypt::decrypt($pengunjung->foto_ktp));
            }

            Pengunjung::where('id_pengunjung', $pengunjung->id_pengunjung)->update(['foto_ktp' => $foto_ktp]);
        }

        // Update informasi kamar
        if ($request->status > 10) {
            $totalPembayaran = 0;
            $detail = $request->id_detail;

            foreach ($detail as $i => $detail_id) {
                $durasi  = Carbon::parse($request->check_in[$i])->diffInDays(Carbon::parse($request->check_out[$i]));
                $tarif   = TarifSewa::where('kamar_id', $request->kamar_id[$i])->where('kategori_tamu', $request->tarif[$i])->first();
                if ($detail_id == 'null') {
                    $tDetail = new ReservasiDetail();
                    $tDetail->reservasi_id      = $id;
                    $tDetail->tarif_sewa_id     = $tarif->id_tarif_sewa;
                    $tDetail->tanggal_check_in  = $request->check_in[$i];
                    $tDetail->tanggal_check_out = $request->check_out[$i];
                    $tDetail->total_harga       = $tarif->harga_sewa * $durasi;
                    $tDetail->keterangan        = $request->keterangan[$i];
                    $tDetail->created_at        = Carbon::now();
                    $tDetail->save();

                    Kamar::where('id_kamar', $tarif->kamar_id)->update(['status_kamar' => 6]);
                } else {
                    ReservasiDetail::where('id_detail', $detail_id)->update([
                        'tarif_sewa_id'     => $tarif->id_tarif_sewa,
                        'tanggal_check_in'  => $request->check_in[$i],
                        'tanggal_check_out' => $request->check_out[$i],
                        'total_harga'       => $tarif->harga_sewa * $durasi,
                        'deleted_at'        => $request->status_batal[$i] == 'true' ? Carbon::now() : null
                    ]);

                    if ($request->status_batal[$i] == 'true') {
                        Kamar::where('id_kamar', $tarif->kamar_id)->update(['status_kamar' => 5]);
                    }
                }

                $totalPembayaran += $tarif->harga_sewa * $durasi;
            }
            $totalPembayaran = ReservasiDetail::select(DB::RAW('sum(total_harga) AS total'))->where('reservasi_id', $id)->first();
            Reservasi::where('id_reservasi', $id)->update([
                'total_pembayaran'  => $totalPembayaran->total
            ]);
        }

        if ($request->status > 11) {
            if ($request->bukti_bayar) {
                $file  = $request->file('bukti_bayar');
                $maxFileSize = 5 * 1024 * 1024; // 2 MB dalam bytes

                if ($file->getSize() > $maxFileSize) {
                    return back()->with('Ukuran file lebih dari 5 MB');
                }

                $filename = $file->getClientOriginalName();
                $foto = $file->storeAs('public/files/bukti_pembayaran', $filename);
                $bukti_bayar = Crypt::encrypt($filename);

                if ($reservasi->bukti_pembayaran) {
                    Storage::delete('public/files/bukti_pembayaran/' . Crypt::decrypt($reservasi->bukti_pembayaran));
                }

                Reservasi::where('id_reservasi', $id)->update(['bukti_pembayaran' => $bukti_bayar]);
            }

            Reservasi::where('id_reservasi', $id)->update(['kode_biling' => $request->kode_biling]);
        }

        return redirect()->route('reservasi.edit', $id)->with('success', 'Berhasil menyimpan perubahan');
    }

    public function destroy($id)
    {
        $reservasi = Reservasi::where('id_reservasi', $id)->first();
        Reservasi::where('id_reservasi', $id)->delete();
        Pengunjung::where('id_pengunjung', $reservasi->pengunjung_id)->delete();
        ReservasiDetail::where('reservasi_id', $id)->delete();

        return redirect()->route('reservasi.show')->with('success', 'Berhasil Menghapus');
    }

    public function print($id)
    {
        $reservasi = Reservasi::where('id_reservasi', $id)->first();
        return view('pages.reservasi.print', compact('id', 'reservasi'));
    }

    public function book(Request $request, $id)
    {
        $pegawai = '';
        $nik     = $id ?? null;
        $proses  = $request->get('proses');
        $kamar   = $request->get('kamar') ?? null;
        $masuk   = $request->get('masuk') ?? null;
        $keluar  = $request->get('keluar') ?? null;
        $uker    = UnitKerja::get();
        if (!$proses) {
            if ($id != 'umum') {
                $id = 'kemenkes';
            }

            return view('reservasi', compact('id', 'nik', 'pegawai', 'kamar', 'masuk', 'keluar', 'uker'));
        } else {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => '6LcVm4YqAAAAAO8020bjfHf8aBp_SP8dnCuNKkf_',
                'response' => $request->input('g-recaptcha-response'),
            ]);
            $responseBody = $response->json();

            if (!$responseBody['success']) {
                return back()->with('error', 'Verifikasi CAPTCHA gagal. Silakan coba lagi.');
            }

            $pengunjung = str_pad(Pengunjung::withTrashed()->count() + 1, 4, 0, STR_PAD_LEFT);
            $idTamu     = (int) Carbon::now()->isoFormat('YYMMDD') . $pengunjung;

            $tamu = new Pengunjung();
            $tamu->id_pengunjung = $idTamu;
            $tamu->nama_pengunjung = ucwords(strtolower($request->nama));
            $tamu->no_hp           = $request->nohp;
            $tamu->nik             = $request->instansi == 'kemenkes' ? $request->nik : null;
            $tamu->instansi        = $request->instansi;
            $tamu->unit_kerja_id   = $request->instansi == 'kemenkes' ? $request->uker : null;
            $tamu->keterangan      = ucwords(strtolower($request->nama_instansi));
            $tamu->created_at      = Carbon::now();
            $tamu->save();

            $reservasi   = str_pad(Reservasi::withTrashed()->count() + 1, 4, 0, STR_PAD_LEFT);
            $idReservasi = (int) Carbon::now()->isoFormat('YYMMDD') . $reservasi;

            $reservasi = new Reservasi();
            $reservasi->id_reservasi      = $idReservasi;
            $reservasi->pengunjung_id     = $idTamu;
            $reservasi->tanggal_reservasi = Carbon::now();
            $reservasi->status_reservasi  = 10;
            $reservasi->total_kamar       = $kamar;
            $reservasi->tanggal_masuk     = $masuk;
            $reservasi->tanggal_keluar    = $keluar;
            $reservasi->created_at        = Carbon::now();
            $reservasi->save();

            return redirect()->route('reservasi.etiket', $idReservasi)->with('success', 'Berhasil Melakukan Reservasi');
        }
    }

    public function etiket(Request $request, $id)
    {
        if ($id == 'cari') {
            $data = Reservasi::where('id_reservasi', $request->id_reservasi)->where('status_reservasi', 10)->first();
        } else {
            $data = Reservasi::where('id_reservasi', $id)->where('status_reservasi', 10)->first();
        }

        if (!$data) {
            return back()->with('failed', 'Reservasi Tidak Ditemukan');
        }

        return view('etiket', compact('data'));
    }
}
