@extends('external.frame')
@section('external-css')
    <style>
        .bg-nue {
            background: #FEF3E2;
            color: #333;
            padding: 8px;
        }

        .form-control:hover,
        .form-control:focus {
            box-shadow: none !important;
        }

        .favorit {
            color: #ff0000 !important;
        }

        .review-card {
            border: 1px solid #ddd;
        }

        .review-card .rating {
            font-size: 1.5rem !important;

        }

        .custom-select-wrapper {
            position: relative;
            width: 100%;
        }

        .custom-select select {
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            background-color: #fff;
            border: 1px solid #ddd;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            font-size: 18px;
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

        .category-list-container {
            width: 100%;
            height: 65px;
            overflow-x: auto;
            white-space: nowrap;
            overflow-y: hidden;
            padding: 10px;
            box-sizing: border-box;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .category-list-container::-webkit-scrollbar {
            display: none;
            /* Safari and Chrome */
        }

        .category-list {
            display: inline-block;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .category-list li {
            display: inline-block;
            margin: 0 10px;
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

        .tabbtn {
            border-radius: 20px;
            padding: 5px 10px;
        }

        .tabbtn:hover {
            border-radius: 20px;
        }


        .star-rating {
            direction: rtl;
            display: inline-flex;
            font-size: 2rem;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #ddd;
            cursor: pointer;
            transition: color 0.3s;
        }

        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #f41909;
        }

        .filled {
            color: #f41909 !important;
        }

        /* Blurred overlay styles */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            z-index: 100001;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .loading-text {
            font-size: 1.5rem;
            color: #333;
            font-weight: bold;
        }

        body.no-scroll {
            overflow: hidden;
        }

        .status-indicate .light {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 14px;
            position: relative;
        }

        .status-indicate .red {
            background-color: red;
            animation: blink 2s infinite, wave 2s infinite;
        }

        .status-indicate .green {
            background-color: green;
            animation: blink 2s infinite, wave 2s infinite;
            animation-delay: 1s;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .3;
            }
        }

        @keyframes wave {
            0% {
                box-shadow: 0 0 0px rgba(255, 0, 0, 0.7);
            }

            50% {
                box-shadow: 0 0 30px 10px rgba(255, 0, 0, 0.3);
            }

            100% {
                box-shadow: 0 0 0px rgba(255, 0, 0, 0.7);
            }
        }

        .status-indicate .green {
            animation: blink 2s infinite, wave-green 2s infinite;
        }

        @keyframes wave-green {
            0% {
                box-shadow: 0 0 0px rgba(0, 255, 0, 0.7);
            }

            50% {
                box-shadow: 0 0 30px 10px rgba(0, 255, 0, 0.3);
            }

            100% {
                box-shadow: 0 0 0px rgba(0, 255, 0, 0.7);
            }
        }

        .form-group {
            margin-bottom: 8px !important;
        }
    </style>
@endsection
@section('external-home-content')
    <!-- Blurred Overlay -->
    <div id="loading-overlay" class="loading-overlay" style="display: none;">
        <div class="loading-text">Processing...</div>
    </div>

    <section class="py-0  bg-primary-gradient">
        <div class="container-fluid py-5 mt-4">
            <div class="row">
                <div class="col-md-8 ">
                    <div class="card my-4 shadow rounded-2 rounded-top ">
                        <div class="rest_card_img">
                            <img src="{{ isset($vendor->vendor_details->banner) ? asset('uploads/banner/' . $vendor->vendor_details->banner) : 'https://placehold.co/1200x400' }}"
                                class="img-fluid-2 rounded-2" alt="">
                            <div class="logo_block">
                                <img src="{{ isset($vendor->vendor_details->logo) ? asset('uploads/logo/' . $vendor->vendor_details->logo) : 'https://placehold.co/300x300' }}"
                                    class="img-fluid-2 rounded-2" alt="">
                            </div>
                        </div>
                        <div class="card-body mt-5">
                            <div class="row justify-content-center">
                                <div class="col-md-11 ">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h2 class="fs-1 card-title">{{ $vendor->name }}</h2>
                                            <a class="fw-bold"> <i class="fas text-danger fa-star"></i>
                                                {{ number_format($averageRating, 1) }} ({{ $ratingCount }})</a>
                                        </div>
                                        <div
                                            class="col-md-4 d-flex justify-content-end align-items-center  status-indicate">
                                            @if (isset($vendor->vendor_details->restaurant_status) && $vendor->vendor_details->restaurant_status == 1)
                                                <div title="Open" class="light green"></div>
                                            @else
                                                <div title="Close" class="light red"></div>
                                            @endif
                                            <a title="{{ $vendor->name }}" class="btn-lighter me-3">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            </a>

                                            <label for="favorite"
                                                class="d-flex justify-content-center align-items-center mb-0 btn-lighter">
                                                <i class="fa-solid fa-heart @if ($isFav) favorit @endif "
                                                    id="heart-icon" aria-hidden="true"></i>
                                                <input @checked($isFav)
                                                    onchange="isFavorite({{ $vendor->id }},event)" type="checkbox"
                                                    id="favorite" style="display:none;">
                                            </label>


                                        </div>
                                    </div>
                                    <div class="input-group d-flex justify-content-center  flex-nowrap mt-3">
                                        <span class="input-group-text px-md-3 px-1 bg-light">
                                            <i class="fa fa-percent me-2 text-primary" aria-hidden="true"></i>
                                            <span class="text-dark fw-bold"> StampCards</span>
                                        </span>

                                        <a href="" class="input-group-text bg-light">
                                            <span class="text-dark fw-semibold"> Find out more</span>
                                        </a>

                                    </div>

                                    <div class="w-100 text-center mt-2">
                                        @if (isset($vendor->table_service->status) && $vendor->table_service->status == 1)
                                            <a href="{{ route('shop.table', $vendor->unid) }}" class=" btn btn-primary">Book
                                                Your Table</a>
                                        @endif
                                    </div>


                                    <div class="text-start mt-2 d-flex justify-content-between gap-2 flex-wrap">

                                        <div>
                                            @if (isset($availability['is_delivery_open']) && $availability['is_delivery_open'])
                                                <h6 class="fs-1">Delivery Time</h6>
                                                @foreach ($availability['deliveryTimes'] as $dtime)
                                                    <div class="d-flex">
                                                        <span class="me-3"> <strong>Open :</strong>
                                                            {{ date('h:i A', strtotime($dtime->start)) }}</span>
                                                        <span> <strong>Close :</strong>
                                                            {{ date('h:i A', strtotime($dtime->end)) }}</span>
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="text-danger fw-bolder">Delivery Close</span>
                                            @endif
                                        </div>
                                        <div>
                                            @if (isset($availability['is_pickup_open']) && $availability['is_pickup_open'])
                                                <h6 class="fs-1 ">Pickup Time</h6>
                                                @foreach ($availability['pickupTimes'] as $dtime)
                                                    <div class="d-flex">
                                                        <span class="me-3"> <strong>Open :</strong>
                                                            {{ date('h:i A', strtotime($dtime->start)) }}</span>
                                                        <span> <strong>Close :</strong>
                                                            {{ date('h:i A', strtotime($dtime->end)) }}</span>
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="text-danger fw-bolder">Pickup Close</span>
                                            @endif
                                        </div>

                                    </div>


                                </div>
                            </div>
                            <div class="row mt-4 ">

                                <div class="col-12">
                                    <div class="category-list-container ">
                                        <ul class="category-list mx-0 px-0">
                                            <li>
                                                <a href="" class="btn tabbtn btn-outline-dark active">
                                                    Popular
                                                    <i class="fa fa-heart" style="color: red ; margin-left:7px"
                                                        aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            @foreach ($categories as $category)
                                                <li>
                                                    <a href="{{ route('shop.view', $vendor->unid) }}?slug={{ $category->category->slug }}"
                                                        class="btn btn-light tabbtn ">
                                                        {{ $category->category->name }}
                                                    </a>
                                                </li>
                                            @endforeach


                                        </ul>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card p-2 rounded-0 mt-2">
                        <h6 class="fs-1 fw-bold mt-2">Popular <i class="fa fa-heart" style="color: red ; margin-left:7px"
                                aria-hidden="true"></i></h6>

                        @foreach ($deals as $item)
                            <div class="card mt-3 rounded-2">
                                <div class="card-body view-food-details" data-food-id="{{ $item->id }}"
                                    data-id="{{ $item->id }}" style="cursor:pointer;">
                                    <div class="d-flex justify-content-between">
                                        <div class="food-content">
                                            <p class="fw-bold mb-0"> {{ $item->food_item_name }} <a href=""
                                                    class="mb-0">
                                                    <i style="font-size:14px;" class="fa fa-info-circle"
                                                        aria-hidden="true"></i> </a></p>
                                            <small class="text-muted">{{ $item->description }}</small>
                                            <p class="mb-0 fw-bold text-dark"> {{ $item->delivery_price }} <i
                                                    style="font-size:14px;" class="fas fa-euro-sign "></i> </p>

                                        </div>
                                        <div>
                                            <button class="add_cart view-food-details" data-food-id="{{ $item->id }}"
                                                type="button" data-id="{{ $item->id }}"
                                                style="width:35px !important; height:35px !important;">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="text-center">Read Reviews</h5>

                            <div class="reviews mt-3" style="max-height:20rem; overflow-x:scroll;">
                                @php
                                    use Carbon\Carbon;
                                @endphp
                                @foreach ($feedbacks as $feedback)
                                    <div class="review-card " style="box-shadow: none !important;">
                                        <div class="review-details">
                                            <div class="review-header">
                                                <div class="name">{{ $feedback->user->name }}</div>
                                                <div class="date">{{ $feedback->created_at->diffForHumans() }}</div>
                                            </div>
                                            <div class="rating mb-0">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $feedback->rating)
                                                        <span class="star filled">★</span>
                                                    @else
                                                        <span class="star" style="color: #999;">★</span>
                                                    @endif
                                                @endfor
                                            </div>
                                            <div class="message">
                                                {{ $feedback->content }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <h5 class="text-center py-2 mt-4">Give your feedback now</h5>
                            <form method="post" action="{{ route('shop.save.feedback') }}" class="card-body p-0">
                                @csrf
                                <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
                                <div class="star-rating">
                                    <input type="radio" id="star5" name="rating" value="5">
                                    <label for="star5">&#9733;</label>
                                    <input type="radio" id="star4" name="rating" value="4">
                                    <label for="star4">&#9733;</label>
                                    <input type="radio" id="star3" name="rating" value="3">
                                    <label for="star3">&#9733;</label>
                                    <input type="radio" id="star2" name="rating" value="2">
                                    <label for="star2">&#9733;</label>
                                    <input type="radio" id="star1" name="rating" value="1">
                                    <label for="star1">&#9733;</label>
                                </div>
                                <div class="mt-0">
                                    <textarea name="feedback" id="feedback" placeholder="Please write your feedback" rows="5"
                                        class="form-control bg-white p-2"></textarea>
                                    <small class="text-muted">Your feedback is appeared after verify by restaurants</small>
                                </div>
                                @error('feedback')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="mt-3">
                                    <button class="btn btn-primary px-4 py-1 rating-submit "
                                        type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="card h-100 rounded-0 border-0 my-4">
                        <div class="card-body mt-4">
                            <h5 class="fs-1 text-center fw-bold">Basket</h5>
                            <div class="w-100 d-flex justify-content-center">
                                <div class="switch-button">
                                    <input class="switch-button-checkbox" type="checkbox" id="toggleDeliveryPickup">
                                    <label class="switch-button-label" for="toggleDeliveryPickup">
                                        <span class="switch-button-label-span"></span>
                                    </label>
                                </div>
                            </div>

                            <div id="cartContainer" class="filter_content mt-7 text-center">
                                <i class="fa-solid fa-bag-shopping fs-2 text-center"></i>
                                <h5 class="text-center fs-1 mt-2 fw-bold">Fill your basket</h5>
                                <small class="text-center ">Your basket is empty</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <section class="pb-2">
        <div class="bg-holder"
            style="background-image:url({{ asset('pizza-client/assets/img/gallery/cta-one-bg.png') }});background-position:center;background-size:cover;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-10">
                    <div class="card card-span shadow-warning" style="border-radius: 35px;">
                        <div class="card-body py-5">
                            <div class="row justify-content-evenly">
                                <div class="col-md-3">
                                    <div
                                        class="d-flex d-md-block d-xl-flex justify-content-evenly justify-content-lg-between">
                                        <img src="{{ asset('pizza-client/assets/img/illustrations/discount.svg') }}"
                                            width="100" alt="..." />
                                        <div class="d-flex d-lg-block d-xl-flex flex-center">
                                            <h2 class="fw-bolder text-1000 mb-0 text-gradient">Daily<br
                                                    class="d-none d-md-block" />Discounts </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 hr-vertical">
                                    <div
                                        class="d-flex d-md-block d-xl-flex justify-content-evenly justify-content-lg-between">
                                        <img src="{{ asset('pizza-client/assets/img/illustrations/map.svg') }}"
                                            width="100" alt="..." />
                                        <div class="d-flex d-lg-block d-xl-flex flex-center">
                                            <h2 class="fw-bolder text-1000 mb-0 text-gradient">Live Tracking</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 hr-vertical">
                                    <div
                                        class="d-flex d-md-block d-xl-flex justify-content-evenly justify-content-lg-between">
                                        <img src="{{ asset('pizza-client/assets/img/illustrations/timer.svg') }}"
                                            width="100" alt="..." />
                                        <div class="d-flex d-lg-block d-xl-flex flex-center">
                                            <h2 class="fw-bolder text-1000 mb-0 text-gradient">Quick Delivery </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row flex-center mt-md-8">
                <div class="col-lg-5 d-none d-lg-block" style="margin-bottom: -10px;"> <img class="w-100"
                        src="{{ asset('pizza-client/assets/img/gallery/phone-cta-one.png') }}" alt="..." /></div>
                <div class="col-lg-5 mt-4 mt-md-0">
                    <h1 class="text-primary">Install the app</h1>
                    <p>It's never been easier to order food. Look for the finest <br class="d-none d-xl-block" />discounts
                        and you'll be lost in a world of delectable food.</p>
                    <div class="d-flex pt-3 pt-md-0 justify-content-md-start justify-content-between">
                        <a class="pe-2 mt-2 d-block" href="https://www.apple.com/app-store/" target="_blank">
                            <img src="{{ asset('pizza-client/assets/img/gallery/app-store.svg') }}" style="height: 3rem;"
                                width="160" alt="" />
                        </a>
                        <a href="https://play.google.com/store/apps" class="mt-2 d-block" target="_blank">
                            <img src="{{ asset('pizza-client/assets/img/gallery/google-play.svg') }}"
                                style="height: 3rem;" width="160" alt="" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for Food Item Details -->
    <div class="modal fade" id="foodModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="foodModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" id="foodModalContent" data-id="">
                <div class="modal-header">
                    <h5 class="modal-title" id="foodModalLabel">Food Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 340px; overflow-y:scroll;">
                    <!-- Food Description -->
                    <p id="foodDescription"></p>
                    <!-- Variant Selection -->
                    <div class="form-group mb-3">
                        <label for="variantSelect">Choose Variant:</label>
                        <div class="custom-select-wrapper">
                            <div class="custom-select">
                                <select id="variantSelect" class="custom-select rounded-0">

                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Toppings Selection -->
                    {{-- <div class="form-group bg-nue" id="toppingsSection">
                        <label class="fw-bold">Toppings:</label>
                        <div id="toppingsContainer"></div>
                    </div> --}}

                    <!-- Extras Selection -->
                    <div class="form-group bg-nue" id="extrasSection">
                        <label class="fw-bold">Toppings:</label>
                        <div id="extrasContainer"></div>
                    </div>

                    <!-- Supplements Selection -->
                    <div class="form-group bg-nue" id="supplementsSection">
                        <label class="fw-bold">Supplements:</label>
                        <div id="supplementsContainer"></div>
                    </div>

                    <!-- Special Requests Selection -->
                    <div class="form-group bg-nue" id="specialRequestsSection">
                        <label class="fw-bold">Special Requests:</label>
                        <div id="specialRequestsContainer"></div>
                    </div>

                    <!-- Drinks Selection -->
                    <div class="form-group bg-nue" id="aldrinksSection">
                        <label class="fw-bold">Alcoholic Drinks:</label>
                        <div id="aldrinksContainer"></div>
                    </div>
                    <div class="form-group bg-nue" id="nondrinksSection">
                        <label class="fw-bold">Non-Alcoholic Drinks:</label>
                        <div id="nondrinksContainer"></div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <!-- Quantity Controls -->
                    <div class="quantity-controls d-flex">
                        <button type="button" class="btn btn-primary rounded-0 decrease-qty ">
                            <i class="fa fa-minus"></i>
                        </button>
                        <input type="number" style="width: 50px;text-align:center;"
                            class="form-control mx-2 bg-transparent text-primary px-0 rounded-0 qty-input" value="1"
                            min="1" readonly>
                        <button type="button" class="btn btn-primary rounded-0 increase-qty ">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- Add to Cart Button -->
                    <button type="button" class="btn btn-primary add-to-cart-btn">
                        Add to Cart - <span id="totalPrice">€0.00</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for edit Food Item Details -->
    <div class="modal fade" id="editfoodModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="foodModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" id="editfoodModalContent" data-id="">
                <div class="modal-header">
                    <h5 class="modal-title" id="editfoodModalLabel">Food Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 340px; overflow-y:scroll;">
                    <small class="text-muted">Update Cart</small>
                    <!-- Food Description -->
                    <p id="editfoodDescription"></p>
                    <!-- Variant Selection -->
                    <div class="form-group mb-3">
                        <label for="variantSelect">Choose Variant:</label>
                        <div class="custom-select-wrapper">
                            <div class="custom-select">
                                <select id="editvariantSelect" class="custom-select rounded-0">

                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Toppings Selection -->
                    {{-- <div class="form-group bg-nue" id="toppingsSection">
                        <label class="fw-bold">Toppings:</label>
                        <div id="toppingsContainer"></div>
                    </div> --}}

                    <!-- Extras Selection -->
                    <div class="form-group bg-nue" id="editextrasSection">
                        <label class="fw-bold">Toppings:</label>
                        <div id="editextrasContainer"></div>
                    </div>

                    <!-- Supplements Selection -->
                    <div class="form-group bg-nue" id="editsupplementsSection">
                        <label class="fw-bold">Supplements:</label>
                        <div id="editsupplementsContainer"></div>
                    </div>

                    <!-- Special Requests Selection -->
                    <div class="form-group bg-nue" id="editspecialRequestsSection">
                        <label class="fw-bold">Special Requests:</label>
                        <div id="editspecialRequestsContainer"></div>
                    </div>

                    <!-- Drinks Selection -->
                    <div class="form-group bg-nue" id="editaldrinksSection">
                        <label class="fw-bold">Alcoholic Drinks:</label>
                        <div id="editaldrinksContainer"></div>
                    </div>
                    <div class="form-group bg-nue" id="editnondrinksSection">
                        <label class="fw-bold">Non-Alcoholic Drinks:</label>
                        <div id="editnondrinksContainer"></div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <!-- Quantity Controls -->
                    <div class="quantity-controls d-flex">
                        <button type="button" class="btn btn-primary rounded-0 edit-decrease-qty ">
                            <i class="fa fa-minus"></i>
                        </button>
                        <input type="number" style="width: 50px;text-align:center;"
                            class="form-control mx-2 bg-transparent text-primary px-0 rounded-0 edit-qty-input"
                            value="1" min="1" readonly>
                        <button type="button" class="btn btn-primary rounded-0 edit-increase-qty ">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- Add to Cart Button -->
                    <button type="button" class="btn btn-primary edit-to-cart-btn">
                        <input type="hidden" name="totalCostPay" id="totalCostPay">
                        Update Cart - <span id="edittotalPrice">€0.00</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('external-js')
    <script>
        // Global variable to track pickup/delivery status
        let isPickupSelected = false;
        let isDeliverOpen = "{{ $availability['is_delivery_open'] }}";
        let isPickOpen = "{{ $availability['is_pickup_open'] }}";

        // Checkbox change event to toggle between pickup and delivery
        $('#toggleDeliveryPickup').on('change', function() {
            isPickupSelected = this.checked;
            getCart();
        });

        function displayCartItems(cartItems, area) {
            let cartContainer = $('#cartContainer');
            let delivery_cost = 0;
            let min_order_price = 0;
            let isDeliveryMin = true;
            let min_order_price_free_delivery = 0;
            if (area != undefined && area != null && area.length != 0) {
                delivery_cost = area?.delivery_charge;
                min_order_price = area?.min_order_price;
                min_order_price_free_delivery = area?.min_order_price_free_delivery;

                if (cartItems != null && cartItems != undefined && cartItems.length != 0) {
                    var totalPrice = 0;
                    var calCaulation = '';
                    var DeliveryCost = 0;
                    var PickupCost = 0;
                    var totalPricePay = 0;
                    cartContainer.empty(); // Clear existing content

                    $.each(cartItems, function(index, item) {
                        totalPrice = parseFloat(totalPrice) + parseFloat(item.total_price);
                        var food_item = item?.food_item;
                        if (food_item?.image) {

                            var imaUrl = "{{ asset('uploads/menu/') }}/" + food_item?.image;
                        } else {
                            var imaUrl = "{{ asset('uploads/foodu.png') }}";

                        }
                        var food_variant = item?.variant;

                        var liElement = `
                         ${food_item.food_item_name} (${food_variant?.variant_name})
                         
                        `;



                        let card = `
                    <div class="card mb-2">
                        <div class="card-body d-flex justify-content-between align-items-center flex-column">
                           <div class="row ">
                              <div class="col-4 col-md-3">
                                  <img src="${imaUrl}" class="rounded-2" style="height:5rem;" />
                              </div>
                              <div class="col-8 col-md-9">
                                 <span class="mt-2 fw-bold" onclick="updateCartProduct(${item?.id})">${liElement}</span>
                                 <div style="font-size:13px;" >
                                   <strong>Extra Note:</strong> ${item?.extra_note ? item?.extra_note : "NA"}
                                  </div>
                                  <!-- Quantity Box -->
    
                            <div class="w-100 d-flex justify-content-center mt-2 align-items-center">
                                
                                <div class="mt-2 mt-md-0" style="font-size:11px;">
                                    <span class=" mb-0 text-primary">${item.total_price} €</span>/
                                    <span class="mt-2 text-success">${item.quantity} Qty</span>
                                </div>
                                <div class="qty-box d-flex align-items-center justify-content-center mt-2 mt-md-0">
                                    <button style="height:20px; width:20px;" class="btn p-0 btn-outline-dark btn-sm btn-decrease fs-3" data-id="${item.id}">-</button>
                                    <input style="height:20px !important; width:30px !important;" type="text" class="form-control text-center mx-2 p-0" value="${item.quantity}" data-id="${item.id}">
                                    <button style="height:20px; width:20px;" class="btn p-0 btn-outline-dark btn-sm btn-increase fs-3" data-id="${item.id}">+</button>
                                </div>
                            </div>
                           
                              </div>
                            </div>
                             <!-- Add Note Section -->
                            <div class="note-section w-100 mt-2">
                                <button class="btn btn-primary p-2 py-1 btn-sm add-note-btn" data-id="${item.id}">Add Note</button>
                                <div class="note-input-section" style="display:none; margin-top: 10px;">
                                    <textarea class="form-control mb-2 note-input p-2 bg-white" placeholder="Enter your note here">${item?.extra_note ? item?.extra_note : "NA"}</textarea>
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-success btn-sm save-note-btn px-2 py-1" data-id="${item.id}">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm close-note-btn px-2 py-1" data-id="${item.id}">
                                            <i class="fa-solid fa-x"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                        cartContainer.append(card);

                    });
                    // console.log(totalPrice)
                    if (totalPrice >= min_order_price_free_delivery) {
                        DeliveryCost = 0;
                    } else {
                        DeliveryCost = parseFloat(delivery_cost);
                    }

                    if (totalPrice < min_order_price) {
                        isDeliveryMin = false;
                    } else {
                        isDeliveryMin = true;
                    }
                    // Determine which total price to show based on isPickupSelected
                    totalPricePay = isPickupSelected ? (parseFloat(totalPrice)) : (
                        parseFloat(totalPrice) + parseFloat(DeliveryCost));

                    // alert(totalPricePay)
                    calCaulation = `
                    <li class="d-flex justify-content-between"><strong>Sub Total:</strong> ${totalPrice.toFixed(2)} €</li>
                    <li class="d-flex justify-content-between mt-2 ${isPickupSelected ? 'd-none' : ''}" id="deliveryPrice"><strong>Delivery Price:</strong> ${DeliveryCost.toFixed(2)} €</li>
                    <li class="d-flex justify-content-between mt-2"><strong>Total Price:</strong> ${totalPricePay.toFixed(2)} €</li>
                `;
                    // Append calculation at the end
                    var isDisable = isDeliveryMin ? '' : 'disabled';
                    var buttonCheck = true;
                    if (isPickupSelected) {
                        buttonCheck = isPickOpen;
                    } else {
                        buttonCheck = isDeliverOpen;
                    }
                    var classNone = buttonCheck ? '' : 'd-none'
                    cartContainer.append(
                        `
                <ul class="mx-0 px-0">
                    ${calCaulation}
                </ul>
                <button ${isDisable} class="btn btn-primary mt-3 w-100 rounded-1 ${classNone}" type="button" id="checkoutNowBtn">Checkout Now</button>
                <small>Minimum Order Price Must be : ${min_order_price}€</small>
                `
                    );

                    // Add Note Button Click Event
                    $('.add-note-btn').click(function() {
                        $(this).siblings('.note-input-section').toggle();
                    });

                    // Close Note Button Click Event
                    $('.close-note-btn').click(function() {
                        $(this).closest('.note-input-section').hide();
                    });

                    // Save Note Button Click Event
                    $('.save-note-btn').click(function() {
                        var itemId = $(this).data('id');
                        var noteText = $(this).closest('.note-input-section').find('.note-input').val();

                        $.ajax({
                            url: '{{ route('cart.update.note') }}',
                            method: 'POST',
                            data: {
                                cart_item_id: itemId,
                                extra_note: noteText,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                toastr.success('Note saved successfully!');
                                $(`.save-note-btn[data-id="${itemId}"]`).closest('.note-input-section')
                                    .hide();
                                getCart();
                            },
                            error: function(xhr, status, error) {
                                toastr.error('Error saving note. Please try again.');
                            }
                        });
                    });
                }
            } else {
                cartContainer.html(
                    `<p class="text-center">Please choose a location on home page!</p>`
                );
            }
        }

        $(document).on('click', '.btn-increase', function() {
            let input = $(this).siblings('input');
            let newQty = parseInt(input.val()) + 1;
            input.val(newQty);
            updateCart($(this).data('id'), newQty);
            getCart();
        });

        // Handle quantity decrease
        $(document).on('click', '.btn-decrease', function() {
            let input = $(this).siblings('input');
            let newQty = parseInt(input.val()) - 1;
            if (newQty >= 1) {
                input.val(newQty);
                updateCart($(this).data('id'), newQty);
                getCart();
            } else {
                input.val(0);
                updateCart($(this).data('id'), 0);
                location.reload();
            }
        });
        $(document).on('click', '#checkoutNowBtn', function() {
            // alert('yes');
            if (isPickupSelected) {
                var method = "pickup";
            } else {
                var method = "delivery";
            }
            // alert('Please wait. We are on development mode. Thank you!');
            window.location.href = "{{ route('checkout.now') }}/" + method;
        })

        function getCart() {
            // alert('hello')
            var location_address = localStorage.getItem('location');
            var postalCode = 0;
            if (location_address) {
                location_address = JSON.parse(location_address);
                postalCode = location_address?.postalCode;
                if (!postalCode) {
                    window.location.href = "{{ route('home') }}";
                }
            } else {
                window.location.href = "{{ route('home') }}";
            }
            $.ajax({
                url: "{{ route('cart.get') }}",
                method: "POST",
                data: {
                    postalcode: postalCode,
                    vendor_id: "{{ $vendor->id }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status) {
                        let cartItems = response.data;

                        displayCartItems(cartItems, response.area);
                    }
                },
                error: function(er) {
                    console.log(er);
                }
            });
        }

        getCart();


        function updateCart(itemId, quantity) {
            $.ajax({
                url: "{{ route('cart.update') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cart_id: itemId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.status) {
                        // console.log(response);
                        getCart();
                    }else{
                        getCart();

                    }
                }
            });
        }



        let editbasePrice = 0;
        let edittotalPrice = 0;
        let editcurrentQty = 1;
        let editextras = [];

        function updateCartProduct(cartId) {
            // alert(cartId)
            $.ajax({
                url: '{{ route('cart.get.product.detail') }}',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    cart_item_id: cartId
                },
                success: function(response) {
                    console.log(response)
                    $('#editfoodModalContent').data('id', response.food.id);
                    $('#editfoodModalLabel').text(response.food.food_item_name);
                    $('#editfoodDescription').text(response.food.description);
                    $('.edit-qty-input').val(response?.cart?.quantity);
                    editbasePrice = response.food.base_price;

                    // Store extras for later use
                    editextras = response.extras;

                    // Load variants in select
                    $('#editvariantSelect').empty();
                    $.each(response.food.variants, function(key, variant) {
                        var oldselectedVariant = (response?.cart?.variant_id == variant?.id) ?
                            'selected' : '';
                        edit_loadExtras(editextras.map(extra => {
                            extra.price = extra.prices[response?.cart?.variant_id] || extra
                                .price;
                            return extra;
                        }), response?.extraIds);
                        $('#editvariantSelect').append(
                            `<option ${oldselectedVariant} value="${variant.id}" data-price="${variant.price}">${variant.variant_name} (€${variant.price}) - ${variant.additional_details}</option>`
                        );
                    });

                    // Load extras and other data
                    edit_loadExtras(response.extras, response?.extraIds);
                    edit_toggleSectionVisibility('#editsupplementsContainer', '#editsupplementsSection',
                        response.supplements, response?.supplementIds, 'edit-supplement-checkbox');
                    edit_toggleSectionVisibility('#editspecialRequestsContainer',
                        '#editspecialRequestsSection', response.special_requests, response
                        ?.specialRequestIds,
                        'edit-special-request-checkbox');
                    edit_toggleSectionVisibility('#editaldrinksContainer', '#editaldrinksSection',
                        response.alcohols, response?.drinkIds, 'edit-drink-checkbox', true);
                    edit_toggleSectionVisibility('#editnondrinksContainer', '#editnondrinksSection',
                        response.nonalcohols, response?.drinkIds, 'edit-drink-checkbox-non', false);

                    // Initialize price display
                    editcurrentQty = response?.cart?.quantity;
                    updateTotalPrice();
                    $('#editfoodModal').modal('show');
                }
            });
        }



        // Function to toggle visibility of sections based on data
        function edit_toggleSectionVisibility(container, mainSection, items, checks, className, isDrink = false) {
            if (items && items.length > 0) {
                $(mainSection).show();
                edit_loadCheckboxItems(container, items, checks, className, isDrink);
            } else {
                $(mainSection).hide();
            }
        }

        // function to load extras based on the selected variant
        function edit_loadExtras(extras, checks) {
            $('#editextrasContainer').empty();
            edit_loadCheckboxItems('#editextrasContainer', extras, checks, 'edit-extra-checkbox');
        }

        // Function to load and show checkbox items (toppings, extras, etc.)
        function edit_loadCheckboxItems(container, items, checks, className, isDrink = false) {
            $(container).empty();
            // console.log(checks,className);
            const maxVisibleItems = 5;
            const showMoreButton =
                `<p class="show-more-btn cursor-pointer text-primary pb-0 mb-0 fs-1 mt-2">Show More</p>`;
            const showLessButton =
                `<p class="show-less-btn cursor-pointer text-primary pb-0 mb-0 fs-1 mt-2">Show Less</p>`;

            function checkValueInArray(checks, value) {
                // Check if checks is an array, not null, and not empty
                if (Array.isArray(checks) && checks !== null && checks.length > 0) {

                    if (checks.map(Number).includes(value)) {
                        return 'checked';
                    } else {
                        return '';
                    }
                } else {
                    return '';
                }
            }
            $.each(items, function(key, item) {
                let price = item.price; // Default price
                var checked = checkValueInArray(checks, item.id);

                $(container).append(`
                <div class="mb-2">
                  <div class="form-check align-items-center ${className}-item" style="display:${key < maxVisibleItems ? 'flex' : 'none'};">
                    <input ${checked} id="${className}-${key}" style="height:25px; width:25px;" class="form-check-input mt-0 me-2 rounded-0 ${className}" type="checkbox" value="${item.id}" data-price="${price}">
                    <label class="form-check-label mb-0 pb-0" for="${className}-${key}">
                        ${item.name} €<span>${price}</span>
                    </label>
                  </div>
                  <small class="${className}-info" style="display:${key < maxVisibleItems ? 'flex' : 'none'};">${item.info}</small>
                </div>
            `);
            });

            if (items.length > maxVisibleItems) {
                $(container).append(showMoreButton);

                $(container).on('click', '.show-more-btn', function() {
                    $(`.${className}-item`).slice(maxVisibleItems).show();
                    $(`.${className}-info`).slice(maxVisibleItems).show();
                    $(this).replaceWith(showLessButton);
                });

                $(container).on('click', '.show-less-btn', function() {
                    $(`.${className}-item`).slice(maxVisibleItems).hide();
                    $(`.${className}-info`).slice(maxVisibleItems).hide();
                    $(this).replaceWith(showMoreButton);
                });
            }
        }

        // Update extras prices based on selected variant
        $('#editvariantSelect').on('change', function() {
            let selectedVariant_Id = $(this).val();
            // Update extras prices for the selected variant
            // console.log(extras);
            edit_loadExtras(editextras.map(extra => {
                extra.price = extra.prices[selectedVariant_Id] || extra.price;
                return extra;
            }));
            updateTotalPrice();
        });

        // Helper function to calculate total price
        function updateTotalPrice() {
            let edittotalPrice = 0;

            // Get selected variant price
            let variantPrice = parseFloat($('#editvariantSelect option:selected').data('price')) || 0;
            edittotalPrice += variantPrice;

            // Get selected extras price
            $('#editextrasContainer input[type=checkbox]:checked').each(function() {
                edittotalPrice += parseFloat($(this).data('price'));
            });

            // Get selected supplements price
            $('#editsupplementsContainer input[type=checkbox]:checked').each(function() {
                edittotalPrice += parseFloat($(this).data('price'));
            });

            // Get selected alcoholic or non-alcoholic drink price
            let drinkPrice = parseFloat($('input[name=alcoholicDrink]:checked').data('price')) || 0;
            edittotalPrice += drinkPrice;

            let nonDrinkPrice = parseFloat($('input[name=nonAlcoholicDrink]:checked').data('price')) || 0;
            edittotalPrice += nonDrinkPrice;
            let qtyInput = $('.edit-qty-input');
            let editcurrentQty = parseInt(qtyInput.val()) || 1;

            // Update the modal's total price display
            $('#edittotalPrice').text(`€${edittotalPrice.toFixed(2)*editcurrentQty}`);
            $('#totalCostPay').val(edittotalPrice.toFixed(2) * editcurrentQty);
        }
        $('.modal-body').on('change',
            '.edit-extra-checkbox, .edit-supplement-checkbox, .edit-special-request-checkbox, .edit-drink-checkbox, .edit-drink-checkbox-non',
            function() {
                updateTotalPrice();
            });
        // Quantity controls
        $('.edit-increase-qty').click(function() {
            let qtyInput = $('.edit-qty-input');
            let editcurrentQty = parseInt(qtyInput.val()) || 1;
            qtyInput.val(editcurrentQty + 1);
            updateTotalPrice();
        });

        $('.edit-decrease-qty').click(function() {
            let qtyInput = $('.edit-qty-input');
            let editcurrentQty = parseInt(qtyInput.val()) || 1;
            if (editcurrentQty > 1) {
                qtyInput.val(editcurrentQty - 1);
            }
            updateTotalPrice();
        });

        // Add to cart functionality

        $('.modal-footer').on('click', '.edit-to-cart-btn', function() {
            let editfoodId = $('#editfoodModalContent').data('id');
            let editselectedVariantId = $('#editvariantSelect').val();
            let editselectedExtras = [];
            let editselectedSpecialRequests = [];
            let editselectedDrinks = [];
            let editselectedSupplements = [];

            $('.edit-extra-checkbox:checked').each(function() {
                editselectedExtras.push($(this).val());
            });

            $('.edit-supplement-checkbox:checked').each(function() {
                editselectedSupplements.push($(this).val());
            });
            $('.edit-special-request-checkbox:checked').each(function() {
                editselectedSpecialRequests.push($(this).val());
            });

            $('.edit-drink-checkbox:checked, .drink-checkbox-non:checked').each(function() {
                editselectedDrinks.push($(this).val());
            });
            edittotalPrice = $('#totalCostPay').val();
            let qtyInput = $('.edit-qty-input');
            let editcurrentQty = parseInt(qtyInput.val()) || 1;
            // alert(edittotalPrice)
            var dataCart = {
                _token: "{{ csrf_token() }}",
                food_id: editfoodId,
                variant_id: editselectedVariantId,
                quantity: editcurrentQty,
                extras: editselectedExtras,
                special_requests: editselectedSpecialRequests,
                suppliments: editselectedSupplements,
                drinks: editselectedDrinks,
                total_price: edittotalPrice
            };
            // console.log(dataCart);
            $.ajax({
                url: '{{ route('cart.store') }}',
                method: 'POST',
                data: dataCart,
                success: function(response) {
                    if (response.status) {
                        toastr.success('Item updated to cart successfully');
                    } else {
                        toastr.error('Sorry we could not added your item in food.');
                    }
                    getCart();
                    $('#editfoodModal').modal('hide');
                },
                error: function(err) {
                    console.error(err);
                    toastr.error('Please try again')
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function(e) {

            // default
            var els = document.querySelectorAll(".selectize");
            els.forEach(function(select) {
                NiceSelect.bind(select);
            });

            // seachable 
            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("seachable-select"), options);
        });
    </script>
    <script>
        $(document).ready(function() {
            let basePrice = 0;
            let totalPrice = 0;
            let currentQty = 1;
            let extras = []; // To store extras and update their prices

            // Function to open modal and load food details
            $('.view-food-details').on('click', function() {
                let foodId = $(this).data('id');

                var urlGet = "{{ route('getFoodDetails') }}/" + foodId;
                $.ajax({
                    url: urlGet,
                    method: 'GET',
                    success: function(response) {
                        // console.log(response);
                        // Set modal content
                        $('#foodModalContent').data('id', response.food.id);
                        $('#foodModalLabel').text(response.food.food_item_name);
                        $('#foodDescription').text(response.food.description);
                        basePrice = response.food.base_price;

                        // Store extras for later use
                        extras = response.extras;

                        // Load variants in select
                        $('#variantSelect').empty();
                        $.each(response.food.variants, function(key, variant) {
                            $('#variantSelect').append(
                                `<option value="${variant.id}" data-price="${variant.price}">${variant.variant_name} (€${variant.price}) - ${variant.additional_details}</option>`
                            );
                        });

                        // Load extras and other data
                        loadExtras(response.extras); // Call a new function for loading extras
                        toggleSectionVisibility('#supplementsContainer', '#supplementsSection',
                            response.supplements, 'supplement-checkbox');
                        toggleSectionVisibility('#specialRequestsContainer',
                            '#specialRequestsSection', response.special_requests,
                            'special-request-checkbox');
                        toggleSectionVisibility('#aldrinksContainer', '#aldrinksSection',
                            response.alcohols, 'drink-checkbox', true);
                        toggleSectionVisibility('#nondrinksContainer', '#nondrinksSection',
                            response.nonalcohols, 'drink-checkbox-non', false);

                        // Initialize price display
                        currentQty = 1;
                        updatePrice();
                        $('#foodModal').modal('show');
                    }
                });
            });

            // Function to toggle visibility of sections based on data
            function toggleSectionVisibility(container, mainSection, items, className, isDrink = false) {
                if (items && items.length > 0) {
                    $(mainSection).show();
                    loadCheckboxItems(container, items, className, isDrink);
                } else {
                    $(mainSection).hide();
                }
            }

            // function to load extras based on the selected variant
            function loadExtras(extras) {
                $('#extrasContainer').empty();
                loadCheckboxItems('#extrasContainer', extras, 'extra-checkbox');
            }

            // Function to load and show checkbox items (toppings, extras, etc.)
            function loadCheckboxItems(container, items, className, isDrink = false) {
                $(container).empty();

                const maxVisibleItems = 5;
                const showMoreButton =
                    `<p class="show-more-btn cursor-pointer text-primary pb-0 mb-0 fs-1 mt-2">Show More</p>`;
                const showLessButton =
                    `<p class="show-less-btn cursor-pointer text-primary pb-0 mb-0 fs-1 mt-2">Show Less</p>`;

                $.each(items, function(key, item) {
                    let price = item.price; // Default price

                    $(container).append(`
                <div class="mb-2">
                  <div class="form-check align-items-center ${className}-item" style="display:${key < maxVisibleItems ? 'flex' : 'none'};">
                    <input id="${className}-${key}" style="height:25px; width:25px;" class="form-check-input mt-0 me-2 rounded-0 ${className}" type="checkbox" value="${item.id}" data-price="${price}">
                    <label class="form-check-label mb-0 pb-0" for="${className}-${key}">
                        ${item.name} €<span>${price}</span>
                    </label>
                  </div>
                  <small class="${className}-info" style="display:${key < maxVisibleItems ? 'flex' : 'none'};">${item.info}</small>
                </div>
            `);
                });

                if (items.length > maxVisibleItems) {
                    $(container).append(showMoreButton);

                    $(container).on('click', '.show-more-btn', function() {
                        $(`.${className}-item`).slice(maxVisibleItems).show();
                        $(`.${className}-info`).slice(maxVisibleItems).show();
                        $(this).replaceWith(showLessButton);
                    });

                    $(container).on('click', '.show-less-btn', function() {
                        $(`.${className}-item`).slice(maxVisibleItems).hide();
                        $(`.${className}-info`).slice(maxVisibleItems).hide();
                        $(this).replaceWith(showMoreButton);
                    });
                }
            }

            // Update extras prices based on selected variant
            $('#variantSelect').on('change', function() {
                let selectedVariantId = $(this).val();
                // Update extras prices for the selected variant
                // console.log(extras);
                loadExtras(extras.map(extra => {
                    extra.price = extra.prices[selectedVariantId] || extra.price;
                    return extra;
                }));
                updatePrice();
            });

            // Function to update the price
            function updatePrice() {
                let selectedVariantPrice = parseFloat($('#variantSelect option:selected').data('price')) ||
                    basePrice;
                let extraCost = 0;

                $('.extra-checkbox:checked, .supplement-checkbox:checked, .special-request-checkbox:checked, .drink-checkbox:checked, .drink-checkbox-non:checked')
                    .each(function() {
                        extraCost += parseFloat($(this).data('price')) || 0;
                    });

                totalPrice = (selectedVariantPrice + extraCost) * currentQty;
                $('#totalPrice').text(`€${totalPrice.toFixed(2)}`);
            }

            // Update price when extras or toppings are selected
            $('.modal-body').on('change',
                '.extra-checkbox, .supplement-checkbox, .special-request-checkbox, .drink-checkbox, .drink-checkbox-non',
                function() {
                    updatePrice();
                });

            // Increase quantity
            $('.modal-footer').on('click', '.increase-qty', function() {
                currentQty++;
                $('.qty-input').val(currentQty);
                updatePrice();
               
            });

            // Decrease quantity
            $('.modal-footer').on('click', '.decrease-qty', function() {
                if (currentQty > 1) {
                    currentQty--;
                    $('.qty-input').val(currentQty);
                    updatePrice();
                }
            });

            // Add to cart functionality
            $('.modal-footer').on('click', '.add-to-cart-btn', function() {
                let foodId = $('#foodModalContent').data('id');
                let selectedVariantId = $('#variantSelect').val();
                let selectedExtras = [];
                let selectedSpecialRequests = [];
                let selectedDrinks = [];
                let selectedSupplements = [];

                $('.extra-checkbox:checked').each(function() {
                    selectedExtras.push($(this).val());
                });

                $('.supplement-checkbox:checked').each(function() {
                    selectedSupplements.push($(this).val());
                });
                $('.special-request-checkbox:checked').each(function() {
                    selectedSpecialRequests.push($(this).val());
                });

                $('.drink-checkbox:checked, .drink-checkbox-non:checked').each(function() {
                    selectedDrinks.push($(this).val());
                });
                // alert(currentQty);
                currentQty=$('.qty-input').val();
                var dataCart = {
                    _token: "{{ csrf_token() }}",
                    food_id: foodId,
                    variant_id: selectedVariantId,
                    quantity: currentQty,
                    extras: selectedExtras,
                    special_requests: selectedSpecialRequests,
                    suppliments: selectedSupplements,
                    drinks: selectedDrinks,
                    total_price: totalPrice
                };
                // console.log(dataCart);
                $.ajax({
                    url: '{{ route('cart.store') }}',
                    method: 'POST',
                    data: dataCart,
                    success: function(response) {
                        if (response.status) {
                            toastr.success('Item added to cart successfully');
                        } else {
                            toastr.error('Sorry we could not added your item in food.');
                        }
                        getCart();
                        $('#foodModal').modal('hide');
                    },
                    error: function(err) {
                        console.error(err);
                        toastr.error('Please try again')
                    }
                });
            });
        });
    </script>

    <script>
        function isFavorite(vendor_id, e) {
            var isFav = (e.target.checked === true) ? 1 : 0;

            $.ajax({
                url: '{{ route('addFavorite') }}',
                method: 'POST',
                data: {
                    vendor_id: vendor_id,
                    status: isFav,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    if (response.status) {
                        if (e.target.checked) {
                            $('#heart-icon').addClass('favorit')
                        } else {
                            $('#heart-icon').removeClass('favorit')
                        }
                        toastr.success(response.message);
                    } else {
                        toastr.info(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    $('#addcard .modal-body').html(
                        '<p>An error occurred while loading the data.</p>');
                }
            });
        }
    </script>
@endsection
