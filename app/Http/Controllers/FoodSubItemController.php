<?php

namespace App\Http\Controllers;

use App\Models\CategoryVariant;
use App\Models\CollectionItem;
use App\Models\collections;
use App\Models\FoodSubItem;
use App\Models\type;
use Illuminate\Http\Request;

class FoodSubItemController extends Controller
{
    //
    public function index(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $edit_sub_item = '';
            if (isset($request->id) && $request->id != '') {
                $edit_sub_item = FoodSubItem::latest()->where('vendor_id', auth()->user()->id)->where('id', $request->id)->first();
            }
            $types = type::orWhere('vendor_id', auth()->user()->id)->orWhere('vendor_id', null)->orderBy('name', 'ASC')->get();
            $food_sub_items = FoodSubItem::latest()->where('vendor_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
            return view('vendor.collections.food-sub-items.add-food-sub-items', compact('food_sub_items', 'edit_sub_item', 'types'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'You are not logged in']);
        }
    }
    public function getFoodSubType(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $vendorId = auth()->user()->id;
            $type = $request->type;
            $categoryId = $request->category;
            $latestCollection = collections::where('vendor_id', $vendorId)
                ->where('category_id', $categoryId)
                ->where('type', $type)
                ->latest()
                ->first();
            $collectionItems = '';
            if ($latestCollection) {
                $collectionItems = CollectionItem::whereHas('sub_items', function ($query) use ($vendorId, $type) {
                    $query->where('vendor_id', $vendorId)
                        ->where('type', $type);
                })->where('collection_id',$latestCollection->id)->with('sub_items')->get();
                if($collectionItems){
                    foreach($collectionItems as $collectionItem){
                        $collectionItem->prices = (isset($collectionItem->prices) && $collectionItem->prices) ?json_decode($collectionItem->prices):[];
                    }
                }
            }
            // dd($collectionItems);
            $variant = '';
            if ($request->has('category')) {
                $variant = CategoryVariant::where('vendor_id', auth()->user()->id)->where('category_id', $request->category)->orderBy('id', 'ASC')->get();
            }
            $food_sub_items = FoodSubItem::where('vendor_id', auth()->user()->id)->where('type', $request->type)->orderBy('name', 'ASC')->get();
            return response()->json(['status' => true, 'message' => 'Successfully fetched!', 'data' => $food_sub_items, 'variant' => $variant, 'collectionItems' => $collectionItems]);
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first.']);
        }
    }

    public function saveInclude(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $request->validate([
                'names' => 'required|array',
                'names.*' => 'required|string',
                'prices' => 'required|array',
                'prices.*' => 'required|numeric|min:0',
                'infos' => 'nullable|array',
                'deposit_bottel' => 'nullable|array',
                'type' => 'required|string',
            ]);
            if (isset($request->names[0]) && $request->names[0] != '') {
                $prices = $request->prices;
                $infos = $request->infos;
                $deposit_bottels = $request->deposit_bottel;
                $type = $request->type;

                foreach ($request->names as $key => $value) {
                    $food_sub_item = new FoodSubItem();
                    $food_sub_item->vendor_id = auth()->user()->id;
                    $food_sub_item->name = $value;
                    $food_sub_item->price = isset($prices[$key]) ? $prices[$key] : '';
                    $food_sub_item->info = isset($infos[$key]) ? $infos[$key] : '';
                    $food_sub_item->deposit_bottel = isset($deposit_bottels[$key]) ? $deposit_bottels[$key] : '';
                    $food_sub_item->type = $type;
                    $food_sub_item->save();
                }
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully save your include.']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Please fill name, price']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function updateInclude(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $request->validate([
                'id' => 'required|exists:food_sub_items,id',
                'name' => 'required|string',
                'price' => 'required|numeric|min:0',
                'info' => 'nullable|string',
                'deposit_bottel' => 'nullable|string',
                'type' => 'required|string',
            ]);
            if (isset($request->name) && $request->name != '') {
                $food_sub_item = FoodSubItem::where('id', $request->id)->first();
                if ($food_sub_item) {
                    $food_sub_item->vendor_id = auth()->user()->id;
                    $food_sub_item->name = $request->name;
                    $food_sub_item->price = $request->price;
                    $food_sub_item->info = $request->info;
                    $food_sub_item->deposit_bottel = $request->deposit_bottel;
                    $food_sub_item->type = $request->type;
                    $food_sub_item->save();
                }
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully update include.']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Please fill name, price']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function statusInclude(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $collectionExtra = FoodSubItem::find($request->id);
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

    public function destroyInclude(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $collection_extra = FoodSubItem::find($request->id);
            if ($collection_extra) {
                $collection_extra->delete();
                return response()->json(['status' => true, 'message' => 'Include deleted']);
            } else {
                return response()->json(['status' => false, 'message' => 'Include is not found!']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first']);
            // abort(403);
        }
    }
}
