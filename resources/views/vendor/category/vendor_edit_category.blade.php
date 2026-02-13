@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Food Category</h5>
                        <small class="text-muted float-end">Edit Food Category</small>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('vendor.update.food.category') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" value="{{ $category->id }}">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Category Name</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-fullname2" class="input-group-text">
                                                <i class="bx bx-bowl-hot"></i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="Chinese, Italian"
                                                aria-label="Chinese" name="name" id="name"
                                                value="{{ $category->name }}" />
                                        </div>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="order">Order (Sort By)</label>
                                        <select class="form-control" name="order" id="order">
                                            <option value="">Select Order</option>
                                            @for ($i = 1; $i <= 50; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $category->sort == $i ? 'selected' : '' }}>{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('order')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="slug">Slug </label>

                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-link"></i></span>
                                    <input type="text" class="form-control" placeholder="italian-food" name="slug"
                                        value="{{ $category->slug }}" id="slug" />
                                </div>
                                <small class="text-muted">(Slug must be in small letters and please use
                                    "-" instead of space.)</small>
                                @error('slug')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Variants</label>
                                <div id="variants-wrapper">
                                    @if ($category->category_variants && count($category->category_variants) > 0)
                                        @foreach ($category->category_variants as $index => $variant)
                                            <div class="row variant-row mb-2">
                                                <input type="hidden" name="variants_ids[]" value="{{ $variant->id }}">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="variants_name[]"
                                                        value="{{ $variant->name }}"
                                                        placeholder="Variant Name (e.g., Small)" />
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="variants_info[]"
                                                        value="{{ $variant->other_info }}"
                                                        placeholder="Variant Info (e.g., 10 inches)" />
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger remove-variant"
                                                        data-id="{{ $variant->id }}">
                                                        <i class="bx bx-trash remove-variant"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary" id="add-variant">Add More
                                    Variant</button>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="image">Image (Web)</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-image"></i></span>
                                            <input type="file" id="image" class="form-control phone-mask"
                                                name="image" accept="image/*" />
                                        </div>
                                        @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    @if (isset($category->image) && !empty($category->image))
                                        <img style="height:4rem;width:7rem" class="mt-3"
                                            src="{{ asset('uploads/category/' . $category->image) }}" alt="">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="image">Image (Mobile)</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-image"></i></span>
                                            <input type="file" id="mobile_image" class="form-control phone-mask"
                                                name="mobile_image" accept="image/*" />
                                        </div>
                                        @error('mobile_image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    @if (isset($category->mobile_image) && !empty($category->mobile_image))
                                        <img style="height:4rem; width:4rem" class="mt-3"
                                            src="{{ asset('uploads/category/mobile/' . $category->mobile_image) }}"
                                            alt="">
                                    @endif
                                </div>
                                <div class="col-md-6 d-flex ">
                                    <div class="mb-3 me-3">
                                        <label class="form-label" for="discount">Discount</label>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" name="discount" @checked($category->discount == 1)
                                                type="checkbox" id="discount" />
                                            <label class="form-check-label" for="discount"></label>
                                        </div>
                                        @error('discount')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="status">Status</label>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" name="status" @checked($category->status == 1)
                                                type="checkbox" id="status" />
                                            <label class="form-check-label" for="status"></label>
                                        </div>
                                        @error('status')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-comment"></i></span>
                                    <textarea id="description" name="description" class="form-control" placeholder="Description about the category"> {{ $category->description }} </textarea>
                                </div>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
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
            // Function to add a new variant row
            $('#add-variant').click(function() {
                var newVariantRow = `
            <div class="row variant-row mb-2">
                <input type="hidden" name="variants_ids[]" value="">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="variants_name[]" placeholder="Variant Name (e.g., Small)" />
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="variants_info[]" placeholder="Variant Info (e.g., 10 inches)" />
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-variant">
                        <i class="bx bx-trash remove-variant"></i>
                        
                    </button>
                </div>
            </div>
        `;

                $('#variants-wrapper').append(newVariantRow); // Add the new variant row to the wrapper
            });

            // Function to remove a variant row
            $(document).on('click', '.remove-variant', function() {
                var variantRow = $(this).closest('.variant-row');
                var variantId = $(this).data('id');

                
                if (variantId) {
                    $.ajax({
                        url: '{{ route('vendor.delete.category-variant') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: variantId
                        },
                        success: function(response) {
                            // Remove the variant row from the DOM if successfully deleted
                            variantRow.remove();
                        },
                        error: function(response) {
                            alert('Error deleting variant.');
                        }
                    });
                } else {
                    // If no ID exists, simply remove the row from the DOM
                    variantRow.remove();
                }
            });
        });
    </script>
@endsection
