@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="py-0">Allergens Lists</h5>
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                            data-bs-target="#addNewAllergenModel">Add New</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allergens as $allergen)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $allergen->name }}
                                        </td>
                                        <td>
                                            {{ $allergen->type }}
                                        </td>
                                        <td>
                                            <div>
                                                <div class="form-check form-switch mb-2 " style="cursor: pointer;">
                                                    <input class="form-check-input toggle-status" type="checkbox"
                                                        data-id="{{ $allergen->id }}" data-field="status"
                                                        @checked($allergen->status == 1) id="status-{{ $allergen->id }}" />
                                                    <label class="form-check-label"
                                                        for="status-{{ $allergen->id }}"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="btn btn-sm btn-success cursor-pointer btn-edit" data-id="{{ $allergen->id }}"
                                                data-type="{{ $allergen->type }}" data-name="{{ $allergen->name }}">
                                                <i class="bx bx-edit text-white"></i>
                                            </span>
                                        </td>
                                        <td>
                                            
                                            <span class="btn btn-sm btn-danger cursor-pointer btn-delete"
                                                data-id="{{ $allergen->id }}">
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
    <div class="modal fade" id="addNewAllergenModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addNewAllergen" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewAllergen">Add New Allergen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="name" class="form-label">Allergen Name</label>
                                <input type="text" class="form-control" id="allergen_name" name="name" />
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="type" class="form-label">Allergen Type</label>
                                <select name="allergen_type" id="allergen_type" class="form-select">
                                    <option value="">Select Allergen Type</option>
                                    <option value="cereals and gluten">Cereals And Gluten</option>
                                    <option value="nuts">Nuts</option>
                                    <option value="further allergens">Further Allergens</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-timing">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Timing Modal -->
    <div class="modal fade" id="editAllergenModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editAllergenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAllergenModalLabel">Edit Allergen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-allergen-form" class="row">
                         <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="name" class="form-label">Allergen Name</label>
                                <input type="text" class="form-control" id="edit_allergen_name" name="name" />
                            </div>
                         </div>
                         <div class="col-12 ">
                            <div class="form-group">
                                <label for="edit_allergen_type" class="form-label">Allergen Type</label>
                                <select name="allergen_type" id="edit_allergen_type" class="form-select">
                                    <option value="">Select Allergen Type</option>
                                    <option value="cereals and gluten">Cereals And Gluten</option>
                                    <option value="nuts">Nuts</option>
                                    <option value="further allergens">Further Allergens</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                         </div>
                        <input type="hidden" id="edit-allergen-id" name="allergen_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save-edited-allergen" class="btn btn-primary">Save changes</button>
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
            "order": false,
            lengthMenu: [[-1, 10, 20, 50, 100, 200], ['All', 10, 20, 50, 100, 200]]
        });
    });
</script>
    <script>
        $(document).ready(function() {
            $('#save-timing').click(function() {
                let allergen_name = $('#allergen_name').val();
                let allergen_type = $('#allergen_type').val();
                if (allergen_name != '') {
                    if (allergen_type != '') {
                        $.ajax({
                            url: '{{ route('vendor.add.allergen') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                allergen_name: allergen_name,
                                allergen_type: allergen_type
                            },
                            success: function(response) {
                                toastr.success('Allergen saved successfully!');
                                location.reload();
                            },
                            error: function(response) {
                                console.error(response);
                            }
                        });
                    }else{
                        toastr.error('Please select allergen type');
                    }
                }else{
                    toastr.error('Please enter allergen name');
                }

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Event Listener for Edit Button Click
            $('.btn-edit').click(function() {
                let allergenId = $(this).data('id');
                let allergenName = $(this).data('name');
                let allergeType = $(this).data('type');

                // Set Modal Fields
                $('#edit-allergen-id').val(allergenId);
                $('#edit_allergen_name').val(allergenName);
                $('#edit_allergen_type').val(allergeType);
                // Show the modal for editing
                $('#editAllergenModal').modal('show');
            });



            // Save Edited
            $('#save-edited-allergen').click(function() {
                let allergen_Id = $('#edit-allergen-id').val();
                let allergen_Name = $('#edit_allergen_name').val();
                let allergen_Type = $('#edit_allergen_type').val();
                
                $.ajax({
                    url: '{{ route('vendor.update.allergen') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        allergen_id: allergen_Id,
                        allergen_name: allergen_Name,
                        allergen_type: allergen_Type,
                    },
                    success: function(response) {
                        toastr.success('Allergen updated successfully!');
                        location.reload();
                    },
                    error: function(response) {
                        toastr.error('An error occurred while updating allergen.');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.toggle-status').change(function() {
                var id = $(this).data('id');
                var status = $(this).is(':checked') ? 1 : 0;
                var pickupUrl = "{{ route('vendor.update.allergen.status') }}/" + id;
                $.ajax({
                    url: pickupUrl,
                    type: 'PUT',
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
            const allergen_id = $(this).data('id');
            const row = $(this).closest('tr');

            // Confirm deletion
            if (confirm('Are you sure you want to delete this allergen?')) {
                $.ajax({
                    url: '{{ route('vendor.allergen.destroy') }}',
                    type: 'DELETE',
                    data: {
                        id: allergen_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        row.remove();
                        toastr.success(response.message); 
                    },
                    error: function(xhr) {
                        // Handle error
                        toastr.error('An error occurred while deleting the allergen.');
                    }
                });
            }
        });
    </script>
@endsection
