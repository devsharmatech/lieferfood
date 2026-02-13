<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\CollectionItem;
use App\Models\collections;
use App\Models\FoodSubItem;
use App\Models\type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectionsController extends Controller
{
    //
    public function index()
    {
        if (isset(auth()->user()->id)) {
            $types = type::orWhere('vendor_id', auth()->user()->id)->orWhere('vendor_id', null)->orderBy('name', 'ASC')->get();
            // dd($types);
            $categories = category::where('vendor_id', auth()->user()->id)->where('status', 1)->orderBy('name', 'ASC')->get();
            $collections = collections::where('vendor_id', auth()->user()->id)->with('category')->orderBy('sort', 'ASC')->get();
            return view('vendor.collections.create-collection', compact('collections', 'categories', 'types'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    // public function createUpdateCollection(Request $request)
    // {
    //     // dd($request->all());
    //     if (isset(auth()->user()->id)) {
    //         $request->validate([
    //             'name' => 'required',
    //             'description' => 'nullable|string',
    //             'type' => 'required|string',
    //             'select_type' => 'required|numeric',
    //             'sort' => 'nullable|numeric',
    //             'category' => 'required|exists:categories,id',
    //             'item' => 'nullable|array',
    //             'prices' => 'nullable|array',
    //         ]);
    //         $prices = $request->prices ?? [];
    //         $item = $request->item;
    //         if (isset($request->id) && !empty($request->id)) {
    //             $collection = collections::where('vendor_id', auth()->user()->id)->where('id', $request->id)->first();
    //             $collection->name = $request->name;
    //             $collection->description = $request->description;
    //             $collection->type = $request->type;
    //             $collection->category_id = $request->category;
    //             $collection->isMultiple = $request->select_type;
    //             $collection->sort = $request->sort;

    //             $collection->save();

    //             $filteredPrices = array_filter($prices, function ($key) use ($item) {
    //                 return isset($item[$key]);
    //             }, ARRAY_FILTER_USE_KEY);
    //             // Fetch all current prices related to this collection
    //             $existingItemIds = CollectionItem::where('collection_id', $collection->id)->pluck('item_id')
    //                 ->toArray();;
    //             $incomingItemIds = array_keys($filteredPrices);
    //             $itemsToDelete = array_diff($existingItemIds, $incomingItemIds);
    //             $itemsToAdd = array_diff($incomingItemIds, $existingItemIds);
    //             $processedPrices = [];
    //             dd($filteredPrices);
    //             if (is_array($filteredPrices)) {
    //                 foreach ($filteredPrices as $key => $itemCollection) {
    //                     $collectionItem = CollectionItem::where('collection_id', $collection->id)->where('item_id', $key)->first();
    //                     $defaultPrice = 0;

    //                     if (!$collectionItem) {
    //                         $defaultPrice = FoodSubItem::where('id', $key)->value('price');
    //                     }
    //                     if (isset($collectionItem)) {
    //                         $collectionItem->collection_id = $collection->id;
    //                         $collectionItem->item_id = $key;
    //                         $collectionItem->prices = json_encode($itemCollection);
    //                         $collectionItem->item_id = $defaultPrice;
    //                         $collectionItem->save();
    //                     } else {
    //                         $coll_item = new CollectionItem();
    //                         $coll_item->collection_id = $collection->id;
    //                         $coll_item->item_id = $key;
    //                         $coll_item->dprice = $defaultPrice;
    //                         $coll_item->prices = json_encode($itemCollection) ?? null;
    //                         $coll_item->save();
    //                     }
    //                 }
    //             }
    //             if (!empty($itemsToDelete)) {
    //                 CollectionItem::where('collection_id', $collection->id)
    //                     ->whereIn('item_id', $itemsToDelete)
    //                     ->delete();
    //             }
    //         } else {
    //             // check duplicate collection not exist for same vendor
    //             $collection = collections::where('vendor_id', auth()->user()->id)->where('name', $request->name)->first();
    //             if (!empty($collection)) {
    //                 return back()->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Collection already exist with same name.']);
    //             } else {
    //                 $collection = new collections();
    //                 $collection->vendor_id = auth()->user()->id;
    //                 $collection->name = $request->name;
    //                 $collection->description = $request->description;
    //                 $collection->type = $request->type;
    //                 $collection->category_id = $request->category;
    //                 $collection->isMultiple = $request->select_type;
    //                 $collection->sort = $request->sort;
    //                 $collection->save();

    //                 $filteredPrices = array_filter($prices, function ($key) use ($item) {
    //                     return isset($item[$key]);
    //                 }, ARRAY_FILTER_USE_KEY);
    //                 dd($filteredPrices);
    //                 if (is_array($filteredPrices)) {
    //                     foreach ($filteredPrices as $key => $itemCollection) {
    //                         $defaultPrice = 0;
    //                         $defaultPrice = FoodSubItem::where('id', $key)->value('price');
    //                         $coll_item = new CollectionItem();
    //                         $coll_item->collection_id = $collection->id;
    //                         $coll_item->item_id = $key;
    //                         $coll_item->prices = json_encode($itemCollection) ?? null;
    //                         $coll_item->dprice = $defaultPrice;
    //                         $coll_item->save();
    //                     }
    //                 }
    //             }
    //         }
    //         return back()->with(['alert-type' => 'success', 'message' => 'Collection created successfully.']);
    //     } else {
    //         return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
    //     }
    // }
    public function createUpdateCollection(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $request->validate([
                'name' => 'required',
                'description' => 'nullable|string',
                'type' => 'required|string',
                'select_type' => 'required|numeric',
                'is_alcohal' => 'required|in:0,1',
                'sort' => 'nullable|numeric',
                'deposit' => 'nullable|numeric',
                'category' => 'required|exists:categories,id',
                'item' => 'nullable|array',
                'prices' => 'nullable|array',
            ]);
    
            $prices = $request->prices ?? [];
            $item = $request->item;
    
            if (isset($request->id) && !empty($request->id)) {
                $collection = collections::where('vendor_id', auth()->user()->id)->where('id', $request->id)->first();
                $collection->name = $request->name;
                $collection->description = $request->description;
                $collection->type = $request->type;
                $collection->category_id = $request->category;
                $collection->isMultiple = $request->select_type;
                $collection->isAlcohal = $request->is_alcohal;
                $collection->sort = $request->sort;
                $collection->return_price = $request->deposit;
                $collection->save();
    
                $filteredPrices = array_filter($prices, function ($key) use ($item) {
                    return isset($item[$key]);
                }, ARRAY_FILTER_USE_KEY);
    
                
                if (empty($filteredPrices)) {
                    foreach ($item as $key) {
                        $defaultPrice = FoodSubItem::where('id', $key)->value('price') ?? 0;
    
                        $collectionItem = CollectionItem::where('collection_id', $collection->id)->where('item_id', $key)->first();
                        if ($collectionItem) {
                            $collectionItem->dprice = $defaultPrice;
                            $collectionItem->prices = json_encode([]);  
                            $collectionItem->save();
                        } else {
                            $coll_item = new CollectionItem();
                            $coll_item->collection_id = $collection->id;
                            $coll_item->item_id = $key;
                            $coll_item->dprice = $defaultPrice;
                            $coll_item->prices = json_encode([]); 
                            $coll_item->save();
                        }
                    }
                } else {
                    foreach ($filteredPrices as $key => $itemCollection) {
                        $collectionItem = CollectionItem::where('collection_id', $collection->id)->where('item_id', $key)->first();
                        $defaultPrice = $collectionItem ? $collectionItem->dprice : FoodSubItem::where('id', $key)->value('price') ?? 0;
    
                        if ($collectionItem) {
                            $collectionItem->dprice = $defaultPrice;
                            $collectionItem->prices = json_encode($itemCollection);
                            $collectionItem->save();
                        } else {
                            $coll_item = new CollectionItem();
                            $coll_item->collection_id = $collection->id;
                            $coll_item->item_id = $key;
                            $coll_item->dprice = $defaultPrice;
                            $coll_item->prices = json_encode($itemCollection);
                            $coll_item->save();
                        }
                    }
                }
            } else {
                // If creating a new collection
                $collection = collections::where('vendor_id', auth()->user()->id)->where('name', $request->name)->first();
                if ($collection) {
                    return back()->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Collection already exists with the same name.']);
                } else {
                    $collection = new collections();
                    $collection->vendor_id = auth()->user()->id;
                    $collection->name = $request->name;
                    $collection->description = $request->description;
                    $collection->type = $request->type;
                    $collection->category_id = $request->category;
                    $collection->isMultiple = $request->select_type;
                    $collection->isAlcohal = $request->is_alcohal;
                    $collection->sort = $request->sort;
                     $collection->return_price = $request->deposit;
                    $collection->save();
    
                    $filteredPrices = array_filter($prices, function ($key) use ($item) {
                        return isset($item[$key]);
                    }, ARRAY_FILTER_USE_KEY);
    
                    
                    if (empty($filteredPrices)) {
                        foreach ($item as $key) {
                            $defaultPrice = FoodSubItem::where('id', $key)->value('price') ?? 0;
    
                            $coll_item = new CollectionItem();
                            $coll_item->collection_id = $collection->id;
                            $coll_item->item_id = $key;
                            $coll_item->dprice = $defaultPrice;
                            $coll_item->prices = json_encode([]);  
                            $coll_item->save();
                        }
                    } else {
                       
                        foreach ($filteredPrices as $key => $itemCollection) {
                            $defaultPrice = FoodSubItem::where('id', $key)->value('price') ?? 0;
    
                            $coll_item = new CollectionItem();
                            $coll_item->collection_id = $collection->id;
                            $coll_item->item_id = $key;
                            $coll_item->dprice = $defaultPrice;
                            $coll_item->prices = json_encode($itemCollection);
                            $coll_item->save();
                        }
                    }
                }
            }
            return back()->with(['alert-type' => 'success', 'message' => 'Collection created successfully.']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    
    public function deleteCollection($id)
    {
        if (isset(auth()->user()->id)) {
            $collection = collections::where('vendor_id', auth()->user()->id)->where('id', $id)->first();
            $collection->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Collection deleted successfully.']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function editCollection($id)
    {
        if (isset(auth()->user()->id)) {
            $categories = category::where('vendor_id', auth()->user()->id)->where('status', 1)->orderBy('name', 'ASC')->get();
            $collection = collections::where('vendor_id', auth()->user()->id)->where('id', $id)->with('collection_items')->first();
            $collection_category = category::where('id', $collection->category_id)->with('category_variants')->first();
            $collection_items = '';
            $types = type::orWhere('vendor_id', auth()->user()->id)->orWhere('vendor_id', null)->orderBy('name', 'ASC')->get();
            $food_sub_items = FoodSubItem::where('vendor_id', auth()->user()->id)->where('type', $collection->type)->where('status', 1)->orderBy('name', 'ASC')->get();
            if ($collection) {
                $collection_items = CollectionItem::where('collection_id', $collection->id)->get();
            }
            return view('vendor.collections.edit-collection', compact('collection', 'food_sub_items', 'categories', 'collection_items', 'collection_category','types'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    // types
    public function typeIndex($id = "")
    {
        if (isset(auth()->user()->id)) {
            $typeData = '';
            if ($id != '') {
                $typeData = type::where('vendor_id', auth()->user()->id)->where('id', $id)->first();
            }
            $types = type::latest()->where('vendor_id', auth()->user()->id)->get();
            return view('vendor.collections.types', compact('types', 'typeData'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function updateType(Request $request)
    {
        if (isset(auth()->user()->id)) {
            if ($request->has('value')) {
                $value = $request->input('value');
                $valueSlug = Str::slug($value);
                $request->value = $valueSlug;
            }
            $request->validate([
                'id' => 'nullable',
                'name' => 'required|string',
                'value' => 'required|string',
            ]);
            // check same slug is added in types
            if ($request->has('id') && $request->id != '') {
                $type = type::where('vendor_id', auth()->user()->id)->where('id', $request->id)->first();
                if ($type) {
                    $type->name = $request->name;
                    $type->value = $valueSlug;
                    $type->save();
                }
                return redirect()->route('vendor.all.types')->with(['alert-type' => 'success', 'message' => 'Successfully added!']);
            } else {
                $type = new Type;
                $type->name = $request->name;
                $type->vendor_id = auth()->user()->id;
                $type->value = $valueSlug;
                $type->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully added!']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function deleteType($id)
    {
        if (isset(auth()->user()->id)) {
            $type = type::where('vendor_id', auth()->user()->id)->where('id', $id)->first();
            $type->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Type deleted successfully.']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    // for admin
    public function adminIndex()
    {
        if (isset(auth()->user()->id)) {
            $collections = collections::latest()->where('vendor_id', auth()->user()->id)->get();
            return view('admin.menu.collections', compact('collections'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }



    public function adminCreateUpdateCollection(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $request->validate([
                'name' => 'required',
                'description' => 'nullable|string',
            ]);
            if (isset($request->id) && !empty($request->id)) {
                $collection = collections::where('vendor_id', auth()->user()->id)->where('id', $request->id)->first();
                $collection->name = $request->name;
                $collection->description = $request->description;
                $collection->save();
            } else {
                // check duplicate collection not exist for same vendor
                $collection = collections::where('vendor_id', auth()->user()->id)->where('name', $request->name)->first();
                if (!empty($collection)) {
                    return back()->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Collection already exist with same name.']);
                } else {
                    $collection = new collections();
                    $collection->vendor_id = auth()->user()->id;
                    $collection->name = $request->name;
                    $collection->description = $request->description;
                    $collection->save();
                }
            }
            return back()->with(['alert-type' => 'success', 'message' => 'Collection created successfully.']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function adminDeleteCollection($id)
    {
        if (isset(auth()->user()->id)) {
            $collection = collections::where('vendor_id', auth()->user()->id)->where('id', $id)->first();
            $collection->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Collection deleted successfully.']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function adminEditCollection($id)
    {
        if (isset(auth()->user()->id)) {
            $collections = collections::latest()->where('vendor_id', auth()->user()->id)->get();
            $collection = collections::where('vendor_id', auth()->user()->id)->where('id', $id)->first();
            return view('admin.menu.collections', compact('collection', 'collections'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
}
