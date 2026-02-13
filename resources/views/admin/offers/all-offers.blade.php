@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Offers)
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Offers List</h5>
                        <a href="{{ route('admin.create.offer') }}" class="btn btn-sm btn-primary">Add New</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Created By</th>
                                    <th>Creator Name</th>
                                    <th>Percent/Fixed</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($offers as $offer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if (Str::startsWith($offer->image, 'http'))
                                                <div style="height: 3rem; width:3rem;">
                                                    <img src="{{ $offer->image }}" class="h-100 w-100" alt="">
                                                </div>
                                            @else
                                                <div style="height: 3rem; width:3rem;">
                                                    <img src="{{ asset('uploads/offer/' . $offer->image) }}"
                                                        class="h-100 w-100" alt="">
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $offer->title }}</td>
                                        <td>{{ $offer->description }}</td>
                                        <td>{{ $offer->creator_role }}</td>
                                        <td>{{ $offer->createdby->name }}</td>
                                        <td>{{ $offer->offer_type == 'percentage' ? $offer->discount_value . ' %' : $offer->discount_value . ' €' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.edit.offer', $offer->id) }}"
                                                class="text-success">
                                                <i class="bx bx-edit"></i> 
                                            </a>
                                            <a id="delete" href="{{ route('admin.delete.offer', $offer->id) }}"
                                                class="text-danger">
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
