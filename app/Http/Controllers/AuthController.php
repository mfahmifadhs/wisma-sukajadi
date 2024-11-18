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
        $ssoBaseUrl  = "https://auth-eoffice.kemkes.go.id/";
        $clientId    = app('config')->get('services.sso.client_id');
        $redirectUri = "https://wisma-sukajadi.kemkes.go.id/auth/sso/callback";

        $redirectUrl = $ssoBaseUrl . "/oauth/authorize" . "?client_id=" . $clientId . "&redirect_uri=" . urlencode($redirectUri) . "&response_type=code";

        return Redirect::away($redirectUrl);
    }

    public function callback(Request $request)
    {
        $code = $request->query('code');

        $response = Http::asForm()->post(config('services.sso.base_url') . '/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.sso.client_id'),
            'client_secret' => config('services.sso.client_secret'),
            'redirect_uri' => config('services.sso.redirect'),
            'code' => $code,
        ]);

        $tokenData = $response->json();

        if (!isset($tokenData['access_token'])) {
            return redirect('/')->withErrors('Login failed. No response from eOffice.');
        }

        $userResponse = Http::withToken($tokenData['access_token'])->post(config('services.sso.base_url') . '/oauth/usertoken');
        $userData = $userResponse->json();

        if (empty($userData['nip'])) {
            return redirect('/')->withErrors('Login failed. NIP not found.');
        }

        $user = User::join('t_pegawai', 'id_pegawai', 'pegawai_id')
            ->where('nip', $userData['nip'])
            ->first();

        // if (!$user) {
        //     return redirect()->route('login')->with('failed', 'Pengguna tidak terdaftar');
        // }

        Auth::login($user);
        return redirect()->route('reservasi.book', $userData['nip']);
        // return redirect()->intended('dashboard');
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
