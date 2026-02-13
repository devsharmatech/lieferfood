@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Menu Option values</h5>
                       
                        <p class="fw-bold btn btn-info"> {{ isset($menu_item_option->option_name) ? $menu_item_option->option_name : '' }} </p>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('addMenuOptionValues') }}" class="row">
                            @csrf
                            <input type="hidden" name="mid"
                                value="{{ isset($menu_item_option->id) ? $menu_item_option->id : '' }}">
                            <input type="hidden" name="id"
                                value="{{ isset($menu_option_value->id) ? $menu_option_value->id : '' }}">
                            <div class="col-md-6">
                                <label for="value" class="form-label">Value</label>
                                <input type="text" class="form-control" name="value" id="value"
                                    value="{{ isset($menu_option_value->value) ? $menu_option_value->value : '' }}" placeholder="Value">
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <div class="input-group">
                                    <input type="number"
                                        value="{{ isset($menu_option_value->price_adjustment) ? $menu_option_value->price_adjustment : '' }}"
                                        class="form-control" id="option_name" name="price" placeholder="Price" />
                                    <button class=" btn btn-primary" type="submit" id="add_option">Add</button>
                                </div>
                                @error('price')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>

                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Food Name</th>
                                    <th>Value</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($menu_option_values as $menu_option_value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td></td>
                                        <td>{{ $menu_option_value->value }}</td>
                                        <td>{{ $menu_option_value->price_adjustment }}</td>

                                        <td>
                                            <a href="{{ route('editMenuOptionValues', [$menu_option_value->menu_item_option_id,$menu_option_value->id]) }}"
                                                class="btn btn-sm btn-info">Edit</a>
                                            <a href="{{ route('menuOptionValuesDelete', [$menu_option_value->menu_item_option_id,$menu_option_value->id]) }}" id="delete"
                                                class="btn btn-sm btn-danger">Delete</a>
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
            lengthMenu: [[-1, 10, 20, 50, 100, 200], ['All', 10, 20, 50, 100, 200]]
        });
    });
</script>
@endsection
