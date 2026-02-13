@extends('vendor.vendor-frame')

@section('vendor_body')
@php
function formatId($id) {
    $length = strlen((string) $id);
    $totalLength = $length + 1;
    return 'L' . str_pad($id, $totalLength - 1, '0', STR_PAD_LEFT);
}
@endphp

<style>
    /* Mobile Optimization */
    @media (max-width: 768px) {
        .card-header h5 {
            font-size: 1rem !important;
        }
        
        .order-card {
            font-size: 0.75rem !important;
        }
        
        .order-card .card-header {
            padding: 0.4rem 0.5rem !important;
        }
        
        .order-card .card-body {
            padding: 0.5rem !important;
        }
        
        .accordion-button {
            font-size: 0.75rem !important;
            padding: 0.35rem 0.5rem !important;
        }
        
        .accordion-body {
            font-size: 0.7rem !important;
            padding: 0.4rem !important;
        }
        
        .badge {
            font-size: 0.65rem !important;
            padding: 0.2rem 0.4rem !important;
        }
        
        .btn-sm {
            padding: 0.2rem 0.5rem !important;
            font-size: 0.75rem !important;
        }
        
        .form-control-sm, .form-select-sm {
            font-size: 0.8rem !important;
            padding: 0.25rem 0.5rem !important;
        }
        
        .table-sm th,
        .table-sm td {
            padding: 0.15rem 0.3rem !important;
            font-size: 0.7rem !important;
        }
        
        .pagination-sm .page-link {
            padding: 0.2rem 0.4rem !important;
            font-size: 0.7rem !important;
        }
        
        .text-muted {
            font-size: 0.7rem !important;
        }
    }
    
    @media (max-width: 576px) {
        .order-card {
            font-size: 0.7rem !important;
        }
        
        .row-cols-sm-1 > * {
            flex: 0 0 auto;
            width: 100%;
        }
        
        .d-flex.gap-2 {
            gap: 0.25rem !important;
        }
        
        .order-card .card-footer {
            padding: 0.3rem 0.4rem !important;
        }
    }
    
    @media (max-width: 400px) {
        .order-card {
            font-size: 0.65rem !important;
        }
        
        .accordion-button {
            font-size: 0.7rem !important;
        }
        
        .btn-sm {
            padding: 0.15rem 0.4rem !important;
            font-size: 0.7rem !important;
        }
        
        .form-label {
            font-size: 0.75rem !important;
            margin-bottom: 0.1rem !important;
        }
    }
    
    /* Base Styles */
    .order-card {
        border-radius: 8px;
        transition: all 0.2s ease;
        border: 1px solid #e0e0e0;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }
    
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border-color: #0d6efd;
    }
    
    .order-card .card-header {
        border-top-left-radius: 7px;
        border-top-right-radius: 7px;
        padding: 0.5rem 0.75rem;
    }
    
    .accordion-flush .accordion-item {
        border: 1px solid #f0f0f0;
        border-radius: 5px;
        margin-bottom: 0.4rem;
    }
    
    .x-small {
        font-size: 0.75rem;
    }
    
    /* Compact layout for mobile */
    .compact-view .d-flex {
        flex-wrap: wrap;
    }
    
    .compact-view .col-6 {
        margin-bottom: 0.25rem;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Filter Section -->
                <div class="card-header py-2 px-3">
                    <!-- Header Row -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                        <h5 class="mb-0">
                            <i class="fas fa-clipboard-list me-2 fs-6"></i>Total Orders
                            <span class="badge bg-primary text-white ms-2">{{ $orders->total() }}</span>
                        </h5>

                        <div class="d-flex gap-2">
                            <!-- Toggle Button (Mobile Only) -->
                            <button class="btn btn-sm btn-outline-primary d-lg-none"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#orderFilter">
                                <i class="fas fa-filter"></i>
                            </button>

                            <a href="{{ route('vendor.all.orders') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-redo-alt"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="collapse d-lg-block" id="orderFilter">
                        <form method="GET" action="{{ route('vendor.all.orders') }}"
                              class="row g-2 g-sm-3 align-items-end mt-2">

                            <!-- Start Date -->
                            <div class="col-12 col-sm-6 col-lg-2">
                                <label class="form-label small mb-1">Start Date</label>
                                <input type="date" name="start_date"
                                       value="{{ request('start_date') }}"
                                       class="form-control form-control">
                            </div>

                            <!-- End Date -->
                            <div class="col-12 col-sm-6 col-lg-2">
                                <label class="form-label small mb-1">End Date</label>
                                <input type="date" name="end_date"
                                       value="{{ request('end_date') }}"
                                       class="form-control form-control">
                            </div>

                            <!-- Status -->
                            <div class="col-12 col-sm-6 col-lg-2">
                                <label class="form-label small mb-1">Status</label>
                                <select name="status" class="form-select ">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>New Order</option>
                                    <option value="confirmed" {{ request('status')=='confirmed'?'selected':'' }}>Confirmed</option>
                                    <option value="out_for_delivery" {{ request('status')=='out_for_delivery'?'selected':'' }}>Out for Delivery</option>
                                    <option value="delivered" {{ request('status')=='delivered'?'selected':'' }}>Delivered</option>
                                    <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Cancelled</option>
                                </select>
                            </div>

                            <!-- Type -->
                            <div class="col-12 col-sm-6 col-lg-2">
                                <label class="form-label small mb-1">Type</label>
                                <select name="method_type" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="delivery" {{ request('method_type')=='delivery'?'selected':'' }}>Delivery</option>
                                    <option value="pickup" {{ request('method_type')=='pickup'?'selected':'' }}>Pickup</option>
                                </select>
                            </div>
                            <!-- Type -->
                            <div class="col-12 col-sm-6 col-lg-2">
                                <label class="form-label small mb-1">Payment Type</label>
                                <select name="payment_method" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="cash" {{ request('payment_method')=='cash'?'selected':'' }}>Cash</option>
                                    <option value="paypal" {{ request('payment_method')=='paypal'?'selected':'' }}>PayPal</option>
                                    <option value="card_payment" {{ request('payment_method')=='card_payment'?'selected':'' }}>Card Payment</option>
                                    <option value="stripe" {{ request('payment_method')=='stripe'?'selected':'' }}>Stripe Payment</option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="col-12 col-lg-2">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-fill">
                                        <i class="fas fa-filter me-1"></i> Filter
                                    </button>
                                    <a href="{{ route('vendor.all.orders') }}"
                                       class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                
                <!-- Orders Cards -->
                <div class="card-body p-1 p-sm-2 p-md-3">
                    @if($orders->isEmpty())
                        <div class="text-center py-4 py-sm-5">
                            <i class="fas fa-clipboard-list fa-2x fa-sm-3x text-muted mb-3"></i>
                            <h6 class="text-muted mb-2">No orders found</h6>
                            <p class="text-muted small mb-0">Try adjusting your filters or check back later</p>
                        </div>
                    @else
                        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 g-2 g-sm-3 compact-view">
                            @foreach ($orders as $order)
                                @php
                                    // Define status colors and icons
                                    $statusConfig = [
                                        'pending' => [
                                            'color' => 'warning',
                                            'icon'  => 'clock',
                                            'bg'    => '#fd7e14'
                                        ],
                                        'confirmed' => [
                                            'color' => 'primary',
                                            'icon'  => 'check-circle',
                                            'bg'    => '#0d6efd'
                                        ],
                                        'preparing' => [
                                            'color' => 'info',
                                            'icon'  => 'utensils',
                                            'bg'    => '#0dcaf0'
                                        ],
                                        'out_for_delivery' => [
                                            'color' => 'info',
                                            'icon'  => 'truck',
                                            'bg'    => '#0dcaf0'
                                        ],
                                        'delivered' => [
                                            'color' => 'success',
                                            'icon'  => 'check',
                                            'bg'    => '#198754'
                                        ],
                                        'cancelled' => [
                                            'color' => 'danger',
                                            'icon'  => 'times',
                                            'bg'    => '#dc3545'
                                        ]
                                    ];

                                    $status   = $order->order_status;
                                    $config   = $statusConfig[$status] ?? $statusConfig['pending'];
                                    $receiver = isset($order->food_receiver) ? json_decode($order->food_receiver) : null;
                                    $address  = isset($order->address) ? json_decode($order->address) : null;
                                    $paymentStatus = [
                                        '0' => ['label' => 'Unpaid', 'class' => 'danger'],
                                        '1' => ['label' => 'Paid', 'class' => 'success'],
                                        '2' => ['label' => 'Cash Pending', 'class' => 'warning'],
                                        '3' => ['label' => 'Cash Received', 'class' => 'info']
                                    ];
                                @endphp
                                
                                <div class="col">
                                    <div class="card order-card h-100 shadow-sm border-hover">
                                        <!-- Card Header -->
                                        <div class="card-header py-1 px-2" style="background: {{ $config['bg'] }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex flex-column">
                                                    <span class="badge bg-white text-dark px-1 py-2 me-1 small" style="width:fit-content">
                                                        #{{ formatId($order->id) }}
                                                    </span>
                                                    <span class="text-white x-small fw-semibold">{{ ucfirst($status == "pending" ? "new order" : $status) }}</span>
                                                </div>
                                                <div class="text-white x-small">
                                                    {{ number_format($order->total_amount, 2) }}€
                                                </div>    
                                                <div class="text-end">
                                                    <span class="text-white d-block x-small">{{ $order->created_at->format('d M') }}</span>
                                                    <span class="text-white d-block x-small">{{ $order->created_at->format('h:i A') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Card Body -->
                                        <div class="card-body p-2">
                                            <!-- Quick Info Row -->
                                            <div class="row g-1 mb-2">
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-user text-muted me-1 x-small"></i>
                                                        <div>
                                                            <div class="fw-medium text-dark x-small">{{ $receiver->name ?? 'Customer' }}</div>
                                                            @if($receiver && $receiver->phone)
                                                                <div class="text-dark x-small">{{ $receiver->phone }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-end">
                                                        <span class="badge bg-light text-dark x-small">
                                                            {{ $order->payment_method == 'cash' ? 'Cash' : ($order->payment_method == 'paypal' ? 'PayPal' : 'Card') }}
                                                        </span>
                                                        @if(isset($order->payment_status))
                                                            <span class="badge bg-{{ $paymentStatus[$order->payment_status]['class'] ?? 'secondary' }} x-small ms-1">
                                                                {{ $paymentStatus[$order->payment_status]['label'] ?? 'Unknown' }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Collapsible Sections -->
                                            <div class="accordion accordion-flush x-small" id="accordion-{{ $order->id }}">
                                                <!-- Address Section -->
                                                @if($address)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed py-1 px-2" type="button" 
                                                                data-bs-toggle="collapse" 
                                                                data-bs-target="#address-{{ $order->id }}">
                                                            <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                                            <span>Address</span>
                                                        </button>
                                                    </h2>
                                                    <div id="address-{{ $order->id }}" class="accordion-collapse collapse" 
                                                         data-bs-parent="#accordion-{{ $order->id }}">
                                                        <div class="accordion-body p-1">
                                                            <ul class="list-unstyled mb-0">
                                                                @if(isset($address->street) && $address->street)
                                                                    <li class="mb-1"><strong>Street:</strong> {{ $address->street }}</li>
                                                                @endif
                                                                @if(isset($address->house_number) && $address->house_number)
                                                                    <li class="mb-1"><strong>House No:</strong> {{ $address->house_number }}</li>
                                                                @endif
                                                                <li class="mb-1">
                                                                    <strong>Address:</strong> 
                                                                    {{ isset($address->city) ? $address->city . ', ' : '' }}
                                                                    {{ isset($address->state) ? $address->state . ' ' : '' }}
                                                                    {{ isset($address->postal_code) ? $address->postal_code : '' }}
                                                                    {{ isset($address->neighborhood) ? '(' . $address->neighborhood . ')' : '' }}
                                                                </li>
                                                                @if(isset($address->delivery_notes) && $address->delivery_notes)
                                                                    <li class="mb-1"><strong>Notes:</strong> {{ $address->delivery_notes }}</li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                <!-- Order Items Section -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed py-1 px-2" type="button" 
                                                                data-bs-toggle="collapse" 
                                                                data-bs-target="#items-{{ $order->id }}">
                                                            <i class="fas fa-utensils me-1 text-danger"></i>
                                                            <span>Items ({{ $order->order_items->count() }})</span>
                                                        </button>
                                                    </h2>
                                                    <div id="items-{{ $order->id }}" class="accordion-collapse collapse" 
                                                         data-bs-parent="#accordion-{{ $order->id }}">
                                                        <div class="accordion-body p-0">
                                                            <div class="table-responsive">
                                                                <table class="table table-sm table-borderless mb-0">
                                                                    <tbody>
                                                                        @foreach($order->order_items as $item)
                                                                            @php
                                                                                $extra_toppings = json_decode(isset($item->extras) && $item->extras != null && $item->extras != '' ? $item->extras : json_encode([]));
                                                                                $extrapric = 0;
                                                                            @endphp
                                                                            <tr class="border-bottom">
                                                                                <td width="15%" class="ps-1">
                                                                                    <strong>{{ $item->quantity }}x</strong>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="fw-medium">{{ $item->food_item_name }}</div>
                                                                                    @if($item->variant)
                                                                                        <small class="text-dark">({{ $item->variant }})</small>
                                                                                    @endif
                                                                                    @if(count($extra_toppings) > 0)
                                                                                        <ul class="list-unstyled mb-0 mt-1">
                                                                                            @foreach($extra_toppings as $extra_topping)
                                                                                                @php $extrapric += $extra_topping->price; @endphp
                                                                                                <li class="text-capitalize x-small text-dark">
                                                                                                    <i class="fas fa-plus me-1"></i>
                                                                                                    {{ $extra_topping->name }} ({{ number_format($extra_topping->price, 2) }}€)
                                                                                                </li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    @endif
                                                                                </td>
                                                                                <td width="30%" class="text-end pe-1">
                                                                                    <div class="fw-bold">
                                                                                        {{ number_format(($item->price > 0 ? $item->price : ($item->food->delivery_price ?? 0)) * $item->quantity, 2) }}€
                                                                                    </div>
                                                                                    @if($extrapric > 0)
                                                                                        <div class="x-small text-dark">
                                                                                            +{{ number_format($extrapric, 2) }}€ 
                                                                                        </div>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <ul class="list-unstyled mb-0 p-1">
                                                                <li class="d-flex justify-content-between mb-1">
                                                                    <span>Subtotal:</span>
                                                                    <span class="fw-medium">{{ number_format($order->total_amount + $order->discount, 2) }}€</span>
                                                                </li>
                                                                @if($order->discount > 0)
                                                                    <li class="d-flex justify-content-between mb-1">
                                                                        <span class="text-success">Discount:</span>
                                                                        <span class="text-success">-{{ number_format($order->discount, 2) }}€</span>
                                                                    </li>
                                                                @endif
                                                                <li class="d-flex justify-content-between  mb-1">
                                                                    <span>Delivery:</span>
                                                                    <span>+{{ number_format($order->delivery_price, 2) }}€</span>
                                                                </li>
                                                                <li class="d-flex justify-content-between mb-1 pt-2 border-top">
                                                                    <span class="fw-bold">Payable Amount:</span>
                                                                    <span class="fw-bold">{{ number_format($order->total_amount, 2) }}€</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Status Update -->
                                            <div class="mt-2">
                                                <label class="form-label x-small mb-1 text-dark">Update Status:</label>
                                                <select data-id="{{ $order->id }}" onchange="orderStatus(this)"
                                                        class="form-select form-select-sm">
                                                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>New Order</option>
                                                    <option value="confirmed" {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                    <option value="out_for_delivery" {{ $order->order_status == 'out_for_delivery' ? 'selected' : '' }}>Out for delivery</option>
                                                    <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Action Buttons -->
                                            <div class="d-flex gap-1 mt-2">
                                                <a href="{{ route('vendor.order.view', $order->id) }}"
                                                   class="btn btn-sm btn-outline-primary flex-fill py-1"
                                                   title="View Full Details">
                                                    <i class="fas fa-eye me-1"></i> View
                                                </a>
                                                <a href="{{ route('vendor.generate.order.pdf', $order->id) }}"
                                                   class="btn btn-sm btn-outline-dark py-1 px-2"
                                                   title="Print Order">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                                @if($order->order_status !== 'delivered' && $order->order_status !== 'cancelled')
                                                    <button class="btn btn-sm btn-outline-success py-1 px-2"
                                                            onclick="markAsDelivered({{ $order->id }})"
                                                            title="Mark as Delivered">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Card Footer -->
                                        <div class="card-footer py-1 px-2 bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted x-small">
                                                    {{ $order->method_type == 'pickup' ? 'Pickup' : 'Delivery' }}
                                                </small>
                                                <small class="text-muted x-small">
                                                    {{ $order->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Bootstrap 5 Pagination -->
                        @if($orders->hasPages())
                            <div class="mt-3">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm justify-content-center mb-1">
                                        {{-- Previous Page Link --}}
                                        @if ($orders->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">
                                                    <i class="fas fa-chevron-left"></i>
                                                </span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $orders->previousPageUrl() }}" aria-label="Previous">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @php
                                            $current = $orders->currentPage();
                                            $last = $orders->lastPage();
                                            $start = max(1, $current - 1);
                                            $end = min($last, $current + 1);
                                        @endphp
                                        
                                        @if($start > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $orders->url(1) }}">1</a>
                                            </li>
                                            @if($start > 2)
                                                <li class="page-item disabled">
                                                    <span class="page-link">...</span>
                                                </li>
                                            @endif
                                        @endif
                                        
                                        @for($page = $start; $page <= $end; $page++)
                                            @if($page == $orders->currentPage())
                                                <li class="page-item active" aria-current="page">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $orders->url($page) }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endfor
                                        
                                        @if($end < $last)
                                            @if($end < $last - 1)
                                                <li class="page-item disabled">
                                                    <span class="page-link">...</span>
                                                </li>
                                            @endif
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $orders->url($last) }}">{{ $last }}</a>
                                            </li>
                                        @endif

                                        {{-- Next Page Link --}}
                                        @if ($orders->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $orders->nextPageUrl() }}" aria-label="Next">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">
                                                    <i class="fas fa-chevron-right"></i>
                                                </span>
                                            </li>
                                        @endif
                                    </ul>
                                    
                                    <div class="text-center">
                                        <small class="text-muted x-small">
                                            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} 
                                            of {{ $orders->total() }} orders
                                        </small>
                                    </div>
                                </nav>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function orderStatus(e) {
        const status = e.value;
        const entryId = e.getAttribute('data-id');
        const csrfToken = "{{ csrf_token() }}";
        const card = e.closest('.order-card');
        
        // Show loading state
        const originalValue = e.value;
        e.disabled = true;
        card.classList.add('card-loading');
        const originalHTML = e.innerHTML;
        e.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>';

        fetch('{{ route('vendor.order.status') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id: entryId,
                status: status
            })
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.status) {
                toastr.success(data.message);
                
                // Update card header color based on new status
                const cardHeader = card.querySelector('.card-header');
                const statusBadge = card.querySelector('.fw-semibold');
                
                // Define status colors
                const statusColors = {
                    'pending': '#fd7e14',
                    'confirmed': '#0d6efd',
                    'preparing': '#0dcaf0',
                    'out_for_delivery': '#0dcaf0',
                    'delivered': '#198754',
                    'cancelled': '#dc3545'
                };
                
                // Update colors
                if (cardHeader) {
                    cardHeader.style.background = statusColors[status] || '#fd7e14';
                }
                
                // Update status text
                if (statusBadge) {
                    statusBadge.textContent = status === 'pending' ? 'New Order' : status.charAt(0).toUpperCase() + status.slice(1);
                }
                
            } else {
                toastr.error(data.message || 'Failed to update status');
                e.value = originalValue;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('An error occurred. Please try again.');
            e.value = originalValue;
        })
        .finally(() => {
            e.disabled = false;
            card.classList.remove('card-loading');
            e.innerHTML = originalHTML;
        });
    }
    
    function markAsDelivered(orderId) {
        if (confirm('Mark this order as delivered?')) {
            const selectElement = document.querySelector(`[data-id="${orderId}"]`);
            selectElement.value = 'delivered';
            orderStatus(selectElement);
        }
    }
    
    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Collapse all accordions by default on mobile
        if (window.innerWidth < 768) {
            document.querySelectorAll('.accordion-collapse').forEach(collapse => {
                collapse.classList.remove('show');
            });
        }
        
        // Auto-refresh for new orders (every 2 minutes)
        let autoRefreshInterval;
        
        function startAutoRefresh() {
            autoRefreshInterval = setInterval(() => {
                if (document.visibilityState === 'visible') {
                    window.location.reload();
                }
            }, 120000);
        }
        
        // Start auto-refresh
        if (window.location.pathname.includes('vendor.all.orders')) {
            startAutoRefresh();
        }
    });
</script>
@endsection

@section('vendor_custome_script')
<script>
    $(document).ready(function () {
        // Initialize Bootstrap tooltips
        $('[title]').tooltip({
            trigger: 'hover',
            placement: 'top'
        });
        
        // Mobile menu toggle for filters
        $('[data-bs-toggle="collapse"]').click(function() {
            $(this).toggleClass('active');
        });
        
        // Smooth scroll to top on page change
        $('.page-link').on('click', function(e) {
            if (!$(this).parent().hasClass('disabled')) {
                $('html, body').animate({
                    scrollTop: 0
                }, 200);
            }
        });
    });
</script>
@endsection