<?php

namespace App\Http\Controllers;

use App\Models\food_item;
use App\Models\foodVariant;
use Illuminate\Http\Request;

class variantController extends Controller
{
    //
    public function getVariant($id)
    {
        $variant = foodVariant::where('id', $id)->first();
        return response()->json($variant);
    }

    public function saveVariant(Request $request)
    {
        if (isset($request->variant_id) && !empty($request->variant_id)) {
            $variant = foodVariant::find($request->variant_id);
            $variant->variant_name = $request->variant_name;
            $variant->price = $request->price;
            $variant->additional_details = $request->additional_details;
            $variant->save();
            return response()->json($variant);
        } else {
            $variant = new foodVariant();
            $variant->food_id = $request->food_id;
            $variant->variant_name = $request->variant_name;
            $variant->price = $request->price;
            $variant->additional_details = $request->additional_details;
            $variant->save();
            return response()->json($variant);
        }
    }
    

    public function deleteVariant($id)
    {
        $variant = foodVariant::where('id', $id)->first();
        $variant->delete();
        return response()->json(['status' => true, 'message' => 'Successfully deleted']);
    }
}
