@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Delivery Ranges</h5>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#add-delivery-area">Add New</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Min Km</th>
                                    <th>Max Km</th>
                                    <th>Charge</th>
                                    <th>Delivery Time</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($areas as $area)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $area->min_km ?? 0 }}</td>
                                        <td>{{ $area->max_km ?? 0 }}</td>
                                       
                                        <td>
                                            <p class="mb-1" style="white-space: nowrap">Charge:
                                                {{ $area->delivery_charge }} &euro;</p>
                                            <p class="mb-1" style="white-space: nowrap">Min Order Price:
                                                {{ $area->min_order_price }} &euro;</p>
                                            <p class="mb-1" style="white-space: nowrap">Free Delivery On:
                                                {{ $area->min_order_price_free_delivery }} &euro;</p>
                                        </td>

                                        <td>{{ $area->max_delivery_time }} Minutes</td>
                                        <td>
                                            <div>

                                                <div class="form-check form-switch mb-2" style="cursor: pointer;">
                                                    <input class="form-check-input update-status" type="checkbox"
                                                        data-id="{{ $area->id }}" data-field="status"
                                                        @checked($area->status == 1) id="status-{{ $area->id }}" />
                                                    <label class="form-check-label"
                                                        for="status-{{ $area->id }}"></label>
                                                </div>

                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('vendor.edit.delivery-charge', $area->id) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            
                                            <span class="btn btn-sm btn-danger text-white cursor-pointer delete-record"
                                                data-id="{{ $area->id }}">
                                                <i class="bx bx-trash"></i>
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
    <div class="modal fade" id="add-delivery-area" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-6" id="staticBackdropLabel">Add Delivery Charge Range</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="addNewPostcode" class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="min_km" class="form-label">Min Km</label>
                            <input type="number" step=".01" class="form-control" id="min_km" name="min_km" placeholder="0.0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="max_km" class="form-label">Max Km</label>
                            <input type="number" step=".01" class="form-control" id="max_km" name="max_km" placeholder="0.1">
                        </div>
                       
                        <div class="col-md-6 mb-3">
                            <label for="delivery_charge" class="form-label">Delivery Charge (&euro;)</label>
                            <input type="number" step=".01" class="form-control" id="delivery_charge"
                                name="delivery_charge" placeholder="5.00">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="min_order_price" class="form-label">Minimum Order Price (&euro;)</label>
                            <input type="number" step=".01" class="form-control" id="min_order_price"
                                name="min_order_price" placeholder="20.00">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="min_order_price_free_delivery" class="form-label">Minimum Price for free delivery
                                (&euro;)</label>
                            <input type="number" step=".01" class="form-control" id="min_order_price_free_delivery"
                                name="min_order_price_free_delivery" placeholder="25.00">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="max_delivery_time" class="form-label">Max Delivery Time (Minutes)</label>
                            <input type="number" step="1" class="form-control" id="max_delivery_time"
                                name="max_delivery_time" placeholder="30">
                        </div>
                    </div>
                    <div class="mt-2 d-flex justify-content-end">
                        <button type="reset" class="btn btn-secondary me-2">Reset</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
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
    {{-- add new delivery area --}}
    <script>
        $(document).ready(function() {
            $('#addNewPostcode').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: '{{ route('vendor.save.delivery-charge') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('input').removeClass('is-invalid');
                        $('.invalid-feedback').remove();
                        if (response.status === false) {
                            $.each(response.errors, function(key, message) {
                                let input = $('#' + key);
                                input.addClass('is-invalid');
                                let errorMessage = $(
                                    '<div class="invalid-feedback"></div>').text(
                                    message);
                                input.after(errorMessage);
                            });
                        } else {
                            toastr.success('Delivery range added successfully!');
                            $('#addNewPostcode')[0].reset();
                            location.reload();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>

    {{-- delete delivery area --}}
    <script>
        $(document).ready(function() {
            $('.delete-record').on('click', function(e) {
                e.preventDefault();

                let recordId = $(this).data('id');
                let row = $(this).closest('tr');

                // Show confirmation dialog
                if (confirm("Are you sure you want to delete this record?")) {
                    var deleteUrl = "{{ route('vendor.delete.delivery-charge') }}/" + recordId;
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                row.remove();
                                toastr.success('Record deleted successfully.');
                            } else {
                                toastr.error('Failed to delete the record.');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Handle error
                            alert('An error occurred while trying to delete the record.');
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Listen for the change event on checkboxes
            $('.update-status').on('change', function() {
                let status = $(this).is(':checked') ? 1 :0; 
                let recordId = $(this).data('id'); 
                let field = $(this).data('field');

                // AJAX request
                $.ajax({
                    url: '{{route("vendor.update.delivery-charge-status")}}',
                    type: 'POST',
                    data: {
                        _token: '{{csrf_token()}}', 
                        id: recordId,
                        field: field,
                        value: status
                    },
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                        } else {
                            toastr.error('Failed to update status.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        toastr.error('An error occurred while updating the status.'); 
                    }
                });
            });
        });
    </script>
@endsection
