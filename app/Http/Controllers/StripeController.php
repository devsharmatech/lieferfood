<?php

namespace App\Http\Controllers;

use App\Events\OrderCompleted;
use App\Events\PaymentConfirmed;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Payment;
use App\Models\User;
use App\Models\Notification;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    protected $fcm;

    public function __construct()
    {
        $this->fcm = new FirebaseService(env('FIREBASE_PROJECT_ID'), public_path(env('FIREBASE_CREDENTIALS_PATH')));
    }

    private function sendOrderNotification($receiverId, $title, $message, $type = 'order')
    {
        $receiver = User::find($receiverId);
        if (!$receiver)
            return;

        Notification::create([
            'user_id' => $receiver->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'is_read' => false,
        ]);

        if ($receiver->device_token) {
            try {
                $this->fcm->sendNotification(
                    [$receiver->device_token],
                    [
                        'title' => $title,
                        'body' => $message,
                        'type' => $type,
                    ]
                );
            } catch (\Exception $e) {
                Log::error('FCM Error: ' . $e->getMessage());
            }
        }
    }

    /**
     * Handle successful Stripe payment redirect.
     */
    public function stripeSuccess(Request $request)
    {
        $order_code = Session::get('order_code');

        if (!$order_code) {
            return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'Order not found.']);
        }

        $order = Order::where('order_code', $order_code)->first();

        if (!$order) {
            return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'Order not found.']);
        }

        // Verify the Stripe session
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $sessionId = $request->get('session_id');

            if ($sessionId) {
                $session = \Stripe\Checkout\Session::retrieve($sessionId);

                if ($session->payment_status !== 'paid') {
                    return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'Payment not completed.']);
                }
            }
        } catch (\Exception $e) {
            Log::error('Stripe verification error: ' . $e->getMessage());
        }

        // Mark order as paid
        $order->payment_method = 'stripe';
        $order->payment_status = 2;
        $order->save();

        // Send notifications
        $this->sendOrderNotification(
            $order->user_id,
            'Order Placed Successfully 🎉',
            "Your Stripe payment was successful. Order #{$order->order_code} has been placed.",
            'order_success'
        );

        $this->sendOrderNotification(
            $order->vendor_id,
            'New Order Received 🛒',
            "You have received a new paid order #{$order->order_code}.",
            'new_order'
        );

        // Create Payment record
        $paymentRecord = new Payment();
        $paymentRecord->user_id = Auth::user()->id;
        $paymentRecord->vendor_id = $order->vendor_id;
        $paymentRecord->payment_id = $request->get('session_id', uniqid('stripe_'));
        $paymentRecord->payment_method = 'stripe';
        $paymentRecord->payment_status = 'paid';
        $paymentRecord->amount = ($order->total_amount + $order->method_cost);
        $paymentRecord->order_code = $order_code;
        $paymentRecord->payment_date = date('Y-m-d H:i:s');
        $paymentRecord->save();

        // Fire email events
        $user = User::where('id', $order->user_id)->first();
        $address = json_decode($order->address);
        $orderItems = Order_item::where('order_id', $order->id)->get();

        $dataEmail = [
            'name' => $user->name,
            'customer_email' => $user->email,
            'order_code' => $order_code,
            'order_date' => date('d F Y, h:i A'),
            'order_status' => 'paid',
            'amount' => $order->total_amount,
            'discount' => $order->discount,
            'method' => $order->method_type,
            'extra_cost' => $order->method_cost,
            'delivery_cost' => $order->delivery_price,
            'delivery_address' => $address,
            'payment_method' => 'Stripe',
            'items' => $orderItems
        ];
        $dataEmail = json_decode(json_encode($dataEmail));
        event(new OrderCompleted($dataEmail));

        $paymentData = [
            'name' => $user->name,
            'customer_email' => $user->email,
            'amount' => (floatVal($order->total_amount) + floatVal($order->method_cost)),
            'discount' => (floatVal($order->discount)),
            'currency_code' => 'EUR',
            'payment_method' => 'Stripe',
            'payment_status' => 'paid',
            'order_code' => $order_code,
            'payment_date' => date('Y-m-d H:i:s'),
        ];
        $paymentData = json_decode(json_encode($paymentData));
        event(new PaymentConfirmed($paymentData));

        return redirect()->route('home')->with(['alert-type' => 'success', 'message' => 'Your order has been placed successfully.']);
    }

    /**
     * Handle cancelled Stripe payment.
     */
    public function stripeCancel()
    {
        return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'Payment was cancelled.']);
    }
}
