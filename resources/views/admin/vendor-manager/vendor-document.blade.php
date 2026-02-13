@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Vendor Documents)
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Vendor Documents</h5>
                        <a class="btn btn-sm btn-primary" href="{{route('vendors.add.document')}}">Add</a>
                    </div>
                    <div class="card-body">
                       
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Vendor</th>
                                    <th>View Document</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($documents as $key => $document)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="" class="w-100 text-center">
                                                <div class="w-100 d-flex justify-content-center">
                                                    <div
                                                        style="height: 3rem;width:3rem; border-radius:50%; border:2px solid #ddd;">
                                                        <img src="@if ($document->vendor->profile) {{ asset('uploads/users/' . $document->vendor->profile) }}
                                                @else
                                                    {{ asset('uploads/avtarlg.jpg') }} @endif"
                                                            class="h-100 w-100 rounded-circle" alt="">
                                                    </div>
                                                </div>
                                                <p>{{ $document->vendor->name }}</p>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn-link" href="{{route('vendors.edit.document',$document->vendor_id)}}">Show Documents</a>
                                        </td>
                                       
                                        <td>
                                            {{ date('d/M/Y h:i A',strtotime($document->created_at)) }}
                                        </td>
                                        
                                        <td>
                                            <a href="{{route('vendors.delete.document',$document->id)}}"
                                                id="delete" class="text-danger">
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

@section('custome_script')
    <script>
        new DataTable('#datatable', {
            responsive: true
        });
    </script>
@endsection
