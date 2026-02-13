<?php

namespace App\Http\Controllers;

use App\Events\OrderCompleted;
use App\Events\PaymentConfirmed;
use App\Models\Cart;
use App\Models\offer;
use App\Models\CollectionItem;
use App\Models\old_address;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Payment;
use App\Models\User;
use App\Models\vendor_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

use App\Models\Notification;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PayPalController extends Controller
{
    protected $fcm;

    public function __construct()
    {
        $this->fcm = new FirebaseService(env('FIREBASE_PROJECT_ID'),public_path(env('FIREBASE_CREDENTIALS_PATH')));
    }
    
    private function sendOrderNotification($receiverId, $title, $message, $type = 'order')
{
    $receiver = User::find($receiverId);
    if (!$receiver) return;

    // Save in DB
    Notification::create([
        'user_id' => $receiver->id,
        'type'    => $type,
        'title'   => $title,
        'message' => $message,
        'is_read' => false,
    ]);

    // Send FCM if token exists
    if ($receiver->device_token) {
        try {
            $this->fcm->sendNotification(
                [$receiver->device_token],
                [
                    'title' => $title,
                    'body'  => $message,
                    'type'  => $type,
                ]
            );
        } catch (\Exception $e) {
            \Log::error('FCM Error: ' . $e->getMessage());
        }
    }
}

    //
    public function payWithPayPal(Request $request)
    {
        // dd($request->all());


        $rules = [
            'old_address' => ['nullable', 'integer'],
            'method_type' => ['required', 'string'],
            'building_storey' => ['nullable', 'string'],
            'company_name' => ['nullable', 'string'],
            'note' => ['nullable', 'string'],
            'custome_time' => ['nullable', 'string'],
            'name' => ['nullable', 'string'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'del_price' => ['required'],
            'paymentMethod' => ['required', 'string'],
            'accept_terms_condition' => ['required'],
            'save_details_next' => ['nullable', 'in:on'],
            'cart' => ['required', 'array'],
            'cart.*' => ['required', 'integer', 'exists:carts,id'],
            'street' => ['nullable', 'string'],
            'house_number' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'latitude' => ['nullable', 'string'],
            'longitude' => ['nullable', 'string'],
        ];

        // Apply conditional rules
        $validator = Validator::make($request->all(), $rules);

        $validator->sometimes('street', 'required|string', function ($input) {
            return !$input->old_address && $input->method_type !== 'pickup';
        });

        $validator->sometimes('house_number', 'required|string', function ($input) {
            return !$input->old_address && $input->method_type !== 'pickup';
        });

        $validator->sometimes('postal_code', 'required|string', function ($input) {
            return !$input->old_address && $input->method_type !== 'pickup';
        });

        $validator->sometimes('city', 'required|string', function ($input) {
            return !$input->old_address && $input->method_type !== 'pickup';
        });

        // Validate and debug errors
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->with(['alert-type' => 'error', 'message' => $validator->errors()->first()]);
        }

        // Continue processing if validation passes
        $request->validate($rules);
        $cart_ids = $request->cart;

        $order_code = uniqid();

        $carts = Cart::whereIn('id', $cart_ids)->with('food_item.category.offer', 'food_item.offer', 'variant.variant_item')->get();
        // dd($carts);
        $restaurantDis = 0;
        $categoryDis = 0;
        $totalCategoryDis = 0;
        $vendor_id = (isset($carts[0]->food) && $carts[0]->food != null) ? $carts[0]->food->vendor_id : $carts[0]->food_item->vendor_id;

        $vendorDetail = vendor_detail::where('vendor_id', $vendor_id)->first();
        if ($vendorDetail && isset($vendorDetail->restaurant_status) && $vendorDetail->restaurant_status == 1) {
            $offer = offer::where('created_by', $vendor_id)
                ->where('whichType', 'restaurant')
                ->where('start_date', '<=', now())
                ->where('end_date', '>', now())
                ->where('is_active', 1)
                ->first();
            $total_price = 0;

            foreach ($carts as $cart) {
                $offerl = null;
                if (isset($cart->food_item->offer)) {
                    $offerl = $cart->food_item->offer;
                } elseif (isset($cart->food_item->category->offer)) {
                    $offerl = $cart->food_item->category->offer;
                } elseif (isset($offer)) {
                    $offerl = $offer;
                }
                if (isset($offerl)) {
                    if ($offerl->offer_type == 'percentage') {
                        $categoryDis = ($offerl->discount_value / 100) * $cart->total_price;
                        $totalCategoryDis += $categoryDis;
                        $total_price += $cart->total_price - $categoryDis;
                    } elseif ($offer->offer_type == 'fixed') {
                        $categoryDis = $offerl->discount_value;
                        $totalCategoryDis += $categoryDis;
                        $total_price += $cart->total_price - $categoryDis;
                    } else {
                        $total_price += $cart->total_price;
                    }
                } else {
                    $total_price += $cart->total_price;
                }
            }
            // dd($arr);
            $totalDis = floatVal($restaurantDis) + floatVal($totalCategoryDis);

            if (isset($request->method_type) && $request->method_type == "delivery") {
                if (isset($request->old_address) && $request->old_address != "") {
                    $oldaddress = old_address::find($request->old_address);
                    if ($oldaddress) {
                        $address = [
                            'street' => $oldaddress->street,
                            'house_number' => $oldaddress->house_no,
                            'postal_code' => $oldaddress->postal_code,
                            'city' => $oldaddress->city,
                            'floor' => $oldaddress->floor,
                            'company_name' => $oldaddress->company_name,
                            'latitude' => $request->latitude,
                            'longitude' => $request->longitude
                        ];
                    } else {
                        $address = [
                            'street' => $request->street,
                            'house_number' => $request->house_number,
                            'postal_code' => $request->postal_code,
                            'city' => $request->city,
                            'floor' => $request->building_storey,
                            'company_name' => $request->company_name,
                            'latitude' => $request->latitude,
                            'longitude' => $request->longitude
                        ];
                    }
                } else {
                    // check want to save address for next time
                    if (isset($request->save_details_next) && $request->save_details_next == "on") {
                        $address = [
                            'street' => $request->street,
                            'house_number' => $request->house_number,
                            'postal_code' => $request->postal_code,
                            'city' => $request->city,
                            'floor' => $request->building_storey,
                            'company_name' => $request->company_name,
                            'latitude' => $request->latitude,
                            'longitude' => $request->longitude
                        ];
                        $oldAddress = new old_address();
                        $oldAddress->user_id = Auth::user()->id;
                        $oldAddress->street = $request->street;
                        $oldAddress->house_no = $request->house_number;
                        $oldAddress->postal_code = $request->postal_code;
                        $oldAddress->city = $request->city;
                        $oldAddress->floor = $request->building_storey;
                        $oldAddress->company_name = $request->company_name;
                        $oldAddress->latitude = $request->latitude;
                        $oldAddress->longitude = $request->longitude;
                        $oldAddress->save();
                    } else {
                        $address = [
                            'street' => $request->street,
                            'house_number' => $request->house_number,
                            'postal_code' => $request->postal_code,
                            'city' => $request->city,
                            'floor' => $request->building_storey,
                            'latitude' => $request->latitude,
                            'longitude' => $request->longitude
                        ];
                    }
                }
            } else {
                $address = [];
            }

            $order_receiver = [
                'name' => $request->first_name . ' ' . $request->last_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ];
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->order_code = $order_code;
            $order->vendor_id = $vendor_id;
            $order->total_amount = $total_price;
            $order->discount = $totalDis;
            $order->contact_number = $request->phone;
            $order->special_instructions = $request->note;
            $order->payment_method = $request->paymentMethod;
            $order->custome_time = $request->custome_time;
            $order->address = json_encode($address);
            $order->food_receiver = json_encode($order_receiver);
            $order->save();


            $extraCost = 0;
            $totalCostFood = 0;
            $totalCategoryDis = 0;
            foreach ($carts as $cart) {
                $offerl = null;
                if (isset($cart->food_item->offer)) {
                    $offerl = $cart->food_item->offer;
                } elseif (isset($cart->food_item->category->offer)) {
                    $offerl = $cart->food_item->category->offer;
                } elseif (isset($offer)) {
                    $offerl = $offer;
                }
                if (isset($offerl)) {
                    if ($offerl->offer_type == 'percentage') {
                        $categoryDis = ($offerl->discount_value / 100) * $cart->total_price;
                        $totalCategoryDis += $categoryDis;
                        $totalCostFood += $cart->total_price - $categoryDis;
                    } elseif ($offer->offer_type == 'fixed') {
                        $categoryDis = $offerl->discount_value;
                        $totalCategoryDis += $categoryDis;
                        $totalCostFood += $cart->total_price - $categoryDis;
                    } else {
                        $totalCostFood += $cart->total_price;
                    }
                } else {
                    $totalCostFood += $cart->total_price;
                }

                $foodItem = $cart->food_item;
                $variant = $cart->variant;
                // dd($foodItem);
                 
                $variant_id = $variant->variant_id ?? null;

                if ($foodItem) {

                    $dressing = CollectionItem::where('id', $cart->dressing_type)->with('sub_items')->first();
                    $cart->dressing = (isset($dressing->sub_items->name)) ? $dressing->sub_items->name : "";
                    $extraIds = is_array(json_decode($cart->extras, true)) ? json_decode($cart->extras, true) : [];

                    if (!empty($extraIds) && is_array($extraIds)) {
    $extraIds = array_map('intval', $extraIds); // Ensure integer IDs

    $cart->collection_items = CollectionItem::where('status', 1)
        ->whereIn('id', $extraIds)
        ->with('sub_items')
        ->orderByRaw("FIELD(id, " . implode(',', $extraIds) . ")")
        ->get();
                    } else {
                      $cart->collection_items = collect(); // or handle error
                    }

                        
                    $collectionData = [];
                    if (isset($cart->collection_items)) {
                        foreach ($cart->collection_items as $collectionItem) {
                            if (isset($collectionItem->prices) && json_decode($collectionItem->prices) != null) {
                                $pricesArray = json_decode($collectionItem->prices, true);
                                $price = is_array($pricesArray) && array_key_exists($variant_id, $pricesArray) && isset($pricesArray[$variant_id]) && $pricesArray[$variant_id] != "" ? $pricesArray[$variant_id] : $collectionItem->sub_items->price;
                            } else {
                                $price = $collectionItem->sub_items->price;
                            }
                            $collectionData[] = array('name' => isset($collectionItem->sub_items->name) ? $collectionItem->sub_items->name : "", 'info' => isset($collectionItem->sub_items->info) ? $collectionItem->sub_items->type : "", 'type' => isset($collectionItem->sub_items->type) ? $collectionItem->sub_items->type : "", "price" => $price);
                        }
                    }

                    $newOrder = new Order_item();
                    $newOrder->order_id = $order->id;
                    $newOrder->food_id = $foodItem->id;
                    $newOrder->food_item_name = $foodItem->food_item_name;
                    $newOrder->variant = isset($variant->variant_item->name) ? $variant->variant_item->name : "";
                    if($cart->dressing!="" && empty($cart->variant_id)){
                      $newOrder->price = isset($foodItem->delivery_price) ? (floatval($foodItem->delivery_price)) : 0; 
                    //   dd($foodItem->price);
                    }else{
                      $newOrder->price = isset($variant->price) ? $variant->price : 0;  
                    }
                    // dd($newOrder);
                    $newOrder->total_price = floatval($totalCostFood);
                    $newOrder->quantity = $cart->quantity;
                    $newOrder->extra_note = $cart->extra_note;
                    $newOrder->dressing = $cart->dressing;
                    $newOrder->extras = json_encode($collectionData);
                    $newOrder->save();
                }
                $cart->delete();
            }

            $order->delivery_price = $request->del_price;
            $order->method_type = $request->method_type;
            $order->method_cost = $request->del_price;
            $order->save();

            session(['order_code' => $order_code]);
            $amount = floatval($total_price + $request->del_price);

            if ($request->paymentMethod == "paypal") {
                $provider = new PayPalClient;
                $provider->setApiCredentials(config('paypal'));
                $token = $provider->getAccessToken();
                $provider->setAccessToken($token);
                $amount = number_format($amount, 2);
                $response = $provider->createOrder([
                    "intent" => "CAPTURE",
                    "application_context" => [
                        "return_url" => route('paypal.status'),
                        "cancel_url" => route('paypal.status'),
                    ],
                    "purchase_units" => [
                        0 => [
                            "amount" => [
                                "currency_code" => "EUR",
                                "value" => $amount
                            ]
                        ]
                    ]
                ]);
                //  dd($response);
                if (isset($response['id']) && $response['id'] != null) {
                    foreach ($response['links'] as $link) {
                        if ($link['rel'] == 'approve') {
                            // dd($link['href']);
                            return redirect()->away($link['href']);
                        }
                    }
                    return redirect()->route('checkout.now')->with('error', 'Something went wrong.');
                } else {
                    return redirect()->route('checkout.now')->with('error', $response['message'] ?? 'Something went wrong.');
                }
            } else {
                $order->payment_method = $request->paymentMethod;
                $order->payment_status = 2;
                $order->save();
                // Send Notification to customer
                $this->sendOrderNotification(
    $order->user_id,
    'Order Placed Successfully 🎉',
    "Your order #{$order_code} has been placed successfully.",
    'order_success'
);
                // send Notification to vendor
                $this->sendOrderNotification(
    $order->vendor_id,
    'New Order Received 🛒',
    "You have received a new order #{$order->order_code}.",
    'new_order'
);

                $user = User::where('id', $order->user_id)->first();
                $orderItems = Order_item::where('order_id', $order->id)->get();
                $dataEmail = [
                    'name' => $user->name,
                    'customer_email' => $user->email,
                    'order_code' => $order_code,
                    'order_date' => date('d F Y, h:i A'),
                    'order_status' => 'paid',
                    'amount' => $amount,
                    'discount' => $totalDis,
                    'delivery_cost' => $request->del_price,
                    'method' => $order->method_type,
                    'extra_cost' => $order->method_cost,
                    'delivery_address' => $address,
                    'payment_method' => ucfirst($request->method_type),
                    'items' => $orderItems,

                ];
                $dataEmail = json_decode(json_encode($dataEmail));

                event(new OrderCompleted($dataEmail));
                return redirect()->route('myaccount')->with(['alert-type' => 'success', 'message' => 'Order placed successfully.']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Restaurant is close.']);
        }
    }

    public function payPalStatus(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $response = $provider->capturePaymentOrder($request['token']);
        // dd($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $billingAddress = $response['purchase_units'][0]['shipping']['address'];
            $order_code = Session::get('order_code');
            $order = Order::where('order_code', $order_code)->first();
            $order->payment_method = 'paypal';
            $order->payment_status = 2;
            $order->save();
           
            // -----------------------------
// SEND ORDER NOTIFICATIONS
// -----------------------------

// Notify USER
$this->sendOrderNotification(
    $order->user_id,
    'Order Placed Successfully 🎉',
    "Your PayPal payment was successful. Order #{$order->order_code} has been placed.",
    'order_success'
);

// Notify VENDOR
$this->sendOrderNotification(
    $order->vendor_id,
    'New Order Received 🛒',
    "You have received a new paid order #{$order->order_code}.",
    'new_order'
);

           
            $paymentOrder = new Payment();
            $paymentOrder->user_id = Auth::user()->id;
            $paymentOrder->vendor_id = $order->vendor_id;
            $paymentOrder->payment_id = $response['id'];
            $paymentOrder->payment_method = 'paypal';
            $paymentOrder->payment_status = 'paid';
            $paymentOrder->amount = ($order->total_amount + $order->method_cost);
            $paymentOrder->order_code = $order_code;
            $paymentOrder->payment_date = date('Y-m-d H:i:s');
            $paymentOrder->save();
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
                'payment_method' => 'PayPal',
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
                'payment_method' => "PayPal",
                'payment_status' => "paid",
                'order_code' => $order_code,
                'payment_date' => date('Y-m-d H:i:s'),
            ];
            $paymentData = json_decode(json_encode($paymentData));
            event(new PaymentConfirmed($paymentData));
            return redirect()->route('home')->with(['alert-type' => 'success', 'message' => 'Your order has been placed.']);
        } else {
            // Payment failed
            return redirect()->route('home')->with(['alert-type' => 'error', 'message' => $response['message'] ?? 'Payment failed.']);
        }
    }

    public function deleteOldAddress($address_id)
    {
        if (isset(Auth::user()->id)) {
            $userId = Auth::user()->id;
            $oldAddress = old_address::where('user_id', $userId)->where('id', $address_id)->first();
            if ($oldAddress) {
                $oldAddress->delete();
                return response()->json(['success' => true, 'message' => 'Address is deleted successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Address not found']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Please login first.']);
        }
    }
}
