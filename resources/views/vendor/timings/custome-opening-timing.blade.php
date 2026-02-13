@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="py-0">Custome Open Timings</h5>
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                            data-bs-target="#addTimingModal">Add New</button>
                        <a href="{{ route('vendor.all.openings') }}" class="btn btn-primary btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Pickup</th>
                                    <th>Delivery</th>
                                    <th>Delivery Times</th>
                                    <th>Pickup Times</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($timings as $timing)
                                    <tr>
                                        <td>{{ date('d/M/Y', strtotime($timing->open_date)) }}</td>
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
                                                    // print_r($delivery_times);
                                                    // die;
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
                                                data-id="{{ $timing->id }}" data-day="{{ $timing->open_date }}"
                                                data-delivery="{{ $timing->delivery_times }}"
                                                data-pickup="{{ $timing->pickup_times }}">
                                                <i class="bx bx-edit text-white"></i>
                                            </span>
                                        </td>
                                        <td>
                                            
                                            <span class="btn btn-sm btn-danger cursor-pointer btn-delete"
                                                data-id="{{ $timing->id }}">
                                                <i class="bx bx-trash text-white"></i>
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

    <!-- Add New Timing Modal -->
    <div class="modal fade" id="addTimingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addTimingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTimingModalLabel">Add New Timing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Date Picker -->
                    <div class="mb-3">
                        <label for="open_date" class="form-label">Select Date</label>
                        <input type="date" id="open_date" class="form-control" min="{{ date('Y-m-d') }}" />
                    </div>

                    <!-- Pickup Switch -->
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_pickup" />
                        <label class="form-check-label" for="is_pickup">Pickup Active</label>
                    </div>
                    <!-- Pickup Times Section -->
                    <div class="mb-3">
                        <h6>Pickup Times</h6>
                        <div id="pickup-times">
                            <!-- Pickup time row -->
                        </div>
                        <button type="button" id="add-pickup-time" class="btn btn-secondary btn-sm">Add New Pickup
                            Time</button>
                    </div>
                    <!-- Delivery Switch -->
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_delivery" />
                        <label class="form-check-label" for="is_delivery">Delivery Active</label>
                    </div>

                    

                    <!-- Delivery Times Section -->
                    <div class="mb-3">
                        <h6>Delivery Times</h6>
                        <div id="delivery-times">
                            <!-- Delivery time row -->
                        </div>
                        <button type="button" id="add-delivery-time" class="btn btn-secondary btn-sm">Add New Delivery
                            Time</button>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-timing">Save Timing</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Timing Modal -->
    <div class="modal fade" id="editTimingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editTimingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTimingModalLabel">Edit Timing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-timing-form">
                        <!-- Date Field -->
                        <div class="mb-3">
                            <label for="edit-open-date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="edit-open-date" name="open_date"
                                min="{{ date('Y-m-d') }}" required>
                        </div>
                        <!-- Pickup Times Section -->
                        <div class="mb-3">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="edit-is-pickup" name="is_pickup">
                                <label class="form-check-label" for="edit-is-pickup">Is Pickup</label>
                            </div>
                            <div id="edit-pickup-times-section">
                                <h6>Pickup Times</h6>
                                <div id="edit-pickup-times"></div>
                                <button type="button" id="edit-add-pickup-time"
                                    class="btn btn-sm btn-secondary mb-3">Add Pickup
                                    Time</button>
                            </div>
                        </div>
                        <!-- Delivery Times Section -->
                        <div class="mb-3">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="edit-is-delivery"
                                    name="is_delivery">
                                <label class="form-check-label" for="edit-is-delivery">Is Delivery</label>
                            </div>
                            <div id="edit-delivery-times-section">
                                <h6>Delivery Times</h6>
                                <div id="edit-delivery-times"></div>
                                <button type="button" id="edit-add-delivery-time"
                                    class="btn btn-sm btn-secondary mb-3">Add
                                    Delivery Time</button>
                            </div>
                        </div>
                        <input type="hidden" id="edit-timing-id" name="timing_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save-edited-timing" class="btn btn-primary">Save changes</button>
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
    <script>
        $(document).ready(function() {
            // Add new Pickup time row
            $('#add-pickup-time').click(function() {
                $('#pickup-times').append(`
            <div class="row mb-2 pickup-time-row">
                <div class="col-sm-5">
                    <input type="time" class="form-control pickup-start-time" placeholder="Start Time" />
                </div>
                <div class="col-sm-5">
                    <input type="time" class="form-control pickup-end-time" placeholder="End Time" />
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-danger remove-time-row">
                         <i class="bx bx-trash"></i>
                    </button>
                </div>
            </div>
        `);
            });

            // Add new Delivery time row
            $('#add-delivery-time').click(function() {
                $('#delivery-times').append(`
            <div class="row mb-2 delivery-time-row">
                <div class="col-5">
                    <input type="time" class="form-control delivery-start-time" placeholder="Start Time" />
                </div>
                <div class="col-5">
                    <input type="time" class="form-control delivery-end-time" placeholder="End Time" />
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger remove-time-row">
                         <i class="bx bx-trash"></i>
                    </button>
                </div>
            </div>
        `);
            });

            // Remove time row
            $(document).on('click', '.remove-time-row', function() {
                $(this).closest('.row').remove();
            });

            // Save timing via AJAX
            $('#save-timing').click(function() {
                let openDate = $('#open_date').val();
                let isPickup = $('#is_pickup').is(':checked');
                let isDelivery = $('#is_delivery').is(':checked');

                // Collect pickup times
                let pickupTimes = [];
                $('.pickup-time-row').each(function() {
                    let startTime = $(this).find('.pickup-start-time').val();
                    let endTime = $(this).find('.pickup-end-time').val();
                    if (startTime && endTime) {
                        pickupTimes.push({
                            start: startTime,
                            end: endTime
                        });
                    }
                });

                // Collect delivery times
                let deliveryTimes = [];
                $('.delivery-time-row').each(function() {
                    let startTime = $(this).find('.delivery-start-time').val();
                    let endTime = $(this).find('.delivery-end-time').val();
                    if (startTime && endTime) {
                        deliveryTimes.push({
                            start: startTime,
                            end: endTime
                        });
                    }
                });


                $.ajax({
                    url: '{{ route('vendor.add.custome_timing') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        open_date: openDate,
                        is_pickup: isPickup,
                        is_delivery: isDelivery,
                        pickup_times: pickupTimes,
                        delivery_times: deliveryTimes
                    },
                    success: function(response) {
                        toastr.success('Timing saved successfully!');
                        location.reload();
                    },
                    error: function(response) {
                        console.error(response);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Event Listener for Edit Button Click
            $('.btn-edit').click(function() {
                let timingId = $(this).data('id');
                let openDate = $(this).data('day');
                let deliveryTimes = $(this).data('delivery');
                let pickupTimes = $(this).data('pickup');

                // Set Modal Fields
                $('#edit-timing-id').val(timingId);
                $('#edit-open-date').val(openDate);

                $('#edit-is-pickup').prop('checked', (pickupTimes && pickupTimes.length > 0));
                $('#edit-is-delivery').prop('checked', (deliveryTimes && deliveryTimes.length > 0));

                // Clear existing rows
                $('#edit-pickup-times').empty();
                $('#edit-delivery-times').empty();

                // Populate Pickup Times
                // console.log(pickupTimes)
                if (pickupTimes && pickupTimes.length > 0) {
                    let pickupArray = pickupTimes;
                    pickupArray.forEach(function(time) {
                        $('#edit-pickup-times').append(`
                    <div class="row mb-2 pickup-time-row">
                        <div class="col-5">
                            <input type="time" class="form-control edit-pickup-start-time" value="${time.start}" />
                        </div>
                        <div class="col-5">
                            <input type="time" class="form-control edit-pickup-end-time" value="${time.end}" />
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-danger edit-remove-time-row">
                            <i class="bx bx-trash"></i>    
                            </button>
                        </div>
                    </div>
                `);
                    });
                }

                // Populate Delivery Times
                if (deliveryTimes && deliveryTimes.length > 0) {
                    let deliveryArray = deliveryTimes;
                    deliveryArray.forEach(function(time) {
                        $('#edit-delivery-times').append(`
                    <div class="row mb-2 delivery-time-row">
                        <div class="col-5">
                            <input type="time" class="form-control edit-delivery-start-time" value="${time.start}" />
                        </div>
                        <div class="col-5">
                            <input type="time" class="form-control edit-delivery-end-time" value="${time.end}" />
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-danger edit-remove-time-row">
                             <i class="bx bx-trash"></i>    
                            </button>
                        </div>
                    </div>
                `);
                    });
                }

                // Show the modal for editing
                $('#editTimingModal').modal('show');
            });

            // Add New Pickup Time in Edit Mode
            $('#edit-add-pickup-time').click(function() {
                $('#edit-pickup-times').append(`
            <div class="row mb-2 pickup-time-row">
                <div class="col-5">
                    <input type="time" class="form-control edit-pickup-start-time" />
                </div>
                <div class="col-5">
                    <input type="time" class="form-control edit-pickup-end-time" />
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger edit-remove-time-row">
                        <i class="bx bx-trash"></i>    
                    </button>
                </div>
            </div>
        `);
            });

            // Add New Delivery Time in Edit Mode
            $('#edit-add-delivery-time').click(function() {
                $('#edit-delivery-times').append(`
            <div class="row mb-2 delivery-time-row">
                <div class="col-5">
                    <input type="time" class="form-control edit-delivery-start-time" />
                </div>
                <div class="col-5">
                    <input type="time" class="form-control edit-delivery-end-time" />
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger edit-remove-time-row">
                     <i class="bx bx-trash"></i>        
                    </button>
                </div>
            </div>
        `);
            });

            // Remove Time Row in Edit Mode
            $(document).on('click', '.edit-remove-time-row', function() {
                $(this).closest('.row').remove();
            });

            // Save Edited Timing
            $('#save-edited-timing').click(function() {
                let timingId = $('#edit-timing-id').val();
                let openDate = $('#edit-open-date').val();
                let isPickup = $('#edit-is-pickup').is(':checked');
                let isDelivery = $('#edit-is-delivery').is(':checked');
                let newPickupTimes = [];
                let newDeliveryTimes = [];

                // Collect the edited pickup times
                $('.pickup-time-row').each(function() {
                    let start = $(this).find('.edit-pickup-start-time').val();
                    let end = $(this).find('.edit-pickup-end-time').val();
                    if (start && end) {
                        newPickupTimes.push({
                            start: start,
                            end: end
                        });
                    }
                });

                // Collect the edited delivery times
                $('.delivery-time-row').each(function() {
                    let start = $(this).find('.edit-delivery-start-time').val();
                    let end = $(this).find('.edit-delivery-end-time').val();
                    if (start && end) {
                        newDeliveryTimes.push({
                            start: start,
                            end: end
                        });
                    }
                });


                $.ajax({
                    url: '{{ route('vendor.update.custome_timing') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        timing_id: timingId,
                        open_date: openDate,
                        is_pickup: isPickup,
                        is_delivery: isDelivery,
                        pickup_times: newPickupTimes,
                        delivery_times: newDeliveryTimes,
                    },
                    success: function(response) {
                        toastr.success('Timing updated successfully!');
                        location.reload();
                    },
                    error: function(response) {
                        toastr.error('An error occurred while updating timing.');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.toggle-pickup').change(function() {
                var id = $(this).data('id');
                var isPickup = $(this).is(':checked') ? 1 : 0;
                var pickupUrl = "{{ route('vendor.update.pickup_custome.status') }}/" + id;
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
                var deliveryUrl = "{{ route('vendor.update.delivery_custome.status') }}/" + id;
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


    <script>
        $(document).on('click', '.btn-delete', function() {
            const timingId = $(this).data('id');
            const row = $(this).closest('tr'); 

            // Confirm deletion
            if (confirm('Are you sure you want to delete this timing?')) {
                $.ajax({
                    url: '{{route("vendor.custom-timing.destroy")}}', 
                    type: 'DELETE',
                    data: {
                        id: timingId,
                        _token: "{{csrf_token()}}" 
                    },
                    success: function(response) {
                       
                        row.remove();
                        toastr.success(response.message); // Show success message
                    },
                    error: function(xhr) {
                        // Handle error
                        toastr.error('An error occurred while deleting the timing.');
                    }
                });
            }
        });
    </script>
@endsection
