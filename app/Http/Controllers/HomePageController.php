<?php

namespace App\Http\Controllers;

use App\Models\DeliveryArea;
use App\Models\food_item;
use App\Models\home_slider;
use App\Models\User;
use App\Models\vendor_detail;
use App\Models\DeliveryCharge;
use App\Models\VirtualLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class HomePageController extends Controller
{
    //
    public function index()
    {
        $slides = home_slider::latest()->get();
        $vendors = User::with('vendor_details')->where('role', 'vendor')->where('isPopular', 1)->where('isVendorDetail', 1)->get();
        $featureds = User::latest()->with('vendor_details')->where('role', 'vendor')
            ->where('isFeatured', 1)
            ->where('isVendorDetail', 1)
            ->limit(8)->get();
        // dd($vendors);
        $items = food_item::latest()->with('vendor')->where('is_available', 1)->get();
        return view('external.home', compact('slides', 'vendors', 'featureds', 'items'));
    }
    public function checkDeliveryArea1(Request $request)
    {
        $postcode = $request->postcode;
        $sublocality = $request->sublocality;
        $street = $request->street ?? null;
        $street_number = $request->street_number ?? null;
        $state = $request->state ?? null;
        $city = $request->city;

        if (!$postcode) {
            return response()->json(['status' => false, 'message' => 'Please enter postcode'], 200);
        }

        $query = DeliveryArea::where('postcode', $postcode)
            ->where('status', 1);

        if ($sublocality) {
            $normalized = strtolower($sublocality);
            $parts = preg_split('/[\s\-]+/', $normalized);
            $shortestPart = end($parts); 

            $query->where(function ($q) use ($normalized, $shortestPart) {
                $q->whereRaw('LOWER(area_name) LIKE ?', ['%' . $normalized . '%'])
                    ->orWhereRaw('LOWER(area_name) LIKE ?', ['%' . $shortestPart . '%']);
            });
        }

        $deliveryAreas = $query->get(['id', 'vendor_id', 'postcode','city','village', 'area_name']);

        if ($deliveryAreas->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No delivery areas found for this postcode and area'
            ], 200);
        }

        session()->put([
            'postcode' => $postcode,
            'city' => $city,
            'street' => $sublocality.' '.$street.' '.$street_number,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return response()->json(['status' => true, 'data' => $deliveryAreas]);
    }

    public function checkDeliveryArea2(Request $request)
    {
    $postcode = $request->postcode;
    $sublocality = $request->sublocality;
    $city = $request->city;

    if (!$postcode) {
        return response()->json(['status' => false, 'message' => 'Please enter postcode'], 200);
    }

    $query = DeliveryArea::where('postcode', $postcode)
        ->where('status', 1)
        ->where(function ($q) use ($city) {
            $q->whereRaw('LOWER(city) = ?', [strtolower($city)]);
        });

    if ($sublocality) {
        $normalized = strtolower($sublocality);
        $parts = preg_split('/[\/\s\-]+/', $normalized); 
        $shortestPart = end($parts);

        $query->where(function ($q) use ($normalized, $parts, $city) {
            $q->whereRaw('LOWER(village) = ?', [strtolower($city)])
              ->orWhereIn(DB::raw('LOWER(village)'), $parts)               
              ->orWhere(function ($qq) use ($parts) {                   
                  foreach ($parts as $part) {                       
                      $qq->orWhereRaw('LOWER(area_name) LIKE ?', ['%' . $part . '%']);                   
                  }               
                  
              });         
            
        });
    } else {
        // If no sublocality, match area_name with city
        $query->whereRaw('LOWER(area_name) = ?', [strtolower($city)]);
    }

    $deliveryAreas = $query->get(['id', 'vendor_id', 'postcode', 'city', 'village', 'area_name']);

    if ($deliveryAreas->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'No delivery areas found for this postcode and area'
        ], 200);
    }

    session()->put([
        'city' => $city,
        'postcode' => $postcode,
        'street' => $sublocality,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude
    ]);

    return response()->json(['status' => true, 'data' => $deliveryAreas]);
}

public function checkDeliveryArea(Request $request)
{
    $userLat = $request->latitude;
    $userLng = $request->longitude;
    $postcode = $request->postcode == 64 ? "64293" :$request->postcode;
    $street = $request->street ?? null;
        $street_number = $request->street_number ?? null;
        $state = $request->state ?? null;
    $sublocality = $request->sublocality;
    $city = $request->city;
    
    if (!$userLat || !$userLng) {
        return response()->json(['status' => false, 'message' => 'Latitude and longitude are required.'], 200);
    }

    // Optional: Save user location to session
    session()->put([
        'city' => $city,
        'postcode' => $postcode,
        'sublocality' => $sublocality,
        'street' => $street,
        'street_number' => $street_number,
        'latitude' => $userLat,
        'longitude' => $userLng
    ]);

    // Get vendors with location info
    $vendors = vendor_detail::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get(['id','vendor_id', 'company_name', 'latitude', 'longitude']);

    $eligibleVendors = [];

    foreach ($vendors as $vendor) {
        $distance = $this->calculateDistance($userLat, $userLng, $vendor->latitude, $vendor->longitude);
        $distance=round($distance);
        // dd($distance);
        $deliveryCharge = DeliveryCharge::where('vendor_id',$vendor->vendor_id)
            ->where('min_km', '<=', $distance)
            ->where('max_km', '>=', $distance)
            ->where('status', 1)
            ->first();
        
        
        if ($deliveryCharge) {
            $eligibleVendors[] = [
                'vendor_id' => $vendor->vendor_id,
                'vendor_name' => $vendor->company_name,
                'distance_km' => round($distance, 2),
                'delivery_charge' => $deliveryCharge->delivery_charge,
                'min_order_price' => $deliveryCharge->min_order_price,
                'free_above' => $deliveryCharge->min_order_price_free_delivery,
                'estimated_time' => $deliveryCharge->max_delivery_time,
            ];
        }
    }

    if (empty($eligibleVendors)) {
        return response()->json([
            'status' => false,
            'message' => 'No vendors deliver to this location.'
        ], 200);
    }

    return response()->json([
        'status' => true,
        'vendors' => $eligibleVendors
    ]);
}
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

    public function saveInSession(Request $request)
    {
        if (isset($request->postcode) && $request->postcode != '') {
            session()->put(['postcode' => $request->postcode, 'latitude' => $request->latitude, 'longitude' => $request->longitude]);
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false, 'message' => 'Error data not found!'], 200);
        }
    }


    public function saveLocation(Request $request)
    {
        if (isset(Auth::user()->id)) {
            $validator = Validator::make($request->all(), [
                'latitude'  => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ], 422);
            }
            $lat = $request->latitude;
            $lng = $request->longitude;
            $user = User::where('id', Auth::user()->id)->first();
            if ($lat == $user->latitude && $user->longitude == $lng && false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Location already saved',
                ]);
            }

            $userAgent = $request->header('User-Agent');
            $response = Http::withHeaders([
                'User-Agent' => $userAgent,
            ])->get("https://nominatim.openstreetmap.org/reverse?lat={$lat}&lon={$lng}&format=json");

            $data = $response->json();
            // dd($data);
            $postcode = 203131;
            $state = null;
            $city = null;
            $country = null;
            if (!empty($data['address'])) {
                $city = $data['address']['city'] ?? '';
                $postcode = $data['address']['postcode'] ?? 203001;
                $state = $data['address']['county'] ?? '';
                $country = $data['address']['country'] ?? '';
            }
            $user->latitude = $lat;
            $user->longitude = $lng;

            $user->zipcode = $postcode;
            $user->save();
            session()->put(['postcode' => $postcode, 'latitude' => $lat, 'longitude' => $lng]);
            $resp = ['zipcode' => $postcode, 'city' => $city, 'state' => $state, 'country' => $country, 'latitude' => $lat, 'longitude' => $lng];
            return response()->json(['success' => true, 'data' => $resp]);
        } else {
            $validator = Validator::make($request->all(), [
                'latitude'  => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ], 422);
            }
            $ip = $request->ip();
            $lat = $request->latitude;
            $lng = $request->longitude;
            $VirtualLocation = VirtualLocation::where('ip_address', $ip)->first();
            if (!$VirtualLocation) {
                $VirtualLocation = new VirtualLocation();
            }
            $userAgent = $request->header('User-Agent');
            $response = Http::withHeaders([
                'User-Agent' => $userAgent,
            ])->get("https://nominatim.openstreetmap.org/reverse?lat={$lat}&lon={$lng}&format=json");
            $data = $response->json();
            $postcode = 203131;
            $state = null;
            $city = null;
            $country = null;
            $address = null;
            if (!empty($data['address'])) {
                $city = $data['address']['city'] ?? '';
                $postcode = $data['address']['postcode'] ?? 203001;
                $state = $data['address']['county'] ?? '';
                $country = $data['address']['country'] ?? '';
            }
            $address = $data['display_name'] ?? '';
            $VirtualLocation->ip_address = $ip;
            $VirtualLocation->latitude = $lat;
            $VirtualLocation->longitude = $lng;
            $VirtualLocation->postcode = $postcode;
            $VirtualLocation->city = $city;
            $VirtualLocation->state = $state;
            $VirtualLocation->country = $country;
            $VirtualLocation->save();
            session()->put(['postcode' => $postcode, 'latitude' => $lat, 'longitude' => $lng]);
            $resp = ['zipcode' => $postcode, 'city' => $city, 'state' => $state, 'country' => $country, 'latitude' => $lat, 'longitude' => $lng];
            return response()->json(['success' => true, 'data' => $resp]);
        }
    }

    public function privacyPolicy()
    {
        return view('external.privacy-policy');
    }
    public function termCondition()
    {
        return view('external.terms-conditions');
    }
    public function cookiePolicy()
    {
        return view('external.cookie-policy');
    }
    public function refundCancellation()
    {
        return view('external.refund-cancellation');
    }
}
