<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Hash;
use Auth;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.masuk');
    }

    public function redirect()
    {
        // redirect to SSO DTO
        // $ssoBaseUrl = "https://auth-dev-eoffice.kemkes.go.id";
        // $clientId = env("SSO_CLIENT_ID", "993fe200-4df3-4f99-986a-424bed9edaa9");
        // $redirectUri = env("SSO_CLIENT_ID", "https://wisma-sukajadi.kemkes.go.id/");



        $ssoBaseUrl  = "https://auth-dev-eoffice.kemkes.go.id";
        $clientId    = app('config')->get('services.sso.client_id');
        $redirectUri = "https://wisma-sukajadi.kemkes.go.id";

        $redirectUrl = $ssoBaseUrl . "/oauth/authorize" . "?client_id=" . $clientId . "&redirect_uri=" . urlencode($redirectUri) . "&response_type=code";

        return Redirect::away($redirectUrl);
    }

    public function callback()
    {
        // callback
        // $auth = get user from SSO DTO
        // $user = User::where('nip', $auth->nip)->first();
        // $user = Socialite::driver('dto')->user();
        // $akun = User::where('nip', $user->nip)->first();
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
        return redirect()->route('dashboard')->with('Selamat Datang di Wisma Sukajadi Bandung');
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


    // public function dashboard()
    // {
    //     if (Auth::check()) {
    //         return redirect()->route('dashboard')->with('success', 'Selamat Datang di Wisma Sukajadi Bandung');
    //     } else {
    //         return redirect("login")->with('failed', 'Anda tidak memiliki akses!');
    //     }
    // }


    public function keluar()
    {
        Session::flush();
        Auth::logout();
        return Redirect('halaman-masuk');
    }

}
