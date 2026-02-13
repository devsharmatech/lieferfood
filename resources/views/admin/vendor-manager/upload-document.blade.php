@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Vendor Document Manager)
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Vendor Document Manager</h5>
                        <small class="text-muted float-end">Upload vendor document</small>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('vendors.upload.document') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name">Vendor</label>
                                <select class="form-select" name="vendor">
                                    <option value="">Select a vendor</option>
                                    @foreach($users as $user)
                                      <option @selected(isset($vendorDocument->vendor_id) && $user->id==$vendorDocument->vendor_id) value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                                @error('vendor')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                <label class="form-label" for="document1">Document 1</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-image"></i></span>
                                    <input type="file" id="document1" class="form-control phone-mask" name="document1"
                                        accept="image/*" />
                                </div>
                                @error('document1')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                @if(isset($vendorDocument->document1))
                                   <img src="{{asset('uploads/documents/'.$vendorDocument->document1)}}" style="height:5rem;" class="mt-2 rounded-2">
                                @endif
                            </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                <label class="form-label" for="document2">Document 2</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-image"></i></span>
                                    <input type="file" id="document2" class="form-control phone-mask" name="document2"
                                        accept="image/*" />
                                </div>
                                @error('document2')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                @if(isset($vendorDocument->document2))
                                   <img src="{{asset('uploads/documents/'.$vendorDocument->document2)}}" style="height:5rem;" class="mt-2 rounded-2">
                                @endif
                            </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                <label class="form-label" for="document3">Document 3</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-image"></i></span>
                                    <input type="file" id="document3" class="form-control phone-mask" name="document3"
                                        accept="image/*" />
                                </div>
                                @error('document3')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                @if(isset($vendorDocument->document3))
                                   <img src="{{asset('uploads/documents/'.$vendorDocument->document3)}}" style="height:5rem;" class="mt-2 rounded-2">
                                @endif
                            </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                <label class="form-label" for="document4">Document 4</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-image"></i></span>
                                    <input type="file" id="document4" class="form-control phone-mask" name="document4"
                                        accept="image/*" />
                                </div>
                                @error('document4')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                @if(isset($vendorDocument->document4))
                                   <img src="{{asset('uploads/documents/'.$vendorDocument->document4)}}" style="height:5rem;" class="mt-2 rounded-2">
                                @endif
                            </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
