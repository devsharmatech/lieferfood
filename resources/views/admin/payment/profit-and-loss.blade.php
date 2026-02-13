@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Revenue)
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class=" py-0">My Revenue</h5>
                    </div>
                    <div class="card-header">
                        <form method="GET" action="{{ route('admin.all.revenues',$vendor->vendor_id) }}" class="row g-3 align-items-end">
                            <!-- Start Date -->
                            <div class="col-md-3">
                                <label class="form-label">Start Date:</label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}"
                                    class="form-control">
                            </div>
                            <!-- End Date -->
                            <div class="col-md-3">
                                <label class="form-label">End Date:</label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}"
                                    class="form-control">
                            </div>


                            <!-- Payment Method -->
                            <div class="col-md-3">
                                <label class="form-label">Order Type:</label>
                                <select name="method_type" class="form-select">
                                    <option value="">All</option>
                                    <option value="delivery" {{ request('method_type') == 'delivery' ? 'selected' : '' }}>
                                        Delivery</option>
                                    <option value="pickup" {{ request('method_type') == 'pickup' ? 'selected' : '' }}>
                                        Pickup</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('admin.all.revenues',$vendor->id) }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Order Id</th>
                                    <th>Total Amount</th>
                                    <th>Delivery Charge</th>
                                    <th>Discount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn btn-sm btn-info me-2"
                                                href="{{ route('admin.order.detail', $order->id) }}">L{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</a>
                                                <a class="btn btn-sm btn-primary"
                                                href="{{ route('admin.order.pdf', $order->id) }}">PDF Download</a>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $order->total_amount }} &euro;
                                        </td>
                                        <td>
                                            {{ $order->delivery_price }} &euro;
                                        </td>
                                        <td>
                                            {{ $order->discount }} &euro;
                                        </td>
                                        <td>
                                            {{ date('d M Y', strtotime($order->created_at)) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th class="w-33 text-white">Total Amount</th>
                                        <th class="w-33 text-white">Total Delivery Charge</th>
                                        <th class="w-33 text-white">Total Discount</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td>{{ number_format($totalAmount, 2) }} €</td>
                                        <td>{{ number_format($totalDeliveryCharge, 2) }} €</td>
                                        <td>{{ number_format($totalDiscounts, 2) }} €</td>
                                    </tr>

                                    <tr class="table-secondary">
                                        <th class="w-33">Commission</th>
                                        <th class="w-33">Credit Card Commission</th>
                                        <th class="w-33">PayPal Commission</th>
                                    </tr>
                                    <tr>
                                        <td>{{ number_format($totalCommission, 2) }} €</td>
                                        <td>{{ number_format($totalCreditCardCommission, 2) }} €</td>
                                        <td>{{ number_format($totalPaypalCommission, 2) }} €</td>
                                    </tr>

                                    <tr class="table-primary">
                                        <th class="w-33">Total PayPal Amount</th>
                                        <th class="w-33">Total Commission</th>
                                        <th class="w-33">Total Earnings</th>
                                    </tr>
                                    <tr>
                                        <td>{{ number_format($totalOnlinePay, 2) }} €</td>
                                        <td>{{ number_format($finalCommissionFormatted, 2) }} €</td>
                                        <td>
                                            {{ number_format($totalAmount + $totalDeliveryCharge - $finalCommissionFormatted, 2) }}€
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custome_script')
    <script>
        new DataTable('#datatable', {
            responsive: true
        });
    </script>
@endsection
