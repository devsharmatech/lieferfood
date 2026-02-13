<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CustomerController extends Controller
{
    //
    public function updateProfilePicture(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            "user_id" => 'required|exists:users,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation failed.', 'error' => $validator->messages()], 200);
        } else {
            $user = User::where('id', $request->user_id)->first();
            if ($user) {
                // upload image if exist
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
                $user->save();
                $data = $user->only(['id', 'email', 'name', 'surname', 'phone', 'unid', 'profile', 'language']);
                return response()->json(['status' => true, 'message' => 'User Profile is successfully updated.', 'data' => $data], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'User not found.'], 200);
            }
        }
    }
    public function getCustomerDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => 'required|exists:users,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation failed.', 'error' => $validator->messages()], 200);
        } else {
            $user = User::where('id', $request->user_id)->with('delivery_address')->first();
            if ($user) {
                return response()->json(['status' => true, 'message' => 'Data Successfully fetched', 'data' => $user], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'User not found.'], 200);
            }
        }
    }

    public function updateCustomerInfo(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "user_id" => 'required|exists:users,id',
            'name' => 'required|string',
            'surname' => 'nullable|string',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
            'phone' => 'required|unique:users,phone,' . $request->user_id,
            'address' => 'required|string',
            'image' => 'nullable|image',
            'password' => 'nullable|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation failed.', 'error' => $validator->messages()], 200);
        } else {
            $id = $request->user_id;
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
            return response()->json(['status' => true, 'message' => 'Customer info successfully updated', 'data' => $user], 200);
        }
    }
    public function createAddress(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'country' => 'required|string',
                'state' => 'nullable|string',
                'city' => 'required|string',
                'postal_code' => 'required|string',
                'neighborhood' => 'nullable|string',
                'street' => 'nullable|string',
                'house_number' => 'nullable|string',
                'complement' => 'nullable|string',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation failed.', 'error' => $validator->messages()], 200);
        } else {
            $id = $request->user_id;
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
            return response()->json(['status' => true, 'message' => 'Address created successfully','data'=>$address], 201);
        }
    }
}
