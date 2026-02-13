@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class=" py-0">Food Deals</h5>

                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" class="row" action="{{route('groupDataStore')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{ isset($group->id) ? $group->id : '' }}">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Food Deal Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Food Deal Name"
                                    value="{{ isset($group->name) ? $group->name : '' }}">
                                @error('name')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Deal Price</label>
                                <input type="number" class="form-control" id="price" name="price"
                                    placeholder="Enter Deal Price"
                                    value="{{ isset($group->price) ? $group->price : '' }}">
                                @error('price')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Deal Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                                @error('image')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label">Description</label>
                               
                                    <input type="text" class="form-control" id="description" name="description"
                                        placeholder="Enter Food Group Description"
                                        value="{{ isset($group->description) ? $group->description : '' }}">
                                   
                                
                                @error('description')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            
                            <div>
                                <button class="btn btn-primary" type="submit">Add</button>
                            </div>
                        </form>

                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Add Items</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($groups as $group)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="
                                            @if (!empty($group->image))
                                                {{ asset('uploads/menu/'.$group->image) }}
                                            @else
                                                https://placehold.co/400x400
                                            @endif
                                            " alt="image" class="rounded-2" style="height:4rem; width:4rem;"/>
                                        </td>
                                        <td>{{ $group->name }}</td>
                                        <td>{{ $group->price }}</td>
                                        <td>
                                            <div style="width: 10rem;">
                                                {{ $group->description }}
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{route('groupItems',$group->id)}}">Add</a>
                                        </td>
                                        <td>
                                            <a href="{{route('editGroup',$group->id)}}" class="btn btn-sm btn-info">Edit</a>
                                            <a href="{{route('deleteGroup',$group->id)}}" id="delete" class="btn btn-sm btn-primary">Delete</a>
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
        new DataTable('#datatable', {
            responsive: true
        });
    </script>
@endsection
