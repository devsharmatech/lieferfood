<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WinorderApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WinOrderController extends Controller
{
    //
    public function allApis(){
        $apis=WinorderApi::latest()->with('vendor')->get();
        $users = User::latest()
                 ->where('role', 'vendor')
                 ->whereDoesntHave('winorderApi') 
                 ->get();
        return view('admin.winorder.all-api',compact('apis','users'));
    }
   public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'vendor' => 'required|integer|exists:users,id', 
        ]);
        $code = uniqid('lfc'); 
        $secret_key = uniqid('sckey'); 
        $winorderapi=new WinorderApi();
        $winorderapi->vendor_id=$request->vendor;
        $winorderapi->code=$code;
        $winorderapi->secret_key=$secret_key;
        $winorderapi->save();
        return back()->with(['alert-type'=>'success','message'=>'Successfully generate code for this shop.']);
    }
     public function deleteThis($id)
    {
        if (isset(Auth::user()->id)) {
            $WinorderApi = WinorderApi::where('id', $id)->first();
            if (!empty($WinorderApi)) {
               
                $WinorderApi->delete();
                return redirect()->back()->with(['alert-type' => 'success', 'message' => 'API Access is deleted successfully']);
            } else {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'API Access is not found']);
            }
        } else {
            return redirect()->back()->with(['alert-type' => 'warning', 'message' => 'Please login first.']);
        }
    }
}
