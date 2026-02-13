<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
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
            <h1>{{ config('app.name') }} - Payment Confirmation</h1>
        </div>
        <div class="content">
            <h2>Payment Received</h2>
            <p>We have received your payment for order #{{$payment->order_code}}. The details of your payment are as follows:</p>
            <p><strong>Order Number:</strong> #{{$payment->order_code}}</p>
            <p><strong>Discount:</strong> {{number_format($payment->discount,2)}} {{$payment->currency_code}}</p>
            <p><strong>Amount Paid:</strong> {{number_format($payment->amount,2)}} {{$payment->currency_code}}</p>
            <p><strong>Payment Method:</strong> PayPal</p>
            <p><strong>Payment Date:</strong> {{$payment->payment_date}}</p>
            <p>If you have any questions, please feel free to contact us.</p>
        </div>
        <div class="footer">
            <p>Thank you for dining with {{ config('app.name') }}!</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
