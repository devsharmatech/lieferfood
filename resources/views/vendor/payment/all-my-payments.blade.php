@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class=" py-0">All Payments</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>User Name</th>
                                    <th>Email</th>
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
                                            @if ($payment->user_id != null)
                                                {{ $payment->user->name }}
                                                {{ $payment->user->surname }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($payment->user_id != null)
                                                {{ $payment->user->email }}
                                            @endif
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
                                            {{ date('d F Y, h:i A',strtotime($payment->payment_date)) }}
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
@section('vendor_custome_script')
    <script>
    $(document).ready(function () {
        new DataTable('#datatable', {
            responsive: true,
            ordering:false,
            lengthMenu: [[-1, 10, 20, 50, 100, 200], ['All', 10, 20, 50, 100, 200]]
        });
    });
</script>
@endsection
