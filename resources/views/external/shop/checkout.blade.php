@extends('external.frame')
@section('external-css')
    <style>
        .ios-fix {
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
        }

        /* iOS specific fixes */
        @@supports (-webkit-touch-callout: none) {

            .form-control,
            .form-select {
                font-size: 16px !important;
                /* Prevent zoom on focus */
            }

            .payment-card,
            .address-card {
                -webkit-tap-highlight-color: transparent;
            }
        }

        select.form-select {
            font-size: 16px !important;
            -webkit-appearance: none;
            appearance: none;
        }

        .accordion-button:focus {
            box-shadow: unset !important;
        }

        .accordion-button::after {
            content: "▲";
            background: unset !important;
        }

        .bg-1000 {
            display: none !important;
        }

        .lableform label {
            font-size: 20px !important;
        }

        .form-control-lg {
            border-radius: 10px !important;
            padding: auto 20px !important;
            font-size: 20px !important;
        }

        .add_cart {
            background-color: #ddd;
            color: #ff0000;
            height: 35px;
            width: 35px;
            border: 1px solid #ddd;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.4s ease-in;

        }

        .add_cart:hover {
            background-color: #ff0000;
            color: #ddd;

        }

        .qty-box {
            min-width: 8rem;
            display: flex;

        }

        .qty-box button {
            height: 40px;
            width: 30px;
            border-radius: 0%;
            border: 1px solid #ddd;
            color: #ff0000;
            font-size: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
        }

        .qty-box input {
            height: 40px !important;
            width: 40px !important;
            border-radius: 0%;
            border: 1px solid #ddd;
            color: #ff0000 !important;
        }

        .tabbtn:hover {
            border-radius: 20px;
        }

        .form-control {
            padding: 0.5rem !important;
            background: #fff !important;
        }

        .form-control:hover,
        .form-control:focus {
            box-shadow: none !important;
        }

        .payment-methods {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .payment-card input[type="radio"] {
            display: none;
        }

        .payment-card img {
            width: 50px;
            margin-right: 10px;
        }

        .payment-card span {
            font-size: 16px;
            font-weight: 700;
        }

        .payment-card input[type="radio"]:checked+.card-content {
            border: 2px solid orange;
            border-radius: 10px;
        }

        .list>li {
            line-height: 2;
            list-style: none;
            display: flex;
            justify-content: space-between;
        }

        .address-card {
            cursor: pointer;
            transition: border-color 0.3s ease;
            position: relative;
            /* needed for checkmark positioning */
        }

        .address-card .card-input {
            display: none;
        }

        .address-card .card-body {
            border: 2px solid #d6d6d6;
            border-radius: 0.5rem;
            position: relative;
            padding-right: 30px;
            /* space for checkmark */
        }

        /* ✅ when checked → green border + checkmark */
        .address-card .card-input:checked+.card-body {
            border: 2px solid green;
            border-radius: 0.5rem;
        }

        .address-card .card-input:checked+.card-body::after {
            content: "\2713";
            /* check mark */
            font-size: 20px;
            color: green;
            font-weight: bold;
            position: absolute;
            top: -7px;
            right: 5px;
        }

        /* Hover effect */
        .address-card:hover .card-body {
            border: 2px solid rgba(0, 128, 0, 0.5);
            /* greenish hover */
            border-radius: 0.5rem;
        }

        .nice-select {
            height: 47px !important;
            line-height: 47px !important;
            font-size: 18px;
            width: calc(100% - 30px);
        }

        /* ========== STICKY/SCROLLABLE LAYOUT STYLES ========== */
        @media (min-width: 1200px) {
            .checkout-wrapper {
                display: flex;
                flex-wrap: nowrap;
                align-items: flex-start;
                gap: 0;
            }

            .scrollable-column {
                flex: 0 0 66.666667%;
                max-width: 66.666667%;
                max-height: calc(100vh - 120px);
                overflow-y: auto;
                overflow-x: hidden;
                padding-right: 25px;
                scrollbar-width: thin;
                scrollbar-color: #c1c1c1 #f1f1f1;
                -webkit-overflow-scrolling: touch;
            }

            .scrollable-column::-webkit-scrollbar {
                width: 6px;
            }

            .scrollable-column::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
                margin: 10px 0;
            }

            .scrollable-column::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 10px;
            }

            .scrollable-column::-webkit-scrollbar-thumb:hover {
                background: #a1a1a1;
            }

            .sticky-column {
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
                position: sticky;
                top: 20px;
                max-height: calc(100vh - 120px);
                overflow-y: auto;
                padding-left: 15px;
            }

            .sticky-column .card {
                max-height: none;
            }
        }

        /* Mobile: reset all sticky/fixed behavior */
        @media (max-width: 1199.98px) {
            .checkout-wrapper {
                display: block;
            }

            .scrollable-column {
                flex: none;
                max-width: 100%;
                max-height: none;
                overflow-y: visible;
                padding-right: 0;
            }

            .sticky-column {
                flex: none;
                max-width: 100%;
                position: relative;
                top: auto;
                max-height: none;
                overflow-y: visible;
                padding-left: 0;
                margin-top: 20px;
            }
        }

        /* Smooth scrolling for the entire page */
        html {
            scroll-behavior: smooth;
        }
    </style>

    <style>
        .payment-methods {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .payment-card {
            position: relative;
            cursor: pointer;
            width: auto;
            flex: 0 0 auto;
        }

        .payment-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            width: 0;
            height: 0;
        }

        .card-content {
            position: relative;
            width: 220px;
            height: 100%;
            min-height: 60px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px 15px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: start;
            background: white;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        @media (max-width: 768px) {
            .payment-methods {
                gap: 10px;
                justify-content: center;
            }

            .payment-card {
                width: 100%;
                flex: 1 1 100%;
            }

            .card-content {
                width: 100%;
                justify-content: center;
            }

            .card-content span {
                font-size: 16px !important;
            }
        }

        .payment-card:hover .card-content {
            border-color: #ef4444;
            /* red border on hover */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }

        .payment-card input[type="radio"]:checked+.card-content {
            border-color: #ef4444;
            border-width: 2px;
            background-color: #fef2f2;
            box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.1);
        }

        .payment-card input[type="radio"]:checked+.card-content .checkmark {
            opacity: 1;
            transform: scale(1);
        }

        .checkmark {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 20px;
            height: 20px;
            background-color: #ef4444;
            /* match red theme */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
        }

        .checkmark svg {
            width: 12px;
            height: 12px;
            fill: white;
        }

        .card-content img {
            width: 32px;
            height: 32px;
            object-fit: contain;
            margin-right: 10px;
        }

        .card-content span {
            font-size: 15px;
            font-weight: 600;
            color: #334155;
            text-align: left;
            line-height: 1.2;
        }
    </style>

    <style>
        .autocomplete-suggestions {
            position: absolute;
            background: #fff;
            border: 1px solid #ddd;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            max-height: 250px;
            overflow-y: auto;
            z-index: 1000;
            right: 0px;
            left: 0px;
            -webkit-overflow-scrolling: touch;
            width: 100%;
            display: none;
            border-radius: 10px;
        }

        .autocomplete-suggestions div {
            padding: 12px;
            font-size: 1.2rem;
            color: #333 !important;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }

        .autocomplete-suggestions div:last-child {
            border-bottom: none;
        }

        .autocomplete-suggestions div:hover {
            background-color: #f7f7f7;
        }

        .home-search-input:focus+#autocomplete-suggestions {
            display: block;
        }

        @media (max-width: 768px) {
            .autocomplete-suggestions div {
                padding: 8px;
                font-size: 1.1rem;
            }
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
            border: none !important;
            border-bottom: 1px solid #ddd !important;
            line-height: normal !important;
            padding: 8px 4px !important;
        }

        .pac-icon {
            margin-top: 0px !important;
        }
    </style>

    <style>
        .my-select {
            width: 100%;
            padding: 8px 14px;
            font-size: 1.2rem;
            color: #333;
            background-color: #fff;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            outline: none;
            cursor: pointer;
            transition: all 0.3s ease;
            /* Remove default arrow */
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            /* Custom arrow */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='gray' viewBox='0 0 16 16'%3E%3Cpath d='M1.5 5.5l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 14px;
        }

        /* Hover */
        .my-select:hover {
            border-color: #999;
        }

        /* Focus */
        .my-select:focus {
            border-color: #f41909;
            box-shadow: 0 0 0 3px rgba(244, 25, 9, 0.15);
        }

        /* Disabled option */
        .my-select option[disabled] {
            color: #aaa;
        }
    </style>

    <style>
        .extra-item {
            display: none;
        }
    </style>
@endsection

@section('external-home-content')
    <section class="py-0 ">
        @php
            $sessionLocation = trim(
                (session('street') ? session('street') . ' ' : '')
                . (session('street_number') ? session('street_number') . ', ' : '')
                . (session('postcode') ? session('postcode') . ' ' : '')
                . (session('city') ? session('city') : '')
                . (session('sublocality') ? ', ' . session('sublocality') : '')
            );
        @endphp
        <div class="container-fluid py-5 pt-3">
            <form method="post" action="{{ route('paypal.payment') }}">
                @csrf
                @php
                    $totalAmount = 0;
                    $extraCost = 0;
                    $extraCost1 = 0;
                    $isReady = false;
                    $maxDeliveryTime = 30;
                    $restDiscount = $discounts['onResturant'];
                    $categoryDiscount = $discounts['onCategory'];
                    $totalDiscount = $restDiscount + $categoryDiscount;
                @endphp

                @foreach ($carts as $cart)
                    @php
                        $totalAmount += $cart->total_price;
                    @endphp
                @endforeach
                @php
                    if (isset($method) && $method == 'delivery') {
                        if (
                            isset($deliveryArea->min_order_price_free_delivery) &&
                            $totalAmount >= $deliveryArea->min_order_price_free_delivery
                        ) {
                            $extraCost1 = 0;
                        } else {
                            $extraCost1 = $deliveryArea->delivery_charge ?? 0;
                        }
                        if (isset($deliveryArea->min_order_price) && $totalAmount >= $deliveryArea->min_order_price) {
                            $isReady = true;
                        } else {
                            $isReady = false;
                        }
                    } else {
                        $extraCost1 = 0;
                        if (isset($deliveryArea->min_order_price) && $totalAmount >= $deliveryArea->min_order_price) {
                            $isReady = true;
                        } else {
                            $isReady = false;
                        }
                    }

                    $maxDeliveryTime = isset($deliveryArea->max_delivery_time) ? $deliveryArea->max_delivery_time : 45;

                @endphp
                <h1 class="text-center fw-bold fs-4  mb-2 text-uppercase">Go To Checkout</h1>
                
                {{-- CHECKOUT WRAPPER with sticky/scrollable layout --}}
                <div class="checkout-wrapper">
                    
                    {{-- LEFT SCROLLABLE COLUMN --}}
                    <div class="scrollable-column">
                        <div class="lableform">
                            <div class="card  border-0">
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="text-uppercase text-sm-start text-center fw-bold">
                                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                                {{ $method == 'delivery' ? 'All' : 'Pickup' }} Address
                                            </h5>
                                        </div>
                                        <hr>
                                        <input type="hidden" name="method_type"
                                            value="{{ $method == 'delivery' ? 'delivery' : 'pickup' }}">
                                        @if ($method == 'delivery')
                                            <div class="col-12">
                                                <div class="accordion" id="accordionExample">
                                                    <div class="accordion-item ">
                                                        <h2 class="accordion-header" id="headingOne">
                                                            <button class="accordion-button text-white fs-1 fw-bold"
                                                                style="background:gray;" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                                aria-controls="collapseOne">
                                                                Choose Your Delivery Address From Saved Address
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOne" class="accordion-collapse collapse "
                                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body px-0">
                                                                <div class="row">
                                                                    @if (isset($oldAddresses))
                                                                        @forelse ($oldAddresses as $oldAddress)
                                                                            <div class="col-md-6 d-flex align-items-center">
                                                                                <label class="address-card card position-relative w-100">
                                                                                    <input type="radio" name="old_address"
                                                                                        class="card-input old_address"
                                                                                        value="{{ $oldAddress->id }}"
                                                                                        data-street="{{ $oldAddress->street ?? '' }}"
                                                                                        data-house-number="{{ $oldAddress->house_no ?? '' }}"
                                                                                        data-postal-code="{{ $oldAddress->postal_code ?? '' }}"
                                                                                        data-city="{{ $oldAddress->city ?? '' }}"
                                                                                        data-floor="{{ $oldAddress->floor ?? '' }}"
                                                                                        data-latitude="{{ $oldAddress->latitude ?? '' }}"
                                                                                        data-longitude="{{ $oldAddress->longitude ?? '' }}"
                                                                                        data-company-name="{{ $oldAddress->company_name ?? '' }}">
                                                                                    <div class="card-body  p-2 w-100 ">
                                                                                        <p class="card-text fw-bold"
                                                                                            style="word-break:break-all !important;">
                                                                                            {{ isset($oldAddress->street) && $oldAddress->street != '' ? $oldAddress->street : '' }}
                                                                                            {{ isset($oldAddress->house_no) && $oldAddress->house_no != '' ? $oldAddress->house_no : '' }}
                                                                                            {{ isset($oldAddress->floor) && $oldAddress->floor != '' ? ', ' . $oldAddress->floor . ' Floor' : '' }}
                                                                                            {{ isset($oldAddress->postal_code) && $oldAddress->postal_code != '' ? ', ' . $oldAddress->postal_code : '' }}
                                                                                            {{ isset($oldAddress->city) && $oldAddress->city != '' ? $oldAddress->city : '' }}
                                                                                            {{ isset($oldAddress->company_name) && $oldAddress->company_name != '' ? ', ' . $oldAddress->company_name : '' }}
                                                                                        </p>
                                                                                    </div>
                                                                                </label>
                                                                                <div class="text-start" style="margin-left:10px;">
                                                                                    <i style="cursor:pointer;"
                                                                                        class="fa-solid fa-trash text-danger text-start  delete-address"
                                                                                        data-id="{{ $oldAddress->id }}"
                                                                                        title="Delete Address"></i>
                                                                                </div>
                                                                            </div>
                                                                        @empty
                                                                            <h5 class="fw-semibold text-center">Your Saved Address
                                                                                not found!</h5>
                                                                        @endforelse
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php
                                                    $userLat = session('latitude');
                                                    $userLng = session('longitude');
                                                @endphp

                                                <div class="row mt-2">
                                                    <div class="home-search-form col-12 position-relative  mb-4">
                                                        <h5 class="fw-bold">Your Delivery Address</h5>
                                                        <div class="input-group position-relative rounded-pill">
                                                            <input type="text" class="form-control home-search-input fw-bold py-3"
                                                                style="padding-left:1rem !important; -webkit-appearance: textfield;height:56px !important;font-size:1.4rem;color:#000 !important;"
                                                                placeholder="Please give your postcode, city or area name."
                                                                id="place-input" name="location" autocomplete="off" />
                                                            <i class="fa-solid fa-times clear-input-icon position-absolute justify-content-center align-items-center  rounded-circle"
                                                                style="right: 49px; top: 50%; transform: translateY(-50%); cursor: pointer; display: none; z-index: 10; color: #000; border:1px solid red;height:25px !important; width:25px !important"></i>
                                                            <button class="btn btn-primary home-search-button text-white disabled"
                                                                disabled id="search-loc"> <i
                                                                    class="fa-solid fa-location-dot"></i></button>
                                                        </div>
                                                        <div class="text-center position-relative mt-2 card py-1 rounded-pill">
                                                            <span id="getMyAddress"
                                                                style="cursor:pointer; color:red; font-size:1.4rem;">
                                                                <i class="fa-solid fa-location-crosshairs mx-2 "></i> Click here get
                                                                current location
                                                            </span>
                                                        </div>
                                                        <div id="autocomplete-suggestions" class="autocomplete-suggestions"></div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="street" class="fw-bold">Street <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" id="street" name="street"
                                                                class="form-control form-control-lg" value="{{session('street')}}"
                                                                placeholder="Street" readonly>
                                                            @error('street')
                                                                <small class="text-danger">{{$message}}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="house_number" class="fw-bold">House Number</label>
                                                            <input type="text" id="house_number" name="house_number"
                                                                class="form-control form-control-lg" placeholder="House Number"
                                                                value="{{session('street_number') ?? null}}" required>
                                                            @error('house_number')
                                                                <small class="text-danger">{{$message}}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="postal_code" class="fw-bold">Postal Code <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" id="postal_code" name="postal_code"
                                                                class="form-control form-control-lg" placeholder="Postal code"
                                                                value="{{session('postcode')}}" readonly>
                                                            <input type="hidden" id="latitude" name="latitude"
                                                                value="{{session('latitude')}}" readonly>
                                                            <input type="hidden" id="longitude" name="longitude"
                                                                value="{{session('longitude')}}" readonly>
                                                            @error('postal_code')
                                                                <small class="text-danger">{{$message}}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="city" class="fw-bold">City <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" id="city" name="city"
                                                                class="form-control form-control-lg" placeholder="City"
                                                                value="{{session('city')}}" readonly>
                                                            @error('city')
                                                                <small class="text-danger">{{$message}}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="city_district" class="fw-bold">City District </label>
                                                            <input type="text" id="city_district" name="city_district"
                                                                class="form-control form-control-lg" value="{{session('sublocality')}}"
                                                                placeholder="City District.." readonly>
                                                            @error('city_district')
                                                                <small class="text-danger">{{$message}}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="floor" class="fw-bold">Building storey <span
                                                                    class="text-danger">*</span></label>
                                                            <select id="floor" name="building_storey" class="my-select" required>
                                                                <option value="" disabled selected>Select building storey</option>
                                                                <option value="Basement floor">Basement floor</option>
                                                                <option value="Ground floor">Ground floor</option>
                                                                @for ($i = 1; $i <= 20; $i++)
                                                                    <option value="{{ $i }} Floor">{{ $i }}: Floor</option>
                                                                @endfor
                                                            </select>
                                                            @error('building_storey')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="company_name" class="fw-bold">Company name (Optional)</label>
                                                            <input type="text" id="company_name" name="company_name"
                                                                class="form-control form-control-lg" placeholder="Company name">
                                                            @error('company_name')
                                                                <small class="text-danger">{{$message}}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="phone" class="fw-bold">Please select your delivery/pickup
                                                                time</label>
                                                            <div class="input-group flex-nowrap">
                                                                <span class="input-group-text px-2">
                                                                    <i class="fa-regular text-primary fs-3 fa-clock"></i>
                                                                </span>
                                                                <select name="custome_time" id="seachable-select" class=" my-select">
                                                                    <option value="As soon as possible">As soon as possible</option>
                                                                    @foreach ($slots as $slot)
                                                                        <option value="{{ $slot }}">
                                                                            {{ date('h:i A', strtotime($slot)) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-check mb-3">
                                                            <input type="checkbox" class="form-check-input" id="save_details_next"
                                                                name="save_details_next">
                                                            <label for="save_details_next" class="form-check-label fw-bold">Do you want
                                                                to save this address?</label>
                                                        </div>
                                                        @error('save_details_next')
                                                            <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-12 mb-3">
                                                <div class="card shadow border-0">
                                                    <div class="card-body">
                                                        <h5 class="fs-2 fw-bold">Here You Can Pickup Your Order.</h5>
                                                        <h6 class="mt-3 fs-1"><strong><i class="fas fa-map-marker-alt me-2"></i>
                                                                Address:</strong></h6>
                                                        <h6 class="mt-3 fs-1"><strong><i
                                                                    class="fa-solid fa-shop me-2"></i>{{$vendor->name}}</strong></h6>
                                                        <p class="mb-1 fs-1">
                                                            @isset($restDetails)
                                                                {{ $restDetails->company_street ?? 'Street not available' }},
                                                                <br />
                                                                {{ $restDetails->company_zipcode ?? 'Zipcode not available' }}
                                                                {{ $restDetails->company_city ?? 'City not available' }},
                                                                <br />
                                                                {{ $restDetails->company_state ?? '' }}
                                                            @else
                                                                Address not available
                                                            @endisset
                                                        </p>
                                                        <h6 class="mt-3 fs-1"><strong><i class="fas fa-tty me-2"></i> Contact
                                                                Information:</strong></h6>
                                                        <p class="mb-1 fs-1">
                                                            @isset($vendor->phone)
                                                                <i class="fas fa-phone-alt me-2"></i> Phone: {{ $vendor->phone }}
                                                            @else
                                                                Phone number not available
                                                            @endisset
                                                        </p>
                                                        <p class="mb-1 fs-1">
                                                            @isset($vendor->email)
                                                                <i class="fas fa-envelope me-2"></i> Email: {{ $vendor->email }}
                                                            @else
                                                                Email not available
                                                            @endisset
                                                        </p>
                                                        <p class="mb-1 fs-1">
                                                            <i class="fas fa-globe me-2"></i> Url: <a class="text-primary"
                                                                target="_blank"
                                                                href="{{$restDetails->shop_url}}">{{$restDetails->shop_url}}</a>
                                                        </p>
                                                    </div>
                                                    <div class="card-body">
                                                        <iframe
                                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7005.14247513045!2d77.39483454999998!3d28.6126369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cef9166ea02d7%3A0x9a32f1a301ccc430!2sSector%2069%2C%20Noida%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1708586070667!5m2!1sen!2sin"
                                                            style="border: 0; width: 100%; height: 15rem" allowfullscreen=""
                                                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                                            id="mapFrame"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="note" class="fw-bold">Note</label>
                                                <textarea id="note" name="note" rows="1" class="form-control form-control-lg"
                                                    placeholder="Note"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 my-3">
                                            <h5 class="text-uppercase fw-bold">Personal Details</h5>
                                            <hr>
                                        </div>
                                        @php
                                            $name = explode(' ', $user->name);
                                        @endphp
                                        <div class="col-md-6 mb-3">
                                            <label for="first_name" class="fw-bold">First Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="first_name" name="first_name"
                                                class="form-control form-control-lg" placeholder="First Name"
                                                value="{{ isset($name[0]) ? $name[0] : '' }}">
                                            @error('first_name')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="last_name" class="fw-bold">Last Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="last_name" name="last_name" class="form-control form-control-lg"
                                                placeholder="Last Name" value="{{ old('last_name', $name[2] ?? '') }}">
                                            @error('last_name')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="fw-bold">Email Address <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" id="email" name="email" class="form-control form-control-lg"
                                                placeholder="Email" value="{{ isset($user->email) ? $user->email : '' }}">
                                            @error('email')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="fw-bold">Phone Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="tel" id="phone" name="phone" class="form-control form-control-lg"
                                                placeholder="Phone" value="{{ isset($user->phone) ? $user->phone : '' }}">
                                            @error('phone')
                                                <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <h5 class="fw-bold text-uppercase mb-4">Select your payment method</h5>
                                            <input type="hidden" name="del_price" value="{{ $extraCost1 }}">
                                            <div
                                                class="payment-methods d-flex flex-wrap justify-content-center justify-content-md-start gap-3">
                                                <label class="payment-card" for="paypal">
                                                    <input checked type="radio" name="paymentMethod" id="paypal" value="paypal">
                                                    <div class="card-content  shadow-sm">
                                                        <div class="checkmark">
                                                            <svg viewBox="0 0 24 24">
                                                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                                            </svg>
                                                        </div>
                                                        <img src="{{ asset('uploads/logo/paypal.png') }}" alt="paypal-payment">
                                                        <span>PayPal</span>
                                                    </div>
                                                </label>
                                                <label class="payment-card" for="cash">
                                                    <input type="radio" name="paymentMethod" id="cash" value="cash">
                                                    <div class="card-content shadow-sm">
                                                        <div class="checkmark">
                                                            <svg viewBox="0 0 24 24">
                                                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                                            </svg>
                                                        </div>
                                                        <img src="{{ asset('uploads/money.png') }}" alt="Cash">
                                                        <span>Cash Payment</span>
                                                    </div>
                                                </label>
                                                <label class="payment-card" for="debit_card_at_home">
                                                    <input type="radio" name="paymentMethod" id="debit_card_at_home"
                                                        value="card_payment">
                                                    <div class="card-content shadow-sm">
                                                        <div class="checkmark">
                                                            <svg viewBox="0 0 24 24">
                                                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                                            </svg>
                                                        </div>
                                                        <img src="{{ asset('uploads/pos-terminal.png') }}" alt="debit_card_at_home">
                                                        <span class="text-center">Debit Card at home</span>
                                                    </div>
                                                </label>
                                                <label class="payment-card" for="stripe">
                                                    <input type="radio" name="paymentMethod" id="stripe" value="stripe">
                                                    <div class="card-content shadow-sm">
                                                        <div class="checkmark">
                                                            <svg viewBox="0 0 24 24">
                                                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                                            </svg>
                                                        </div>
                                                        <div
                                                            style="width:60px;height:40px;display:flex;align-items:center;justify-content:center;margin-right:10px;">
                                                            <img src="{{ asset('stripe.png') }}" alt="stripe">
                                                        </div>
                                                        <span class="ms-1">Stripe</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END LEFT SCROLLABLE COLUMN --}}

                    {{-- RIGHT STICKY COLUMN --}}
                    <div class="sticky-column">
                        <div class="card border-0">
                            <div class="card-body">
                                <h5 class="fw-bold text-uppercase">Order Details</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-12 px-0 mb-3">
                                        <ul class="list px-0 mx-0">
                                            @php
                                                $totalPrice = 0;
                                            @endphp
                                            @foreach ($carts as $cart)
                                                @php
                                                    $totalPrice += $cart->total_price;
                                                    if ($cart->food == null) {
                                                        $foodName = $cart->food_item->food_item_name;
                                                    } else {
                                                        $foodName = $cart->food->name;
                                                    }
                                                    $variantName = isset($cart->variant->variant_item->name)
                                                        ? $cart->variant->variant_item->name
                                                        : '';
                                                @endphp
                                                <li class="w-100">
                                                    <div class="d-flex flex-column w-100">
                                                        <div class="d-flex justify-content-between w-100  align-items-center">
                                                            <h6 class="mb-0 " style="font-size:16px;">{{ $cart->quantity }} <span
                                                                    class="text-muted">x</span> {{ $foodName }} :
                                                                {{ $variantName }}
                                                            </h6>
                                                            <span class="fw-bold"
                                                                style="white-space: nowrap;">{{ number_format($cart->total_price, 2) }}€</span>
                                                        </div>

                                                        @php
                                                            $extrasOrder = json_decode($cart->extras, true);
                                                            if (!is_array($extrasOrder)) {
                                                                $extrasOrder = [];
                                                            }
                                                            $sortedItems = collect($extrasOrder)->map(function ($extraId) use ($cart) {
                                                                return collect($cart->collection_items)->firstWhere('id', $extraId);
                                                            })->filter();
                                                        @endphp

                                                        <ul id="combinedItems_{{ $loop->index }}" class="px-0 mx-0"
                                                            style="list-style:none;">
                                                            @foreach ($sortedItems as $index => $item)
                                                                <li class="{{ $index >= 2 ? 'extra-item' : '' }}">
                                                                    + {{ $item->sub_items->name }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        @if ($sortedItems->count() > 2)
                                                            <a class="text-primary fw-bold" id="showMoreBtn_{{ $loop->index }}"
                                                                onclick="toggleItems('combinedItems_{{ $loop->index }}', 'showMoreBtn_{{ $loop->index }}')"
                                                                data-state="collapsed" style="cursor:pointer;font-size:15px;">+ Show
                                                                More</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <input type="hidden" name="cart[]" value="{{ $cart->id }}">
                                            @endforeach
                                            <hr>
                                            <li class="fw-bold"><strong>Sub Total </strong>
                                                <span>{{ number_format($totalPrice, 2) }}€</span>
                                            </li>
                                            @if($totalDiscount > 0)
                                                <li class="fw-bold"><strong>Discount </strong> <span
                                                        class="text-success">-{{ number_format($totalDiscount, 2) }}€</span>
                                                </li>
                                            @endif
                                            <li class="fw-bold"><strong>
                                                    @if (isset($method) && $method == 'delivery')
                                                        Delivery Charge
                                                    @else
                                                        Pickup Charge
                                                    @endif
                                                </strong>
                                                @if($isNotDeliverable)
                                                    <span class="text-danger">Delivery not available</span>
                                                @else
                                                    <span>{{ $extraCost1 == 0 ? 'Free' : number_format($extraCost1, 2) . '€' }}</span>
                                                @endif
                                            </li>
                                            <li class="fw-bold"><strong>Total Price </strong>
                                                <span>{{ number_format($totalPrice + $extraCost1 - $totalDiscount, 2) }}€</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-12 ">
                                        <div class="d-flex align-items-center ">
                                            <input type="checkbox" name="accept_terms_condition" id="accept_terms_condition">
                                            <label for="accept_terms_condition" class="ms-2 mb-0">I accept the terms &
                                                conditions and privacy policy.</label>
                                        </div>
                                        @error('accept_terms_condition')
                                            <small class="text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                    @if (isset($isReady) && !$isNotDeliverable)
                                        <div class="col-12 mt-2">
                                            <button type="submit" class="btn btn-primary fw-bold w-100">Order Now
                                                {{ number_format($totalAmount + $extraCost1 - $totalDiscount, 2) }}€</button>
                                        </div>
                                        <p class="text-dark text-center">Secure Payment With PayPal</p>
                                    @else
                                        <span class="text-danger w-100 text-center btn btn-light disabled fw-bold">Delivery not
                                            available</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END RIGHT STICKY COLUMN --}}
                </div>
                {{-- END CHECKOUT WRAPPER --}}
            </form>
        </div>
    </section>

    @if($method != 'delivery')
        <script>
            var country = "{{ $restDetails->country }}";
            var state = "{{ $restDetails->company_state }}";
            var city = "{{ $restDetails->company_city }}";
            var zipcode = "{{ $restDetails->company_zipcode }}";
            var street = "{{ $restDetails->company_street }}";

            var locationx = `${street} ${city}, ${state}, ${country}, ${zipcode}`;
            var source_src =
                `https://www.google.com/maps/embed/v1/place?key=AIzaSyAonK15hotzDslX4ePjIbmizRii-7Ng4QE&q=${encodeURIComponent(locationx)}`;
            document.getElementById('mapFrame').src = source_src;
        </script>
    @endif
@endsection

@section('external-js')
    <script>
        // Removed visibilitychange reload script as it caused the page to refresh 
        // on iOS when selecting inputs or payment options.
    </script>

    <script>
        function toggleItems(listId, btnId) {
            const listItems = document.querySelectorAll(`#${listId} .extra-item`);
            const button = document.getElementById(btnId);
            const isCollapsed = button.getAttribute('data-state') === 'collapsed';

            listItems.forEach(item => {
                item.style.display = isCollapsed ? 'list-item' : 'none';
            });

            if (isCollapsed) {
                button.innerText = "- Show Less";
                button.setAttribute('data-state', 'expanded');
            } else {
                button.innerText = "+ Show More";
                button.setAttribute('data-state', 'collapsed');
            }
        }
    </script>

    <script>
        $(document).ready(function () {

            $('.delete-address').on('click', function () {
                const addressId = $(this).data('id');
                const card = $(this).closest('.col-md-4');

                if (confirm('Are you sure you want to delete this address?')) {
                    var urlDelete = "{{url('old-address/')}}/";
                    $.ajax({
                        url: `${urlDelete + addressId}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}"
                        },
                        success: function (response) {
                            if (response.success) {
                                card.remove();
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                            alert('An error occurred while deleting the address. Please try again.');
                        }
                    });
                }
            });
        });

    </script>
    <script>
        const searchButton = document.getElementById('search-loc');
        const input = document.getElementById('place-input');
        const suggestionsBox = document.getElementById('autocomplete-suggestions');
        function saveLocationToLocalStorage(locationData) {
            localStorage.setItem('location', JSON.stringify(locationData));
        }

        function validatePostCode(locationData) {
            searchButton.disabled = true;
            searchButton.classList.add('disabled');
            searchButton.classList.add('btn-primary');
            searchButton.classList.remove('btn-success');

            $.ajax({
                url: '{{ route("check.rest.location") }}',
                method: 'POST',
                data: {
                    city: locationData?.city,
                    sublocality: locationData?.sublocality,
                    street: locationData?.street,
                    street_number: locationData?.streetNumber,
                    state: locationData?.state,
                    postcode: locationData?.postalCode,
                    latitude: locationData?.latitude,
                    longitude: locationData?.longitude,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.status) {
                        searchButton.disabled = false;
                        searchButton.classList.remove('disabled');
                        searchButton.classList.remove('btn-primary');
                        searchButton.classList.add('btn-success');
                        localStorage.setItem("location_saved", "true");

                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else {
                        showError(response.message || 'This location is not serviceable');
                    }
                },
                error: function (err) {
                    console.error(err);
                    showError('Error validating location');
                }
            });
        }

        function showError(message) {

            if (typeof toastr !== 'undefined') {
                toastr.options = {
                    positionClass: 'toast-top-center',
                    timeOut: 20000,
                    closeButton: true,
                    extendedTimeOut: 2000,
                    tapToDismiss: false
                };
                return toastr.error(message);
            }
        }
        function initAutocomplete() {
            let autocompleteService;

            // Check if Google Maps API is loaded
            if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
                console.error('Google Maps API not loaded');
                return;
            }

            autocompleteService = new google.maps.places.AutocompleteService();
            let placesService = new google.maps.places.PlacesService(document.createElement('div'));

            // Track if user is interacting with suggestions
            let isSelectingSuggestion = false;

            // Handle both touch and mouse events
            function setupInputEvents() {
                // Show suggestions on focus
                input.addEventListener('focus', showSuggestionsIfNeeded);

                // Handle input changes with debounce
                input.addEventListener('input', debounce(handleInput, 300));

                // Handle blur carefully to avoid hiding suggestions too soon
                input.addEventListener('blur', function () {
                    if (!isSelectingSuggestion) {
                        setTimeout(() => {
                            if (!isSelectingSuggestion) {
                                suggestionsBox.style.display = 'none';
                            }
                        }, 200);
                    }
                });

                // Special handling for iOS touch devices
                if ('ontouchstart' in window) {
                    input.addEventListener('touchstart', function () {
                        this.focus();
                        showSuggestionsIfNeeded();
                    });
                }
            }

            function debounce(func, wait) {
                let timeout;
                return function () {
                    const context = this,
                        args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        func.apply(context, args);
                    }, wait);
                };
            }

            function showSuggestionsIfNeeded() {
                if (input.value.trim() && suggestionsBox.innerHTML.trim()) {
                    suggestionsBox.style.display = 'block';
                }
            }

            function handleInput() {
                const inputValue = input.value.trim();

                if (!inputValue) {
                    suggestionsBox.style.display = 'none';
                    searchButton.disabled = true;
                    searchButton.classList.add('disabled');
                    searchButton.classList.add('btn-primary');
                    searchButton.classList.remove('btn-success');
                    return;
                }

                autocompleteService.getPlacePredictions({
                    input: inputValue,
                    componentRestrictions: {
                        country: 'de'
                    },
                },
                    function (predictions, status) {
                        if (status === google.maps.places.PlacesServiceStatus.OK && predictions) {
                            renderSuggestions(predictions);
                            suggestionsBox.style.display = 'block';
                        } else {
                            suggestionsBox.style.display = 'none';
                        }
                    }
                );
            }

            function renderSuggestions(predictions) {
                suggestionsBox.innerHTML = '';

                predictions.forEach(prediction => {
                    const suggestionDiv = document.createElement('div');
                    suggestionDiv.textContent = prediction.description;
                    suggestionDiv.dataset.placeId = prediction.place_id;

                    // Handle both touch and click events
                    suggestionDiv.addEventListener('mousedown', () => {
                        isSelectingSuggestion = true;
                    });

                    suggestionDiv.addEventListener('mouseup', () => {
                        selectSuggestion(prediction);
                    });

                    suggestionDiv.addEventListener('touchend', (e) => {
                        e.preventDefault();
                        selectSuggestion(prediction);
                    });

                    suggestionsBox.appendChild(suggestionDiv);
                });
            }

            function selectSuggestion(prediction) {
                suggestionsBox.style.display = 'none';
                isSelectingSuggestion = false;
                getPlaceDetails(prediction.place_id, prediction.description);
            }

            function getPlaceDetails(placeId, prediction_description) {
                placesService.getDetails({
                    placeId: placeId
                }, function (place, status) {
                    if (status === google.maps.places.PlacesServiceStatus.OK) {

                        const locationData = {
                            latitude: place.geometry.location.lat(),
                            longitude: place.geometry.location.lng(),
                            city: extractComponent(place, 'locality') || extractComponent(place, 'postal_town'),
                            sublocality: extractComponent(place, 'sublocality') || extractComponent(place,
                                'sublocality_level_1'),
                            state: extractComponent(place, 'administrative_area_level_1'),
                            country: extractComponent(place, 'country'),
                            postalCode: extractComponent(place, 'postal_code'),
                            street: extractComponent(place, 'route'),
                            streetNumber: extractComponent(place, 'street_number')
                        };

                        if (!locationData.city) {
                            input.value = input.value.trim() + "  ";
                            showError('Please enter city name.');
                            highlightInput(true);
                            return;
                        }

                        if (!locationData.postalCode) {
                            showError('Please enter postalcode.');
                            input.value = input.value.trim() + "  ";
                            highlightInput(true);
                            return;
                        }

                        input.value = prediction_description;
                        // All validations passed
                        highlightInput(false);
                        saveLocationToLocalStorage(locationData);
                        validatePostCode(locationData);
                    } else {
                        showError('Could not retrieve address details. Please try again.');
                    }
                });
            }

            function extractComponent(place, type) {
                const component = place.address_components.find(c => c.types.includes(type));
                return component ? component.long_name : '';
            }

            function highlightInput(isError) {
                // if (isError) {
                //     input.classList.add('is-invalid');
                // } else {
                //     input.classList.remove('is-invalid');
                // }
            }

            // Initialize
            setupInputEvents();
        }


        function loadGoogleMapsAPI() {
            if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
                const script = document.createElement('script');
                script.src =
                    `https://maps.googleapis.com/maps/api/js?key=AIzaSyAonK15hotzDslX4ePjIbmizRii-7Ng4QE&libraries=places&loading=async&callback=initAutocomplete`;
                script.async = true;
                script.defer = true;
                document.head.appendChild(script);
            } else {
                initAutocomplete();
            }
        }


        document.addEventListener('DOMContentLoaded', loadGoogleMapsAPI);
    </script>
    <script>
        function extractComponent(place, type) {
            const component = place.address_components.find(c => c.types.includes(type));
            return component ? component.long_name : '';
        }

        function getPlaceDetails(placeId, prediction_description) {
            const placesService = new google.maps.places.PlacesService(document.createElement('div'));

            placesService.getDetails({ placeId: placeId }, function (place, status) {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    const locationData = {
                        latitude: place.geometry.location.lat(),
                        longitude: place.geometry.location.lng(),
                        city: extractComponent(place, 'locality') || extractComponent(place, 'postal_town'),
                        sublocality: extractComponent(place, 'sublocality') || extractComponent(place, 'sublocality_level_1'),
                        state: extractComponent(place, 'administrative_area_level_1'),
                        country: extractComponent(place, 'country'),
                        postalCode: extractComponent(place, 'postal_code'),
                        street: extractComponent(place, 'route'),
                        streetNumber: extractComponent(place, 'street_number')
                    };

                    if (!locationData.city) {
                        document.getElementById('place-input').value += "  ";
                        showError('Please enter city name.');
                        return;
                    }

                    if (!locationData.postalCode) {
                        document.getElementById('place-input').value += "  ";
                        showError('Please enter postalcode.');
                        return;
                    }

                    document.getElementById('place-input').value = prediction_description;

                    saveLocationToLocalStorage(locationData);
                    validatePostCode(locationData);
                } else {
                    showError('Could not retrieve address details. Please try again.');
                }
            });
        }

        function fetchAddress(lat, lng, retries = 3) {
            const apiKey = "AIzaSyAonK15hotzDslX4ePjIbmizRii-7Ng4QE";
            const geocodeUrl = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${apiKey}`;

            $.get(geocodeUrl, function (data) {
                if (data.status === "OK" && data.results.length > 0) {
                    const placeResult = data.results[0];
                    const address = placeResult.formatted_address;
                    const placeId = placeResult.place_id;

                    const $input = $("#place-input");
                    $input.focus().val(address);

                    setTimeout(() => {
                        $input.val($input.val().slice(0, -1));
                    }, 100);

                    getPlaceDetails(placeId, address);
                } else {
                    if (retries > 0) {
                        console.warn("Retrying... attempts left:", retries);
                        setTimeout(() => fetchAddress(lat, lng, retries - 1), 1500); // wait 1.5s then retry
                    } else {
                        alert("Address not found after multiple attempts.");
                    }
                }
            }).fail(function () {
                if (retries > 0) {
                    console.warn("API call failed. Retrying... attempts left:", retries);
                    setTimeout(() => fetchAddress(lat, lng, retries - 1), 2000); // wait 2s then retry
                } else {
                    alert("Error fetching address after multiple attempts.");
                }
            });
        }

        $("#getMyAddress").on("click", function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    fetchAddress(position.coords.latitude, position.coords.longitude);
                }, function (error) {
                    const messages = {
                        1: "User denied the request for Geolocation.",
                        2: "Location information is unavailable.",
                        3: "The request to get user location timed out."
                    };
                    alert(messages[error.code] || "An unknown error occurred.");
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });

    </script>
    <script>
        $(document).ready(function () {
            // Restore selected address after refresh
            const savedAddressId = localStorage.getItem("selected_address_id");
            if (savedAddressId) {
                const $input = $(`.old_address[value="${savedAddressId}"]`);
                $input.prop("checked", true); // re-check
            }
            $(".old_address").on("click", function () {
                if ($(this).is(":checked")) {
                    // Get selected address data
                    const locationData = {
                        street: $(this).data("street"),
                        streetNumber: $(this).data("house-number"),
                        postalCode: $(this).data("postal-code"),
                        city: $(this).data("city"),
                        state: $(this).data("state"), // add state if stored
                        country: $(this).data("country"), // add country if stored
                        floor: $(this).data("floor"),
                        companyName: $(this).data("company-name"),
                        latitude: $(this).data("latitude"),
                        longitude: $(this).data("longitude")
                    };
                    localStorage.setItem("selected_address_id", $(this).val());
                    // First validate (check availability in backend)
                    $.ajax({
                        url: '{{ route("check.rest.location") }}',
                        method: 'POST',
                        data: {
                            city: locationData.city,
                            street: locationData.street,
                            street_number: locationData.streetNumber,
                            state: locationData.state,
                            postcode: locationData.postalCode,
                            latitude: locationData.latitude,
                            longitude: locationData.longitude,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            if (response.status) {
                                // ✅ Location is serviceable → set fields
                                $("#street").val(locationData.street);
                                $("#house_number").val(locationData.streetNumber);
                                $("#postal_code").val(locationData.postalCode);
                                $("#city").val(locationData.city);
                                $("#floor").val(locationData.floor);
                                $("#company_name").val(locationData.companyName);
                                $("#longitude").val(locationData.longitude);
                                $("#latitude").val(locationData.latitude);

                                // Save to local storage (optional, like Google search flow)
                                localStorage.setItem("location_saved", "true");
                                localStorage.setItem("location", JSON.stringify(locationData));

                                setTimeout(function () {
                                    location.reload();
                                }, 2000);

                            } else {
                                // ❌ Not serviceable
                                showError(response.message || "This location is not serviceable");
                                $(".old_address").prop("checked", false); // unselect
                            }
                        },
                        error: function () {
                            showError("Error validating old address");
                            $(".old_address").prop("checked", false); // unselect
                        }
                    });

                } else {
                    // If unchecked and no other radio selected → clear inputs
                    if ($(".old_address:checked").length === 0) {
                        $("#street, #house_number, #postal_code, #city, #floor, #company_name, #longitude, #latitude").val("");
                    }
                }
            });

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('place-input');
            const clearIcon = document.querySelector('.clear-input-icon');

            // Show/hide clear icon based on input
            searchInput.addEventListener('input', function () {
                clearIcon.style.display = this.value.length > 0 ? 'flex' : 'none';
            });

            // Clear input when icon is clicked
            clearIcon.addEventListener('click', function () {
                searchInput.value = '';
                clearIcon.style.display = 'none';
                searchInput.focus();
            });

            // Also check on focus in case value was changed programmatically
            searchInput.addEventListener('focus', function () {
                clearIcon.style.display = this.value.length > 0 ? 'flex' : 'none';
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let placeInput = document.getElementById("place-input");
            let sessionLocation = @json($sessionLocation);

            // If search input is empty, fill from session
            if (placeInput && !placeInput.value.trim() && sessionLocation.trim()) {
                placeInput.value = sessionLocation;
            }
        });
    </script>
@endsection