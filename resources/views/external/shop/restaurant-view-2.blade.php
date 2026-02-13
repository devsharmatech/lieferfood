@extends('external.frame')
@section('external-css')
    <style>
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
                        {{-- @foreach ($items as $item)
                            <div class="card mt-3 rounded-2">
                                <div class="card-body ">
                                    <div class="d-flex justify-content-between">
                                        <div class="food-content">
                                            <p class="fw-bold mb-0"> {{ $item->food_item_name }} <a href=""
                                                    class="mb-0"> <i style="font-size:14px;" class="fa fa-info-circle"
                                                        aria-hidden="true"></i> </a></p>
                                            <small class="text-muted">{{ $item->description }}</small>
                                            <p class="mb-0 fw-bold text-dark"> {{ $item->price }} <i
                                                    style="font-size:14px;" class="fas fa-euro-sign    "></i> </p>

                                        </div>
                                        <div>
                                            <button class="add_cart" type="button" data-id="{{ $item->id }}"
                                                style="width:35px !important; height:35px !important;">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <h5 class="mt-3">Food Deals</h5> --}}
                        @foreach ($deals as $item)
                            <div class="card mt-3 rounded-2">
                                <div class="card-body open-modal" data-food-id="{{ $item->id }}"
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
                                            <button class="add_cart open-modal" data-food-id="{{ $item->id }}"
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







    <!-- Modal Structure -->
    <div class="modal fade" id="foodModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="foodModalLabel">Food Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalContent" style="max-height: 300px; overflow-y:scroll;"></div>
                </div>
                <!-- Modal Footer Structure -->
                <div class="modal-footer">
                    <div class="qty-box">
                        <button type="button" id="decrease-quantity">
                            <i class="fa fa-minus"></i>
                        </button>

                        <input type="number" class="mx-2 text-center" id="global-quantity" value="1"
                            min="1" readonly>
                        <button type="button" id="increase-quantity">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-primary ms-auto" id="addToCartBtn">Add to Cart (€0.00)</button>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('external-js')
    <script>
        // Global variable to track pickup/delivery status
        let isPickupSelected = false;

        // Checkbox change event to toggle between pickup and delivery
        $('#toggleDeliveryPickup').on('change', function() {
            isPickupSelected = this.checked;
            getCart();
        });

        function displayCartItems(cartItems) {
            if (cartItems != null && cartItems != undefined && cartItems.length != 0) {
                let cartContainer = $('#cartContainer');
                var totalPrice = 0;
                var calCaulation = '';
                var DeliveryCost = 0;
                var PickupCost = 0;
                cartContainer.empty(); // Clear existing content

                $.each(cartItems, function(index, item) {
                    totalPrice = parseFloat(totalPrice) + parseFloat(item.total_price);
                    var selectedItems = JSON.parse(item?.selected_items);

                    if (!Array.isArray(selectedItems)) {
                        selectedItems = [];
                    }

                    var liElement = '';

                    selectedItems.forEach(function(foodItem) {
                        if (foodItem.variant !== 0 && foodItem.variant !== '0' && foodItem.variant !== "") {
                            liElement +=
                                `<li style="font-size:13px;">${foodItem.food_name} (${foodItem.variant}) - €${foodItem.variant_price} X ${item.quantity} Qty</li>`;
                            DeliveryCost += parseFloat(foodItem.delivery_price);
                            PickupCost += parseFloat(foodItem.pickup_price);
                            if (foodItem.extras != null && foodItem.extras.length > 0) {
                                var ulmt = '<ul class="text-start mb-2">';
                                foodItem.extras.forEach(function(extraItem) {
                                    ulmt +=
                                        `<li style="font-size:13px;" class="text-capitalize">${extraItem.extra_name} - €${extraItem.extra_price} X ${item.quantity} Qty</li>`;
                                });
                                ulmt += '</ul>';
                                liElement += ulmt;
                            }
                        }
                    });

                    // Determine which total price to show based on isPickupSelected
                    var totalPricePay = isPickupSelected ? (parseFloat(totalPrice) + parseFloat(PickupCost)) : (
                        parseFloat(totalPrice) + parseFloat(DeliveryCost));

                    calCaulation = `
                <li class="d-flex justify-content-between"><strong>Sub Total:</strong> ${totalPrice.toFixed(2)} €</li>
                <li class="d-flex justify-content-between mt-2 ${isPickupSelected ? 'd-none' : ''}" id="deliveryPrice"><strong>Delivery Price:</strong> ${DeliveryCost.toFixed(2)} €</li>
                <li class="d-flex justify-content-between mt-2 ${isPickupSelected ? '' : 'd-none'}" id="pickupPrice"><strong>Pickup Price:</strong> ${PickupCost.toFixed(2)} €</li>
                <li class="d-flex justify-content-between mt-2"><strong>Total Price:</strong> ${totalPricePay.toFixed(2)} €</li>
            `;

                    var nameFood = item.food ? item?.food?.name : item?.food_item?.food_item_name;

                    let card = `
                <div class="card mb-2">
                    <div class="card-body d-flex justify-content-between align-items-center flex-column">
                        <span class="mt-2 fw-bold">${nameFood}</span>
                        <ol class="mb-0 pb-0">${liElement}</ol>

                        <div style="font-size:13px;" class="mb-3">
                            <strong>Extra Note:</strong> ${item?.extra_note ? item?.extra_note : "NA"}
                        </div>

                        <!-- Add Note Section -->
                        <div class="note-section w-100">
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

                        <!-- Quantity Box -->
                        <div class="w-100 d-flex justify-content-between align-items-center">
                            <div class="mt-2">
                                <span class=" mb-0 text-primary">${item.total_price} €</span>/
                                <span class="mt-2 text-success">${item.quantity} Qty</span>
                            </div>
                            <div class="qty-box d-flex align-items-center justify-content-center mt-2">
                                <button style="height:30px; width:30px;" class="btn p-0 btn-outline-dark btn-sm btn-decrease fs-3" data-id="${item.id}">-</button>
                                <input style="height:30px; width:30px;" type="text" class="form-control text-center mx-2 p-0" value="${item.quantity}" data-id="${item.id}">
                                <button style="height:30px; width:30px;" class="btn p-0 btn-outline-dark btn-sm btn-increase fs-3" data-id="${item.id}">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                    cartContainer.append(card);
                });

                // Append calculation at the end
                cartContainer.append(`
            <ul class="mx-0 px-0">
                ${calCaulation}
            </ul>
            <button class="btn btn-primary mt-3 w-100 rounded-1" type="button" id="checkoutNowBtn">Checkout Now</button>
        `);

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
                        },
                        error: function(xhr, status, error) {
                            toastr.error('Error saving note. Please try again.');
                        }
                    });
                });
            }
        }



        $(document).on('click', '.btn-increase', function() {
            let input = $(this).siblings('input');
            let newQty = parseInt(input.val()) + 1;
            input.val(newQty);
            updateCart($(this).data('id'), newQty);
        });

        // Handle quantity decrease
        $(document).on('click', '.btn-decrease', function() {
            let input = $(this).siblings('input');
            let newQty = parseInt(input.val()) - 1;
            if (newQty >= 1) {
                input.val(newQty);
                updateCart($(this).data('id'), newQty);
            } else {
                input.val(0);
                updateCart($(this).data('id'), 0);
            }
        });
        $(document).on('click', '#checkoutNowBtn', function() {
            // alert('yes');
            if (isPickupSelected) {
                var method = "pickup";
            } else {
                var method = "delivery";
            }
            window.location.href = "{{ route('checkout.now') }}/"+method;
        })

        function getCart() {
            // alert('hello')
            $.ajax({
                url: "{{ route('cart.get') }}",
                method: "POST",
                data: {
                    vendor_id: "{{ $vendor->id }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status) {
                        let cartItems = response.data;
                        displayCartItems(cartItems);
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
                    }
                }
            });
        }
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
        let cartSelections = {};
        let globalQuantity = 1;

        $(document).on('click', '#decrease-quantity', function() {
            if (globalQuantity > 1) {
                globalQuantity--;
                $('#global-quantity').val(globalQuantity);
                recalculateTotalPrices();
            }
        });

        $(document).on('click', '#increase-quantity', function() {
            globalQuantity++;
            $('#global-quantity').val(globalQuantity);
            recalculateTotalPrices();
        });

        $(document).on('change', '.variant-select, .extra-checkbox', function() {
            recalculateTotalPrices();
        });


        $('#global-quantity').on('change', function() {
            globalQuantity = parseInt($(this).val());
            if (globalQuantity < 1) globalQuantity = 1; // Minimum quantity is 1
            recalculateTotalPrices();
        });

        function recalculateTotalPrices() {
            let totalOrderPrice = 0;

            $('.food-item').each(function() {
                let basePrice = parseFloat($(this).find('.variant-select').data('base-price')) || 0;
                let variantPrice = parseFloat($(this).find('.variant-select').val()) || basePrice;
                let extraPrice = 0;

                // Calculate extra prices
                $(this).find('.extra-checkbox:checked').each(function() {
                    extraPrice += parseFloat($(this).data('extra-price'));
                });

                let totalPrice = (variantPrice + extraPrice) * globalQuantity;
                $(this).find('.total-price').text(totalPrice.toFixed(2));

                totalOrderPrice += totalPrice;

                let foodId = $(this).find('.variant-select').data('food-id');
                let variantId = $(this).find('.variant-select option:selected').data('variant-id');
                if (!cartSelections[foodId]) {
                    cartSelections[foodId] = {};
                }
                cartSelections[foodId].quantity = globalQuantity;
                cartSelections[foodId].price = totalPrice;
                cartSelections[foodId].variantId = variantId;
                cartSelections[foodId].extras = $(this).find('.extra-checkbox:checked').map(function() {
                    return $(this).data('extra-id');
                }).get();
                // console.log(cartSelections);
            });

            $('#addToCartBtn').text(`Add to Cart (€${totalOrderPrice.toFixed(2)})`);
        }



        $(document).ready(function() {

            $('.open-modal').on('click', function() {
                let foodId = $(this).data('food-id');
                $('#modalContent').html('');
                var urlGet = "{{ route('getFoodDetails') }}/" + foodId;

                $.ajax({
                    url: urlGet,
                    method: 'GET',
                    success: function(response) {
                        // console.log(response);
                        let modalContent = '';

                        if (response.collection) {
                            modalContent += `<h5>${response.collection.name}</h5>`;
                            modalContent += `<small>${response.collection.description}</small>`;
                            modalContent +=
                                `<input type="hidden" id="collectionid" value="${response.collection.id}"/>`;
                            response.collection.food_items.forEach(function(item) {
                                modalContent += generateFoodContent(item);
                            });
                        } else {
                            modalContent += generateFoodContent(response.food);
                        }

                        $('#modalContent').html(modalContent);

                        // Show the modal
                        $('#foodModal').modal('show');
                        recalculateTotalPrices();
                    }
                });
            });

            function generateFoodContent(food) {
                let content = `<div class="food-item mb-3">`;
                content += `<h5>${food.food_item_name}</h5>`;
                content += `<p>Base Price: ${food.delivery_price}€</p>`;

                // If variants exist
                if (food.variants.length > 0) {
                    content += `<div class="form-group mb-3">
                        <label class="form-label">Select Variant:</label>`;
                    content += `<select class="form-control form-select px-2 bg-white variant-select" data-food-id="${food.id}" data-base-price="0">
                        <option value="0" selected data-variant-id="">Please select</option>`;

                    food.variants.forEach(function(variant) {
                        content +=
                            `<option value="${variant.price}" data-variant-id="${variant.id}">${variant.variant_name} - ${variant.price}€</option>`;
                    });

                    content += `</select></div>`;
                } else {
                    content += `<div class="mb-2">
                     <input type="hidden" class="variant-select" data-food-id="${food.id}" data-base-price="${food.delivery_price}" />
                    </div>`;
                }

                // Extras section

                if (food.extras && food.extras.length > 0) {
                    content += `<div class="extras-section">`;
                    content += `<p class="fw-bold">Extras Toppings:</p>`;

                    // Limit to 4 items visible initially
                    food.extras.slice(0, 4).forEach(function(extra, index) {
                        content += `<div class="form-check extra-item">
                            <input class="form-check-input extra-checkbox" type="checkbox" data-extra-id="${extra.id}" data-extra-price="${extra.extra_price}" id="extra${extra.id}">
                            <label class="form-check-label text-capitalize" for="extra${extra.id}">
                                ${extra.extra_name} - ${extra.extra_price}€
                            </label>
                        </div>`;
                    });

                    // If extras are more than 4, add a Show More button
                    if (food.extras.length > 4) {
                        content += `<div class="extra-items-hidden" style="display:none;">`;
                        food.extras.slice(4).forEach(function(extra) {
                            content += `<div class="form-check extra-item">
                                <input class="form-check-input extra-checkbox" type="checkbox" data-extra-id="${extra.id}" data-extra-price="${extra.extra_price}" id="extra${extra.id}">
                                <label class="form-check-label text-capitalize"  for="extra${extra.id}">
                                    ${extra.extra_name} - ${extra.extra_price}€
                                </label>
                            </div>`;
                        });
                        content +=
                            `</div>
                        <span class="text-primary mb-2 d-block  show-more-extras" style="cursor:pointer;">Show More</span>`;
                    }

                    content += `</div>`; // End of extras section
                }

                content += `<p>Total Price: <span class="total-price">${food.delivery_price}€</span></p>`;
                content += `</div>`;
                return content;
            }



        });

        $(document).ready(function() {
            $('#addToCartBtn').on('click', function() {
                @if (isset(auth()->user()->id))

                    $('#loading-overlay').show();
                    $('body').addClass('no-scroll');
                    let collectionId = $('#collectionid').val();
                    if (collectionId) {
                        let variantFound = false;
                        for (let foodId in cartSelections) {
                            if (cartSelections[foodId].variantId) {
                                variantFound = true;
                                break;
                            }
                        }
                        if (!variantFound) {
                            alert('Please select at least one variant.');
                            $('#loading-overlay').hide();
                            $('body').removeClass('no-scroll');
                            return;
                        }
                    }
                    addToCart(collectionId);
                @else
                    toastr.error('Please login to add items to cart.');
                @endif
            });

            function addToCart(collectionId) {
                $.ajax({
                    url: '{{ route('cart.store2') }}',
                    method: 'POST',
                    data: {
                        "cart": cartSelections,
                        "collectionId": collectionId,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // console.log(response);
                        toastr.success('Items successfully added to cart.');
                        $('#loading-overlay').hide();
                        $('body').removeClass('no-scroll');
                        $('#foodModal').modal('hide');
                        getCart();

                    },
                    error: function() {
                        toastr.error('Error adding items to cart.');
                        $('#loading-overlay').hide();
                        $('body').removeClass('no-scroll');
                        $('#foodModal').modal('hide');
                    }
                });
            }
        });
        $(document).on('click', '.show-more-extras', function() {
            $(this).siblings('.extra-items-hidden').slideToggle();
            $(this).text($(this).text() === 'Show More' ? 'Show Less' : 'Show More');
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
