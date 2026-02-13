@extends('admin.main-frame')
@section('title')
    Admin Dashboard
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 ">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Congratulations {{ auth()->user()->name }}! 🎉</h5>
                                <div>
                                    <p class="mb-2">
                                        {{ $quote }}
                                    </p>
                                    <small class="text-muted mb-2 d-block">- {{ $author }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('uploads/restu.svg') }}" height="140" alt="Restaurant" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="col-12">
                <div class="row">
                    <div class="col-sm-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('uploads/icon-free/calendar.png') }}" alt="Order Today"
                                            class="rounded" />
                                    </div>

                                </div>
                                <span class="d-block mb-1">Orders Today</span>
                                <h3 class="card-title text-nowrap mb-2">{{ number_format($todayOrders) }}</h3>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('uploads/icon-free/schedule.png') }}" alt="Pending Orders"
                                            class="rounded" />
                                    </div>

                                </div>
                                <span class="fw-medium d-block mb-1">Pending Orders</span>
                                <h3 class="card-title mb-2">{{ number_format($todayPendingOrders) }}</h3>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('uploads/icon-free/price.png') }}" alt="Today’s Revenue"
                                            class="rounded" />
                                    </div>

                                </div>
                                <span class="fw-medium d-block mb-1">Today’s Revenue</span>
                                <h3 class="card-title mb-2">&euro;{{ number_format($todayRevenue, 2) }}</h3>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('uploads/icon-free/cancel-order.png') }}"
                                            alt="Today's cancel Order" class="rounded" />
                                    </div>

                                </div>
                                <span>Today's cancel Order</span>
                                <h3 class="card-title text-nowrap mb-2">{{ number_format($todayCancelledOrders) }}</h3>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
