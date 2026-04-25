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
use Carbon\Carbon;

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
          
 /* ---------------- Date Helpers ---------------- */
        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $monthStart = Carbon::now()->startOfMonth();

        /* ---------------- Orders Stats ---------------- */
        $todayOrders = Order::whereDate('created_at', $today)
            ->count();

        $todayPendingOrders = Order::where('order_status', 'pending')
            ->whereDate('created_at', $today)
            ->count();

        $todayCancelledOrders = Order::where('order_status', 'cancelled')
            ->whereDate('created_at', $today)
            ->count();

        $totalOrders = Order::count();

        $weeklyOrders = Order::where('created_at', '>=', $weekStart)
            ->count();

        $monthlyOrders = Order::where('created_at', '>=', $monthStart)
            ->count();

        $deliveredOrders = Order::where('order_status', 'delivered')
            ->count();
        $deliveryOrders = Order::where('method_type', 'delivery')
            ->count();
        $pickupOrders = Order::where('method_type', 'pickup')
            ->count();
        $totalOrders = Order::count();

        /* ---------------- Revenue Stats ---------------- */
        $todayRevenue = Order::where('order_status', 'delivered')
            ->whereDate('created_at', $today)
            ->sum('total_amount');

        $weeklyRevenue = Order::where('order_status', 'delivered')
            ->where('created_at', '>=', $weekStart)
            ->sum('total_amount');

        $monthlyRevenue = Order::where('order_status', 'delivered')
            ->where('created_at', '>=', $monthStart)
            ->sum('total_amount');

        $totalRevenue = Order::where('order_status', 'delivered')
            ->sum('total_amount');

        $avgOrderValue = Order::where('order_status', 'delivered')
            ->avg('total_amount');

        /* ---------------- Customer Stats ---------------- */
        $totalCustomers = Order::distinct('user_id')
            ->count('user_id');

        $todayCustomers = Order::whereDate('created_at', $today)
            ->distinct('user_id')
            ->count('user_id');

        return view('admin.welcome', compact(
            'quote',
            'author',
         
            'todayOrders',
            'todayPendingOrders',
            'todayCancelledOrders',
            'todayRevenue',
            'weeklyOrders',
            'monthlyOrders',
            'totalOrders',
            'deliveredOrders',
            'weeklyRevenue',
            'monthlyRevenue',
            'totalRevenue',
            'avgOrderValue',
            'totalCustomers',
            'todayCustomers',
            'totalOrders',
            'deliveryOrders',
            'pickupOrders'
        ));
    }
}
