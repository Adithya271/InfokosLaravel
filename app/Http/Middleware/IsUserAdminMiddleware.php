<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class IsUserAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna yang diautentikasi adalah UserAdmin
        if (Auth::check() && (Auth::user() instanceof \App\Models\UserAdmin)) {
            return $next($request);
        }
        
        return redirect()->route('login');

        return response()->json([
            'success' => false,
            'message' => 'Anda tidak memiliki izin untuk mengakses sumber daya ini.'
        ], 403);
    }
}
