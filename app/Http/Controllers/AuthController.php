<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Hash;
use Auth;
use Session;
use DB;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.masuk');
    }

    public function redirect()
    {
        // redirect to SSO DTO
        return 'sso redirect';
    }

    public function callback()
    {
        // callback
        // $auth = get user from SSO DTO
        // $user = User::where('nip', $auth->nip)->first();
        return 'sso callback';
    }

    public function masuk(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')->with('success', 'Berhasil Masuk !');
        }
        return redirect("halaman-masuk")->with('failed', 'Username atau Password Salah !');
    }



    public function registration()
    {
        return view('daftar');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'full_name' => 'required',
            'username'  => 'required',
            'password'  => 'required|min:6',
        ]);
        $data = $request->all();
        $check = $this->create($data);
        return redirect("dashboard")->with('Success', 'Berhasil Login !');
    }


    public function create(array $data)
    {
        return User::create([
            'id'        => $data['id'],
            'role_id'   => '3',
            'full_name' => $data['full_name'],
            'username'  => $data['username'],
            'password'  => Hash::make($data['password']),
            'status_id' => '1',
        ]);
    }


    public function dashboard()
    {
        if (Auth::check() && Auth::user()->role_id == 1 && Auth::user()->status == 'aktif') {
            return redirect('admin-master/dashboard');
        } elseif (Auth::check() && Auth::user()->role_id == 4 && Auth::user()->status == 'aktif') {
            return redirect('admin-sukajadi/dashboard');
        } elseif (Auth::check() && Auth::user()->role_id == 3 && Auth::user()->status == 'aktif') {
            return redirect('admin-pnbp/dashboard');
        } else {
            return redirect("login")->with('failed', 'Anda tidak memiliki akses!');
        }
    }


    public function keluar()
    {
        Session::flush();
        Auth::logout();
        return Redirect('halaman-masuk');
    }

}
