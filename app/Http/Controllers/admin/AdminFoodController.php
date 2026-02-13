<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\collections;
use App\Models\Extra;
use App\Models\food_item;
use App\Models\foodVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class AdminFoodController extends Controller
{
    //
    public function  index()
    {
        $foods = food_item::latest()->with('category', 'vendor')->get();
        return view('admin.menu.food-items', compact('foods'));
    }
    public function create()
    {
        $categories = category::where('vendor_id', auth()->user()->id)->orderBy('name', 'ASC')->get();
        $collections = collections::where('vendor_id', auth()->user()->id)->where('status', 1)->orderBy('name', 'ASC')->get();
        return view('admin.menu.add-food-item', compact('categories', 'collections'));
    }
    public function store(Request $request)
    {

        $id = auth()->user()->id;
        $request->validate([
            'food_name' => 'required',
            'category' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'delivery_price' => 'required|min:0',
            'pickup_price' => 'required|min:0',
            'item_type' => 'required|string',
            'external_id' => 'nullable',
            'hasVariants' => 'nullable',
            'variant_names' => 'nullable|array',
            'variant_prices' => 'nullable|array',
            'variant_details' => 'nullable|array',
            'extra_names' => 'nullable|array',
            'extra_prices' => 'nullable|array',
            'extra_info' => 'nullable|array',
            'cereal' => 'nullable|array',
            'nuts' => 'nullable|array',
            'furthers' => 'nullable|array',
            'is_allergens_accept' => 'nullable',
            'confirm' => 'nullable',
            'collection' => 'nullable|exists:collections,id',
        ]);
        $food = new food_item();
        $food->food_item_name = $request->food_name;
        $food->category_id = $request->category;
        $food->vendor_id = $id;
        $food->description = $request->description;
        $food->is_available = 1;
        $food->delivery_price = $request->delivery_price;
        $food->pickup_price = $request->pickup_price;
        $food->item_type = $request->item_type;
        $food->external_id = $request->external_id;
        $food->hasVariants = $request->hasVariants;
        $food->collection = $request->collection;
        $food->save();
        if (isset($request->hasVariants) && $request->hasVariants == 'on') {
            if (isset($request->variant_names) && is_array($request->variant_names)) {
                $variant_prices = $request->variant_prices;
                $variant_details = $request->variant_details;
                foreach ($request->variant_names as $key => $variant_name) {
                    $food_variant = new foodVariant();
                    $food_variant->food_id = $food->id;
                    $food_variant->variant_name = $variant_name;
                    $food_variant->price = isset($variant_prices[$key]) ? $variant_prices[$key] : 0;
                    $food_variant->additional_details = isset($variant_details[$key]) ? $variant_details[$key] : "";
                    $food_variant->save();
                }
            }
        }
        if (isset($request->is_allergens_accept) && $request->is_allergens_accept == "on") {
            if (isset($request->confirm) && $request->confirm == "on") {
                $food->is_allergens_accept = 1;
                $food->cereal = json_encode($request->cereal);
                $food->nuts = json_encode($request->nuts);
                $food->furthers = json_encode($request->furthers);
            }
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $manager = new ImageManager(Driver::class);
            $oldPath = public_path('uploads/menu/' . $food->image);
            $image = $manager->read($file);
            $filename = uniqid('menu_') . '.' . $file->getClientOriginalExtension();
            $image->resize(400, 400)->save(public_path('uploads/menu/' . $filename));
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $food->image = $filename;
        }
        if (isset($request->extra_names)) {
            if (isset($request->extra_names) && is_array($request->extra_names)) {
                $extra_info = $request->extra_info;
                $extra_prices = $request->extra_prices;
                foreach ($request->extra_names as $key => $extra_name) {
                    $food_extra = new Extra();
                    $food_extra->food_id = $food->id;
                    $food_extra->extra_name = $extra_name;
                    $food_extra->extra_price = isset($extra_prices[$key]) ? $extra_prices[$key] : 0;
                    $food_extra->extra_info = isset($extra_info[$key]) ? $extra_info[$key] : "";
                    $food_extra->save();
                }
            }
        }
        $food->save();
        return redirect()->route('admin.food')->with(['alert-type' => 'success', 'message' => 'Successfully added new food.']);
    }
    public function edit($food_id)
    {
        $categories = category::orderBy('name', 'ASC')->get();
        $food = food_item::where('id', $food_id)->with('variants')->first();
        $collections = collections::where('status', 1)->orderBy('name', 'ASC')->get();
        if (!empty($food)) {
            return view('admin.menu.edit-food-items', compact('food', 'categories', 'collections'));
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Food not found!']);
        }
    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:food_items,id',
            'food_name' => 'required',
            'category' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'delivery_price' => 'required|min:0',
            'pickup_price' => 'required|min:0',
            'item_type' => 'required|string',
            'external_id' => 'nullable',
            'cereal' => 'nullable|array',
            'nuts' => 'nullable|array',
            'furthers' => 'nullable|array',
            'is_allergens_accept' => 'nullable',
            'confirm' => 'nullable',
            'collection' => 'nullable|exists:collections,id',
        ]);

        $food = food_item::where('id', $request->id)->first();
        if (!empty($food)) {
            $food->food_item_name = $request->food_name;
            $food->category_id = $request->category;
            $food->description = $request->description;
            $food->is_available = 1;
            $food->delivery_price = $request->delivery_price;
            $food->pickup_price = $request->pickup_price;
            $food->item_type = $request->item_type;
            $food->external_id = $request->external_id;
            $food->hasVariants = $request->hasVariants;
            $food->collection = $request->collection;
            $food->save();

            if (isset($request->is_allergens_accept) && $request->is_allergens_accept == "on") {
                if (isset($request->confirm) && $request->confirm == "on") {
                    $food->is_allergens_accept = 1;
                    $food->cereal = json_encode($request->cereal);
                    $food->nuts = json_encode($request->nuts);
                    $food->furthers = json_encode($request->furthers);
                }
            }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $manager = new ImageManager(Driver::class);
                $oldPath = public_path('uploads/menu/' . $food->image);
                $image = $manager->read($file);
                $filename = uniqid('menu_') . '.' . $file->getClientOriginalExtension();
                $image->resize(400, 400)->save(public_path('uploads/menu/' . $filename));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $food->image = $filename;
            }
            $food->save();
            return redirect()->route('admin.food')->with(['alert-type' => 'success', 'message' => 'Successfully update food.']);
        } else {

            return redirect()->route('admin.food')->with(['alert-type' => 'error', 'message' => 'Food not found!']);
        }
    }
    public function delete($food_id)
    {

        $food = food_item::where('id', $food_id)->first();

        if (!empty($food)) {
            $oldPath = public_path('uploads/category/' . $food->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $food->delete();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Food deleted successfully!']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Food not found!']);
        }
    }
    public function menuAvailable(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $menu = food_item::where('id', $request->id)->first();
            if ($menu) {
                $menu->is_available = $request->value;
                $menu->save();
                return response()->json(['success' => true, 'message' => 'Status Changed.']);
            } else {

                return response()->json(['success' => false, 'message' => 'menu not found.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Please login first.']);
        }
    }
}
