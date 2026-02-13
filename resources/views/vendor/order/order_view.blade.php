@extends('vendor.vendor-frame')
@section('custome_style')
    <style>
        /* Base styles */
        .step {
            flex: 1;
            min-width: 70px;
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

        /* Enhanced stepper styles - FIXED COLORS */
        .order-stepper {
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            margin-top: 2rem;
            position: relative;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }

        .stepper-progress-bar {
            height: 10px;
            border-radius: 5px;
            background: #e9ecef;
            position: relative;
            overflow: hidden;
            margin: 35px 0 45px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stepper-progress-fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            border-radius: 5px;
            transition: width 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            background: linear-gradient(90deg, #4e54c8, #8f94fb);
            box-shadow: 0 2px 8px rgba(78, 84, 200, 0.4);
        }

        .stepper-container {
            position: relative;
            z-index: 2;
        }

        /* Fixed step wrapper positioning */
        .step-wrapper {
            position: relative;
            flex: 1;
            min-width: 120px;
            z-index: 2;
        }

        /* Fixed circle positioning - CRITICAL FIX */
        .step-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            color: white !important; /* Force white text on circles */
            border: 5px solid white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            position: absolute;
            top: -60px !important; /* Fixed positioning */
            left: 50%;
            transform: translateX(-50%);
            z-index: 10; /* Higher z-index to appear above progress bar */
        }

        .step-circle.active {
            animation: pulse 2s infinite;
            transform: translateX(-50%) scale(1.05);
        }

        .step-circle.completed {
            background: linear-gradient(135deg, #28a745, #20c997) !important;
        }

        /* Fixed text colors for readability */
        .step-label {
            margin-top: 20px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            text-align: center;
            min-height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #212529 !important; /* Dark color for better readability */
        }

        .step-date {
            font-size: 12px;
            color: #495057 !important; /* Darker gray for better readability */
            margin-top: 6px;
            text-align: center;
            min-height: 32px;
        }

        /* Connector lines fixed */
        .connector-line {
            position: absolute;
            top: -30px;
            left: 50%;
            width: 100%;
            height: 4px;
            background: #dee2e6;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .step-wrapper:first-child .connector-line {
            left: 50%;
            width: 50%;
        }

        .step-wrapper:last-child .connector-line {
            width: 50%;
            left: 0;
        }

        .connector-line.active {
            background: linear-gradient(90deg, #4e54c8, #8f94fb);
            box-shadow: 0 2px 4px rgba(78, 84, 200, 0.3);
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.6);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(40, 167, 69, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
            }
        }

        /* Status-specific colors with gradients - TEXT COLOR FIXED */
        .status-pending { 
            background: linear-gradient(135deg, #dc3545, #ff6b6b) !important;
        }
        .status-confirmed { 
            background: linear-gradient(135deg, #fd7e14, #ffa94d) !important;
        }
        .status-out_for_delivery { 
            background: linear-gradient(135deg, #17a2b8, #39c0d6) !important;
        }
        .status-delivered { 
            background: linear-gradient(135deg, #28a745, #20c997) !important;
        }
        .status-cancelled { 
            background: linear-gradient(135deg, #6c757d, #adb5bd) !important;
        }

        /* Inactive step circles */
        .step-circle.inactive {
            background: linear-gradient(135deg, #adb5bd, #ced4da) !important;
            color: white !important;
        }

        .progress-filled-pending { 
            background: linear-gradient(90deg, #dc3545 0%, #fd7e14 100%);
        }
        .progress-filled-confirmed { 
            background: linear-gradient(90deg, #dc3545 0%, #fd7e14 33%, #17a2b8 100%);
        }
        .progress-filled-out_for_delivery { 
            background: linear-gradient(90deg, #dc3545 0%, #fd7e14 33%, #17a2b8 66%, #28a745 100%);
        }
        .progress-filled-delivered { 
            background: linear-gradient(90deg, #dc3545 0%, #fd7e14 33%, #17a2b8 66%, #28a745 100%);
        }
        .progress-filled-cancelled { 
            background: linear-gradient(90deg, #6c757d 0%, #adb5bd 100%);
        }

        /* Current status display - FIXED TEXT COLORS */
        .current-status-display {
           
            color: white !important; /* Force white text */
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
            box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3);
        }

        .current-status-display h6,
        .current-status-display p,
        .current-status-display strong,
        .current-status-display small {
            color: white !important; /* Force white text */
        }

        .current-status-display .badge {
            color: #212529 !important; /* Dark text on light badge */
        }

        .status-icon {
            font-size: 2.5rem;
            margin-right: 15px;
            opacity: 0.9;
            color: white !important;
        }

        /* Order status header */
        .order-status-header {
           
            color: white !important;
            
            border-radius: 10px 10px 0 0;
            margin-bottom: 20px;
            text-align: center;
        }

        .order-status-header h5 {
            margin: 0;
            font-weight: 600;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
            color: white !important;
        }

        /* Progress percentage text - FIXED COLOR */
        .progress-percentage .display-4 {
            color: #28a745 !important; /* Force green color */
        }
       li{
           color: #000 !important;
       }
        /* Card body text colors fixed */
        .card-body ol li strong,
        .card-body h5,
        .card-body h6,
        .card-body .text-uppercase {
            color: #000 !important; /* Dark color for better readability */
        }

        .card-body .text-muted {
            color: #6c757d !important;
        }

        /* Table text colors fixed */
        .table thead th {
            color: #212529 !important;
            background-color: #f8f9fa;
        }

        .table tbody td {
            color: #212529 !important;
        }

        .table tfoot td {
            color: #212529 !important;
            background-color: #f8f9fa;
        }

        /* Responsive adjustments - FIXED FOR MOBILE */
        @media (max-width: 768px) {
            .step-circle {
                width: 40px;
                height: 40px;
                font-size: 16px;
                top: -50px !important;
                border-width: 4px;
            }
            
            .step-label {
                font-size: 12px;
                min-height: 35px;
                color: #212529 !important;
            }
            
            .order-stepper {
                padding: 20px;
            }
            
            .stepper-progress-bar {
                margin: 30px 0 40px;
            }
            
            .step-wrapper {
                min-width: 90px;
            }
        }

        @media (max-width: 576px) {
            .step-circle {
                width: 35px;
                height: 35px;
                font-size: 14px;
                top: -45px !important;
                border-width: 3px;
            }
            
            .step-label {
                font-size: 10px;
                margin-top: 15px;
                min-height: 30px;
                color: #212529 !important;
            }
            
            .step-date {
                font-size: 10px;
                min-height: 28px;
                color: #495057 !important;
            }
            
            .order-stepper {
                padding: 15px;
            }
            
            .stepper-progress-bar {
                height: 8px;
                margin: 25px 0 35px;
            }
            
            .status-icon {
                font-size: 2rem;
                margin-right: 10px;
            }
            
            .step-wrapper {
                min-width: 80px;
            }
            
            .current-status-display {
                padding: 15px;
            }
            
            .current-status-display .fs-4 {
                font-size: 1.2rem !important;
            }
            
            .progress-percentage .display-4 {
                font-size: 2.5rem !important;
            }
        }

        @media (max-width: 480px) {
            .step-wrapper {
                min-width: 70px;
            }
            
            .step-circle {
                width: 30px;
                height: 30px;
                font-size: 12px;
                top: -40px !important;
                border-width: 3px;
            }
            
            .step-label {
                font-size: 9px;
                margin-top: 12px;
            }
            
            .step-date {
                font-size: 9px;
            }
            
            .stepper-container {
                flex-wrap: wrap;
            }
        }

        /* Ensure progress circles are visible on progress line */
        .stepper-progress-bar-container {
            position: relative;
            width: 100%;
            margin: 35px 0 45px;
        }

        /* Dark mode text compatibility */
        
        .text-dark{
            color:black !important;
        }
    </style>
@endsection

@section('vendor_body')
@php
function formatId($id) {
    $length = strlen((string) $id);
    $totalLength = $length + 1;
    return 'L' . str_pad($id, $totalLength - 1, '0', STR_PAD_LEFT);
}

@endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-center py-2 bg-primary">
                        <h5 class="py-0 mb-0 text-white">
                            <i class="fas fa-receipt me-2"></i>Order Details
                        </h5>
                    </div>
                    <div class="card-body pt-4">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 mb-4">
                                <h5 class="text-capitalize fs-5 mb-2 text-dark">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>Delivery Address
                                </h5>
                                <div>
                                    
                                    @if (isset($order->address) && json_decode($order->address) != null)
                                        @php
                                            $address = json_decode($order->address);
                                            $receiver=json_decode(json_encode([]));
                                        @endphp
                                        
                                         @if (isset($order->food_receiver) && json_decode($order->food_receiver) != null)
                                        @php
                                            $receiver = json_decode($order->food_receiver);
                                        @endphp
                                        
                                    @endif
                                        <ul class="mx-0 px-2">
                                            <li class="mb-1"><strong class="text-dark">Name: </strong>
                                                {{ isset($receiver->name) ? $receiver->name : '' }}</li>
                                            <li class="mb-1"><strong class="text-dark">Street: </strong>
                                                {{ isset($address->street) ? $address->street : '' }}</li>
                                            <li class="mb-1"><strong class="text-dark">House No: </strong>
                                                {{ isset($address->house_number) ? $address->house_number : '' }}
                                            </li>
                                            <li class="mb-1">
                                                <strong class="text-dark">Address: </strong>
                                                {{ isset($address->city) ? $address->city : '' }},
                                                {{ isset($address->state) ? $address->state : '' }}
                                                {{ isset($address->postal_code) ? $address->postal_code : '' }}
                                                {{ isset($address->neighborhood) ? $address->neighborhood : '' }}
                                            </li>
                                             <li class="mb-1"><strong class="text-dark">Phone: </strong>
                                                {{ isset($receiver->phone) ? $receiver->phone : '' }}</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-sm-12 mb-4">
                                <h5 class="text-uppercase fs-5 mb-2 text-dark">
                                    <i class="fas fa-credit-card me-2 text-warning"></i>Payment Details
                                </h5>
                                <div>
                                    <ul class="mx-0 px-2">
                                        <li class="mb-1">
                                            <strong class="text-dark">
                                                Payment Method:
                                            </strong>
                                            @if (isset($order->payment_method) && $order->payment_method == 'cash')
                                                <span class="badge bg-info ms-2">Cash</span>
                                            @elseif (isset($order->payment_method) && $order->payment_method == 'paypal')
                                                <span class="badge bg-primary ms-2">PayPal</span>
                                            @else
                                                <span class="badge bg-success ms-2">Card Payment</span>
                                            @endif
                                        </li>
                                        <li class="mb-1">
                                            <strong class="text-dark">
                                                Delivery/Pickup Charge:
                                            </strong>
                                            <span class="float-end text-dark" style="white-space: nowrap;">{{ number_format($order->delivery_price, 2) }} &euro;</span>
                                        </li>
                                        <li class="mb-1">
                                            <strong class="text-dark">
                                                Total Amount:
                                            </strong>
                                            <span class="float-end text-dark" style="white-space: nowrap;">{{ number_format($order->total_amount+$order->discount, 2) }} &euro;</span>
                                        </li>
                                        
                                        <li class="mb-1">
                                            <strong class="text-dark">
                                                Discount :
                                            </strong>
                                            <span class="float-end text-danger" style="white-space: nowrap;">-{{ number_format($order->discount, 2) }} &euro;</span>
                                        </li>
                                        <li class="mb-1 pt-2 border-top">
                                            <strong class="text-dark">
                                               Payable Amount :
                                            </strong>
                                            <span class="float-end fw-bold text-dark" style="white-space: nowrap;">{{ number_format($order->total_amount, 2) }} &euro;</span>
                                        </li>
                                        <li class="mb-1">
                                            <strong class="text-dark">
                                                Payment Status:
                                            </strong>
                                            @if (isset($order->payment_status) && $order->payment_status == '1')
                                                <span class="badge bg-success ms-2">Paid</span>
                                            @elseif (isset($order->payment_status) && $order->payment_status == '2')
                                                <span class="badge bg-warning ms-2">Cash Pending</span>
                                            @elseif (isset($order->payment_status) && $order->payment_status == '3')
                                                <span class="badge bg-info ms-2">Cash Received</span>
                                            @elseif (isset($order->payment_status) && $order->payment_status == '0')
                                                <span class="badge bg-danger ms-2">Unpaid</span>
                                            @endif
                                        </li>
                                    </ul>
                                    @if (isset($payment))
                                        <div class="mt-3 p-3 bg-light rounded">
                                            <h6 class="mb-2 text-dark">Payment Info:</h6>
                                            <ul class="mx-0 px-2 small">
                                                <li class="mb-1"><strong class="text-dark">Payment Date: </strong>
                                                    {{ isset($payment->payment_date) ? $payment->payment_date : '' }}</li>
                                                <li class="mb-1"><strong class="text-dark">Amount: </strong>
                                                    {{ isset($payment->amount) ? $payment->amount : '' }} &euro;</li>
                                                <li class="mb-1"><strong class="text-dark">Payment Id: </strong>
                                                    {{ isset($payment->payment_id) ? $payment->payment_id : '' }}</li>
                                                <li class="mb-1"><strong class="text-dark">PayCode: </strong>
                                                    {{ isset($payment->order_code) ? $payment->order_code : '' }}</li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <hr class="my-1">
                            
                            
                            
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="d-flex align-items-center h-100">
                                    <a href="{{ route('vendor.generate.order.pdf',$order->id) }}" class="btn btn-primary">
                                        <i class="fas fa-print me-2"></i> Print Order
                                    </a>
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <h5 class="text-uppercase fs-5 mb-2 text-dark">
                                    <i class="fas fa-utensils me-2 text-danger"></i>Food Items
                                </h5>
                                @if (isset($order->order_items))
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-dark"><strong class="text-dark">Qty</strong></th>
                                                    <th class="text-dark"><strong class="text-dark">Food Item</strong></th>
                                                    <!--<th class="text-dark"><strong class="text-dark">Extra Price</strong></th>-->
                                                    <th class="text-dark"><strong class="text-dark">Price</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->order_items as $item)
                                                    <tr>
                                                         <td class="text-dark">
                                                            
                                                               <strong class="text-dark"> {{ $item->quantity }} x</strong>
                                                            
                                                        </td>
                                                        <td class="text-dark">
                                                            <strong class="text-dark">{{ $item->food_item_name }}</strong> 
                                                            
@if(!empty($item->variant))
    <small class="text-muted">({{ $item->variant }})</small>
@endif
<br>
  @php
                                                                $extra_toppings = json_decode(
                                                                    isset($item->extras) &&
                                                                    $item->extras != null &&
                                                                    $item->extras != ''
                                                                        ? $item->extras
                                                                        : json_encode([]),
                                                                );
                                                               
                                                                $extrapric = 0;

                                                                if(count($extra_toppings) > 0) {
                                                                    echo '<ul class="list-unstyled mb-0">';
                                                                    foreach ($extra_toppings as $extra_topping) {
                                                                        $extrapric += $extra_topping->price;
                                                                        echo '<li class="text-capitalize small text-dark">';
                                                                        echo '<i class="fas fa-plus text-dark me-1"></i>';
                                                                        echo $extra_topping->name . ' ('.number_format($extra_topping->price, 2).'&euro;)';
                                                                        echo '</li>';
                                                                    }
                                                                    echo '</ul>';
                                                                } else {
                                                                    echo '';
                                                                }
                                                            @endphp
                                                        </td>
                                                        
                                                       
                                                        
                                                        <td class="text-dark">
                                                            <strong class="text-dark" style="white-space: nowrap;">
                                                                @if($item->price>0)
                                                                {{ number_format($item->price, 2) }} &euro;
                                                                @else
                                                                {{ number_format($item->food->delivery_price ?? 0, 2) }} &euro;
                                                                @endif
                                                            </strong>
                                                                @if($extrapric>0)
                                                                <br>
                                                                <strong class="text-dark" style="white-space: nowrap;">{{ number_format($extrapric, 2) }} &euro;</strong>
                                                                @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="table-light">
                                                <tr>
                                                    <td colspan="2" class="text-end text-dark"><strong>Subtotal:</strong></td>
                                                    <td class="text-dark"><strong style="white-space: nowrap;">{{ number_format($order->total_amount+$order->discount, 2) }} &euro;</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="text-end text-dark"><strong>Delivery Charge:</strong></td>
                                                    <td class="text-dark"><strong style="white-space: nowrap;">{{ number_format($order->delivery_price, 2) }} &euro;</strong></td>
                                                </tr>
                                                @if($order->discount > 0)
                                                <tr>
                                                    <td colspan="2" class="text-end text-danger"><strong>Discount:</strong></td>
                                                    <td class="text-danger"><strong style="white-space: nowrap;">-{{ number_format($order->discount, 2) }} &euro;</strong></td>
                                                </tr>
                                                @endif
                                                <tr class="table-active">
                                                    <td colspan="2" class="text-end text-dark"><strong>Total Payable:</strong></td>
                                                    <td class="text-dark"><strong class="fs-5" style="white-space: nowrap;">{{ number_format($order->total_amount, 2) }} &euro;</strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @endif
                            </div>
                            
                            @php
                                $statuses = [
                                    'pending' => [
                                        'label' => 'New Order',
                                        'icon' => 'fas fa-clock',
                                        'color' => '#dc3545'
                                    ],
                                    'confirmed' => [
                                        'label' => 'Confirmed',
                                        'icon' => 'fas fa-check-circle',
                                        'color' => '#fd7e14'
                                    ],
                                    'out_for_delivery' => [
                                        'label' => 'On the Way',
                                        'icon' => 'fas fa-truck',
                                        'color' => '#17a2b8'
                                    ],
                                    'delivered' => [
                                        'label' => 'Delivered',
                                        'icon' => 'fas fa-home',
                                        'color' => '#28a745'
                                    ],
                                    'cancelled' => [
                                        'label' => 'Cancelled',
                                        'icon' => 'fas fa-times-circle',
                                        'color' => '#6c757d'
                                    ]
                                ];

                                $statusOrder = ['pending', 'confirmed', 'out_for_delivery', 'delivered'];
                                $currentStatus = $order->order_status;
                                $isCancelled = $currentStatus === 'cancelled';
                                
                                // Get status index for progress calculation
                                $currentStatusIndex = array_search($currentStatus, $statusOrder);
                                if ($currentStatusIndex === false && !$isCancelled) {
                                    $currentStatusIndex = 0;
                                }
                                
                                // Calculate progress percentage
                                $progressPercentage = $isCancelled ? 100 : ($currentStatusIndex !== false 
                                    ? (($currentStatusIndex + 1) / count($statusOrder)) * 100 
                                    : 0);
                                
                                // Get progress color class
                                $progressClass = 'progress-filled-' . ($isCancelled ? 'cancelled' : $currentStatus);
                                
                                // Status timeline dates
                                $statusDates = [
                                    'pending' => $order->created_at->format('M d, Y - h:i A'),
                                    'confirmed' => $order->confirmed_at ? \Carbon\Carbon::parse($order->confirmed_at)->format('M d, Y - h:i A') : null,
                                    'out_for_delivery' => $order->out_for_delivery_at ? \Carbon\Carbon::parse($order->out_for_delivery_at)->format('M d, Y - h:i A') : null,
                                    'delivered' => $order->delivered_at ? \Carbon\Carbon::parse($order->delivered_at)->format('M d, Y - h:i A') : null,
                                    'cancelled' => $order->cancelled_at ? \Carbon\Carbon::parse($order->cancelled_at)->format('M d, Y - h:i A') : null,
                                ];
                            @endphp

                            <!-- Order Tracking Stepper -->
                            <div class="col-12 mt-4">
                                <div class="order-status-header bg-primary py-2">
                                    <p class="text-white fs-5 mb-0"><i class="fas fa-shipping-fast me-2"></i> Order Tracking Status</p>
                                </div>
                                
                                <div class="order-stepper">
                                    <!-- Progress Bar Container -->
                                    <div class="stepper-progress-bar-container">
                                        <!-- Progress Bar -->
                                        <div class="stepper-progress-bar">
                                            <div class="stepper-progress-fill {{ $progressClass }}" 
                                                 style="width: {{ $progressPercentage }}%"></div>
                                        </div>
                                        
                                        <!-- Stepper Circles -->
                                        <div class="stepper-container d-flex justify-content-between position-relative">
                                            @foreach($statusOrder as $index => $status)
                                                @php
                                                    $isActive = $isCancelled ? false : ($currentStatusIndex !== false && $index <= $currentStatusIndex);
                                                    $isCurrent = $isCancelled ? false : ($status === $currentStatus);
                                                    $isCompleted = $isCancelled ? false : ($currentStatusIndex !== false && $index < $currentStatusIndex);
                                                    $statusClass = 'status-' . $status;
                                                    $statusInfo = $statuses[$status];
                                                @endphp
                                                
                                                <div class="step-wrapper">
                                                    
                                                    
                                                    <!-- Status Circle - FIXED POSITIONING -->
                                                    <div class="step-circle {{ $statusClass }} {{ $isCurrent ? 'active' : '' }} {{ $isCompleted ? 'completed' : '' }} {{ !$isActive ? 'inactive' : '' }}"
                                                         style="color: white !important;">
                                                        @if($isCompleted)
                                                            <i class="fas fa-check"></i>
                                                        @elseif($isCurrent)
                                                            <i class="{{ $statusInfo['icon'] }}"></i>
                                                        @else
                                                            {{ $index + 1 }}
                                                        @endif
                                                    </div>
                                                    
                                                    <!-- Status Label -->
                                                    <div class="step-label {{ $isActive ? 'text-dark fw-bold' : 'text-muted' }}">
                                                        {{ $statusInfo['label'] }}
                                                    </div>
                                                    
                                                    <!-- Status Date -->
                                                    @if($statusDates[$status])
                                                        <div class="step-date {{ $isActive ? 'text-primary fw-bold' : '' }}">
                                                            <i class="fas fa-calendar-alt me-1"></i>
                                                            {{ $statusDates[$status] }}
                                                        </div>
                                                    @else
                                                        <div class="step-date text-muted">
                                                            <i class="fas fa-clock me-1"></i>
                                                            Pending
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                            
                                            <!-- Cancelled Status (if applicable) -->
                                            @if($isCancelled)
                                                <div class="step-wrapper">
                                                    
                                                    <div class="step-circle status-cancelled active">
                                                        <i class="fas fa-times"></i>
                                                    </div>
                                                    <div class="step-label text-dark fw-bold">
                                                        {{ $statuses['cancelled']['label'] }}
                                                    </div>
                                                    @if($statusDates['cancelled'])
                                                        <div class="step-date text-primary fw-bold">
                                                            <i class="fas fa-calendar-alt me-1"></i>
                                                            {{ $statusDates['cancelled'] }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Current Status Display -->
                                    <div class="current-status-display bg-primary py-2">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <div class="status-icon">
                                                @if($isCancelled)
                                                    <i class="fas fa-ban"></i>
                                                @else
                                                    <i class="{{ $statuses[$currentStatus]['icon'] }}"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="mb-1 text-white fs-5">Current Status</p>
                                                <p class="mb-0 fs-4 text-white">
                                                    <strong class="text-white">{{ $statuses[$currentStatus]['label'] }}</strong>
                                                    @if($statusDates[$currentStatus])
                                                        <br>
                                                        <small class="opacity-80 text-white">
                                                            <i class="fas fa-calendar me-1"></i>
                                                            Updated: {{ $statusDates[$currentStatus] }}
                                                        </small>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="ms-auto">
                                                <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                                    Order #{{ formatId($order->id) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Progress Percentage -->
                                    <div class="text-center mt-3">
                                        <div class="progress-percentage">
                                            <span class="display-4 fw-bold" style="color: {{ $isCancelled ? '#6c757d' : $statuses[$currentStatus]['color'] }} !important;">
                                                {{ round($progressPercentage) }}%
                                            </span>
                                            <p class="text-muted mb-0">Order Completion</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Order Tracking Stepper -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection