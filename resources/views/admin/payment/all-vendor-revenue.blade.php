@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Vendor)
@endsection

@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Vendor List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Vendor</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Revenue</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $key => $vendor)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="" class="w-100 text-center">
                                                <div class="w-100 d-flex justify-content-center">
                                                    <div
                                                        style="height: 3rem;width:3rem; border-radius:50%; border:2px solid #ddd;">
                                                        <img src="@if ($vendor->profile) {{ asset('uploads/users/' . $vendor->profile) }}
                                                @else
                                                    {{ asset('uploads/avtarlg.jpg') }} @endif"
                                                            class="h-100 w-100 rounded-circle" alt="">
                                                    </div>
                                                </div>
                                                <p>{{ $vendor->name }}</p>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $vendor->email }}">{{ $vendor->email }}</a>
                                        </td>
                                        <td>
                                            <a href="tel:{{ $vendor->phone }}">{{ $vendor->phone }}</a>
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.all.revenues', $vendor->id) }}"
                                                class="btn btn-sm btn-primary">Revenue</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.show.vendor', $vendor->id) }}"
                                                class="btn btn-sm btn-info">Details</a>
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

@section('custome_script')
    <script>
        new DataTable('#datatable', {
            responsive: true
        });
    </script>
@endsection
