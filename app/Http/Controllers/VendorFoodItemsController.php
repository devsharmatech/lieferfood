<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use App\Models\category;
use App\Models\CategoryVariant;
use App\Models\collections;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\foodVariant;
use App\Models\food_item;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use App\Models\vendor_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

use App\Models\Notification;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class VendorFoodItemsController extends Controller
{
    //
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
    public function index()
    {
        $id = Auth::user()->id;
        $foods = food_item::where('vendor_id', $id)->with('category')->orderBy('sort', 'ASC')->get();
        // dd($foods);
        return view('vendor.foods.all-food-items', compact('foods'));
    }
    public function create()
    {
        $categories = category::where('vendor_id', Auth::user()->id)->orderBy('name', 'ASC')->get();
        $collections = collections::where('vendor_id', Auth::user()->id)->where('status', 1)->orderBy('name', 'ASC')->get();
        $allergens = Allergen::where('vendor_id', Auth::user()->id)->where('status', 1)->orderBy('type', 'ASC')->get();
        return view('vendor.foods.add-food-item', compact('categories', 'collections', 'allergens'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $id = Auth::user()->id;
        $request->validate([
            'food_name' => 'required',
            'category' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'item_type' => 'required|string',
            'item_types' => 'nullable|array',
            'external_id' => 'nullable',
            'variants' => 'nullable|array',
            'variants.*' => 'nullable|exists:category_variants,id',
            'prices' => 'nullable|array',
            'delivery_price' => 'nullable|numeric|min:0',
            'pickup_price' => 'nullable|numeric|min:0',
            'status' => 'nullable|array',
            'cereal' => 'nullable|array',
            'nuts' => 'nullable|array',
            'furthers' => 'nullable|array',
            'is_allergens_accept' => 'nullable',
            'confirm' => 'nullable',
            'collection' => 'nullable|array',
        ]);
        $food = new food_item();
        $food->food_item_name = $request->food_name;
        $food->category_id = $request->category;
        $food->vendor_id = $id;
        $food->description = $request->description;
        $food->is_available = 1;
        $food->delivery_price = 0;
        $food->pickup_price = 0;
        $food->item_type = $request->item_type;
        $food->types = json_encode($request->item_types ?? []);
        $food->external_id = $request->external_id;
        $food->save();
        if ($request->has('variants') && count($request->variants) > 0) {
            $food->hasVariants = 1;
            $variants = $request->variants;
            $prices = $request->prices;
            $status = $request->status;
            foreach ($variants as $key => $variant) {
                if (isset($status[$variant][0]) && $status[$variant][0] == "on") {
                    $food_variant = new foodVariant();
                    $food_variant->food_id = $food->id;
                    $food_variant->variant_id = $variant;
                    $food_variant->price = (isset($prices[$key]) && $prices[$key] != "null") ? $prices[$key] : 0;
                    $food_variant->save();
                }
            }
        } else {
            $food->hasVariants = 0;
            $food->delivery_price = $request->delivery_price;
            $food->pickup_price = $request->pickup_price;
        }
        $food->collections = json_encode($request->collection);
        $food->save();

        if (isset($request->is_allergens_accept) && $request->is_allergens_accept == "on") {
            if (isset($request->confirm) && $request->confirm == "on") {
                $food->is_allergens_accept = 1;
                $food->cereal = json_encode($request->cereal);
                $food->nuts = json_encode($request->nuts);
                $food->furthers = json_encode($request->furthers);
            }
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $manager = new ImageManager(Driver::class);
            $oldPath = public_path('uploads/menu/' . $food->image);
            $image = $manager->read($file);
            $filename = uniqid('menu_') . '.' . $file->getClientOriginalExtension();
            $image->resize(400, 400)->save(public_path('uploads/menu/' . $filename));
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $food->image = $filename;
        }

        $food->save();
        return redirect()->route('vendor.all.foods')->with(['alert-type' => 'success', 'message' => 'Successfully added new food.']);
    }
    public function getCollectionByCategory(Request $request)
    {
        $category_id = $request->category;
        if (isset(Auth::user()->id)) {
            $collections = collections::where('vendor_id', Auth::user()->id)->where('category_id', $category_id)->where('status', 1)->get();
            return response()->json(['status' => true, 'message' => 'Successfully fetched', 'data' => $collections]);
        } else {
            return response()->json(['status' => false, 'message' => 'You are not logged in']);
        }
    }
    public function getVariantByCategory(Request $request)
    {
        $category_id = $request->category;
        if (isset(Auth::user()->id)) {
            $variants = CategoryVariant::where('vendor_id', Auth::user()->id)->where('category_id', $category_id)->where('status', 1)->get();
            return response()->json(['status' => true, 'message' => 'Successfully fetched', 'data' => $variants]);
        } else {
            return response()->json(['status' => false, 'message' => 'You are not logged in']);
        }
    }
    public function delete($food_id)
    {
        $id = Auth::user()->id;
        $food = food_item::where('id', $food_id)->where('vendor_id', $id)->first();

        if (!empty($food)) {
            $oldPath = public_path('uploads/menu/' . $food->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $food->delete();
            return redirect()->route('vendor.all.foods')->with(['alert-type' => 'success', 'message' => 'Food deleted successfully!']);
        } else {
            return redirect()->route('vendor.all.foods')->with(['alert-type' => 'error', 'message' => 'Food not found!']);
        }
    }

    public function ediFood($food_id)
    {
        $id = Auth::user()->id;
        $categories = category::orderBy('name', 'ASC')->get();
        $food = food_item::where('id', $food_id)->where('vendor_id', $id)->with('variants')->first();
        $allergens = Allergen::where('vendor_id', Auth::user()->id)->where('status', 1)->orderBy('type', 'ASC')->get();
        $food_category = '';
        $variants = '';
        if (!empty($food)) {
            $variants = CategoryVariant::where('vendor_id', Auth::user()->id)->where('category_id', $food->category_id)->where('status', 1)->get();
            $food_category = category::where('id', $food->category_id)->where('vendor_id', $id)->first();
        }
        $collections = collections::where('vendor_id', Auth::user()->id)->where('category_id', $food->category_id)->where('status', 1)->orderBy('name', 'ASC')->get();
        if (!empty($food)) {
            return view('vendor.foods.edit-food-items', compact('categories', 'food', 'collections', 'food_category', 'variants', 'allergens'));
        } else {
            return redirect()->route('vendor.all.foods')->with(['alert-type' => 'error', 'message' => 'Food not found!']);
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $id = Auth::user()->id;
        $request->validate([
            'id' => 'required|exists:food_items,id',
            'food_name' => 'required',
            'category' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'item_type' => 'required|string',
            'item_types' => 'nullable|array',
            'external_id' => 'nullable',
            'variants' => 'nullable|array',
            'variants.*' => 'nullable|exists:category_variants,id',
            'prices' => 'nullable|array',
            'status' => 'nullable|array',
            'cereal' => 'nullable|array',
            'nuts' => 'nullable|array',
            'furthers' => 'nullable|array',
            'is_allergens_accept' => 'nullable',
            'confirm' => 'nullable',
            'collection' => 'nullable|array',
        ]);

        $food = food_item::where('vendor_id', $id)->where('id', $request->id)->first();
        if (!empty($food)) {
            $food->food_item_name = $request->food_name;
            $food->category_id = $request->category;
            $food->vendor_id = $id;
            $food->description = $request->description;
            $food->is_available = 1;
            $food->delivery_price = 0;
            $food->pickup_price = 0;
            $food->item_type = $request->item_type;
            $food->types = json_encode($request->item_types ?? []);
            $food->external_id = $request->external_id;
            if ($request->has('variants') && count($request->variants) > 0) {
                $food->hasVariants = 1;
                $variants = $request->variants;
                $prices = $request->prices;
                $status = $request->status;
                $existingVariants = foodVariant::where('food_id', $food->id)->get()->keyBy('variant_id');
                $processedVariantIds = [];
                foreach ($variants as $key => $variant) {
                    if (isset($status[$variant][0]) && $status[$variant][0] == "on") {
                        $processedVariantIds[] = $variant;
                        if ($existingVariants->has($variant)) {
                            $food_variant = $existingVariants->get($variant);
                            $food_variant->price = (isset($prices[$variant]) && $prices[$variant] != "null") ? $prices[$variant] : 0;
                            $food_variant->save();
                        } else {
                            $new_variant = new foodVariant();
                            $new_variant->food_id = $food->id;
                            $new_variant->variant_id = $variant;
                            $new_variant->price = (isset($prices[$variant]) && $prices[$variant] != "null") ? $prices[$variant] : 0;
                            $new_variant->save();
                        }
                    }
                }
                $variantsToDelete = $existingVariants->keys()->diff($processedVariantIds);
                if ($variantsToDelete->isNotEmpty()) {
                    foodVariant::where('food_id', $food->id)
                        ->whereIn('variant_id', $variantsToDelete)
                        ->delete();
                }
            } else {
                $food->hasVariants = 0;
                $food->delivery_price = $request->delivery_price;
                $food->pickup_price = $request->pickup_price;
                foodVariant::where('food_id', $food->id)->delete();
            }

            $food->save(); // Save the food model updates

            $food->collections = json_encode($request->collection);
            $food->save();

            if (isset($request->is_allergens_accept) && $request->is_allergens_accept == "on") {
                if (isset($request->confirm) && $request->confirm == "on") {
                    $food->is_allergens_accept = 1;
                    $food->cereal = json_encode($request->cereal);
                    $food->nuts = json_encode($request->nuts);
                    $food->furthers = json_encode($request->furthers);
                }
            }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $manager = new ImageManager(Driver::class);
                $oldPath = public_path('uploads/menu/' . $food->image);
                $image = $manager->read($file);
                $filename = uniqid('menu_') . '.' . $file->getClientOriginalExtension();
                $image->resize(400, 400)->save(public_path('uploads/menu/' . $filename));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $food->image = $filename;
            }
            $food->save();
            return redirect()->route('vendor.all.foods')->with(['alert-type' => 'success', 'message' => 'Successfully update food.']);
        } else {

            return redirect()->route('vendor.all.foods')->with(['alert-type' => 'error', 'message' => 'Food not found!']);
        }
    }
    public function menuAvailable(Request $request)
    {
        if (isset(Auth::user()->id)) {
            $menu = food_item::where('vendor_id', Auth::user()->id)->where('id', $request->id)->first();
            if ($menu) {
                $menu->is_available = $request->value;
                $menu->save();
                return response()->json(['success' => true, 'message' => 'Status Changed.']);
            } else {

                return response()->json(['success' => false, 'message' => 'menu not found.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Please login first.']);
        }
    }
    public function allOrders(Request $request)
{
    if (isset(Auth::user()->id)) {

        $query = Order::where('vendor_id', Auth::user()->id)
            ->with('order_items.food');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date,
                $request->end_date
            ]);
        }

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('method_type')) {
            $query->where('method_type', $request->method_type);
        }

        // 🔥 Pagination (10 orders per page)
        $orders = $query->latest()->paginate(9);

        // Keep filters while paginating
        $orders->appends($request->all());

        return view('vendor.order.all-my-orders', compact('orders'));
    } else {
        return back()->with([
            'alert-type' => 'error',
            'message' => 'Please login first.'
        ]);
    }
}

private function getOrderStatusNotification($status, $orderCode)
{
    return match ($status) {
        'confirmed' => [
            'title' => 'Order Confirmed ✅',
            'message' => "Your order #{$orderCode} has been confirmed by the restaurant."
        ],
        'preparing' => [
            'title' => 'Preparing Your Order 👨‍🍳',
            'message' => "Your order #{$orderCode} is being prepared."
        ],
        'out_for_delivery' => [
            'title' => 'Out for Delivery 🚚',
            'message' => "Your order #{$orderCode} is on the way."
        ],
        'delivered' => [
            'title' => 'Order Delivered 🎉',
            'message' => "Your order #{$orderCode} has been delivered. Enjoy!"
        ],
        'cancelled' => [
            'title' => 'Order Cancelled ❌',
            'message' => "Your order #{$orderCode} has been cancelled."
        ],
        default => null
    };
}
public function orderStatus(Request $request)
{
    if (!Auth::check()) {
        return response()->json(['status' => false, 'message' => 'Please login first.']);
    }

    $order = Order::where('vendor_id', Auth::id())
        ->where('id', $request->id)
        ->first();

    if (!$order) {
        return response()->json(['status' => false, 'message' => 'Order not found.']);
    }

    // Prevent duplicate updates
    if ($order->order_status === $request->status) {
        return response()->json(['status' => true, 'message' => 'Status already updated.']);
    }

    $order->order_status = $request->status;
    $newStatus=$request->status;
    switch($newStatus) {
        case 'confirmed':
            $order->confirmed_at = now();
            break;
        case 'preparing':
            $order->preparing_at = now();
            break;
        case 'out_for_delivery':
            $order->out_for_delivery_at = now();
            break;
        case 'delivered':
            $order->delivered_at = now();
            break;
        case 'cancelled':
            $order->cancelled_at = now();
            break;
    }
    $order->save();

    // -----------------------------
    // SEND USER NOTIFICATION
    // -----------------------------
    $notification = $this->getOrderStatusNotification($request->status, $order->order_code);

    if ($notification) {
        $this->sendOrderNotification(
            $order->user_id,
            $notification['title'],
            $notification['message'],
            'order_status'
        );
    }

    return response()->json(['status' => true, 'message' => 'Status Changed.']);
}

    public function orderStatusOld(Request $request)
    {
        if (isset(Auth::user()->id)) {
            $order = Order::where('vendor_id', Auth::user()->id)->where('id', $request->id)->first();
            if ($order) {
                $order->order_status = $request->status;
                $order->save();
                return response()->json(['status' => true, 'message' => 'Status Changed.']);
            } else {

                return response()->json(['status' => false, 'message' => 'Order not found.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please login first.']);
        }
    }
    public function orderView($id)
    {
        if (isset(Auth::user()->id)) {
            $order = Order::where('vendor_id', Auth::user()->id)->with('user', 'order_items.food')->where('id', $id)->first();
            // dd($order->order_code);
            $payment = Payment::where('order_code', $order->order_code)->latest()->first();

            if ($order) {
                return view('vendor.order.order_view', compact('order', 'payment'));
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Order not found.']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function payments()
    {
        if (isset(Auth::user()->id)) {
            $payments = Payment::where('vendor_id', Auth::user()->id)->with('user')->latest()->get();
            return view('vendor.payment.all-my-payments', compact('payments'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function revenues(Request $request)
    {
        if (isset(Auth::user()->id)) {
            $vendor = vendor_detail::where('vendor_id', Auth::user()->id)->first();
            $query = Order::where('vendor_id', Auth::user()->id)->with('order_items');
            if ($request->has('start_date') && $request->filled('start_date') && $request->has('end_date') && $request->filled('end_date')) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            }

            if ($request->has('method_type') && !empty($request->method_type)) {
                $query->where('method_type', $request->method_type);
            }
            $orders = $query->where('order_status', 'delivered')->where('payment_status', '1')->latest()->get();

            $totalAmount = $totalDeliveryCharge = $totalDiscounts = 0;
            $totalCommission = $totalPaypalCommission = $totalCreditCardCommission = 0;

            foreach ($orders as $order) {
                $totalAmount += $order->total_amount;
                $totalDeliveryCharge += $order->delivery_price;
                $totalDiscounts += $order->discount;

                $orderTotal = $order->total_amount + $order->delivery_price;
                if ($vendor->commission_fixed) {
                    $commission = $vendor->commission_fixed;
                } else {
                    $commission = ($vendor->commission / 100) * $orderTotal;
                }
                $totalCommission += $commission;
                if ($order->payment_method === 'paypal') {
                    if ($vendor->paypal_commission_fixed) {
                        $paypalCommission = $vendor->paypal_commission_fixed;
                    } else {
                        $paypalCommission = ($vendor->paypal_commission / 100) * $orderTotal;
                    }
                    $totalPaypalCommission += $paypalCommission;
                }

                if ($vendor->credit_card_commission_fixed && $order->payment_method === 'card_payment') {
                    $creditCardCommission = $vendor->credit_card_commission_fixed;
                } else {
                    $creditCardCommission = ($vendor->credit_card_commission / 100) * $orderTotal;
                }
                $totalCreditCardCommission += $creditCardCommission;
            }
            $finalCommissionFormatted = $totalCommission + $totalPaypalCommission + $totalCreditCardCommission;
            $totalEarnings = ($totalAmount + $totalDeliveryCharge) - $finalCommissionFormatted;
            return view('vendor.payment.revenue', compact('orders', 'vendor', 'totalAmount', 'totalDeliveryCharge', 'totalPaypalCommission', 'totalCreditCardCommission', 'totalCommission', 'finalCommissionFormatted', 'totalDiscounts'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function updateSortOrder(Request $request)
    {

        $order = $request->order;
        foreach ($order as $item) {
            $food = food_item::where('id', $item['id'])->first();
            if ($food) {
                $food->sort = $item['position'];
            }
            $food->save();
        }

        return response()->json(['success' => true]);
    }

    public function generateOrderPDF($id)
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $order = Order::with('user', 'vendor.vendor_details', 'order_items.foodData')
                ->where('id', $id)
                ->first();

            if ($order && $order->vendor_id == $userId) {
                $payment = Payment::where('order_code', $order->order_code)->latest()->first();
                $formattedOrderId = 'L' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
                $timestamp = now()->format('Ymd_His');
                $fileName = "Order_{$formattedOrderId}_{$timestamp}.pdf";
                $vendor = $order->vendor;
                
                $pdf = Pdf::loadView('pdfs.order', compact('order', 'vendor'));
                return $pdf->download($fileName);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Unauthorized access.']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
}
