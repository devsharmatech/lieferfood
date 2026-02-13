<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class allOrderController extends Controller
{
    //
    public function index()
    {
        if (isset(Auth::user()->id)) {
            $orders = Order::with('order_items', 'vendor', 'user')->latest()->get();
            // dd($orders);
            return view('admin.order.all-orders', compact('orders'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function updateStatus(Request $request)
    {
        if (isset(Auth::user()->id)) {
            $order = Order::where('id', $request->id)->first();
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
    public function viewOrder($id)
    {
        if (isset(Auth::user()->id)) {
            $order = Order::with('user', 'vendor.vendor_details', 'order_items.deal.menuItems')->where('id', $id)->first();

            $payment = Payment::where('order_code', $order->order_code)->latest()->first();
            if ($order) {
                return view('admin.order.order_view', compact('order', 'payment'));
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Order not found.']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function generateOrderPDF($id)
    {
        if (Auth::check()) { 
            $userId = Auth::user()->id;
            $order = Order::with('user', 'vendor.vendor_details', 'order_items.foodData')
                          ->where('id', $id)
                          ->first();
        
            if ($order) {
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
