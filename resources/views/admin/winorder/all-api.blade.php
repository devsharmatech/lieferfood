@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Vendor Apis)
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Vendor Winorder APIs</h5>
                        
                    </div>
                    <div class="card-body">
                        <form class="row mb-4" action="{{route('admin.store.winorder')}}" method="post">
                        @csrf
                        <div class="col-md-4 mt-2">
                            <div class="form-group">
                                <select class="form-select" name="vendor">
                                    <option value="">Select a vendor</option>
                                    @foreach($users as $user)
                                      <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                                @error('vendor')
                                  <small class="text-danger"> {{$message}} </small>
                                @enderror
                        </div>
                        <div class="col-md-4 mt-2">
                            <button class="btn btn-primary" type="submit">Generate Now</button>
                        </div>
                    </form>
                        <p class="fw-bold">WinOrderApi:- https://lieferfood.de/winorder/getNewOrder.php</p>
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Vendor</th>
                                    <th>App-Key</th>
                                    <th>Key-Secret</th>
                                    <th>Generated On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($apis as $key => $api)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="" class="w-100 text-center">
                                                <div class="w-100 d-flex justify-content-center">
                                                    <div
                                                        style="height: 3rem;width:3rem; border-radius:50%; border:2px solid #ddd;">
                                                        <img src="@if ($api->vendor->profile) {{ asset('uploads/users/' . $api->vendor->profile) }}
                                                @else
                                                    {{ asset('uploads/avtarlg.jpg') }} @endif"
                                                            class="h-100 w-100 rounded-circle" alt="">
                                                    </div>
                                                </div>
                                                <p>{{ $api->vendor->name }}</p>
                                            </a>
                                        </td>
                                        <td>
                                            {{ $api->code }}
                                        </td>
                                        <td>
                                            {{ $api->secret_key }}
                                        </td>
                                        <td>
                                            {{ date('d/M/Y h:i A',strtotime($api->created_at)) }}
                                        </td>
                                        
                                        <td>
                                            <a href="{{route('admin.delete.winorder',$api->id)}}"
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
