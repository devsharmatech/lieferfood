@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Table Slot Offers</h5>
                        <a href="{{ route('vendor.create.slot.offer') }}" class="btn btn-sm btn-primary">Add New</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Slot Day</th>
                                    <th>Title</th>
                                    <th>Discount Type</th>
                                    <th>Discount</th>
                                    <th>Upto Price</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (isset($offers))
                                    @foreach ($offers as $offer)
                                        <tr>
                                            <td> {{ $loop->iteration }} </td>
                                            <td> {{ isset($offer->slot->day) ? $offer->slot->day : '' }}
                                            </td>
                                            <td>{{ $offer->title }}</td>
                                            <td>
                                                <span class="text-uppercase">{{ $offer->discount_type }}</span>
                                            </td>
                                            <td>{{ $offer->discount }} {{ $offer->discount_type == 'fixed' ? '' : '%' }}
                                            </td>
                                            <td>{{ $offer->upto_price }}</td>
                                             <td>
                                            <div>

                                                <div class="form-check form-switch mb-2" style="cursor: pointer;">
                                                    <input class="form-check-input update-offer" type="checkbox"
                                                        data-id="{{ $offer->id }}" data-field="status"
                                                        @checked($offer->status == 1) id="status-{{ $offer->id }}" />
                                                    <label class="form-check-label"
                                                        for="status-{{ $offer->id }}"></label>
                                                </div>

                                            </div>
                                        </td>
                                            <td>{{ date('d F Y', strtotime($offer->created_at)) }}</td>
                                            <td>
                                                 <a href="{{route('vendor.edit.slot.offer',$offer->id)}}" class="btn btn-sm btn-success">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                            </td>
                                            <td>
                                                <div class="d-flex ">
                                                   
                                                   
                                                    <a href="{{route('vendor.delete.slot.offer',$offer->id)}}" id="delete" class="btn btn-sm btn-danger">
                                                        <i class="bx bx-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
        $(document).on('change', '.update-offer', function() {
            let id = $(this).data('id');
            let col = $(this).data('field');
            let value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route('vendor.change.slot.offer.status') }}',
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
