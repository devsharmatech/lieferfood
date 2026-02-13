@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Create New Vendor)
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Vendor Account</h5>
                        <small class="text-muted float-end">Create new vendor</small>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.store.vendor') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name">Vendor Name</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-bowl-hot"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Italian Restaurant"
                                        aria-label="Chinese" name="name" id="name" value="{{ old('name') }}" />
                                </div>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Vendor Email</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">
                                        <i class='bx bx-envelope'></i>
                                    </span>
                                    <input type="email" class="form-control" placeholder="vendor@gmail.com" name="email"
                                        value="{{ old('email') }}" id="email" />
                                </div>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="phone">Vendor Phone</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                    <input type="tel" class="form-control" placeholder="+44 7287 276362" name="phone"
                                        value="{{ old('phone') }}" id="phone" />
                                </div>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="image">Vendor Profile</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-image"></i></span>
                                    <input type="file" id="image" class="form-control phone-mask" name="image"
                                        accept="image/*" />
                                </div>
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
