<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    //
    public function login()
    {
        return view('admin.admin-auth.login');
    }
    public function signin(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            ['email' => ['required', 'email'], 'password' => ['required']]
        );
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Email or password is incorrect']);
        } else {
            $user = User::where('email', $request->email)->with('vendor_details')->first();
            // dd($user);
            if ($user) {
                if (password_verify($request->password, $user->password)) {
                    
                    if ($user->role == "admin") {
                        Auth::login($user);
                        return redirect()->route('admin.dashboard')->with(['alert-type' => 'success', 'message' => 'Successfully admin login']);
                    } else {
                        return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Only admin can access this!']);
                    }
                } else {
                    return back()->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Email or password is incorrect']);
                }
            } else {
                return back()->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Email or password is incorrect']);
            }
        }
    }
    
    public function loginVendor()
    {
        return view('admin.admin-auth.login-vendor');
    }
    public function signinVendor(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            ['email' => ['required', 'email'], 'password' => ['required']]
        );
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Email or password is incorrect']);
        } else {
            $user = User::where('email', $request->email)->with('vendor_details')->first();
            // dd($user);
            if ($user) {
                if (password_verify($request->password, $user->password)) {
                    
                    if ($user->role == "vendor") {
                        Auth::login($user);
                        return redirect()->route('vendor.dashboard')->with(['alert-type' => 'success', 'message' => 'Successfully shop login']);
                    } else {
                        return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Only shop can access this!']);
                    }
                } else {
                    return back()->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Email or password is incorrect']);
                }
            } else {
                return back()->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Email or password is incorrect']);
            }
        }
    }
    public function logout()
    {
        $role=Auth::user()->role;
        Auth::logout();
        if($role=="admin"){
           return redirect()->route('admin.login')->with(['alert-type' => 'success', 'message'
            => 'Successfully admin sign out']); 
        }else{
          return redirect()->route('vendor.login')->with(['alert-type' => 'success', 'message'
            => 'Successfully shop sign out']);   
        }
    }

    public function dashboard()
    {

        try {
            $response = Http::withoutVerifying()->timeout(5)->get('https://api.quotable.io/random');

            if ($response->successful()) {
                $quoteData = $response->json();
                $quote = $quoteData['content'];
                $author = $quoteData['author'];
            } else {
                $quote = "The best way to predict your future is to create it.";
                $author = "Abraham Lincoln";
            }
        } catch (\Exception $e) {
            Log::error('Quote API error: ' . $e->getMessage());
            $quote = "The best way to predict your future is to create it.";
            $author = "Abraham Lincoln";
        }
        $today = now()->toDateString();
        $todayOrders = Order::whereDate('created_at', $today)
            ->count();
        $todayPendingOrders = Order::where('order_status', 'pending')
            ->whereDate('created_at', $today)
            ->count();
        $todayCancelledOrders = Order::where('order_status', 'cancelled')
            ->whereDate('created_at', $today)
            ->count();
        $todayRevenue = Order::where('order_status', 'delivered')
            ->whereDate('created_at', $today)
            ->sum('total_amount');
       return view('admin.welcome',compact('quote', 'author','todayOrders','todayPendingOrders','todayCancelledOrders','todayRevenue'));     
    }
}
