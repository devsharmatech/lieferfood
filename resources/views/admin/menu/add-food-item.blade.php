@extends('admin.main-frame')

@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">New Food Menu</span> </h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">Menu Details</h5>

                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.store.food') }}">
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
                                    <select id="category" name="category" class="select2 form-select">
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
                                    <label for="delivery_price" class="form-label">Delivery Price</label>
                                    <input class="form-control" value="{{ old('delivery_price') }}" step="0.01" type="number"
                                        name="delivery_price" id="delivery_price" placeholder="Price should be in €"/>
                                    @error('delivery_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="pickup_price" class="form-label">Pickup Price</label>
                                    <input class="form-control" value="{{ old('pickup_price') }}" step="0.01" type="number"
                                        name="pickup_price" id="pickup_price"  placeholder="Price should be in €" />
                                    @error('pickup_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="item_type" class="form-label">Item Type</label>
                                    <select id="item_type" name="item_type" class="select2 form-select">
                                        <option value="">Select Type</option>
                                        <option value="food-item" @selected(old('item_type') == 'food-item')>Food Item</option>
                                        <option value="non-alcoholic-drink" @selected(old('item_type') == 'non-alchoholic-drink')>Non Alcoholic Drink
                                        </option>
                                        <option value="alcoholic-drink" @selected(old('item_type') == 'alchoholic-drink')>Alcoholic Drink
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
                                    <input class="form-control" min="1" value="{{ old('external_id') }}"
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
                                <div class="col-md-12 mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input" name="hasVariants" type="checkbox" id="hasVariantsCheckbox">
                                        <label class="form-check-label" for="hasVariantsCheckbox">
                                            This food item has variants (e.g., Small, Large, Family)
                                        </label>
                                    </div>
                                    <div id="variantsSection" class="mt-4 d-none">
                                        <h4>Variants</h4>
                                        <div id="variantsContainer"></div>
                                        <button type="button" class="btn btn-primary mt-3" id="addVariantBtn">Add More Variant</button>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div id="extrasSection">
                                        <h6 class="mt-4">Extras <i class="bx bx-info-circle text-danger"></i> </h6>
                                        <div id="extrasContainer"></div>
                                        <button type="button" id="addExtraBtn" class="btn btn-primary btn-sm mt-2">Add
                                            Extra</button>
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
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="cereal[]" class="form-check-input"
                                                                type="checkbox" id="allergen1" value="Wheat">
                                                            <label class="form-check-label" for="allergen1">Wheat</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="cereal[]" class="form-check-input"
                                                                type="checkbox" id="allergen2" value="Rye">
                                                            <label class="form-check-label" for="allergen2">Rye</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="cereal[]" class="form-check-input"
                                                                type="checkbox" id="allergen3" value="Barley">
                                                            <label class="form-check-label" for="allergen3">Barley</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="cereal[]" class="form-check-input"
                                                                type="checkbox" id="allergen4" value="Oats">
                                                            <label class="form-check-label" for="allergen4">Oats</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="cereal[]" class="form-check-input"
                                                                type="checkbox" id="allergen5" value="Spelt">
                                                            <label class="form-check-label" for="allergen5">Spelt</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="cereal[]" class="form-check-input"
                                                                type="checkbox" id="allergen6" value="Kamut">
                                                            <label class="form-check-label" for="allergen6">Kamut</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Allergen Category 2: Contains Nuts -->
                                                <h6 class="mt-3">Contains Nuts and Products Thereof</h6>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="nuts[]" class="form-check-input"
                                                                type="checkbox" id="allergen7" value="Almonds">
                                                            <label class="form-check-label"
                                                                for="allergen7">Almonds</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="nuts[]" class="form-check-input"
                                                                type="checkbox" id="allergen8" value="Hazelnuts">
                                                            <label class="form-check-label"
                                                                for="allergen8">Hazelnuts</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="nuts[]" class="form-check-input"
                                                                type="checkbox" id="allergen9" value="Walnuts">
                                                            <label class="form-check-label"
                                                                for="allergen9">Walnuts</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="nuts[]" class="form-check-input"
                                                                type="checkbox" id="allergen10" value="Cashews">
                                                            <label class="form-check-label"
                                                                for="allergen10">Cashews</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="nuts[]" class="form-check-input"
                                                                type="checkbox" id="allergen11" value="Pecans">
                                                            <label class="form-check-label"
                                                                for="allergen11">Pecans</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="nuts[]" class="form-check-input"
                                                                type="checkbox" id="allergen12" value="Brazil nuts">
                                                            <label class="form-check-label" for="allergen12">Brazil
                                                                nuts</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="nuts[]" class="form-check-input"
                                                                type="checkbox" id="allergen13" value="Pistachios">
                                                            <label class="form-check-label"
                                                                for="allergen13">Pistachios</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="nuts[]" class="form-check-input"
                                                                type="checkbox" id="allergen14" value="Macadamia nuts">
                                                            <label class="form-check-label" for="allergen14">Macadamia
                                                                nuts</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Allergen Category 3: Further Allergens -->
                                                <h6 class="mt-3">Further Allergens</h6>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="furthers[]" class="form-check-input"
                                                                type="checkbox" id="allergen15"
                                                                value="Milk and dairy products">
                                                            <label class="form-check-label" for="allergen15">Milk and
                                                                dairy
                                                                products</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="furthers[]" class="form-check-input"
                                                                type="checkbox" id="allergen16"
                                                                value="Eggs and egg products">
                                                            <label class="form-check-label" for="allergen16">Eggs and egg
                                                                products</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="furthers[]" class="form-check-input"
                                                                type="checkbox" id="allergen17"
                                                                value="Fish and fish products">
                                                            <label class="form-check-label" for="allergen17">Fish and fish
                                                                products</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="furthers[]" class="form-check-input"
                                                                type="checkbox" id="allergen18"
                                                                value="Soy and soy products">
                                                            <label class="form-check-label" for="allergen18">Soy and soy
                                                                products</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="furthers[]" class="form-check-input"
                                                                type="checkbox" id="allergen19"
                                                                value="Peanuts and peanut products">
                                                            <label class="form-check-label" for="allergen19">Peanuts and
                                                                peanut
                                                                products</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="furthers[]" class="form-check-input"
                                                                type="checkbox" id="allergen20"
                                                                value="Sesame seeds and products">
                                                            <label class="form-check-label" for="allergen20">Sesame seeds
                                                                and
                                                                products</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="furthers[]" class="form-check-input"
                                                                type="checkbox" id="allergen21"
                                                                value="Lupin and lupin products">
                                                            <label class="form-check-label" for="allergen21">Lupin and
                                                                lupin
                                                                products</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="furthers[]" class="form-check-input"
                                                                type="checkbox" id="allergen22"
                                                                value="Celery and celery products">
                                                            <label class="form-check-label" for="allergen22">Celery and
                                                                celery
                                                                products</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="furthers[]" class="form-check-input"
                                                                type="checkbox" id="allergen23"
                                                                value="Mustard and mustard products">
                                                            <label class="form-check-label" for="allergen23">Mustard and
                                                                mustard
                                                                products</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input name="furthers[]" class="form-check-input"
                                                                type="checkbox" id="allergen24"
                                                                value="Molluscs and mollusc products">
                                                            <label class="form-check-label" for="allergen24">Molluscs and
                                                                mollusc
                                                                products</label>
                                                        </div>
                                                    </div>
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
                                                        <option value="{{ $collection->id }}">{{ $collection->name }}
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
                                                <label for="is_addons" class="btn btn-outline-primary">Save
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
@section('custome_script')
    <script>
        document.getElementById('openModalBtn').addEventListener('click', function() {
            const allergenModal = new bootstrap.Modal(document.getElementById('allergenModal'));
            allergenModal.show();
        });
    </script>
   
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hasVariantsCheckbox = document.getElementById('hasVariantsCheckbox');
            const variantsSection = document.getElementById('variantsSection');
            const variantsContainer = document.getElementById('variantsContainer');
            const addVariantBtn = document.getElementById('addVariantBtn');
    
            let variantCount = 0;
    
            // Toggle variants section visibility
            hasVariantsCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    variantsSection.classList.remove('d-none');
                } else {
                    variantsSection.classList.add('d-none');
                    variantsContainer.innerHTML = ''; // Clear all variants
                }
            });
    
            // Function to create a variant card
            function createVariantCard() {
                variantCount++;
                const variantCard = document.createElement('div');
                variantCard.classList.add('card', 'variant-card','mt-2');
                variantCard.setAttribute('id', `variantCard${variantCount}`);
                variantCard.innerHTML = `
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="variantName${variantCount}" class="form-label">Variant Name</label>
                                <input type="text" name="variant_names[]" class="form-control" id="variantName${variantCount}" placeholder="e.g., Small, Large">
                            </div>
                            <div class="col-md-4">
                                <label for="variantPrice${variantCount}" class="form-label">Price</label>
                                <input type="number" step="0.01" name="variant_prices[]" class="form-control" id="variantPrice${variantCount}" placeholder="Price in €">
                            </div>
                            <div class="col-md-4">
                                <label for="additionalDetails${variantCount}" class="form-label">Additional Details</label>
                                <input type="text" name="variant_details[]" class="form-control" id="additionalDetails${variantCount}" placeholder="e.g., 12-inch, 16-inch">
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-danger btn-sm deleteVariantBtn" data-id="${variantCount}">Delete</button>
                        </div>
                    </div>
                `;
                variantsContainer.appendChild(variantCard);
    
                // Add delete functionality to the delete button
                variantCard.querySelector('.deleteVariantBtn').addEventListener('click', function() {
                    const cardId = this.getAttribute('data-id');
                    document.getElementById(`variantCard${cardId}`).remove();
                });
            }
    
            // Add the first variant card when the page loads
            hasVariantsCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    createVariantCard();
                }
            });
    
            // Add more variants on button click
            addVariantBtn.addEventListener('click', function() {
                createVariantCard();
            });
        });
    </script>

    
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const extrasContainer = document.getElementById('extrasContainer');
        const addExtraBtn = document.getElementById('addExtraBtn');

        let extraCount = 0;

        // Function to create a row for an extra
        function createExtraRow() {
            extraCount++;
            const extraRow = document.createElement('div');
            extraRow.classList.add('row', 'mt-3', 'extra-row');
            extraRow.setAttribute('id', `extraRow${extraCount}`);

            extraRow.innerHTML = `
                <div class="col-md-3">
                    <input type="text" name="extra_names[]" class="form-control" placeholder="Extra Name" />
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="extra_prices[]" class="form-control" placeholder="Price in €" />
                </div>
                <div class="col-md-4">
                    <input type="text" name="extra_info[]" class="form-control" placeholder="Extra Info" />
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm deleteExtraBtn" data-id="${extraCount}">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            `;

            extrasContainer.appendChild(extraRow);

            // Add delete functionality to the delete button
            extraRow.querySelector('.deleteExtraBtn').addEventListener('click', function () {
                const rowId = this.getAttribute('data-id');
                document.getElementById(`extraRow${rowId}`).remove();
            });
        }

        // Add the first extra row on page load if needed
        // createExtraRow(); // Uncomment if you want one row to be created by default

        
        addExtraBtn.addEventListener('click', function () {
            createExtraRow();
        });
    });
</script>
@endsection
