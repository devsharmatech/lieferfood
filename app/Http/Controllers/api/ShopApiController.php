<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\add_favorite;
use App\Models\category;
use App\Models\collection_drink;
use App\Models\collection_extra;
use App\Models\collections;
use App\Models\Extra;
use App\Models\foodVariant;
use App\Models\special_request;
use App\Models\suppliment;
use App\Models\food_item;
use App\Models\review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\VendorOpeningTime;
use App\Models\customeOpening;
use Carbon\Carbon;
class ShopApiController extends Controller
{
    //
private function checkVendorAvailability($vendor_id, $currentDateTime)
{
        
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
                
                return [
                    'is_delivery_open' => false,
                    'is_pickup_open' => false,
                    'deliveryTimes' => [],
                    'pickupTimes' => [],
                    'delivery_start' => '',
                    'pickup_start' => '',
                ];
            }
            if(isset($vendorOpeningTime->is_delivery) && $vendorOpeningTime->is_delivery==1){
               $deliveryTimes = $vendorOpeningTime->delivery_times; 
            }
            if(isset($vendorOpeningTime->is_pickup) && $vendorOpeningTime->is_pickup==1){
              
               $pickupTimes = $vendorOpeningTime->pickup_times;
            }
        }

        
        $isDeliveryOpen = $this->checkTimeRange($deliveryTimes, $currentTime);
        $isPickupOpen = $this->checkTimeRange($pickupTimes, $currentTime);
        $deliveryTimes = $this->getTimes($deliveryTimes);
        $pickupTimes = $this->getTimes($pickupTimes);
        
if ($isDeliveryOpen !== true) {
    $deliveryStartTime = $isDeliveryOpen ? $isDeliveryOpen : ''; 
} else {
    $deliveryStartTime = ''; 
}

if ($isPickupOpen !== true) {
    $pickupStartTime = $isPickupOpen ? $isPickupOpen : '';
} else {
    $pickupStartTime = ''; 
}
        return [
             'is_delivery_open' => $isDeliveryOpen === true,
             'is_pickup_open' => $isPickupOpen === true,
             'delivery_start' => $deliveryStartTime,
             'pickup_start' => $pickupStartTime,
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
    $timezone = 'Europe/Berlin';
    foreach ($times as $timeRange) {
        $startTime = Carbon::createFromFormat('H:i', $timeRange->start,$timezone);
        $endTime = Carbon::createFromFormat('H:i', $timeRange->end,$timezone);
        $current = Carbon::createFromFormat('H:i', $currentTime,$timezone);
        if ($current->between($startTime, $endTime)) {
            return true; 
        }
        if ($current->lt($startTime)) {
            return $timeRange->start;
        }
    }

    return false;
}
private function getTimes($times, $currentTime = null)
{
    $times = json_decode($times);
    if (is_array($times)) {
        
        if ($currentTime) {
            $current = Carbon::createFromFormat('H:i', $currentTime);
            $upcomingTimes = array_filter($times, function ($timeRange) use ($current) {
                $startTime = Carbon::createFromFormat('H:i', $timeRange->start);
                return $current->lt($startTime); 
            });
            return $upcomingTimes;
        }
        return $times;
    }

    return [];
}
    
    public function allVendors(Request $request)
    {
        if ($request->has('user_id')) {
            $userId = $request->input('user_id');
            $query = User::query()
                ->orderBy('name','ASC')
                ->with('vendor_details', 'offers', 'reviews.user')
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')->where('role', 'vendor');
        } else {
            $query = User::query()
                ->orderBy('name','ASC')
                ->with('vendor_details', 'offers', 'reviews.user')
                ->withAvg('reviews', 'rating')
                ->withCount('reviews');
        }

        $categories = category::orderBy('sort','ASC')->where('status',1)->whereIn('vendor_id',["",5])->get();
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $vendors = $query->withCount('offers')->get();
        $userId = null;
        if ($request->has('user_id')) {
            $userId = $request->input('user_id');
        }
        $timezone = 'Europe/Berlin';
        $currentDateTime = Carbon::now($timezone); 
        $vendors->each(function ($vendor) use ($userId,$currentDateTime) {
            
            $isFavorite = false;
            if ($userId != null) {
                $isFavorite = add_favorite::where('vendor_id', $vendor->id)
                    ->where('user_id', $userId)
                    ->exists();
            }
            
            $vendor['isOffer'] = $vendor->offers_count > 0;
            $vendor['average_rating'] = $vendor->reviews_avg_rating ?? 5;
            $vendor['total_reviews'] = $vendor->reviews_count;
            $vendor['isFav'] = $isFavorite ? true : false;
            
            
            
            $availability = $this->checkVendorAvailability($vendor->id, $currentDateTime);
            $vendor['open_close_times'] =  $availability;
            
        });
        $data = ['vendors' => $vendors, 'categories' => $categories];
        return response()->json(['status' => true, 'message' => 'Successfully fetched all restaurants.', 'data' => $data]);
    }

    public function viewRestaurant(Request $request)
    {
        if ($request->has('vendor_id') && $request->input('vendor_id') != '') {
            $vendorId = $request->input('vendor_id');
            $vendor = User::with('vendor_details', 'table_service')
                ->where('id', $vendorId)
                ->where('role', 'vendor')
                ->withCount([
                    'reviews as rating_count' => function ($query) {
                        $query->select(DB::raw('count(*)'));
                    }
                ])
                ->withAvg('reviews', 'rating')
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
            if (isset($request->slug) && !empty($request->slug)) {
                $categories_data = category::where('slug', $request->slug)
                    ->whereHas('food_items', function ($query) use ($vendor) {
                        // Ensure food_items exist for the specified vendor and are available
                        $query->where('vendor_id', $vendor->id)
                            ->where('is_available', 1);
                    })
                    ->with([
                        'food_items' => function ($query) use ($vendor) {
                            // Fetch the related food_items with vendor and variants
                            $query->where('vendor_id', $vendor->id)
                                ->where('is_available', 1)
                                ->with('variants')
                                ->orderBy('sort', 'ASC');
                        }
                    ])
                    ->get();
            } else {
                $categories_data = category::whereHas('food_items', function ($query) use ($vendor) {
                    $query->where('vendor_id', $vendor->id)
                        ->where('is_available', 1);
                })
                    ->with([
                        'food_items' => function ($query) use ($vendor) {
                            $query->where('vendor_id', $vendor->id)
                                ->where('is_available', 1)
                                ->with('variants')
                                ->orderBy('sort', 'ASC');
                        }
                    ])
                    ->get();
            }
            $categories = food_item::select('category_id')
                ->distinct()
                ->with('category')
                ->where('is_available', 1)
                ->where('vendor_id', $vendor->id)
                ->get();
            $data = [
                'vendor' => $vendor,
                'average_rating' => $averageRating,
                'rating_count' => $ratingCount,
                'isFav' => $isFav,
                'feedbacks' => $feedbacks,
                'categories_data' => $categories_data,
                'categories' => $categories
            ];
            $timezone = 'Europe/Berlin';
            $currentDateTime = Carbon::now($timezone); 
            $availability = $this->checkVendorAvailability($vendor->id, $currentDateTime);
            return response()->json(['status' => true, 'message' => 'Successfully fetched restaurant details', 'data' => $data, 'availability' => $availability]);
        } else {
            return response()->json(['status' => false, 'message' => 'Vendor id is required.']);
        }
    }

    public function viewDeals(Request $request)
    {
        if (isset($request->food_id)) {
            $food = food_item::whereId($request->food_id)->with('variants.variant_item')->first();
            if ($food) {
            $collectionIds=[];
            if ($food->collections != null) {
                $collectionIds = json_decode($food->collections, true);
            }
            $collections = [];
            if ($collectionIds != null) {

                $collections = collections::with('collection_items.sub_items')
                    ->whereIn('id', $collectionIds)->orderBy('sort', 'ASC')
                    ->get();
                foreach ($collections as $collection) {
                    foreach ($collection->collection_items as $item) {
                        $item->prices = json_decode($item->prices, true);
                    }
                }
            }
            $data = ['food' => $food, 'collections' => $collections];
            return response()->json(['status' => true, 'data' => $data]);
        }else{
            return response()->json([
                'status' => false,
                'data' => [
                    'food' => [],
                    'collections' => []
                ],
                'message'=>'Food is not exist!'
            ]);
        }
        } else {
            return response()->json([
                'status' => false,
                'data' => [
                    'food' => [],
                    'collections' => []
                ]
            ]);
        }
    }


}
