@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Edit Offer</span> </h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">Offer Details</h5>

                    <div class="card-body">
                        @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops! Something went wrong.</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                        <form method="POST" enctype="multipart/form-data" action="{{ route('vendor.update.offer') }}">
                            @csrf

                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <input type="hidden" name="id" value="{{$offer->id}}">
                                    <label for="title" class="form-label">Title</label>
                                    <input class="form-control" value="{{ $offer->title }}" type="text" id="title"
                                        name="title" autofocus />
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="discount_type" class="form-label">Discount Type</label>
                                    <select id="discount_type" name="discount_type" class="select2 form-select">
                                        <option value="">Select</option>
                                        <option value="fixed" @selected($offer->offer_type == 'fixed')>Fixed</option>
                                        <option value="percentage" @selected($offer->offer_type == 'percentage')>Percentage</option>
                                    </select>
                                    @error('discount_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="discount" class="form-label">Discount </label>
                                    <input class="form-control" type="number" value="{{ $offer->discount_value }}"
                                        name="discount" id="discount" />
                                    @error('discount')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="upto_price" class="form-label">Upto Price </label>
                                    <input class="form-control" type="number" value="{{ $offer->upto }}"
                                        name="upto_price" id="upto_price" />
                                    @error('upto_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                
                               <div class="mb-3 col-md-6">
                                    <label for="offer_on" class="form-label">Offer On</label>
                                    <select id="offer_on" name="offer_on" class="select2 form-select">
                                        <option value="">Select</option>
                                        <option value="restaurant" @selected($offer->whichType == "restaurant")>On Shop (Restaurant)</option>
                                        <option value="category" @selected($offer->whichType == "category")>On Category</option>
                                        <option value="food" @selected($offer->whichType == "food")>On Food</option>
                                    </select>
                                    @error('offer_on')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6" id="category_sl">
                                    <label for="category" class="form-label">Category </label>
                                    <select id="category" name="category" class="select2 form-select">
                                        <option value="">Select</option>
                                        @foreach($categories AS $category)
                                        <option value="{{$category->id}}" @selected($offer->category_id ==$category->id)>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">(Need to select when you want to add offer on category)</small>
                                    @error('category')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6" id="food_sl">
                                    <label for="food" class="form-label">Food</label>
                                    <select id="food" name="food" class="select2 form-select">
                                        <option value="">Select</option>
                                        @foreach($foods AS $food)
                                          <option value="{{$food->id}}" @selected($offer->food_id ==$food->id)>{{$food->food_item_name}}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">(Need to select when you want to add offer on food)</small>
                                    @error('food')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                <div class="mb-3 col-md-6">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input class="form-control" value="{{ date('Y-m-d',strtotime($offer->start_date)) }}" type="date"
                                        name="start_date" id="start_date" />
                                    @error('start_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                <div class="mb-3 col-md-6">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input class="form-control" value="{{ date('Y-m-d',strtotime($offer->end_date)) }}" type="date"
                                        name="end_date" id="end_date" />
                                    @error('end_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                <div class="col-md-12 mt-4">
    <label class="form-label">Offer Time Slots</label>
    <div id="time-slots">
        @php
          $slots=$offer->slots ?? [];
        @endphp
        @if (!empty($slots))
            @foreach ($slots as $slot)
                <div class="row time-row align-items-center">
                    <div class="mb-3 col-md-5">
                        <label class="form-label">Start Time</label>
                        <input class="form-control start_time" type="time" name="start_times[]" value="{{ $slot['start_time'] ?? '' }}" required />
                    </div>
                    <div class="mb-3 col-md-5">
                        <label class="form-label">End Time</label>
                        <input class="form-control end_time" type="time" name="end_times[]" value="{{ $slot['end_time'] ?? '' }}" required />
                    </div>
                    <div class="mb-3 col-md-2 d-flex align-items-center pt-2">
                        <button type="button" class="btn btn-danger mt-3 remove-time">Remove</button>
                    </div>
                </div>
            @endforeach
        @else
          <div class="row time-row align-items-center">
            <div class="mb-3 col-md-5">
                    <label class="form-label">Start Time</label>
                    <input class="form-control start_time" type="time" name="start_times[]" required />
                </div>
           <div class="mb-3 col-md-5">
                    <label class="form-label">End Time</label>
                    <input class="form-control end_time" type="time" name="end_times[]" required />
                </div>
           <div class="mb-3 col-md-2 d-flex align-items-center pt-2">
                    <button type="button" class="btn btn-danger mt-3 remove-time">Remove</button>
                </div>
         </div>
        @endif
    </div>
    <div class="text-end w-100">
       <button type="button" class="btn btn-success my-3 add-time">Add More</button> 
    </div>
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
    <script>
        $(document).ready(function () {
            
            $('#offer_on').change(function () {
                let selectedValue = $(this).val();
                $('#category_sl, #food_sl').hide();
                
                if (selectedValue === 'category') {
                    $('#category_sl').show();
                } else if (selectedValue === 'food') {
                    $('#food_sl').show();
                }
            }).trigger('change');

             $(document).on("click", ".add-time", function () {
        let newSlot = `
            <div class="row time-row align-items-center">
                <div class="mb-3 col-md-5">
                    <label class="form-label">Start Time</label>
                    <input class="form-control start_time" type="time" name="start_times[]" required />
                </div>
                <div class="mb-3 col-md-5">
                    <label class="form-label">End Time</label>
                    <input class="form-control end_time" type="time" name="end_times[]" required />
                </div>
                <div class="mb-3 col-md-2 d-flex align-items-center pt-2">
                    <button type="button" class="btn btn-danger mt-3 remove-time">Remove</button>
                </div>
            </div>
        `;
        $("#time-slots").append(newSlot);
    });

    // Function to remove a time slot
    $(document).on("click", ".remove-time", function () {
        $(this).closest(".time-row").remove();
    });
        });
    </script>
@endsection
