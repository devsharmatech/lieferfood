@extends('admin.main-frame')
@section('title')
    Create New Courier Partner
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Review</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.upadate.food.review') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $review->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Rating</label>
                                        <div class="input-group input-group-merge">
                                            <select name="rating" id="rating" class="form-control">
                                                <option value="1" @selected($review->rating == 1)>1</option>
                                                <option value="2" @selected($review->rating == 2)>2</option>
                                                <option value="3" @selected($review->rating == 3)>3</option>
                                                <option value="4" @selected($review->rating == 4)>4</option>
                                                <option value="5" @selected($review->rating == 5)>5</option>
                                            </select>
                                        </div>
                                        @error('rating')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="status">Status</label>
                                        <div class="input-group input-group-merge">
                                            <select name="status" id="status" class="form-control">
                                                <option value="0" @selected($review->status == 0)>Inactive</option>
                                                <option value="1" @selected($review->status == 1)>Active</option>
                                            </select>
                                        </div>
                                        @error('status')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="review">Review</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-message"></i></span>
                                            <textarea class="form-control" name="review" id="review" rows="6">{{ $review->content }}</textarea>
                                        </div>

                                        @error('review')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
