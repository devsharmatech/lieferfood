@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Offers List</h5>
                        <a href="{{route('vendor.create.offer')}}" class="btn btn-sm btn-primary">Add Offer</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Offer On</th>
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th>Upto</th>
                                    <th>Percent/Fixed</th>
                                    <th>Status</th>
                                    <th>Start and End</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($offers as $offer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $offer->whichType }}</td>
                                        <td>
                                            @if(isset($offer->whichType) && $offer->whichType=="category")
                                              {{ isset($offer->category->name)?$offer->category->name:"" }}
                                            @elseif(isset($offer->whichType) && $offer->whichType=="food")
                                              {{ isset($offer->food->food_item_name)?$offer->food->food_item_name:"" }}
                                            @else
                                              Restaurant
                                            @endif
                                        </td>
                                        <td>{{ $offer->title }}</td>
                                        <td>{{ $offer->upto.'€' }}</td>
                                        

                                        <td>{{ $offer->offer_type == 'percentage' ? $offer->discount_value . ' %' : $offer->discount_value . ' €' }}
                                        </td>
                                         <td>
                                            <div>

                                                <div class="form-check form-switch mb-2" style="cursor: pointer;">
                                                    <input class="form-check-input update-offer" type="checkbox"
                                                        data-id="{{ $offer->id }}" data-field="is_active"
                                                        @checked($offer->is_active == 1) id="status-{{ $offer->id }}" />
                                                    <label class="form-check-label"
                                                        for="status-{{ $offer->id }}"></label>
                                                </div>

                                            </div>
                                        </td>
                                        <td>{{ date('d-M-Y',strtotime($offer->start_date)) }} To {{ date('d-M-Y',strtotime($offer->end_date)) }}</td>
                                        <td>
                                            <a href="{{route('vendor.edit.offer',$offer->id)}}" class=" btn btn-sm btn-success">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                
                                                <a id="delete" href="{{route('vendor.delete.offer',$offer->id)}}" class="btn btn-sm btn-danger">
                                                    <i class="bx bx-trash"></i>
                                                </a>
                                            </div>
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
            "order": false,
            lengthMenu: [[-1, 10, 20, 50, 100, 200], ['All', 10, 20, 50, 100, 200]]
        });
    });
</script>
     <script>
        $(document).on('change', '.update-offer', function() {
            let id = $(this).data('id');
            let col = $(this).data('field');
            let value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route('vendor.change.status.offer') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    value: value,
                    col: col
                },
                success: function(response) {
                    if (response.status) {
                        toastr.success('Offer status updated successfully')
                    } else {
                        toastr.error('Failed to update offer status')
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
