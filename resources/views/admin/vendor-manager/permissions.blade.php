@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Create New Vendor)
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Permissions for {{ $vendor->name }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('vendors.permissions', $vendor->id) }}" method="POST">
                            @csrf
                            @method('POST')


                            @foreach ($permissions as $permission)
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckDefault{{ $permission->id }}" name="permissions[]"
                                        value="{{ $permission->id }}"
                                        {{ in_array($permission->id, $vendorPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexSwitchCheckDefault{{ $permission->id }}">
                                        {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                    </label>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-success btn-sm mt-4">Save Permissions</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
