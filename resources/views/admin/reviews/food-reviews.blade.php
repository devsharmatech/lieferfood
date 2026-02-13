@extends('admin.main-frame')
@section('title')
    Admin Dashboard (Food Reviews)
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-header py-0">Review List</h5>

                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Customer</th>
                                    <th>Food</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Report</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($reviews as $review)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <a>
                                                <div
                                                    style="height: 3rem;width:3rem; border-radius:50%; border:2px solid #ddd;">
                                                    <img src="
                                                @if (isset($review->user->profile) && $review->user->profile != null && $review->user->profile != '') {{ asset('uploads/users/' . $review->user->profile) }}
                                                  @else
                                                  {{ asset('uploads/users/default.jpg') }} @endif
                                                "class="h-100 w-100 rounded-circle"
                                                        alt="">
                                                </div>
                                                <p>{{ isset($review->user->name) ? $review->user->name . ' ' . $review->user->surname : '' }}
                                                </p>
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                href="{{route('admin.show.vendor',$review->vendor_id)}}">{{ isset($review->vendor->name) ? $review->vendor->name . ' ' . $review->vendor->surname : '' }}</a>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{$review->rating}}</span>
                                        </td>

                                        <td>
                                            <p>
                                                {{$review->content}}
                                            </p>
                                        </td>
                                        <td>
                                            @if(isset($review->isReport) && $review->isReport==1)
                                               <span class="badge bg-danger text-white rounded-0">
                                                   Reported
                                               </span>
                                               <p> {{$review->report_msg}} </p>
                                            @endif
                                        </td>

                                        <td>
                                            <p> {{date('d/m/Y h:i A', strtotime($review->created_at))}} </p>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{route('admin.edit.food.review',$review->id)}}" class="text-success me-2">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <a href="{{route('admin.delete.food.review',$review->id)}}" id="delete" class="text-danger">
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

@section('custome_script')
    <script>
        new DataTable('#datatable', {
            responsive: true
        });
    </script>
@endsection
