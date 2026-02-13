@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Food List</h5>
                        <a href="{{ route('vendor.add.food') }}" class="btn btn-sm btn-primary">Add New</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Order</th>
                                    <th>Image</th>
                                    <th>Food Name</th>
                                    <th>Food Type</th>
                                    <th>Category</th>
                                    <th>Available</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody class="sortable">
                                @foreach ($foods as $food)
                                    <tr data-id="{{$food->id}}" style="cursor:grab;">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $food->sort }}</td>
                                        <td>
                                            <div style="height: 3rem; width:3rem;">
                                                <img src="
                                                @if ($food->image!='') {{ asset('uploads/menu/' . $food->image) }}
                                                 @else
                                                 https://placehold.co/400 @endif
                                                 "
                                                    class="h-100 w-100" alt="">
                                            </div>
                                        </td>
                                        <td>{{ $food->food_item_name }}</td>
                                        <td>{{ $food->item_type }}</td>
                                        <td>{{ $food->category->name }}</td>
                                        
                                        <td>
                                            <div>

                                                <div class="form-check form-switch mb-2" style="cursor: pointer;">
                                                    <input class="form-check-input  update-category" type="checkbox"
                                                        data-id="{{ $food->id }}" data-field="is_available"
                                                        @checked($food->is_available == 1) id="status-{{ $food->id }}" />
                                                    <label class="form-check-label"
                                                        for="status-{{ $food->id }}"></label>
                                                </div>

                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('vendor.edit.food', $food->id) }}" class="btn btn-sm btn-success">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            
                                        </td>
                                        <td>
                                            <a href="{{ route('vendor.delete.food', $food->id) }}" id="delete"
                                                class="btn btn-sm btn-danger">
                                                <i class="bx bx-trash"></i>
                                            </a>
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
        $(document).on('change', '.update-category', function() {
            let menu_id = $(this).data('id');
            let value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route('vendor.change.status') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: menu_id,
                    value: value
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Menu updated successfully')
                    } else {
                        toastr.error('Failed to update menu')
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(function() {
        // Make the tbody sortable
        $('.sortable').sortable({
            update: function(event, ui) {
                // Get the sorted data
                let order = [];
                $('.sortable tr').each(function(index) {
                    order.push({
                        id: $(this).data('id'),
                        position: index + 1
                    });
                });

                // Send the order to the backend via AJAX
                $.ajax({
                    url: '{{ route('vendor.update.sort.order') }}', 
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order: order
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Order updated successfully!');
                        } else {
                            toastr.error('Failed to update order.');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Something went wrong!');
                    }
                });
            }
        });
    });
</script>

@endsection
