@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="py-0">Table Open Timings</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Table</th>
                                    <th>Table Times</th>
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
                                                    <input class="form-check-input toggle-table" type="checkbox"
                                                        data-id="{{ $timing->id }}" data-field="is_table"
                                                        @checked($timing->is_table == 1) id="table-{{ $timing->id }}" />
                                                    <label class="form-check-label"
                                                        for="table-{{ $timing->id }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                       
                                        <td>
                                            @if (isset($timing->table_times) && json_decode($timing->table_times) != null)
                                                @php
                                                    $table_times = json_decode($timing->table_times);
                                                @endphp
                                                @foreach ($table_times as $table_time)
                                                    <p style="white-space: nowrap" class="mb-1 pb-0">
                                                        {{ date('h:i A', strtotime($table_time->start)) }} to
                                                        {{ date('h:i A', strtotime($table_time->end)) }}</p>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-success cursor-pointer btn-edit"
                                                data-id="{{ $timing->id }}" data-day="{{ $timing->day }}"
                                                data-table="{{ $timing->table_times }}">
                                                <i class="bx bx-edit text-success"></i>
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
                        <div class="col-12">
                            <!-- Table Times -->
                            <h6>Table Times</h6>
                            <div id="delivery-timing-container">
                                <!-- Timings will be dynamically added here -->
                            </div>
                            <button id="add-delivery-time" class="btn btn-success btn-sm mb-3">Add Table Time</button>
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
                let tableTimes = $(this).data('table');

                $('#selectedDay').text(day);

                // Load existing Table times
                loadTimes(tableTimes, 'table', '#delivery-timing-container');

                // Save button event
                $('#save-timings').off('click').on('click', function() {
                    saveTimings(id);
                });

                $('#editTimingModal').modal('show');
            });

            // Add more delivery time
            $('#add-delivery-time').click(function() {
                addTimeSlot('table', '#delivery-timing-container');
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
                let tableTimes = [];

                $('.table-start').each(function(index) {
                    let start = $(this).val();
                    let end = $('.table-end').eq(index).val();
                    tableTimes.push({
                        start: start,
                        end: end
                    });
                });
                
                var updateUrl = "{{ route('vendor.update.table.openings') }}/" + id;
                $.ajax({
                    url: updateUrl,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        tableTimes: tableTimes,
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
            $('.toggle-table').change(function() {
                var id = $(this).data('id');
                var isTable = $(this).is(':checked') ? 1 : 0;
                var pickupUrl = "{{ route('vendor.update.table.status') }}/" + id;
                $.ajax({
                    url: pickupUrl,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_table: isTable
                    },
                    success: function(response) {
                        toastr.success('Table status updated successfully!');
                    },
                    error: function(xhr) {
                        toastr.error('Error updating status: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
