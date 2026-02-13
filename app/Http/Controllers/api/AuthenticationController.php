<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\add_favorite;
use App\Models\offer;
use App\Models\VendorOpeningTime;
use App\Models\customeOpening;
use Carbon\Carbon;
use App\Models\gallery;
use App\Models\review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    //
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|max:16',
        ]);
        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'Invalid credentials'], 200);
        } else {
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['status' => false, 'message' => 'Invalid credentials'], 200);
            } else {
                $data = $user->only(['id', 'email', 'name', 'surname', 'phone', 'unid', 'profile', 'language']);
                return response()->json(['status' => true, 'message' => 'Successfully sign in.', 'data' => $data], 200);
            }
        }
    }
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => 'required|string|min:8|max:16',
        ]);
        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation failed', 'errors' => $validate->errors()], 200);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->unid = uniqid();
            $user->role = "user";
            $user->language = "eng";
            $user->password = Hash::make($request->password);
            $user->save();
            $data = $user->only(['id', 'email', 'name', 'surname', 'phone', 'unid', 'profile', 'language']);
            return response()->json(['status' => true, 'message' => 'Successfully sign up.', 'data' => $data], 200);
        }
    }

    public function forgetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'Invalid email'], 200);
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $otp = rand(1000, 9999);
                $user->otp = $otp;
                Mail::send('mail.send-otp', ['user' => $user], function ($message) use ($user) {
                    // dd($user);
                    $message->to($user->email)
                        ->subject('One Time Password from Dillon Restaurant');
                });
                $data = $user->only(['id', 'email', 'name', 'surname', 'phone', 'unid', 'profile', 'language']);
                return response()->json(['status' => true, 'message' => 'OTP sent successfully', 'otp' => $otp, 'user' => $data], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'User not found'], 200);
            }
        }
    }
    public function changePassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:16',
        ]);
        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation failed', 'errors' => $validate->errors()], 200);
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json(
                    ['status' => true, 'message' => 'Password changed successfully'],
                    200
                );
            } else {
                return response()->json(
                    ['status' => false, 'message' => 'User not found'],
                    200
                );
            }
        }
    }
    
    public function getInformation(Request $request){
        $validate = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation failed', 'errors' => $validate->errors()], 200);
        }
        $unid=$request->vendor_id;
        $vendor = User::with('vendor_details', 'table_service')
            ->where('id', $unid)
            ->where('role', 'vendor')
            ->withCount([
                'reviews as rating_count' => function ($query) {
                    $query->select(DB::raw('count(*)'));
                }
            ])
            ->withAvg('reviews', 'rating')
            ->first();
        $vendorOffer=offer::where('created_by',$vendor->id)
                           ->where('whichType','restaurant')
                           ->where('start_date', '<=', now()) 
                           ->where('end_date', '>', now()) 
                           ->where('is_active',1)
                           ->first();    
        $averageRating = $vendor->reviews_avg_rating ?? 5;
        $ratingCount = $vendor->rating_count ?? 0;
        if (isset($request->user_id)) {
            $id = $request->user_id;
            $fav = add_favorite::where('vendor_id', $vendor->id)->where('user_id', $id)->first();
            if ($fav) {
                $isFav = true;
            } else {
                $isFav = false;
            }
        } else {
            $isFav = false;
        }
        $feedbacks = review::where('vendor_id', $vendor->id)->with('user')->where('status', 1)->get();
        $currentDateTime = Carbon::now(); // Current date and time
        $availability = $this->checkVendorAvailability($vendor->id, $currentDateTime);
        $dataReturn=['vendor'=>$vendor, 'averageRating'=>$averageRating, 'ratingCount'=>$ratingCount,'vendorOffer'=>$vendorOffer, 'isFav'=>$isFav, 'feedbacks'=>$feedbacks, 'availability'=>$availability];
        return response()->json($dataReturn);
    }
    
    
    
    
    
     private function checkVendorAvailability($vendor_id, $currentDateTime)
    {
        // Parse date and time details
        $day = strtolower($currentDateTime->format('l'));
        $day = ucfirst($day);
        $date = $currentDateTime->format('Y-m-d');
        $currentTime = $currentDateTime->format('H:i');
        $deliveryTimes='';
        $pickupTimes='';

        $customOpening = customeOpening::where('vendor_id', $vendor_id)
            ->where('open_date', $date)
            ->first();

        if ($customOpening) {
            if(isset($customOpening->is_delivery) && $customOpening->is_delivery==1){
                $deliveryTimes = $customOpening->delivery_times;
            }
            if(isset($customOpening->is_pickup) && $customOpening->is_pickup==1){
                $pickupTimes = $customOpening->pickup_times;
            }
        } else {

            $vendorOpeningTime = VendorOpeningTime::where('vendor_id', $vendor_id)
                ->where('day', $day)
                ->first();
            if (!$vendorOpeningTime) {
                // No opening times found, return false
                return [
                    'is_delivery_open' => false,
                    'is_pickup_open' => false,
                    'deliveryTimes' => [],
                    'pickupTimes' => [],
                ];
            }
            if(isset($vendorOpeningTime->is_delivery) && $vendorOpeningTime->is_delivery==1){
               $deliveryTimes = $vendorOpeningTime->delivery_times; 
            }
            if(isset($vendorOpeningTime->is_pickup) && $vendorOpeningTime->is_pickup==1){
              
               $pickupTimes = $vendorOpeningTime->pickup_times;
            }
        }

        // Step 4: Check if current time falls within delivery or pickup times
        $isDeliveryOpen = $this->checkTimeRange($deliveryTimes, $currentTime);
        $isPickupOpen = $this->checkTimeRange($pickupTimes, $currentTime);
        $deliveryTimes = $this->getTimes($deliveryTimes);
        $pickupTimes = $this->getTimes($pickupTimes);

        return [
            'is_delivery_open' => $isDeliveryOpen,
            'is_pickup_open' => $isPickupOpen,
            'deliveryTimes' => $deliveryTimes,
            'pickupTimes' => $pickupTimes,
        ];
    }

    private function checkTimeRange($times, $currentTime)
    {
        $times = json_decode($times);
        if (!is_array($times)) {
            return false;
        }
        foreach ($times as $timeRange) {
            $startTime = Carbon::createFromFormat('H:i', $timeRange->start);
            $endTime = Carbon::createFromFormat('H:i', $timeRange->end);
            $current = Carbon::createFromFormat('H:i', $currentTime);

            if ($current->between($startTime, $endTime)) {
                return true;
            }
        }

        return false;
    }
    private function getTimes($times)
    {
        $times = json_decode($times);
        if (is_array($times)) {
            return $times;
        } else {
            return [];
        }
    }
}
