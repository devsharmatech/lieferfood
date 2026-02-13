<?php

namespace App\Listeners;

use App\Events\OrderCompleted;
use Illuminate\Support\Facades\Mail;

class SendOrderEmail 
{
    

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderCompleted  $event
     * @return void
     */
    public function handle(OrderCompleted $event)
    {
        $order = $event->order;
        Mail::send('mail.food-order', ['order' => $order], function ($message) use ($order) {
            // dd($user);
            $message->to($order->customer_email)
                ->subject('Order Confirmed');
        });
    }
}
