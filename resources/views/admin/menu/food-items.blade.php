@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Food)
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Food List</h5>

                        <a href="{{ route('admin.add.food') }}" class="btn btn-sm btn-primary">Add New</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Image</th>
                                    <th>Food Name</th>
                                    <th>Category</th>
                                    <th>Vendor</th>
                                    <th>Delivery Price</th>
                                    <th>Pickup Price</th>
                                    <th>Is Available</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($foods as $food)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if (Str::startsWith($food->image, 'http'))
                                                <div style="height: 3rem; width:3rem;">
                                                    <img src="{{ $food->image }}" class="h-100 w-100" alt="">
                                                </div>
                                                @elseif ($food->image=='')
                                                <div style="height: 3rem; width:3rem;">
                                                    <img src="{{ asset('uploads/foodu.png') }}"
                                                        class="h-100 w-100" alt="">
                                                </div>
                                            @else
                                                <div style="height: 3rem; width:3rem;">
                                                    <img src="{{ asset('uploads/menu/' . $food->image) }}"
                                                        class="h-100 w-100" alt="">
                                                </div>
                                            @endif

                                        </td>
                                        <td>{{ $food->food_item_name }}</td>
                                        <td>{{ $food->category->name }}</td>
                                        <td>{{ $food->vendor->name }}</td>
                                        <td>€{{ number_format($food->delivery_price,2) }}</td>
                                        <td>€{{ number_format($food->pickup_price,2) }}</td>
                                        <td>
                                            <div>

                                                <div class="form-check form-switch mb-2">
                                                    <input class="form-check-input update-category" type="checkbox"
                                                        data-id="{{ $food->id }}" data-field="is_available"
                                                        @checked($food->is_available == 1) id="status-{{ $food->id }}" />
                                                    <label class="form-check-label"
                                                        for="status-{{ $food->id }}"></label>
                                                </div>

                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{route('admin.edit.food',$food->id)}}" class="text-success">
                                                <i class="bx bx-edit"></i> 
                                            </a>
                                            <a href="{{route('admin.delete.food',$food->id)}}" id="delete" class="text-danger">
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

@section('custome_script')
    <script>
        new DataTable('#datatable', {
            responsive: true
        });
    </script>
    <script>
        $(document).on('change', '.update-category', function() {
            let menu_id = $(this).data('id');
            let value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route('admin.food.change.status') }}',
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
@endsection
