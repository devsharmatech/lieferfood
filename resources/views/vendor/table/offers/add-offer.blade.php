@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Add New Offers</span> </h4>

        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">Slot Offer Add</h5>

                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('vendor.store.slot.offer') }}">
                            @csrf

                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <label for="title" class="form-label">Title</label>
                                    <input class="form-control" value="{{ old('title') }}" type="text" id="title"
                                        name="title" autofocus />
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input class="form-control" value="{{ old('start_date') }}" type="date"
                                        name="start_date" id="start_date" />
                                    @error('start_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input class="form-control" value="{{ old('end_date') }}" type="date" name="end_date"
                                        id="end_date" />
                                    @error('end_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="mb-3 col-md-3">
                                    <label for="time_id" class="form-label">Day</label>
                                    <select id="time_id" name="time_id" class="select2 form-select">
                                        <option value="">Select</option>
                                        @if (isset($slots))
                                            @foreach ($slots as $slot)
                                                <option value="{{ $slot->id }}" @selected(old('time_id') == $slot->id)>
                                                    {{ $slot->day }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('time_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="discount_type" class="form-label">Discount Type</label>
                                    <select id="discount_type" name="discount_type" class="select2 form-select">
                                        <option value="">Select</option>
                                        <option value="fixed" @selected(old('discount_type') == 'fixed')>Fixed</option>
                                        <option value="percentage" @selected(old('discount_type') == 'percentage')>Percentage</option>
                                    </select>
                                    @error('discount_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="discount" class="form-label">Discount </label>
                                    <input class="form-control" type="number" value="{{ old('discount') }}"
                                        name="discount" id="discount" />
                                    @error('discount')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="upto_price" class="form-label">Upto Price </label>
                                    <input class="form-control" type="number" value="{{ old('upto_price') }}"
                                        name="upto_price" id="upto_price" />
                                    @error('upto_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="image" class="form-label">Image (400x400px)</label>
                                    <input type="file" id="upload" name="image" class="form-control"
                                        accept="image/*" />
                                    @error('image')
                                        <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="5">{{ old('description') }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
