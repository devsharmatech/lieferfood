@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Table Foods</h5>
                        <a href="{{route('vendor.add-table.food')}}" class="btn btn-sm btn-primary">Add New</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Image</th>
                                    <th>Food Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Created On</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($foods as $food)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img style="height: 4rem; width:4rem;" class="rounded-2"
                                                src="{{ asset('uploads/table-foods/' . $food->image) }}" alt="">
                                        </td>
                                        <td>{{ $food->name }}</td>
                                        <td>{{ $food->category->name }}</td>
                                        <td>{{ $food->price }}</td>
                                        <td>{{ $food->created_at }}</td>
                                        <td>
                                            <a href="{{route('vendor.edit-table.food',$food->id)}}" class="btn btn-sm btn-success">Edit</a>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                
                                                <form action="{{route('vendor.delete-table.food',$food->id)}}" method="POST" style="display: inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
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
            ordering:false,
            lengthMenu: [[-1, 10, 20, 50, 100, 200], ['All', 10, 20, 50, 100, 200]]
        });
    });
</script>
@endsection
