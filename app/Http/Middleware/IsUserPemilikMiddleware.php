<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsUserPemilikMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna yang diautentikasi adalah UserPemilik
        if (Auth::check() && (Auth::user() instanceof \App\Models\UserPemilik)) {
            return $next($request);
        }

        return response()->json([
            'success' => false,
            'message' => 'Anda tidak memiliki izin untuk mengakses sumber daya ini.'
        ], 403);
    }
}
