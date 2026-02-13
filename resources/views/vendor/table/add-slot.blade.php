@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Add New Slot</span> </h4>

        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card mb-4">
                    <h5 class="card-header">Slot Add</h5>

                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('vendor.add.slot') }}">
                            @csrf
                            <div class="row">

                                <div class="mb-3 col-md-12">
                                    <label for="slot" class="form-label">Slot Time</label>
                                    <select id="slot" name="slot" class="select2 form-select">
                                        <option value="">Select</option>
                                        @for ($hour = 0; $hour < 24; $hour++)
                                            @for ($minute = 0; $minute < 60; $minute += 30)
                                                @php
                                                    // Convert to 12-hour format
                                                    $displayHour = $hour % 12 == 0 ? 12 : $hour % 12;
                                                    $amPm = $hour < 12 ? 'AM' : 'PM';
                                                    $displayTime =
                                                        str_pad($displayHour, 2, '0', STR_PAD_LEFT) .
                                                        ':' .
                                                        str_pad($minute, 2, '0', STR_PAD_LEFT) .
                                                        ' ' .
                                                        $amPm;

                                                    // Convert to 24-hour format for value
                                                    $valueTime =
                                                        str_pad($hour, 2, '0', STR_PAD_LEFT) .
                                                        ':' .
                                                        str_pad($minute, 2, '0', STR_PAD_LEFT) .
                                                        ':00';
                                                @endphp
                                                <option @selected(isset($table_service->open_time) && $table_service->open_time == $valueTime) value="{{ $valueTime }}">
                                                    {{ $displayTime }}
                                                </option>
                                            @endfor
                                        @endfor

                                    </select>
                                    @error('slot')
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
