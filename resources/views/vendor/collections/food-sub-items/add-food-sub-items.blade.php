@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="py-0">Food Sub Items List</h5>
                    </div>
                    @if (isset($edit_sub_item->id) && $edit_sub_item->id != '')
                        <form method="POST" action="{{ route('vendor.update.include') }}" class="card-body">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="row item-row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input class="form-control" type="text"
                                                    value="{{ $edit_sub_item->name }}" name="name"
                                                    placeholder="Enter Name" />
                                                <input type="hidden" name="id" value="{{ $edit_sub_item->id }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Price &euro;</label>
                                                <input class="form-control" step="0.01" type="number"
                                                    value="{{ $edit_sub_item->price }}" name="price"
                                                    placeholder="Enter price" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Info</label>
                                                <input class="form-control" type="text" name="info"
                                                    value="{{ $edit_sub_item->info }}" placeholder="Enter info">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Deposit Bottle</label>
                                                <input class="form-control" type="text" name="deposit_bottel"
                                                    value="{{ $edit_sub_item->deposit_bottel }}" placeholder="Enter Deposit Of Bottle">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="type">Type</label>
                                        <select name="type" id="type" class="form-control form-select">
                                            <option value="">Please select type</option>
                                            @foreach ($types as $type)
                                                <option @selected(isset($edit_sub_item->type) && $edit_sub_item->type == $type->value) value="{{ $type->value }}">{{ $type->name }}</option>
                                            @endforeach
                                            
                                        </select>
                                        @error('type')
                                            <small class="text-danger mt-2"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-sm btn-primary" type="submit">Save Change</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <form method="POST" action="{{ route('vendor.add.include') }}" class="card-body">
                            @csrf
                            <div class="row">
                                <div class="col-12" id="multi_container">
                                    <div class="row item-row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input class="form-control" type="text" name="names[]"
                                                    placeholder="Enter Name" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Price &euro;</label>
                                                <input class="form-control" step="0.01" type="number" name="prices[]"
                                                    placeholder="Enter price" value="0.00" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Info</label>
                                                <input class="form-control" type="text" name="infos[]"
                                                    placeholder="Enter info">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Deposit Bottle (If Needed)</label>
                                                <div class="input-group">
                                                   <input class="form-control" type="text" name="deposit_bottels[]"
                                                     placeholder="Enter Deposit Of Bottle">
                                                   <button class=" input-group-btn btn btn-sm btn-danger delete-row">
                                                     <i class="bx bx-trash"></i>
                                                  </button>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <button id="add-more" class="btn btn-sm btn-primary">
                                        <i class="bx bx-plus"></i> More
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="type">Type</label>
                                        <select name="type" id="type" class="form-control form-select">
                                            <option value="">Please select type</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->value }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                            <small class="text-danger mt-2"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-sm btn-primary" type="submit">Save Change</button>
                                </div>
                            </div>
                        </form>
                    @endif
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Info</th>
                                    <th>Deposit Of Bottle</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($food_sub_items as $key => $extra)
                                    <tr>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>{{ $extra->name }}</td>
                                        <td>{{ $extra->price }} &euro;</td>
                                        <td>{{ $extra->type }}</td>

                                        <td>
                                            <div style="width:9rem;">
                                                {{ $extra->info }}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="width:9rem;">
                                                {{ $extra->deposit_bottel ?? '' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="form-check form-switch mb-2 " style="cursor: pointer;">
                                                    <input class="form-check-input toggle-status" type="checkbox"
                                                        data-id="{{ $extra->id }}" data-field="status"
                                                        @checked($extra->status == 1) id="status-{{ $extra->id }}" />
                                                    <label class="form-check-label"
                                                        for="status-{{ $extra->id }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            
                                            <a href="{{ route('vendor.all.include', $extra->id) }}"
                                                class="btn btn-sm btn-success cursor-pointer btn-edit">
                                                <i class="bx bx-edit "></i>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="btn btn-sm btn-danger cursor-pointer btn-delete"
                                                data-id="{{ $extra->id }}">
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
@endsection
@section('vendor_custome_script')
     <script>
    $(document).ready(function () {
        new DataTable('#datatable', {
            responsive: true,
            lengthMenu: [[-1, 10, 20, 50, 100, 200], ['All', 10, 20, 50, 100, 200]]
        });
    });
</script>

    <script>
        $(document).ready(function() {
            $('.toggle-status').change(function() {
                var id = $(this).data('id');
                var status = $(this).is(':checked') ? 1 : 0;
                var pickupUrl = "{{ route('vendor.update.include.status') }}/" + id;
                $.ajax({
                    url: pickupUrl,
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        toastr.success('Status updated successfully!');
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
            const extra_id = $(this).data('id');
            const row = $(this).closest('tr');

            // Confirm deletion
            if (confirm('Are you sure you want to delete this include?')) {
                $.ajax({
                    url: '{{ route('vendor.delete.include') }}',
                    type: 'DELETE',
                    data: {
                        id: extra_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        row.remove();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        // Handle error
                        toastr.error('An error occurred while deleting the extra.');
                    }
                });
            }
        });
    </script>
    <script>
        // Function to create a new row
        $('#add-more').click(function(e) {
            e.preventDefault();

            var newRow = `
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input class="form-control" type="text" name="names[]" placeholder="Enter Name" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Price &euro;</label>
                        <input class="form-control" step="0.01" type="number" name="prices[]" placeholder="Enter price" value="0.00" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Info</label>
                        <input class="form-control" type="text" name="infos[]" placeholder="Enter info">
                    </div>
                </div>
                <div class="col-md-3 pt-2">
                    <div class="mb-3">
                      
                      <label class="form-label">Deposit Of Bottle (If needed)</label>
                      <div class="input-group">
                        <input class="form-control" type="text" name="deposit_bottels[]" placeholder="Enter Deposit of bottle">
                        <button class=" input-group-btn btn btn-sm btn-danger delete-row">
                          <i class="bx bx-trash"></i>
                        </button>
                      </div>
                    </div>
                </div>
            </div>`;

            // Append the new row to the container
            $('#multi_container').append(newRow);
        });
        $('#multi_container').on('click', '.delete-row', function(e) {
            e.preventDefault();
            if ($('#multi_container .row').length > 1) {
                $(this).closest('.row').remove();
            }
        });
    </script>
@endsection
