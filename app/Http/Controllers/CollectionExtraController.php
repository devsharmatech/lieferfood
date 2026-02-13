<?php

namespace App\Http\Controllers;

use App\Models\collection_extra;
use App\Models\collections;
use Illuminate\Http\Request;


class CollectionExtraController extends Controller
{
    //
    public function index(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $edit_extra = '';
            if (isset($request->id) && $request->id != '') {
                $edit_extra = collection_extra::latest()->where('vendor_id', auth()->user()->id)->where('id', $request->id)->first();
            }

            $extras = collection_extra::latest()->where('vendor_id', auth()->user()->id)->with('collection_data')->get();
            $collections = collections::latest()->where('vendor_id', auth()->user()->id)->get();
            return view('vendor.collections.extras.index', compact('extras', 'collections', 'edit_extra'));
        } else {
            return back()->with(['alert-type' => false, 'message' => 'You are not logged in']);
        }
    }

    public function saveCollectionExtra(Request $request)
    {
        if (isset(auth()->user()->id)) {
            if (isset($request->extra_id) && $request->extra_id != '') {
                $request->validate([
                    'extra_id' => 'required|exists:collection_extras,id',
                    'collection' => 'required|exists:collections,id',
                    'name' => 'required',
                    'price' => 'required|numeric|min:1',
                    'info' => 'nullable|string',
                ]);
                $collectionExtra = collection_extra::where('id', $request->extra_id)->where('vendor_id', auth()->user()->id)->first();
                if ($collectionExtra) {
                    $collectionExtra->collection_id = $request->collection;
                    $collectionExtra->name = $request->name;
                    $collectionExtra->price = $request->price;
                    $collectionExtra->info = $request->info;
                    $collectionExtra->vendor_id = auth()->user()->id;
                    $collectionExtra->save();
                    return redirect()->route('vendor.all.collection-extras')->with(['alert-type' => 'success', 'message' => 'Successfully create extra.']);
                } else {
                    return back()->with(['alert-type' => 'error', 'message' => 'Extra not found.']);
                }
            } else {

                $request->validate([
                    'collection' => 'required|exists:collections,id',
                    'name' => 'required',
                    'price' => 'required|numeric|min:1',
                    'info' => 'nullable|string',
                ]);
                $collectionExtra = new collection_extra();
                $collectionExtra->collection_id = $request->collection;
                $collectionExtra->name = $request->name;
                $collectionExtra->price = $request->price;
                $collectionExtra->info = $request->info;
                $collectionExtra->vendor_id = auth()->user()->id;
                $collectionExtra->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully create extra.']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function statusCollectionExtra(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $collectionExtra = collection_extra::find($request->id);
            if ($collectionExtra) {
                $collectionExtra->status = $request->status;
                $collectionExtra->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Status updated']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Not found']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first']);
        }
    }

    public function destroyCollectionExtra(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $collection_extra = collection_extra::find($request->id);
            if ($collection_extra) {
                $collection_extra->delete();
                return response()->json(['status' => true, 'message' => 'Collection extra deleted']);
            } else {
                return response()->json(['status' => false, 'message' => 'Collection extra is not found!']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first']);
            // abort(403);
        }
    }
}
