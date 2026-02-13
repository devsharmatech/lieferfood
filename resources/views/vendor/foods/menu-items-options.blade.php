@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Menu Options</h5>

                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('addMenuItemOption')}}" class="row">
                            @csrf
                            <div class="col-md-6">
                                <input type="hidden" name="id" value="{{isset($menu_option->id)?$menu_option->id:''}}">
                                <label for="menu_item" class="form-label">Menu Item</label>
                                <select name="menu_item" id="menu_item" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($menu_items as $menu_item)
                                        <option @selected(isset($menu_option->menu_item_id) && $menu_option->menu_item_id==$menu_item->id) value="{{ $menu_item->id }}">{{ $menu_item->food_item_name }}</option>
                                    @endforeach
                                </select>
                                @error('menu_item')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="option_name" class="form-label">Option Name</label>
                                <div class="input-group">
                                    <input type="text" value="{{isset($menu_option->option_name)?$menu_option->option_name:''}}" class="form-control" id="option_name" name="option_name" placeholder="Option name"/>
                                    <button class=" btn btn-primary" type="submit" id="add_option">Add</button>
                                </div>
                                @error('option_name')
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
                                    <th>Option Name</th>
                                    <th>Food Name</th>
                                    {{-- <th>Values</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($menu_item_options as $menu_item_option)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $menu_item_option->option_name }}</td>
                                        <td>
                                            <a href="{{route('vendor.edit.food',isset($menu_item_option->food_item->id) ? $menu_item_option->food_item->id : '')}}">{{ isset($menu_item_option->food_item->food_item_name) ? $menu_item_option->food_item->food_item_name : '' }}</a>
                                        </td>
                                        {{-- <td>
                                            <a href="{{route('menuItemOptionValues',$menu_item_option->id)}}">Values</a>
                                        </td> --}}
                                        <td>
                                            <a href="{{route('editMenuOption',$menu_item_option->id)}}" class="btn btn-sm btn-info">Edit</a>
                                            <a href="{{route('deleteMenuOption',$menu_item_option->id)}}" id="delete" class="btn btn-sm btn-danger">Delete</a>
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
