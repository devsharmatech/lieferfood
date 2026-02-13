<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\offer;
use App\Models\collection_drink;
use App\Models\collection_extra;
use App\Models\CollectionItem;
use App\Models\DeliveryArea;
use App\Models\collections;
use App\Models\food_item;
use App\Models\foodVariant;
use App\Models\special_request;
use App\Models\suppliment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class cartController extends Controller
{
    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'food_id' => ['required', 'exists:food_items,id'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'variant_id' => ['required', 'exists:food_variants,id'],
            'extras' => ['nullable', 'array'],
            'extras.*' => ['nullable', 'exists:collection_items,id'],
            'dressing_type' => ['required', 'numeric'],
            'isAlcohal' => ['required', 'numeric'],
            'total_price' => ['required', 'numeric'],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 200);
        } else {
            $cart = Cart::where('food_id', $request->food_id)->where('user_id', $request->user_id)->first();
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
                $cart->user_id = $request->user_id;
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

    }
    
    public function getCart(Request $request)
    {
        if (isset($request->user_id)) {
            $vendor_id = $request->vendor_id;
            $postalcode = $request->postalcode;
            // postcode store into session
            session(['postalcode' => $postalcode, 'restaurant' => $vendor_id]);
            $userId = $request->user_id;

            $deliveryArea = DeliveryArea::where('postcode', $postalcode)->where('vendor_id', $vendor_id)->first();
            $deletedCarts = Cart::latest()->where('user_id', $userId)->whereHas('food_item', function ($query) use ($vendor_id) {
                $query->where('vendor_id', '!=', $vendor_id);
            })->get();
            if ($deletedCarts) {
                foreach ($deletedCarts as $cart) {
                    $cart->delete();
                }
            }
            $offer=offer::where('created_by',$vendor_id)
                        ->where('whichType','restaurant')
                        ->where('start_date', '<=', now()) 
                        ->where('end_date', '>', now()) 
                        ->where('is_active',1) 
                        ->first();
            $carts = Cart::latest()->where('user_id', $userId)->with('food_item.category.offer', 'variant.variant_item')->get();
            $restaurantDis = 0;
                 $categoryDis = 0;
                 $total_price = 0;
            foreach ($carts as $cart) {
                if(isset($cart->food_item->category->offer)){
                   $categoryOffer= $cart->food_item->category->offer;
                 if ($categoryOffer->offer_type == 'percentage') {
                       $categoryDis += ($categoryOffer->discount_value / 100) * $cart->total_price; 
                       $total_price += $cart->total_price-$categoryDis; 
                  } elseif ($categoryOffer->offer_type == 'fixed') {
                       $categoryDis += $categoryOffer->discount_value; 
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
                $cart->collection_items = CollectionItem::where('status', 1)->whereIn('id', $extraIds)->with('sub_items')->get();
            }
            if ($offer) {
              if ($offer->offer_type == 'percentage') {
                 $restaurantDis = ($offer->discount_value / 100) * $total_price;
               } elseif ($offer->offer_type == 'fixed') {
                 $restaurantDis = $offer->discount_value;
               }
            }
            $discounts=['onResturant'=>number_format(floatVal($restaurantDis),2),'onCategory'=>number_format(floatVal($categoryDis),2)];
            return response()->json(['status' => true, 'data' => $carts, 'area' => $deliveryArea,'discounts'=>$discounts], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first'], 200);
        }
    }

    public function updateQty(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'cart_id' => 'required|exists:carts,id',
                'quantity' => 'required|numeric|min:0',
            ]
        );
        if ($validate->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $validate->errors()], 200);
        }

        $userId = $request->user_id;
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
                    ['status' => true, 'message' => 'Quantity updated successfully', 'data' => $cart],
                    200
                );
            } else {
                return response()->json(
                    ['status' => false, 'message' => 'Cart not found'],
                    200
                );
            }
        }
    }
    
    
     public function getCartProductDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'cart_item_id' => ['required', 'numeric'],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 200);
        }
        
            $userId = $request->user_id;
            $cartId = $request->cart_item_id;
            $cart = Cart::latest()->where('user_id', $userId)->where('id', $cartId)->first();
            if (isset($cart->food_id)) {
                $food = food_item::whereId($cart->food_id)->with('variants.variant_item')->first();
                $collectionIds = json_decode($food->collections, true);
                $collections = collections::with('collection_items.sub_items')
                    ->whereIn('id', $collectionIds)->orderBy('sort','ASC')
                    ->get();
                foreach ($collections as $collection) {
                    foreach ($collection->collection_items as $item) {
                        $item->prices = json_decode($item->prices, true);
                    }
                }
                $extraIds = is_array(json_decode($cart->extras, true)) ? json_decode($cart->extras, true) : [];
                $cart->variant=foodVariant::where('id',$cart->variant_id)->first();
                return response()->json([
                    'status' => true,
                    'cart' => $cart,
                    'extraIds' => $extraIds,
                    'food' => $food,
                    'collections'=>$collections
                ]);
            } else {
                return response()->json(
                    ['status' => false, 'message' => 'Cart not found'],
                    200
                );
            }
        
    }
}
