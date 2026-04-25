@extends('external.frame')
@section('external-css')
    <style>
        .bg-1000 {
            display: none !important;
        }
 * {
  -webkit-touch-callout: none; 
  -webkit-user-select: none;
  user-select: none;
}
        .pmt {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            background: rgba(0, 0, 0, 0.8);
            text-align: center;
            border-radius: 0px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .pac-container {
            z-index: 1045 !important;
            border-radius: 10px !important;
            padding: 10px !important;
        }

        .hdpi.pac-logo:after {
            background-image: none !important;
        }

        .pac-logo:after {
            background-image: none !important;
            height: 0px !important;
            padding: 0px !important;
        }

        .pac-item {
            /* margin-top: 10px !important; */
            border: none !important;
            border-bottom: 1px solid #ddd !important;
            line-height: normal !important;
            padding: 8px 4px !important;
        }

        .pac-icon {
            margin-top: 0px !important;
        }

        .custom-select-wrapper {
            position: relative;
            width: 100%;
        }

        .custom-select select {
            width: 100%;
            padding: 9px;
            border-radius: 8px;
            background-color: #fff;
            border: 1px solid #ddd;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .custom-select select:focus {
            outline: none;
            border-color: #ff0400;
        }

        .custom-select select:hover {
            border-color: #ff0400;
        }

        .custom-select::after {
            content: '\25BC';
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            pointer-events: none;
            font-size: 14px;
            color: #999;
        }

        .custom-select select:hover~.custom-select::after {
            color: #ff0400;
        }

        .custom-select select option {
            padding: 10px;
        }

        .location-filter {
            height: 2.8rem !important;
            width: 2.8rem !important;
            background-color: #fff;
            color: #111;
            margin-left: 5px !important;
            outline: none !important;
            border: none !important;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd !important;
        }

        .map-view {
            height: 26rem;
            width: 100% !important;
            background-color: #111 !important;
            position: relative;

        }

        .google-map-area {
            height: 100%;
            width: 100%;
        }

        .google-map {
            height: 100%;
            width: 100%;
        }

        .backtolist {
            position: absolute;
            top: 1rem !important;
            left: 50%;
            transform: translateX(-50%);
            background-color: #111 !important;
            color: #ddd !important;
            outline: none !important;
            border: none !important;
            padding: 8px 12px;
            border-radius: 6px;
        }

        .ft-ic {
            font-size: 14px !important;
            padding: 3px 7px;
            background-color: #111;
            color: #ddd !important;
            position: absolute;
            right: 0%;
            bottom: 5%;
            border-bottom-left-radius: 10px;
            border-top-left-radius: 10px;
        }

        .btn-primary:hover {
            color: #fff !important;

        }

        .rating {
            direction: rtl;
            font-size: 20px;
        }

        .rating input[type="radio"] {
            display: none;
        }

        .rating label {
            cursor: pointer;
            color: #ddd;
            font-size: 20px;
        }

        .rating label:before {
            content: '\f005';
            font-family: "FontAwesome";
            color: #ddd;
        }

        .rating label:hover~label:before,
        .rating label:hover:before,
        .rating input[type="radio"]:checked~label:before {
            color: #ff5100;
        }



        @media (max-width: 575.98px) {

            .switch-button {
                background: rgba(0, 0, 0, 0.10) !important;
                border-radius: 30px !important;
                overflow: hidden !important;
                width: 280px !important;
                height: 45px;
                text-align: center !important;
                font-size: 22px !important;
                letter-spacing: 1px !important;
                color: #155FFF !important;
                border: 1px solid #ddd !important;
                padding-right: 140px !important;
                position: relative !important;
            }

            .switch-button:before {
                content: "🧺 Pickup" !important;
                position: absolute !important;
                top: 0 !important;
                bottom: 0 !important;
                right: 0 !important;
                width: 140px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                z-index: 3 !important;
                color: #000;
                pointer-events: none !important;
                font-size: 22px !important;
            }

            .switch-button:after {
                content: "🚚 Delivery" !important;
                position: absolute !important;
                top: 0 !important;
                bottom: 0 !important;
                left: 0 !important;
                width: 140px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                z-index: 3 !important;
                color: #000;
                pointer-events: none !important;
                font-size: 22px !important;
            }

            .switch-button-checkbox {
                cursor: pointer !important;
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                width: 100% !important;
                height: 100% !important;
                opacity: 0 !important;
                z-index: 2 !important;
            }

            .switch-button-checkbox:checked+.switch-button-label:before {
                transform: translateX(140px) !important;
                transition: transform 300ms linear !important;
            }

            .switch-button-checkbox+.switch-button-label {
                position: relative !important;
                padding: 7px 0 !important;
                height: 100%;
                display: block !important;
                user-select: none !important;
                pointer-events: none !important;
                margin-bottom: 0 !important;
                color: #000;
            }

            .switch-button-checkbox+.switch-button-label:before {
                content: " " !important;
                background: white !important;
                color: #000 !important;
                height: 100% !important;
                width: 100% !important;
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                border-radius: 30px !important;
                transform: translateX(0) !important;
                transition: transform 300ms !important;
            }

            .switch-button-checkbox+.switch-button-label .switch-button-label-span {
                position: relative !important;
                color: #000 !important;
            }



        }

        .discount-strip {
            background: #FFC300;
            color: #000;
            text-align: center;
            padding: 5px 15px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            position: relative;
        }

        .scrolling-text {
            display: flex;
            gap: 50px;
            width: max-content;
            animation: scrollText 15s linear infinite;
        }


        /* Optional Animation for Scrolling Effect */
        @keyframes scrollText {
            from {
                transform: translateX(0%);
            }

            to {
                transform: translateX(-50%);
            }
        }
    </style>
@endsection
@section('external-home-content')
    @php
        $typeAction =
            isset($_GET['service_type']) && $_GET['service_type'] == 0 ? 'is_pickup_open' : 'is_delivery_open';
        $typeTime = isset($_GET['service_type']) && $_GET['service_type'] == 0 ? 'pickup_start' : 'delivery_start';

    @endphp
    <section class="pb-0 pt-2 bg-white overflow-hidden">
    <div class="container">
        <div class="row h-100">
            <div class="col-md-12 d-flex align-items-center justify-content-center">
                <a style="cursor:pointer"
                    class="prev-btn px-3 text-primary rounded-circle d-md-flex d-none justify-content-center align-items-center">
                    <i class="fa fa-chevron-left fs-4" aria-hidden="true"></i>
                </a>
                
                <div class="owl-carousel category_items">
                    @if (isset($categories) && !empty($categories))
                        
                        @foreach ($categories as $category)
                            <a href="javascript:void(0);" class="card border-0 p-0 mt-3 category-item {{ in_array($category->slug, explode(',', request()->input('categories') ?? '')) ? 'selected-category' : '' }}" data-category="{{ $category->slug }}">
                                <div style="background: #fff;" class=" rounded">
                                    @if (Str::startsWith($category->mobile_image, 'http'))
                                        <img src="{{ $category->mobile_image }}" class="rounded-2" alt=""
                                            style="max-height:2.5rem;">
                                    @elseif($category->mobile_image == '')
                                        <img src="{{ asset('uploads/foodu.png') }}" class="rounded-2" alt=""
                                            style="max-height:3rem;object-fit:contain;">
                                    @else
                                        <img src="{{ asset('uploads/category/mobile/' . $category->mobile_image) }}"
                                            class="rounded-2" alt=""
                                            style="max-height:3rem;object-fit:contain;">
                                    @endif
                                </div>
                                <span class="fw-bold text-center" style="font-size: 12px;">
                                    {{ Str::limit($category->name, 8, '') }}
                                </span>

                            </a>
                        @endforeach
                    @endif
                </div>
                <a style="cursor:pointer"
                    class="next-btn px-3 text-primary rounded-circle d-md-flex d-none justify-content-center align-items-center">
                    <i class="fa fa-chevron-right fs-4" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize selected categories from URL or empty set
    const urlParams = new URLSearchParams(window.location.search);
    const categoriesParam = urlParams.get('categories');
    const selectedCategories = new Set(categoriesParam ? categoriesParam.split(',') : []);
    
    // Highlight initially selected categories
    document.querySelectorAll('.category-item').forEach(item => {
        const category = item.getAttribute('data-category');
        if (category === 'alal' && selectedCategories.size == "ox") {
            item.classList.add('selected-category');
        } else if (selectedCategories.has(category)) {
            item.classList.add('selected-category');
        }
    });
    
    // Handle category selection
    document.querySelectorAll('.category-item').forEach(item => {
        item.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            
            if (category === 'all') {
                // Clear all selections
                selectedCategories.clear();
                document.querySelectorAll('.category-item').forEach(el => {
                    el.classList.remove('selected-category');
                });
                // Select "All"
                this.classList.add('selected-category');
                filterProducts();
                return;
            }
            
            // Toggle selection
            if (selectedCategories.has(category)) {
                selectedCategories.delete(category);
                this.classList.remove('selected-category');
            } else {
                selectedCategories.add(category);
                this.classList.add('selected-category');
            }
            
            // Update "All" state
            // const allItem = document.querySelector('[data-category="all"]');
            // if (selectedCategories.size === 0) {
            //     allItem.classList.add('selected-category');
            // } else {
            //     allItem.classList.remove('selected-category');
            // }
            
            filterProducts();
        });
    });
    
    function filterProducts() {
        const categories = Array.from(selectedCategories);
        const baseUrl = "{{ route('shop') }}";
        let url;
        
        if (categories.length === 0) {
            url = baseUrl;
        } else {
            url = `${baseUrl}?categories=${categories.join(',')}`;
        }
        
        window.location.href = url;
    }
});
</script>

<style>
.category-item {
    transition: all 0.3s ease;
    margin: 0 5px;
    border: 2px solid transparent;
    cursor: pointer;
}
.category-item:hover {
    transform: translateY(-3px);
}
.selected-category {
    /*border: 2px solid #f41909 !important;*/
    background-color: #fff !important;
    padding: auto 5px !important;
    /*box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);*/
    position: relative;
}
.selected-category::after {
    content: "✓";
    position: absolute;
    top: -8px;
    right: -8px;
    background: green;
    color: white;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}
#open_now,
#free_delivery,#id1,#id2 {
  width: 3rem;
  height: 1.2rem;
  transform: scale(1.3);
}
</style>


    <section class="py-0  ">
        <div class="container-fluid py-5 pt-3">
            <div class="row">
                <div class="col-md-4 col-lg-3 d-md-block d-none ">
                    <div class="card  rounded-0 border-0 shadow-0 h-100">
                        <div class="card-body">
                            <p class="fw-bold  mb-1">{{ count($open_vendors) }} places</p>
                            <div class="d-flex justify-content-start ">
                                <label class="fw-bold me-3" for="open_now">Open now</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input input" type="checkbox" @checked(isset($_GET['restaurant_status']) && $_GET['restaurant_status'] == 1)
                                        name="restaurant_status" value="1" id="open_now">

                                </div>
                            </div>
                            <div class="d-flex justify-content-start">
                                <label class="fw-bold me-3" for="free_delivery">Free Delivery</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input input" type="checkbox" name="isDelivery"
                                        @checked(isset($_GET['isDelivery']) && $_GET['isDelivery'] == 1) value="1" id="free_delivery">

                                </div>
                            </div>
                            <div class="d-flex align-items-center ">
                                <p class="fw-bold  mb-0 pb-0 me-2">Minimum order Amount</p>
                                <i class="fa fa-info-circle text-primary" aria-hidden="true"></i>
                            </div>
                            <div class="form-check ">
                                <input class="form-check-input input" @if (isset($_GET['show']) && ($_GET['show'] != 'low' || $_GET['show'] != 'heigh')) checked @endif
                                    type="radio" name="show" value="all" id="show_all">
                                <label class="form-check-label " style="font-size:16px !important;" for="show_all">
                                    Show All ({{ count($open_vendors) }})
                                </label>
                            </div>
                            <div class="form-check ">
                                <input class="form-check-input input" @checked(isset($_GET['show']) && $_GET['show'] == 'low') type="radio"
                                    name="show" value="low" id="price_to_low">
                                <label class="form-check-label " style="font-size:16px !important;" for="price_to_low">
                                    10,00 & or less
                                </label>
                            </div>
                            <div class="form-check ">
                                <input class="form-check-input input" @checked(isset($_GET['show']) && $_GET['show'] == 'heigh') type="radio"
                                    name="show" value="heigh" id="price_to_hight">
                                <label class="form-check-label " style="font-size:16px !important;" for="price_to_hight">
                                    10,00 & or greater
                                </label>
                            </div>
                            <p class="fw-bold  mb-1">Rating</p>
                            <div class="d-flex justify-content-start">
                                <div class="d-flex mb-2 rating">
                                    <input class="input" type="radio" @checked(isset($_GET['star']) && $_GET['star'] == 5) name="star"
                                        value="5" id="star5"><label for="star5"></label>
                                    <input class="input" type="radio" @checked(isset($_GET['star']) && $_GET['star'] == 4) name="star"
                                        value="4" id="star4"><label for="star4"></label>
                                    <input class="input" type="radio" @checked(isset($_GET['star']) && $_GET['star'] == 3) name="star"
                                        value="3" id="star3"><label for="star3"></label>
                                    <input class="input" type="radio" @checked(isset($_GET['star']) && $_GET['star'] == 2) name="star"
                                        value="2" id="star2"><label for="star2"></label>
                                    <input class="input" type="radio" @checked(isset($_GET['star']) && $_GET['star'] == 1) name="star"
                                        value="1" id="star1"><label for="star1"></label>




                                </div>
                            </div>
                            <div class="d-flex align-items-center ">
                                <p class="fw-bold  mb-0 pb-0 me-2">Offers and savings</p>
                                <i class="fa fa-info-circle text-primary" aria-hidden="true"></i>
                            </div>
                            <div class="form-check my-2">
                                <input class="form-check-input input" type="checkbox" @checked(isset($_GET['offer']) && $_GET['offer'] == 'true')
                                    value="true" name="offer" id="offers">
                                <label class="form-check-label" for="offers">
                                    Offers
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input input" type="checkbox" name="stampcard"
                                    @checked(isset($_GET['stampcard']) && $_GET['stampcard'] == 'true') value="true" id="stampcard">
                                <label class="form-check-label" for="stampcard">
                                    StampCards
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-lg-9">
                   
                    <div class="row mt-3">
                        <div class="col-md-12 " id="listview">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <h5 class="fw-bold fs-1 mb-1">Order from {{ count($open_vendors) }} Shops/Restaurants</h5>
                                <a href="{{route('shop')}}" class="btn btn-sm btn-light rounded-pill fs-1 px-3 py-2" style="background:#ededed !important; white-space:nowrap;"> <i class="fa-solid fa-shop me-2 text-danger"></i> All Shops</a>
                           
                               <div class="custom-select-wrapper" style="max-width:10rem;">
                                <div class="custom-select ">
                                    <select name="sort_by" class="rounded-pill fs-1">
                                        <option value="">Sort By</option>
                                        <option value="rating" @if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'rating') selected @endif>Rating
                                        </option>
                                        <option value="price_low_to_high"
                                            @if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'price_low_to_high') selected @endif>Price: Low to High</option>
                                        <option value="price_high_to_low"
                                            @if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'price_high_to_low') selected @endif>Price: High to Low</option>
                                    </select>
                              
                                </div>
                            </div>
                            </div>
                            <a href="" style="font-size: 13px; text-decoration:underline">Learn how results are
                                sorted</a>
                            <div class="row">
                                
                                 
                            @php
                                // Initialize categories
                                $bothServicesOpen = [];
                                $deliveryOnly = [];
                                $pickupOnly = [];
                                $deliveryFutureOpen = [];
                                $deliveryPickupFutureOpen = [];
                                $pickupFutureOpen = [];
                                $closedVendors = [];

                                // Categorize vendors
                                foreach ($open_vendors as $open_vendor) {
                                    $availability = $open_vendor['availability'] ?? [];
                                    $isDeliveryOpen = $availability['is_delivery_open'] ?? false;
                                    $isPickupOpen = $availability['is_pickup_open'] ?? false;
                                    $deliveryStart = $availability['delivery_start'] ?? '';
                                    $pickupStart = $availability['pickup_start'] ?? '';

                                    if ($isDeliveryOpen && $isPickupOpen) {
                                        $bothServicesOpen[] = $open_vendor;
                                    } elseif ($isDeliveryOpen) {
                                        $deliveryOnly[] = $open_vendor;
                                    } elseif ($isPickupOpen) {
                                        $pickupOnly[] = $open_vendor;
                                    } elseif (!$isDeliveryOpen && !$isPickupOpen) {
                                        if (!empty($deliveryStart) && !empty($pickupStart)) {
                                            $deliveryPickupFutureOpen[] = $open_vendor;
                                        } elseif (!empty($deliveryStart) && empty($pickupStart)) {
                                            $deliveryFutureOpen[] = $open_vendor;
                                        } elseif (!empty($pickupStart) && empty($deliveryStart)) {
                                            $pickupFutureOpen[] = $open_vendor;
                                        } else {
                                            $closedVendors[] = $open_vendor;
                                        }
                                    }
                                }
                            @endphp

                            <!-- Display Categories -->
                            @foreach ([
            'Open For Delivery and Pickup Service' => $bothServicesOpen,
            'Open For Delivery Service Only' => $deliveryOnly,
            'Open For Only Pickup Service' => $pickupOnly,
            'Pre-Order for Delivery and Pickup Service' => $deliveryPickupFutureOpen,
            'Pre-Order for Delivery' => $deliveryFutureOpen,
            'Pre-Order for Pickup' => $pickupFutureOpen,
            'Closed Shops' => $closedVendors,
        ] as $heading => $vendors)
                                @if (count($vendors) > 0)
                                    @php
                                        $dim = $heading == 'Closed Shops' ? 'opacity:0.7;' : '';
                                    @endphp
                                    <h3 class="mt-4 fs-1 text-md-start text-center">{{ $heading }}</h3>
                                    @foreach ($vendors as $open_vendor)
                                        @php
                                            $availability = $open_vendor['availability'] ?? [];
                                            $pickupTime = '';
                                           
                                            if ($heading == 'Pre-Order for Delivery') {
                                                $avtime = $availability['delivery_start'] ?? '';
                                            } elseif ($heading == 'Pre-Order for Delivery and Pickup Service') {
                                                $avtime = $availability['delivery_start'] ?? '';
                                                $pickupTime = $availability['pickup_start'] ?? '';
                                            } elseif ($heading == 'Pre-Order for Pickup') {
                                                $avtime = $availability['pickup_start'] ?? '';
                                                
                                            } else {
                                                $avtime = '';
                                            }
                                        @endphp
                                        <div class="col-md-4 col-lg-3 col-sm-6">
                                        <div class="card overflow-hidden mt-3 border-0 shadow-0"
                                            style="{{ $dim }}">
                                            <div class="row">
                                                <a 
@if ($avtime != '' || $heading == 'Open For Delivery Service Only' || $heading == 'Open For Only Pickup Service' || $heading == 'Closed Shops') 
    data-url="{{ route('shop.view', $open_vendor->unid) }}"
    data-off="{{ $heading ?? '' }}"
    data-pickup="{{ $pickupTime ?? '' }}"
    data-open="{{ $avtime ?? '' }}"
    href="javascript:void(0)"
    class="position-relative pe-md-0 pe-auto vendor-link"
@else
    href="{{ route('shop.view', $open_vendor->unid) }}"
    class="col-12 position-relative"
@endif
style="height: 12rem;">
                                                    <div class="img-view position-relative h-100">
                                                        <img src="{{ asset('uploads/users/' . $open_vendor->profile) }}"
                                                            class="h-100 w-100 rounded-2" alt="" style="border-bottom-left-radius:0px !important; border-bottom-right-radius:0px !important;">
                                                        <div class="logo-ic" style="left:5%;bottom:5%;">
                                                            <img src="@if (!empty($open_vendor->vendor_details->logo)) {{ asset('uploads/logo/' . $open_vendor->vendor_details->logo) }} @else {{ asset('uploads/logo/default.png') }} @endif"
                                                                alt="" >
                                                        </div>
                                                        @if ($avtime != '')
                                                            <span style="cursor:pointer;"
                                                                class="pmt px-2 py-1 fw-bolder text-white me-2">Open From:
                                                                {{ $avtime ?? '' }} </span>
                                                        @elseif($heading == 'Open For Delivery Service Only')
                                                            <span style="cursor:pointer;"
                                                                class="pmt px-2 py-1 fw-bolder text-white me-2">Only Delivery
                                                                </span>
                                                        @elseif($heading == 'Open For Only Pickup Service')
                                                            <span style="cursor:pointer;"
                                                                class="pmt px-2 py-1 fw-bolder text-white me-2">Pickup
                                                                Only</span>
                                                        @elseif($heading == 'Closed Shops')
                                                            <span style="cursor:pointer;"
                                                                class="pmt px-2 py-1 fw-bolder text-white me-2">Currently ordering is <br> not available</span>
                                                        @endif
                                                        @if (!empty($open_vendor->vendor_details->isSponsored) && $open_vendor->vendor_details->isSponsored == 1)
                                                            <div class="ft-ic"
                                                                title="{{ $open_vendor->vendor_details->company_name }}">
                                                                Sponsored
                                                            </div>
                                                        @endif
                                                    </div>
                                                </a>
                                                <div class="col-12">
                                                     <div class="row g-0 w-100">
                                                            <div class="col-md-12">
                                                                @php
    $discounts = $open_vendor->offers ?? []; 
@endphp

@if (!empty($discounts) && isset($discounts[0]))
    <div class="discount-strip w-100 overflow-hidden">
        <div class="scrolling-text" style="gap:20px;">
            @if ($open_vendor->isOffer)
                <p class="mb-0 pb-0">
                    <i class="fas fa-tag text-danger"></i> Offer
                </p>
            @endif
            
            {{-- Repeat offers 3 times for smooth scrolling --}}
            @for ($i = 0; $i < 4; $i++)
                @foreach ($discounts as $discount)
                    @if (isset($discount['is_active']) && $discount['is_active'])
                        @php 
                            $slot = $discount->slots->first() ?? null;
                        @endphp
                        <span class="discount-item">
                            🎉 {{ $discount['title'] }} - 
                            @if ($discount['offer_type'] == 'percentage')
                                {{ number_format($discount['discount_value']) }}% OFF
                            @else
                                €{{ number_format($discount['discount_value'], 2) }} OFF
                            @endif
                            | Valid till {{ date('d M Y', strtotime($discount['end_date'])) }}
                            @if ($slot)
                                | ⏰ Running Now: {{ date('h:i A', strtotime($slot->start_time)) }} - {{ date('h:i A', strtotime($slot->end_time)) }}
                            @endif
                        </span>
                    @endif
                @endforeach
            @endfor
        </div>
    </div>
@endif


                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="col-12 d-flex align-items-center">
                                                    <div
                                                        class="card-body px-md-0 pt-1 px-auto flex-column justify-content-start d-flex align-items-start">
                                                        <div>
                                                            <a href="{{ route('shop.view', $open_vendor->unid) }}"
                                                                class="fw-bold pb-0 mb-2 fs-1">
                                                                {{ $open_vendor->name }}
                                                            </a>
                                                            <div class="d-flex mb-2 fs-1 align-items-center flex-wrap"
                                                                style="cursor: pointer;">
                                                                <i data-bs-toggle="modal"
                                                                    data-vendor-id="{{ $open_vendor->id }}"
                                                                    data-bs-target="#staticBackdrop2"
                                                                    class="fa fa-star me-1 text-warning"
                                                                    style="font-size: 14px;" aria-hidden="true"></i>
                                                                <small class="text-dark me-2 fw-bold">
                                                                    {{ number_format($open_vendor->average_rating, 1) }}
                                                                    <!--({{ $open_vendor->total_reviews }})-->
                                                                </small>
                                                                <small>
                                                                    {{ $open_vendor->category_names ?? '' }}
                                                                </small>
                                                            </div>
                                                            <div class="d-flex fs-1 flex-wrap">
                                                                <div class="me-2 mt-2 d-flex align-items-center"
                                                                    style="font-size:14px;">
                                                                     @php
                                                                        $deliveryCost=$open_vendor->delivery_charge ?? ($open_vendor->vendor_details->delivery_cost ?? 0);
                                                                        
                                                                        $minOrderCost=$open_vendor->min_order_price ?? ($open_vendor->vendor_details->minimum_price ?? 0);
                                                                        
                                                                        $maxTimeDeliver=$open_vendor->estimated_time ?? ($open_vendor->vendor_details->max_prepare_time ?? 0);
                                                                    @endphp
                                                                    <i class="fa-regular fa-clock me-2"></i>
                                                                    <span
                                                                        class="d-flex fw-bold">{{ $open_vendor->vendor_details->min_prepare_time ?? '0' }}-{{ $maxTimeDeliver ?? '0' }}
                                                                        Mins</span>
                                                                </div>
                                                                @if((request('service_type')!="0" && $heading!="Open For Only Pickup Service"))
                                                                <div class="me-2 d-flex mt-2 align-items-center"
                                                                    style="font-size:14px;">
                                                                    <i class="fa-solid fa-bicycle me-2"></i>
                                                                    <span class="d-flex fw-bold">{{ number_format($deliveryCost ?? 0, 2) }}€</span>
                                                                </div>
                                                                <div class="me-2 d-flex mt-2 align-items-center"
                                                                    style="font-size:14px;">
                                                                    <i class="fa-solid fa-bowl-rice me-2"></i>
                                                                    <span class="d-flex fw-bold">Min.
                                                                        {{ number_format($minOrderCost ?? 0, 2) }}€</span>
                                                                </div>
                                                                @endif
                                                                @if (isset($open_vendor->distance) && (request('service_type')=="0" || $heading=="Open For Only Pickup Service"))
                                                                <p class="mb-0 pb-0 mt-2 fw-bold" style="font-size:14px;">
                                                                    <i class="fa-solid fa-location-dot"></i>
                                                                    {{ $open_vendor->distance }} 
                                                                </p>
                                                                @endif
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                            
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
</div>   
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

   <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title fs-2 fw-bold" id="staticBackdropLabel">
                    <i class="bi bi-star-fill me-2"></i>Customer Reviews From <span id="vendor_nameId"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Overall Rating Summary -->
                <div class="rating-summary bg-light py-4 px-4 border-bottom">
                    <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap">
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="overall-rating-display me-4">
                                <div class="display-3 fw-bold text-primary mb-1" id="averageRating">0.0</div>
                                <div class="stars-large mb-1" id="overallStars">
                                    <span class="text-warning">☆☆☆☆☆</span>
                                </div>
                            </div>
                            <div class="rating-info">
                                <div class="fs-5 fw-bolder text-dark">Overall Rating</div>
                                <div class="text-muted">
                                    Based on <span class="fw-bold text-primary" id="totalReviewsCount">0</span> ratings
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary fs-6 px-3 py-2" style="line-height:normal;" id="ratingBadge">
                                0.0 ★
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<style>
    .bg-gradient-primary {
        background: red !important;
    }
    .bi-star-fill{
        color: gold !important;
    }
    .stars-large {
        font-size: 1.5rem;
        letter-spacing: 2px;
    }
    
    .review-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border: 1px solid #eef2f7;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .review-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    
    .review-rating {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    
    .rating-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #ff6b35;
        margin-right: 10px;
    }
    
    .rating-stars {
        color: #ffc107;
        font-size: 1.1rem;
        letter-spacing: 2px;
    }
    
    .review-message {
        color: #2d3748;
        line-height: 1.6;
        font-size: 1rem;
        background: #f8fafc;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid #667eea;
        margin-top: 0.5rem;
    }
    
    .review-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
        font-size: 0.85rem;
        color: #718096;
    }
    
    .review-date {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .report-btn {
        font-size: 0.85rem;
        padding: 0.25rem 0.75rem;
    }
    
    .badge {
        font-size: 1.1rem;
        font-weight: 600;
    }
</style>

    <div class="modal fade" id="filtermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content rounded-2">
                <div class="modal-header">
                    <h5 class="modal-title fs-2 fw-bolder" id="staticBackdropLabel">Filter </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="get" class="card-body">
                        <p class="fw-bold  mb-1 fs-1">{{ count($open_vendors) }} places</p>
                        <div class="d-flex justify-content-between ">
                            <p class="fw-bold fs-1">Open now</p>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="id1"
                                    @checked(isset($_GET['restaurant_status']) && $_GET['restaurant_status'] == 1) name="restaurant_status" value="1">

                            </div>
                        </div>
                        <div class="d-flex justify-content-between ">
                            <p class="fw-bold fs-1">Free Delivery</p>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="id2" name="isDelivery"
                                    @checked(isset($_GET['isDelivery']) && $_GET['isDelivery'] == 1) value="1">
                            </div>
                        </div>
                        <div class="d-flex align-items-center fs-1">
                            <p class="fw-bold  mb-0 pb-0 me-2 fs-1">Minimum order Amount</p>
                            <i class="fa fa-info-circle text-primary" aria-hidden="true"></i>
                        </div>
                        <div class="form-check ">
                            <input class="form-check-input fs-1" @if (isset($_GET['show']) && ($_GET['show'] != 'low' || $_GET['show'] != 'heigh')) checked @endif
                                type="radio" name="show" value="all" id="id3">
                            <label class="form-check-label fs-1" for="id3">
                                Show All ({{ count($open_vendors) }})
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input fs-1" @checked(isset($_GET['show']) && $_GET['show'] == 'low') type="radio"
                                name="show" value="low" id="id7">
                            <label class="form-check-label fs-1" for="id7">
                                10,00 & or less
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input fs-1" @checked(isset($_GET['show']) && $_GET['show'] == 'heigh') type="radio"
                                name="show" value="heigh" id="id9">
                            <label class="form-check-label fs-1" for="id9">
                                10,00 & or greater
                            </label>
                        </div>
                        <p class="fw-bold  mb-1">Rating</p>
                        <div class="d-flex justify-content-start">
                            <div class="d-flex mb-2 rating">
                                <input type="radio" @checked(isset($_GET['star']) && $_GET['star'] == 5) name="star" value="5"
                                    id="star5"><label for="star5"></label>
                                <input type="radio" @checked(isset($_GET['star']) && $_GET['star'] == 4) name="star" value="4"
                                    id="star4"><label for="star4"></label>
                                <input type="radio" @checked(isset($_GET['star']) && $_GET['star'] == 3) name="star" value="3"
                                    id="star3"><label for="star3"></label>
                                <input type="radio" @checked(isset($_GET['star']) && $_GET['star'] == 2) name="star" value="2"
                                    id="star2"><label for="star2"></label>
                                <input type="radio" @checked(isset($_GET['star']) && $_GET['star'] == 1) name="star" value="1"
                                    id="star1"><label for="star1"></label>




                            </div>
                        </div>
                        <div class="d-flex align-items-center fs-1">
                            <p class="fw-bold  mb-0 pb-0 me-2 fs-1">Offers and savings</p>
                            <i class="fa fa-info-circle text-primary" aria-hidden="true"></i>
                        </div>
                        <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" @checked(isset($_GET['offer']) && $_GET['offer'] == 'true') value="true"
                                name="offer" id="offers">
                            <label class="form-check-label fs-1" for="offers">
                                Offers
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="stampcard"
                                @checked(isset($_GET['stampcard']) && $_GET['stampcard'] == 'true') value="true" id="stampcard">
                            <label class="form-check-label fs-1" for="stampcard">
                                StampCards
                            </label>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-sm btn-primary">Apply</button>
                        </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    <div class="modal fade" id="vendorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="vendorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm rounded-2">
            <div class="modal-content">

                <div class="modal-body position-relative">
                    <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal"
                        aria-label="Close" style="top:4%;right:4%;font-size:13px;"></button>
                    <p class="fs-3 fw-bolder mt-3 pb-0 mb-0 text-center"><strong id="modalHeading">Restaurant open at </strong> <span
                            id="modalTime"></span></p>
                    <p class="text-center pb-0 mb-2 fs-1" id="opencontent"></p>
                    <div class="d-flex justify-content-center align-items-center flex-column ">
                        <a id="preOrderBtn" href="#" class="btn btn-primary rounded-pill mb-1">Order for later</a>
                        <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Alternative
                            nearby</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('external-js')
    
   <script>
$(document).ready(function() {

    // ✅ Use delegated event (works for dynamic content too)
    $(document).on('click', '.vendor-link', function(e) {

        e.preventDefault();

        const openTime   = $(this).attr('data-open') || '';
        const openPickup = $(this).attr('data-pickup') || '';
        const isoff      = $(this).attr('data-off') || '';
        const preOrderUrl= $(this).attr('data-url') || '';

        // 🧠 Better condition handling
        if (openTime !== '') {

            $('#modalTime').text(openTime);

            if (openPickup !== '') {
                $('#opencontent').text(
                    `You can schedule delivery from ${openTime} or schedule pickup from ${openPickup}.`
                );
            } else {
                $('#opencontent').text(`You can schedule your order for later.`);
            }

            $('#preOrderBtn').attr('href', preOrderUrl);
            $('#modalHeading').text('Shop Open at ');

        } else {

            if (isoff == "Closed Shops") {
                $('#opencontent').text(
                    `Currently ordering is not available. Please check back later or explore other nearby options.`
                );
                $('#preOrderBtn').attr('href', preOrderUrl);
                // want to see menu like this i want button name
                $('#preOrderBtn').text('See Menu');

                

            } else if (isoff === "Open For Delivery Service Only") {
                $('#opencontent').text(`This shop is available for delivery only.`);
                $('#modalHeading').text('Shop open for delivery only');
                $('#preOrderBtn').attr('href', preOrderUrl);
                 $('#preOrderBtn').text('Order for delivery');
            } else if (isoff === "Open For Only Pickup Service") {
                $('#opencontent').text(`This shop is available for pickup only.`);
                $('#modalHeading').text('Shop open for pickup only');
                $('#preOrderBtn').attr('href', preOrderUrl);
                $('#preOrderBtn').text('Order for pickup');
            } else {
                $('#opencontent').text(`Currently unavailable.`);
                    $('#modalHeading').text('Shop unavailable');
                    $('#preOrderBtn').attr('href', preOrderUrl);
            }
        }

        // ✅ Show modal
        $('#vendorModal').modal('show');

    });

});
</script>
    <script>
        $(document).ready(function() {
            $('.category_items').owlCarousel({
                loop: true,
                margin: 0,
                dots: false,
                responsiveClass: true,
                responsive: {
    0: {
        items: 3,
        nav: false
    },
    320: {
        items: 4,
        nav: false
    },
    480: {
        items: 4,
        nav: false
    },
    600: {
        items: 6,
        nav: false
    },
    768: {
        items: 8,
        nav: false
    },
    992: {
        items: 10,
        nav: false
    },
    1200: {
        items: 12,
        nav: false,
        loop: false
    },
    1400: {
        items: 14,
        nav: false,
        loop: false
    }
}

            })


            var owl = $(".category_items");
            owl.owlCarousel();
            $(".next-btn").click(function() {
                owl.trigger("next.owl.carousel");
            });
            $(".prev-btn").click(function() {
                owl.trigger("prev.owl.carousel");
            });
            $(".prev-btn").addClass("disabled");
            $(owl).on("translated.owl.carousel", function(event) {
                if ($(".owl-prev").hasClass("disabled")) {
                    $(".prev-btn").addClass("disabled");
                } else {
                    $(".prev-btn").removeClass("disabled");
                }
                if ($(".owl-next").hasClass("disabled")) {
                    $(".next-btn").addClass("disabled");
                } else {
                    $(".next-btn").removeClass("disabled");
                }
            });


            $('.popular_items').owlCarousel({
                loop: true,
                margin: 20,
                dots: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: false
                    },
                    600: {
                        items: 5,
                        nav: false
                    },
                    1000: {
                        items: 7,
                        nav: false,
                        loop: false
                    }
                }
            })
            var popular_items = $(".popular_items");
            popular_items.owlCarousel();
            $("#popular_right").click(function() {
                popular_items.trigger("next.owl.carousel");
            });
            $("#popular_left").click(function() {
                popular_items.trigger("prev.owl.carousel");
            });
            $("#popular_left").addClass("disabled");
            $(popular_items).on("translated.owl.carousel", function(event) {
                if ($(".owl-prev").hasClass("disabled")) {
                    $("#popular_left").addClass("disabled");
                } else {
                    $("#popular_left").removeClass("disabled");
                }
                if ($(".owl-next").hasClass("disabled")) {
                    $("#popular_right").addClass("disabled");
                } else {
                    $("#popular_right").removeClass("disabled");
                }
            });


            $('.search_foods').owlCarousel({
                loop: true,
                margin: 20,
                dots: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: false
                    },
                    600: {
                        items: 5,
                        nav: false
                    },
                    1000: {
                        items: 7,
                        nav: false,
                        loop: false
                    }
                }
            })
            var search_foods = $(".search_foods");
            search_foods.owlCarousel();
            $("#popular_right1").click(function() {
                search_foods.trigger("next.owl.carousel");
            });
            $("#popular_left1").click(function() {
                search_foods.trigger("prev.owl.carousel");
            });
            $("#popular_left1").addClass("disabled");
            $(search_foods).on("translated.owl.carousel", function(event) {
                if ($(".owl-prev").hasClass("disabled")) {
                    $("#popular_left1").addClass("disabled");
                } else {
                    $("#popular_left1").removeClass("disabled");
                }
                if ($(".owl-next").hasClass("disabled")) {
                    $("#popular_right1").addClass("disabled");
                } else {
                    $("#popular_right1").removeClass("disabled");
                }
            });
        });
    </script>
    <script>
        function showMapView(event) {
            $('#mapview').removeClass('d-none');
            $('#listview').addClass('d-none');
        }

        function listMapView(event) {
            $('#mapview').addClass('d-none');
            $('#listview').removeClass('d-none');
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle checkbox state change
            const checkbox = document.getElementById('switch-checkbox');
            const switchContainer = document.getElementById('switch-container');
            const switchSlider = document.getElementById('switch-slider');
            const switchLabels = document.querySelectorAll('.switch-label');

            function switchChanged() {
                if (checkbox.checked) {
                    switchContainer.classList.add('checked');
                    switchSlider.textContent = '🧺 Pickup';
                } else {
                    switchContainer.classList.remove('checked');
                    switchSlider.textContent = '🚚 Delivery';
                }
                checkbox.dispatchEvent(new Event('change'));
            }
            switchChanged();
            switchContainer.addEventListener('click', function() {
                checkbox.checked = !checkbox.checked;
                switchChanged();
            });
            const inputs = document.querySelectorAll('.input, select');
            inputs.forEach(input => {
                input.addEventListener('change', function() {
                    const params = new URLSearchParams();

                    inputs.forEach(i => {
                        if (i.type === 'checkbox' && i.checked) {
                            params.append(i.name, i.value);
                        } else if (i.type === 'radio' && i.checked) {
                            params.append(i.name, i.value);
                        } else if (i.type === 'text') {
                            params.append(i.name, i.value);
                        } else if (i.tagName.toLowerCase() === 'select') {
                            if (i.value) {
                                params.append(i.name, i.value);
                            }
                        }
                    });

                    const url = `${window.location.pathname}?${params.toString()}`;
                    window.location.href = url;
                });
            });

        });
    </script>
    <script>
    function updateLocationDisplay() {
        const storedLocation = JSON.parse(localStorage.getItem('location'));
        console.log(storedLocation)
        if (!storedLocation) return;

        const {
            street,
            streetNumber,
            sublocality,
            city,
            state
        } = storedLocation;

        let locationParts = [];

        // Check and add street with number
        if (street) {
            let fullStreet = street;
            if (streetNumber) fullStreet += ' ' + streetNumber;
            locationParts.push(fullStreet);
        }

        // Add sublocality only if street is not available
        if (!street && sublocality) {
            locationParts.push(sublocality);
        }

        
        if (city) {
            locationParts.push(city);
        }

        document.getElementById('location-display').innerText = locationParts.join(', ');
    }

    updateLocationDisplay();
</script>

    <script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('staticBackdrop2');
    const reportModal = document.getElementById('reportModal');

    if (!modal) return;

    const reportModalInstance = reportModal
        ? new bootstrap.Modal(reportModal, { backdrop: 'static', keyboard: false })
        : null;

    modal.addEventListener('shown.bs.modal', function (event) {

        const triggerElement = event.relatedTarget;
        if (!triggerElement) return;

        const vendorId = triggerElement.getAttribute('data-vendor-id');
        const authUserId = "{{ auth()->user()->id ?? '' }}";

        if (!vendorId) return;

        const url = "{{ route('shop.fetch.shop.details') }}/" + vendorId;

        fetch(url)
            .then(res => res.json())
            .then(data => {

                /* ================= OVERALL RATING ================= */
                const avgRating = Number(data.average_rating || 0).toFixed(1);

                document.getElementById('averageRating').textContent = avgRating;
                document.getElementById('ratingBadge').textContent = avgRating + ' ★';
                document.getElementById('overallStars').innerHTML =
                    generateStarRating(data.average_rating, 'large');
                document.getElementById('totalReviewsCount').textContent =
                    data.total_reviews || 0;
                 document.getElementById('vendor_nameId').textContent = data?.vendor_name;
                /* ================= REVIEWS ================= */
                const reviewsList = document.getElementById('reviewsList');
                const noReviewsMessage = document.getElementById('noReviewsMessage');

                reviewsList.innerHTML = '';

                if (data.reviews && data.reviews.length > 0) {
                    if (noReviewsMessage) noReviewsMessage.style.display = 'none';

                    data.reviews.forEach(review => {
                        const reviewCard = createReviewCard(
                            review,
                            authUserId,
                            vendorId
                        );
                        reviewsList.appendChild(reviewCard);
                    });

                } else {
                    if (noReviewsMessage) noReviewsMessage.style.display = 'block';
                }

                setupReportButtons();

            })
            .catch(error => {
                console.error('Error fetching vendor details:', error);
                document.getElementById('reviewsList').innerHTML = `
                    <div class="text-center py-5">
                        <i class="bi bi-exclamation-triangle text-danger fs-2"></i>
                        <p class="mt-2 text-danger">Failed to load reviews.</p>
                    </div>
                `;
            });
    });

    /* ================= STAR RATING ================= */
    function generateStarRating(rating = 0, size = 'normal') {

        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 >= 0.5;
        const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);

        let stars = `<span class="${size === 'large' ? 'stars-large' : 'rating-stars'}">`;

        stars += '<i class="bi bi-star-fill"></i>'.repeat(fullStars);
        if (hasHalfStar) stars += '<i class="bi bi-star-half"></i>';
        stars += '<i class="bi bi-star"></i>'.repeat(emptyStars);

        stars += '</span>';
        return stars;
    }

    /* ================= REVIEW CARD ================= */
    function createReviewCard(review, authUserId, vendorId) {

        const div = document.createElement('div');
        div.className = 'review-card mb-3';

        div.innerHTML = `
            <div class="review-rating">
                <div class="rating-value">${Number(review.rating || 0).toFixed(1)}</div>
                ${generateStarRating(review.rating)}
            </div>

            <div class="review-message">
                ${review.review_msg || 'No message provided'}
            </div>

            <div class="review-meta">
                <div class="review-date">
                    <i class="bi bi-calendar"></i>
                    ${formatDate(review.date)}
                </div>

                ${authUserId == vendorId ? `
                <button class="btn btn-outline-danger btn-sm report-btn"
                        data-review-id="${review.id}"
                        data-review-msg="${review.review_msg || ''}">
                    <i class="bi bi-flag"></i> Report
                </button>` : ''}
            </div>
        `;

        return div;
    }

    /* ================= DATE FORMAT ================= */
    function formatDate(dateString) {
        if (!dateString) return '';
        return new Date(dateString).toLocaleDateString('en-US', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    /* ================= REPORT BUTTON ================= */
    function setupReportButtons() {
        document.querySelectorAll('.report-btn').forEach(btn => {
            btn.onclick = function () {
                document.getElementById('reportReviewId').value =
                    this.dataset.reviewId;
                document.getElementById('reportMessage').value =
                    this.dataset.reviewMsg || '';
                document.getElementById('reportReason').value = '';
                document.getElementById('additionalDetails').value = '';

                reportModalInstance?.show();
            };
        });
    }

    /* ================= REPORT SUBMIT ================= */
    document.getElementById('submitReport')?.addEventListener('click', function () {

        const payload = {
            review_id: document.getElementById('reportReviewId').value,
            message: document.getElementById('reportMessage').value,
            reason: document.getElementById('reportReason').value,
            additional_details: document.getElementById('additionalDetails').value
        };

        if (!payload.reason.trim()) {
            alert('Please select a reason.');
            return;
        }

        fetch("{{ route('review.report') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(res => {
            res.success ? toastr.success(res.message) : toastr.error(res.message);
            reportModalInstance?.hide();
        })
        .catch(err => console.error(err));
    });

    /* ================= MODAL CLEANUP ================= */
    reportModal?.addEventListener('hidden.bs.modal', () => {
        document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
        document.body.classList.remove('modal-open');
        document.body.style.paddingRight = '';
    });

});

/* ================= BOOTSTRAP ICONS ================= */
if (!document.querySelector('link[href*="bootstrap-icons"]')) {
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css';
    document.head.appendChild(link);
}
</script>


    <script>
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                location.reload();
            }
        });

        window.addEventListener('focus', function() {
            location.reload();
        });
    </script>
@endsection
