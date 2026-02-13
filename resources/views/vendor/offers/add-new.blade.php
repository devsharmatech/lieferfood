@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">New Offer</span></h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Offer Details</h5>

                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('vendor.store.offer') }}">
                            @csrf

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="title" class="form-label">Title</label>
                                    <input class="form-control" value="{{ old('title') }}" type="text" id="title" name="title" autofocus />
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                 <div class="mb-3 col-md-6">
                                    <label for="discount_type" class="form-label">Discount Type</label>
                                    <select id="discount_type" name="discount_type" class="form-select">
                                        <option value="">Select</option>
                                        <option value="fixed" @selected(old('discount_type') == "fixed")>Fixed</option>
                                        <option value="percentage" @selected(old('discount_type') == "percentage")>Pecentage</option>
                                    </select>
                                    @error('discount_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="discount" class="form-label">Discount</label>
                                    <input class="form-control" type="number" value="{{ old('discount') }}" name="discount" id="discount" />
                                    @error('discount')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="upto_price" class="form-label">Upto Price</label>
                                    <input class="form-control" type="number" value="{{ old('upto_price') }}" name="upto_price" id="upto_price" />
                                    @error('upto_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Offer On Selection -->
                                <div class="mb-3 col-md-6">
                                    <label for="offer_on" class="form-label">Offer On</label>
                                    <select id="offer_on" name="offer_on" class="form-select">
                                        <option value="">Select</option>
                                        <option value="restaurant" @selected(old('offer_on') == "restaurant")>On Shop (Restaurant)</option>
                                        <option value="category" @selected(old('offer_on') == "category")>On Category</option>
                                        <option value="food" @selected(old('offer_on') == "food")>On Food</option>
                                    </select>
                                    @error('offer_on')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                
                                <div class="mb-3 col-md-6" id="category_sl">
                                    <label for="category" class="form-label">Category</label>
                                    <select id="category" multiple name="categories[]" class="form-select">
                                        <option value="">Select</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @selected(in_array($category->id, old('categories', [])))>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('categories')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                
                                <div class="mb-3 col-md-6" id="food_sl">
                                    <label for="food" class="form-label">Food</label>
                                    <select id="food" multiple name="foods[]" class="form-select">
                                        <option value="">Select</option>
                                        @foreach($foods as $food)
                                            <option value="{{ $food->id }}" @selected(in_array($food->id, old('foods', [])))>{{ $food->food_item_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('foods')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-12"></div>
                                <div class="mb-3 col-md-6">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input class="form-control" type="date" value="{{ old('start_date') }}" name="start_date" id="start_date" />
                                    @error('start_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input class="form-control" type="date" value="{{ old('end_date') }}" name="end_date" id="end_date" />
                                    @error('end_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                <div class="col-md-12 mt-4">
                                    <label class="form-label">Offer Time Slots</label>
                                    <div id="time-slots">
                                        <div class="row time-row align-items-center">
                                            <div class="mb-3 col-md-5">
                                                 <label class="form-label">Start Time</label>
                                                <input class="form-control start_time" type="time" name="start_times[]" value="00:01" />
                                            </div>
                                            <div class="mb-3 col-md-5">
                                                <label class="form-label">Start Time</label>
                                                <input class="form-control end_time" type="time" name="end_times[]" value="23:59" />
                                            </div>
                                            <div class="mb-3 col-md-2 d-flex align-items-center pt-1">
                                                <button type="button" class="btn btn-success mt-3 add-time">Add</button>
                                            </div>
                                        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        $(document).ready(function () {
            const category = new Choices("#category", { removeItemButton: true });
            const food = new Choices("#food", { removeItemButton: true });

            $('#offer_on').change(function () {
                let selectedValue = $(this).val();
                $('#category_sl, #food_sl').hide();
                
                if (selectedValue === 'category') {
                    $('#category_sl').show();
                } else if (selectedValue === 'food') {
                    $('#food_sl').show();
                }
            }).trigger('change');

            $(document).on('click', '.add-time', function () {
                let timeRow = $('.time-row:first').clone();
                timeRow.find("input").val("");
                timeRow.find(".add-time").removeClass('btn-success add-time').addClass('btn-danger remove-time').html('X');
                $('#time-slots').append(timeRow);
            });

            $(document).on('click', '.remove-time', function () {
                $(this).closest('.time-row').remove();
            });
        });
    </script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endsection

