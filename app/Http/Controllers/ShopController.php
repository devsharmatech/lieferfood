<?php

namespace App\Http\Controllers;

use App\Models\add_favorite;
use App\Models\category;
use App\Models\collection_drink;
use App\Models\collection_extra;
use App\Models\collections;
use App\Models\customeOpening;
use App\Models\DeliveryArea;
use App\Models\DeliveryCharge;
use App\Models\Extra;
use App\Models\food_item;
use App\Models\foodVariant;
use App\Models\gallery;
use App\Models\offer;
use App\Models\review;
use App\Models\slot_offer;
use App\Models\slots;
use App\Models\special_request;
use App\Models\suppliment;
use App\Models\User;
use App\Models\VendorOpeningTime;
use App\Models\VendorTableTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    //
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

public function index(Request $request)
{
    $userLatitude = session('latitude');
    $userLongitude = session('longitude');

    $query = User::query()
        ->with('vendor_details', 'reviews.user')
        ->withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->where('role', 'vendor');

    if ($userLatitude && $userLongitude) {
        $query->selectRaw(
            "users.*, 
            (6371 * acos(cos(radians(?)) * cos(radians(vendor_details.latitude)) * 
            cos(radians(vendor_details.longitude) - radians(?)) + 
            sin(radians(?)) * sin(radians(vendor_details.latitude)))) AS distance",
            [$userLatitude, $userLongitude, $userLatitude]
        )
        ->join('vendor_details', 'users.id', '=', 'vendor_details.vendor_id')
        ->having('distance', '>=', 0)
        ->orderBy('distance', 'ASC');
    }

    $categories = Category::orderBy('sort', 'ASC')->where('status', 1)->whereIn('vendor_id', ["", 5])->get();

    if ($request->has('slug')) {
        $category = Category::where('slug', $request->slug)->first();
        if (!empty($category)) {
            $query->whereHas('vendor_details', function ($query) use ($category) {
                $query->whereJsonContains('categories', (string) $category->id);
            });
        }
    }
   
if ($request->has('categories')) {
    $categorySlugs = explode(',', $request->input('categories'));
    $categoryIds = Category::whereIn('slug', $categorySlugs)->pluck('id')->toArray();
    
    if (!empty($categoryIds)) {
        $query->whereHas('vendor_details', function($query) use ($categoryIds) {
            $query->where(function($q) use ($categoryIds) {
                foreach ($categoryIds as $categoryId) {
                    $q->orWhereJsonContains('categories', (string)$categoryId);
                }
            });
        });
    }
}
    if ($request->has('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // if ($request->has('restaurant_status') && $request->input('restaurant_status') !== '') {
    //     $query->whereHas('vendor_details', function ($query) use ($request) {
    //         $query->where('restaurant_status', $request->input('restaurant_status'));
    //     });
    // } else {
    //     $query->whereHas('vendor_details', function ($query) {
    //         $query->where('restaurant_status', 1);
    //     });
    // }

    // if ($request->has('isDelivery') && $request->input('isDelivery') !== '') {
    //     $query->whereHas('vendor_details', function ($query) use ($request) {
    //         $query->where('isDelivery', $request->input('isDelivery'));
    //     });
    // }

    if ($request->input('show') === 'low') {
        $query->whereHas('vendor_details', function ($query) {
            $query->where('minimum_price', '<=', 1000);
        });
    }

    if ($request->input('show') === 'heigh') {
        $query->whereHas('vendor_details', function ($query) {
            $query->where('minimum_price', '>=', 1000);
        });
    }

    if ($request->has('service_type')) {
        if ($request->input('service_type') == 0) {
            $query->whereHas('vendor_details', function ($query) {
                $query->where('isPickup', 1);
            });
        } elseif ($request->input('service_type') == 1) {
            $query->whereHas('vendor_details', function ($query) {
                $query->where('isDelivery', 1);
            });
        }
    }

    if ($request->has('star') && $request->input('star') !== '') {
        $query->having('reviews_avg_rating', '>=', (float)$request->input('star'));
    }

    if ($request->input('offer') === 'true') {
        $query->whereHas('offers', function ($query) {
            $query->where('is_active', 1);
        });
    }

    if ($request->input('sort_by') === 'price_low_to_high') {
        $query->whereHas('vendor_details', function ($query) {
            $query->orderBy('minimum_price', 'ASC');
        });
    }

    if ($request->input('sort_by') === 'price_high_to_low') {
        $query->whereHas('vendor_details', function ($query) {
            $query->orderBy('minimum_price', 'DESC');
        });
    }

    $open_vendors = $query->withCount('offers')->get();

    // Apply delivery charge filter only if service_type is NOT set
    if (!$request->has('service_type')) {
        $open_vendors = $open_vendors->filter(function ($vendor) use ($userLatitude, $userLongitude) {
            $vendorLat = $vendor->vendor_details->latitude ?? null;
            $vendorLng = $vendor->vendor_details->longitude ?? null;

            if (!$vendorLat || !$vendorLng || !$userLatitude || !$userLongitude) {
                return false;
            }

            $distance = $this->calculateDistance($userLatitude, $userLongitude, $vendorLat, $vendorLng);
            $distance=round($distance);
            $deliveryCharge = DeliveryCharge::where('vendor_id', $vendor->id)
                ->where('min_km', '<=', $distance)
                ->where('max_km', '>=', $distance)
                ->where('status', 1)
                ->first();

            if (!$deliveryCharge) {
                return false;
            }

            // Attach delivery info
            $vendor['delivery_charge'] = $deliveryCharge->delivery_charge;
            $vendor['estimated_time'] = $deliveryCharge->max_delivery_time;
            $vendor['min_order_price'] = $deliveryCharge->min_order_price;
            $vendor['min_order_price_free_delivery'] = $deliveryCharge->min_order_price_free_delivery;

            return true;
        })->values();
    } else {
        // Even if not filtering, attach delivery charge if available
        foreach ($open_vendors as $vendor) {
            if (isset($vendor->vendor_details->latitude, $vendor->vendor_details->longitude, $userLatitude, $userLongitude)) {
                $distance = $this->calculateDistance($userLatitude, $userLongitude, $vendor->vendor_details->latitude, $vendor->vendor_details->longitude);
                $distance=round($distance);
                $deliveryCharge = DeliveryCharge::where('vendor_id', $vendor->id)
                    ->where('min_km', '<=', $distance)
                    ->where('max_km', '>=', $distance)
                    ->where('status', 1)
                    ->first();

                if ($deliveryCharge) {
                    $vendor['delivery_charge'] = $deliveryCharge->delivery_charge;
                    $vendor['estimated_time'] = $deliveryCharge->max_delivery_time;
                    $vendor['min_order_price'] = $deliveryCharge->min_order_price;
                    $vendor['min_order_price_free_delivery'] = $deliveryCharge->min_order_price_free_delivery;
                }
            }
        }
    }

    $timezone = 'Europe/Berlin';
    $currentDateTime = Carbon::now($timezone);

    $open_vendors->each(function ($vendor) use ($currentDateTime) {
        $availability = $this->checkVendorAvailability($vendor->id, $currentDateTime);

        if (isset($vendor->distance)) {
            $vendor->distance = number_format($vendor->distance, 2) . ' km';
        }

        $offers = Offer::where('is_active', 1)
            ->where('created_by', $vendor->id)
            ->where('whichType', 'restaurant')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->where(function ($query) {
                $query->whereDoesntHave('slots')
                    ->orWhereHas('slots', function ($subQuery) {
                        $subQuery->whereTime('start_time', '<=', now())
                            ->whereTime('end_time', '>=', now());
                    });
            })
            ->with(['slots' => function ($query) {
                $query->whereTime('start_time', '<=', now())
                    ->whereTime('end_time', '>=', now())
                    ->orderBy('start_time')
                    ->limit(1);
            }])->get();

        $vendor['offers'] = $offers;
        $vendor['isOffer'] = $vendor->offers_count > 0;
        $vendor['average_rating'] = $vendor->reviews_avg_rating ?? 5;
        $vendor['total_reviews'] = $vendor->reviews_count;
        $vendor['availability'] = $availability;

        $categoryIds = !empty($vendor->vendor_details->categories) ? json_decode($vendor->vendor_details->categories, true) : [];
        $categoryNames = !empty($categoryIds)
            ? Category::whereIn('id', $categoryIds)->pluck('name')->implode(', ')
            : '';
        $vendor['category_names'] = $categoryNames;
    });

    return view('external.shop.shop', compact('categories', 'open_vendors'));
}


public function index2(Request $request)
{
    $userLatitude = session('latitude');
    $userLongitude = session('longitude');

    $query = User::query()
        ->with('vendor_details', 'reviews.user')
        ->withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->where('role', 'vendor');

    if ($userLatitude && $userLongitude) {
        $query->selectRaw(
            "users.*, 
            (6371 * acos(cos(radians(?)) * cos(radians(vendor_details.latitude)) * 
            cos(radians(vendor_details.longitude) - radians(?)) + 
            sin(radians(?)) * sin(radians(vendor_details.latitude)))) AS distance",
            [$userLatitude, $userLongitude, $userLatitude]
        )
        ->join('vendor_details', 'users.id', '=', 'vendor_details.vendor_id')
        ->having('distance', '>', 0)
        ->orderBy('distance', 'ASC');
    }

    $categories = Category::orderBy('sort', 'ASC')->where('status', 1)->whereIn('vendor_id', ["", 5])->get();

    if ($request->has('slug')) {
        $category = Category::where('slug', $request->slug)->first();
        if (!empty($category)) {
            $query->whereHas('vendor_details', function ($query) use ($category) {
                $query->whereJsonContains('categories', (string) $category->id);
            });
        }
    }

if ($request->has('categories')) {
    $categorySlugs = explode(',', $request->input('categories'));
    $categoryIds = Category::whereIn('slug', $categorySlugs)->pluck('id')->toArray();
    
    if (!empty($categoryIds)) {
        $query->whereHas('vendor_details', function($query) use ($categoryIds) {
            $query->where(function($q) use ($categoryIds) {
                foreach ($categoryIds as $categoryId) {
                    $q->orWhereJsonContains('categories', (string)$categoryId);
                }
            });
        });
    }
}

    if ($request->has('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->has('restaurant_status') && $request->input('restaurant_status') !== '') {
        $query->whereHas('vendor_details', function ($query) use ($request) {
            $query->where('restaurant_status', $request->input('restaurant_status'));
        });
    } else {
        $query->whereHas('vendor_details', function ($query) {
            $query->where('restaurant_status', 1);
        });
    }

    if ($request->has('isDelivery') && $request->input('isDelivery') !== '') {
        $query->whereHas('vendor_details', function ($query) use ($request) {
            $query->where('isDelivery', $request->input('isDelivery'));
        });
    }

    if ($request->input('show') === 'low') {
        $query->whereHas('vendor_details', function ($query) {
            $query->where('minimum_price', '<=', 1000);
        });
    }

    if ($request->input('show') === 'heigh') {
        $query->whereHas('vendor_details', function ($query) {
            $query->where('minimum_price', '>=', 1000);
        });
    }

    if ($request->has('service_type')) {
        if ($request->input('service_type') == 0) {
            $query->whereHas('vendor_details', function ($query) {
                $query->where('isPickup', 1);
            });
        } elseif ($request->input('service_type') == 1) {
            $query->whereHas('vendor_details', function ($query) {
                $query->where('isDelivery', 1);
            });
        }
    }

    if ($request->has('star') && $request->input('star') !== '') {
        $query->having('reviews_avg_rating', '>=', (float)$request->input('star'));
    }

    if ($request->input('offer') === 'true') {
        $query->whereHas('offers', function ($query) {
            $query->where('is_active', 1);
        });
    }

    if ($request->input('sort_by') === 'price_low_to_high') {
        $query->whereHas('vendor_details', function ($query) {
            $query->orderBy('minimum_price', 'ASC');
        });
    }

    if ($request->input('sort_by') === 'price_high_to_low') {
        $query->whereHas('vendor_details', function ($query) {
            $query->orderBy('minimum_price', 'DESC');
        });
    }

    $open_vendors = $query->withCount('offers')->get();

    // Filter by delivery range
    $open_vendors = $open_vendors->filter(function ($vendor) use ($userLatitude, $userLongitude) {
        $vendorLat = $vendor->vendor_details->latitude ?? null;
        $vendorLng = $vendor->vendor_details->longitude ?? null;

        if (!$vendorLat || !$vendorLng) {
            return false;
        }

        $distance = $this->calculateDistance($userLatitude, $userLongitude, $vendorLat, $vendorLng);

        $deliveryCharge = DeliveryCharge::where('vendor_id', $vendor->id)
            ->where('min_km', '<=', $distance)
            ->where('max_km', '>', $distance)
            ->where('status', 1)
            ->first();

        if (!$deliveryCharge) {
            return false;
        }

        // Attach delivery info to vendor
        $vendor['delivery_charge'] = $deliveryCharge->delivery_charge;
        $vendor['estimated_time'] = $deliveryCharge->max_delivery_time;
        $vendor['min_order_price'] = $deliveryCharge->min_order_price;
        $vendor['min_order_price_free_delivery'] = $deliveryCharge->min_order_price_free_delivery;

        return true;
    })->values(); // reindex the collection

    $timezone = 'Europe/Berlin';
    $currentDateTime = Carbon::now($timezone);

    $open_vendors->each(function ($vendor) use ($currentDateTime) {
        $availability = $this->checkVendorAvailability($vendor->id, $currentDateTime);

        if (isset($vendor->distance)) {
            $vendor->distance = number_format($vendor->distance, 2) . ' km';
        }

        $offers = Offer::where('is_active', 1)
            ->where('created_by', $vendor->id)
            ->where('whichType', 'restaurant')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->where(function ($query) {
                $query->whereDoesntHave('slots')
                    ->orWhereHas('slots', function ($subQuery) {
                        $subQuery->whereTime('start_time', '<=', now())
                            ->whereTime('end_time', '>=', now());
                    });
            })
            ->with(['slots' => function ($query) {
                $query->whereTime('start_time', '<=', now())
                    ->whereTime('end_time', '>=', now())
                    ->orderBy('start_time')
                    ->limit(1);
            }])->get();

        $vendor['offers'] = $offers;
        $vendor['isOffer'] = $vendor->offers_count > 0;
        $vendor['average_rating'] = $vendor->reviews_avg_rating ?? 5;
        $vendor['total_reviews'] = $vendor->reviews_count;
        $vendor['availability'] = $availability;

        $categoryIds = !empty($vendor->vendor_details->categories) ? json_decode($vendor->vendor_details->categories, true) : [];
        $categoryNames = !empty($categoryIds)
            ? Category::whereIn('id', $categoryIds)->pluck('name')->implode(', ')
            : '';
        $vendor['category_names'] = $categoryNames;
    });
    
    // dd($open_vendors);
    return view('external.shop.shop', compact('categories', 'open_vendors'));
}

    public function index1(Request $request)
    {
        $userLatitude = session('latitude');
        $userLongitude = session('longitude');
        $userPostcode = session('postcode');
        $userStreet = session('street');
        $userCity = session('city');

        $query = User::query()
            ->with('vendor_details', 'reviews.user')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('role', 'vendor');
        if ($userLatitude && $userLongitude) {
            $query->selectRaw(
                "
            users.*, 
            (6371 * acos(cos(radians(?)) * cos(radians(vendor_details.latitude)) * 
            cos(radians(vendor_details.longitude) - radians(?)) + 
            sin(radians(?)) * sin(radians(vendor_details.latitude)))) AS distance",
                [$userLatitude, $userLongitude, $userLatitude]
            )
                ->join('vendor_details', 'users.id', '=', 'vendor_details.vendor_id')
                ->having('distance', '>', 0)
                ->orderBy('distance', 'ASC');
        }

        $categories = category::orderBy('sort', 'ASC')->where('status', 1)->whereIn('vendor_id', ["", 5])->get();

        if (isset($request->slug)) {
            $category = category::where('slug', $request->slug)->first();
            if (!empty($category)) {
                $query->whereHas('vendor_details', function ($query) use ($category) {
                    $query->whereJsonContains('categories', (string) $category->id);
                });
            }
        }
        // dd($query->get());

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('restaurant_status') && $request->input('restaurant_status') != '') {
            $query->whereHas('vendor_details', function ($query) use ($request) {
                $query->where('restaurant_status', $request->input('restaurant_status'));
            });
        } else {
            $query->whereHas('vendor_details', function ($query) {
                $query->where('restaurant_status', 1);
            });
        }

        if ($request->has('isDelivery') && $request->input('isDelivery') != '') {
            $query->whereHas('vendor_details', function ($query) use ($request) {
                $query->where('isDelivery', $request->input('isDelivery'));
            });
        }

        if ($request->has('show') && $request->input('show') == 'low') {
            $query->whereHas('vendor_details', function ($query) {
                $query->where('minimum_price', '<=', 1000);
            });
        }

        if ($request->has('show') && $request->input('show') == 'heigh') {
            $query->whereHas('vendor_details', function ($query) {
                $query->where('minimum_price', '>=', 1000);
            });
        }

        if ($request->has('service_type') && $request->input('service_type') == 0) {
            $query->whereHas('vendor_details', function ($query) {
                $query->where('isPickup', '=', 1);
            });
        } elseif ($request->has('service_type') && $request->input('service_type') == 1) {
            $query->whereHas('vendor_details', function ($query) {
                $query->where('isDelivery', '=', 1);
            });
        }
        if ($request->has('star') && $request->input('star') != '') {
            $starRating = (float) $request->input('star');
            $query->having('reviews_avg_rating', '>=', $starRating);
        }
        if ($request->has('offer') && $request->input('offer') == 'true') {
            $query->whereHas('offers', function ($query) {
                $query->where('is_active', 1);
            });
        }

        if ($request->has('sort_by') && $request->input('sort_by') == "price_low_to_high") {
            $query->whereHas('vendor_details', function ($query) use ($request) {
                $query->orderBy('minimum_price', 'ASC');
            });
        }

        if ($request->has('sort_by') && $request->input('sort_by') == "price_high_to_low") {
            $query->whereHas('vendor_details', function ($query) use ($request) {
                $query->orderBy('minimum_price', 'DESC');
            });
        }
        $open_vendors = $query->withCount('offers')->get();

        $timezone = 'Europe/Berlin';
        $currentDateTime = Carbon::now($timezone);
        $open_vendors->each(function ($vendor) use ($currentDateTime, $userPostcode, $userStreet,$userCity) {

            $availability = $this->checkVendorAvailability($vendor->id, $currentDateTime);
            if (isset($vendor->distance)) {
                $vendor->distance = number_format($vendor->distance, 2) . ' km';
            }
            $offers = Offer::where('is_active', 1)
                ->where('created_by', $vendor->id)
                ->where('whichType', 'restaurant')
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->where(function ($query) {
                    $query->whereDoesntHave('slots')
                        ->orWhereHas('slots', function ($subQuery) {
                            $subQuery->whereTime('start_time', '<=', now())
                                ->whereTime('end_time', '>=', now());
                        });
                })
                ->with(['slots' => function ($query) {
                    $query->whereTime('start_time', '<=', now())
                        ->whereTime('end_time', '>=', now())
                        ->orderBy('start_time')
                        ->limit(1);
                }])
                ->get();

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
               $getFirstMatchedArea = $query->where('vendor_id', $vendor->id)
                ->first(); 

            $vendor['area'] = $getFirstMatchedArea ?? [];
            $vendor['offers'] = $offers ?? [];
            $vendor['isOffer'] = $vendor->offers_count > 0;
            $vendor['average_rating'] = $vendor->reviews_avg_rating ?? 5;
            $vendor['total_reviews'] = $vendor->reviews_count;
            $vendor['availability'] = $availability;

            $categoryIds = !empty($vendor->vendor_details->categories) ? json_decode($vendor->vendor_details->categories, true) : [];
            $categoryNames = !empty($categoryIds) ? Category::whereIn('id', $categoryIds)->pluck('name')->implode(', ')  : '';
            $vendor['category_names'] = $categoryNames;
        });

        // dd($open_vendors);

        return view('external.shop.shop', compact('categories', 'open_vendors'));
    }

    public function viewRestaurant(Request $request, $unid)
    {
        $vendor = User::with('vendor_details', 'table_service', 'vendor_opening_times', 'delivery_areas')
            ->where('unid', $unid)
            ->where('role', 'vendor')
            ->withCount([
                'reviews as rating_count' => function ($query) {
                    $query->select(DB::raw('count(*)'));
                }
            ])
            ->withAvg('reviews', 'rating')
            ->first();
        // dd($vendor->toArray());  
        $timezone = 'Europe/Berlin';
        $vendorOffer = Offer::where('is_active', 1)
            ->where('created_by', $vendor->id)
            ->where('whichType', 'restaurant')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->where(function ($query) {
                $query->whereDoesntHave('slots')
                    ->orWhereHas('slots', function ($subQuery) {
                        $subQuery->whereTime('start_time', '<=', now())
                            ->whereTime('end_time', '>=', now());
                    });
            })
            ->with(['slots' => function ($query) {
                $query->whereTime('start_time', '<=', now())
                    ->whereTime('end_time', '>=', now())
                    ->orderBy('start_time')
                    ->limit(1);
            }])
            ->get();
        // dd($vendorOffer);                
        $averageRating = $vendor->reviews_avg_rating ?? 5;
        $ratingCount = $vendor->rating_count ?? 0;
        if (isset(Auth::user()->id)) {
            $id = Auth::user()->id;
            $fav = add_favorite::where('vendor_id', $vendor->id)->where('user_id', $id)->first();
            if ($fav) {
                $isFav = true;
            } else {
                $isFav = false;
            }
        } else {
            $isFav = false;
        }
        $now = now('Europe/Berlin');
        $feedbacks = review::where('vendor_id', $vendor->id)->with('user')->where('status', 1)->get();
        if (isset($request->slug) && !empty($request->slug)) {
            $categories_data = category::when($request->slug, function ($query) use ($request) {
                $query->where('slug', $request->slug);
            })->whereHas('food_items', function ($query) use ($vendor) {
                $query->where('vendor_id', $vendor->id)
                    ->where('is_available', 1);
            })->with(['offer' => function ($query) use ($now) {
                $query->where('is_active', 1)
                    ->whereDate('start_date', '<=', $now)
                    ->whereDate('end_date', '>=', $now)
                    ->where(function ($q) use ($now) {
                        $q->whereDoesntHave('slots')
                            ->orWhereHas('slots', function ($subQ) use ($now) {
                                $subQ->whereTime('start_time', '<=', $now->format('H:i:s'))
                                    ->whereTime('end_time', '>=', $now->format('H:i:s'));
                            });
                    });
            }, 'food_items' => function ($query) use ($vendor, $now) {
                $query->where('vendor_id', $vendor->id)
                    ->where('is_available', 1)
                    ->with([
                        'offer' => function ($q) use ($now) {
                            $q->where('is_active', 1)
                                ->whereDate('start_date', '<=', $now)
                                ->whereDate('end_date', '>=', $now)
                                ->where(function ($q2) use ($now) {
                                    $q2->whereDoesntHave('slots')
                                        ->orWhereHas('slots', function ($subQ) use ($now) {
                                            $subQ->whereTime('start_time', '<=', $now->format('H:i:s'))
                                                ->whereTime('end_time', '>=', $now->format('H:i:s'));
                                        });
                                });
                        },
                        'vendor',
                        'variants'
                    ])->orderBy('sort', 'ASC');
            }])->orderBy('sort', 'ASC')->get();
        } else {


            $categories_data = category::when($request->slug, function ($query) use ($request) {
                $query->where('slug', $request->slug);
            })->whereHas('food_items', function ($query) use ($vendor) {
                $query->where('vendor_id', $vendor->id)
                    ->where('is_available', 1);
            })->with([
                'offer' => function ($query) use ($now) {
                    $query->where('is_active', 1)
                        ->whereDate('start_date', '<=', $now)
                        ->whereDate('end_date', '>=', $now)
                        ->where(function ($q) use ($now) {
                            $q->whereDoesntHave('slots')
                                ->orWhereHas('slots', function ($subQ) use ($now) {
                                    $subQ->whereTime('start_time', '<=', $now->format('H:i:s'))
                                        ->whereTime('end_time', '>=', $now->format('H:i:s'));
                                });
                        });
                },
                'food_items' => function ($query) use ($vendor, $now) {
                    $query->where('vendor_id', $vendor->id)
                        ->where('is_available', 1)
                        ->with([
                            'offer' => function ($q) use ($now) {
                                $q->where('is_active', 1)
                                    ->whereDate('start_date', '<=', $now)
                                    ->whereDate('end_date', '>=', $now)
                                    ->where(function ($q2) use ($now) {
                                        $q2->whereDoesntHave('slots')
                                            ->orWhereHas('slots', function ($subQ) use ($now) {
                                                $subQ->whereTime('start_time', '<=', $now->format('H:i:s'))
                                                    ->whereTime('end_time', '>=', $now->format('H:i:s'));
                                            });
                                    });
                            },
                            'vendor',
                            'variants'
                        ])->orderBy('sort', 'ASC');
                }
            ])->orderBy('sort', 'ASC')->get();
        }

        $categories = food_item::select('category_id')
            ->distinct()
            ->with('category')
            ->where('is_available', 1)
            ->where('vendor_id', $vendor->id)
            ->orderBy('sort', 'ASC')
            ->get();
        $timezone = 'Europe/Berlin';
        $currentDateTime = Carbon::now($timezone); // Current date and time
        $availability = $this->checkVendorAvailability($vendor->id, $currentDateTime);
        if (!empty($vendor)) {
           
            return view('external.shop.restaurant-view', compact('vendor', 'averageRating', 'ratingCount', 'categories', 'categories_data', 'vendorOffer', 'isFav', 'feedbacks', 'availability'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'This restaurant is not found!']);
        }
    }

    public function tableShop($unid)
    {
        $vendor = User::with('vendor_details', 'table_service')->where('unid', $unid)->where('role', 'vendor')->first();
        if (isset(Auth::user()->id)) {
            $isFav = add_favorite::where('vendor_id', $vendor->id)->where('user_id', Auth::user()->id)->first();
            if ($isFav) {
                $isFav = true;
            } else {
                $isFav = false;
            }
        } else {
            $isFav = false;
        }
        $gallery = gallery::latest()->where('vendor_id', $vendor->id)->where('status', 1)->get();
        $todaySlot = $this->getCurrentDayTimes($vendor->id);
        // dd($todaySlot);
        if (!empty($vendor)) {
            return view('external.shop.table-booking', compact('vendor', 'todaySlot', 'gallery', 'isFav'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'This restaurant is not found!']);
        }
    }

    public function generateSlots(Request $request)
    {
        $timezone = 'Europe/Berlin'; // Define the timezone for Germany
        $vendorId = $request->input('vendor_id');
        $date = $request->input('date', Carbon::now($timezone)->toDateString()); // Use the timezone variable
        $dayOfWeek = Carbon::parse($date, $timezone)->format('l');

        // Fetch the vendor table time for the given date and vendor
        $vendorTableTime = VendorTableTime::where('vendor_id', $vendorId)
            ->withCount('offers')
            ->where('day', $dayOfWeek)
            ->where('is_table', 1)
            ->first();

        if (!$vendorTableTime) {
            return response()->json([
                'success' => false,
                'message' => 'No table times available for the selected vendor and date.',
                'slots' => [],
            ]);
        }

        $tableTimes = json_decode($vendorTableTime->table_times, true);

        // Generate slots, filtering past slots if the date is today
        $slots = $this->generateTimeSlots($tableTimes, $date, $timezone);
        $offers = $vendorTableTime->offers_count ?? 0;

        return response()->json([
            'success' => true,
            'message' => 'Slots generated successfully.',
            'vendorTableTimeId' => $vendorTableTime->id,
            'slots' => $slots,
            'offers' => $offers,
        ]);
    }

    private function generateTimeSlots(array $tableTimes, $date, $timezone)
    {
        $slots = [];
        $currentDate = Carbon::now($timezone)->toDateString();
        $currentTime = Carbon::now($timezone)->format('H:i'); // Current time in the given timezone

        foreach ($tableTimes as $time) {
            $start = Carbon::createFromFormat('H:i', $time['start'], $timezone);
            $end = Carbon::createFromFormat('H:i', $time['end'], $timezone);

            while ($start->lt($end)) {
                $slotTime = $start->format('H:i');

                // Include slot only if it's not a past slot on the current day
                if ($date > $currentDate || ($date === $currentDate && $slotTime > $currentTime)) {
                    $slots[] = $slotTime;
                }

                $start->addMinutes(30); // Increment by 30 minutes
            }
        }

        return $slots;
    }

    public function getCurrentDayTimes($vendor_id)
    {
        $timezone = 'Europe/Berlin';
        $vendorId = $vendor_id;
        $dayOfWeek = Carbon::now($timezone)->format('l');

        // Fetch the vendor's table time for the current day
        $vendorTableTime = VendorTableTime::where('vendor_id', $vendorId)
            ->where('day', $dayOfWeek)
            ->first();

        if (!$vendorTableTime) {
            return [
                'success' => false,
                'message' => 'No table times available for the selected vendor.',
                'is_table' => false,
                'start_end_times' => [],
            ];
        }

        $tableTimes = json_decode($vendorTableTime->table_times, true);
        $startEndTimes = array_map(function ($time) {
            return [
                'start' => $time['start'],
                'end' => $time['end']
            ];
        }, $tableTimes);

        return [
            'success' => true,
            'message' => 'Times fetched successfully.',
            'is_table' => (bool)$vendorTableTime->is_table,
            'start_end_times' => $startEndTimes,
        ];
    }



    public function fetchOffers($slid)
    {
        $offers = slot_offer::where('slot_id', $slid)->where('status', 1)->get();
        // dd($offers);
        if (isset($offers)) {
            return response()->json($offers);
        } else {
            return response()->json(['message' => 'No offers available for this slot']);
        }
    }

    public function storeFeedback(Request $request)
    {
        if (isset(Auth::user()->id)) {
            $request->validate([
                'vendor_id' => ['required', 'exists:users,id'],
                'rating' => ['required', 'numeric', 'between:1,5'],
                'feedback' => ['required', 'string']
            ]);
            $feedback = review::where('user_id', Auth::user()->id)->where('vendor_id', $request->vendor_id)->first();
            if ($feedback) {
                $feedback->vendor_id = $request->vendor_id;
                $feedback->rating = $request->rating;
                $feedback->content = $request->feedback;
                $feedback->status = 0;
                $feedback->save();
            } else {
                $feedback = new review();
                $feedback->vendor_id = $request->vendor_id;
                $feedback->user_id = Auth::user()->id;
                $feedback->rating = $request->rating;
                $feedback->content = $request->feedback;
                $feedback->status = 0;
                $feedback->save();
            }
            return back()->with(['alert-type' => 'success', 'message' => 'Feedback submitted successfully']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    
    public function getReview(Request $request)
    {
        $review = review::where('user_id', Auth::user()->id)
            ->where('vendor_id', $request->vendor_id)
            ->where('order_id', $request->order_id)
            ->first();
        return response()->json(['success' => true, 'data' => $review]);
    }
    public function reportReview(Request $request)
    {
        if (isset(Auth::user()->id)) {

            $review = review::where('vendor_id', Auth::user()->id)
                ->where('id', $request->review_id)
                ->first();
            //   dd($request->review_id);            
            if ($review) {
                $review->isReport = 1;
                $review->report_msg = $request->message;
                $review->reason = $request->reason;
                $review->save();
            }
            return response()->json(['success' => true, 'message' => 'Your report is send to the admin!']);
        }
        return response()->json(['success' => false, 'message' => 'Login first!']);
    }
    public function storeReview(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'vendor_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Review::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'order_id' => $request->order_id,
                'vendor_id' => $request->vendor_id,
            ],
            [
                'content' => $validated['content'],
                'rating' => $validated['rating'],
            ]
        );

        return response()->json(['success' => true, 'message' => 'Review saved successfully.']);
    }
    public function getVendorDetails($id)
    {
        $vendor = User::with([
            'vendor_details',
            'reviews' => function ($query) {
                $query->select('reviews.*', 'users.name as reviewer_name')
                    ->join('users', 'reviews.user_id', '=', 'users.id')
                    ->where('reviews.status', 1);
            }
        ])
            ->where('id', $id)
            ->firstOrFail();

        // Prepare data
        $reviews = $vendor->reviews->map(function ($review) {
            return [
                'reviewer_name' => $review->reviewer_name,
                'date' => $review->created_at->format('F j, Y'),
                'food_name' => "",
                'rating' => $review->rating,
                'id' => $review->id,
                'report_msg' => $review->report_msg,
                'message' => $review->content,
            ];
        });

        return response()->json([
            'vendor_name' => $vendor->name,
            'vendor_description' => $vendor->vendor_details->description,
            'average_rating' => $vendor->reviews->avg('rating'), // Calculate average rating
            'total_reviews' => $vendor->reviews->count(),
            'reviews' => $reviews,
        ]);
    }

    public function getFoodDetails($food_id)
    {

        $food = food_item::with('collections', 'variants')->find($food_id);
        // return response()->json($food);
        if ($food->collection) {
            $collection = collections::with(['food_items.variants', 'food_items.extras'])->find($food->collection);
        } else {
            $collection = null;
        }

        return response()->json([
            'food' => $food,
            'collection' => $collection
        ]);
    }
    public function getFoodDetails2($food_id)
    {

        $food = food_item::with('collections', 'variants')->find($food_id);
        $toppings = '';
        if (isset($food->id) && $food->id != null && $food->id != '') {
            $toppings = Extra::where('food_id')->get();
        }
        $variants = [];
        if (
            isset($food->id) && $food->id != null && $food->id != ''
        ) {
            $variants_array = foodVariant::where('food_id', $food->id)->get('id')->toArray();
            if (isset($variants_array) && is_array($variants_array) && count($variants_array) > 0) {
                foreach ($variants_array as $variant) {
                    array_push($variants, $variant['id']);
                }
            }
        }
        // dd($variants);
        $extras = '';
        if (isset($food->collection) && $food->collection != null && $food->collection != '') {
            $extras = collection_extra::where('collection_id', $food->collection)->where('status', 1)->with([
                'variantPrices' => function ($query) use ($variants) {
                    $query->whereIn('variant_id', $variants);
                }
            ])->get();
        }
        $supplements = '';
        if (isset($food->collection) && $food->collection != null && $food->collection != '') {
            $supplements = suppliment::where('collection_id', $food->collection)->where('status', 1)->get();
        }
        $special_requests = '';
        if (isset($food->collection) && $food->collection != null && $food->collection != '') {
            $special_requests = special_request::where('collection_id', $food->collection)->where('status', 1)->get();
        }
        $alcohols = '';
        if (isset($food->collection) && $food->collection != null && $food->collection != '') {
            $alcohols = collection_drink::where('collection_id', $food->collection)->where('status', 1)->where('type', 1)->get();
        }
        $nonalcohols = '';
        if (isset($food->collection) && $food->collection != null && $food->collection != '') {
            $nonalcohols = collection_drink::where('collection_id', $food->collection)->where('status', 1)->where('type', 0)->get();
        }
        $extData = [];
        if ($extras) {
            $extData = $extras->map(function ($extra) {
                return [
                    'id' => $extra->id,
                    'name' => $extra->name,
                    'price' => $extra->price,
                    'info' => $extra->info,
                    'prices' => $extra->variantPrices->pluck('price', 'variant_id')
                ];
            });
        }
        return response()->json([
            'food' => $food,
            'toppings' => $toppings,
            'extras' => $extData,
            // 'extras' => $extras,
            'supplements' => $supplements,
            'special_requests' => $special_requests,
            'alcohols' => $alcohols,
            'nonalcohols' => $nonalcohols
        ]);
    }

    public function getFoodDetails3(Request $request)
    {
        $food = food_item::whereId($request->id)->with('variants.variant_item')->first();
        $collectionIds = json_decode($food->collections, true);
        // Fetch the collections and their items
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
    }







    private function checkVendorAvailability($vendor_id, $currentDateTime)
    {
        // Parse date and time details
        $day = strtolower($currentDateTime->format('l'));
        $day = ucfirst($day);
        $date = $currentDateTime->format('Y-m-d');
        $currentTime = $currentDateTime->format('H:i');
        $deliveryTimes = '';
        $pickupTimes = '';

        $customOpening = customeOpening::where('vendor_id', $vendor_id)
            ->where('open_date', $date)
            ->first();

        if ($customOpening) {
            if (isset($customOpening->is_delivery) && $customOpening->is_delivery == 1) {
                $deliveryTimes = $customOpening->delivery_times;
            }
            if (isset($customOpening->is_pickup) && $customOpening->is_pickup == 1) {
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
                    'delivery_start' => '',
                    'pickup_start' => '',
                ];
            }
            if (isset($vendorOpeningTime->is_delivery) && $vendorOpeningTime->is_delivery == 1) {
                $deliveryTimes = $vendorOpeningTime->delivery_times;
            }
            if (isset($vendorOpeningTime->is_pickup) && $vendorOpeningTime->is_pickup == 1) {

                $pickupTimes = $vendorOpeningTime->pickup_times;
            }
        }

        // Step 4: Check if current time falls within delivery or pickup times
        $isDeliveryOpen = $this->checkTimeRange($deliveryTimes, $currentTime);
        $isPickupOpen = $this->checkTimeRange($pickupTimes, $currentTime);
        $deliveryTimes = $this->getTimes($deliveryTimes);
        $pickupTimes = $this->getTimes($pickupTimes);
        // If the vendor is not open, get the next available opening time
        if ($isDeliveryOpen !== true) {
            $deliveryStartTime = $isDeliveryOpen ? $isDeliveryOpen : ''; // If not open, get the next start time
        } else {
            $deliveryStartTime = ''; // Vendor is open, no need to show start time
        }

        if ($isPickupOpen !== true) {
            $pickupStartTime = $isPickupOpen ? $isPickupOpen : ''; // If not open, get the next start time
        } else {
            $pickupStartTime = ''; // Vendor is open, no need to show start time
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
            $startTime = Carbon::createFromFormat('H:i', $timeRange->start, $timezone);
            $endTime = Carbon::createFromFormat('H:i', $timeRange->end, $timezone);
            $current = Carbon::createFromFormat('H:i', $currentTime, $timezone);

            // Check if current time is within the range
            if ($current->between($startTime, $endTime)) {
                return true; // Vendor is currently open
            }

            // If the current time is before the start time, return the upcoming opening time
            if ($current->lt($startTime)) {
                return $timeRange->start; // Return only the next opening time
            }
        }

        return false; // Vendor is closed and no upcoming opening time
    }


    private function getTimes($times, $currentTime = null)
    {
        $times = json_decode($times);
        if (is_array($times)) {
            // If $currentTime is provided, filter times to show only upcoming ones
            if ($currentTime) {
                $current = Carbon::createFromFormat('H:i', $currentTime);
                $upcomingTimes = array_filter($times, function ($timeRange) use ($current) {
                    $startTime = Carbon::createFromFormat('H:i', $timeRange->start);
                    return $current->lt($startTime); // Include only future opening times
                });
                return $upcomingTimes;
            }
            return $times;
        }

        return [];
    }
    private function zcheckTimeRange($times, $currentTime)
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
    private function zgetTimes($times)
    {
        $times = json_decode($times);
        if (is_array($times)) {
            return $times;
        } else {
            return [];
        }
    }
}
