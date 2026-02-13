@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Order Detail)
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-center">
                        <h5 class=" py-0">
                            Order Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-uppercase fs-5 mb-2">Vendor Details</h5>
                                <ol class="px-0">
                                    <li class="d-flex gap-2 flex-wrap my-0 py-0">
                                        <strong>Vendor Name: </strong>
                                        {{ isset($order->vendor->name) ? $order->vendor->name : '' }}
                                    </li>
                                    <li class="d-flex gap-2 flex-wrap my-0 py-0">
                                        <strong>Vendor Email: </strong>
                                        {{ isset($order->vendor->email) ? $order->vendor->email : '' }}
                                    </li>
                                    <li class="d-flex gap-2 flex-wrap my-0 py-0">
                                        <strong>Vendor Phone: </strong>
                                        {{ isset($order->vendor->phone) ? $order->vendor->phone : '' }}
                                    </li>
                                    <li class="d-flex gap-2 flex-wrap mb-0 my-0 py-0">
                                        <strong>Company Name: </strong>
                                        {{ isset($order->vendor->vendor_details->company_name) ? $order->vendor->vendor_details->company_name : '' }}
                                    </li>
                                </ol>
                            </div>
                            <div class="col-md-6">

                                <ol class="px-0">
                                    <li class="d-flex gap-2 flex-wrap my-0 py-0">
                                        <strong>Vendor GST No: </strong>
                                        {{ isset($order->vendor->vendor_details->gst_number) ? $order->vendor->vendor_details->gst_number : '' }}
                                    </li>
                                    <li class="d-flex gap-2 flex-wrap my-0 py-0">
                                        <strong>Pan Card Number: </strong>
                                        {{ isset($order->vendor->vendor_details->pan_number) ? $order->vendor->vendor_details->pan_number : '' }}
                                    </li>

                                </ol>
                            </div>
                            <div class="col-sm-4">
                                <h5 class="text-uppercase fs-5 mb-2">Delivery Address</h5>
                                <div>
                                    @if (isset($order->address) && json_decode($order->address) != null)
                                        @php
                                            $address = json_decode($order->address);
                                        @endphp
                                        <ol class="mx-0 px-2">
                                            <li><strong>Street: </strong>
                                                {{ isset($address->street) ? $address->street : '' }}</li>
                                            <li><strong>House No: </strong>
                                                {{ isset($address->house_number) ? $address->house_number : '' }},
                                            </li>
                                            <li>
                                                <strong>Address: </strong>
                                                {{ isset($address->city) ? $address->city : '' }},
                                                {{ isset($address->state) ? $address->state : '' }},
                                                {{ isset($address->postal_code) ? $address->postal_code : '' }},
                                                {{ isset($address->neighborhood) ? $address->neighborhood : '' }},

                                            </li>

                                        </ol>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <h5 class="text-uppercase fs-5 mb-2">Receiver Details</h5>
                                <div>
                                    @if (isset($order->food_receiver) && json_decode($order->food_receiver) != null)
                                        @php
                                            $receiver = json_decode($order->food_receiver);
                                        @endphp
                                        <ol class="mx-0 px-2">
                                            <li><strong>Name: </strong>
                                                {{ isset($receiver->name) ? $receiver->name : '' }}</li>
                                            <li><strong>Email: </strong>
                                                {{ isset($receiver->email) ? $receiver->email : '' }}</li>
                                            <li><strong>Phone: </strong>
                                                {{ isset($receiver->phone) ? $receiver->phone : '' }}</li>
                                        </ol>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <h5 class="text-uppercase fs-5 mb-2">Payment Details</h5>
                                <div>
                                    <ol class="mx-0 px-2">
                                        <li>
                                            <strong>
                                                Payment Method:
                                            </strong>
                                            @if (isset($order->payment_method) && $order->payment_method == 'cash')
                                                Cash
                                            @elseif (isset($order->payment_method) && $order->payment_method == 'paypal')
                                                PayPal
                                            @endif
                                        </li>
                                        <li>
                                            <strong>
                                                Amount :
                                            </strong>
                                            {{ number_format($order->total_amount) }}
                                        </li>
                                        <li>
                                            <strong>
                                                Payment Status:
                                            </strong>
                                            @if (isset($order->payment_status) && $order->payment_status == '1')
                                                Paid
                                            @elseif (isset($order->payment_status) && $order->payment_status == '2')
                                                Cash Pending
                                            @elseif (isset($order->payment_status) && $order->payment_status == '3')
                                                Cash Received
                                            @elseif (isset($order->payment_status) && $order->payment_status == '0')
                                                Unpaid
                                            @endif
                                        </li>
                                    </ol>
                                    @if (isset($payment))
                                        <ol class="mx-0 px-2">
                                            <li><strong>Payment Date: </strong>
                                                {{ isset($payment->payment_date) ? $payment->payment_date : '' }}</li>
                                            <li><strong>Amount: </strong>
                                                {{ isset($payment->amount) ? $payment->amount : '' }}</li>
                                            <li><strong>Payment Id: </strong>
                                                {{ isset($payment->payment_id) ? $payment->payment_id : '' }}</li>
                                            <li><strong>PayCode: </strong>
                                                {{ isset($payment->order_code) ? $payment->order_code : '' }}</li>
                                        </ol>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="col-sm-4">
                                <h5 class="text-uppercase fs-5 mb-2">Account Details</h5>
                                @if (isset($order->user))
                                    <ol class="px-2">
                                        <li><strong>Name: </strong>{{ $order->user->name }} {{ $order->user->surname }}
                                        </li>
                                        <li><strong>Email: </strong>{{ $order->user->email }} </li>
                                        <li><strong>Phone: </strong>{{ $order->user->phone }}</li>
                                    </ol>
                                @endif
                            </div>
                            <div class="col-sm-12">
                                <h5 class="text-uppercase fs-5 mb-2">Food Items</h5>
                                @if (isset($order->order_items))
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Food Deal</th>
                                                    <th>Food Items</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Total Price</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                @foreach ($order->order_items as $item)
                                                    <tr>
                                                        <td>
                                                            {{ $item->food_item_name }} ({{$item->variant}})
                                                        </td>
                                                        <td>
                                                          
                                                            @php
                                                                $extra_toppings = json_decode(
                                                                    isset($item->extras) &&
                                                                    $item->extras != null &&
                                                                    $item->extras != ''
                                                                        ? $item->extras
                                                                        : json_encode([]),
                                                                );
                                                                $totalPrice = $item->total_price;
                                                                $extrapric=0;
                                                                
                                                                echo '<ol>';
                                                                foreach ($extra_toppings as $extra_topping) {
                                                                    echo '<li style="font-size:12px" class=" text-capitalize ">' .
                                                                        $extra_topping->name .
                                                                        ' - (' .
                                                                        $extra_topping->type .
                                                                        ')</li>';
                                                                }
                                                                echo '</ol>';
                                                            @endphp
                                                        </td>
                                                        <td>
                                                            {{ $item->quantity }} Qty
                                                        </td>
                                                        <td>
                                                            {{ $item->price+$extrapric }}
                                                        </td>
                                                        <td>
                                                            {{ $totalPrice }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
