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
                        <h5 class=" py-0">Payout History</h5>
                        <a href="{{route('admin.generate.payout')}}" class="btn btn-sm btn-primary">Payout Generate</a>
                    </div>
                    <div class="card-header">
                        <form method="GET" action="{{ route('admin.payment.history') }}" class="row g-3 align-items-end">
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
                            <div class="col-md-3">
                                <label class="form-label">Vendor:</label>
                                <select name="shop_id" id="shop_id" class="form-control form-select">
                                    <option value="">Select Vendor</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Submit Button -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('admin.payment.history') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Vendor Name</th>
                                    <th>Payout By</th>
                                    <th>Invoice</th>
                                    <th>Total Amount</th>
                                    <th>Commission</th>
                                    <th>PayPal Commission</th>
                                    <th>Card Commission</th>
                                    <th>Pay Amount</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($payouts as $payout) 
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a target="_blank" href="{{ route('admin.show.vendor', $payout->vendor_id) }}" class="btn btn-link">{{ $payout->vendor->name ?? '' }}</a>
                                        </td>
                                        <td>{{ $payout->payout_by }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-info" download href="{{ asset('uploads/pdfs/'.$payout->invoice->pdf) }}">Print Invoice</a>
                                        </td>
                                        <td>{{ $payout->amount }}</td>
                                        <td>{{ $payout->commission }}</td>
                                        <td>{{ $payout->paypal_commission }}</td>
                                        <td>{{ $payout->card_commission }}</td>
                                        <td>{{ $payout->amount-($payout->commission+$payout->card_commission+$payout->paypal_commission) }}</td>
                                        <td>{{ $payout->payment_date ?? '' }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('admin.delete.payout', $payout->id) }}" class="btn btn-sm btn-danger">
                                                    Delete
                                               </a>
                                            </div>

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
