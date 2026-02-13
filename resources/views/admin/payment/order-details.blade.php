@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Order Details)
@endsection
@section('custome_style')
    <style>
        .step {
            flex: 1;
            min-width: 70px;
            /* Adjusts spacing for smaller screens */
        }

        .step-icon {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
        }

        @media (max-width: 576px) {
            .step-icon {
                width: 30px;
                height: 30px;
                font-size: 12px;
            }

            .small {
                font-size: 10px;
            }
        }
    </style>
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
                                            @else
                                                Card Payment (Home)
                                            @endif
                                        </li>
                                        <li>
                                            <strong>
                                                Delivery/Pickup Charge:
                                            </strong>
                                            {{ number_format($order->delivery_price, 2) }}
                                        </li>
                                        <li>
                                            <strong>
                                                Total Amount:
                                            </strong>
                                            {{ number_format($order->total_amount + $order->discount, 2) }}
                                        </li>

                                        <li>
                                            <strong>
                                                Discount :
                                            </strong>
                                            {{ number_format($order->discount, 2) }}
                                        </li>
                                        <li>
                                            <strong>
                                                Payable Amount :
                                            </strong>
                                            {{ number_format($order->total_amount, 2) }}
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
                            <div class="col-sm-4">
                                <a href="{{ route('admin.order.pdf', $order->id) }}"
                                    class="btn btn-primary">Print
                                    Order</a>
                            </div>
                            <div class="col-sm-12">
                                <h5 class="text-uppercase fs-5 mb-2">Food Items</h5>
                                @if (isset($order->order_items))
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Food Item</th>
                                                    <th>Food Extras</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Extra Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->order_items as $item)
                                                    <tr>
                                                        <td>
                                                            {{ $item->food_item_name }} ({{ $item->variant }})
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

                                                                $extrapric = 0;

                                                                echo '<ol>';
                                                                foreach ($extra_toppings as $extra_topping) {
                                                                    $extrapric += $extra_topping->price;
                                                                    echo '<li style="font-size:12px" class=" text-capitalize ">' .
                                                                        $extra_topping->name .
                                                                        '(' .
                                                                        $extra_topping->price .
                                                                        '&euro;)';
                                                                }
                                                                echo '</ol>';
                                                            @endphp
                                                        </td>
                                                        <td>
                                                            {{ $item->quantity }} Qty
                                                        </td>
                                                        <td>
                                                            {{ $item->price }}
                                                        </td>
                                                        <td>
                                                            {{ $extrapric }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                            @php
                                $statuses = ['pending', 'confirmed', 'preparing', 'out_for_delivery', 'delivered'];
                                $currentStatusIndex = array_search($order->order_status, $statuses);
                                $progressPercentage = ($currentStatusIndex / (count($statuses) - 1)) * 100;
                                $isCancelled = $order->order_status == 'cancelled';
                            @endphp

                            <div class="order-stepper rounded mt-4  bg-white">
                                <!-- Progress Bar -->
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar {{ $isCancelled ? 'bg-danger' : 'bg-success' }}"
                                        role="progressbar"
                                        style="width: {{ $isCancelled ? '100%' : $progressPercentage . '%' }};"
                                        aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>

                                <!-- Stepper Steps -->
                                <div class="d-flex justify-content-between mt-2 position-relative flex-wrap">
                                    @foreach ($statuses as $index => $status)
                                        <div class="text-center position-relative step">
                                            <div
                                                class="step-icon d-inline-block p-2 rounded-circle 
                                                   {{ $currentStatusIndex >= $index ? ($isCancelled ? 'bg-danger text-white' : 'bg-success text-white') : 'bg-light text-muted' }}">
                                            </div>
                                            <p
                                                class="small mt-1 {{ $currentStatusIndex >= $index ? 'fw-bold text-dark' : 'text-muted' }}">
                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                                            </p>
                                        </div>
                                    @endforeach

                                    @if ($isCancelled)
                                        <div class="text-center position-relative step">
                                            <div class="step-icon d-inline-block p-2 rounded-circle bg-danger text-white">
                                            </div>
                                            <p class="small mt-1 fw-bold text-danger">Cancelled</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
