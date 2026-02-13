@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="py-0">Open Timings</h5>
                       
                        <a href="{{ route('vendor.custome_opening') }}" class="btn btn-primary btn-sm">Custome Timing
                            Manager</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Pickup</th>
                                    <th>Delivery</th>
                                    <th>Delivery Times</th>
                                    <th>Pickup Times</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($timings as $timing)
                                    <tr>
                                        <td>{{ $timing->day }}</td>
                                        <td>
                                            <div>
                                                <div class="form-check form-switch mb-2 " style="cursor: pointer;">
                                                    <input class="form-check-input toggle-pickup" type="checkbox"
                                                        data-id="{{ $timing->id }}" data-field="is_pickup"
                                                        @checked($timing->is_pickup == 1) id="pickup-{{ $timing->id }}" />
                                                    <label class="form-check-label"
                                                        for="pickup-{{ $timing->id }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>

                                            <div>
                                                <div class="form-check form-switch mb-2 " style="cursor: pointer;">
                                                    <input class="form-check-input toggle-delivery" type="checkbox"
                                                        data-id="{{ $timing->id }}" data-field="is_delivery"
                                                        @checked($timing->is_delivery == 1) id="delivery-{{ $timing->id }}" />
                                                    <label class="form-check-label"
                                                        for="delivery-{{ $timing->id }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if (isset($timing->delivery_times) && json_decode($timing->delivery_times) != null)
                                                @php
                                                    $delivery_times = json_decode($timing->delivery_times);
                                                @endphp
                                                @foreach ($delivery_times as $delivery_time)
                                                    <p style="white-space: nowrap" class="mb-1 pb-0">
                                                        {{ date('h:i A', strtotime($delivery_time->start)) }} to
                                                        {{ date('h:i A', strtotime($delivery_time->end)) }}</p>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($timing->pickup_times) && json_decode($timing->pickup_times) != null)
                                                @php
                                                    $pickup_times = json_decode($timing->pickup_times);
                                                @endphp
                                                @foreach ($pickup_times as $pickup_time)
                                                    <p style="white-space: nowrap" class="mb-1 pb-0">
                                                        {{ date('h:i A', strtotime($pickup_time->start)) }} to
                                                        {{ date('h:i A', strtotime($pickup_time->end)) }}</p>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <span class="btn btn-sm btn-success cursor-pointer btn-edit"
                                                data-id="{{ $timing->id }}" data-day="{{ $timing->day }}"
                                                data-delivery="{{ $timing->delivery_times }}"
                                                data-pickup="{{ $timing->pickup_times }}">
                                                <i class="bx bx-edit text-white"></i>
                                            </span>
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

    <!-- Modal for Editing Timings -->
    <div class="modal fade" id="editTimingModal" data-bs-backdrop="static"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="editTimingModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTimingModalLabel">Edit Timings for <span id="selectedDay"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="co">
                            <!-- Delivery Times -->
                            <h6>Delivery Times</h6>
                            <div id="delivery-timing-container">
                                <!-- Timings will be dynamically added here -->
                            </div>
                            <button id="add-delivery-time" class="btn btn-success btn-sm mb-3">Add Delivery Time</button>

                            <!-- Pickup Times -->
                            <h6>Pickup Times</h6>
                            <div id="pickup-timing-container">
                                <!-- Timings will be dynamically added here -->
                            </div>
                            <button id="add-pickup-time" class="btn btn-success btn-sm mb-3">Add Pickup Time</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-timings">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('vendor_custome_script')
    <script>
        new DataTable('#datatable', {
            responsive: true,
            "order": false,
        });
    </script>
    <script>
        $(document).ready(function() {
            // When edit button is clicked
            $('.btn-edit').click(function() {

                let id = $(this).data('id');
                let day = $(this).data('day');
                let deliveryTimes = $(this).data('delivery');
                let pickupTimes = $(this).data('pickup');

                $('#selectedDay').text(day);

                // Load existing delivery times
                loadTimes(deliveryTimes, 'delivery', '#delivery-timing-container');
                // Load existing pickup times
                loadTimes(pickupTimes, 'pickup', '#pickup-timing-container');

                // Save button event
                $('#save-timings').off('click').on('click', function() {
                    saveTimings(id);
                });

                $('#editTimingModal').modal('show');
            });

            // Add more delivery time
            $('#add-delivery-time').click(function() {
                addTimeSlot('delivery', '#delivery-timing-container');
            });

            // Add more pickup time
            $('#add-pickup-time').click(function() {
                addTimeSlot('pickup', '#pickup-timing-container');
            });

            // Function to load existing times
            function loadTimes(times, type, container) {
                $(container).html('');
                // check times is array or object
                console.log(times);
                if (times) {
                    times.forEach(function(time, index) {
                        addTimeSlot(type, container, time.start, time.end);
                    });
                }
            }

            // Function to add a new time slot row
            function addTimeSlot(type, container, start = '', end = '') {
                let row = `
                    <div class="row ${type}-timing mb-2">
                        <div class="col-md-5">
                            <input type="time" class="form-control ${type}-start" value="${start}">
                        </div>
                        <div class="col-md-5">
                            <input type="time" class="form-control ${type}-end" value="${end}">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-danger remove-time">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                $(container).append(row);
            }

            // Remove time slot
            $(document).on('click', '.remove-time', function() {
                $(this).closest('.row').remove();
            });

            // Save timings via AJAX
            function saveTimings(id) {
                let deliveryTimes = [];
                let pickupTimes = [];

                $('.delivery-start').each(function(index) {
                    let start = $(this).val();
                    let end = $('.delivery-end').eq(index).val();
                    deliveryTimes.push({
                        start: start,
                        end: end
                    });
                });

                $('.pickup-start').each(function(index) {
                    let start = $(this).val();
                    let end = $('.pickup-end').eq(index).val();
                    pickupTimes.push({
                        start: start,
                        end: end
                    });
                });
                var updateUrl = "{{ route('vendor.update.openings') }}/" + id;
                $.ajax({
                    url: updateUrl,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        delivery_times: deliveryTimes,
                        pickup_times: pickupTimes
                    },
                    success: function(response) {
                        toastr.success('Timings updated successfully!');
                        $('#editTimingModal').modal('hide');
                        location.reload();
                    }
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.toggle-pickup').change(function() {
                var id = $(this).data('id');
                var isPickup = $(this).is(':checked') ? 1 : 0;
                var pickupUrl = "{{ route('vendor.update.pickup.status') }}/" + id;
                $.ajax({
                    url: pickupUrl,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_pickup: isPickup
                    },
                    success: function(response) {
                        toastr.success('Pickup status updated successfully!');
                    },
                    error: function(xhr) {
                        toastr.error('Error updating status: ' + xhr.responseText);
                    }
                });
            });
            $('.toggle-delivery').change(function() {
                var id = $(this).data('id');
                var isDelivery = $(this).is(':checked') ? 1 : 0;
                var deliveryUrl = "{{ route('vendor.update.delivery.status') }}/" + id;
                $.ajax({
                    url: deliveryUrl,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_delivery: isDelivery
                    },
                    success: function(response) {
                        toastr.success('Delivery status updated successfully!');
                    },
                    error: function(xhr) {
                        toastr.error('Error updating status: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
