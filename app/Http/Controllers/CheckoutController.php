<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CollectionItem;
use App\Models\customeOpening;
use App\Models\DeliveryArea;
use App\Models\offer;
use App\Models\old_address;
use App\Models\Order;
use App\Models\User;
use App\Models\vendor_detail;
use App\Models\DeliveryCharge;
use App\Models\VendorOpeningTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

class CheckoutController extends Controller
{
    
private function calculateDistance($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371; // km
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earthRadius * $c;
}

    
public function getVendorSlotsByMethod($vendor_id, $method, $timeAft,$interval_min)
{
    // Step 1: Validate the method (should be either 'delivery' or 'pickup')
    if (!in_array($method, ['delivery', 'pickup'])) {
        throw new InvalidArgumentException("Invalid method. Allowed values are 'delivery' or 'pickup'.");
    }

    // Step 2: Generate time slots based on the provided method
    return $this->getTimeSlots($vendor_id, $method, $interval_min, $timeAft);
}

private function getTimeSlots($vendor_id, $type, $intval, $timeAft)
{
    
    $gtimezone = 'Europe/Berlin'; // Germany timezone
    $dayOfWeek = now($gtimezone)->format('l'); // Current day of the week
    $currentDate = now($gtimezone)->format('Y-m-d'); // Current date
    if($type=='delivery'){
      $currentTime = now($gtimezone)->addMinutes($timeAft)->ceilMinute(15);  
    }else{
      $currentTime = now($gtimezone)->addMinutes(10)->ceilMinute(5);  
    }
    // dd($currentTime);
    // Retrieve vendor opening times
    $vendorOpeningTimes = VendorOpeningTime::where('vendor_id', $vendor_id)
        ->where('day', $dayOfWeek)
        ->first();

    // Retrieve custom opening times
    $customOpenings = CustomeOpening::where('vendor_id', $vendor_id)
        ->where('open_date', $currentDate)
        ->first();

    // Determine which field to use for times
    $timeField = ($type === 'delivery') ? 'delivery_times' : 'pickup_times';

    // Extract opening times
    $openingTimes = [];
    if ($customOpenings) {
        $openingTimes = json_decode($customOpenings->$timeField, true);
    } elseif ($vendorOpeningTimes) {
        $openingTimes = json_decode($vendorOpeningTimes->$timeField, true);
    }
    
    // If no opening times are found, return an empty array
    if (empty($openingTimes)) {
        return [];
    }

    $timeSlots = [];
    foreach ($openingTimes as $time) {
        // Parse the start and end times
        if($type === 'delivery'){
          $start = Carbon::createFromFormat('H:i', $time['start'])->addMinutes($timeAft)->ceilMinute(5);
        }else{
           $start = Carbon::createFromFormat('H:i', $time['start'])->ceilMinute(5);   
        }
        $end = Carbon::createFromFormat('H:i', $time['end']);

        // Adjust start time to be at least the current time
        $currentTime = Carbon::createFromFormat('H:i',$currentTime->format('H:i'));
        if ($start->lte($currentTime)) {
            $start = Carbon::createFromFormat('H:i',$currentTime->format('H:i'));
        }
        // dd($start);
        if($currentTime->gte($end)){
             continue;
        }
        // Generate time slots between start and end
        while ($start->lte($end)) {
            // dd($end);
            $start = Carbon::createFromFormat('H:i',$start->format('H:i'));
            if ($start->gt($end)) {
                break;
            }
            // dd($start);
            $timeSlots[] = $start->format('H:i'); // Format time as HH:MM
            $start->addMinutes($intval); // Increment by the 
            $start = Carbon::createFromFormat('H:i',$start->format('H:i'));
            
        }
        
    }
    // dd($timeSlots);
    return $timeSlots;
}

// Helper function to floor minutes to the nearest interval
private function floorMinute(Carbon $time, $interval)
{
    $minutes = $time->minute;
    $roundedMinutes = floor($minutes / $interval) * $interval;
    return $time->minute($roundedMinutes)->second(0);
}

// Helper function to ceil minutes to the nearest interval
private function ceilMinute(Carbon $time, $interval)
{
    $minutes = $time->minute;
    $roundedMinutes = ceil($minutes / $interval) * $interval;
    return $time->minute($roundedMinutes)->second(0);
}


    public function checkout1($method = "delivery")
    {
        if (isset(Auth::user()->id)) {
            // get postalcode from session
            $postalcode = session()->get('postalcode');
            $vendorId = session()->get('restaurant');
            $userPostcode = session('postcode');
            $userStreet = session('street');
            $userCity = session('city');
            $userLatitude = session('latitude');
            $userLongitude = session('longitude');

            $query = DeliveryArea::where('postcode', $userPostcode)
                ->where(function ($q) use ($userCity) {
                     $q->whereRaw('LOWER(city) = ?', [strtolower($userCity)]);
                });
                if ($userStreet) {
        $normalized = strtolower($userStreet);
        $parts = preg_split('/[\/\s\-]+/', $normalized); 
        $shortestPart = end($parts);

        $query->where(function ($q) use ($normalized, $parts, $userCity) {
            $q->whereRaw('LOWER(village) = ?', [strtolower($userCity)])
              ->orWhereIn(DB::raw('LOWER(village)'), $parts)               
              ->orWhere(function ($qq) use ($parts) {                   
                  foreach ($parts as $part) {                       
                      $qq->orWhereRaw('LOWER(area_name) LIKE ?', ['%' . $part . '%']);                   
                      
                  }               
                  
              });         
            
        });
    } else {
        // If no sublocality, match area_name with city
        $query->whereRaw('LOWER(area_name) = ?', [strtolower($userCity)]);
    }
                $deliveryArea=$query->where('vendor_id', $vendorId)
                ->first();
           
            if ($deliveryArea) {
                $restDetails=vendor_detail::where('vendor_id',$vendorId)->first();
                $vendor=User::where('id',$vendorId)->first();
                $id = Auth::user()->id;
                $method = (isset($method) && $method == "delivery") ? "delivery" : "pickup";
                
                $slots = $this->getVendorSlotsByMethod($vendorId, $method,$deliveryArea->max_delivery_time,5);
                
                // $slots = $this->getTimeSlots($vendorId, $method, 15);
                //  dd($slots);
                 $offer=offer::where('created_by',$vendorId)
                        ->where('whichType','restaurant')
                        ->where('start_date', '<=', now()) 
                        ->where('end_date', '>', now()) 
                        ->where('is_active',1) 
                        ->first();
                         
                 $carts = Cart::latest()->where('user_id', $id)->with('food_item.category.offer','food_item.offer', 'variant.variant_item')->get();
                 $restaurantDis = 0;
                 $categoryDis = 0;
                 $total_price = 0;
                foreach ($carts as $cart) {
                     $offerl=null;
                if (isset($cart->food_item->offer)) {
                  $offerl = $cart->food_item->offer;
                } elseif (isset($cart->food_item->category->offer)) {
                  $offerl = $cart->food_item->category->offer;
                } elseif (isset($offer)) {
                  $offerl = $offer;
                }
                if(isset($offerl)){
                 if ($offerl->offer_type == 'percentage') {
                       $categoryDis += ($offerl->discount_value / 100) * $cart->total_price; 
                       $total_price += $cart->total_price-$categoryDis; 
                 }elseif ($offer->offer_type == 'fixed') {
                       $categoryDis += $offerl->discount_value; 
                       $total_price += $cart->total_price-$categoryDis; 
                 }else{
                     $total_price += $cart->total_price;
                 }
                }else{
                  $total_price += $cart->total_price;
                }
                    $dressing = CollectionItem::where('id', $cart->dressing_type)->with('sub_items')->first();
                    $cart->dressing = (isset($dressing->sub_items->name)) ? $dressing->sub_items->name : "";
                    $extraIds = is_array(json_decode($cart->extras, true)) ? json_decode($cart->extras, true) : [];
                    $cart->collection_items = CollectionItem::where('status', 1)->whereIn('id', $extraIds)->with('sub_items','collectionData')->get();
                }
                
                $discounts=['onResturant'=>floatVal($restaurantDis),'onCategory'=>floatVal($categoryDis)];
                $user = User::latest()->where('id', $id)->with('delivery_address')->first();
                $oldAddresses=old_address::where('user_id',$id)->orderBy('id','DESC')->get();
                // echo '<pre>';
                //  print_r($carts->toArray());
                // echo '</pre>';
                // die;
                return view('external.shop.checkout', compact('carts', 'user', 'method','vendor','deliveryArea', 'slots','oldAddresses','restDetails','discounts'));
            } else {
                return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'Please choose area of location.']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

public function checkout($method = "delivery")
{
    if (!Auth::check()) {
        return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
    }

    $userId = Auth::id();
    $vendorId = session('restaurant');

    $userLatitude = session('latitude');
    $userLongitude = session('longitude');

    $vendor = User::with('vendor_details')->where('id', $vendorId)->first();
    $vendorDetails = $vendor->vendor_details;
    $restDetails=vendor_detail::where('vendor_id',$vendorId)->first();
    if (!$vendorDetails || !$vendorDetails->latitude || !$vendorDetails->longitude || !$userLatitude || !$userLongitude) {
        return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'Could not calculate delivery range.']);
    }

    // Calculate distance
    $distance = $this->calculateDistance($userLatitude, $userLongitude, $vendorDetails->latitude, $vendorDetails->longitude);
    $distance=round($distance);
    // Find delivery charge in range
    $deliveryArea =DeliveryCharge::where('vendor_id', $vendorId)
        ->where('min_km', '<=', $distance)
        ->where('max_km', '>=', $distance)
        ->where('status', 1)
        ->first();
    $isNotDeliverable=false;
    if (!$deliveryArea && $method === "delivery") {
        $isNotDeliverable=true;
    }

    $method = ($method === "delivery") ? "delivery" : "pickup";

    $slots = $this->getVendorSlotsByMethod($vendorId, $method, $deliveryArea->max_delivery_time ?? 45, 5);

    $offer = Offer::where('created_by', $vendorId)
        ->where('whichType', 'restaurant')
        ->where('start_date', '<=', now())
        ->where('end_date', '>', now())
        ->where('is_active', 1)
        ->first();

    $carts = Cart::latest()
        ->where('user_id', $userId)
        ->with('food_item.category.offer', 'food_item.offer', 'variant.variant_item')
        ->get();

    $restaurantDis = 0;
    $categoryDis = 0;
    $total_price = 0;
    if($method=="pickup"){
        $isNotDeliverable=false;
    }
    foreach ($carts as $cart) {
        $offerl = $cart->food_item->offer ?? $cart->food_item->category->offer ?? $offer;

        if ($offerl) {
            if ($offerl->offer_type === 'percentage') {
                $discount = ($offerl->discount_value / 100) * $cart->total_price;
                $categoryDis += $discount;
                $total_price += $cart->total_price - $discount;
            } elseif ($offerl->offer_type === 'fixed') {
                $discount = $offerl->discount_value;
                $categoryDis += $discount;
                $total_price += $cart->total_price - $discount;
            } else {
                $total_price += $cart->total_price;
            }
        } else {
            $total_price += $cart->total_price;
        }

        // Dressing and extras
        $dressing = CollectionItem::where('id', $cart->dressing_type)->with('sub_items')->first();
        $cart->dressing = $dressing->sub_items->name ?? "";

        $extraIds = is_array(json_decode($cart->extras, true)) ? json_decode($cart->extras, true) : [];
        $cart->collection_items = CollectionItem::where('status', 1)
            ->whereIn('id', $extraIds)
            ->with('sub_items', 'collectionData')
            ->get();
    }

    $discounts = ['onResturant' => floatVal($restaurantDis), 'onCategory' => floatVal($categoryDis)];
    $user = User::with('delivery_address')->find($userId);
    $oldAddresses = old_address::where('user_id', $userId)->orderBy('id', 'DESC')->get();
    
    return view('external.shop.checkout', compact(
        'carts',
        'user',
        'method',
        'vendor',
        'deliveryArea',
        'slots',
        'oldAddresses',
        'vendorDetails',
        'restDetails',
        'discounts',
        'isNotDeliverable'
    ));
}

    public function cancelStatus(Request $request)
    {
        if (isset(Auth::user()->id)) {
            $id = $request->id;
            $order = Order::where('user_id', Auth::user()->id)->where('id', $id)->first();
            if ($order) {
                $order->order_status = 'cancelled';
                $order->save();

                return response()->json(['status' => true, 'message' => 'Order cancelled successfully.'], 200);
            } else {

                return response()->json(['status' => false, 'message' => 'Order not found.'], 200);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first'], 200);
        }
    }
}
