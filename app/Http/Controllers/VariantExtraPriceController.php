<?php

namespace App\Http\Controllers;

use App\Models\collection_extra;
use App\Models\food_item;
use App\Models\foodVariant;
use App\Models\variant_extra_price;
use Illuminate\Http\Request;

class VariantExtraPriceController extends Controller
{
    //
    public function index($extra_id)
    {
        if (isset(auth()->user()->id)) {
            // check this extra is valid
            $isExtra = collection_extra::where('id', $extra_id)->where('vendor_id', auth()->user()->id)->first();
            if ($isExtra) {
                $variantExtraPrices = variant_extra_price::where('vendor_id', auth()->user()->id)->with('extra', 'variant.food_item')->get();
                $food_variants = foodVariant::whereHas('food_item', function ($query) {
                    $query->where('vendor_id', auth()->user()->id);
                })->with('food_item')->get();
                return view('vendor.collections.extras.extra-variant-price', compact('variantExtraPrices', 'food_variants', 'extra_id', 'isExtra'));
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Collection Extra Not Found']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first!']);
        }
    }

    public function store(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $request->validate([
                'variant' => 'required|exists:food_variants,id',
                'extra_id' => 'required|exists:collection_extras,id',
                'price' => 'required|numeric',
            ]);
            // check if already in database than update it
            $variantExtraPrice = variant_extra_price::where('vendor_id', auth()->user()->id)->where('variant_id', $request->variant)->where('extra_id', $request->extra_id)->first();

            if ($variantExtraPrice) {

                $variantExtraPrice->variant_id = $request->variant;
                $variantExtraPrice->vendor_id = auth()->user()->id;
                $variantExtraPrice->extra_id = $request->extra_id;
                $variantExtraPrice->price = $request->price;
                $variantExtraPrice->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Variant Extra Price updated Successfully']);
            } else {

                $variantExtraPrice = new variant_extra_price();
                $variantExtraPrice->variant_id = $request->variant;
                $variantExtraPrice->vendor_id = auth()->user()->id;
                $variantExtraPrice->extra_id = $request->extra_id;
                $variantExtraPrice->price = $request->price;
                $variantExtraPrice->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Variant Extra Price Added Successfully']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first']);
        }
    }

    public function destroy(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $variant_extra_price = variant_extra_price::find($request->id);
            if ($variant_extra_price) {
                $variant_extra_price->delete();
                return response()->json(['status' => true, 'message' => 'Variant extra price deleted']);
            } else {
                return response()->json(['status' => false, 'message' => 'Variant extra price is not found!']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first']);
            // abort(403);
        }
    }
}
