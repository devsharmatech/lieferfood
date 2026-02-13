<?php

namespace App\Http\Controllers;

use App\Models\food_item;
use App\Models\GroupItems;
use App\Models\Groups;
use App\Models\MenuItemOptions;
use App\Models\MenuItemOptionValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class VendorMenuOptionController extends Controller
{
    //
    public function menuItemOptions()
    {
        $id = auth()->user()->id;
        $menu_items = food_item::where('vendor_id', $id)->get();
        $menu_item_options = MenuItemOptions::whereHas('food_item', function ($query) use ($id) {
            $query->where('vendor_id', $id);
        })->with('food_item')->get();

        return view('vendor.foods.menu-items-options', compact('menu_item_options', 'menu_items'));
    }
    public function editMenuOption($mid)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $menu_item_option = MenuItemOptions::whereHas('food_item', function ($query) use ($id) {
                $query->where('vendor_id', $id);
            })->where('id', $mid)->first();
            if (!empty($menu_item_option)) {
                $menu_items = food_item::where('vendor_id', $id)->get();
                $menu_option = MenuItemOptions::where('id', $mid)->first();
                $menu_item_options = MenuItemOptions::whereHas('food_item', function ($query) use ($id) {
                    $query->where('vendor_id', $id);
                })->get();
                return view('vendor.foods.menu-items-options', compact('menu_item_options', 'menu_items', 'menu_option'));
            } else {

                return back()->with(['alert-type' => 'error', 'message' => 'Menu item option not found.']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function addMenuItemOption(Request $request)
    {
        // $id=auth()->user()->id;
        if (isset($request->id) && $request->id != '') {

            $request->validate(
                [
                    'id' => ['required', 'exists:menu_item_options,id'],
                    'menu_item' => ['required', 'exists:food_items,id'],
                    'option_name' => ['required', 'string']
                ]
            );
            $menuItemOption = MenuItemOptions::where('id', $request->id)->first();
            $menuItemOption->menu_item_id = $request->menu_item;
            $menuItemOption->option_name = $request->option_name;
            $menuItemOption->save();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Menu Item Option updated Successfully']);
        } else {
            $request->validate(
                [
                    'menu_item' => ['required', 'exists:food_items,id'],
                    'option_name' => ['required', 'string']
                ]
            );
            $menuItemOption = new MenuItemOptions();
            $menuItemOption->menu_item_id = $request->menu_item;
            $menuItemOption->option_name = $request->option_name;
            $menuItemOption->save();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Menu Item Option Added Successfully']);
        }
    }

    public function deleteMenuOption($mid)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $menu_item_option = MenuItemOptions::whereHas('food_item', function ($query) use ($id) {
                $query->where('vendor_id', $id);
            })->where('id', $mid)->first();
            if (!empty($menu_item_option)) {
                $menu_option = MenuItemOptions::where('id', $mid)->first();
                $menu_option->delete();
                return back()->with(['alert-type' => 'success', 'message' => 'Menu item option deleted successfully']);
            } else {

                return back()->with(['alert-type' => 'error', 'message' => 'Menu item option not found.']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login']);
        }
    }

    // menu items options values
    public function menuItemOptionValues($mid)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $menu_item_option = MenuItemOptions::whereHas('food_item', function ($query) use ($id) {
                $query->where('vendor_id', $id);
            })->where('id', $mid)->first();
            if (!empty($menu_item_option)) {
                $menu_option_values = MenuItemOptionValues::where('menu_item_option_id', $mid)->get();

                return view('vendor.foods.menu_item_option_values', compact('menu_option_values', 'menu_item_option'));
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Menu item option not found.']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function addMenuOptionValues(Request $request)
    {
        // $id=auth()->user()->id;
        if (isset($request->id) && $request->id != '') {

            $request->validate(
                [
                    'id' => ['required', 'exists:menu_item_option_values,id'],
                    'mid' => ['required', 'exists:menu_item_options,id'],
                    'value' => ['required', 'string'],
                    'price' => ['required', 'numeric', 'min:0']
                ]
            );
            $menuItemOption = MenuItemOptionValues::where('id', $request->id)->first();
            $menuItemOption->menu_item_option_id = $request->mid;
            $menuItemOption->value = $request->value;
            $menuItemOption->price_adjustment = $request->price;
            $menuItemOption->save();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Menu Item Option value updated Successfully']);
        } else {
            $request->validate(
                [
                    'mid' => ['required', 'exists:menu_item_options,id'],
                    'value' => ['required', 'string'],
                    'price' => ['required', 'numeric', 'min:0']
                ]
            );
            $menuItemOption = new MenuItemOptionValues();
            $menuItemOption->menu_item_option_id = $request->mid;
            $menuItemOption->value = $request->value;
            $menuItemOption->price_adjustment = $request->price;
            $menuItemOption->save();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Menu Item Option Value Added Successfully']);
        }
    }
    public function editMenuOptionValues($mid, $value_id)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $menu_item_option = MenuItemOptions::whereHas('food_item', function ($query) use ($id) {
                $query->where('vendor_id', $id);
            })->where('id', $mid)->first();
            if (!empty($menu_item_option)) {
                $menu_option_values = MenuItemOptionValues::where('menu_item_option_id', $mid)->get();
                $menu_option_value = MenuItemOptionValues::where('menu_item_option_id', $mid)->where('id', $value_id)->first();
                if (!empty($menu_option_value)) {

                    return view('vendor.foods.menu_item_option_values', compact('menu_option_values', 'menu_item_option', 'menu_option_value'));
                } else {

                    return back()->with(['alert-type' => 'error', 'message' => 'Menu item option value not found.']);
                }
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Menu item option not found.']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function menuOptionValuesDelete($mid, $value_id)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $menu_item_option = MenuItemOptions::whereHas('food_item', function ($query) use ($id) {
                $query->where('vendor_id', $id);
            })->where('id', $mid)->first();
            if (!empty($menu_item_option)) {
                $menu_option_value = MenuItemOptionValues::where('menu_item_option_id', $mid)->where('id', $value_id)->first();
                if (!empty($menu_option_value)) {
                    $menu_option_value->delete();
                    return back()->with(['alert-type' => 'success', 'message' => 'Menu item option value deleted successfully']);
                } else {

                    return back()->with(['alert-type' => 'error', 'message' => 'Menu item option value not found.']);
                }
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Menu item option not found.']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }


    // group

    public function groupData()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $groups = Groups::where('vendor_id', $id)->get();
            return view('vendor.foods.group_menu_foods', compact('groups'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function groupDataStore(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            if (isset($request->id) && $request->id != '') {
                $request->validate([
                    'id' => 'required|exists:groups,id',
                    'name' => 'required',
                    'price' => 'required|numeric',
                    'image' => 'nullable|image',
                    'description' => 'required',
                ]);
                $group = Groups::where('id', $request->id)->first();
                $group->vendor_id = $id;
                $group->name = $request->name;
                $group->price = $request->price;
                $group->description = $request->description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $manager = new ImageManager(Driver::class);
                    $image = $manager->read($file);
                    $filename = uniqid('menu_') . '.' . $file->getClientOriginalExtension();
                    $image->resize(400, 400)->save(public_path('uploads/menu/' . $filename));
                    $oldPath = public_path('uploads/menu/' . $group->image);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                    $group->image = $filename;
                }
                $group->save();
            } else {
                $request->validate([
                    'name' => 'required',
                    'price' => 'required|numeric',
                    'image' => 'nullable|image',
                    'description' => 'required',
                ]);
                $group = new Groups();
                $group->vendor_id = $id;
                $group->name = $request->name;
                $group->price = $request->price;
                $group->description = $request->description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $manager = new ImageManager(Driver::class);
                    $oldPath = public_path('uploads/menu/' . $group->image);
                    $image = $manager->read($file);
                    $filename = uniqid('menu_') . '.' . $file->getClientOriginalExtension();
                    $image->resize(400, 400)->save(public_path('uploads/menu/' . $filename));
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                    $group->image = $filename;
                }
                $group->save();
            }

            return back()->with(['alert-type' => 'success', 'message' => 'Group created successfully.']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function deleteGroup($gid)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $group = Groups::where('vendor_id', $id)->where('id', $gid)->first();
            $oldPath = public_path('uploads/menu/' . $group->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $group->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Group deteled successfully']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function editGroup($gid)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $groups = Groups::where('vendor_id', $id)->get();
            $group = Groups::where('vendor_id', $id)->where('id', $gid)->first();
            return view('vendor.foods.group_menu_foods', compact('group', 'groups'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }


    // group items
    public function groupItems($gid)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $group = Groups::where('vendor_id', $id)->where('id', $gid)->first();
            if (isset($group) && !empty($group)) {
                $items = GroupItems::where('group_id', $gid)->with('food_item')->get();
                $food_items = food_item::where('vendor_id', $id)->get();

                return view('vendor.foods.group_items', compact('group', 'items', 'food_items'));
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Group not found']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function addGroupItems(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $request->validate([
                'gid' => ['required'],
                'food_items' => ['required', 'array'],
            ]);
            $group = Groups::where('vendor_id', $id)->where('id', $request->input('gid'))->first();
            if (isset($group) && !empty($group)) {
                foreach ($request->input('food_items') as $food_item_id) {
                    $group_item = new GroupItems();
                    $group_item->group_id = $request->input('gid');
                    $group_item->menu_item_id = $food_item_id;
                    $group_item->save();
                }
                return back()->with(['alert-type' => 'success', 'message' => 'Food Items Added in group.']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Group not found']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }

    public function groupItemDelete($group_item_id)
    {
        if (isset(auth()->user()->id)) {
            $group_item = GroupItems::where('id', $group_item_id)->first();
            if ($group_item) {
                $group_item->delete();
                return back()->with(['alert-type' => 'success', 'message' => 'Group item deleted successfully']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Group item not found']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
}
