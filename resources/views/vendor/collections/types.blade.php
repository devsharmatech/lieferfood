@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header ">
                        <h5 class=" py-0">Types List</h5>
                        <form action="{{route('vendor.create.type')}}" method="post" class="row">
                            @csrf
                            <div class="col-md-5 mb-2">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" value="{{ isset($typeData->name)?$typeData->name:old('name') }}" class="form-control" id="name"
                                        name="name">
                                        <input type="hidden" name="id" value="{{ isset($typeData->id)?$typeData->id:"" }}">
                                    @error('name')
                                        <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5 mb-2">
                                <div class="form-group">
                                    <label for="value">Value</label>
                                    <input type="text" value="{{ isset($typeData->value)?$typeData->value:old('value') }}" class="form-control" id="value"
                                        name="value">
                                    @error('value')
                                        <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2 mb-2 mt-3">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($types as $type)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $type->name }}</td>
                                        <td>{{ $type->value }}</td>
<td>
     <a href="{{ route('vendor.all.types', $type->id) }}" class="btn btn-sm btn-success">
                                                <i class="bx bx-edit"></i>
                                            </a>
</td>
                                        <td>
                                           
                                            <a href="{{ route('vendor.delete.type', $type->id) }}" id="delete"
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
            ordering:false,
            lengthMenu: [[-1, 10, 20, 50, 100, 200], ['All', 10, 20, 50, 100, 200]]
        });
    });
</script>
@endsection
