<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SocialiteController extends Controller
{
    //
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        $existingUser = User::where('email', $user->getEmail())->first();

        if ($existingUser) {
            Auth::login($existingUser, true);
        } else {
            $password = Str::random(8);
            $newUser = new User();
            $newUser->unid = uniqid();
            $newUser->email = $user->getEmail();
            $newUser->name = $user->getName();
            $newUser->password = bcrypt($password);
            $newUser->google_id = $user->getId();
            $avatarUrl = $user->getAvatar();
            $avatarContents = file_get_contents($avatarUrl);
            $avatarName = uniqid() . '.jpg';
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($avatarContents);
            $filename = $avatarName;
            $image->resize(400, 400)->save(public_path('uploads/users/' . $filename));
            $newUser->profile = $filename;
            $newUser->save();
            Auth::login($newUser, true);
        }

        return redirect()->route('home')->with(['alert-type' => 'success', 'message' => 'Successfully login.']);
    }
}
