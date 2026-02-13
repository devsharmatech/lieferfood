<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\CategoryVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = category::latest()->where('vendor_id',auth()->user()->id)->get();
        return view('admin.category.food-category', compact('categories'));
    }
    public function addNew()
    {

        return view('admin.category.create-new');
    }
    public function store(Request $request)
    {
        // i need to change text into slug and than set in $request->slug
        if (isset($request->slug) && !empty($request->slug)) {

            $request['slug'] = Str::slug($request->slug);
        }
        $request->validate([
            'name' => ['required'],
            'order' => ['nullable', 'numeric'],
            'slug' => ['required', 'unique:categories,slug'],
            'image' => ['required', 'image'],
            'mobile_image' => ['required', 'image'],
            'discount' => ['nullable'],
            'status' => ['nullable'],
            'description' => ['nullable', 'string']
        ]);

        $category = new category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->sort = $request->order;
        $category->discount = $request->discount == "on" ? 1 : 0;
        $category->status = $request->status == "on" ? 1 : 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $manager = new ImageManager(Driver::class);
            $oldPath = public_path('uploads/category/' . $category->image);
            $image = $manager->read($file);
            $filename = uniqid('category_') . '.' . $file->getClientOriginalExtension();
            $image->resize(1400, 300)->save(public_path('uploads/category/' . $filename));
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $category->image = $filename;
        }
        if ($request->hasFile('mobile_image')) {
            $file_2 = $request->file('mobile_image');
            $manager = new ImageManager(Driver::class);
            $oldPath = public_path('uploads/category/mobile/' . $category->mobile_image);
            $image = $manager->read($file_2);
            $filename = uniqid('category_mobile_') . '.' . $file_2->getClientOriginalExtension();
            $image->resize(400, 400)->save(public_path('uploads/category/mobile/' . $filename));
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $category->mobile_image = $filename;
        }
        $category->description = $request->description;
        $category->save();
        return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Category Added Successfully']);
    }
    public function remove($id)
    {
        $category = category::where('id', $id)->first();
        if (!empty($category)) {
            $oldPath = public_path('uploads/category/' . $category->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $oldPath2 = public_path('uploads/category/mobile/' . $category->mobile_image);
            if (File::exists($oldPath2)) {
                File::delete($oldPath2);
            }
            $category->delete();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Food category deleted successfully']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Food Category not found']);
        }
    }
    public function edit($id)
    {
        $category = category::where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request)
    {
        // i need to change text into slug and than set in $request->slug
        if (isset($request->slug) && !empty($request->slug)) {

            $request['slug'] = Str::slug($request->slug);
        }
        $request->validate([
            'id' => ['required', 'exists:categories,id'],
            'name' => ['required'],
            'order' => ['nullable', 'numeric'],
            'slug' => ['required', 'unique:categories,slug,' . $request->id],
            'image' => ['nullable', 'image'],
            'mobile_image' => ['nullable', 'image'],
            'discount' => ['nullable'],
            'status' => ['nullable'],
            'description' => ['nullable', 'string']
        ]);

        $category = category::where('id', $request->id)->first();
        if (!empty($category)) {

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->sort = $request->order;
            $category->discount = $request->discount == "on" ? 1 : 0;
            $category->status = $request->status == "on" ? 1 : 0;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $manager = new ImageManager(Driver::class);
                $oldPath = public_path('uploads/category/' . $category->image);
                $image = $manager->read($file);
                $filename = uniqid('category_') . '.' . $file->getClientOriginalExtension();
                $image->resize(1400, 300)->save(public_path('uploads/category/' . $filename));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $category->image = $filename;
            }
            if ($request->hasFile('mobile_image')) {
                $file_2 = $request->file('mobile_image');
                $manager = new ImageManager(Driver::class);
                $oldPath = public_path('uploads/category/mobile/' . $category->mobile_image);
                $image = $manager->read($file_2);
                $filename = uniqid('category_mobile_') . '.' . $file_2->getClientOriginalExtension();
                $image->resize(400, 400)->save(public_path('uploads/category/mobile/' . $filename));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $category->mobile_image = $filename;
            }

            $category->description = $request->description;
            $category->save();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Category Updated Successfully']);
        } else {
            return redirect()->back()->with(['alert-type' => 'warning', 'message' => 'Category not found.']);
        }
    }

    public function updateCategory(Request $request)
    {
        $category = Category::find($request->id);

        if ($category) {
            $field = $request->field;
            $category->$field = $request->value; // Dynamically update 'status' or 'discount'
            $category->save();
            return response()->json(['success' => true, 'message' => 'Category updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Category not found']);
    }

    public function allCategory()
    {
        if (isset(auth()->user()->id)) {
            $categories = Category::where('vendor_id', auth()->user()->id)->orderBy('sort', 'ASC')->get();
            return view('vendor.category.vendor_category', compact('categories'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function addCategory()
    {
        return view('vendor.category.vendor_create_category');
    }
    public function storeCategory(Request $request)
    {
        if (isset(auth()->user()->id)) {
            if (isset($request->slug) && !empty($request->slug)) {
                $request['slug'] = Str::slug($request->slug);
            }
            $request->validate([
                'name' => ['required'],
                'order' => ['nullable', 'numeric'],
                'slug' => ['required', 'unique:categories,slug'],
                'variants_name' => ['nullable', 'array'],
                'variants_info' => ['nullable', 'array'],
                'image' => ['required', 'image'],
                'mobile_image' => ['required', 'image'],
                'discount' => ['nullable'],
                'status' => ['nullable'],
                'description' => ['nullable', 'string', 'min:10']
            ]);

            $category = new category();
            $category->name = $request->name;
            $category->vendor_id = auth()->user()->id;
            $category->slug = $request->slug;
            $category->sort = $request->order;
            $category->discount = $request->discount == "on" ? 1 : 0;
            $category->status = $request->status == "on" ? 1 : 0;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $manager = new ImageManager(Driver::class);
                $oldPath = public_path('uploads/category/' . $category->image);
                $image = $manager->read($file);
                $filename = uniqid('category_') . '.' . $file->getClientOriginalExtension();
                $image->resize(1400, 300)->save(public_path('uploads/category/' . $filename));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $category->image = $filename;
            }
            if ($request->hasFile('mobile_image')) {
                $file_2 = $request->file('mobile_image');
                $manager = new ImageManager(Driver::class);
                $oldPath = public_path('uploads/category/mobile/' . $category->mobile_image);
                $image = $manager->read($file_2);
                $filename = uniqid('category_mobile_') . '.' . $file_2->getClientOriginalExtension();
                $image->resize(400, 400)->save(public_path('uploads/category/mobile/' . $filename));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $category->mobile_image = $filename;
            }
            $category->description = $request->description;
            $category->save();

            if (isset($request->variants_name) && $request->variants_name != '') {
                $variants_info = $request->variants_info;
                foreach ($request->variants_name as $key => $variant_name) {
                    if($variant_name!=null && $variant_name!=''){

                        $variant = new CategoryVariant();
                        $variant->name = $variant_name;
                        $variant->vendor_id = auth()->user()->id;
                        $variant->category_id = $category->id;
                        $variant->other_info = isset($variants_info[$key]) ? $variants_info[$key] : '';
                        $variant->save();
                    }
                }
            }

            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Category Added Successfully']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Please login first']);
        }
    }
    public function editCategory($id)
    {
        if (isset(auth()->user()->id)) {
            $category = category::where('id', $id)->where('vendor_id', auth()->user()->id)->with('category_variants')->first();
            if (isset($category)) {
                return view('vendor.category.vendor_edit_category', compact('category'));
            } else {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Category Not Found']);
            }
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Please login first']);
        }
    }

    public function updateVendorCategory(Request $request)
    {
        if (isset(auth()->user()->id)) {
            // i need to change text into slug and than set in $request->slug
            if (isset($request->slug) && !empty($request->slug)) {

                $request['slug'] = Str::slug($request->slug);
            }
            $request->validate([
                'id' => ['required', 'exists:categories,id'],
                'name' => ['required'],
                'order' => ['nullable', 'numeric'],
                'slug' => ['required', 'unique:categories,slug,' . $request->id],
                'image' => ['nullable', 'image'],
                'mobile_image' => ['nullable', 'image'],
                'discount' => ['nullable'],
                'status' => ['nullable'],
                'description' => ['nullable', 'string']

            ]);
            DB::beginTransaction();
            try {
                $category = category::where('id', $request->id)->where('vendor_id', auth()->user()->id)->first();

                if (!empty($category)) {

                    $category->name = $request->name;
                    $category->slug = $request->slug;
                    $category->sort = $request->order;
                    $category->discount = $request->discount == "on" ? 1 : 0;
                    $category->status = $request->status == "on" ? 1 : 0;
                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        $manager = new ImageManager(Driver::class);
                        $oldPath = public_path('uploads/category/' . $category->image);
                        $image = $manager->read($file);
                        $filename = uniqid('category_') . '.' . $file->getClientOriginalExtension();
                        $image->resize(1400, 300)->save(public_path('uploads/category/' . $filename));
                        if (File::exists($oldPath)) {
                            File::delete($oldPath);
                        }
                        $category->image = $filename;
                    }
                    if ($request->hasFile('mobile_image')) {
                        $file_2 = $request->file('mobile_image');
                        $manager = new ImageManager(Driver::class);
                        $oldPath = public_path('uploads/category/mobile/' . $category->mobile_image);
                        $image = $manager->read($file_2);
                        $filename = uniqid('category_mobile_') . '.' . $file_2->getClientOriginalExtension();
                        $image->resize(400, 400)->save(public_path('uploads/category/mobile/' . $filename));
                        if (File::exists($oldPath)) {
                            File::delete($oldPath);
                        }
                        $category->mobile_image = $filename;
                    }

                    $category->description = $request->description;
                    $category->save();

                    if ($request->has('variants_name')) {
                        foreach ($request->variants_name as $index => $variantName) {
                            if($variantName!=null && $variantName!=''){

                                $variantId = $request->variants_ids[$index] ?? null;
                                if ($variantId) {
                                    $variant = CategoryVariant::find($variantId);
                                    if ($variant) {
                                        $variant->name = $variantName;
                                        $variant->other_info = isset($request->variants_info[$index]) ? $request->variants_info[$index] : '';
                                        $variant->save();
                                    }
                                } else {
                                    $variant = new CategoryVariant();
                                    $variant->name = $variantName;
                                    $variant->vendor_id = auth()->user()->id;
                                    $variant->category_id = $category->id;
                                    $variant->other_info = isset($request->variants_info[$index]) ? $request->variants_info[$index] : '';
                                    $variant->save();
                                }
                            }
                        }
                    }

                    DB::commit();
                    return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Category Updated Successfully']);
                } else {
                    return redirect()->back()->with(['alert-type' => 'warning', 'message' => 'Category not found.']);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with(['alert-type'=>'error', 'message'=>'An error occurred while updating the category and variants.']);
            }
        } else {
            return redirect()->back()->with(['alert-type' => 'warning', 'message' => 'Please login first.']);
        }
    }

    public function deleteThis($id)
    {
        if (isset(auth()->user()->id)) {
            $category = category::where('id', $id)->where('vendor_id', auth()->user()->id)->first();
            if (!empty($category)) {
                $oldPath = public_path('uploads/category/' . $category->image);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $oldPath2 = public_path('uploads/category/mobile/' . $category->mobile_image);
                if (File::exists($oldPath2)) {
                    File::delete($oldPath2);
                }
                $category->delete();
                return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Food category deleted successfully']);
            } else {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Food Category not found']);
            }
        } else {
            return redirect()->back()->with(['alert-type' => 'warning', 'message' => 'Please login first.']);
        }
    }
    public function deleteCategoryVariant(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $category = CategoryVariant::where('id', $request->id)->where('vendor_id', auth()->user()->id)->first();
            if (!empty($category)) {
                $category->delete();
                return response()->json(['status' => true, 'message' => 'Food category variant deleted successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Food Category variant not found']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first.']);
        }
    }
    public function updateSortOrder(Request $request)
    {

        $order = $request->order;
        foreach ($order as $item) {
            $category = category::where('id', $item['id'])->first();
            if ($category) {
                $category->sort = $item['position'];
            }
            $category->save();
        }

        return response()->json(['success' => true]);
    }
}
