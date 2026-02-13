<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background-color: #f41909;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
        }

        .content h2 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .order-details {
            margin-bottom: 20px;
        }

        .order-details th,
        .order-details td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .order-details th {
            background-color: #f41909;
            color: #ffffff;
        }

        .order-summary {
            margin-top: 20px;
        }

        .order-summary p {
            margin: 5px 0;
            font-size: 16px;
        }

        .footer {
            background-color: #f41909;
            color: #ffffff;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }} - Order Confirmation</h1>
        </div>
        <div class="content">
            <h2>Thank you for dining with us!</h2>
            <p>Your order has been successfully placed. Here are the details:</p>
            <table class="order-details" width="100%">
                <tr>
                    <th>Food Item</th>
                    <th>Quantity</th>
                </tr>

                @foreach ($order->items as $item)
                    <tr>
                        <td>
                            {{ $item->food_item_name }}

                            @if (isset($item->variant))
                                ({{ $item->variant }})
                            @endif
                            <span class="badge bg-primary">{{ $item->dressing }}</span>
                            <div>
                                @php
                                    $extra_toppings = json_decode(
                                        isset($item->extras) && $item->extras != null && $item->extras != ''
                                            ? $item->extras
                                            : json_encode([]),
                                    );

                                    echo '
                                    <div class="mb-3">
                                    ';
                                    echo '<ol>';
                                    foreach ($extra_toppings as $extra_topping) {
                                        echo '<li style="font-size:11px" class=" text-capitalize ">' .
                                            $extra_topping->name .
                                            '</li>';
                                    }
                                    echo '
                                     </div>
                                    </ol>
                                    ';
                                @endphp

                            </div>
                        </td>
                        <td>{{ $item->quantity }} Qty</td>

                    </tr>
                @endforeach

            </table>
            <div class="order-summary">
                <p><strong>Order Number:</strong> #{{ $order->order_code }}</p>
                <p><strong>{{ isset($order->method) && $order->method == 'delivery' ? 'Delivery Charge' : 'Pickup Charge' }}:</strong>
                    {{ $order->delivery_cost }}</p>
                <p><strong>Discount:</strong> {{ number_format($order->discount,2)}}</p>
                <p><strong>Total Amount:</strong> {{ number_format($order->amount + $order->delivery_cost,2) }}</p>
                <p><strong>Payment Method:</strong> {{ $order->payment_method }} </p>
            </div>
        </div>
        <div class="footer">
            <p>Thank you for choosing {{ config('app.name') }}!</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
