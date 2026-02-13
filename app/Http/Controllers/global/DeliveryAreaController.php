<?php

namespace App\Http\Controllers\global;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DeliveryArea;
use App\Models\DeliveryCharge;
use Illuminate\Support\Facades\Validator;

class DeliveryAreaController extends Controller
{
    //
    public function addDeliveryManager()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $areas = DeliveryArea::where('vendor_id', $id)->orderBy('postcode', 'asc')->get();
            // dd($areas);
            return view('vendor.delivery-area.delivery-area', compact('areas', 'id'));
        } else {
            abort(403);
        }
    }
    public function deliveryChargeManager()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $areas = DeliveryCharge::where('vendor_id', $id)->orderBy('min_km', 'asc')->get();
            // dd($areas);
            return view('vendor.delivery-area.delivery-charge', compact('areas', 'id'));
        } else {
            abort(403);
        }
    }
    public function saveDeliveryArea(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $validator = Validator::make(
                $request->all(),
                [
                    'postcode' => 'required|min:4|max:8',
                    'city' => 'required|string',
                    'village' => 'nullable|string',
                    'area_name' => 'nullable|string',
                    'delivery_charge' => 'required|numeric|min:0',
                    'min_order_price' => 'required|numeric|min:0',
                    'min_order_price_free_delivery' => 'required|numeric|min:0',
                    'max_delivery_time' => 'required|numeric|min:5',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['status' => false, 'errors' => $validator->errors()]);
            } else {
                $deliveryArea = new DeliveryArea();
                $deliveryArea->vendor_id = $id;
                $deliveryArea->postcode = $request->postcode;
                
                $deliveryArea->city = $request->city;
                $deliveryArea->village = $request->village ?? null;
                $deliveryArea->area_name = $request->area_name ?? null;
                
                $deliveryArea->delivery_charge = $request->delivery_charge;
                $deliveryArea->min_order_price = $request->min_order_price;
                $deliveryArea->min_order_price_free_delivery = $request->min_order_price_free_delivery;
                $deliveryArea->max_delivery_time = $request->max_delivery_time;
                $deliveryArea->save();
                return response()->json(['status' => true, 'message' => 'Delivery Area Added Successfully']);
            }
        } else {
            abort(403);
        }
    }
    
    public function saveDeliveryCharge(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $validator = Validator::make(
                $request->all(),
                [
                    'min_km' => 'required|numeric|min:0',
                    'max_km' => 'required|numeric|gt:min_km',
                    'delivery_charge' => 'required|numeric|min:0',
                    'min_order_price' => 'required|numeric|min:0',
                    'min_order_price_free_delivery' => 'required|numeric|min:0',
                    'max_delivery_time' => 'required|numeric|min:5',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['status' => false, 'errors' => $validator->errors()]);
            } else {
                $deliveryCharge = new DeliveryCharge();
                $deliveryCharge->vendor_id = $id;
                $deliveryCharge->min_km = $request->min_km;
                $deliveryCharge->max_km = $request->max_km;
                $deliveryCharge->delivery_charge = $request->delivery_charge;
                $deliveryCharge->min_order_price = $request->min_order_price;
                $deliveryCharge->min_order_price_free_delivery = $request->min_order_price_free_delivery;
                $deliveryCharge->max_delivery_time = $request->max_delivery_time;
                $deliveryCharge->save();
                return response()->json(['status' => true, 'message' => 'Delivery Charge range Added Successfully']);
            }
        } else {
            abort(403);
        }
    }

    public function destroy($id)
    {
        $postcode = DeliveryArea::find($id);
        if ($postcode) {
            $postcode->delete(); // Delete the record
            return response()->json([
                'status' => true,
                'message' => 'Record deleted successfully.'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Record not found.'
        ], 200);
    }
    
    public function destroyRange($id)
    {
        $deliveryCharge = DeliveryCharge::find($id);
        if ($deliveryCharge) {
            $deliveryCharge->delete(); // Delete the record
            return response()->json([
                'status' => true,
                'message' => 'Record deleted successfully.'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Record not found.'
        ], 200);
    }
    
    public function editDeliveryArea($id)
    {
        if (isset(auth()->user()->id)) {
            $vendor_id = auth()->user()->id;
            $area = DeliveryArea::where('id', $id)->where('vendor_id', $vendor_id)->first();
            if ($area) {
                return view('vendor.delivery-area.edit-delivery-area', compact('area'));
            } else {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Data not found!']);
            }
        } else {
            abort(403);
        }
    }
    
    public function editDeliveryCharge($id)
    {
        if (isset(auth()->user()->id)) {
            $vendor_id = auth()->user()->id;
            $area = DeliveryCharge::where('id', $id)->where('vendor_id', $vendor_id)->first();
            if ($area) {
                return view('vendor.delivery-area.edit-delivery-charge', compact('area'));
            } else {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Data not found!']);
            }
        } else {
            abort(403);
        }
    }

    public function saveDeliveryAreaChange(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required|exists:delivery_areas,id',
                    'postcode' => 'required|min:4|max:8',
                    'city' => 'required|string',
                    'village' => 'nullable|string',
                    'area_name' => 'nullable|string',
                    'delivery_charge' => 'required|numeric|min:0',
                    'min_order_price' => 'required|numeric|min:0',
                    'min_order_price_free_delivery' => 'required|numeric|min:0',
                    'max_delivery_time' => 'required|numeric|min:5',
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->with(['alert-type' => 'error', 'message' => 'Validation failed!']);
            } else {
                $deliveryArea = DeliveryArea::where('id', $request->id)->first();
                if ($deliveryArea) {
                    $deliveryArea->vendor_id = $id;
                    $deliveryArea->postcode = $request->postcode;
                    
                    $deliveryArea->city = $request->city;
                    $deliveryArea->village = $request->village ?? null;
                    $deliveryArea->area_name = $request->area_name ?? null;
                    
                    $deliveryArea->delivery_charge = $request->delivery_charge;
                    $deliveryArea->min_order_price = $request->min_order_price;
                    $deliveryArea->min_order_price_free_delivery = $request->min_order_price_free_delivery;
                    $deliveryArea->max_delivery_time = $request->max_delivery_time;
                    $deliveryArea->save();
                    return redirect()->route('vendor.all.delivery-areas')->with(['alert-type' => 'success', 'message' => 'Successfully save your changes!']);
                } else {
                    return redirect()->back()->with(['alert-type' => 'error', 'message' => 'This delivery area not found']);
                }
            }
        } else {
            return redirect()->route('admin.login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    
    public function saveDeliveryChargeChange(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required|exists:delivery_charges,id',
                    'min_km' => 'required|numeric|min:0',
                    'max_km' => 'required|numeric|gt:min_km',
                    'delivery_charge' => 'required|numeric|min:0',
                    'min_order_price' => 'required|numeric|min:0',
                    'min_order_price_free_delivery' => 'required|numeric|min:0',
                    'max_delivery_time' => 'required|numeric|min:5',
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->with(['alert-type' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $deliveryCharge = DeliveryCharge::where('id', $request->id)->first();
                if ($deliveryCharge) {
                     $deliveryCharge->vendor_id = $id;
                     $deliveryCharge->min_km = $request->min_km;
                     $deliveryCharge->max_km = $request->max_km;
                     $deliveryCharge->delivery_charge = $request->delivery_charge;
                     $deliveryCharge->min_order_price = $request->min_order_price;
                     $deliveryCharge->min_order_price_free_delivery = $request->min_order_price_free_delivery;
                     $deliveryCharge->max_delivery_time = $request->max_delivery_time;
                     $deliveryCharge->save();
                    return redirect()->route('vendor.all.delivery-charge')->with(['alert-type' => 'success', 'message' => 'Successfully save your changes!']);
                } else {
                    return redirect()->back()->with(['alert-type' => 'error', 'message' => 'This delivery charge range not found']);
                }
            }
        } else {
            return redirect()->route('admin.login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function updateStatus(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $field = $request->field;
            $status = $request->value;
            $deliveryArea = DeliveryArea::where('id', $request->id)->first();
            if ($deliveryArea) {
                $deliveryArea->$field = $status;
                $deliveryArea->save();
                return response()->json(['status' => true, 'message' => 'Status updated successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Delivery area not found']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first.']);
        }
    }
    
    public function updateStatusDeliveryCharge(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $field = $request->field;
            $status = $request->value;
            $deliveryArea = DeliveryArea::where('id', $request->id)->first();
            if ($deliveryArea) {
                $deliveryArea->$field = $status;
                $deliveryArea->save();
                return response()->json(['status' => true, 'message' => 'Status updated successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Delivery area not found']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first.']);
        }
    }
}
