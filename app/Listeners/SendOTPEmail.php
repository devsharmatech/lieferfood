<?php

namespace App\Listeners;

use App\Events\sendOtp;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOTPEmail
{

    public function handle(sendOtp $event): void
    {
        //
        $user = $event->user;
        // Log::info('Listener executed for user: ' . $event->user->name);
        Mail::send('mail.send-otp', ['user' => $user], function ($message) use ($user) {
            // dd($user);
            $message->to($user->email)
                ->subject('One Time Password from Dillon Restaurant');
        });
    }
}
