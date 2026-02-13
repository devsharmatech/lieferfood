<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{

    public function handle($request, Closure $next)
    {
    $routeName = Route::currentRouteName();
    if (session('admin_user_id') || Auth::user()->role === 'admin') {
    // Allow admins or impersonated users to proceed
      return $next($request);
    }

    // Ensure permissions are loaded if not already loaded
    $user = Auth::user()->loadMissing('permissions');
    // dd($user);
   // Fetch the route names from the permissions
   $userPermissions = $user->permissions->pluck('route_name');



   // Check if the user has the required permission
   if (!$userPermissions->contains($routeName)) {
    abort(403, 'Unauthorized action.'); // Deny access if permission is missing
  }

   // Allow the request to proceed if permission is granted
   return $next($request);
}
}
