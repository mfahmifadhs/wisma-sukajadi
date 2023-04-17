<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProtectStorageDirectory
{
    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();
        if (strpos($path, 'images/') !== false) {
            return response()->json(['message' => 'Access Denied'], 403);
        }

        return $next($request);
    }
}
