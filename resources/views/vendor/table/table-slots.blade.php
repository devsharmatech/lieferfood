@extends('vendor.vendor-frame')

@section('vendor_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Table Slots</h5>
                        <a href="{{ route('vendor.create.slot') }}" class="btn btn-sm btn-primary">Add New</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Slot Time</th>
                                    <th>Price</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($slots as $slot)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('h:i A', strtotime($slot->time)) }}</td>
                                        <td></td>
                                        <td>{{ date('d F Y ', strtotime($slot->created_at)) }}</td>

                                        <td>
                                            @if ($slot->status == 1)
                                                <a href="{{route('vendor.change.status.slot',$slot->id)}}" class="btn btn-sm btn-success">Active</a>
                                            @else
                                                <a href="{{route('vendor.change.status.slot',$slot->id)}}" class="btn btn-sm btn-danger">Inctive</a>
                                            @endif
                                            <a href="{{ route('vendor.delete.slot', $slot->id) }}" id="delete"
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
            "order": false,
            lengthMenu: [[-1, 10, 20, 50, 100, 200], ['All', 10, 20, 50, 100, 200]]
        });
    });
</script>
@endsection
