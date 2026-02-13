@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">New Food Menu</span> </h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">Menu Details</h5>

                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('vendor.store.food') }}">
                            @csrf

                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <label for="food_name" class="form-label">Food Name</label>
                                    <input class="form-control" value="{{ old('food_name') }}" type="text" id="food_name"
                                        name="food_name" autofocus />
                                    @error('food_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="category" class="form-label">Category</label>
                                    <select id="category" name="category" class="select2 form-select category_select">
                                        <option value="">Select category</option>
                                        @foreach ($categories as $category)
                                            <option @selected($category->id == old('category')) value="{{ $category->id }}">
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="5">{{ old('description') }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                               <div class="mb-3 col-md-6">
    <label for="item_type" class="form-label">Item Type</label>
    <select id="item_type" name="item_type" class="select2 form-select">
        <option value="">Select Type</option>

        <!-- General -->
        <optgroup label="General">
            <option value="food-item" @selected(old('item_type') == 'food-item')>🍽️ Food Item</option>
            <option value="veg" @selected(old('item_type') == 'veg')>🥦 Vegetarian</option>
            <option value="veg2" @selected(old('item_type') == 'veg2')>🍃 Vegetarian</option>
            <option value="non-veg" @selected(old('item_type') == 'non-veg')>🍖 Non-Vegetarian</option>
            <option value="vegan" @selected(old('item_type') == 'vegan')>🌱 Vegan</option>
            <option value="eggetarian" @selected(old('item_type') == 'eggetarian')>🥚 Eggetarian</option>
            <option value="pescatarian" @selected(old('item_type') == 'pescatarian')>🐟 Pescatarian</option>
            <option value="halal" @selected(old('item_type') == 'halal')>🕌 Halal</option>
            <option value="jain-food" @selected(old('item_type') == 'jain-food')>🧘 Jain Food</option>
            <option value="gluten-free" @selected(old('item_type') == 'gluten-free')>🚫🌾 Gluten-Free</option>
            <option value="organic" @selected(old('item_type') == 'organic')>🍃 Organic</option>
            <option value="spicy" @selected(old('item_type') == 'spicy')>🌶️ Hot & Spicy</option>
        </optgroup>
        <optgroup label="Sauce">
           <option value="sauce" @selected(old('item_type') == 'sauce')>🧂 Sauces</option>
<option value="dip" @selected(old('item_type') == 'dip')>🥫 Dips</option>
<option value="ketchup" @selected(old('item_type') == 'ketchup')>🍅 Ketchup</option>
<option value="mustard" @selected(old('item_type') == 'mustard')>🌭 Mustard</option>
<option value="mayo" @selected(old('item_type') == 'mayo')>🍶 Mayonnaise</option>
<option value="bbq" @selected(old('item_type') == 'bbq')>🔥 BBQ Sauce</option>
<option value="chili" @selected(old('item_type') == 'chili')>🌶️ Chili Sauce</option>
<option value="soy" @selected(old('item_type') == 'soy')>🥢 Soy Sauce</option>
<option value="garlic" @selected(old('item_type') == 'garlic')>🧄 Garlic Dip</option>
<option value="tartar" @selected(old('item_type') == 'tartar')>🐟 Tartar Sauce</option>

        </optgroup>

        <!-- Meat & Seafood -->
        <optgroup label="Meat & Seafood">
            <option value="chicken" @selected(old('item_type') == 'chicken')>🐔 Chicken</option>
            <option value="lamb" @selected(old('item_type') == 'lamb')>🐑 Lamb</option>
            <option value="beef" @selected(old('item_type') == 'beef')>🐃 Beef</option>
            <option value="cow" @selected(old('item_type') == 'cow')>🐂 Cow</option>
            <option value="pig" @selected(old('item_type') == 'pig')>🐖 Pork</option>
            <option value="goat" @selected(old('item_type') == 'goat')>🐐 Goat</option>
            <option value="duck" @selected(old('item_type') == 'duck')>🦆 Duck</option>
            <option value="turkey" @selected(old('item_type') == 'turkey')>🦃 Turkey</option>
            <option value="fish" @selected(old('item_type') == 'fish')>🐠 Fish</option>
            <option value="shrimp" @selected(old('item_type') == 'shrimp')>🍤 Shrimp</option>
            <option value="seafood" @selected(old('item_type') == 'seafood')>🦐 Seafood</option>
        </optgroup>

        <!-- Fast Food -->
        <optgroup label="Fast Food">
            <option value="burger" @selected(old('item_type') == 'burger')>🍔 Burger</option>
            <option value="pizza" @selected(old('item_type') == 'pizza')>🍕 Pizza</option>
            <option value="sandwich" @selected(old('item_type') == 'sandwich')>🥪 Sandwich</option>
            <option value="fries" @selected(old('item_type') == 'fries')>🍟 Fries</option>
            <option value="taco" @selected(old('item_type') == 'taco')>🌮 Taco</option>
            <option value="hotdog" @selected(old('item_type') == 'hotdog')>🌭 Hot Dog</option>
        </optgroup>

        <!-- Drinks -->
        <optgroup label="Drinks">
            <!--11-->
            <option value="non-alcoholic-drink" @selected(old('item_type') == 'non-alcoholic-drink')>🥤 Non-Alcoholic Drink</option>
            <option value="alcoholic-drink" @selected(old('item_type') == 'alcoholic-drink')>🍸 Alcoholic Drink</option>
            <option value="beer" @selected(old('item_type') == 'beer')>🍺 Beer</option>
            <option value="beer-mug" @selected(old('item_type') == 'beer-mug')>🍻 Beer Mug</option>
            <option value="red-wine" @selected(old('item_type') == 'red-wine')>🍷 Red Wine</option>
            <option value="white-wine" @selected(old('item_type') == 'white-wine')>🥂 White Wine</option>
            <option value="cocktail" @selected(old('item_type') == 'cocktail')>🍹 Cocktail</option>
            <option value="whiskey" @selected(old('item_type') == 'whiskey')>🥃 Whiskey</option>
            <option value="sparkling-wine" @selected(old('item_type') == 'sparkling-wine')>🥂 Sparkling Wine</option>
            <option value="coffee" @selected(old('item_type') == 'coffee')>☕ Coffee</option>
            <option value="tea" @selected(old('item_type') == 'tea')>🫖 Tea</option>
        </optgroup>

        <!-- Desserts -->
        <optgroup label="Desserts">
            <option value="ice-cream1" @selected(old('item_type') == 'ice-cream1')>🍦 Ice Cream (Cone)</option>
            <option value="ice-cream2" @selected(old('item_type') == 'ice-cream2')>🍨 Ice Cream (Cup)</option>
            <option value="ice-cream3" @selected(old('item_type') == 'ice-cream3')>🍧 Shaved Ice</option>
            <option value="cake" @selected(old('item_type') == 'cake')>🍰 Cake</option>
            <option value="chocolate" @selected(old('item_type') == 'chocolate')>🍫 Chocolate</option>
            <option value="donut" @selected(old('item_type') == 'donut')>🍩 Donut</option>
            <option value="cookie" @selected(old('item_type') == 'cookie')>🍪 Cookie</option>
        </optgroup>

        <!-- Other -->
        <optgroup label="Other">
            <option value="cheese" @selected(old('item_type') == 'cheese')>🧀 Cheese</option>
            <option value="salad" @selected(old('item_type') == 'salad')>🥗 Salad</option>
            <option value="pasta" @selected(old('item_type') == 'pasta')>🍝 Pasta</option>
            <option value="rice" @selected(old('item_type') == 'rice')>🍚 Rice</option>
            <option value="bread" @selected(old('item_type') == 'bread')>🍞 Bread</option>
            <option value="soup" @selected(old('item_type') == 'soup')>🥣 Soup</option>
            <option value="fruit" @selected(old('item_type') == 'fruit')>🍎 Fruit</option>
        </optgroup>
    </select>
    @error('item_type')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


<div class="mb-3 col-md-12">
    <label class="form-label">Select Multiple Types</label>
      <div class="border p-2 rounded">
        <div class="row">
       @php
    $types = [
        'food-item' => '🍽️ Food Item',
        'veg' => '🥦 Vegetarian',
        'veg2' => '🍃 Vegetarian',
        'non-veg' => '🍖 Non-Vegetarian',
        'vegan' => '🌱 Vegan',
        'eggetarian' => '🥚 Eggetarian',
        'pescatarian' => '🐟 Pescatarian',
        'fish' => '🐠 Fish',
        'seafood' => '🦐 Seafood',
        'halal' => '🕌 Halal',
        'jain-food' => '🧘 Jain Food',
        'gluten-free' => '🚫🌾 Gluten-Free',
        'organic' => '🍃 Organic',
        'non-alcoholic-drink' => '🥤 Non-Alcoholic Drink',
        'alcoholic-drink' => '🍸 Alcoholic Drink',
        'hot-spicy' => '🌶️ Hot & Spicy',
        'sauce'    => '🧂 Sauce',
'dip'      => '🥫 Dip',
'ketchup'  => '🍅 Ketchup',
'mustard'  => '🌭 Mustard',
'mayo'     => '🍶 Mayonnaise',
'bbq'      => '🔥 BBQ Sauce',
'chili'    => '🌶️ Chili Sauce',
'soy'      => '🥢 Soy Sauce',
'garlic'   => '🧄 Garlic Dip',
'tartar'   => '🐟 Tartar Sauce',

        'lamb' => '🐑 Lamb',
        'chicken' => '🐔 Chicken',
        'beef' => '🐄 Beef',
        'buffalo' => '🐃 Buffalo',
        'shrimp' => '🍤 Shrimp',
        'meat' => '🥩 Meat',
        'cow' => '🐂 Cow',
        'pig' => '🐖 Pork',
        'beer' => '🍺 Beer',
        'beer-mug' => '🍻 Beer Mug',
        'red-wine' => '🍷 Red Wine',
        'white-wine' => '🥂 White Wine',
        'cocktail' => '🍹 Cocktail',
        'whiskey' => '🥃 Whiskey',
        'sparkling-wine' => '🥂 Sparkling Wine',
        'ice-cream' => '🍦 Ice Cream',
        'gelato' => '🍨 Gelato',
        'shaved-ice' => '🍧 Shaved Ice',
        'pizza' => '🍕 Pizza',
        'burger' => '🍔 Burger',
        'sushi' => '🍣 Sushi',
        'salad' => '🥗 Salad',
        'dessert' => '🍰 Dessert',
        'sandwich' => '🥪 Sandwich',
        'noodles' => '🍜 Noodles',
        'taco' => '🌮 Taco',
        'fries' => '🍟 Fries',
        'steak' => '🥩 Steak',
        'soup' => '🥣 Soup',
        'bread' => '🍞 Bread',
        'cheese' => '🧀 Cheese',
        'fruit' => '🍇 Fruit',
        'chocolate' => '🍫 Chocolate',
        'tea' => '🍵 Tea',
        'coffee' => '☕ Coffee',
        'soft-drink' => '🧃 Soft Drink',
        'water' => '💧 Water',
    ];
@endphp


        @foreach($types as $value => $label)
            <div class="col-md-4">
                <div class="form-check">
                <input type="checkbox" name="item_types[]" value="{{ $value }}" 
                       class="form-check-input" 
                       id="type_{{ $value }}"
                       @if(is_array(old('item_types')) && in_array($value, old('item_types'))) checked @endif>
                <label class="form-check-label" for="type_{{ $value }}">{{ $label }}</label>
            </div>
            </div>
        @endforeach
      </div>
    </div>
      @error('item_types')
        <small class="text-danger">{{ $message }}</small>
      @enderror 
</div>

                                <div class="mb-3 col-md-6">
                                    <label for="image" class="form-label">Preview Image</label>
                                    <input class="form-control" type="file" name="image" id="image" />
                                    @error('image')
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
                                    <input class="form-control"  value="{{ old('external_id') }}"
                                        type="text" name="external_id" id="external_id" />
                                    @error('external_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <h6>Add-ons <i class="bx bx-info-circle text-danger"></i> </h6>
                                </div>
                                <div class="col-12">
                                    <div>
                                        <button type="button" id="addCollectionBtn" class="btn btn-dark"> <i
                                                class="bx bx-plus"></i> Add
                                            Collection</button>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <h6>Variants (Add price)</h6>
                                </div>
                                <div class="col-12" id="category_variants">

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
                                                <h6>Contains Cereals and Products Containing Gluten</h6>
                                                <div class="row">
                                                    @foreach ($allergens as $allergen)
                                                        @if ($allergen->type == 'cereals and gluten')
                                                            <!-- Allergen Category 1: Contains Cereals -->
                                                            <div class="col-sm-6">
                                                                <div class="form-check">
                                                                    <input name="cereal[]" class="form-check-input"
                                                                        type="checkbox" id="allergen{{ $allergen->id }}"
                                                                        value="{{ $allergen->name }}">
                                                                    <label class="form-check-label"
                                                                        for="allergen{{ $allergen->id }}">{{ $allergen->name }}</label>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <!-- Allergen Category 2: Contains Nuts -->
                                                <h6 class="mt-3">Contains Nuts and Products Thereof</h6>
                                                <div class="row">
                                                    @foreach ($allergens as $allergen)
                                                        @if ($allergen->type == 'nuts')
                                                            <div class="col-sm-6">
                                                                <div class="form-check">
                                                                    <input name="nuts[]" class="form-check-input"
                                                                        type="checkbox" id="allergen{{ $allergen->id }}"
                                                                        value="{{ $allergen->name }}">
                                                                    <label class="form-check-label"
                                                                        for="allergen{{ $allergen->id }}">{{ $allergen->name }}</label>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>

                                                <!-- Allergen Category 3: Further Allergens -->
                                                <h6 class="mt-3">Further Allergens</h6>
                                                <div class="row">
                                                    @foreach ($allergens as $allergen)
                                                        @if ($allergen->type == 'further allergens')
                                                            <div class="col-sm-6">
                                                                <div class="form-check">
                                                                    <input name="furthers[]" class="form-check-input"
                                                                        type="checkbox" id="allergen{{ $allergen->id }}"
                                                                        value="{{ $allergen->name }}">
                                                                    <label class="form-check-label"
                                                                        for="allergen{{ $allergen->id }}">{{ $allergen->name }}</label>
                                                                </div>
                                                            </div>
                                                        @endif
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
                                            <div class="row" id="collection_body">

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
                                <button type="submit" class="btn btn-primary me-2">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('vendor_custome_script')
    <script>
        document.getElementById('openModalBtn').addEventListener('click', function() {
            const allergenModal = new bootstrap.Modal(document.getElementById('allergenModal'));
            allergenModal.show();
        });
    </script>
    <script>
        $(document).ready(function() {
            var categoryOld = 0;
            $('#addCollectionBtn').on('click', function(e) {
                e.preventDefault();

                var category = $('#category').val();

                if (category === "") {
                    alert('Please select a category');
                    return;
                }
                if (categoryOld != category) {
                    categoryOld = category;
                    $.ajax({
                        url: '{{ route('vendor.get.category.collection') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            category: category
                        },
                        success: function(response) {
                            if (response.status) {
                                var data = response.data;
                                var html = '';
                                $.each(data, function(key, value) {
                                    html += `<div class="col-md-12">
                                            <div class="form-check mb-2">
                                                <input type="checkbox" name="collection[]" class="form-check-input" value="${value.id}" id="collection_${value.id}">
                                                <label class="form-check-label" for="collection_${value.id}">${value.name}</label>
                                            </div>
                                         </div>
                                    `;
                                });
                                $('#collection_body').html(html);
                                $('#addons').modal('show');
                            } else {
                                toastr.error(response.message);
                            }
                            // console.log('Collection added:', response);
                        },
                        error: function(xhr) {

                            console.log('Error:', xhr.responseText);
                        }
                    });
                } else {
                    $('#addons').modal('show');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.category_select').on('change', function() {
                var categoryId = $(this).val();
                // alert(categoryId);
                if (categoryId) {
                    $.ajax({
                        url: '{{ route('vendor.get.category.variants') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            category: categoryId
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status) {
                                var data = response.data;
                                if (Array.isArray(data) && data.length > 0) {
                                    var html = '';
                                    html += '<div class="row mb-2">';
                                    $.each(data, function(key, value) {
                                        html += `
                                          <div class="col-md-6 mb-3">
                                             <label for="variant_${value.id}">${value.name} ${value.other_info}</label>
                                            <div class="input-group">
                                                <input type="hidden" name="variants[]" value="${value.id}"/>
                                                <div class="input-group-text">
                                                  <div class="form-check form-switch " style="cursor: pointer;">
                                                    <input class="form-check-input" name="status[${value.id}][]" type="checkbox"
                                                        id="status-${value.id}" />
                                                    <label class="form-check-label"
                                                        for="status-${value.id}"></label>
                                                </div>
                                                </div>
                                                <input type="number" name="prices[]" class="form-control" placeholder="Please Enter Price" step="0.01" />
                                            </div>
                                          </div>
                                         
                                        `;
                                    });
                                    html += '</div">';
                                    $('#category_variants').html(html);
                                }else{
                                    var html=`
                                      <div class="row ">
                                         <div class="col-md-6 mt-3">
                                               <label for="delivery_price" class="form-label">Delivery Price</label>
                                               <input placeholder="Delivery price" class="form-control" step="0.01" type="number" name="delivery_price" id="delivery_price" />
                                         </div>
                                         <div class="col-md-6 mt-3">
                                               <label for="pickup_price" class="form-label">Pickup Price</label>
                                               <input placeholder="Pickup price" class="form-control" step="0.01" type="number" name="pickup_price" id="pickup_price" />
                                         </div>
                                      </div>
                                    `;
                                    $('#category_variants').html(html);
                                }
                            } else {
                                $('#category_variants').html('');
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            $('#category_variants').html('');
                            console.log('Error:', xhr.responseText);
                            alert('There was an error fetching variants.');
                        }
                    });
                } else {
                    $('#category_variants').html('');
                    toastr.warning('Please choose a category');
                }
            });


        });
    </script>
@endsection
