@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="py-0">Edit Collection</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" class="row" action="{{ route('vendor.create.collection') }}">
                            @csrf
                            <input type="hidden" name="id"
                                value="{{ isset($collection->id) ? $collection->id : '' }}">
                            <div class="col-md-4 mb-3">
                                <label for="name" class="form-label">Collection Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter collection Name"
                                    value="{{ isset($collection->name) ? $collection->name : '' }}">
                                @error('name')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select name="category" id="category" class="form-control preventselect" >
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option @selected($category->id == $collection->category_id) value="{{ $category->id }}">
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select name="type" id="type"  class="form-control preventselect" >
                                    <option value="">Please select type</option>
                                   
                                      @foreach ($types as $type)
                                        <option @selected($collection->type == $type->value) value="{{ $type->value }}">{{ $type->name }}</option>
                                     @endforeach
                                </select>
                                @error('type')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="select_type" class="form-label">Select Type</label>
                                <select name="select_type" id="select_type" class="form-control">
                                    <option value="">Please choose</option>
                                    <option @selected($collection->isMultiple=="1") value="1">Multiple</option>
                                    <option @selected($collection->isMultiple=="0") value="0">Single</option>
                                </select>
                                @error('select_type')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="is_alcohal" class="form-label">Is Alcohol</label>
                                <select name="is_alcohal" id="is_alcohal" class="form-control">
                                    <option value="0" @selected($collection->isAlcohal=="0")>No</option>
                                    <option value="1" @selected($collection->isAlcohal=="1")>Yes</option>
                                </select>
                                @error('is_alcohal')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="sort" class="form-label">Sort (Order number) </label>
                                <input name="sort" type="number" placeholder="1" id="sort" class="form-control" value="{{$collection->sort}}">
                                @error('sort')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                             <div class="col-md-4 mb-3">
                                <label for="deposit" class="form-label">Deposit Amount (Return After Deposit)</label>
                                <input name="deposit" type="number" step=".01" placeholder="1" id="deposit" value="{{$collection->return_price ?? ''}}" class="form-control">
                                <small class="text-muted" style="font-size:12px;">If There have any price of bottle for return!</small>
                                @error('deposit')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    @php
                                        $checkedItems = collect($collection_items)->keyBy('item_id');
                                    @endphp
                                    @foreach ($food_sub_items as $item)
                                        <div class="col-12 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    @if (isset($checkedItems[$item->id])) checked @endif
                                                    value="{{ $item->id }}" name="item[{{ $item->id }}]"
                                                    id="item-{{ $item->id }}">
                                                <label class="form-check-label"
                                                    for="item-{{ $item->id }}">{{ $item->name }} -
                                                    {{ $item->price }}&euro;</label>
                                            </div>
                                        </div>
                                        @if (isset($collection_category->category_variants) && $collection_category->category_variants != null)
                                            @foreach ($collection_category->category_variants as $key => $variant)
                                                @php
                                                    $variantPrices = isset($checkedItems[$item->id])
                                                        ? json_decode($checkedItems[$item->id]->prices, true)
                                                        : [];
                                                    $priceForVariant = $variantPrices[$variant->id] ?? '';
                                                @endphp
                                                <div class="col-md-3 col-sm-3 col-4">
                                                    <div class="input-group mb-2">
                                                        <span class="input-group-text">&euro;</span>
                                                        <input type="number" step="0.01"
                                                            class="form-control rounded-0"
                                                            name="prices[{{ $item->id }}][{{ $variant->id }}]"
                                                            value="{{ $priceForVariant }}"
                                                            placeholder="{{ $variant->name }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Description</label>

                                <textarea class="form-control" id="description" name="description" placeholder="Enter Food Group Description">{{ isset($collection->description) ? $collection->description : '' }}</textarea>


                                @error('description')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>

                            <div>
                                <button class="btn btn-primary" type="submit">Save Changes</button>
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
            $('.preventselect').on('mousedown', function(e) {
                e.preventDefault(); 
            });
        });
    </script>
@endsection
