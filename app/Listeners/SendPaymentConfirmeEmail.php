<?php

namespace App\Listeners;

use App\Events\PaymentConfirmed;

use Illuminate\Support\Facades\Mail;

class SendPaymentConfirmeEmail
{
    
    public function handle(PaymentConfirmed $event): void
    {
        //
        $payment = $event->payment;
        Mail::send('mail.payment-confirmation', ['payment' => $payment], function ($message) use ($payment) {
            
            $message->to($payment->customer_email)
                ->subject('Payment Confirmed');
        });
    }
}
