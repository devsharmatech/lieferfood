@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="py-0">Collection</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" class="row" action="{{ route('vendor.create.collection') }}">
                            @csrf
                            <input type="hidden" name="id"
                                value="{{ isset($collection->id) ? $collection->id : '' }}">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Collection Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter collection Name"
                                    value="{{ isset($collection->name) ? $collection->name : '' }}">
                                @error('name')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="">Please select type</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->value }}">{{ $type->name }}</option>
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
                                    <option value="1">Multiple</option>
                                    <option value="0">Single</option>
                                </select>
                                @error('select_type')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="is_alcohal" class="form-label">Is Alcohol</label>
                                <select name="is_alcohal" id="is_alcohal" class="form-control">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                                @error('is_alcohal')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="sort" class="form-label">Sort (Order number) </label>
                                <input name="sort" type="number" placeholder="1" id="sort" class="form-control">
                                @error('sort')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="deposit" class="form-label">Deposit Amount (Return After Deposit)</label>
                                <input name="deposit" step=".01" type="number" placeholder="1" id="deposit" class="form-control">
                                <small class="text-muted" style="font-size:12px;">If There have any price of bottle for return!</small>
                                @error('deposit')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Description</label>

                                <textarea class="form-control" id="description" name="description" placeholder="Enter Food Group Description">{{ isset($collection->description) ? $collection->description : '' }}</textarea>


                                @error('description')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>

                            <div>
                                <button class="btn btn-primary" type="submit">Add</button>
                            </div>

                            <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-uppercase" id="dataModalLabel">Please choose</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                         <div class="form-check mx-3 mb-2">
                                           <input class="form-check-input" type="checkbox" id="selectAll">
                                           <label class="form-check-label" for="selectAll">Select All</label>
                                          </div>
                                        <div class="modal-body" id="modal-body">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary"
                                                data-bs-dismiss="modal">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Sort</th>
                                    <th>Type</th>
                                    <th>Deposit</th>
                                    <th>Description</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($collections as $collect)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $collect->name }}</td>
                                        <td>{{ isset($collect->category->name) ? $collect->category->name : '' }}</td>
                                        <td>{{ $collect->sort }}</td>
                                        <td>{{ $collect->isMultiple == '1' ? 'Multiple' : 'Single' }}</td>
                                        <td>{{ $collect->return_price ?? '' }}</td>
                                        <td>
                                            <div style="text-align:justify;">
                                                {{ $collect->description }}
                                            </div>
                                        </td>
<td>
    <a href="{{ route('vendor.edit.collection', $collect->id) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="bx bx-edit"></i>
                                            </a>
</td>
                                        <td>
                                            
                                            <a href="{{ route('vendor.delete.collection', $collect->id) }}" id="delete"
                                                class="btn btn-sm btn-danger">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('vendor_custome_script')
     <script>
    $(document).ready(function () {
        new DataTable('#datatable', {
            responsive: true,
            ordering:false,
            lengthMenu: [[-1, 10, 20, 50, 100, 200], ['All', 10, 20, 50, 100, 200]]
        });
    });
</script>
    <script>
       
        $(document).ready(function() {
            // Variables to store the previous selected values
            var prevCategory = '';
            var prevType = '';

            $('#type').change(function() {
                var type = $(this).val();
                var category = $('#category').val();

                // Check if category or type is empty
                if (type == '' || category == '') {
                    toastr.error('Please choose category and type!');
                    return;
                }

                // If the user selects the same category and type, do not render again
                if (type == prevType && category == prevCategory) {
                    toastr.info('You have already selected this category and type.');
                    return;
                }

                // Update the previous selections
                prevType = type;
                prevCategory = category;

                $.ajax({
                    url: "{{ route('vendor.food-sub-items.get') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        type: type,
                        category: category
                    },
                    success: function(response) {
                        if (response.status) {
                            console.log(response);
                            $('#dataModalLabel').text(`Please choose ${type}(s)`);
                            let modalBody = '';
                            let columnCount = 0;

                            $.each(response.data, function(index, item) {
                                var sizes = '';
                                var isChecked = false;
                                var itemData = null;

                                // Check if collectionItems exists, is an array, and is not empty
                                if (response.collectionItems && Array.isArray(response
                                        .collectionItems) && response.collectionItems
                                    .length > 0) {
                                    // Find the item in collectionItems
                                    itemData = response.collectionItems.find(colItem =>
                                        colItem.item_id === item.id);
                                    // If itemData exists, mark the checkbox as checked
                                    if (itemData) {
                                        isChecked = true;
                                    }
                                }

                                // Always render the size input fields
                                $.each(response.variant, function(key, size) {
                                    let priceValue = '';

                                    // If itemData exists and contains prices for this size, fill the price
                                    if (isChecked && itemData && itemData
                                        .prices[size.id]) {
                                        priceValue = itemData.prices[size
                                        .id]; // Fill price from the existing data
                                    }

                                    sizes += `
                                <div class="col-md-3 col-sm-3 col-4">
                                    <div class="input-group mb-2">
                                        
                                        <input type="number" step="0.01" class="form-control rounded-0" name="prices[${item.id}][${size.id}]" value="${priceValue}" placeholder="${size.name}">
                                        <span class="input-group-text">&euro;</span>
                                    </div>
                                </div>
                            `;
                                });

                                // Render the item checkbox and size inputs regardless of whether collectionItems is empty or not
                                modalBody += `
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input item-checkbox" type="checkbox" value="${item.id}" name="item[${item.id}]" id="item-${item.id}" ${isChecked ? 'checked' : ''}>
                                        <label class="form-check-label" for="item-${item.id}">${item.name} - ${item.price}&euro;</label>
                                    </div>
                                </div>
                                ${sizes}
                                <hr>
                            </div>
                        `;

                                columnCount++;
                            });

                            $('#modal-body').html(modalBody);
                            $('#dataModal').modal('show');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            });
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll');

        selectAllCheckbox.addEventListener('change', function () {
            const allCheckboxes = document.querySelectorAll('#modal-body .item-checkbox');
            allCheckboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
        });

        // Optional: If any individual checkbox is unchecked, uncheck "Select All"
        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('item-checkbox')) {
                const allCheckboxes = document.querySelectorAll('#modal-body .item-checkbox');
                const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
            }
        });
    });
</script>

@endsection
