@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Taxes</h5>
                        
                    </div>
                    <div class="card-body">
                        <form class="row" action="{{route('vendor.save.tax')}}" method="post" >
                            @csrf
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                   <input type="text" placeholder="Enter tax name" name="tax_name" class="form-control" value="{{$tax->name ?? ''}}"/> 
                                   <input type="hidden" name="id" class="form-control" value="{{$tax->id ?? ''}}"/> 
                                </div>
                            </div>
                            <div class="col-md-4 mt-3">
                                 <div class="form-group">
                                <select class="form-control form-select" name="type">
                                    <option value="">Select Type</option>
                                    <option @selected(isset($tax->type) && $tax->type=="food") value="food">Food</option>
                                    <option @selected(isset($tax->type) && $tax->type=="drink") value="drink">Drink</option>
                                    <option @selected(isset($tax->type) && $tax->type=="alcohol") value="alcohol">Alcohol</option>
                                    <option @selected(isset($tax->type) && $tax->type=="other") value="other">Other</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-md-4  mt-3">
                                <div class="input-group">
                                   <input type="number" step="0.01" class="form-control" name="tax_value" value="{{$tax->value ?? 00}}"/>
                                   <button class="btn btn-primary input-group-btn" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Taxes Name</th>
                                    <th>Percentage</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($taxes ?? [] as $tax)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $tax->name ?? '' }}</td>
                                        <td>{{ $tax->value ?? '' }}</td>
                                        <td>
                                            <a href="{{ route('vendor.edit.tax', $tax->id) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            
                                            <span class="btn btn-sm btn-danger cursor-pointer delete-record"
                                                data-id="{{ $tax->id }}">
                                                <i class="bx bx-trash"></i>
                                            </span>
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
            $('.delete-record').on('click', function(e) {
                e.preventDefault();

                let taxId = $(this).data('id');
                let row = $(this).closest('tr');

                // Show confirmation dialog
                if (confirm("Are you sure you want to delete this tax?")) {
                   
                    $.ajax({
                        url: "{{ route('vendor.tax.destroy') }}",
                        type: 'POST',
                        data: {
                            id:taxId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                row.remove();
                                toastr.success('Record deleted successfully.');
                            } else {
                                toastr.error('Failed to delete the record.');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Handle error
                            alert('An error occurred while trying to delete the record.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
