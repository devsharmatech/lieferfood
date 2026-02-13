<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Payout;
use App\Models\User;
use App\Models\vendor_detail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    //
    public function ladger()
    {
        $payments = Payment::with('user', 'vendor')->latest()->get();
        return view('admin.payment.ladger-payment', compact('payments'));
    }
    public function revenues($vid, Request $request)
    {
        if (isset($vid)) {
            $vendor = vendor_detail::where('vendor_id', $vid)->first();
            $query = Order::where('vendor_id', $vid)->with('order_items');
            
            if ($request->has('start_date') && $request->filled('start_date') && $request->has('end_date') && $request->filled('end_date')) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            }

            if ($request->has('method_type') && !empty($request->method_type)) {
                $query->where('method_type', $request->method_type);
            }
            
            $orders = $query->where('order_status', 'delivered')->where('payment_status', '1')->latest()->get();

            $totalAmount = $totalDeliveryCharge = $totalDiscounts = $totalOnlinePay = 0;
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
                    $totalOnlinePay += $order->total_amount;
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
            
            return view('admin.payment.profit-and-loss', compact('orders', 'vendor','totalOnlinePay', 'totalAmount', 'totalDeliveryCharge', 'totalPaypalCommission', 'totalCreditCardCommission', 'totalCommission', 'finalCommissionFormatted', 'totalDiscounts'));
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please Choose any vendor.']);
        }
    }
    public function allVendorForRevenue()
    {
        $users = User::latest()->where('role', 'vendor')->get();
        return view('admin.payment.all-vendor-revenue', compact('users'));
    }
    public function generatePayout(Request $request)
    {
        $users = User::latest()->where('role', 'vendor')->get();
        $lastPayoutDate='';
        if (isset($request->shop_id) && $request->shop_id != "") {
            $vid = $request->shop_id;
            
            $vendor = vendor_detail::where('vendor_id', $vid)->first();
            $lastPayout = Payout::where('vendor_id', $vid)->latest()->first();
            $query = Order::where('vendor_id', $vid)->with('order_items');
            if ($lastPayout) {
                $lastPayoutDate = $lastPayout->payment_date;
                $orders = $query->where('order_status', 'delivered')
                    ->where('payment_status', '1')
                    ->where('created_at', '>=', $lastPayoutDate)
                    ->latest()
                    ->get();
            } else {
                $orders = $query->where('order_status', 'delivered')
                    ->where('payment_status', '1')
                    ->latest()
                    ->get();
               $lastOrder = $orders->last(); 
               $lastPayoutDate=$lastOrder->created_at ?? '';
               $lastPayoutDate = date('d M Y',strtotime($lastPayoutDate));
            }
            
            $totalAmount = $totalDeliveryCharge = $totalDiscounts = $totalOnlinePay = 0;
            $totalCommission = $totalPaypalCommission = $totalCreditCardCommission = 0;
            foreach ($orders as $order) {
                
                $totalAmount += $order->total_amount;
                $totalDeliveryCharge += $order->delivery_price;
                $totalDiscounts += $order->discount;

                $orderTotal = $order->total_amount + $order->delivery_price;
                if ($vendor->commission_fixed > 0) {
                    $commission = $vendor->commission_fixed;
                } else {
                    $commission = ($vendor->commission / 100) * $orderTotal;
                }
                
                $totalCommission += $commission;
                if ($order->payment_method === 'paypal') {
                    
                    $totalOnlinePay+=$order->total_amount ?? 0;
                    
                    if ($vendor->paypal_commission_fixed>0) {
                        $paypalCommission = $vendor->paypal_commission_fixed;
                    } else {
                        $paypalCommission = ($vendor->paypal_commission / 100) * $orderTotal;
                    }
                    $totalPaypalCommission += $paypalCommission;
                }

                if ($vendor->credit_card_commission_fixed > 0 && $order->payment_method === 'card_payment') {
                    $creditCardCommission = $vendor->credit_card_commission_fixed;
                } elseif($vendor->credit_card_commission > 0 && $order->payment_method === 'card_payment') {
                    $creditCardCommission = ($vendor->credit_card_commission / 100) * $orderTotal;
                }else{
                    $creditCardCommission=0;
                }
                $totalCreditCardCommission += $creditCardCommission;
            }
            $finalCommissionFormatted = 0;
            $totalEarnings = 0;
            $finalCommissionFormatted = $totalCommission + $totalPaypalCommission + $totalCreditCardCommission;
            $totalEarnings = ($totalAmount + $totalDeliveryCharge) - $finalCommissionFormatted;
            return view('admin.payment.generate-payout', compact('orders', 'vendor','totalOnlinePay','lastPayoutDate', 'totalAmount', 'totalDeliveryCharge', 'totalPaypalCommission', 'totalCreditCardCommission', 'totalCommission', 'finalCommissionFormatted', 'totalDiscounts', 'users'));
        } else {
            $finalCommissionFormatted = 0;
            $totalEarnings = 0;
            $totalAmount = $totalDeliveryCharge = $totalDiscounts = $totalOnlinePay = 0;
            $totalCommission = $totalPaypalCommission = $totalCreditCardCommission = 0;
            $orders = [];
            $vendor = [];
            return view('admin.payment.generate-payout', compact('orders', 'vendor','totalOnlinePay','lastPayoutDate','totalAmount', 'totalDeliveryCharge', 'totalPaypalCommission', 'totalCreditCardCommission', 'totalCommission', 'finalCommissionFormatted', 'totalDiscounts', 'users'));
        }
    }
    public function viewOrder($id)
    {
        if (isset(Auth::user()->id)) {
            $order = Order::with('user', 'vendor.vendor_details', 'order_items.deal.menuItems')->where('id', $id)->first();

            $payment = Payment::where('order_code', $order->order_code)->latest()->first();
            if ($order) {
                return view('admin.payment.order-details', compact('order', 'payment'));
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
            $order = Order::with('user', 'vendor.vendor_details', 'order_items.deal.menuItems')
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

    public function payoutHistory(Request $request)
    {
        $query = Payout::query();
        if ($request->has(['start_date', 'end_date']) && $request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('payment_date', [$request->start_date, $request->end_date]);
        }
        if ($request->filled('shop_id')) {
            $query->where('vendor_id', $request->shop_id);
        }
        $query->orderBy('payment_date', 'desc');
        $payouts = $query->with('vendor', 'invoice')->get();
        $users = User::latest()->where('role', 'vendor')->get();

        return view('admin.payment.payout-history', compact('payouts', 'users'));
    }
    public function payoutDelete($payout_id)
    {
        $payout = Payout::where('id', $payout_id)->with('invoice')->first();
        if ($payout) {
            if (isset($payout->invoice->pdf) && $payout->invoice->pdf != "") {
                $pdfPath = public_path('uploads/pdfs/' . $payout->invoice->pdf);
                if (File::exists($pdfPath)) {
                    File::delete($pdfPath);
                }
            }
            $payout->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Payout successfully deleted.']);
        }
        return back()->with(['alert-type' => 'error', 'message' => 'Payout not found.']);
    }

    public function generateInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:users,id',
            'vendor_name' => 'required|string',
            'vendor_email' => 'required|email',
            'vendor_phone' => 'required|string',
            'vendor_address' => 'required|string',
            'bank_name' => 'required|string',
            'account_holder' => 'required|string',
            'order_from' => 'required|date',
            'order_till' => 'required|date',
            'account_number' => 'required|string',
            'ifsc_code' => 'required|string',
            'total_amount' => 'required|numeric',
            'commission' => 'required|numeric',
            'paypalCommission' => 'required|numeric',
            'cardCommission' => 'required|numeric',
            'paypal_amount' => 'nullable|numeric',
            'payout_amount' => 'nullable|numeric',
            'payment_method' => 'nullable|string',
            'transaction_date' => 'nullable|date',
            'transaction_id' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            // dd($validator->errors());
            return back()->withErrors($validator->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Validation failed!']);
        }
        
            $vid=$request->vendor_id;
            $vendor = vendor_detail::where('vendor_id', $vid)->first();
            $vendorData = User::where('id', $request->vendor_id)->first();
            $lastPayout = Payout::where('vendor_id', $vid)->latest()->first();
            $query = Order::where('vendor_id', $vid)->with('order_items');
            $query2 = Order::where('vendor_id', $vid)->with('order_items');
            $query3 = Order::where('vendor_id', $vid)->with('order_items');
            if ($lastPayout) {
                $lastPayoutDate = $lastPayout->payment_date;
                $orders = $query->where('order_status', 'delivered')
                    ->where('payment_status', '1')
                    ->where('created_at', '>=', $lastPayoutDate)
                    ->latest()
                    ->get();
                    
                $all_orders = $query2->whereIn('order_status',['delivered','cancelled'])
                                     ->where('payment_status', '1')
                                     ->where('created_at', '>=', $lastPayoutDate)
                                     ->latest()
                                     ->get();
                    
                $orders_cancelled = $query3->where('order_status', 'cancelled')
                    ->where('payment_status', '1')
                    ->where('created_at', '>=', $lastPayoutDate)
                    ->latest()
                    ->get();
            } else {
                $orders = $query->where('order_status', 'delivered')
                    ->where('payment_status', '1')
                    ->latest()
                    ->get();
                    
                $all_orders = $query2->whereIn('order_status',['delivered','cancelled'])
                    ->where('payment_status', '1')
                    ->latest()
                    ->get();
                    
                $orders_cancelled = $query3->where('order_status', 'cancelled')
                    ->where('payment_status', '1')
                    ->latest()
                    ->get();
            }
        // dd($all_orders);
        
        $payout = Payout::create([
            'vendor_id' => $request->vendor_id,
            'message' => "Payout for vendor {$request->vendor_name}",
            'payout_by' => $request->payment_method,
            'amount' => $request->total_amount,
            'order_from' => $request->order_from,
            'order_till' => $request->order_till,
            'paypal_commission' => $request->paypalCommission,
            'commission' => $request->commission,
            'card_commission' => $request->cardCommission,
            'payout_amount' => $request->payout_amount,
            'payment_date' => now(),
            'payment_detail' => json_encode([
                'transaction_id' => $request->transaction_id,
                'other_charges' => $request->otherCharges ?? 0,
            ]),
            'account_detail' => json_encode([
                'bank_name' => $request->bank_name,
                'account_holder' => $request->account_holder,
                'account_number' => $request->account_number,
                'ifsc_code' => $request->ifsc_code,
            ]),
        ]);

        $invoice = new Invoice();
        $invoice->vendor_id = $request->vendor_id;
        $invoice->payout_id = $payout->id;
        $invoice->save();
        $formattedPayoutId = 'PY-'.str_pad($payout->id, 5, '0', STR_PAD_LEFT);
        // $formattedInvoiceId = str_pad($invoice->id, 7, '0', STR_PAD_LEFT);
        $formattedInvoiceId = 'RE-'.str_pad($invoice->id,5, '0', STR_PAD_LEFT);
        $netPay = ($request->total_amount ?? 0) -
            (($request->commission ?? 0) +
                ($request->paypalCommission ?? 0) +
                ($request->cardCommission ?? 0) +
                ($request->otherCharges ?? 0));;
        if ($vendor->commission_fixed!="" && $vendor->commission_fixed>0) {
          $commission = $vendor->commission_fixed."€";
        } else {
          $commission = $vendor->commission.'%';
        }            
        
        if ($vendor->paypal_commission_fixed!="" && $vendor->paypal_commission_fixed>0) {
          $paypalCommission = $vendor->paypal_commission_fixed."€";
        } else {
          $paypalCommission = $vendor->paypal_commission.'%';
        }
        
        if ($vendor->credit_card_commission_fixed!="" && $vendor->credit_card_commission_fixed>0) {
          $creditCardCommission = $vendor->credit_card_commission_fixed."€";
        } else {
          $creditCardCommission = $vendor->credit_card_commission.'%';
        }
        
        $data = [
            'commission_h'=>$commission,
            'paypalCommission_h'=>$paypalCommission,
            'creditCardCommission_h'=>$creditCardCommission,
            'company' => 'Lieferfood',
            'company_address' => 'Raiffeisenstrasse 16 <br> 64347 Griesheim <br> Germany',
            'company_email' => 'support@lieferfood.de',
            'company_phone' => '+49 179 6756786',
            'vendor_name' => $request->vendor_name,
            'vendor_id' => $vendor->vendor_id,
            'vendor_email' => $vendor->company_email,
            'vendor_phone' => $vendor->company_phone,
            'shop_name' => $vendorData->name ?? null,
            'vendor_street' => $vendor->company_street ?? '',
            'vendor_country' => $vendorData->country,
            'vendor_state' => $vendorData->state,
            'vendor_city' => $vendorData->city,
            'vendor_zipcode' => $vendorData->zipcode,
            'gst_number' => $vendor->gst_number,
            'pan_number' => $vendor->pan_number,
            'bank_name' => $request->bank_name,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
            'total_amount' => $request->total_amount,
            'order_from' => $request->order_from,
            'order_till' => $request->order_till,
            'commission' => $request->commission,
            'paypal_commission' => $request->paypalCommission,
            'card_commission' => $request->cardCommission,
            'payout_amount' => $request->payout_amount ?? 0,
            'paypal_amount' => $request->paypal_amount ?? 0,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'other_charges' => $request->otherCharges,
            'net_payout' => $netPay,
            'payment_date' => $request->payment_date,
            'transaction_date' => $request->transaction_date,
            'payout_id' => $formattedPayoutId,
            'invoice_id' => $formattedInvoiceId,
            'orders' => $orders,
            'orders_cancelled' => $orders_cancelled,
            'all_orders' =>$all_orders,
        ];
        // dd($data);
        $data = json_decode(json_encode($data));
        $uniqueFileName = 'invoice_' . uniqid() . '.pdf';
        $pdfPath = 'uploads/pdfs/' . $uniqueFileName;
        $pdf = Pdf::loadView('pdfs.invoice-vendor', ['invoice' => $data,'orders'=>$orders]);
        $pdf->save(public_path($pdfPath));
        
        $invoice->pdf = $uniqueFileName;
        $invoice->save();
        Mail::send('mail.payout-invoice', ['vendor_name' => $data->vendor_name], function ($message) use ($vendorData, $data, $pdfPath) {
            $message->to([$vendorData->email, $data->company_email])
                ->subject('Your Payout Invoice')
                ->attach(public_path($pdfPath));
        });
        return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Payout Invoice Generated Successfully!']);
    }
}
