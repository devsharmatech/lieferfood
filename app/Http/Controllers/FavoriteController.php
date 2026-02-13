<?php

namespace App\Http\Controllers;

use App\Models\add_favorite;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    //
    public function addFavorite(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $user_id = auth()->user()->id;
            if (isset($request->vendor_id)) {
                $vendor_id = $request->vendor_id;
                $favorite = add_favorite::where('user_id', $user_id)
                    ->where('vendor_id', $vendor_id)
                    ->first();
                if ($favorite) {
                    $favorite->delete();
                    return response()->json(['status' => true, 'message' => 'Favorite removed Successfully']);
                } else {
                    $addFav = new add_favorite();
                    $addFav->user_id = $user_id;
                    $addFav->vendor_id = $vendor_id;
                    $addFav->save();
                    return response()->json(['status' => true, 'message' => 'Favorite Added Successfully']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Something went to wrong!']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first.']);
        }
    }

    public function getFavoritesRestaurants(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $userId = auth()->user()->id;
            $query = User::query()->with('vendor_details', 'offers')
            ->where('role','vendor')
            ->where('isVendorDetail',1)
            ->whereHas('favorites', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            });
            ;
            if ($request->has('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
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
            $query->orderBy('isFeatured', 'ASC');
            $open_vendors = $query->withCount('offers')->paginate(10);
            
            $open_vendors->each(function ($vendor) use ($userId) {

                // $isFavorite = add_favorite::where('vendor_id', $vendor->id)
                //     ->where('user_id', $userId)
                //     ->exists();
                $vendor['isOffer'] = $vendor->offers_count > 0;
                // $vendor['isFav'] = $isFavorite ? true : false;
            });
            //  dd($open_vendors);
            return view('external.favorites-restaurants.my-favorits-restaurants', compact('open_vendors'));
        } else {
            return back()->with(['status' => false, 'message' => 'Please login first.']);
        }
    }
}
