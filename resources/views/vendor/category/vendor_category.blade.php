@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Category List</h5>
                        <div>
                            <a href="{{ route('vendor.create.category') }}" class="btn btn-primary">Add New</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Image (Web)</th>
                                    <th>Image (Mobile)</th>
                                    <th>Sort</th>
                                    <th>Category Name</th>
                                    <th>Slug</th>
                                    <th>Discount</th>
                                    <td>Status</td>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody class="sortable">
                                @foreach ($categories as $category)
                                    <tr data-id="{{$category->id}}" style="cursor:grab;">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if (Str::startsWith($category->image, 'http'))
                                                <div style="height: 3rem;width:5rem; ">
                                                    <img src="{{ $category->image }}" class="h-100 w-100 rounded-2" alt="">
                                                </div>
                                            @else
                                                <div style="height: 3rem; width:5rem;">
                                                    <img src="{{ asset('uploads/category/' . $category->image) }}"
                                                        class="h-100 w-100 rounded-2" alt="">
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if (Str::startsWith($category->mobile_image, 'http'))
                                                <div style="height: 3rem; width:3rem;">
                                                    <img src="{{ $category->mobile_image }}" class="h-100 w-100 rounded-2"
                                                        alt="">
                                                </div>
                                            @elseif ($category->mobile_image == null)
                                                <div style="height: 3rem; width:3rem;">
                                                    <img src="https://placehold.co/400" class="h-100 w-100 rounded-2" alt="">
                                                </div>
                                            @else
                                                <div style="height: 3rem; width:3rem;">
                                                    <img src="{{ asset('uploads/category/mobile/' . $category->mobile_image) }}"
                                                        class="h-100 w-100 rounded-2" alt="">
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $category->sort }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>
                                             <div class="mb-3">
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input update-category" name="discount"
                                                            type="checkbox" data-id="{{ $category->id }}"
                                                            data-field="discount" @checked($category->discount == 1)
                                                            id="discount-{{ $category->id }}" />
                                                        <label class="form-check-label"
                                                            for="discount-{{ $category->id }}"></label>
                                                    </div>
                                                </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                               

                                                <div class="mb-3">
                                                    
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input update-category" name="status"
                                                            type="checkbox" data-id="{{ $category->id }}"
                                                            data-field="status" @checked($category->status == 1)
                                                            id="status-{{ $category->id }}" />
                                                        <label class="form-check-label"
                                                            for="status-{{ $category->id }}"></label>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                              <a href="{{ route('vendor.edit.food.category', $category->id) }}"
                                                class=" btn btn-sm btn-success">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                          
                                            <a href="{{ route('vendor.delete.food.category', $category->id) }}"
                                                id="delete" class="btn btn-sm btn-danger">
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
            "order": false,
            lengthMenu: [[-1, 10, 20, 50, 100, 200], ['All', 10, 20, 50, 100, 200]]
        });
    });
</script>
    <script>
        $(document).on('change', '.update-category', function() {
            let categoryId = $(this).data('id');
            let field = $(this).data('field');
            let value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route('update.category.status') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: categoryId,
                    field: field,
                    value: value
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Category updated successfully')
                    } else {
                        toastr.error('Failed to update category')
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
                    url: '{{ route('vendor.update.sort.category') }}', 
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
