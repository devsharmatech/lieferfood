<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CollectionItem;
use App\Models\collections;
use App\Models\DeliveryArea;
use App\Models\DeliveryCharge;
use App\Models\Extra;
use App\Models\food_item;
use App\Models\foodVariant;
use App\Models\offer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller
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

public function getCart(Request $request)
{
    if (!Auth::check()) {
        return response()->json(['status' => false, 'message' => 'Please login first'], 200);
    }

    $vendor_id = $request->vendor_id;
    $postalcode = $request->postalcode;

    session(['postalcode' => $postalcode, 'restaurant' => $vendor_id]);

    $userLatitude = session('latitude');
    $userLongitude = session('longitude');

    $userId = Auth::id();

    // Get vendor's lat/lng
    $vendor = User::with('vendor_details')->where('id', $vendor_id)->first();
    $vendorLat = $vendor->vendor_details->latitude ?? null;
    $vendorLng = $vendor->vendor_details->longitude ?? null;

    $deliveryData = null;

    if ($userLatitude && $userLongitude && $vendorLat && $vendorLng) {
        $distance = $this->calculateDistance($userLatitude, $userLongitude, $vendorLat, $vendorLng);
$distance=round($distance);
        $deliveryChargeRow = DeliveryCharge::where('vendor_id', $vendor_id)
            ->where('min_km', '<=', $distance)
            ->where('max_km', '>=', $distance)
            ->where('status', 1)
            ->first();

        if ($deliveryChargeRow) {
            $deliveryData = [
                'distance_km' => round($distance, 2),
                'delivery_charge' => $deliveryChargeRow->delivery_charge,
                'min_order_price' => $deliveryChargeRow->min_order_price,
                'min_order_price_free_delivery' => $deliveryChargeRow->min_order_price_free_delivery,
                'max_delivery_time' => $deliveryChargeRow->max_delivery_time
            ];
        }
    }

    // Delete old carts from other vendors
    $deletedCarts = Cart::where('user_id', $userId)
        ->whereHas('food_item', function ($query) use ($vendor_id) {
            $query->where('vendor_id', '!=', $vendor_id);
        })->get();

    foreach ($deletedCarts as $cart) {
        $cart->delete();
    }

    // Fetch active restaurant offer
    $offer = Offer::where('created_by', $vendor_id)
        ->where('whichType', 'restaurant')
        ->where('start_date', '<=', now())
        ->where('end_date', '>', now())
        ->where('is_active', 1)
        ->first();

    // Load cart with relations
    $carts = Cart::latest()
        ->where('user_id', $userId)
        ->with('food_item.category.offer', 'food_item.offer', 'variant.variant_item')
        ->get();

    $restaurantDis = 0;
    $categoryDis = 0;
    $total_price = 0;

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

        // Load extras
        $dressing = CollectionItem::where('id', $cart->dressing_type)->with('sub_items')->first();
        $cart->dressing = $dressing->sub_items->name ?? "";

        $extraIds = is_array(json_decode($cart->extras, true)) ? json_decode($cart->extras, true) : [];
        $cart->collection_items = CollectionItem::where('status', 1)
            ->whereIn('id', $extraIds)
            ->with('sub_items', 'collectionData')
            ->get();
    }

    $discounts = [
        'onResturant' => floatVal($restaurantDis),
        'onCategory' => floatVal($categoryDis)
    ];

    return response()->json([
        'status' => true,
        'data' => $carts,
        'area' => $deliveryData,
        'discounts' => $discounts
    ], 200);
}

    public function store2(Request $request)
    {

        if (isset(Auth::user()->id)) {
            $validator = Validator::make($request->all(), [
                'food_id' => ['required', 'exists:food_items,id'],
                'quantity' => ['required', 'numeric', 'min:1'],
                'variant_id' => ['nullable', 'exists:food_variants,id'],
                'extras' => ['nullable', 'array'],
                'extras.*' => ['nullable', 'exists:collection_items,id'],
                'dressing_type' => ['nullable', 'numeric'],
                'isAlcohal' => ['required', 'numeric'],
                'total_price' => ['required', 'numeric'],
            ]);
            // dd($request->all());
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 200);
            } else {
                $cart = Cart::where('food_id', $request->food_id)->where('user_id', Auth::user()->id)->first();
                if ($cart) {
                    $cart->quantity = $request->quantity;
                    $cart->variant_id = $request->variant_id;
                    $cart->dressing_type = $request->dressing_type;
                    $cart->extras = json_encode($request->extras);
                    $cart->isAlcohol = $request->isAlcohal;
                    $cart->total_price = $request->total_price;
                    $cart->save();
                    return response()->json(['status' => true, 'message' => 'Cart updated successfully'], 200);
                } else {
                    $cart = new Cart();
                    $cart->user_id = Auth::user()->id;
                    $cart->quantity = $request->quantity;
                    $cart->variant_id = $request->variant_id;
                    $cart->food_id = $request->food_id;
                    $cart->dressing_type = $request->dressing_type;
                    $cart->extras = json_encode($request->extras);
                    $cart->isAlcohol = $request->isAlcohal;
                    $cart->total_price = $request->total_price;
                    $cart->save();
                    return response()->json(['status' => true, 'message' => 'Added In Cart'], 200);
                }
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first.'], 200);
        }
    }
  
    public function getCart1(Request $request)
    {
        if (isset(Auth::user()->id)) {
            $vendor_id = $request->vendor_id;
            $postalcode = $request->postalcode;
            // postcode store into session
            session(['postalcode' => $postalcode, 'restaurant' => $vendor_id]);
            $userPostcode = session('postcode');
            $userStreet = session('street');
            $userCity = session('city');
            $userLatitude = session('latitude');
            $userLongitude = session('longitude');
            
            $userId = Auth::user()->id;

            $deliveryArea = DeliveryArea::where('postcode', $userPostcode)
                ->where(function ($q) use ($userCity) {
                   $q->whereRaw('LOWER(city) = ?', [strtolower($userCity)]);
               })
                ->where(function ($q) use ($userStreet) {
                    $normalized = strtolower($userStreet);
                    $parts = preg_split('/[\s\-]+/', $normalized);
                    $shortestPart = end($parts);

                    $q->whereRaw('LOWER(area_name) LIKE ?', ['%' . $normalized . '%'])
                        ->orWhereRaw('LOWER(area_name) LIKE ?', ['%' . str_replace(' ', '', $normalized) . '%'])
                        ->orWhereRaw('LOWER(area_name) LIKE ?', ['%' . $shortestPart . '%']);
                })
                ->where('vendor_id', $vendor_id)
                ->first();
            $deletedCarts = Cart::latest()->where('user_id', $userId)->whereHas('food_item', function ($query) use ($vendor_id) {
                $query->where('vendor_id', '!=', $vendor_id);
            })->get();
            if ($deletedCarts) {
                foreach ($deletedCarts as $cart) {
                    $cart->delete();
                }
            }
            $offer = offer::where('created_by', $vendor_id)
                ->where('whichType', 'restaurant')
                ->where('start_date', '<=', now())
                ->where('end_date', '>', now())
                ->where('is_active', 1)
                ->first();
            // dd($offer);
            $carts = Cart::latest()->where('user_id', $userId)->with('food_item.category.offer', 'food_item.offer', 'variant.variant_item')->get();
            $restaurantDis = 0;
            $categoryDis = 0;
            $total_price = 0;
            foreach ($carts as $cart) {
                $offerl = null;
                if (isset($cart->food_item->offer)) {
                    $offerl = $cart->food_item->offer;
                } elseif (isset($cart->food_item->category->offer)) {
                    $offerl = $cart->food_item->category->offer;
                } elseif (isset($offer)) {
                    $offerl = $offer;
                }
                if (isset($offerl)) {
                    if ($offerl->offer_type == 'percentage') {
                        $categoryDis += ($offerl->discount_value / 100) * $cart->total_price;
                        $total_price += $cart->total_price - $categoryDis;
                    } elseif ($offer->offer_type == 'fixed') {
                        $categoryDis += $offerl->discount_value;
                        $total_price += $cart->total_price - $categoryDis;
                    } else {
                        $total_price += $cart->total_price;
                    }
                } else {
                    $total_price += $cart->total_price;
                }

                $dressing = CollectionItem::where('id', $cart->dressing_type)->with('sub_items')->first();

                $cart->dressing = (isset($dressing->sub_items->name)) ? $dressing->sub_items->name : "";
                $extraIds = is_array(json_decode($cart->extras, true)) ? json_decode($cart->extras, true) : [];

                $cart->collection_items = CollectionItem::where('status', 1)->whereIn('id', $extraIds)->with('sub_items', 'collectionData')->get();
            }

            $discounts = ['onResturant' => floatVal($restaurantDis), 'onCategory' => floatVal($categoryDis)];
            // dd($carts);
            return response()->json(['status' => true, 'data' => $carts, 'area' => $deliveryArea, 'discounts' => $discounts], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first'], 200);
        }
    }

    public function updateQty(Request $request)
    {
        if (isset(Auth::user()->id)) {
            $userId = Auth::user()->id;
            $cartId = $request['cart_id'];
            $quantity = $request['quantity'];
            $cart = Cart::find($cartId);
            if ($quantity < 1) {
                $cart->delete();
                return response()->json(
                    ['status' => true, 'message' => 'Quantity updated successfully'],
                    200
                );
            } else {

                if ($cart) {
                    $price = $cart->total_price / $cart->quantity;
                    $cart->quantity = $quantity;
                    $cart->total_price = $price * $quantity;
                    $cart->save();
                    return response()->json(
                        ['status' => true, 'message' => 'Quantity updated successfully'],
                        200
                    );
                } else {
                    return response()->json(
                        ['status' => false, 'message' => 'Cart not found'],
                        200
                    );
                }
            }
        } else {
            return response()->json(
                ['status' => false, 'message' => 'Please login first'],
                200
            );
        }
    }

    public function updateNote(Request $request)
    {
        if (isset(Auth::user()->id)) {
            $userId = Auth::user()->id;
            $cartId = $request['cart_item_id'];
            $extra_note = $request['extra_note'];
            $cart = Cart::find($cartId);
            if ($cart) {
                $cart->extra_note = $extra_note;
                $cart->save();
                return response()->json(
                    ['status' => true, 'message' => 'Note updated successfully'],
                    200
                );
            } else {
                return response()->json(
                    ['status' => false, 'message' => 'Cart not found'],
                    200
                );
            }
        } else {
            return response()->json(
                ['status' => false, 'message' => 'Please login first'],
                200
            );
        }
    }

    public function getCartProductDetail(Request $request)
    {
        if (isset(Auth::user()->id)) {
            $userId = Auth::user()->id;
            $cartId = $request['cart_item_id'];
            $cart = Cart::latest()->where('user_id', $userId)->where('id', $cartId)->first();
            if (isset($cart->food_id)) {
                $food = food_item::whereId($cart->food_id)->with('variants.variant_item')->first();
                $collectionIds = json_decode($food->collections, true);
                $collections = collections::with('collection_items.sub_items')
                    ->whereIn('id', $collectionIds)->orderBy('sort', 'ASC')
                    ->get();
                foreach ($collections as $collection) {
                    foreach ($collection->collection_items as $item) {
                        $item->prices = json_decode($item->prices, true);
                    }
                }
                $extraIds = is_array(json_decode($cart->extras, true)) ? json_decode($cart->extras, true) : [];
                $cart->variant = foodVariant::where('id', $cart->variant_id)->first();
                return response()->json([
                    'status' => true,
                    'cart' => $cart,
                    'extraIds' => $extraIds,
                    'food' => $food,
                    'collections' => $collections
                ]);
            } else {
                return response()->json(
                    ['status' => false, 'message' => 'Cart not found'],
                    200
                );
            }
        } else {
            return response()->json(
                ['status' => false, 'message' => 'Please login first'],
                200
            );
        }
    }
}
