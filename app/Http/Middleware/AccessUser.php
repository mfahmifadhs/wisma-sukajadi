<?php

namespace App\Http\Middleware;

use App\Model\submissionModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $status)
    {
        if(Auth::user() == null){
            return redirect('/')->with('failed','Anda tidak memiliki akses!');
        }

        $role = Auth::user()->role_id;


        if ($status == 'private')
        {
            if ($role == 1) {
                return $next($request);
            } else {
                return back()->with('failed','Anda tidak memiliki akses!');
            }
        }

        if ($status == 'admin')
        {
            if ($role == 4) {
                return $next($request);
            } else {
                return back()->with('failed','Anda tidak memiliki akses!');
            }
        }

        if ($status == 'public')
        {
            if ($role == 1 || $role == 2 || $role == 3 || $role == 4) {
                return $next($request);
            } else {
                return back()->with('failed','Anda tidak memiliki akses!');
            }
        }



        return $next($request);
    }
}
