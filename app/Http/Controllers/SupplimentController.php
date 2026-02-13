<?php

namespace App\Http\Controllers;

use App\Models\collections;
use App\Models\suppliment;
use Illuminate\Http\Request;

class SupplimentController extends Controller
{
    //
    public function index(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $edit_suppliment = '';
            if (isset($request->id) && $request->id != '') {
                $edit_suppliment = suppliment::latest()->where('vendor_id', auth()->user()->id)->where('id', $request->id)->first();
            }

            $suppliments = suppliment::latest()->where('vendor_id', auth()->user()->id)->with('collection_data')->get();
            $collections = collections::latest()->where('vendor_id', auth()->user()->id)->get();
            return view('vendor.collections.suppliments.index', compact('suppliments', 'collections', 'edit_suppliment'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'You are not logged in']);
        }
    }

    public function saveSuppliment(Request $request)
    {
        if (isset(auth()->user()->id)) {
            if (isset($request->suppliment_id) && $request->suppliment_id != '') {
                $request->validate([
                    'suppliment_id' => 'required|exists:suppliments,id',
                    'collection' => 'required|exists:collections,id',
                    'name' => 'required',
                    'price' => 'required|numeric|min:1',
                    'info' => 'nullable|string',
                ]);
                $suppliment = suppliment::where('id', $request->suppliment_id)->where('vendor_id', auth()->user()->id)->first();
                if ($suppliment) {
                    $suppliment->collection_id = $request->collection;
                    $suppliment->name = $request->name;
                    $suppliment->price = $request->price;
                    $suppliment->info = $request->info;
                    $suppliment->vendor_id = auth()->user()->id;
                    $suppliment->save();
                    return redirect()->route('vendor.all.suppliment')->with(['alert-type' => 'success', 'message' => 'Successfully create suppliment.']);
                } else {
                    return back()->with(['alert-type' => 'error', 'message' => 'Suppliment not found.']);
                }
            } else {

                $request->validate([
                    'collection' => 'required|exists:collections,id',
                    'name' => 'required',
                    'price' => 'required|numeric|min:1',
                    'info' => 'nullable|string',
                ]);
                $suppliment = new suppliment();
                $suppliment->collection_id = $request->collection;
                $suppliment->name = $request->name;
                $suppliment->price = $request->price;
                $suppliment->info = $request->info;
                $suppliment->vendor_id = auth()->user()->id;
                $suppliment->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully create suppliment.']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function statusSuppliment(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $suppliment = suppliment::find($request->id);
            if ($suppliment) {
                $suppliment->status = $request->status;
                $suppliment->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Status updated']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Not found']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first']);
        }
    }

    public function destroySuppliment(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $suppliment = suppliment::find($request->id);
            if ($suppliment) {
                $suppliment->delete();
                return response()->json(['status' => true, 'message' => 'Collection suppliment deleted']);
            } else {
                return response()->json(['status' => false, 'message' => 'Collection suppliment is not found!']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first']);
            // abort(403);
        }
    }
}
