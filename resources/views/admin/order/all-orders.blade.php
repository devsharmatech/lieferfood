@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Orders)
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Order List</h5>

                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>User</th>
                                    <th>Vendor</th>
                                    <th>Food Name</th>
                                    <th>Customer_Detail</th>
                                    <th>Delivery_Address</th>
                                    <th>Price</th>
                                    <th>Payment</th>
                                    <th>Order_Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td> <a
                                                href="">{{ isset($order->user->name) ? $order->user->name : 'N/A' }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.show.vendor', $order->vendor_id) }}">
                                                {{ isset($order->vendor->name) ? $order->vendor->name : 'N/A' }}</a>
                                        </td>
                                        <td>
                                            <div>
                                                @foreach ($order->order_items as $item)
                                                    <div class="badge bg-success me-1">{{ $item->food_item_name }}
                                                        ({{ $item->quantity }}X{{ number_format($item->price, 2) }}€)
                                                        -> ({{ $item->variant }})
                                                    </div>
                                                    @php
                                                        $extra_toppings = json_decode(
                                                            isset($item->extras) &&
                                                            $item->extras != null &&
                                                            $item->extras != ''
                                                                ? $item->extras
                                                                : json_encode([]),
                                                        );
                                                        $totalPrice = $item->total_price;
                                                       
                                                        echo '<ol>';
                                                        foreach ($extra_toppings as $extra_topping) {
                                                            echo '<li style="font-size:11px" class=" text-capitalize ">' .
                                                                $extra_topping->name .
                                                                ' - (' .
                                                                $extra_topping->type .
                                                                ')-' .
                                                                $item->quantity .
                                                                ' Qty</li>';
                                                        }
                                                        echo '</ol>';
                                                    @endphp
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            @if (isset($order->food_receiver) && json_decode($order->food_receiver) != null)
                                                @php
                                                    $receiver = json_decode($order->food_receiver);
                                                @endphp
                                                <ul>
                                                    <li><strong>Name: </strong>
                                                        {{ isset($receiver->name) ? $receiver->name : '' }}</li>
                                                    <li><strong>Email: </strong>
                                                        {{ isset($receiver->email) ? $receiver->email : '' }}</li>
                                                    <li><strong>Phone: </strong>
                                                        {{ isset($receiver->phone) ? $receiver->phone : '' }}</li>
                                                </ul>
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($order->address) && json_decode($order->address) != null)
                                                @php
                                                    $address = json_decode($order->address);
                                                @endphp
                                                <ul>
                                                    <li><strong>Street: </strong>
                                                        {{ isset($address->street) ? $address->street : '' }}</li>
                                                    <li><strong>House No: </strong>
                                                        {{ isset($address->house_number) ? $address->house_number : '' }},
                                                    </li>
                                                    <li>
                                                        {{ isset($address->city) ? $address->city : '' }},
                                                        {{ isset($address->state) ? $address->state : '' }},
                                                        {{ isset($address->postal_code) ? $address->postal_code : '' }},
                                                        {{ isset($address->neighborhood) ? $address->neighborhood : '' }},

                                                    </li>

                                                </ul>
                                            @endif
                                        </td>
                                        <td>
                                            <span>
                                                {{ number_format($order->total_amount,2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <p>
                                                    <strong> Payment:</strong> {{ $order->payment_method }}
                                                    ( @if ($order->payment_status == 1)
                                                        Paid
                                                    @elseif($order->payment_status == 2)
                                                        Pending
                                                    @elseif($order->payment_status == 3)
                                                        Cash Pay
                                                    @else
                                                        Unpaid
                                                    @endif)
                                                </p>


                                            </div>
                                        </td>
                                        <td>
                                            <select data-id="{{ $order->id }}" onchange="orderStatus(this)"
                                                class="form-select">
                                                <option @selected($order->order_status == 'pending') value="pending">Pending</option>
                                                <option @selected($order->order_status == 'delivered') value="delivered">Delivered</option>
                                                <option @selected($order->order_status == 'confirmed') value="confirmed">Confirmed</option>
                                                <option @selected($order->order_status == 'preparing') value="preparing">Preparing</option>
                                                <option @selected($order->order_status == 'cancelled') value="cancelled">Cancelled</option>
                                                <option @selected($order->order_status == 'out_for_delivery') value="out_for_delivery">Out for
                                                    delivery</option>
                                            </select>
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.order.view', $order->id) }}" class="btn btn-sm btn-info"
                                                title="View Order">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function orderStatus(e) {

            const status = e.value;
            const entryId = e.getAttribute('data-id');

            const csrfToken = "{{ csrf_token() }}";

            // Make the AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('admin.order.status') }}', true);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.status) {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    } else {
                        console.error('Error:', xhr.statusText);
                        alert('An error occurred. Please try again.');
                    }
                }
            };

            // Send the request with the entry ID and status
            xhr.send(JSON.stringify({
                id: entryId,
                status: status
            }));
        }
    </script>
@endsection

@section('custome_script')
    <script>
        new DataTable('#datatable', {
            responsive: true
        });
    </script>
@endsection
