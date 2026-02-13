<?php

namespace App\Http\Controllers;

use App\Models\collections;
use App\Models\special_request;
use Illuminate\Http\Request;

class SpecialRequestController extends Controller
{
    //
    public function index(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $edit_special_request = '';
            if (isset($request->id) && $request->id != '') {
                $edit_special_request = special_request::latest()->where('vendor_id', auth()->user()->id)->where('id', $request->id)->first();
            }

            $special_requests = special_request::latest()->where('vendor_id', auth()->user()->id)->with('collection_data')->get();
            $collections = collections::latest()->where('vendor_id', auth()->user()->id)->get();
            return view('vendor.collections.special-requests.index', compact('special_requests', 'collections', 'edit_special_request'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'You are not logged in']);
        }
    }

    public function saveSpecialRequest(Request $request)
    {
        if (isset(auth()->user()->id)) {
            if (isset($request->request_id) && $request->request_id != '') {
                $request->validate([
                    'request_id' => 'required|exists:special_requests,id',
                    'collection' => 'required|exists:collections,id',
                    'name' => 'required',
                    'price' => 'required|numeric|min:1',
                    'info' => 'nullable|string',
                ]);
                $special_request = special_request::where('id', $request->request_id)->where('vendor_id', auth()->user()->id)->first();
                if ($special_request) {
                    $special_request->collection_id = $request->collection;
                    $special_request->name = $request->name;
                    $special_request->price = $request->price;
                    $special_request->info = $request->info;
                    $special_request->vendor_id = auth()->user()->id;
                    $special_request->save();
                    return redirect()->route('vendor.all.special-request')->with(['alert-type' => 'success', 'message' => 'Successfully create special request.']);
                } else {
                    return back()->with(['alert-type' => 'error', 'message' => 'Drink not found.']);
                }
            } else {

                $request->validate([
                    'collection' => 'required|exists:collections,id',
                    'name' => 'required',
                    'price' => 'required|numeric|min:1',
                    'info' => 'nullable|string',
                ]);
                $special_request = new special_request();
                $special_request->collection_id = $request->collection;
                $special_request->name = $request->name;
                $special_request->price = $request->price;
                $special_request->info = $request->info;
                $special_request->vendor_id = auth()->user()->id;
                $special_request->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully create special request.']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function statusSpecialRequest(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $special_request = special_request::find($request->id);
            if ($special_request) {
                $special_request->status = $request->status;
                $special_request->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Status updated']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Not found']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first']);
        }
    }

    public function destroySpecialRequest(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $special_request = special_request::find($request->id);
            if ($special_request) {
                $special_request->delete();
                return response()->json(['status' => true, 'message' => 'Collection special request deleted']);
            } else {
                return response()->json(['status' => false, 'message' => 'Collection special request is not found!']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first']);
            // abort(403);
        }
    }
}
