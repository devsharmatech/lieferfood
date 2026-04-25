<?php

namespace App\Http\Controllers\admin\vendor;

use App\Events\vendorRegister;
use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\country;
use App\Models\Order;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\vendor_detail;
use App\Models\VendorDocument;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Carbon\Carbon;

class VendorController extends Controller
{
    //



public function dashboard()
{
    if (isset(Auth::user()->id) && Auth::user()->isVendorDetail == 1) {

        $vendorId = Auth::user()->id;
        $vendor_detail_al = vendor_detail::where('vendor_id', $vendorId)->first();

        /* ---------------- Quote API ---------------- */
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
        $todayOrders = Order::where('vendor_id', $vendorId)
            ->whereDate('created_at', $today)
            ->count();

        $todayPendingOrders = Order::where('vendor_id', $vendorId)
            ->where('order_status', 'pending')
            ->whereDate('created_at', $today)
            ->count();

        $todayCancelledOrders = Order::where('vendor_id', $vendorId)
            ->where('order_status', 'cancelled')
            ->whereDate('created_at', $today)
            ->count();

        $totalOrders = Order::where('vendor_id', $vendorId)->count();

        $weeklyOrders = Order::where('vendor_id', $vendorId)
            ->where('created_at', '>=', $weekStart)
            ->count();

        $monthlyOrders = Order::where('vendor_id', $vendorId)
            ->where('created_at', '>=', $monthStart)
            ->count();

        $deliveredOrders = Order::where('vendor_id', $vendorId)
            ->where('order_status', 'delivered')
            ->count();
        $deliveryOrders = Order::where('vendor_id', $vendorId)
            ->where('method_type', 'delivery')
            ->count();
        $pickupOrders = Order::where('vendor_id', $vendorId)
            ->where('method_type', 'pickup')
            ->count();
        $totalOrders = Order::where('vendor_id', $vendorId)
            ->count();

        /* ---------------- Revenue Stats ---------------- */
        $todayRevenue = Order::where('vendor_id', $vendorId)
            ->where('order_status', 'delivered')
            ->whereDate('created_at', $today)
            ->sum('total_amount');

        $weeklyRevenue = Order::where('vendor_id', $vendorId)
            ->where('order_status', 'delivered')
            ->where('created_at', '>=', $weekStart)
            ->sum('total_amount');

        $monthlyRevenue = Order::where('vendor_id', $vendorId)
            ->where('order_status', 'delivered')
            ->where('created_at', '>=', $monthStart)
            ->sum('total_amount');

        $totalRevenue = Order::where('vendor_id', $vendorId)
            ->where('order_status', 'delivered')
            ->sum('total_amount');

        $avgOrderValue = Order::where('vendor_id', $vendorId)
            ->where('order_status', 'delivered')
            ->avg('total_amount');

        /* ---------------- Customer Stats ---------------- */
        $totalCustomers = Order::where('vendor_id', $vendorId)
            ->distinct('user_id')
            ->count('user_id');

        $todayCustomers = Order::where('vendor_id', $vendorId)
            ->whereDate('created_at', $today)
            ->distinct('user_id')
            ->count('user_id');

        return view('vendor.vendor-dashboard', compact(
            'quote',
            'author',
            'vendor_detail_al',
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

    } else {
        return redirect()->route('vendor.my.profile')
            ->with(['alert-type' => 'warning', 'message' => 'Please first complete your profile.']);
    }
}


    public function dashboard_()
    {
        if (isset(Auth::user()->id) && Auth::user()->isVendorDetail == 1) {


            $vendor_detail_al = vendor_detail::where('vendor_id', Auth::user()->id)->first();
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
            $todayOrders = Order::where('vendor_id', Auth::user()->id)
                ->whereDate('created_at', $today)
                ->count();
            $todayPendingOrders = Order::where('vendor_id', Auth::user()->id)
                ->where('order_status', 'pending')
                ->whereDate('created_at', $today)
                ->count();
            $todayCancelledOrders = Order::where('vendor_id', Auth::user()->id)
                ->where('order_status', 'cancelled')
                ->whereDate('created_at', $today)
                ->count();
            $todayRevenue = Order::where('vendor_id', Auth::user()->id)
                ->where('order_status', 'delivered')
                ->whereDate('created_at', $today)
                ->sum('total_amount');

            return view('vendor.vendor-dashboard', compact('quote', 'author', 'vendor_detail_al','todayOrders','todayPendingOrders','todayCancelledOrders','todayRevenue'));
        } else {
            return redirect()->route('vendor.my.profile')->with(['alert-type' => 'warning', 'message' => 'Please first complete your profile.']);
        }
    }

    public function editVendorProfile()
    {
        $id = Auth::user()->id;
        $categories = category::orderBy('name', 'ASC')->where('vendor_id', null)->get();
        // dd($categories);
        $countries = country::orderBy('name', 'ASC')->get();
        $user = User::where(['id' => $id, 'role' => 'vendor'])->with('vendor_details')->first();
        if (!empty($user)) {
            return view('vendor.my-profile', compact('user', 'countries', 'categories'));
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Your account not found!']);
        }
    }

    public function updateVendorStatusMYOLD(Request $request)
    {
        $vendor = vendor_detail::where('vendor_id', $request->vendor_id)->first();
        if ($vendor) {
            if($request->col=="restaurant_status" && $request->restaurant_status==0){
                $vendor->isDelivery = 0;
                $vendor->isPickup = 0;
                $vendor->restaurant_status = 0;
            }else{
                $vendor[$request->col] = $request->restaurant_status;
            }
            
            $vendor->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

public function updateVendorStatus(Request $request)
{
    $vendor = vendor_detail::where('vendor_id', $request->vendor_id)->first();
    if (!$vendor) {
        return response()->json(['success' => false]);
    }
    if ($request->col == "restaurant_status" && $request->restaurant_status == 0) {
        $vendor->isDelivery = 0;
        $vendor->isPickup = 0;
        $vendor->restaurant_status = 0;

        // 🔁 Also update opening times table
        DB::table('vendor_opening_times')
            ->where('vendor_id', $request->vendor_id)
            ->update([
                'is_delivery' => 0,
                'is_pickup' => 0,
            ]);
    } else {
        
        $vendor[$request->col] = $request->restaurant_status;
        
        if ($request->col == "isPickup") {
            DB::table('vendor_opening_times')
                ->where('vendor_id', $request->vendor_id)
                ->update([
                    'is_pickup' => $request->restaurant_status
                ]);
        }

        if ($request->col == "isDelivery") {
            DB::table('vendor_opening_times')
                ->where('vendor_id', $request->vendor_id)
                ->update([
                    'is_delivery' => $request->restaurant_status
                ]);
        }
    }

    $vendor->save();

    return response()->json(['success' => true]);
}

    public function index()
    {
        $users = User::latest()->where('role', 'vendor')->get();
        return view('admin.vendor-manager.all-vendors', compact('users'));
    }

    public function vendorDocuments()
    {
        $documents = VendorDocument::latest()->with('vendor')->get();
        return view('admin.vendor-manager.vendor-document', compact('documents'));
    }

    public function addVendorDocument()
    {
        $users = User::latest()
            ->where('role', 'vendor')
            ->whereDoesntHave('document')
            ->get();
        return view('admin.vendor-manager.upload-document', compact('users'));
    }

    public function create()
    {
        return view('admin.vendor-manager.create-vendor');
    }

    public function store(Request $request)
    {
        $request['unid'] = uniqid('DHILL');
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'unid' => 'required|unique:users,unid',
            'image' => 'nullable|image',
        ]);
        // generate a random password
        $password = Str::random(8);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->unid = $request->unid;
        $user->password = bcrypt($password);
        $user->role = 'vendor';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $manager = new ImageManager(Driver::class);


            $image = $manager->read($file);
            $filename = uniqid('profile_') . '.' . $file->getClientOriginalExtension();
            $image->resize(400, 400)->save(public_path('uploads/users/' . $filename));
            $user->profile = $filename;
        }
        $user->save();
        $user->fpassword = $password;
        event(new vendorRegister($user));
        return redirect()->route('admin.all.vendor')->with(['alert-type' => 'success', 'message' => 'Vendor created successfully']);
    }
    // public function update(Request $request)
    // {
    //     $request->validate([
    //         'id' => 'required|exists:users,id',
    //         'name' => 'required',
    //         'surname' => 'nullable|string',
    //         'email' => 'required|unique:users,email,' . $request->id,
    //         'phone' => 'required|unique:users,phone,' . $request->id,
    //         'image' => 'nullable|image',
    //         'state' => 'nullable|string',
    //         'address' => 'nullable|string',
    //         'country' => 'nullable|string',
    //         'city' => 'required|string',
    //         'zipcode' => 'nullable|string',
    //         'language' => 'nullable|string',
    //         'status' => 'required',
    //     ]);

    //     $user = User::where('id', $request->id)->first();
    //     if (!empty($user)) {

    //         $user->name = $request->name;
    //         $user->surname = $request->surname;
    //         $user->email = $request->email;
    //         $user->phone = $request->phone;
    //         $user->state = $request->state;
    //         $user->city = $request->city;
    //         $user->address = $request->address;
    //         $user->country = $request->country;
    //         $user->zipcode = $request->zipcode;
    //         $user->language = $request->language;
    //         $user->accountStatus = $request->status;
    //         if ($request->hasFile('image')) {
    //             $file = $request->file('image');
    //             $manager = new ImageManager(Driver::class);
    //             $oldPath = public_path('uploads/users/' . $user->profile);
    //             $image = $manager->read($file);
    //             $filename = uniqid('profile_') . '.' . $file->getClientOriginalExtension();
    //             $image->resize(400, 400)->save(public_path('uploads/users/' . $filename));
    //             if (File::exists($oldPath)) {
    //                 File::delete($oldPath);
    //             }
    //             $user->profile = $filename;
    //         }
    //         $user->save();
    //         return redirect()->route('admin.all.vendor')->with(['alert-type' => 'success', 'message' => 'Vendor update successfully']);
    //     } else {
    //         return redirect()->route('admin.all.vendor')->with(['alert-type' => 'error', 'message' => 'Vendor not found']);
    //     }
    // }
    
    
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'company_id' => 'nullable|exists:vendor_details,id',
            'name' => 'required',
            'surnameGivename' => 'required|string',
            'email' => 'required|unique:users,email,' . $request->id,
            'phone' => 'required|unique:users,phone,' . $request->id,
            'fax' => 'nullable',
            'shop_url' => 'nullable|url',
            'image' => 'nullable|image',
            'state' => 'nullable|string',
            'city' => 'required|string',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'isFeatured' => 'nullable|numeric',
            'isPopular' => 'nullable|numeric',
            'country' => 'nullable|string',
            'zipcode' => 'required|string',
            'language' => 'nullable|string',
            'logo' => 'nullable|image',
            'banner' => 'nullable|image',
            'categories' => 'nullable|array',
            'company_name' => 'required|string',
            'isDelivery' => 'required|numeric',
            'isPickup' => 'required|numeric',
            'free_delivery' => 'required|numeric',
            'restaurant_status' => 'required|numeric',
            'minimum_order_price' => 'required|numeric',
            'min_prepare_time' => 'required|numeric',
            'max_prepare_time' => 'required|numeric',
            'delivery_cost' => 'nullable|required_if:free_delivery,0|numeric|min:1',
            'commission' => 'required|numeric|min:1|max:50',
            'paypal_commission' => 'required|numeric|min:0.5|max:50',
            'stripe_commission' => 'required|numeric|min:0.5|max:50',
            'credit_card_commission' => 'required|numeric|min:0.5|max:50',
            'commission_fixed' => 'nullable|numeric|min:0',
            'paypal_commission_fixed' => 'nullable|numeric|min:0',
            'stripe_commission_fixed' => 'nullable|numeric|min:0',
            'credit_card_commission_fixed' => 'nullable|numeric|min:0',
            'company_name' => 'required|string',
            'company_street' => 'nullable|string',
            'company_zipcode' => 'required|string',
            'company_city' => 'required|string',
            'company_state' => 'nullable|string',
            'company_country' => 'required|string',
            'company_email' => 'required|email',
            'company_phone' => 'required',
            'steuernummer' => 'required',
            'steuerId' => 'required',
            'bank_account_number' => 'required',
            'bic' => 'required',
            'vat' => 'required',
            'bank_name' => 'required|string',
            'isReceivedByMail' => 'nullable',
            'isReceivedByWinorder' => 'nullable',
            'isReceivedBySmartOrder' => 'nullable',
            'bank_account_holder_name' => 'required',
            'description' => 'nullable|string',
            'restuarnat_title' => 'required|string|min:10|max:30',
        ]);

        $user = User::where('id', $request->id)->first();
        if (!empty($user)) {

            $user->name = $request->name;
            $user->surname = "";
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->address = $request->address;
            $user->country = $request->country;
            $user->zipcode = $request->zipcode;
            $user->language = $request->language;
            $user->isFeatured = $request->isFeatured;
            $user->isPopular = $request->isPopular;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $manager = new ImageManager(Driver::class);
                $oldPath = public_path('uploads/users/' . $user->profile);
                $image = $manager->read($file);
                $filename = uniqid('profile_') . '.' . $file->getClientOriginalExtension();
                $image->resize(400, 400)->save(public_path('uploads/users/' . $filename));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $user->profile = $filename;
            }

            $user->isVendorDetail = 1;
            $user->save();

            $companyData = vendor_detail::where('vendor_id', $request->id)->first();
            if (!empty($companyData)) {
                $companyData->company_name = $request->company_name;
                $companyData->vendor_full_name = $request->surnameGivename;
                $companyData->categories = json_encode($request->categories);
                $companyData->isDelivery = $request->isDelivery;
                $companyData->latitude = $request->latitude;
                $companyData->longitude = $request->longitude;
                $companyData->byemail = $request->isReceivedByMail == 'on' ? 1 : 0;
                $companyData->bywinorder = $request->isReceivedByWinorder == 'on' ? 1 : 0;
                $companyData->bysmartorder = $request->isReceivedBySmartOrder == 'on' ? 1 : 0;
                $companyData->isPickup = $request->isPickup;
                $companyData->minimum_price = $request->minimum_order_price;
                $companyData->restaurant_status = $request->restaurant_status;
                $companyData->delivery_free = $request->free_delivery;
                $companyData->commission = $request->commission;
                $companyData->paypal_commission = $request->paypal_commission;
                $companyData->stripe_commission = $request->stripe_commission;
                $companyData->credit_card_commission = $request->credit_card_commission;
                $companyData->commission_fixed = $request->commission_fixed;
                $companyData->paypal_commission_fixed = $request->paypal_commission_fixed;
                $companyData->stripe_commission_fixed = $request->stripe_commission_fixed;
                $companyData->credit_card_commission_fixed = $request->credit_card_commission_fixed;
                $companyData->fax = $request->fax;
                $companyData->shop_url = $request->shop_url;
                $companyData->company_email = $request->company_email;
                $companyData->company_phone = $request->company_phone;
                $companyData->gst_number = $request->steuernummer;
                $companyData->pan_number = $request->steuerId;
                $companyData->vat = $request->vat;
                $companyData->bank_name = $request->bank_name;
                $companyData->bank_account_number = $request->bank_account_number;
                $companyData->bank_ifsc_code = $request->bic;
                $companyData->bank_account_holder_name = $request->bank_account_holder_name;
                $companyData->description = $request->description;
                $companyData->restuarnat_title = $request->restuarnat_title;
                $companyData->min_prepare_time = $request->min_prepare_time;
                $companyData->max_prepare_time = $request->max_prepare_time;
                $companyData->company_street = $request->company_street;
                $companyData->company_zipcode = $request->company_zipcode;
                $companyData->company_city = $request->company_city;
                $companyData->company_state = $request->company_state;
                $companyData->company_country = $request->company_country;
                $companyData->delivery_cost = $request->delivery_cost ?? 10;
                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $manager = new ImageManager(Driver::class);
                    $oldPath = public_path('uploads/logo/' . $companyData->logo);
                    $image = $manager->read($file);
                    $filename = uniqid('logo_') . '.' . $file->getClientOriginalExtension();
                    $image->resize(400, 400)->save(public_path('uploads/logo/' . $filename));
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                    $companyData->logo = $filename;
                }
                if ($request->hasFile('banner')) {
                    $banner = $request->file('banner');
                    $manager = new ImageManager(Driver::class);
                    $oldPath = public_path('uploads/banner/' . $companyData->banner);
                    $image = $manager->read($banner);
                    $filename = uniqid('banner_') . '.' . $banner->getClientOriginalExtension();
                    $image->resize(1200, 400)->save(public_path('uploads/banner/' . $filename));
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                    $companyData->banner = $filename;
                }
                $companyData->save();
            } else {
                $companyData = new vendor_detail();
                $companyData->vendor_id = $request->id;
                $companyData->company_name = $request->company_name;
                $companyData->vendor_full_name = $request->surnameGivename;
                $companyData->categories = json_encode($request->categories);
                $companyData->byemail = $request->isReceivedByMail == 'on' ? 1 : 0;
                $companyData->bywinorder = $request->isReceivedByWinorder == 'on' ? 1 : 0;
                $companyData->bysmartorder = $request->isReceivedBySmartOrder == 'on' ? 1 : 0;
                $companyData->isDelivery = $request->isDelivery;
                $companyData->latitude = $request->latitude;
                $companyData->longitude = $request->longitude;
                $companyData->isPickup = $request->isPickup;
                $companyData->minimum_price = $request->minimum_order_price;
                $companyData->restaurant_status = $request->restaurant_status;
                $companyData->delivery_free = $request->free_delivery;
                // $companyData->company_address = $request->company_address;
                $companyData->commission = $request->commission;
                $companyData->paypal_commission = $request->paypal_commission;
                $companyData->stripe_commission = $request->stripe_commission;
                $companyData->credit_card_commission = $request->credit_card_commission;
                $companyData->commission_fixed = $request->commission_fixed;
                $companyData->paypal_commission_fixed = $request->paypal_commission_fixed;
                $companyData->stripe_commission_fixed = $request->stripe_commission_fixed;
                $companyData->credit_card_commission_fixed = $request->credit_card_commission_fixed;
                $companyData->fax = $request->fax;
                $companyData->shop_url = $request->shop_url;
                $companyData->company_email = $request->company_email;
                $companyData->company_phone = $request->company_phone;
                $companyData->gst_number = $request->steuernummer;
                $companyData->pan_number = $request->steuerId;
                $companyData->vat = $request->vat;
                $companyData->bank_name = $request->bank_name;
                $companyData->bank_account_number = $request->bank_account_number;
                $companyData->bank_ifsc_code = $request->bic;
                $companyData->bank_account_holder_name = $request->bank_account_holder_name;
                $companyData->description = $request->description;
                $companyData->restuarnat_title = $request->restuarnat_title;
                $companyData->min_prepare_time = $request->min_prepare_time;
                $companyData->max_prepare_time = $request->max_prepare_time;
                $companyData->company_street = $request->company_street;
                $companyData->company_zipcode = $request->company_zipcode;
                $companyData->company_city = $request->company_city;
                $companyData->company_state = $request->company_state;
                $companyData->company_country = $request->company_country;
                $companyData->delivery_cost = $request->delivery_cost ?? 10;
                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $manager = new ImageManager(Driver::class);
                    $oldPath = public_path('uploads/logo/' . $companyData->logo);
                    $image = $manager->read($file);
                    $filename = uniqid('logo_') . '.' . $file->getClientOriginalExtension();
                    $image->resize(400, 400)->save(public_path('uploads/logo/' . $filename));
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                    $companyData->logo = $filename;
                }
                if ($request->hasFile('banner')) {
                    $banner = $request->file('banner');
                    $manager = new ImageManager(Driver::class);
                    $oldPath = public_path('uploads/banner/' . $companyData->banner);
                    $image = $manager->read($banner);
                    $filename = uniqid('banner_') . '.' . $banner->getClientOriginalExtension();
                    $image->resize(1200, 400)->save(public_path('uploads/banner/' . $filename));
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                    $companyData->banner = $filename;
                }
                $companyData->save();
            }

            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Your profile updated successfully']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Vendor not found']);
        }
    }
    
    public function updateVendorLocation(Request $request){
        
        $request->validate([
         'latitude' => 'required|numeric',
         'longitude' => 'required|numeric',
         'address' => 'nullable|string',
        ]);

       $user_id = Auth::user()->id; 
       $user=User::where('id',$user_id)->first();
       if (!empty($user)) {
         $user->latitude = $request->latitude;
         $user->longitude = $request->longitude;
         $user->address = $request->address;
         $user->save();
         $companyData = vendor_detail::where('vendor_id',$user_id)->first();
         if (!empty($companyData)){
             $companyData->latitude = $request->latitude;
             $companyData->longitude = $request->longitude;
             $companyData->save();
         }
         Auth::login($user);
       }
      return response()->json(['status'=>true,'message' => 'Location updated successfully']);
    }
    
    public function updateVendorProfile(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'company_id' => 'nullable|exists:vendor_details,id',
            'name' => 'required',
            'surnameGivename' => 'required|string',
            'email' => 'required|unique:users,email,' . $request->id,
            'phone' => 'required|unique:users,phone,' . $request->id,
            'image' => 'nullable|image',
            'state' => 'nullable|string',
            'city' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'address' => 'nullable|string',
            'country' => 'nullable|string',
            'zipcode' => 'required|string',
            'language' => 'nullable|string',
            'logo' => 'nullable|image',
            'banner' => 'nullable|image',
            'categories' => 'nullable|array',
            'company_name' => 'required|string',
            'isDelivery' => 'required|numeric',
            'isPickup' => 'required|numeric',
            'free_delivery' => 'required|numeric',
            'restaurant_status' => 'required|numeric',
            'minimum_order_price' => 'required|numeric',
            'min_prepare_time' => 'required|numeric',
            'max_prepare_time' => 'required|numeric',
            'delivery_cost' => 'nullable|required_if:free_delivery,0|numeric|min:1',
            'company_name' => 'required|string',
            'company_street' => 'nullable|string',
            'company_zipcode' => 'required|string',
            'company_city' => 'required|string',
            'company_state' => 'nullable|string',
            'company_country' => 'required|string',
            'company_email' => 'required|email',
            'company_phone' => 'required',
            'steuernummer' => 'required',
            'steuerId' => 'required',
            'bank_account_number' => 'required',
            'bic' => 'required',
            'vat' => 'required',
            'bank_name' => 'required|string',
            'bank_account_holder_name' => 'required',
            'description' => 'nullable|string',
            'restuarnat_title' => 'required|string|min:10|max:30',
        ]);

        $user = User::where('id', $request->id)->first();
        if (!empty($user)) {

            $user->name = $request->name;
            $user->surname = "";
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->address = $request->address;
            $user->country = $request->country;
            $user->zipcode = $request->zipcode;
            $user->language = $request->language;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $manager = new ImageManager(Driver::class);
                $oldPath = public_path('uploads/users/' . $user->profile);
                $image = $manager->read($file);
                $filename = uniqid('profile_') . '.' . $file->getClientOriginalExtension();
                $image->resize(400, 400)->save(public_path('uploads/users/' . $filename));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $user->profile = $filename;
            }

            $user->isVendorDetail = 1;
            $user->save();

            $companyData = vendor_detail::where('vendor_id', $request->id)->first();
            if (!empty($companyData)) {
                $companyData->company_name = $request->company_name;
                $companyData->vendor_full_name = $request->surnameGivename;
                $companyData->categories = json_encode($request->categories);
                $companyData->isDelivery = $request->isDelivery;
                $companyData->latitude = $request->latitude;
                $companyData->longitude = $request->longitude;
                $companyData->isPickup = $request->isPickup;
                $companyData->minimum_price = $request->minimum_order_price;
                $companyData->restaurant_status = $request->restaurant_status;
                $companyData->delivery_free = $request->free_delivery;
                // $companyData->company_address = $request->company_address;
                $companyData->company_email = $request->company_email;
                $companyData->company_phone = $request->company_phone;
                $companyData->gst_number = $request->steuernummer;
                $companyData->pan_number = $request->steuerId;
                $companyData->vat = $request->vat;
                $companyData->bank_name = $request->bank_name;
                $companyData->bank_account_number = $request->bank_account_number;
                $companyData->bank_ifsc_code = $request->bic;
                $companyData->bank_account_holder_name = $request->bank_account_holder_name;
                $companyData->description = $request->description;
                $companyData->restuarnat_title = $request->restuarnat_title;
                $companyData->min_prepare_time = $request->min_prepare_time;
                $companyData->max_prepare_time = $request->max_prepare_time;
                $companyData->company_street = $request->company_street;
                $companyData->company_zipcode = $request->company_zipcode;
                $companyData->company_city = $request->company_city;
                $companyData->company_state = $request->company_state;
                $companyData->company_country = $request->company_country;
                $companyData->delivery_cost = $request->delivery_cost ?? 10;
                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $manager = new ImageManager(Driver::class);
                    $oldPath = public_path('uploads/logo/' . $companyData->logo);
                    $image = $manager->read($file);
                    $filename = uniqid('logo_') . '.' . $file->getClientOriginalExtension();
                    $image->resize(400, 400)->save(public_path('uploads/logo/' . $filename));
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                    $companyData->logo = $filename;
                }
                if ($request->hasFile('banner')) {
                    $banner = $request->file('banner');
                    $manager = new ImageManager(Driver::class);
                    $oldPath = public_path('uploads/banner/' . $companyData->banner);
                    $image = $manager->read($banner);
                    $filename = uniqid('banner_') . '.' . $banner->getClientOriginalExtension();
                    $image->resize(1200, 400)->save(public_path('uploads/banner/' . $filename));
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                    $companyData->banner = $filename;
                }
                $companyData->save();
            } else {
                $companyData = new vendor_detail();
                $companyData->vendor_id = $request->id;
                $companyData->company_name = $request->company_name;
                $companyData->vendor_full_name = $request->surnameGivename;
                $companyData->categories = json_encode($request->categories);
                $companyData->isDelivery = $request->isDelivery;
                $companyData->latitude = $request->latitude;
                $companyData->longitude = $request->longitude;
                $companyData->isPickup = $request->isPickup;
                $companyData->minimum_price = $request->minimum_order_price;
                $companyData->restaurant_status = $request->restaurant_status;
                $companyData->delivery_free = $request->free_delivery;
                // $companyData->company_address = $request->company_address;
                $companyData->company_email = $request->company_email;
                $companyData->company_phone = $request->company_phone;
                $companyData->gst_number = $request->steuernummer;
                $companyData->pan_number = $request->steuerId;
                $companyData->vat = $request->vat;
                $companyData->bank_name = $request->bank_name;
                $companyData->bank_account_number = $request->bank_account_number;
                $companyData->bank_ifsc_code = $request->bic;
                $companyData->bank_account_holder_name = $request->bank_account_holder_name;
                $companyData->description = $request->description;
                $companyData->restuarnat_title = $request->restuarnat_title;
                $companyData->min_prepare_time = $request->min_prepare_time;
                $companyData->max_prepare_time = $request->max_prepare_time;
                $companyData->company_street = $request->company_street;
                $companyData->company_zipcode = $request->company_zipcode;
                $companyData->company_city = $request->company_city;
                $companyData->company_state = $request->company_state;
                $companyData->company_country = $request->company_country;
                $companyData->delivery_cost = $request->delivery_cost ?? 10;
                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $manager = new ImageManager(Driver::class);
                    $oldPath = public_path('uploads/logo/' . $companyData->logo);
                    $image = $manager->read($file);
                    $filename = uniqid('logo_') . '.' . $file->getClientOriginalExtension();
                    $image->resize(400, 400)->save(public_path('uploads/logo/' . $filename));
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                    $companyData->logo = $filename;
                }
                if ($request->hasFile('banner')) {
                    $banner = $request->file('banner');
                    $manager = new ImageManager(Driver::class);
                    $oldPath = public_path('uploads/banner/' . $companyData->banner);
                    $image = $manager->read($banner);
                    $filename = uniqid('banner_') . '.' . $banner->getClientOriginalExtension();
                    $image->resize(1200, 400)->save(public_path('uploads/banner/' . $filename));
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                    $companyData->banner = $filename;
                }
                $companyData->save();
            }

            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Your profile updated successfully']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Vendor not found']);
        }
    }
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'vendor' => 'required|exists:users,id',
            'document1' => 'nullable|image',
            'document2' => 'nullable|image',
            'document3' => 'nullable|image',
            'document4' => 'nullable|image',
            'document5' => 'nullable|image',
            'document6' => 'nullable|image',
        ]);

        $user = User::where('id', $request->vendor)->where('role', 'vendor')->first();
        if (!empty($user)) {
            $vendorDocument = VendorDocument::where('vendor_id', $request->vendor)->first();
            if (!$vendorDocument) {
                $vendorDocument = new VendorDocument();
            }
            $vendorDocument->vendor_id = $request->vendor;
            for ($i = 1; $i <= 6; $i++) {
                $documentKey = 'document' . $i;
                if ($request->hasFile($documentKey)) {
                    $file = $request->file($documentKey);
                    $oldPath = public_path('uploads/documents/' . $vendorDocument->{$documentKey});
                    $filename = uniqid("document_{$i}_") . '.' . $file->getClientOriginalExtension();

                    // Save the uploaded file without resizing
                    $file->move(public_path('uploads/documents/'), $filename);

                    // Delete the old file if it exists
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }

                    // Update the corresponding field in the database
                    $vendorDocument->{$documentKey} = $filename;
                    $vendorDocument->save();
                }
            }
            $vendorDocument->save();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Vendor document uploaded successfully']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Vendor not found']);
        }
    }
    public function showVendorDocument($id)
    {
        $users = User::latest()
            ->where('role', 'vendor')
            ->get();
        $vendorDocument = VendorDocument::where('vendor_id', $id)->first();
        if (!$vendorDocument) {
            return redirect()->back()->with(['alert-type' => 'warning', 'message' => 'Vendor document not found!']);
        }
        return view('admin.vendor-manager.upload-document', compact('users', 'vendorDocument'));
    }

    public function deleteThisDocument($id)
    {
        $vendorDocument = VendorDocument::where('id', $id)->first();
        if ($vendorDocument) {
            for ($i = 1; $i <= 6; $i++) {
                $documentKey = 'document' . $i;
                $oldPath = public_path('uploads/documents/' . $vendorDocument->{$documentKey});

                // Check if the old file exists and delete it
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            $vendorDocument->delete();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Vendor document deleted successfully.']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Vendor document not found!']);
        }
    }

    public function show($id)
    {
        $adminid = Auth::user()->id;
        $categories = category::orderBy('name', 'ASC')->whereIn('vendor_id', [null, $adminid])->get();
        $countries = country::orderBy('name', 'ASC')->get();
        // $timezones = DateTimeZone::listIdentifiers();
        $user = User::where(['id' => $id, 'role' => 'vendor'])->with('vendor_details')->first();
        if (!empty($user)) {

            return view('admin.vendor-manager.vendor-details', compact('user', 'countries', 'categories'));
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Vendor not found']);
        }
    }
    public function deleteVendor(Request $request)
    {
        if (isset($request->accountActivation)) {
            $user = User::where('id', $request->id)->first();
            if (!empty($user)) {
                $oldPath = public_path('uploads/users/' . $user->profile);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $user->delete();
                return redirect()->route('admin.all.vendor')->with(['alert-type' => 'success', 'message' => 'Vendor deleted successfully']);
            } else {
                return redirect()->route('admin.all.vendor')->with(['alert-type' => 'error', 'message' => 'Vendor not found']);
            }
        } else {
            $user = User::where('id', $request->id)->first();
            if (!empty($user)) {
                $user->accountStatus = 0;
                $user->save();
                return redirect()->route('admin.all.vendor')->with(['alert-type' => 'success', '
                message' => 'Vendor deactivated successfully']);
            } else {
                return redirect()->route('admin.all.vendor')->with(['alert-type' => 'error', '
                    message' => 'Vendor not found']);
            }
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with(['alert-type' => 'success', 'message'
        => 'Successfully sign out']);
    }
    public function permissions(User $vendor)
    {
        $permissions = Permission::all();
        $vendorPermissions = $vendor->permissions->pluck('id')->toArray();
        return view('admin.vendor-manager.permissions', compact('vendor', 'permissions', 'vendorPermissions'));
    }
    public function updatePermissions(Request $request, User $vendor)
    {
        $permissions = $request->input('permissions', []);
        $vendor->permissions()->sync($permissions);
        return redirect()->route('admin.all.vendor')->with(['alert-type' => 'success', 'message' => 'Permissions updated successfully!']);
    }


    public function impersonateVendor($vendorId)
    {

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $vendor = User::findOrFail($vendorId);
        session(['admin_user_id' => Auth::user()->id]);
        Auth::login($vendor);
        return redirect()->route('vendor.dashboard');
    }

    public function returnToAdmin()
    {
        // Check if there is an admin session
        $adminId = session('admin_user_id');
        if (!$adminId) {
            abort(403, 'Unauthorized action.');
        }
        $admin = User::findOrFail($adminId);
        Auth::login($admin);

        session()->forget('admin_user_id');
        return redirect()->route('admin.dashboard');
    }
}
