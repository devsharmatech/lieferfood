<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use Illuminate\Http\Request;

class extraItemController extends Controller
{
    
    public function getExtra($id)
    {
        $extra = Extra::where('id', $id)->first();
        return response()->json($extra);
    }

    public function saveExtra(Request $request)
    {
        if (isset($request->extra_id) && !empty($request->extra_id)) {
            $extra = Extra::find($request->extra_id);
            $extra->extra_name = $request->extra_name;
            $extra->extra_price = $request->extra_price;
            $extra->extra_info = $request->extra_info;
            $extra->save();
            return response()->json($extra);
        } else {
            $extra = new Extra();
            $extra->food_id = $request->food_id;
            $extra->extra_name = $request->extra_name;
            $extra->extra_price = $request->extra_price;
            $extra->extra_info = $request->extra_info;
            $extra->save();
            return response()->json($extra);
        }
    }
    

    public function deleteExtra($id)
    {
        $extra = Extra::where('id', $id)->first();
        $extra->delete();
        return response()->json(['status' => true, 'message' => 'Successfully deleted']);
    }
}
