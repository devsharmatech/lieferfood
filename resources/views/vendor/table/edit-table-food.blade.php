@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Update Table Food</span> </h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">Edit Menu Details</h5>

                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('vendor.update-table.food') }}">
                            @csrf

                            <div class="row">
                                <input type="hidden" name="id" value="{{ $food->id }}">
                                <div class="mb-3 col-md-6">
                                    <label for="food_name" class="form-label">Food Name</label>
                                    <input class="form-control" value="{{ $food->name }}" type="text"
                                        id="food_name" name="food_name" autofocus />
                                    @error('food_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="price" class="form-label">Price</label>
                                    <input class="form-control" value="{{ $food->price }}" type="number" step="0.01" name="price"
                                        id="price" />
                                    @error('price')
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
                               
                                <div class="mb-3 col-md-3">
                                    <label for="discount" class="form-label">Discount (In percent)</label>
                                    <input class="form-control" type="number" value="{{ $food->discount }}"
                                        name="discount" id="discount" />
                                    @error('discount')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                <div class="mb-3 col-md-3">
                                    <label for="prep_time" class="form-label">Prep time (In minutes)</label>
                                    <input class="form-control" type="number" value="{{ $food->preparation_time }}"
                                        name="prep_time" id="prep_time" />
                                    @error('prep_time')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="is_vegetarian" class="form-label">Vegetarian</label>
                                    <select id="is_vegetarian" name="is_vegetarian" class="select2 form-select">
                                        <option value="">Select Vegetarian</option>
                                        <option value="1" @selected($food->is_vegetarian == 1)>Yes</option>
                                        <option value="0" @selected($food->is_vegetarian == 0)>No</option>
                                    </select>
                                    @error('is_vegetarian')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                               
                                <div class="mb-3 col-md-4">
                                    <label for="is_spicy" class="form-label">Spicy</label>
                                    <select id="is_spicy" name="is_spicy" class="select2 form-select">
                                        <option value="">Select</option>
                                        <option value="1" @selected($food->is_spicy == 1)>Yes</option>
                                        <option value="0" @selected($food->is_spicy == 0)>No</option>
                                    </select>
                                    @error('is_spicy')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="is_available" class="form-label">Is Available</label>
                                    <select id="is_available" name="is_available" class="select2 form-select">
                                        <option value="">Select</option>
                                        <option value="1" @selected($food->is_available == 1)>Yes</option>
                                        <option value="0" @selected($food->is_available == 0)>No</option>
                                    </select>
                                    @error('is_available')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="image" class="form-label">Food Image</label>
                                    <input type="file" id="upload" name="image" class="form-control"
                                        accept="image/*" />
                                    @error('image')
                                        <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                    <div class="mt-3">
                                        <img src="{{ asset('uploads/table-foods/' . $food->image) }}" style="height:4rem;"
                                            alt="">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="d-flex mb-2 justify-content-between align-items-center">
                                        <label class="form-label">Ingredients</label>
                                        <button type="button" class="btn btn-sm btn-primary" id="add-ingredient">
                                            <i class="bx bx-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div id="ingredient-container">
                                        @if (isset($food->ingredients) && json_decode($food->ingredients) != null)
                                            @foreach (json_decode($food->ingredients) as $ingredient)
                                                <div class="input-group mb-2">
                                                    <input type="text" value="{{ $ingredient }}"
                                                        name="ingredients[]" class="form-control" />
                                                    <button type="button"
                                                        class="input-group-btn btn btn-sm btn-danger remove-ingredient"> X
                                                    </button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="input-group">
                                                <input type="text" name="ingredients[]" class="form-control" />
                                                <button disabled type="button"
                                                    class="input-group-btn btn btn-sm btn-danger remove-ingredient"> X
                                                </button>
                                            </div>
                                        @endif
                                        @error('ingredients')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="5">{{ $food->description }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
@section('vendor_custome_script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addIngredientButton = document.getElementById('add-ingredient');
            const ingredientContainer = document.getElementById('ingredient-container');

            // Add new ingredient input field
            addIngredientButton.addEventListener('click', function() {
                const newIngredient = document.createElement('div');
                newIngredient.classList.add('input-group', 'mt-3');

                newIngredient.innerHTML = `
        <input type="text" name="ingredients[]" class="form-control" />
        <button type="button" class="input-group-btn btn btn-sm btn-danger remove-ingredient"> X
        </button>
    `;

                ingredientContainer.appendChild(newIngredient);
            });

            // Remove ingredient input field
            ingredientContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-ingredient')) {
                    const ingredientInputGroup = event.target.closest('.input-group');
                    ingredientInputGroup.remove();
                }
            });
        });
    </script>
@endsection
