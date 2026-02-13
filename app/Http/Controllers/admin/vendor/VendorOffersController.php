<?php

namespace App\Http\Controllers\admin\vendor;

use App\Http\Controllers\Controller;
use App\Models\offer;
use App\Models\OfferTimeSlot;
use App\Models\category;
use App\Models\food_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class VendorOffersController extends Controller
{
    //
    public function index()
    {
        $id = auth()->user()->id;
        $offers = offer::latest()->with('category','food')->where('created_by', $id)->get();
         
        return view('vendor.offers.all-offers', compact('offers'));
    }

    public function addNew()
    {
        $categories = category::orderBy('sort', 'ASC')->get();
        $foods=food_item::where('vendor_id',auth()->user()->id)->where('is_available',1)->orderBy('sort','ASC')->get();
        return view('vendor.offers.add-new',compact('categories','foods'));
    }

    public function store(Request $request)
    {
        $id = auth()->user()->id;
        $request->validate([
            'title' => ['required', 'string'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'start_times' => ['required','array'],
            'start_times.*' => ['required','date_format:H:i'],
            'end_times' => ['required','array'],
            'end_times.*' => ['required','date_format:H:i', 'after:start_time'],
            'offer_on' => ['required', 'in:restaurant,category,food'],
            'categories' => ['nullable','required_if:offer_on,category','array'],
            'foods' => ['nullable','required_if:offer_on,food','array'],
            'discount_type' => ['required', 'in:fixed,percentage'],
            'discount' => ['required', 'numeric'],
            'upto_price' => ['required', 'numeric'],
        ]);
        $endTimes=$request->end_times ?? [];
        if($request->offer_on=="restaurant"){
        
           $offer = new offer(); 
           $offer->created_by = $id;
           $offer->title = $request->title;
           $offer->whichType = $request->offer_on;
           $offer->category_id =null;
           $offer->offer_type = $request->discount_type;
           $offer->discount_value = $request->discount;
           $offer->start_date = $request->start_date;
           $offer->end_date = $request->end_date;
           $offer->creator_role = "vendor";
           $offer->upto = $request->upto_price;
           $offer->save();
           
           foreach ($request->start_times ?? [] as $key=>$stime){
               $slotTime=new OfferTimeSlot();
               $slotTime->offer_id=$offer->id;
               $slotTime->start_time=$stime ?? '00:01:01';
               $slotTime->end_time=$endTimes[$key] ?? '23:59:59';
               $slotTime->save();
           }
           return redirect()->route('vendor.offer')->with(['alert-type' => 'success', 'message' => 'Offer added Successfully']); 
        
        }elseif($request->offer_on=="category"){
          foreach ($request->categories ?? [] as $category){
           $offer = new offer(); 
           $offer->created_by = $id;
           $offer->title = $request->title;
           $offer->whichType = $request->offer_on;
           $offer->category_id = $category;
           $offer->offer_type = $request->discount_type;
           $offer->discount_value = $request->discount;
           $offer->start_date = $request->start_date;
           $offer->end_date = $request->end_date;
           $offer->creator_role = "vendor";
           $offer->upto = $request->upto_price;
           $offer->save();
          foreach ($request->start_times ?? [] as $key=>$stime){
            $slotTime=new OfferTimeSlot();
            $slotTime->offer_id=$offer->id;
            $slotTime->start_time=$stime ?? '00:01:01';
            $slotTime->end_time=$endTimes[$key] ?? '23:59:59';
            $slotTime->save();
          }
              
         }
          return redirect()->route('vendor.offer')->with(['alert-type' => 'success', 'message' => 'Offer added Successfully']);
        
        }else{
          foreach ($request->foods ?? [] as $food){
            $offer = new offer(); 
            $offer->created_by = $id;
            $offer->title = $request->title;
            $offer->whichType = $request->offer_on;
            $offer->category_id = null;
            $offer->food_id = $food;
            $offer->offer_type = $request->discount_type;
            $offer->discount_value = $request->discount;
            $offer->start_date = $request->start_date;
            $offer->end_date = $request->end_date;
            $offer->creator_role = "vendor";
            $offer->upto = $request->upto_price;
            $offer->save();
           foreach ($request->start_times ?? [] as $key=>$stime){
            $slotTime=new OfferTimeSlot();
            $slotTime->offer_id=$offer->id;
            $slotTime->start_time=$stime ?? '00:01:01';
            $slotTime->end_time=$endTimes[$key] ?? '23:59:59';
            $slotTime->save();
           }
              
          }
         return redirect()->route('vendor.offer')->with(['alert-type' => 'success', 'message' => 'Offer added Successfully']);
        }
    }

    public function edit($oid)
    {
        $id = auth()->user()->id;
        $offer = offer::latest()->where('id', $oid)->where('created_by', $id)->with('slots')->first();
        $foods=food_item::where('vendor_id',auth()->user()->id)->where('is_available',1)->orderBy('sort','ASC')->get();
        $categories = category::orderBy('sort', 'ASC')->get();
        if (!empty($offer)) {
            return view('vendor.offers.edit-offer', compact('offer','categories','foods'));
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Offer not found!']);
        }
    }
    public function update(Request $request)
    {
        $id = auth()->user()->id;
        // dd($request->all());
        $request->validate([
            'id' => ['required', 'exists:offers,id'],
            'title' => ['required', 'string'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'start_times' => ['required', 'array'],
            'start_times.*' => ['required'],
            'end_times' => ['required', 'array'],
            'end_times.*' => ['required'],
            'offer_on' => ['required', 'in:restaurant,category,food'],
            'category' => ['required_if:offer_on,category'],
            'food' => ['required_if:offer_on,food'],
            'discount_type' => ['required', 'in:fixed,percentage'],
            'discount' => ['required', 'numeric'],
            'upto_price' => ['required', 'numeric'],
        ]);
        
        $offer = offer::where('id', $request->id)->where('created_by', $id)->first();
        if (!empty($offer)) {

            $offer->title = $request->title;
            $offer->offer_type = $request->discount_type;
            $offer->discount_value = $request->discount;
            $offer->start_date = $request->start_date;
            $offer->end_date = $request->end_date;
            $offer->creator_role = "vendor";
            $offer->upto = $request->upto_price;
            $offer->whichType = $request->offer_on;
            if($offer->whichType=="category"){
              $offer->category_id = $request->category;
              $offer->food_id = null;
            }elseif($offer->whichType=="food"){
              $offer->category_id = null;
              $offer->food_id = $request->category;
            }else{
              $offer->category_id = null;
              $offer->food_id = null;
            }
            $offer->save();
            $old_slots=OfferTimeSlot::where('offer_id',$offer->id)->get();
            foreach ($old_slots ?? [] as $oslot){
                $oslot->delete();
            }
            $endTimes=$request->end_times ?? [];
            foreach ($request->start_times ?? [] as $key=>$stime){
               $slotTime=new OfferTimeSlot();
               $slotTime->offer_id=$offer->id;
               $slotTime->start_time=$stime ?? '00:01:01';
               $slotTime->end_time=$endTimes[$key] ?? '23:59:59';
               $slotTime->save();
            }
            return redirect()->route('vendor.offer')->with(['alert-type' => 'success', 'message' => 'Offer updated Successfully']);
        } else {
            return redirect()->route('vendor.offer')->with(['alert-type' => 'error', 'message' => 'Offer not found!']);
        }
    }

    public function delete($oid)
    {
        $id = auth()->user()->id;
        $offer = offer::where('id', $oid)->where('created_by', $id)->first();

        if (!empty($offer)) {
            $offer->delete();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Offer deleted successfully!']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Offer not found!']);
        }
    }
       public function updateStatus(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $offer = offer::where('created_by', auth()->user()->id)->where('id', $request->id)->first();
            if ($offer) {
                $offer[$request->col] = $request->value;
                $offer->save();
                return response()->json(['status' => true, 'message' => 'Status Changed.']);
            } else {

                return response()->json(['status' => false, 'message' => 'Offer not found.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first.']);
        }
    }
}
