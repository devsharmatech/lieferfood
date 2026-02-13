<?php

namespace App\Http\Controllers\auth;

use App\Events\sendOtp;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class customerAuthController extends Controller
{
    //
    public function login()
    {
        return view('external.auth.login');
    }
    public function register()
    {
        return view('external.auth.registeration-user');
    }
    public function register_save(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8'],
                'confirm_password' => ['required', 'string', 'min:8', 'same:password'],
                'term_and_condition' => ['required']
            ]
        );
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Please fill all required field.']);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->route('login')->with(['alert-type' => 'success', 'message' => 'Registration Successfull Please Login to Continue.']);
        }
    }
    public function login_verify(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [

                'email' => ['required', 'email'],
                'password' => ['required']
            ]
        );
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Please fill all required field.']);
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    Auth::login($user);
                    return redirect()->route('home')->with(['alert-type' => 'success', 'message' => 'Successfully login']);
                } else {
                    return back()->withErrors($validate->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Password is incorrect.']);
                }
            } else {
                return back()->withErrors($validate->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Email is incorrect.']);
            }
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with(['alert-type' => 'success', 'message'
        => 'Successfully logout']);
    }
    public function delete_profile($id)
    {
        $user = User::find($id);
        if ($user) {
            // delete use profile image also
            if ($user->profile != '') {
                $image_path = public_path('uploads/users/' . $user->profile);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $user->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'User deleted.']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'User not found.']);
        }
    }

    public function forgetpassword()
    {
        return view('external.auth.forget-password');
    }
    public function sendotp(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Please fill all required field.']);
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                // send otp via email and also store email and otp in session

                $otp = rand(1000, 9999);
                $user->otp = $otp;
                event(new sendOtp($user));


                $otpExpiresAt = now()->addMinutes(10);
                Session::put('otp', $otp);
                Session::put('email', $user->email);
                Session::put('otp_expires_at', $otpExpiresAt);


                return redirect()->route('otpget')->with(['alert-type' => 'success', 'message' => 'OTP sent successfully.']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Email not found.']);
            }
        }
    }
    public function otpget()
    {
        return view('external.auth.otpget');
    }
    public function setpassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'otp' => 'required|numeric',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Please fill all required field.']);
        } else {
            $otp = Session::get('otp');
            $email = Session::get('email');
            $otp_expires_at = Session::get('otp_expires_at');
            if ($otp_expires_at < now()) {
                return redirect()->route('forgetpassword')->with(['alert-type' => 'error', 'message' => 'OTP expired. Please request again.']);
            } else {
                if ($otp == $request->otp) {
                    $user = User::where('email', $email)->first();
                    $user->password = Hash::make($request->password);
                    $user->save();
                    Auth::login($user);
                    return redirect()->route('home')->with(['alert-type' => 'success', 'message'
                    => 'Password set successfully.']);
                } else {
                    return back()->with(['alert-type' => 'error', 'message' => 'Invalid OTP.']);
                }
            }
        }
    }
}
