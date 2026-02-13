<?php

namespace App\Http\Controllers;

use App\Models\customeOpening;
use App\Models\VendorOpeningTime;
use App\Models\VendorTableTime;
use Illuminate\Http\Request;

class VendorOpeningTimeController extends Controller
{
    //
    public function index()
    {
        if (isset(auth()->user()->id)) {

            $vendorId = auth()->user()->id;
            $timings = VendorOpeningTime::where('vendor_id', $vendorId)->orderBy('id', 'ASC')->get();

            if (!empty($timings[0])) {
                return view('vendor.timings.timings', compact('timings'));
            } else {

                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                foreach ($days as $day) {
                    VendorOpeningTime::firstOrCreate(
                        ['vendor_id' => $vendorId, 'day' => $day],
                        [
                            'is_pickup' => false,
                            'is_delivery' => false,
                            'delivery_times' => json_encode([]),
                            'pickup_times' => json_encode([])
                        ]
                    );
                }
                $timings = VendorOpeningTime::where('vendor_id', $vendorId)->orderBy('id', 'ASC')->get();
                return view('vendor.timings.timings', compact('timings'));
            }
        } else {
            abort(403);
        }
    }
    public function index2(){
       if (isset(auth()->user()->id)) {

            $vendorId = auth()->user()->id;
            $timings = VendorTableTime::where('vendor_id', $vendorId)->orderBy('id', 'ASC')->get();

            if (!empty($timings[0])) {
                return view('vendor.table.table-opening-time', compact('timings'));
            } else {

                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                foreach ($days as $day) {
                    VendorTableTime::firstOrCreate(
                        ['vendor_id' => $vendorId, 'day' => $day],
                        [
                            'is_table' => false,
                            'table_times' => json_encode([]),
                        ]
                    );
                }
                $timings = VendorTableTime::where('vendor_id', $vendorId)->orderBy('id', 'ASC')->get();
                return view('vendor.table.table-opening-time', compact('timings'));
            }
        } else {
            abort(403);
        } 
    }
    // Method for updating the timings
    public function update(Request $request, $id)
    {
        $timing = VendorOpeningTime::findOrFail($id);
        $timing->update([
            'delivery_times' => json_encode($request->delivery_times),
            'pickup_times' => json_encode($request->pickup_times),
        ]);
        return response()->json(['status' => 'success', 'message' => 'Timings updated successfully!']);
    }
    public function updateTableTime(Request $request, $id)
    {
        $timing = VendorTableTime::findOrFail($id);
        $timing->update([
            'table_times' => json_encode($request->tableTimes),
        ]);
        return response()->json(['status' => 'success', 'message' => 'Timings updated successfully!']);
    }

    public function updatePickupStatus(Request $request, $id)
    {
        $timing = VendorOpeningTime::findOrFail($id);
        $timing->update([
            'is_pickup' => $request->is_pickup,
        ]);
        return response()->json(['status' => 'success', 'message' => 'Pickup status updated successfully!']);
    }
    public function updateDeliverStatus(Request $request, $id)
    {
        $timing = VendorOpeningTime::findOrFail($id);
        $timing->update([
            'is_delivery' => $request->is_delivery,
        ]);
        return response()->json(['status' => 'success', 'message' => 'Delivery status updated successfully!']);
    }
    public function updateTableStatus(Request $request, $id)
    {
        $timing = VendorTableTime::findOrFail($id);
        $timing->update([
            'is_table' => $request->is_table,
        ]);
        return response()->json(['status' => 'success', 'message' => 'Table status updated successfully!']);
    }




    // all custome openings

    public function customeOpening()
    {
        if (isset(auth()->user()->id)) {

            $vendorId = auth()->user()->id;
            $timings = customeOpening::where('vendor_id', $vendorId)->orderBy('id', 'ASC')->get();
            return view('vendor.timings.custome-opening-timing', compact('timings'));
        } else {
            abort(403);
        }
    }

    public function saveCustomTiming(Request $request)
    {
        $request->validate([
            'open_date' => 'required|date',
            'pickup_times' => 'nullable|required_if:is_pickup,on|array',
            'delivery_times' => 'nullable|required_if:is_delivery,on|array',
        ]);

        $customeOpening = new customeOpening();
        $check = customeOpening::where('vendor_id', auth()->user()->id)
            ->where('open_date', $request->open_date)->first();
        if ($check) {
            return response()->json(['status' => false, 'message' => 'You already have same date']);
        }
        $customeOpening->vendor_id = auth()->user()->id;
        $customeOpening->open_date = $request->open_date;
        $customeOpening->is_pickup = $request->is_pickup ? 1 : 0;
        $customeOpening->is_delivery = $request->is_delivery ? 1 : 0;
        $customeOpening->pickup_times = json_encode($request->pickup_times);
        $customeOpening->delivery_times = json_encode($request->delivery_times);
        $customeOpening->save();

        return response()->json(['success' => true]);
    }



    public function updatePickupStatusCustome(Request $request, $id)
    {
        $timing = customeOpening::findOrFail($id);
        $timing->update([
            'is_pickup' => $request->is_pickup,
        ]);
        return response()->json(['status' => 'success', 'message' => 'Pickup status updated successfully!']);
    }
    public function updateDeliverStatusCustome(Request $request, $id)
    {
        $timing = customeOpening::findOrFail($id);
        $timing->update([
            'is_delivery' => $request->is_delivery,
        ]);
        return response()->json(['status' => 'success', 'message' => 'Delivery status updated successfully!']);
    }

    public function updateCustomeOpening(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'timing_id' => 'required|exists:custome_openings,id',
            'open_date' => 'required|date',
            'is_pickup' => 'nullable',
            'is_delivery' => 'nullable',
            'pickup_times' => 'nullable|required_if:is_pickup,on|array',
            'delivery_times' => 'nullable|required_if:is_delivery,on|array',
        ]);

        // Find the existing timing record
        $timing = customeOpening::find($request->timing_id);
        $timing->open_date = $request->open_date;
        $timing->is_pickup = $request->is_pickup ? 1 : 0;
        $timing->is_delivery = $request->is_delivery ? 1 : 0;
        $timing->pickup_times = json_encode($request->pickup_times);
        $timing->delivery_times = json_encode($request->delivery_times);
        $timing->save();
        return response()->json(['status' => true, 'message' => 'Timing updated successfully!']);
    }

    public function destroyCustomeOpening(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:custome_openings,id',
        ]);
        $timing = customeOpening::find($request->id);
        $timing->delete();
        return response()->json(['status'=>true,'message' => 'Timing deleted successfully!']);
    }
}
