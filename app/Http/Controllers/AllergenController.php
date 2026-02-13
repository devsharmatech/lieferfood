<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use App\Models\Tax;
use Illuminate\Http\Request;

class AllergenController extends Controller
{
    //
    public function index()
    {
        if (isset(auth()->user()->id)) {
            $allergens = Allergen::where('vendor_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
            return view('vendor.allergen.allergens', compact('allergens'));
        } else {
            abort(403);
        }
    }
    public function saveAllergen(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $request->validate([
                'allergen_name' => 'required',
                'allergen_type' => 'required',
            ]);
            $allergen = new Allergen();
            $allergen->vendor_id = auth()->user()->id;
            $allergen->name = $request->allergen_name;
            $allergen->type = $request->allergen_type;
            $allergen->save();
            return response()->json(['status' => true, 'message' => 'Allergen successfully saved']);
        } else {
            abort(403);
        }
    }
    public function updateAllergen(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $request->validate([
                'allergen_id' => 'required|exists:allergens,id',
                'allergen_name' => 'required',
                'allergen_type' => 'required',
            ]);
            $allergen = Allergen::where('id', $request->allergen_id)->where('vendor_id', auth()->user()->id)->first();
            if ($allergen) {
                $allergen->vendor_id = auth()->user()->id;
                $allergen->name = $request->allergen_name;
                $allergen->type = $request->allergen_type;
                $allergen->save();
                return response()->json(['status' => true, 'message' => 'Allergen successfully saved']);
            } else {
                return response()->json(['status' => false, 'message' => 'Allergen not found']);
            }
        } else {
            abort(403);
        }
    }

    public function updateAllergenStatus(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $allergen = Allergen::find($request->id);
            if ($allergen) {
                $allergen->status = $request->status;
                $allergen->save();
                return response()->json(['status' => true, 'message' => 'Allergens status changed']);
            } else {
                return response()->json(['status' => false, 'message' => 'Allergens is not found!']);
            }
        } else {
            abort(403);
        }
    }
    public function destroyAllergen(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $allergen = Allergen::find($request->id);
            if ($allergen) {
                $allergen->delete();
                return response()->json(['status' => true, 'message' => 'Allergens deleted']);
            } else {
                return response()->json(['status' => false, 'message' => 'Allergens is not found!']);
            }
        } else {
            abort(403);
        }
    }
    
    
     public function allTax()
    {
        if (isset(auth()->user()->id)) {
            $taxes = Tax::where('vendor_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
            return view('vendor.tax.index', compact('taxes'));
        } else {
            abort(403);
        }
    }
     public function editTax($tax_id)
     {
        if (isset(auth()->user()->id)) {
            $taxes = Tax::where('vendor_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
            $tax = Tax::where('vendor_id', auth()->user()->id)->where('id',$tax_id)->first();
            
            return view('vendor.tax.index', compact('taxes','tax'));
        } else {
            abort(403);
        }
     }
     public function destroyTax(Request $request)
     {
        if (isset(auth()->user()->id)) {
            $tax = Tax::where('vendor_id', auth()->user()->id)->where('id',$request->id)->first();
            $tax->delete();
            return response()->json(['status'=>true,'message'=>'successfully deleted!']);
        } else {
            return response()->json(['status'=>false,'message'=>'Please login first!']);
        }
     }


    public function saveTax(Request $request){
        if (isset(auth()->user()->id)) {
            $request->validate([
                'id' => 'nullable|exists:taxes,id',
                'tax_name' => 'required',
                'type' => 'required',
                'tax_value' => 'required',
            ]);
            if($request->id!=""){
                $tax = Tax::where('id',$request->id)->first();
            }else{
                $tax = new Tax();
            }
            $tax->vendor_id = auth()->user()->id;
            $tax->name = $request->tax_name;
            $tax->type = $request->type;
            $tax->value = $request->tax_value;
            $tax->save();
            return redirect()->route('vendor.all.tax')->with(['alert-type' =>'success', 'message' => 'Tax successfully saved']);
        } else {
            abort(403);
        }
    }
}
