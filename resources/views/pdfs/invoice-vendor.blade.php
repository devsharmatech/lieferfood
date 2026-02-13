<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_id }}</title>
    <style>
        @page {
            margin: 10px 10px 20px 50px;
        }
       
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 0px;
            position: relative;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            padding: 5px;
            font-size: 13px;
        }

        .header-table,
        .header-table td {
            border: none;
            font-size: 13px;
        }

        .watermark {
            position: absolute;
            top: 35%;
            left: 15%;
            opacity: 0.1;
            font-size: 70px;
            font-weight: bold;
            transform: rotate(-30deg);
            z-index: -1;
            color: #fcc67a;
        }



        h2,
        h3 {
            margin-bottom: 5px;
        }

        p {
            margin: 3px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 13px;
        }

        th {
            background-color: #f8f8f8;
            font-size: 13px;
        }

        .text-right {
            text-align: right;
        }

        .fs-4 {
            font-size: 30px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="watermark">{{ $invoice->company ?? 'Leiferfood' }}</div>
        <h4 style="margin-bottom:0px;" class="text-center fs-4">Invoice</h4>
        <!-- Header Section in Table -->
        <table class="header-table">
            <tr>
                <td style="vertical-align: top; width:70%;">
                    <p>{{ $invoice->shop_name ?? '' }}</p>
                    <p>z.Hd. {{ $invoice->vendor_name ?? '' }}</p>
                    <p>{{ $invoice->vendor_street ?? '' }}</p>
                    <p>{{ $invoice->vendor_zipcode }} {{ $invoice->vendor_city }}</p>
                    <p>{{ $invoice->vendor_state }} {{ $invoice->vendor_country }}</p>
                    
                    <p style="margin-bottom:0px;margin-top:1rem;">Contact: {{ $invoice->vendor_email }} | Tel: {{ $invoice->vendor_phone }}</p>
                    <p>Customer Id: {{ 'PIZ' . str_pad($invoice->vendor_id, 2, '0', STR_PAD_LEFT)}} | Steuernummer: {{ $invoice->gst_number ?? '' }} | Steuer Id: {{ $invoice->pan_number ?? '' }}</p>
                </td>
                <td style="vertical-align: top;width:30%;text-align: right;">
                    <div style="width:100%;display:flex; text-align:right; ">
                      <img src="{{public_path('uploads/logo/logo5.png')}}" height="70" style="margin-right:-10px;"/>
                    </div>
                 
                </td>
            </tr>
            <tr>
                <td>
                    <p> <strong>Invoice date:</strong> {{ now()->format('d.m.Y') }}</p>
                </td>
                <td>
                    <p class="text-right"> <strong>Invoice-Number: </strong>{{ $invoice->invoice_id }}</p>
                </td>
            </tr>
           
        </table>
         @php
         
           $totalOrderAmount=0;
           $totalOnlineOrderAmount=0;
           $totalCashOrderAmount=0;
           $totalCardOrderAmount=0;
           $totalOrders=0;
           $totalOnlineOrders=0;
           $totalCashOrders=0;
           $totalCardOrders=0;
           
           $totalCOrders=0;
         $totalCOrderAmount=0;
         @endphp
         @foreach($orders ?? [] as $order)
            @php
              $totalOrders++;
              $totalOrderAmount+=$order->total_amount ?? 0;
              if($order->payment_method=="paypal"){
                $totalOnlineOrderAmount+=$order->total_amount ?? 0;
                $totalOnlineOrders++;
              }elseif($order->payment_method=="cash"){
                $totalCashOrderAmount+=$order->total_amount ?? 0;
                $totalCashOrders++;
              }else{
                $totalCardOrderAmount+=$order->total_amount ?? 0;
                $totalCardOrders++;
              }
            @endphp
         @endforeach
         
         
         @foreach($invoice->orders_cancelled ?? [] as $c_order)
            @php
              $totalCOrders++;
              $totalCOrderAmount+=$c_order->total_amount ?? 0;
            @endphp
         @endforeach
        
        <table>
            <tbody>
            <tr>
                <td colspan="2">
                    <p>Ihr über Lieferfood.de erzielter Umsatz von {{date('d.m.Y',strtotime($invoice->order_from ?? ''))}} bis {{date('d.m.Y',strtotime($invoice->order_till ?? ''))}}: {{(floatval($totalOrders ?? 0)+floatval($totalCOrders ?? 0))}} Orders Total Amount {{floatval($totalOrderAmount ?? 0)+floatval($totalCOrderAmount ?? 0)}} €</p> 
                </td>
            </tr>    
            <tr>
                <td>Online Payment Orders</td>
                <td class="text-right">{{$totalOnlineOrders ?? 0}} Order(s) received, {{$totalOnlineOrderAmount ?? 0}} €</td>
            </tr>    
            <tr>
                <td>Cash Orders</td>
                <td class="text-right">{{$totalCashOrders}} Order(s) received, {{$totalCashOrderAmount}} €</td>
            </tr>
            <tr>
                <td>Card Orders</td>
                <td class="text-right">{{$totalCardOrders}} Order(s) received, {{$totalCardOrderAmount}} €</td>
            </tr>
            <tr>
                <td>Cancelled Orders</td>
                <td class="text-right">{{$totalCOrders}} Cancelled Order(s), {{$totalCOrderAmount}} €</td>
            </tr>
            <tr>
                <td>
                    <strong>Total Commission relevant Orders</strong>
                </td>
                <td class="text-right">{{$totalOrders}} Order(s) received, {{$totalOrderAmount}} €</td>
            </tr>
            
            </tbody>
        </table>
        <table>
            <tbody>
                
                <tr>
                    <td>Commission ({{$invoice->commission_h}} of total order amount {{$totalOrderAmount}} €)</td>
                    <td class="text-right">{{ number_format($invoice->commission, 2) }} €</td>
                </tr>
                <tr>
                    <td>Best position cost (0 €/per Order)</td>
                    <td class="text-right">0 €</td>
                </tr>
                <tr>
                    <td>Online Payment Commission ({{$invoice->paypalCommission_h}} /per order)</td>
                    <td class="text-right">{{ number_format($invoice->paypal_commission, 2) }} €</td>
                </tr>
                <tr>
                    <td>Card Commission ({{$invoice->creditCardCommission_h}} /per order )</td>
                    <td class="text-right">{{ number_format($invoice->card_commission, 2) }} €</td>
                </tr>
                
                <tr>
                    <td>Other Charges</td>
                    <td class="text-right">{{ number_format($invoice->other_charges, 2) }} €</td>
                </tr>
                @php
                  $totalCom=($invoice->card_commission ?? 0)+($invoice->paypal_commission ?? 0)+($invoice->commission ?? 0)+($invoice->other_charges ?? 0);
                  $finalForGvtTax= $totalCom ?? 0;
                  $taxGovt=$finalForGvtTax*0.19;
                @endphp
                <tr>
                    <td>
                        <strong>Subtotal Comission fees</strong>
                    </td>
                    <td class="text-right">{{ number_format($totalCom,2) }} €</td>
                </tr>
                <tr>
                    <td>MwSt. (19% On {{number_format($finalForGvtTax,2)}} €)</td>
                    <td class="text-right">{{ number_format($taxGovt, 2) }} €</td>
                </tr>
                @php
                  $totalInvoiceAmount=floatval($taxGovt ?? 0)+floatval($totalCom ?? 0);
                @endphp
                <tr>
                    <td><strong>Total invoice amount</strong></td>
                    <td class="text-right"><strong>{{ number_format($totalInvoiceAmount, 2) }} €</strong></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td><strong>Pending online payments</strong></td>
                    <td class="text-right"><strong>{{number_format($totalOnlineOrderAmount, 2)}} €</strong></td>
                </tr>
                <tr>
                    <td>
                        <strong>Payout Amount</strong>
                        <p>
                            Online payment amount {{number_format($totalOnlineOrderAmount, 2)}} €  - Total invoice amount {{number_format($totalInvoiceAmount, 2)}} €
                        </p>
                        
                    </td>
                    <td class="text-right"><strong>{{ number_format($totalOnlineOrderAmount-$totalInvoiceAmount, 2) }} €</strong></td>
                </tr>
                 @php
               $leftAm=$totalOnlineOrderAmount-$totalInvoiceAmount;
            @endphp
            <tr>
                <td style="width:70%;">
                    @if($leftAm>0)
                       Your Pending amount on {{ $invoice->transaction_date ?? date('d.m.Y') }} <strong>Payout ID: {{ $invoice->payout_id }}</strong> will we transferred on your bank account {{ $invoice->account_number }}, z.Hd. {{ ucfirst($invoice->account_holder) }}
                    @else
                       You need to pay:
                    @endif
                </td>
                <td style="width:30%;">
                    <p class="text-right">{{ number_format($leftAm, 2) }} €</p>
                </td>
            </tr>
               
            </tbody>
        </table>
       
        
        <table>
           <tr>
               <td>
                   <strong>Lieferfood GmbH</strong>
                   <br>
                   <p class="mb-0 pb-0">Raiffeisenstrasse 16</p>
                   <p class="mb-0 pb-0">64347 Griesheim</p>
                   <p class="mb-0 pb-0">Germany</p>
               </td>
               <td>
                   <strong>Geschäftsführer:</strong>
                   <br>
                   <p class="mb-0 pb-0">Dhillon Sulakhan</p>
                   <p class="mb-0 pb-0">info@lieferfood.de</p>
                   <p class="mb-0 pb-0">Tel.: 0179 6756 786</p>
               </td>
               <td>
                   <strong>Sparkasse Darmstadt</strong>
                   <br>
                   <p class="mb-0 pb-0">IBAN: DE98501500080016980</p>
               </td>
               <td>
                   <strong>Amtsgericht Darmstadt</strong>
                   <br>
                   <p class="mb-0 pb-0">Ust.-ID Nr.: DE261609465</p>
                   <p class="mb-0 pb-0">Steuer-Nr.: 0781162406</p>
               </td>
           </tr>
        </table>

         <table class="header-table">
              <tr>
                <td style="vertical-align: top; width:70%;">
                    <p>Order details list : from {{date('d.m.Y',strtotime($invoice->order_from ?? ''))}} to {{date('d.m.Y',strtotime($invoice->order_till ?? ''))}}</p> 
                    <p style="margin:1rem 0rem;">Restaurant: {{ $invoice->shop_name ?? '' }} ( {{ 'PIZ' . str_pad($invoice->vendor_id, 2, '0', STR_PAD_LEFT)}} )</p>

                    <p>Total orders amount: {{(floatval($totalOrders ?? 0)+floatval($totalCOrders ?? 0))}} Order(s) {{floatval($totalOrderAmount ?? 0)+floatval($totalCOrderAmount ?? 0)}} € </p>

                    <p>Online Payed Orders: {{$totalOnlineOrders ?? 0}} Order(s) received {{$totalOnlineOrderAmount ?? 0}} € </p>
                    <p>Cash orders: {{$totalCashOrders ?? 0}} Order(s) received {{$totalCashOrderAmount ?? 0}} € </p>
                    <p>Card orders: {{$totalCardOrders ?? 0}} Order(s) received {{$totalCardOrderAmount ?? 0}} € </p>
                    <p>Cancelled orders: {{$totalCOrders ?? 0}} Order(s), {{$totalCOrderAmount ?? 0}} € </p>
                    <p>Commission taking total orders amount: {{$totalOrderAmount ?? 0}} € </p>
                </td>
                <td style="vertical-align: top;width:30%;text-align: right;">
                    <div style="width:100%;display:flex; text-align:right; ">
                      <img src="{{public_path('uploads/logo/logo5.png')}}" height="70" style="margin-right:-10px;"/>
                    </div>
                 
                </td>
            </tr>
         </table>   

        <table>
            <tr>
                <th>Order Date</th>
                <th>Order No.</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
            </tr>
           
            @foreach($invoice->all_orders ?? [] as $order)
               <tr>
                <td>{{date('d.m.Y H:i:s',strtotime($order->created_at))}}</td>
                <td>A{{str_pad($order->id, 5, '0', STR_PAD_LEFT)}}</td>
                <td>{{$order->total_amount+$order->method_cost}}</td>
                <td>{{$order->payment_method ?? 'cash'}}</td>
                <td>
                    @if($order->order_status=="delivered")
                       Completed
                    @else
                       Cancelled
                    @endif
                </td>
              </tr>
            @endforeach
        </table>
        
        <p style="width:100%;text-align:center;"><strong>Thank you for your business!</strong></p>
    </div>


</body>

</html>
