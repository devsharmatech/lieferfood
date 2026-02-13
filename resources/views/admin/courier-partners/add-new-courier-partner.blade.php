@extends('admin.main-frame')
@section('title')
    Create New Courier Partner
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">New Courier Partners</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name">Name</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-user"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="John" name="name"
                                        id="name" value="{{ old('name') }}" />
                                </div>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="email">Email </label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-at"></i></span>
                                            <input type="email" class="form-control" placeholder="johndoe@example.com"
                                                name="email" value="{{ old('email') }}" id="email" />
                                        </div>

                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="phone">Phone </label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                            <input type="tel" class="form-control" placeholder="+61 7266366263"
                                                name="phone" value="{{ old('phone') }}" id="phone" />
                                        </div>
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="image">Image</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-image"></i></span>
                                        <input type="file" id="image" class="form-control phone-mask" name="image"
                                            accept="image/*" />
                                    </div>
                                    @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <h6 class="d-block mt-4 mb-1 text-primary">Vehical Detail</h6>
                                <hr>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="vehicle_number">Vehicle Number</label>
                                        <div class="input-group input-group-merge">

                                            <input type="text" class="form-control" placeholder="UN13P09733"
                                                name="vehicle_number" value="{{ old('vehicle_number') }}"
                                                id="vehicle_number" />
                                        </div>
                                        @error('vehicle_number')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="vehicle_type">Vehicle Type</label>
                                        <div class="input-group input-group-merge">
                                            <select class="form-control @error('vehicle_type') is-invalid @enderror"
                                                id="vehicle_type" name="vehicle_type" required>
                                                <option value="">Select your vehicle type</option>
                                                <option value="bike"
                                                    {{ old('vehicle_type') == 'bike' ? 'selected' : '' }}>
                                                    Bike
                                                </option>
                                                <option value="car"
                                                    {{ old('vehicle_type') == 'car' ? 'selected' : '' }}>
                                                    Car
                                                </option>
                                                <option value="van"
                                                    {{ old('vehicle_type') == 'van' ? 'selected' : '' }}>
                                                    Van
                                                </option>
                                                <option value="truck"
                                                    {{ old('vehicle_type') == 'truck' ? 'selected' : '' }}>Truck
                                                </option>
                                            </select>
                                        </div>
                                        @error('vehicle_type')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="license_number">License Number</label>
                                        <div class="input-group input-group-merge">

                                            <input type="text" class="form-control" placeholder="UK09388HJU"
                                                name="license_number" value="{{ old('license_number') }}"
                                                id="license_number" />
                                        </div>
                                        @error('license_number')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <h6 class="d-block mt-4 mb-1 text-primary">Work Location</h6>
                                <hr>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="country">Country</label>
                                        <div class="input-group input-group-merge">
                                            <select class="form-control @error('country') is-invalid @enderror"
                                                id="country" name="country" required>
                                                <option value="">Select your vehicle type</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->name}}"
                                                        {{ old('country') == $country->name ? 'selected' : '' }}>
                                                        {{$country->name}}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        @error('country')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="vehicle_number">State/Provience</label>
                                        <div class="input-group input-group-merge">

                                            <input type="text" class="form-control" placeholder="State"
                                                name="state" value="{{ old('state') }}"
                                                id="state" />
                                        </div>
                                        @error('state')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="city">City</label>
                                        <div class="input-group input-group-merge">

                                            <input type="text" class="form-control" placeholder="City"
                                                name="city" value="{{ old('city') }}"
                                                id="city" />
                                        </div>
                                        @error('city')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="vehicle_type">Status</label>
                                        <div class="input-group input-group-merge">
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                id="status" name="status" required>
                                                <option value="active"
                                                    {{ old('status') == 'active' ? 'selected' : '' }}>
                                                    Bike
                                                </option>
                                                <option value="car"
                                                    {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                               
                                            </select>
                                        </div>
                                        @error('status')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>



                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
