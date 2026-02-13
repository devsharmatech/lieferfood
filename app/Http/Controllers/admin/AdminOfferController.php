<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class AdminOfferController extends Controller
{
    //
    public function index(){
        $offers=offer::latest()->with('createdby')->get();
        return view('admin.offers.all-offers',compact('offers'));
    }

    public function addNew(){
        return view('admin.offers.add-new');
    }

    public function store(Request $request){
        $id=auth()->user()->id;
        $request->validate([
            'title' => ['required', 'string'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'discount_type' => ['required', 'in:fixed,percentage'],
            'discount' => ['required', 'numeric'],
            'upto_price' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image']
        ]);
        $offer = new offer();
        $offer->created_by = $id;
        $offer->title = $request->title;
        $offer->description = $request->description;
        $offer->offer_type = $request->discount_type;
        $offer->discount_value = $request->discount;
        $offer->start_date = $request->start_date;
        $offer->end_date = $request->end_date;
        $offer->creator_role = "admin";
        $offer->upto = $request->upto_price;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $manager = new ImageManager(Driver::class);
            $oldPath = public_path('uploads/offer/' . $offer->image);
            $image = $manager->read($file);
            $filename = uniqid('offer_') . '.' . $file->getClientOriginalExtension();
            $image->resize(1000, 400)->save(public_path('uploads/offer/' . $filename));
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $offer->image = $filename;
        }
        $offer->save();
        return redirect()->route('admin.offer')->with(['alert-type' => 'success', 'message' => 'Offer added Successfully']);
    }

    public function edit($oid)
    {
        $offer = offer::latest()->where('id', $oid)->first();
        if (!empty($offer)) {
            return view('admin.offers.edit-offer', compact('offer'));
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Offer not found!']);
        }
    }
    public function update(Request $request)
    {
        
        $request->validate([
            'id' => ['required', 'exists:offers,id'],
            'title' => ['required', 'string'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'discount_type' => ['required', 'in:fixed,percentage'],
            'discount' => ['required', 'numeric'],
            'upto_price' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image']
        ]);
        $offer = offer::where('id', $request->id)->first();
        if (!empty($offer)) {

            $offer->title = $request->title;
            $offer->description = $request->description;
            $offer->offer_type = $request->discount_type;
            $offer->discount_value = $request->discount;
            $offer->start_date = $request->start_date;
            $offer->end_date = $request->end_date;
            $offer->creator_role = "vendor";
            $offer->upto = $request->upto_price;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $manager = new ImageManager(Driver::class);
                $oldPath = public_path('uploads/offer/' . $offer->image);
                $image = $manager->read($file);
                $filename = uniqid('offer_') . '.' . $file->getClientOriginalExtension();
                $image->resize(1000, 400)->save(public_path('uploads/offer/' . $filename));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $offer->image = $filename;
            }
            $offer->save();
            return redirect()->route('admin.offer')->with(['alert-type' => 'success', 'message' => 'Offer updated Successfully']);
        } else {
            return redirect()->route('admin.offer')->with(['alert-type' => 'error', 'message' => 'Offer not found!']);
        }
    }

    public function delete($oid)
    {
        
        $offer = offer::where('id', $oid)->first();

        if (!empty($offer)) {
            $oldPath = public_path('uploads/offer/' . $offer->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $offer->delete();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Offer deleted successfully!']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Offer not found!']);
        }
    }
}
