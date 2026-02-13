@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Food Category</h5>
                        <small class="text-muted float-end">Add New Food Category</small>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('vendor.store.food.category') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Category Name</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-fullname2" class="input-group-text">
                                                <i class="bx bx-bowl-hot"></i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="Chinese, Italian"
                                                aria-label="Chinese" name="name" id="name"
                                                value="{{ old('name') }}" />
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
                                                    {{ old('order') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('order')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Variants Section -->
                            <div class="mb-3">
                                <label class="form-label">Variants</label>
                                <div id="variants-wrapper">
                                    <div class="row variant-row mb-2">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="variants_name[]"
                                                placeholder="Variant Name (e.g., Small)" />
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="variants_info[]"
                                                placeholder="Variant Info (e.g., 10 inches)" />
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger remove-variant">
                                                <i class="bx bx-trash remove-variant"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary btn-sm" id="add-variant">Add More Variant</button>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="slug">Slug </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-link"></i></span>
                                    <input type="text" class="form-control" placeholder="italian-food" name="slug"
                                        value="{{ old('slug') }}" id="slug" />
                                </div>
                                <small class="text-muted">(Slug must be in small letters and please use "-" instead of
                                    space.)</small>
                                @error('slug')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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
                                </div>
                                <div class="col-md-6 d-flex ">
                                    <div class="mb-3 me-3">
                                        <label class="form-label" for="discount">Discount</label>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" name="discount" @checked(old('discount'))
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
                                            <input class="form-check-input" name="status" @checked(old('status'))
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
                                    <textarea id="description" name="description" class="form-control" placeholder="Description about the category">{{ old('description') }}</textarea>
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
        let variantIndex = 1;

        document.getElementById('add-variant').addEventListener('click', function() {
            const wrapper = document.getElementById('variants-wrapper');
            const newVariant = document.createElement('div');
            newVariant.classList.add('row', 'variant-row', 'mb-2');
            newVariant.innerHTML = `
            <div class="col-md-5">
                <input type="text" class="form-control" name="variants_name[]" placeholder="Variant Name (e.g., Large)" />
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control" name="variants_info[]" placeholder="Variant Info (e.g., 12 inches)" />
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-variant">
                    <i class="bx bx-trash remove-variant"></i>
                </button>
            </div>
        `;
            wrapper.appendChild(newVariant);
            variantIndex++;
        });

        document.getElementById('variants-wrapper').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-variant')) {
                e.target.closest('.variant-row').remove();
            }
        });
    </script>
@endsection
