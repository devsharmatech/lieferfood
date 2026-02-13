@extends('admin.main-frame')

@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">New Slide</span> </h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                   

                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.update.slide') }}">
                            @csrf

                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <label for="url" class="form-label">Url</label>
                                    <input type="hidden" name="id" value="{{$slide->id}}">
                                    <input class="form-control" value="{{ $slide->url }}" type="url" id="url"
                                        name="url"  />
                                    @error('url')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                               

                                <div class="mb-3 col-md-6">
                                    <label for="image" class="form-label">Image (600X400px)</label>
                                    <input type="file" id="upload" name="image" class="form-control"
                                        accept="image/*" />
                                    @error('image')
                                        <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                    <div class="mt-2">
                                      <img src="{{asset('uploads/slides/'.$slide->image)}}" alt="" style="height: 4rem; width:6rem;">
                                    </div>
                                </div>

                               

                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
