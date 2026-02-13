@extends('admin.main-frame')

@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="py-0">Collection</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" class="row"
                            action="{{ route('admin.create.collection') }}">
                            @csrf
                            <input type="hidden" name="id"
                                value="{{ isset($collection->id) ? $collection->id : '' }}">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Food Deal Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter collection Name"
                                    value="{{ isset($collection->name) ? $collection->name : '' }}">
                                @error('name')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label">Description</label>

                                <input type="text" class="form-control" id="description" name="description"
                                    placeholder="Enter Food Group Description"
                                    value="{{ isset($collection->description) ? $collection->description : '' }}">


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
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($collections as $collect)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $collect->name }}</td>
                                        <td>
                                            <div style="text-align:justify;">
                                                {{ $collect->description }}
                                            </div>
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.edit.collection', $collect->id) }}"
                                                class="text-info">
                                               <i class="bx bx-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.delete.collection', $collect->id) }}" id="delete"
                                                class="text-primary">
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
@endsection
