@extends('admin.main-frame')
@section('custome_style')
    <style>
        .check-confirm input:checked~label {
            background: #f5130b !important;
            color: white !important;
        }
    </style>
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Update Food Menu</span> </h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">Edit Menu Details</h5>

                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.update.food') }}">
                            @csrf

                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <input type="hidden" name="id" value="{{ $food->id }}">
                                    <label for="food_name" class="form-label">Food Name</label>
                                    <input class="form-control" value="{{ $food->food_item_name }}" type="text"
                                        id="food_name" name="food_name" autofocus />
                                    @error('food_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="category" class="form-label">Category</label>
                                    <select id="category" name="category" class="select2 form-select">
                                        <option value="">Select category</option>
                                        @foreach ($categories as $category)
                                            <option @selected($category->id == $food->category_id) value="{{ $category->id }}">
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="5">{{ $food->description }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="delivery_price" class="form-label">Delivery Price</label>
                                    <input class="form-control" value="{{ $food->delivery_price }}" step="0.01" type="number"
                                        name="delivery_price" id="delivery_price" placeholder="Price should be in €" />
                                    @error('delivery_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="pickup_price" class="form-label">Pickup Price</label>
                                    <input class="form-control" value="{{ $food->pickup_price }}" step="0.01" type="number"
                                        name="pickup_price" id="pickup_price" placeholder="Price should be in €" />
                                    @error('pickup_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="item_type" class="form-label">Item Type</label>
                                    <select id="item_type" name="item_type" class="select2 form-select">
                                        <option value="">Select Type</option>
                                        <option value="food-item" @selected($food->item_type == 'food-item')>Food Item</option>
                                        <option value="non-alcoholic-drink" @selected($food->item_type == 'non-alchoholic-drink')>Non Alcoholic Drink
                                        </option>
                                        <option value="alcoholic-drink" @selected($food->item_type == 'alchoholic-drink')>Alcoholic Drink
                                        </option>
                                    </select>
                                    @error('item_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="allergens">Allergens</label>
                                    <div class="input-group input-group-merge">

                                        <input type="text" class="form-control" readonly />
                                        <span class="input-group-text" style="cursor: pointer;" id="openModalBtn">
                                            <i class="bx bx-edit-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="external_id" class="form-label">External Id</label>
                                    <input class="form-control" min="1" value="{{ $food->external_id }}"
                                        type="number" name="external_id" id="external_id" />
                                    @error('external_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <h6>Add-ons <i class="bx bx-info-circle text-danger"></i> </h6>
                                </div>
                                <div class="col-md-3">
                                    <div>
                                        <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#addons"> <i class="bx bx-plus"></i> Add
                                            Collection</button>
                                    </div>
                                </div>


                            </div>
                            {{-- model data here --}}
                            <div class="modal fade" id="allergenModal" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="allergenModalLabel">Allergen Information</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="allergenForm">

                                                <!-- Allergen Category 1: Contains Cereals -->
                                                <h6>Contains Cereals and Products Containing Gluten</h6>
                                                <div class="row">
                                                    @php
                                                        $cereals = ['Wheat', 'Rye', 'Barley', 'Oats', 'Spelt', 'Kamut'];
                                                        $selectedCereal = json_decode(
                                                            isset($food->cereal) && $food->cereal != null
                                                                ? $food->cereal
                                                                : [],
                                                        );
                                                        $selectedCereal =
                                                            $selectedCereal != null ? $selectedCereal : [];

                                                    @endphp

                                                    @foreach ($cereals as $key => $cereal)
                                                        <div class="col-sm-6">
                                                            <div class="form-check">
                                                                <input name="cereal[]" class="form-check-input"
                                                                    type="checkbox" id="allergen{{ $key + 1 }}"
                                                                    value="{{ $cereal }}"
                                                                    @if (in_array($cereal, $selectedCereal)) checked @endif>
                                                                <label class="form-check-label"
                                                                    for="allergen{{ $key + 1 }}">{{ $cereal }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- Allergen Category 2: Contains Nuts -->
                                                <h6 class="mt-3">Contains Nuts and Products Thereof</h6>
                                                <div class="row">
                                                    @php
                                                        $nuts = [
                                                            'Almonds',
                                                            'Hazelnuts',
                                                            'Walnuts',
                                                            'Cashews',
                                                            'Pecans',
                                                            'Brazil nuts',
                                                            'Pistachios',
                                                            'Macadamia nuts',
                                                        ];
                                                        $selectedNuts = json_decode(
                                                            isset($food->nuts) && $food->nuts != null
                                                                ? $food->nuts
                                                                : [],
                                                        );
                                                        $selectedNuts = $selectedNuts != null ? $selectedNuts : [];
                                                    @endphp

                                                    @foreach ($nuts as $key => $nut)
                                                        <div class="col-sm-6">
                                                            <div class="form-check">
                                                                <input name="nuts[]" class="form-check-input"
                                                                    type="checkbox" id="allergen{{ $key + 7 }}"
                                                                    value="{{ $nut }}"
                                                                    @if (in_array($nut, $selectedNuts)) checked @endif>
                                                                <label class="form-check-label"
                                                                    for="allergen{{ $key + 7 }}">{{ $nut }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- Allergen Category 3: Further Allergens -->
                                                <h6 class="mt-3">Further Allergens</h6>
                                                <div class="row">
                                                    @php
                                                        $furthers = [
                                                            'Milk and dairy products',
                                                            'Eggs and egg products',
                                                            'Fish and fish products',
                                                            'Soy and soy products',
                                                            'Peanuts and peanut products',
                                                            'Sesame seeds and products',
                                                            'Lupin and lupin products',
                                                            'Celery and celery products',
                                                            'Mustard and mustard products',
                                                            'Molluscs and mollusc products',
                                                        ];
                                                        $selectedFurthers = json_decode(
                                                            isset($food->furthers) && $food->furthers != null
                                                                ? $food->furthers
                                                                : [],
                                                        );
                                                        $selectedFurthers =
                                                            $selectedFurthers != null ? $selectedFurthers : [];
                                                    @endphp

                                                    @foreach ($furthers as $key => $further)
                                                        <div class="col-sm-6">
                                                            <div class="form-check">
                                                                <input name="furthers[]" class="form-check-input"
                                                                    type="checkbox" id="allergen{{ $key + 15 }}"
                                                                    value="{{ $further }}"
                                                                    @if (in_array($further, $selectedFurthers)) checked @endif>
                                                                <label class="form-check-label"
                                                                    for="allergen{{ $key + 15 }}">{{ $further }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="row mt-4" style="background-color:bisque;">
                                                    <div class="col-12 p-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="is_allergens_accept"
                                                                type="checkbox" id="is_allergens_accept" />
                                                            <label class="form-check-label"
                                                                for="is_allergens_accept">Products may
                                                                contain or come into contact with allergens (e.g., dairy,
                                                                nuts, gluten). Please check if you have any
                                                                allergies.</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <div class="check-confirm">
                                                <input type="checkbox" name="confirm" id="saveAllergens" class="d-none">
                                                <label data-bs-dismiss="modal" for="saveAllergens"
                                                    class="btn btn-outline-primary">Confirm</label>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="addons" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="collectionModalLabel">Choose a Collection</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="collectionSelect" class="form-label">Select a
                                                    Collection</label>
                                                <select class="form-select" id="collectionSelect"
                                                    aria-label="Collection select" name="collection">
                                                    <option selected disabled>Select a collection</option>
                                                    @foreach ($collections as $collection)
                                                        <option value="{{ $collection->id }}"
                                                            @selected($food->collection == $collection->id)>{{ $collection->name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <div class="check-confirm">
                                                <input type="checkbox" name="is_addons" id="is_addons" class="d-none">
                                                <label for="is_addons" data-bs-dismiss="modal"
                                                    class="btn btn-outline-primary">Save
                                                    Selection</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- model end here --}}
                            <div class="mt-5">
                                <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body mt-2">
                        <h6 class="fw-bold fs-5 mb-3">Variants of menu</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th>Variant Name</th>
                                        <th>Price</th>
                                        <th>Additional Detail</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($food->variants) && $food->variants != '')
                                        @foreach ($food->variants as $variant)
                                            <tr data-variant-id="{{ $variant->id }}">
                                                <td>
                                                    {{ $variant->variant_name }}
                                                </td>
                                                <td>
                                                    €{{ number_format($variant->price,2) }}
                                                </td>
                                                <td>
                                                    {{ $variant->additional_details }}
                                                </td>
                                                <td>
                                                    <button type="button" class="btn text-success edit-variant-btn"
                                                        data-id="{{ $variant->id }}">
                                                        <i class="bx bx-edit-alt"></i>
                                                    </button>
                                                    <button type="button" class="btn text-danger delete-variant-btn"
                                                        data-id="{{ $variant->id }}">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <!-- Add Variant Button -->
                            <button type="button" id="add-more-variant" class="btn btn-primary mt-3"
                                data-bs-toggle="modal" data-bs-target="#variantModal">
                                Add Variant
                            </button>
                        </div>

                    </div>
                    <div class="card-body mt-4">
                        <h6 class="fw-bold fs-5 mb-3">Extras of menu</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th>Extras Name</th>
                                        <th>Price</th>
                                        <th>Info</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($food->extras) && $food->extras != '')
                                        @foreach ($food->extras as $extra)
                                            <tr data-extra-id="{{ $extra->id }}">
                                                <td>
                                                    {{ $extra->extra_name }}
                                                </td>
                                                <td>
                                                    €{{ number_format($extra->extra_price,2) }}
                                                </td>
                                                <td>
                                                    {{ $extra->extra_info }}
                                                </td>
                                                <td>
                                                    <button type="button" class="btn text-success edit-extra-btn"
                                                        data-id="{{ $extra->id }}">
                                                        <i class="bx bx-edit-alt"></i>
                                                    </button>
                                                    <button type="button" class="btn text-danger delete-extra-btn"
                                                        data-id="{{ $extra->id }}">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <!-- Add extra Button -->
                            <button type="button" id="add-more-extra" class="btn btn-primary mt-3"
                                data-bs-toggle="modal" data-bs-target="#extraModal">
                                Add Extra
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Bootstrap Modal for Add/Edit -->
    <div class="modal fade" id="variantModal" tabindex="-1" aria-labelledby="variantModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="variantModalLabel">Add/Edit Variant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="variantForm">
                        @csrf
                        <input type="hidden" name="variant_id" id="variant_id">
                        <input type="hidden" name="food_id" id="food_id" value="{{ $food->id }}">

                        <div class="mb-3">
                            <label for="variant_name" class="form-label">Variant Name</label>
                            <input type="text" class="form-control" id="variant_name" name="variant_name">
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price">
                        </div>

                        <div class="mb-3">
                            <label for="additional_details" class="form-label">Additional Details</label>
                            <input type="text" class="form-control" id="additional_details"
                                name="additional_details">
                        </div>

                        <button type="submit" class="btn btn-primary" id="save-variant-btn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="extraModal" tabindex="-1" aria-labelledby="variantModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="extraModalLabel">Add/Edit Extras</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="extraForm" method="POST">
                        @csrf
                        <input type="hidden" name="extra_id" id="extra_id">
                        <input type="hidden" name="food_id" id="food_id2" value="{{ $food->id }}">

                        <div class="mb-3">
                            <label for="extra_name" class="form-label">Extra Name</label>
                            <input type="text" class="form-control" id="extra_name" name="extra_name">
                        </div>

                        <div class="mb-3">
                            <label for="extra_price" class="form-label">Extra Price</label>
                            <input type="number" step="0.01" class="form-control" id="extra_price" name="extra_price">
                        </div>

                        <div class="mb-3">
                            <label for="extra_info" class="form-label">Extra Info</label>
                            <input type="text" class="form-control" id="extra_info"
                                name="extra_info">
                        </div>

                        <button type="submit" class="btn btn-primary" id="save-extra-btn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custome_script')
    <script>
        document.getElementById('openModalBtn').addEventListener('click', function() {
            const allergenModal = new bootstrap.Modal(document.getElementById('allergenModal'));
            allergenModal.show();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#add-more-variant').on('click', function() {
                $('#variantForm')[0].reset();
                $('#variant_id').val('');
                $('#variantModalLabel').text('Add Variant');
            });


            $('.edit-variant-btn').on('click', function() {
                let id = $(this).data('id');
                var editUrl = "{{ route('admin.edit.variant') }}/" + id;
                $.ajax({
                    url: editUrl,
                    method: 'GET',
                    success: function(data) {
                        $('#variant_id').val(data.id);
                        $('#variant_name').val(data.variant_name);
                        $('#price').val(data.price);
                        $('#additional_details').val(data.additional_details);
                        $('#variantModalLabel').text('Edit Variant');
                        $('#variantModal').modal('show');
                    }
                });
            });


            $('#variantForm').on('submit', function(e) {
                e.preventDefault();
                if ($('#variant_name').val() == '') {
                    alert('Please fill variant name');
                    return false;
                } else {
                    if ($('#price').val() == '') {
                        alert('Please fill variant price');
                        return false;
                    } else {
                        let id = $('#variant_id').val();
                        let saveUrl = id ? '{{ route('admin.update.variant') }}/' + id :
                            '{{ route('admin.save.variant') }}';
                        let method = id ? 'PUT' : 'POST';

                        $.ajax({
                            url: saveUrl,
                            method: method,
                            data: $(this).serialize(),
                            success: function(response) {
                                if (method == "POST") {
                                    $('#variantForm')[0].reset();
                                    $('tbody').append(`
                                     <tr data-variant-id="${response.id}">
                                        <td>${response.variant_name}</td>
                                        <td>€${response.price}</td>
                                        <td>${response.additional_details}</td>
                                        <td>
                                          <button type="button" class="btn text-success edit-variant-btn" data-id="${response.id}">
                                            <i class="bx bx-edit-alt"></i>
                                          </button>
                                          <button type="button" class="btn text-danger delete-variant-btn" data-id="${response.id}">
                                            <i class="bx bx-trash"></i>
                                          </button>
                                        </td>
                                     </tr>
                                   `);
                                    $('#variantModal').modal('hide');
                                    toastr.success('New Variant Added');
                                } else if (method == "PUT") {
                                    // Update the table row dynamically
                                    let row = $('tr[data-variant-id="' + id + '"]');
                                    row.find('td').eq(0).text(response.variant_name);
                                    row.find('td').eq(1).text('€' + response.price);
                                    row.find('td').eq(2).text(response.additional_details);

                                    $('#variantModal').modal('hide');
                                    toastr.success('Variant Updated')
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                            }
                        });
                    }
                }
            });

            // Delete Variant via AJAX
            $('.delete-variant-btn').on('click', function() {
                if (confirm('Are you sure you want to delete this variant?')) {
                    let id = $(this).data('id');
                    let row = $(this).closest('tr');
                    var deleteUrl = "{{ route('admin.delete.variant') }}/" + id;
                    $.ajax({
                        url: deleteUrl,
                        method: 'GET',
                        success: function(response) {
                            row.remove();
                        }
                    });
                }
            });
        });
    </script>

    {{-- for extrass --}}
    <script>
        $(document).ready(function() {
            $('#add-more-extra').on('click', function() {
                $('#extraForm')[0].reset();
                $('#extra_id').val('');
                $('#extraModalLabel').text('Add Extra');
            });

            $('.edit-extra-btn').on('click', function() {
                let id = $(this).data('id');
                var editUrl = "{{ route('admin.edit.extra') }}/" + id;
                $.ajax({
                    url: editUrl,
                    method: 'GET',
                    success: function(data) {
                        $('#extra_id').val(data.id);
                        $('#extra_name').val(data.extra_name);
                        $('#extra_price').val(data.extra_price);
                        $('#extra_info').val(data.extra_info);
                        $('#extraModalLabel').text('Edit Extra');
                        $('#extraModal').modal('show');
                    }
                });
            });


            $('#extraForm').on('submit', function(e) {
                e.preventDefault();
                if ($('#extra_name').val() == '') {
                    alert('Please fill extras topping name');
                    return false;
                } else {
                    if ($('#extra_price').val() == '') {
                        alert('Please fill extras topping price');
                        return false;
                    } else {
                        let id = $('#extra_id').val();
                        let saveUrl = id ? '{{ route('admin.update.extra') }}/' + id :
                            '{{ route('admin.save.extra') }}';
                        let method = id ? 'PUT' : 'POST';

                        $.ajax({
                            url: saveUrl,
                            method: method,
                            data: $(this).serialize(),
                            success: function(response) {
                                if (method == "POST") {
                                    $('#extraForm')[0].reset();
                                    $('tbody').append(`
                                         <tr data-extra-id="${response.id}">
                                            <td>${response.extra_name}</td>
                                            <td>€${response.extra_price}</td>
                                            <td>${response.extra_info}</td>
                                            <td>
                                              <button type="button" class="btn text-success edit-extra-btn" data-id="${response.id}" data-bs-toggle="modal" data-bs-target="#editExtraModal">
                                                <i class="bx bx-edit-alt"></i>
                                              </button>
                                              <button type="button" class="btn text-danger delete-extra-btn" data-id="${response.id}">
                                                <i class="bx bx-trash"></i>
                                              </button>
                                            </td>
                                         </tr>
                                       `);
                                    $('#extraModal').modal('hide');
                                    toastr.success('New extra Added');
                                } else if (method == "PUT") {
                                    // Update the table row dynamically
                                    let row = $('tr[data-extra-id="' + id + '"]');
                                    row.find('td').eq(0).text(response.extra_name);
                                    row.find('td').eq(1).text('€'+response.extra_price);
                                    row.find('td').eq(2).text(response.extra_info);

                                    $('#extraModal').modal('hide'); 
                                    toastr.success('Extra Updated')
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                            }
                        });
                    }
                }
            });

            // Delete extra via AJAX
            $('.delete-extra-btn').on('click', function() {
                if (confirm('Are you sure you want to delete this extra topping?')) {
                    let id = $(this).data('id');
                    let row = $(this).closest('tr');
                    var deleteUrl = "{{ route('admin.delete.extra') }}/" + id;
                    $.ajax({
                        url: deleteUrl,
                        method: 'GET',
                        success: function(response) {
                            row.remove();
                        }
                    });
                }
            });
        });
    </script>
@endsection
