<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            position: relative;
        }

        @page {
            /*margin: 15px;*/
            size: auto;
        }

        .container {
            width: 100%;
            padding: 0%;
            margin: 0%;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            color: #000;
            margin: 0;
            margin-top: 10px !important;
        }

        .order-info,
        .vendor-info {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .order-info td,
        .vendor-info td {
            padding: 5px;
            border: 1px solid #2c2c2c;
             font-size: 13px;
        }

        .order-info th,
        .vendor-info th {
            background: #f7f7f7;
            color: #000;
            border: 1px solid #2c2c2c;
            padding: 5px;
            text-align: left;
             font-size: 13px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #2c2c2c;
            padding: 10px;
            text-align: left;
             font-size: 13px;
        }

        .items-table th {
            background: #f7f7f7;
            color: #000;
             font-size: 13px;
        }
        ol{
            margin-left: 20px;
            padding-left: 0px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: gray;
        }

        .watermark {
            position: absolute;
            top: 40%;
            left: 30%;
            font-size: 50px;
            color: rgba(0, 0, 0, 0.1);
            transform: rotate(-30deg);
            z-index: -1;
        }
    </style>
</head>

<body>

    <!-- Watermark -->
    <div class="watermark">{{ env('APP_NAME') ?? 'Lieferfood' }}</div>

    <div class="container">
        <!-- Header -->
        <div style="width:100%;display:flex; text-align:center;">
            <img src="{{public_path('uploads/logo/logo5.png')}}" height="70"/>
        </div>
        <div class="header">
            <h2>Order Info</h2>
        </div>

        <!-- Order Details -->
        <table class="order-info">
            <tr>
                <th style="width:50%;">Customer Delivery Details</th>
                <th style="width:50%;">Shop / Restaurant Details</th>
            </tr>
            <tr>
                <td>{{ $order->user->name ?? '' }}</td>
                <td>{{ $vendor->name }}</td>
            </tr>
            <tr>
                <td>
                     
                    @if (isset($order->address) && json_decode($order->address) != null)
                        @php
                            $address = json_decode($order->address);
                        @endphp
                        
                            <span>
                                {{ isset($address->street) ? $address->street : '' }}</span>
                            <span>
                                {{ isset($address->house_number) ? $address->house_number : '' }}
                            </span>
                            
                    @endif
                </td>
                
                <td>{{ $vendor->address }}</td>
            </tr>
            <tr>
                <td>
                     
                    @if (isset($order->address) && json_decode($order->address) != null)
                        @php
                            $address = json_decode($order->address);
                        @endphp
                        
                           
                            <span>
                                {{ (isset($address->postal_code) && $address->postal_code!="") ? $address->postal_code : '' }}
                                {{ (isset($address->city) && $address->city!="") ? $address->city : '' }}
                                {{ (isset($address->state) && $address->state!="") ? $address->state : '' }}
                                {{ (isset($address->neighborhood) && $address->neighborhood!="") ? $address->neighborhood : '' }}

                            </span>
                    @endif
                </td>
                <td>{{$vendor->zipcode ?? ''}} {{$vendor->city ?? ''}}</td>
            </tr>
            <tr>
                <td>{{ $order->user->phone ?? '' }}</td>
                <td>{{ $vendor->phone }}</td>
            </tr>
            
            
            <tr>
                <td>Delivery Time: {{ $order->custome_time ?? '' }}</td>
                <td>{{ $vendor->email }}</td>
            </tr>
            <tr>
                
                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                <td>{{ $vendor->vendor_details->shop_url ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Order No: A{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td></td>
            </tr>
            <tr>
                <td>Payment Method: {{ $order->payment_method }}</td>
                <td></td>
            </tr>
        </table>

        <!-- Order Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Quantity</th>
                    <th>Product Code</th>
                    <th>Article Name</th>
                    <th>Extras</th>
                    <th>Unit Price</th>
                    <th>Extras Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($order->order_items as $item)
                    <tr>
                        <td>
                            {{ $item->quantity }} X
                        </td>
                         <td>
                            {{ $item->foodData->external_id ?? '' }}
                        </td>
                        <td>
                            {{ $item->food_item_name }} ({{ $item->variant }})
                        </td>
                       
                        <td>
                            @php
                                $extra_toppings = json_decode(
                                    isset($item->extras) && $item->extras != null && $item->extras != ''
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
                                $extraCost = $extrapric * $item->quantity;
                                $foodCost = $item->price * $item->quantity;
                                $totalOrderItemCost = $foodCost + $extraCost;
                            @endphp
                        </td>
                        
                        <td style="text-align: right;">
                            {{ $foodCost }}€
                        </td>
                        <td style="text-align: right;">
                            {{ number_format($extraCost,2) }}€
                        </td>
                        <td style="text-align: right;">
                            {{ $totalOrderItemCost }}€
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="2">Total Amount</th>
                    <td colspan="3"></td>
                    <td colspan="2" style="text-align: right;">
                        {{ $order->total_amount + $order->discount ?? '0.00' }}€
                    </td>
                </tr>
                <tr>
                    <th colspan="2">Delivery Amount</th>
                    <td colspan="3"></td>
                    <td colspan="2" style="text-align: right;">
                        + {{ $order->delivery_price ?? '0.00' }}€
                    </td>
                </tr>
                <tr>
                    <th colspan="2">Discount</th>
                    <td colspan="3"></td>
                    <td colspan="2" style="text-align: right;">
                       - {{ $order->discount ?? '0.00' }}€
                    </td>
                </tr>
                <tr>
                    <th colspan="2">Service Charge</th>
                    <td colspan="3"></td>
                    <td colspan="2" style="text-align: right;">
                        + {{ '0.00' }}€
                    </td>
                </tr>
                <tr>
                    <th colspan="2">Final Amount</th>
                    <td colspan="3"></td>
                    <td colspan="2" style="text-align: right;">
                        {{ $order->total_amount ?? '0.00' }}€
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your order! If you have any questions, please contact us.</p>
        </div>
        @if($order->payment_method=="paypal")
          <h4 style="text-align:center; width:100%;">Customer has already paid online!</h4>
        @elseif($order->payment_method=="cash")
          <h4 style="text-align:center; width:100%;">Customer pay in cash!</h4>
        @else
          <h4 style="text-align:center; width:100%;">Customer pay by card!</h4>
        @endif
    </div>

</body>

</html>
