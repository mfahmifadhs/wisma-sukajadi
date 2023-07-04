<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Hash;

class UserController extends Controller
{
    public function show()
    {
        $user = User::get();
        return view ('pages.user.show', compact('user'));
    }

    public function create()
    {
        $role    = Role::get();
        $pegawai = Pegawai::get();
        $status  = Status::get();
        return view ('pages.user.create', compact('role','pegawai','status'));
    }

    public function store(Request $request)
    {
        $format  = str_pad(Pegawai::count() + 1, 3, 0, STR_PAD_LEFT);
        $id      = Carbon::now()->isoFormat('YYMMDD').$format;
        $pegawai = Pegawai::where('id_pegawai', $request->pegawai_id)->first();

        $tambah = new User();
        $tambah->id             = $id;
        $tambah->role_id        = $request->role_id;
        $tambah->pegawai_id     = $request->pegawai_id;
        $tambah->username       = $pegawai->nip;
        $tambah->password       = Hash::make($request->password);
        $tambah->password_text  = $request->password;
        $tambah->status_id      = $request->status_id;
        $tambah->save();

        return redirect()->route('user.show')->with('success', 'Berhasil membuat user');
    }

    public function detail($id)
    {
        $user = User::where('id', $id)->first();
        return view ('pages.user.detail', compact('user'));
    }

    public function edit($id)
    {
        $status  = Status::where('kategori','user')->get();
        $role    = Role::get();
        $pegawai = Pegawai::get();
        $user    = User::where('id', $id)->first();
        return view ('pages.user.edit', compact('status','role','pegawai','user'));
    }

    public function update(Request $request, $id)
    {
        User::where('id', $id)->update([
            'role_id'        => $request->role_id,
            'password'       => Hash::make($request->password),
            'password_text'  => $request->password,
            'status_id'      => $request->status_id
        ]);
        return redirect()->route('user.show')->with('success', 'Berhasil menyimpan perubahan');
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return redirect()->route('user.show')->with('success', 'Berhasil menghapus user');
    }
}
