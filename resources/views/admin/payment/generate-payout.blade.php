@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Revenue)
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h5 class=" py-0">Generate Payout</h5>
                        <p>From: {{$lastPayoutDate==""?'........':$lastPayoutDate}} To: {{ date('d M Y') }}</p>
                    </div>
                    <div class="card-header pb-0">
                        <form method="GET" action="{{ route('admin.generate.payout') }}" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Vendor:</label>
                                <select name="shop_id" id="shop_id" class="form-control form-select">
                                    <option value="">Select Vendor</option>
                                    @foreach ($users as $user)
                                        <option @selected(request('shop_id') == $user->id) value="{{ $user->id }}">
                                            {{ $user->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Submit Button -->
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('admin.generate.payout') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
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
                                        <th class="w-33">Total Online Payment</th>
                                        <th class="w-33">Total Commission</th>
                                        <th class="w-33" >Total Earnings</th>
                                    </tr>
                                    <tr>
                                        <td>{{ number_format($totalOnlinePay, 2) }} €</td>
                                        <td>{{ number_format($finalCommissionFormatted, 2) }} €</td>
                                        <td>
                                            {{ number_format($totalAmount + $totalDeliveryCharge - $finalCommissionFormatted, 2) }}
                                            €
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        @if(isset($vendor->vendor_id) && $vendor->vendor_id!="")
                        <div class="card-header">
                            <h4 class="mb-0 fs-5 text-center fw-bolder">Vendor Payout Invoice</h4>
                        </div>
                        <form method="post" action="{{ route('admin.generate.payout.pdf') }}" class="card-body form-generate-invoice">
                            @csrf
                            <input type="hidden" name="vendor_id" value="{{ $vendor->vendor_id }}">
                            <!-- Vendor Details -->
                            <div class="row py-2 my-3" style="border:1px solid gray;">
                                <h5 class="mb-3 fw-bold fs-5">Vendor Details</h5>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Order From</label>
                                    <input type="date" class="form-control"
                                        name="order_from" readonly
                                        value="{{ date('Y-m-d',strtotime($lastPayoutDate)) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Order Till</label>
                                    <input type="date" class="form-control"
                                        name="order_till" readonly
                                        value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Vendor Name</label>
                                    <input type="text" class="form-control @error('vendor_name') is-invalid @enderror"
                                        name="vendor_name" required
                                        value="{{ old('vendor_name', $vendor->vendor_full_name ?? '') }}">
                                    @error('vendor_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('vendor_email') is-invalid @enderror"
                                        name="vendor_email" required
                                        value="{{ old('vendor_email', $vendor->company_email ?? '') }}">
                                    @error('vendor_email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('vendor_phone') is-invalid @enderror"
                                        name="vendor_phone" required
                                        value="{{ old('vendor_phone', $vendor->company_phone ?? '') }}">
                                    @error('vendor_phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control @error('vendor_address') is-invalid @enderror"
                                        name="vendor_address" required
                                        value="{{ old('vendor_address', $vendor->company_address ?? '') }}">
                                    @error('vendor_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bank Details -->
                            <div class="row py-4 my-3" style="border:1px solid gray;">
                                <h5 class="mb-3 fs-5 fw-bold">Vendor Bank Details</h5>
                                <div class="col-md-6">
                                    <label class="form-label">Bank Name</label>
                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                        name="bank_name" required value="{{ old('bank_name', $vendor->bank_name ?? '') }}">
                                    @error('bank_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Account Holder Name</label>
                                    <input type="text" class="form-control @error('account_holder') is-invalid @enderror"
                                        name="account_holder" required
                                        value="{{ old('account_holder', $vendor->bank_account_holder_name ?? '') }}">
                                    @error('account_holder')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" class="form-control @error('account_number') is-invalid @enderror"
                                        name="account_number" required
                                        value="{{ old('account_number', $vendor->bank_account_number ?? '') }}">
                                    @error('account_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label class="form-label">IFSC / SWIFT Code</label>
                                    <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror"
                                        name="ifsc_code" required
                                        value="{{ old('ifsc_code', $vendor->bank_ifsc_code ?? '') }}">
                                    @error('ifsc_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Payout Details -->
                            <div class="row py-4 my-3" style="border:1px solid gray;">
                                <h5 class="mb-3 fs-5 fw-bold">Payout Details</h5>
                               
                                <div class="col-md-4 mt-3">
                                    <label class="form-label">Total Amount</label>
                                    <input type="number" id="totalAmount"
                                        name="total_amount"
                                        class="form-control @error('total_amount') is-invalid @enderror" step="0.01"
                                        required value="{{ old('total_amount', number_format($totalAmount, 2)) }}"
                                        oninput="calculatePayout()">
                                    @error('total_amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                @php
                                    $fields = [
                                        'commission' => ['label' => 'Commission', 'value' => $totalCommission],
                                        'paypalCommission' => [
                                            'label' => 'PayPal Commission',
                                            'value' => $totalPaypalCommission,
                                        ],
                                        'cardCommission' => [
                                            'label' => 'Card Commission',
                                            'value' => $totalCreditCardCommission,
                                        ],
                                        'otherCharges' => ['label' => 'Other Charges', 'value' => 0],
                                    ];
                                @endphp

                                @foreach ($fields as $name => $data)
                                    <div class="col-md-4 mt-3">
                                        <label class="form-label">{{ $data['label'] }}</label>
                                        <input type="number" id="{{ $name }}" name="{{ $name }}"
                                            class="form-control @error($name) is-invalid @enderror" step="0.01"
                                            required value="{{ old($name, number_format($data['value'], 2)) }}"
                                            oninput="calculatePayout()">
                                        @error($name)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endforeach

                                <div class="col-md-4 mt-3">
                                    <label class="form-label"><strong>Total PayPal Amount</strong></label>
                                    <input type="text" id="netPaypal" name="paypal_amount" value="{{ $totalOnlinePay ?? 0}}" class="form-control bg-light" readonly>
                                </div>
                                 
                                <div class="col-md-4 mt-3">
                                    <label class="form-label"><strong>Total Earning (After Deductions)</strong></label>
                                    <input type="text" id="netPayout" class="form-control bg-light" readonly>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label class="form-label"><strong>Total Payout (After Deductions)</strong></label>
                                    <input type="text" id="netPayoutDeduction" name="payout_amount" class="form-control bg-light" readonly>
                                </div>
                                
                            </div>

                            <!-- Payment Method -->
                            <div class="row py-4 my-3" style="border:1px solid gray;">
                                <h5 class="mb-3 fs-5 fw-bold">Payment Method</h5>
                                <div class="col-md-4">
                                    <label class="form-label">Payment Method</label>
                                    <select class="form-control @error('payment_method') is-invalid @enderror"
                                        name="payment_method" required>
                                        <option value="bank_transfer"
                                            {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer
                                        </option>
                                    </select>
                                    @error('payment_method')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Transaction Id</label>
                                    <input class="form-control @error('transaction_id') is-invalid @enderror"
                                        type="text" name="transaction_id" value="{{ old('transaction_id') }}">
                                    @error('transaction_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Transaction Date</label>
                                    <input class="form-control @error('transaction_date') is-invalid @enderror"
                                        type="date" name="transaction_date" value="{{ old('transaction_date') }}">
                                    @error('transaction_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Generate Payout Invoice</button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custome_script')
    <script>
        function calculatePayout() {
            let totalAmount = parseFloat(document.getElementById("totalAmount").value) || 0;
            let netPaypal = parseFloat(document.getElementById("netPaypal").value) || 0;
            let commission = parseFloat(document.getElementById("commission").value) || 0;
            let paypalCommission = parseFloat(document.getElementById("paypalCommission").value) || 0;
            let cardCommission = parseFloat(document.getElementById("cardCommission").value) || 0;
            let otherCharges = parseFloat(document.getElementById("otherCharges").value) || 0;

            let finalPayout = totalAmount - (paypalCommission + commission + cardCommission + otherCharges);
            let netPayoutDeduction = netPaypal - (paypalCommission + commission + cardCommission + otherCharges);
            document.getElementById("netPayout").value = finalPayout.toFixed(2);
            document.getElementById("netPayoutDeduction").value = netPayoutDeduction.toFixed(2);
        }
        calculatePayout();
    </script>
@endsection
