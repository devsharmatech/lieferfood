<?php

namespace App\Http\Controllers;

use App\Models\address;
use App\Models\country;
use App\Models\Order;
use App\Models\table_booking;
use App\Models\table_food;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;


class UserController extends Controller
{
    //
    public function myAccount()
    {
        $id = auth()->user()->id;
        $user = User::where('id', $id)->with('delivery_address')->first();
        $countries = country::orderBy('name', 'ASC')->get();
        $orders = Order::where('user_id', $id)->with('order_items','review')->latest()->get();
        $tables = table_booking::where('user_id', $id)->where('isComplete',1)
            ->with('vendor')
            ->latest()
            ->get();

        $tables->each(function ($table) {
            $foodIds = json_decode($table->foods, true); 
            if (is_array($foodIds) && count($foodIds) > 0) {
                $table->foodDetails = table_food::whereIn('id', $foodIds)->get();
            } else {
                $table->foodDetails = collect(); // Empty collection if no foods are found
            }
        });
        // dd($tables);
        return view('external.profile.my-profile', compact('user', 'countries', 'orders', 'tables'));
    }
    public function updateAccount(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $request->validate(
                [
                    'name' => 'required|string',
                    'surname' => 'nullable|string',
                    'email' => 'required|email|unique:users,email,' . $id,
                    'phone' => 'required|unique:users,phone,' . $id,
                    'address' => 'required|string',
                    'image' => 'nullable|image',
                    'password' => 'nullable|string|min:8',
                ]
            );
            $user = User::where('id', $id)->first();
            $user->name = $request->name;
            $user->surname = $request->surname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $manager = new ImageManager(Driver::class);
                $oldPath = public_path('uploads/users/' . $user->profile);
                $image = $manager->read($file);
                $filename = uniqid('profile_') . '.' . $file->getClientOriginalExtension();
                $image->resize(400, 400)->save(public_path('uploads/users/' . $filename));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $user->profile = $filename;
            }
            if ($request->password != '') {
                $user->password = bcrypt($request->password);
            }
            $user->save();
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Successfully update your profile.']);
        } else {
            return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function updateAddress(Request $request)
    {

        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $request->validate([
                'country' => 'required|string',
                'state' => 'nullable|string',
                'city' => 'required|string',
                'postal_code' => 'required|string',
                'neighborhood' => 'nullable|string',
                'street' => 'nullable|string',
                'house_number' => 'nullable|string',
                'complement' => 'nullable|string',
            ]);
            $user = User::find($id);
            $user->country = $request->country;
            $user->state = $request->state;
            $user->zipcode = $request->postal_code;
            $user->save();

            $address = address::where('user_id', $id)->first();
            if ($address) {
                $address->country = $request->country;
                $address->state = $request->state;
                $address->city = $request->city;
                $address->postal_code = $request->postal_code;
                $address->neighborhood = $request->neighborhood;
                $address->street = $request->street;
                $address->number = $request->house_number;
                $address->complement = $request->complement;
                $address->save();
            } else {
                $address = new address();
                $address->user_id = $id;
                $address->country = $request->country;
                $address->state = $request->state;
                $address->city = $request->city;
                $address->postal_code = $request->postal_code;
                $address->neighborhood = $request->neighborhood;
                $address->street = $request->street;
                $address->number = $request->house_number;
                $address->complement = $request->complement;
                $address->save();
            }
            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Address updated successfully', 'isAddress' => 'yes']);
        } else {
            return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
}
