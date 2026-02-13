@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Update Food Menu</span> </h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">Edit Menu Details</h5>

                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('vendor.update.food') }}">
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
                                    <select id="category" name="category" class="select form-select">
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
    <label for="item_type" class="form-label">Item Type</label>
    <select id="item_type" name="item_type" class="select2 form-select">
        <option value="">Select Type</option>

        <!-- General -->
        <optgroup label="General">
            <option value="food-item" @selected($food->item_type == 'food-item')>🍽️ Food Item</option>
            <option value="veg" @selected($food->item_type == 'veg')>🥦 Vegetarian</option>
            <option value="veg2" @selected($food->item_type == 'veg2')>🍃 Vegetarian</option>
            <option value="non-veg" @selected($food->item_type == 'non-veg')>🍖 Non-Vegetarian</option>
            <option value="vegan" @selected($food->item_type == 'vegan')>🌱 Vegan</option>
            <option value="eggetarian" @selected($food->item_type == 'eggetarian')>🥚 Eggetarian</option>
            <option value="pescatarian" @selected($food->item_type == 'pescatarian')>🐟 Pescatarian</option>
            <option value="halal" @selected($food->item_type == 'halal')>🕌 Halal</option>
            <option value="jain-food" @selected($food->item_type == 'jain-food')>🧘 Jain Food</option>
            <option value="gluten-free" @selected($food->item_type == 'gluten-free')>🚫🌾 Gluten-Free</option>
            <option value="organic" @selected($food->item_type == 'organic')>🍃 Organic</option>
            <option value="spicy" @selected($food->item_type == 'spicy')>🌶️ Hot & Spicy</option>
        </optgroup>
        <!-- Sauce -->
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
            <option value="chicken" @selected($food->item_type == 'chicken')>🐔 Chicken</option>
            <option value="lamb" @selected($food->item_type == 'lamb')>🐑 Lamb</option>
            <option value="beef" @selected($food->item_type == 'beef')>🐃 Beef</option>
            <option value="cow" @selected($food->item_type == 'cow')>🐂 Cow</option>
            <option value="pig" @selected($food->item_type == 'pig')>🐖 Pork</option>
            <option value="goat" @selected($food->item_type == 'goat')>🐐 Goat</option>
            <option value="duck" @selected($food->item_type == 'duck')>🦆 Duck</option>
            <option value="turkey" @selected($food->item_type == 'turkey')>🦃 Turkey</option>
            <option value="fish" @selected($food->item_type == 'fish')>🐠 Fish</option>
            <option value="shrimp" @selected($food->item_type == 'shrimp')>🍤 Shrimp</option>
            <option value="seafood" @selected($food->item_type == 'seafood')>🦐 Seafood</option>
        </optgroup>

        <!-- Fast Food -->
        <optgroup label="Fast Food">
            <option value="burger" @selected($food->item_type == 'burger')>🍔 Burger</option>
            <option value="pizza" @selected($food->item_type == 'pizza')>🍕 Pizza</option>
            <option value="sandwich" @selected($food->item_type == 'sandwich')>🥪 Sandwich</option>
            <option value="fries" @selected($food->item_type == 'fries')>🍟 Fries</option>
            <option value="taco" @selected($food->item_type == 'taco')>🌮 Taco</option>
            <option value="hotdog" @selected($food->item_type == 'hotdog')>🌭 Hot Dog</option>
        </optgroup>

        <!-- Drinks -->
        <optgroup label="Drinks">
            <option value="non-alcoholic-drink" @selected($food->item_type == 'non-alcoholic-drink')>🥤 Non-Alcoholic Drink</option>
            <option value="alcoholic-drink" @selected($food->item_type == 'alcoholic-drink')>🍸 Alcoholic Drink</option>
            <option value="beer" @selected($food->item_type == 'beer')>🍺 Beer</option>
            <option value="beer-mug" @selected($food->item_type == 'beer-mug')>🍻 Beer Mug</option>
            <option value="red-wine" @selected($food->item_type == 'red-wine')>🍷 Red Wine</option>
            <option value="white-wine" @selected($food->item_type == 'white-wine')>🥂 White Wine</option>
            <option value="cocktail" @selected($food->item_type == 'cocktail')>🍹 Cocktail</option>
            <option value="whiskey" @selected($food->item_type == 'whiskey')>🥃 Whiskey</option>
            <option value="sparkling-wine" @selected($food->item_type == 'sparkling-wine')>🥂 Sparkling Wine</option>
            <option value="coffee" @selected($food->item_type == 'coffee')>☕ Coffee</option>
            <option value="tea" @selected($food->item_type == 'tea')>🫖 Tea</option>
        </optgroup>

        <!-- Desserts -->
        <optgroup label="Desserts">
            <option value="ice-cream1" @selected($food->item_type == 'ice-cream1')>🍦 Ice Cream (Cone)</option>
            <option value="ice-cream2" @selected($food->item_type == 'ice-cream2')>🍨 Ice Cream (Cup)</option>
            <option value="ice-cream3" @selected($food->item_type == 'ice-cream3')>🍧 Shaved Ice</option>
            <option value="cake" @selected($food->item_type == 'cake')>🍰 Cake</option>
            <option value="chocolate" @selected($food->item_type == 'chocolate')>🍫 Chocolate</option>
            <option value="donut" @selected($food->item_type == 'donut')>🍩 Donut</option>
            <option value="cookie" @selected($food->item_type == 'cookie')>🍪 Cookie</option>
        </optgroup>

        <!-- Other -->
        <optgroup label="Other">
            <option value="cheese" @selected($food->item_type == 'cheese')>🧀 Cheese</option>
            <option value="salad" @selected($food->item_type == 'salad')>🥗 Salad</option>
            <option value="pasta" @selected($food->item_type == 'pasta')>🍝 Pasta</option>
            <option value="rice" @selected($food->item_type == 'rice')>🍚 Rice</option>
            <option value="bread" @selected($food->item_type == 'bread')>🍞 Bread</option>
            <option value="soup" @selected($food->item_type == 'soup')>🥣 Soup</option>
            <option value="fruit" @selected($food->item_type == 'fruit')>🍎 Fruit</option>
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
            $oldTypes = json_decode($food->types, true) ?? [];
        @endphp

        @foreach($types as $value => $label)
            <div class="col-md-4 mb-1">
                <div class="form-check">
                    <input type="checkbox" name="item_types[]" value="{{ $value }}" 
                           class="form-check-input" 
                           id="type_{{ $value }}"
                           @if(is_array($oldTypes) && in_array($value, $oldTypes)) checked @endif>
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
                                    <div class="input-group input-group-merge" style="cursor: pointer;"
                                        data-bs-toggle="modal" data-bs-target="#allergenModal">

                                        <input type="text" class="form-control" readonly />
                                        <span class="input-group-text">
                                            <i class="bx bx-edit-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="external_id" class="form-label">External Id</label>
                                    <input class="form-control"  value="{{ $food->external_id }}"
                                        type="text" name="external_id" id="external_id" />
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

                                <div class="col-12 mt-4">
                                    <h6 class="fw-bold fs-6">Variants</h6>
                                    <div class="row">
                                        @if ($food->hasVariants == 1)
                                            @foreach ($variants as $key => $variant)
                                                @php

                                                    $foodVariant = collect($food->variants)->firstWhere(
                                                        'variant_id',
                                                        $variant->id,
                                                    );
                                                @endphp

                                                <div class="col-md-3 col-sm-4 col-12 mb-3">
                                                    <label for="variant_{{ $variant->id }}">{{ $variant->name }}
                                                        {{ $variant->other_info }}</label>
                                                    <div class="input-group">
                                                        <input type="hidden" name="variants[]"
                                                            value="{{ $variant->id }}" />
                                                        <div class="input-group-text">
                                                            <div class="form-check form-switch" style="cursor: pointer;">
                                                                <input class="form-check-input"
                                                                    name="status[{{ $variant->id }}][]" type="checkbox"
                                                                    id="status-{{ $variant->id }}"
                                                                    @if ($foodVariant) checked @endif />
                                                                <label class="form-check-label"
                                                                    for="status-{{ $variant->id }}"></label>
                                                            </div>
                                                        </div>
                                                        <input type="number" name="prices[{{ $variant->id }}]"
                                                            class="form-control" placeholder="Please Enter Price"
                                                            step="0.01"
                                                            value="{{ $foodVariant ? $foodVariant['price'] : '' }}" />
                                                        <!-- Prefill price if exists -->
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-md-6 mt-3">
                                                <label for="delivery_price" class="form-label">Delivery Price</label>
                                                <input type="number" step="0.01" value="{{$food->delivery_price}}" name="delivery_price" id="delivery_price" placeholder="Delivery Price" class="form-control" />
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="pickup_price" class="form-label">Pickup Price</label>
                                                <input type="number" step="0.01" value="{{$food->pickup_price}}" name="pickup_price" id="pickup_price" placeholder="Pickup Price" class="form-control" />
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            {{-- model data here --}}
                            <div class="modal fade" id="allergenModal" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
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

                                                        $selectedCereal = json_decode(
                                                            isset($food->cereal) && $food->cereal != null
                                                                ? $food->cereal
                                                                : null,
                                                        );
                                                        $selectedCereal =
                                                            $selectedCereal != null ? $selectedCereal : [];

                                                    @endphp

                                                    @foreach ($allergens as $key => $allergen)
                                                        @if ($allergen->type == 'cereals and gluten')
                                                            <div class="col-sm-6">
                                                                <div class="form-check">
                                                                    <input name="cereal[]" class="form-check-input"
                                                                        type="checkbox" id="allergen{{ $key + 1 }}"
                                                                        value="{{ $allergen->name }}"
                                                                        @if (in_array($allergen->name, $selectedCereal)) checked @endif>
                                                                    <label class="form-check-label"
                                                                        for="allergen{{ $key + 1 }}">{{ $allergen->name }}</label>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>

                                                <!-- Allergen Category 2: Contains Nuts -->
                                                <h6 class="mt-3">Contains Nuts and Products Thereof</h6>
                                                <div class="row">
                                                    @php

                                                        $selectedNuts = json_decode(
                                                            isset($food->nuts) && $food->nuts != null
                                                                ? $food->nuts
                                                                : null,
                                                        );
                                                        $selectedNuts = $selectedNuts != null ? $selectedNuts : [];
                                                    @endphp

                                                    @foreach ($allergens as $key => $allergen)
                                                        @if ($allergen->type == 'nuts')
                                                            <div class="col-sm-6">
                                                                <div class="form-check">
                                                                    <input name="nuts[]" class="form-check-input"
                                                                        type="checkbox"
                                                                        id="allergen_nut{{ $key + 7 }}"
                                                                        value="{{ $allergen->name }}"
                                                                        @if (in_array($allergen->name, $selectedNuts)) checked @endif>
                                                                    <label class="form-check-label"
                                                                        for="allergen_nut{{ $key + 7 }}">{{ $allergen->name }}</label>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>

                                                <!-- Allergen Category 3: Further Allergens -->
                                                <h6 class="mt-3">Further Allergens</h6>
                                                <div class="row">
                                                    @php

                                                        $selectedFurthers = json_decode(
                                                            isset($food->furthers) && $food->furthers != null
                                                                ? $food->furthers
                                                                : null,
                                                        );
                                                        $selectedFurthers =
                                                            $selectedFurthers != null ? $selectedFurthers : [];
                                                    @endphp

                                                    @foreach ($allergens as $key => $allergen)
                                                        @if ($allergen->type == 'further allergens')
                                                            <div class="col-sm-6">
                                                                <div class="form-check">
                                                                    <input name="furthers[]" class="form-check-input"
                                                                        type="checkbox"
                                                                        id="allergen_furth{{ $key + 15 }}"
                                                                        value="{{ $allergen->name }}"
                                                                        @if (in_array($allergen->name, $selectedFurthers)) checked @endif>
                                                                    <label class="form-check-label"
                                                                        for="allergen_furth{{ $key + 15 }}">{{ $allergen->name }}</label>
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
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="collectionModalLabel">Choose a Collection</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3 row">
                                                @php

                                                    $selectedCollections = json_decode(
                                                        isset($food->collections) && $food->collections != null
                                                            ? $food->collections
                                                            : [],
                                                    );
                                                    $selectedCollections =
                                                        $selectedCollections != null ? $selectedCollections : [];
                                                @endphp
                                                @foreach ($collections as $collection)
                                                    <div class="col-md-12">
                                                        <div class="form-check mb-2">
                                                            <input type="checkbox" name="collection[]"
                                                                class="form-check-input" value="{{ $collection->id }}"
                                                                id="collection_{{ $collection->id }}"
                                                                @if (in_array($collection->id, $selectedCollections)) checked @endif>
                                                            <label class="form-check-label"
                                                                for="collection_{{ $collection->id }}">{{ $collection->name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach


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


                </div>

            </div>
        </div>
    </div>
@endsection
@section('vendor_custome_script')
    <script>
        $(document).ready(function() {
            $('.select').on('mousedown', function(e) {
                e.preventDefault();
            });
        });
    </script>
@endsection
