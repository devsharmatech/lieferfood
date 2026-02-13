<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\add_favorite;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    //
    public function addFavorite(Request $request)
    {
        if ($request->has('user_id') && $request->input('user_id')!="") {
            $user_id = $request->input('user_id');
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
                return response()->json(['status' => false, 'message' => 'Vendor id is required!']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'User Id is required']);
        }
    }

    public function getFavoritesRestaurants(Request $request)
    {
        if ($request->has('user_id') && $request->input('user_id')!="") {
            $userId = $request->input('user_id');
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
            $open_vendors = $query->withCount('offers')->get();
            
            $open_vendors->each(function ($vendor) use ($userId) {
                $vendor['isOffer'] = $vendor->offers_count > 0;
            });
            
            return response()->json(['status' => true, 'message' => 'Successfully get all favorite shops!','shops'=>$open_vendors]);
        } else {
            return response()->json(['status' => false, 'message' => 'User id is required!']);
        }
    }
}
