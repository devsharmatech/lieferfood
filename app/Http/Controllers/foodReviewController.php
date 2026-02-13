<?php

namespace App\Http\Controllers;

use App\Models\review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class foodReviewController extends Controller
{
    //
    public function index()
    {
        $reviews=review::latest()->with('vendor','user')->get();
        return view('admin.reviews.food-reviews',compact('reviews'));
    }
    public function vendorReviews()
    {
        $reviews=review::latest()->with('user')->where('vendor_id',auth()->id())->get();
        return view('vendor.reviews.reviews',compact('reviews'));
    }
    public function editReview($id){
        $review=review::where('id',$id)->first();
        if($review){
            return view('admin.reviews.edit',compact('review'));
        }else{
            return back()->with(['alert-type'=>'error','message'=>'Review not found.']);
        }
    }

    public function update(Request $request){
        $validater=Validator::make($request->all(),
        [
            'id'=>'required|exists:users,id',
            'rating'=>'required|numeric|digits_between:1,5',
            'review'=>'required|string',
            'status'=>'required|integer',
        ]);
        if($validater->fails()){
            return back()->with(['alert-type'=>"error",'message'=>'Validation failed!'])->withErrors($validater->fails());
        }else{
            $review=review::where('id',$request->id)->first();
            if($review){
                $review->rating=$request->rating;
                $review->content=$request->review;
                $review->status=$request->status;
                $review->save();
                return redirect()->route('admin.food.reviews')->with(['alert-type'=>'success','message'=>'Review updated']);
            }else{
                return back()->with(['alert-type'=>'error','message'=>'Review not found.']);
            }
        }
    }
    public function deleteReview($id){
        $review=review::where('id',$id)->first();
        if($review){
            $review->delete();
            return back()->with(['alert-type'=>'success','message'=>'Review deleted.']);
        }else{
            return back()->with(['alert-type'=>'error','message'=>'Review not found.']);
        }
    }
}
