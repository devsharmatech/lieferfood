@extends('vendor.vendor-frame')

@section('vendor_body')
@php
function formatId($id) {
    $length = strlen((string) $id);
    $totalLength = $length + 1;
    return 'L' . str_pad($id, $totalLength - 1, '0', STR_PAD_LEFT);
}
@endphp
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
                                    <th>Order No.</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Report</th>
                                    <th>Date</th>
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
                                            <a href="{{ route('vendor.order.view', $review->order_id) }}" class="text-primary fw-bolder">
                                                {{formatId($review->order_id ?? 0)}}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge bg-success fs-6">
                                                {{$review->rating}} 
                                                <i class="fa fa-star"></i>
                                            </span>
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
        new DataTable('#datatable', {
            responsive: true
        });
    </script>
@endsection
