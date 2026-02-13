@extends('vendor.vendor-frame')
@section('custome_style')
    <style>
        .select2-container--default .select2-selection--multiple{
            border: 1px solid #ddd !important;
            padding: 7px 0px !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            background-color: #4CAF50 !important;
            color: #fff !important;
            
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
            color: #fff !important;
            border-color: #fff !important;
        }
    </style>
@endsection
@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between flex-wrap">
                        <h5 >Group Items</h5>
                        <a href="{{ route('editGroup', $group->id) }}">Group: {{ $group->name }}</a>
                        
                    </div>
                    <div class="card-body">
                        <form action="{{route('addGroupItems')}}" method="post" class="row">
                            @csrf
                            <input type="hidden" name="gid" value="{{$group->id}}">
                            <div class="col-md-6 mb-2">
                                <label for="example" class="form-label">Menu Items</label>
                                <select name="food_items[]" id="example" class="form-control" multiple>
                                    @foreach ($food_items as $food_item)
                                        <option value="{{ $food_item->id }}">{{ $food_item->food_item_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                             <div>
                                <button class="btn btn-primary" type="submit">Save</button>
                             </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Menu Name</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <a
                                                href="{{ route('vendor.edit.food', $item->food_item->id) }}">{{ $item->food_item->food_item_name }}</a>
                                        </td>
                                        <td>
                                            {{ $item->created_at }}
                                        </td>
                                        <td>
                                            <a id="delete" href="{{route('groupItemDelete',$item->id)}}" class="btn btn-danger btn-sm delete-btn"
                                                data-toggle="tooltip" data-placement="top" title="Delete">
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
        $('#example').select2()
    </script>
     <script>
    $(document).ready(function () {
        new DataTable('#datatable', {
            responsive: true,
            lengthMenu: [[-1, 10, 20, 50, 100, 200], ['All', 10, 20, 50, 100, 200]]
        });
    });
</script>
@endsection
