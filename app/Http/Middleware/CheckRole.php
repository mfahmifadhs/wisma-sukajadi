<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (Auth::user() == null) {
            return redirect('/')->with('failed', 'Anda tidak memiliki akses!');
        }
        if ($role == 'admin-master' && auth()->user()->role_id != 1) {
            abort(403);
        }

        if ($role == 'admin-roum' && auth()->user()->role_id != 2) {
            abort(403);
        }

        if ($role == 'admin-pnbp' && auth()->user()->role_id != 3) {
            abort(403);
        }
        if ($role == 'admin-sukajadi' && auth()->user()->role_id != 4) {
            abort(403);
        }
        if ($role == 'tamu' && auth()->user()->role_id != 5) {
            abort(403);
        }

        return $next($request);
    }
}
