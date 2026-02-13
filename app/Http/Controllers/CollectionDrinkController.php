<?php

namespace App\Http\Controllers;

use App\Models\collection_drink;
use App\Models\collections;
use Illuminate\Http\Request;

class CollectionDrinkController extends Controller
{
    //
    public function index(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $edit_drink = '';
            if (isset($request->id) && $request->id != '') {
                $edit_drink = collection_drink::latest()->where('vendor_id', auth()->user()->id)->where('id', $request->id)->first();
            }

            $drinks = collection_drink::latest()->where('vendor_id', auth()->user()->id)->with('collection_data')->get();
            $collections = collections::latest()->where('vendor_id', auth()->user()->id)->get();
            return view('vendor.collections.drinks.index', compact('drinks', 'collections', 'edit_drink'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'You are not logged in']);
        }
    }

    public function saveCollectionDrink(Request $request)
    {
        if (isset(auth()->user()->id)) {
            if (isset($request->drink_id) && $request->drink_id != '') {
                $request->validate([
                    'drink_id' => 'required|exists:collection_drinks,id',
                    'collection' => 'required|exists:collections,id',
                    'name' => 'required',
                    'price' => 'required|numeric|min:1',
                    'type' => 'required',
                    'info' => 'nullable|string',
                ]);
                $collection_drink = collection_drink::where('id', $request->drink_id)->where('vendor_id', auth()->user()->id)->first();
                if ($collection_drink) {
                    $collection_drink->collection_id = $request->collection;
                    $collection_drink->name = $request->name;
                    $collection_drink->price = $request->price;
                    $collection_drink->info = $request->info;
                    $collection_drink->type = $request->type;
                    $collection_drink->vendor_id = auth()->user()->id;
                    $collection_drink->save();
                    return redirect()->route('vendor.all.drinks')->with(['alert-type' => 'success', 'message' => 'Successfully create drink.']);
                } else {
                    return back()->with(['alert-type' => 'error', 'message' => 'Drink not found.']);
                }
            } else {

                $request->validate([
                    'collection' => 'required|exists:collections,id',
                    'name' => 'required',
                    'price' => 'required|numeric|min:1',
                    'type' => 'required',
                    'info' => 'nullable|string',
                ]);
                $collection_drink = new collection_drink();
                $collection_drink->collection_id = $request->collection;
                $collection_drink->name = $request->name;
                $collection_drink->price = $request->price;
                $collection_drink->info = $request->info;
                $collection_drink->type = $request->type;
                $collection_drink->vendor_id = auth()->user()->id;
                $collection_drink->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully create drink.']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function statusCollectionDrink(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $collection_drink = collection_drink::find($request->id);
            if ($collection_drink) {
                $collection_drink->status = $request->status;
                $collection_drink->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Status updated']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Not found']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first']);
        }
    }

    public function destroyCollectionDrink(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $collection_drink = collection_drink::find($request->id);
            if ($collection_drink) {
                $collection_drink->delete();
                return response()->json(['status' => true, 'message' => 'Collection drink deleted']);
            } else {
                return response()->json(['status' => false, 'message' => 'Collection drink is not found!']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first']);
            // abort(403);
        }
    }
}
