@extends('admin.main-frame')
@section('title')
    Admin Dashboard
@endsection
@section('admin_body')
    <style>
   .state .icon-box {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 18px;
}

.state .card-hover {
    transition: all 0.3s ease;
}

.state .card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.state .card-link {
    text-decoration: none;
    color: inherit;
}

</style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Welcome Card -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="d-flex flex-column flex-md-row align-items-end">
                        <div class="col-md-7 col-12 order-2 order-md-1">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Congratulations {{auth()->user()->name}}! 🎉</h5>
                                <div>
                                    <p class="mb-2">
                                        {{$quote}}
                                    </p>
                                    <small class="text-dark mb-2 d-block">- {{$author}}</small>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-5 col-12 order-1 order-md-2">
                            <div class="card-body text-md-left text-center pb-0 px-0 px-md-4 ">
                                <img src="{{ asset('uploads/restu.svg') }}"
                                    height="140" alt="Restaurant" style="height:8rem;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
<div class="col-12">
    <div class="row state">

        {{-- Orders Today --}}
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('admin.all.orders') }}" class="card-link">
                <div class="card h-100 card-hover">
                    <div class="card-body text-center">
                        <div class="icon-box bg-primary mx-auto">
                            <i class="fa-solid fa-calendar-day"></i>
                        </div>
                        <span class="text-dark d-block mt-2">Orders Today</span>
                        <h4 class="mb-0">{{ $todayOrders ?? 0 }}</h4>
                    </div>
                </div>
            </a>
        </div>

        {{-- Pending Orders --}}
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('admin.all.orders',['status'=>'pending']) }}" class="card-link">
                <div class="card h-100 card-hover">
                    <div class="card-body text-center">
                        <div class="icon-box bg-warning mx-auto">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <span class="text-dark d-block mt-2">Pending Orders</span>
                        <h4 class="mb-0">{{ $todayPendingOrders ?? 0 }}</h4>
                    </div>
                </div>
            </a>
        </div>

        {{-- Cancelled Orders --}}
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('admin.all.orders',['status'=>'cancelled']) }}" class="card-link">
                <div class="card h-100 card-hover ">
                    <div class="card-body text-center">
                        <div class="icon-box bg-danger mx-auto">
                            <i class="fa-solid fa-xmark-circle"></i>
                        </div>
                        <span class="text-dark d-block mt-2">Cancelled Today</span>
                        <h4 class="mb-0">{{ $todayCancelledOrders ?? 0 }}</h4>
                    </div>
                </div>
            </a>
        </div>

        {{-- Today Revenue --}}
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('admin.all.orders') }}" class="card-link">
                <div class="card h-100 card-hover">
                    <div class="card-body text-center">
                        <div class="icon-box mx-auto bg-success">
                            <i class="fa-solid fa-euro-sign"></i>
                        </div>
                        <span class="text-dark d-block mt-2">Today Revenue</span>
                        <h4 class="mb-0">€{{ number_format($todayRevenue ?? 0, 2) }}</h4>
                    </div>
                </div>
            </a>
        </div>

        {{-- Weekly Orders --}}
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('admin.all.orders') }}" class="card-link">
                <div class="card h-100 card-hover">
                    <div class="card-body text-center">
                        <div class="icon-box mx-auto bg-info">
                            <i class="fa-solid fa-calendar-week"></i>
                        </div>
                        <span class="text-dark d-block mt-2">Weekly Orders</span>
                        <h4 class="mb-0">{{ $weeklyOrders ?? 0 }}</h4>
                    </div>
                </div>
            </a>
        </div>

        {{-- Monthly Orders --}}
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('admin.all.orders') }}" class="card-link">
                <div class="card h-100 card-hover">
                    <div class="card-body text-center">
                        <div class="icon-box mx-auto bg-secondary">
                            <i class="fa-solid fa-calendar"></i>
                        </div>
                        <span class="text-dark d-block mt-2">Monthly Orders</span>
                        <h4 class="mb-0">{{ $monthlyOrders ?? 0 }}</h4>
                    </div>
                </div>
            </a>
        </div>

        {{-- Delivered Orders --}}
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('admin.all.orders',['status'=>'delivered']) }}" class="card-link">
                <div class="card h-100 card-hover">
                    <div class="card-body text-center">
                        <div class="icon-box mx-auto bg-success">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <span class="text-dark d-block mt-2">Delivered Orders</span>
                        <h4 class="mb-0">{{ $deliveredOrders ?? 0 }}</h4>
                    </div>
                </div>
            </a>
        </div>
        {{-- Delivery Orders --}}
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('admin.all.orders',['method_type'=>'delivery']) }}" class="card-link">
                <div class="card h-100 card-hover">
                    <div class="card-body text-center">
                        <div class="icon-box mx-auto bg-info">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <span class="text-dark d-block mt-2">Delivery Orders</span>
                        <h4 class="mb-0">{{ $deliveryOrders ?? 0 }}</h4>
                    </div>
                </div>
            </a>
        </div>
        {{-- Pickup Orders --}}
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('admin.all.orders',['method_type'=>'pickup']) }}" class="card-link">
                <div class="card h-100 card-hover">
                    <div class="card-body text-center">
                        <div class="icon-box mx-auto bg-info">
                            <i class="fa-solid fa-store-alt"></i>
                        </div>
                        <span class="text-dark d-block mt-2">Pickup Orders</span>
                        <h4 class="mb-0">{{ $pickupOrders ?? 0 }}</h4>
                    </div>
                </div>
            </a>
        </div>
        {{-- Restaurant Orders --}}
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('admin.table.bookings') }}" class="card-link">
                <div class="card h-100 card-hover">
                    <div class="card-body text-center">
                        <div class="icon-box mx-auto bg-info">
                            <i class="fa-solid fa-chair"></i>
                        </div>
                        <span class="text-dark d-block mt-2">Restaurant Table Bookings</span>
                        <h4 class="mb-0">{{ $pickupOrders ?? 0 }}</h4>
                    </div>
                </div>
            </a>
        </div>
        
        {{-- Total Orders --}}
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('admin.all.orders') }}" class="card-link">
                <div class="card h-100 card-hover">
                    <div class="card-body text-center">
                        <div class="icon-box mx-auto bg-warning">
                            <i class="fa-solid fa-bucket"></i>
                        </div>
                        <span class="text-dark d-block mt-2">Total Orders</span>
                        <h4 class="mb-0">{{ $totalOrders ?? 0 }}</h4>
                    </div>
                </div>
            </a>
        </div>

        {{-- Weekly Revenue --}}
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('admin.all.orders') }}" class="card-link">
                <div class="card h-100 card-hover">
                    <div class="card-body text-center">
                        <div class="icon-box mx-auto bg-info">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <span class="text-dark d-block mt-2">Weekly Revenue</span>
                        <h4 class="mb-0">€{{ number_format($weeklyRevenue ?? 0, 2) }}</h4>
                    </div>
                </div>
            </a>
        </div>

        {{-- Monthly Revenue --}}
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('admin.all.orders') }}" class="card-link">
                <div class="card h-100 card-hover">
                    <div class="card-body text-center">
                        <div class="icon-box mx-auto bg-dark">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <span class="text-dark d-block mt-2">Monthly Revenue</span>
                        <h4 class="mb-0">€{{ number_format($monthlyRevenue ?? 0, 2) }}</h4>
                    </div>
                </div>
            </a>
        </div>

        {{-- Average Order Value --}}
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('admin.all.orders') }}" class="card-link">
                <div class="card h-100 card-hover">
                    <div class="card-body text-center">
                        <div class="icon-box mx-auto bg-warning">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <span class="text-dark d-block mt-2">Avg Order Value</span>
                        <h4 class="mb-0">€{{ number_format($avgOrderValue ?? 0, 2) }}</h4>
                    </div>
                </div>
            </a>
        </div>

        

    </div>
</div>


        </div>
    </div>             
@endsection
