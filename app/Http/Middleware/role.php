<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class role
{

    public function handle(Request $request, Closure $next, $role): Response
    {
        // dd($role);
        if (!Auth::check() || Auth::user()->role !== $role) {
            if ($role == 'admin') {
                return redirect()->route('admin.login');
            } elseif ($role == 'user') {
                return redirect()->route('login');
            } elseif ($role == 'vendor') {
                return redirect()->route('vendor.login');
            } else {
                abort(403, 'Unauthorized action.');
            }
        }else{
            return $next($request);
        }

    }
}
