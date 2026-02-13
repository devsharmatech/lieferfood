@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Table Service</span> </h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">Table Service Details</h5>

                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('vendor.store.table-service') }}">
                            @csrf
                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <label for="table_service_status" class="form-label">Table Service</label>
                                    <select id="table_service_status" name="table_service_status"
                                        class="select2 form-select">
                                        <option value="">Select</option>
                                        <option value="1" @selected(isset($table_service->status) && $table_service->status == 1)>Active</option>
                                        <option value="0" @selected(isset($table_service->status) && $table_service->status == 0)>Inactive</option>
                                    </select>
                                    @error('table_service_status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="holiday" class="form-label">Holiday</label>
                                    <select id="holiday" name="holiday" class="select2 form-select">
                                        <option value="">Select</option>
                                        @php
                                            $daysOfWeek = [
                                                'monday',
                                                'tuesday',
                                                'wednesday',
                                                'thursday',
                                                'friday',
                                                'saturday',
                                                'sunday',
                                            ];
                                        @endphp
                                        @foreach ($daysOfWeek as $day)
                                            <option value="{{ $day }}" @selected(isset($table_service->day_off) && ($table_service->day_off == $day))>
                                                {{ ucfirst($day) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('holiday')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="open_time" class="form-label">Open Time</label>
                                    <select id="open_time" name="open_time" class="select2 form-select">
                                        <option value="">Select</option>
                                        @for ($hour = 0; $hour < 24; $hour++)
                                            @php
                                                $displayHour = $hour % 12 == 0 ? 12 : $hour % 12;
                                                $amPm = $hour < 12 ? 'AM' : 'PM';
                                                $time1 = str_pad($displayHour, 2, '0', STR_PAD_LEFT) . ':00 ' . $amPm;
                                                $time2 = str_pad($displayHour, 2, '0', STR_PAD_LEFT) . ':30 ' . $amPm;
                                            @endphp
                                            <option @selected(isset($table_service->open_time) && $table_service->open_time == $time1) value="{{ $time1 }}">
                                                {{ $time1 }}</option>
                                            <option @selected(isset($table_service->open_time) && $table_service->open_time == $time2) value="{{ $time2 }}">
                                                {{ $time2 }}</option>
                                        @endfor
                                    </select>
                                    @error('open_time')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="close_time" class="form-label">Close Time</label>
                                    <select id="close_time" name="close_time" class="select2 form-select">
                                        <option value="">Select</option>
                                        @for ($hour = 0; $hour < 24; $hour++)
                                            @php
                                                $displayHour = $hour % 12 == 0 ? 12 : $hour % 12;
                                                $amPm = $hour < 12 ? 'AM' : 'PM';
                                                $time1 = str_pad($displayHour, 2, '0', STR_PAD_LEFT) . ':00 ' . $amPm;
                                                $time2 = str_pad($displayHour, 2, '0', STR_PAD_LEFT) . ':30 ' . $amPm;
                                            @endphp
                                            <option @selected(isset($table_service->close_time) && $table_service->close_time == $time1) value="{{ $time1 }}">
                                                {{ $time1 }}</option>
                                            <option @selected(isset($table_service->close_time) && $table_service->close_time == $time2) value="{{ $time2 }}">
                                                {{ $time2 }}</option>
                                        @endfor
                                    </select>
                                    @error('close_time')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="upload" class="form-label">Gallery</label>
                                    <input type="file" id="upload" name="images[]" multiple class="form-control"
                                        accept="image/*" />
                                    @error('images')
                                        <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="mt-3 col-12">
                                    <div class="row">
                                        @foreach ($gallery as $image)
                                            <div class="col-sm-3 mb-2 position-relative" >
                                                <a href="{{route('vendor.table.delete.image',$image->id)}}" class="btn position-absolute top-2 left-2 btn-sm btn-primary"> <i class="bx bx-trash" aria-hidden="true"></i> </a>
                                                <img class="img-fluid rounded-2" src="{{ asset('uploads/gallery/'.$image->image) }}" alt="Image" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
