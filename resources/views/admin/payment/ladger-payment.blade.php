@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Payment Ladger)
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Payments</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Vendor</th>
                                    <th>Phone</th>
                                    <th>Price</th>
                                    <th>Payment Id</th>
                                    <th>Pay On</th>

                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        
                                        <td>
                                            <a href="{{route('admin.show.vendor',$payment->vendor_id)}}">{{isset($payment->vendor->name)?$payment->vendor->name:'N/A'}}</a>
                                        </td>
                                       
                                        <td>
                                            @if ($payment->user_id != null)
                                                {{ $payment->user->phone }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $payment->amount }}
                                        </td>
                                        <td>
                                            {{ $payment->payment_id }}
                                        </td>
                                        <td>
                                            {{ date('d F Y, h:i A', strtotime($payment->payment_date)) }}
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
@endsection

@section('custome_script')
    <script>
        new DataTable('#datatable', {
            responsive: true
        });
    </script>
@endsection
