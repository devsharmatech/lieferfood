@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Table Bookings</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>User_Detail</th>
                                    <th>Foods</th>
                                    <th>Food Type</th>
                                    <th>Visit On</th>
                                    <th>Guest</th>
                                    <th>Status</th>
                                    <th>Offer_On_Slot_Time</th>
                                    <th>Booked_On</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($tables as $table)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>

                                            <p class="mb-0">
                                                {{ isset($table->user->name) ? $table->user->name : '' }}
                                            </p>
                                            <p class="mb-0">
                                                ({{ isset($table->user->email) ? $table->user->email : '' }})
                                            </p>
                                            <p class="mb-0">
                                                ({{ isset($table->user->phone) ? $table->user->phone : '' }})
                                            </p>
                                        </td>
                                        <td>
                                            <ol>
                                                @if (isset($table->foodDetails) && !empty($table->foodDetails))
                                                    @foreach ($table->foodDetails as $item)
                                                        <li>{{ $item->name }}</li>
                                                    @endforeach
                                                @endif
                                            </ol>
                                        </td>
                                        <td>
                                            <p class="text-uppercase">{{ $table->food_type }}</p>
                                        </td>
                                        <td>
                                            <p class="text-uppercase">
                                                {{ date('d F Y h:i A', strtotime($table->table_date . ' ' . $table->slot_time)) }}
                                            </p>
                                        </td>
                                        <td>{{ $table->guest }}</td>
                                        <td>
                                            <div style="width:8rem;">
                                                <select data-id="{{ $table->id }}" onchange="tableStatus(this)"
                                                    class="form-select">
                                                    <option @selected($table->status == 'pending') value="pending">Pending</option>
                                                    <option @selected($table->status == 'accept') value="accept">Accept</option>
                                                    <option @selected($table->status == 'reject') value="reject">Reject</option>
                                                    <option @selected($table->status == 'cancelled') value="cancelled">Cancelled
                                                    </option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            @if (isset($table->offer) && json_decode($table->offer) != null)
                                                @php
                                                    $offer = json_decode($table->offer);
                                                @endphp
                                                <ol>
                                                    <li><strong>Offer Name:</strong> {{ $offer->title }}</li>
                                                    <li><strong>Discount :</strong> {{ $offer->discount }}
                                                        {{ isset($offer->discount_type) && $offer->discount_type == 'percentage' ? '%' : '' }}
                                                    </li>
                                                    <li><strong>Offer Available Upto:</strong> {{ $offer->upto_price }}
                                                    </li>
                                                    <li><strong>End Offer:</strong>
                                                        {{ date('d F Y', strtotime($offer->end_date)) }}</li>
                                                </ol>
                                            @endif
                                        </td>
                                        <td>{{ date('d F Y h:i A', strtotime($table->created_at)) }}</td>

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
        function tableStatus(e) {

            const status = e.value;
            const entryId = e.getAttribute('data-id');

            const csrfToken = "{{ csrf_token() }}";

            // Make the AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('vendor.tableStatusChange') }}', true);
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
@section('vendor_custome_script')
     <script>
    $(document).ready(function () {
        new DataTable('#datatable', {
            responsive: true,
            "order": false,
            lengthMenu: [[-1, 10, 20, 50, 100, 200], ['All', 10, 20, 50, 100, 200]]
        });
    });
</script>
@endsection
