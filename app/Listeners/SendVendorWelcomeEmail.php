<?php

namespace App\Listeners;

use App\Events\vendorRegister;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendVendorWelcomeEmail
{

    public function handle(vendorRegister $event): void
    {
        //
        $user = $event->user;
        Mail::send('mail.vendor-welcome', ['user' => $user], function ($message) use ($user) {
            // dd($user);
            $message->to($user->email)
                ->subject('Welcome to our platform!');
        });
    }
}
