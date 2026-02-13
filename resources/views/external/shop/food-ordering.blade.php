@extends('external.frame')
@section('external-css')
    <style>
        html {

            overflow-x: hidden !important;
        }

        body {
            overflow-x: hidden !important;
        }

        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            /* Adjust as needed */
            z-index: 9999;
            overflow: hidden;
        }

        body.loading {
            overflow: hidden;
        }

        #loader img {
            width: 100px;
        }

        .category-slider {
            display: flex;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .category-list-container {
            overflow-x: hidden;
            width: 80%;
        }

        .category-list {
            display: flex;
            transition: transform 0.3s ease;
            white-space: nowrap;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .category-list li {
            margin-right: 0px;
        }

        .scroll-left,
        .scroll-right {
            padding: 5px;
            cursor: pointer;
            font-size: 14px;
            border: none;
        }

        .scroll-left:disabled,
        .scroll-right:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }





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

        select:focus {
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

        select {
            border: 1px solid #ddd;
            font-size: 24px !important;
        }

        select option {
            font-size: 24px !important;
        }

        .category-list-container {
            width: 100%;
            height: 49px;
            overflow-x: auto;
            white-space: nowrap;
            overflow-y: hidden;
            padding: 10px;
            box-sizing: border-box;

        }

        .category-list-container::-webkit-scrollbar {
            display: none;
        }

        .category-list {
            display: inline-block;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .category-list li {
            display: inline-block;
            margin: 0;
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
            border: none;
            margin-right: 10px;
            transition: background-color 0.3s, color 0.3s;
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

        #stickycontainer {
            position: sticky;
            z-index: 5;
            overflow: hidden;
        }

        .slidecontainer {
            overflow-y: scroll;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .slidecontainer::-webkit-scrollbar {
            display: none;
        }


        .overlay-cart {
            /* background: white; */
            /*z-index: 1029;*/
            overflow-y: auto;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            transform: translateX(100%);
        }

        .overlay-cart.show {
            display: block !important;
            z-index: 1051;
            margin-top: 0px !important;
            background: white;
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            width: 100%;
            overflow: hidden;
            transform: translateX(0);
        }

        .overlay-cart.show #cartcheckout {
            background: #fff;
            position: fixed;
            bottom: 0px;
            left: 10px;
            right: 10px;
        }

        .close-icon {
            position: fixed;
            top: 10px;
            right: 15px;
            cursor: pointer;
            color: #333;
            font-size: 1.5rem;
            z-index: 1100;
        }

        .overlay-cart.show .basketcontainer {
            margin-top: 0px !important;
        }

        .overlay-cart.show #cartContainer {
            margin-top: 10px !important;
        }

        @media (min-width: 1200px) {
            .overlay-cart {

                position: static;
                transform: translateX(0);
                height: auto;
                box-shadow: none;
            }

            .close-icon,
            .drag-icon {
                display: none;
            }
        }


        .tabbtn.active {
            border-radius: 23px !important;
            background-color: black !important;
            color: white !important;
        }

        .tabbtn:not(.active) {
            border-radius: 23px !important;
            background-color: #f7f7f7 !important;
            color: black !important;
        }
    </style>
@endsection
@section('external-home-content')
    <!-- Blurred Overlay -->
    <div id="loading-overlay" class="loading-overlay" style="display: none;">
        <div class="loading-text">Processing...</div>
    </div>
    <div id="loader">
        <img src="{{ asset('uploads/giphy.gif') }}" alt="Loading...">
    </div>
    <div class="container-fluid pb-5 px-xl-3 px-0  bg-primary-gradient">
        <div class="row">
            <div class="col-xl-8 slidecontainer" id="slidecontainer" style="max-height:80rem;overflow-y:scroll;">
                <div class="card mt-5">
                    <div class="card-body">
                        <div class="rest_card_img">
                            <img src="{{ isset($vendor->vendor_details->banner) ? asset('uploads/banner/' . $vendor->vendor_details->banner) : 'https://placehold.co/1200x400' }}"
                                class="img-fluid-2 rounded-2" alt="">
                            <div class="logo_block">
                                <img src="{{ isset($vendor->vendor_details->logo) ? asset('uploads/logo/' . $vendor->vendor_details->logo) : 'https://placehold.co/300x300' }}"
                                    class="img-fluid-2 rounded-2" alt="">
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-8">
                                <h2 class="fs-1 card-title">{{ $vendor->name }}</h2>
                                <a class="fw-bold"> <i class="fas text-danger fa-star"></i>
                                    {{ number_format($averageRating, 1) }} ({{ $ratingCount }})</a>
                            </div>
                            <div class="col-md-4 d-flex justify-content-end align-items-center  status-indicate">
                                @if (isset($vendor->vendor_details->restaurant_status) && $vendor->vendor_details->restaurant_status == 1)
                                    <div title="Open" class="light green"></div>
                                @else
                                    <div title="Close" class="light red"></div>
                                @endif
                                <a title="{{ $vendor->name }}" class="btn-lighter me-3">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </a>

                                <label for="favorite"
                                    class="d-flex justify-content-center align-items-center mb-0 btn-lighter"
                                    style="cursor:pointer;">
                                    <i class="fa-solid fa-heart @if ($isFav) favorit @endif "
                                        id="heart-icon" aria-hidden="true"></i>
                                    <input @checked($isFav) onchange="isFavorite({{ $vendor->id }},event)"
                                        type="checkbox" id="favorite" style="display:none;">
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
                                    <h6 style="font-size: 14px;">Delivery Time</h6>
                                    @foreach ($availability['deliveryTimes'] as $dtime)
                                        <div class="d-flex">
                                            <span class="me-3" style="font-size: 13px;"> <strong>Open
                                                    :</strong>
                                                {{ date('h:i A', strtotime($dtime->start)) }}</span>
                                            <span style="font-size: 13px;"> <strong>Close :</strong>
                                                {{ date('h:i A', strtotime($dtime->end)) }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-danger fw-bolder">Delivery Close</span>
                                @endif
                            </div>
                            <div>
                                @if (isset($availability['is_pickup_open']) && $availability['is_pickup_open'])
                                    <h6 style="font-size: 14px;">Pickup Time</h6>
                                    @foreach ($availability['pickupTimes'] as $dtime)
                                        <div class="d-flex">
                                            <span class="me-3" style="font-size: 13px;"> <strong>Open
                                                    :</strong>
                                                {{ date('h:i A', strtotime($dtime->start)) }}</span>
                                            <span style="font-size: 13px;"> <strong>Close :</strong>
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
                <div id="stickycontainer" class="w-100" style="position:sticky;top:0;z-index: 1045;  overflow: hidden;  background: #fff;">
                    <div class="input-group my-3 px-xl-5 px-3 rounded-pill">
                        <span class="input-group-text px-3 bg-transparent  rounded-start">
                            <i class="fa-solid fa-magnifying-glass text-primary"></i>
                        </span>
                        <input type="search" id="searchfoodname" class="form-control px-1  bg-transparent  rounded-end"
                            placeholder="Food name...." />
                    </div>
                    <div class="category-slider">
                        <span class="scroll-left">
                            <i class="fa-solid fa-arrow-left"></i>
                        </span>
                        <div class="category-list-container">
                            <ul class="category-list mx-0 px-0 d-flex">
                                <li>
                                    <a href="javascript:void(0);" data-target="all"
                                        class="btn tabbtn btn-outline-dark active p-1 px-3" style="font-size:14px;">
                                        Popular
                                        <i class="fa fa-heart" style="color: red; margin-left: 7px;" aria-hidden="true"></i>
                                    </a>
                                </li>
                                @foreach ($categories_data as $index => $category_data)
                                    <li>
                                        <a href="javascript:void(0);" data-target="category-{{ $index }}"
                                            class="btn  btn-light  tabbtn p-1 px-3" style="font-size:14px;">
                                            {{ $category_data->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <span class="scroll-right">
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
                <div class="card p-2 rounded-1 mt-2">
                    <h6 class="fs-1 fw-bold mt-2 text-primary">Menu Items</h6>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="all">
                            <h6 class="fw-bold text-uppercase mt-2">All Items</h6>
                            @foreach ($categories_data as $category_data)
                                <div class="categoryshow">
                                    <h6 class="fw-bold text-uppercase mt-2">{{ $category_data->name }}</h6>
                                    <p style="font-size:14px;">{{ $category_data->description }}</p>
                                    @if (isset($category_data->image) && $category_data->image != '')
                                        <div class="w-100 text-center">
                                            <img src="{{ asset('uploads/category/' . $category_data->image) }}"
                                                alt="" class="img-fluid">
                                        </div>
                                    @endif
                                </div>
                                @foreach ($category_data->food_items as $item)
                                    <div class="card mt-3 rounded-2 position-relative">
                                        <div class="card-body view-food-details" data-food-id="{{ $item->id }}"
                                            data-id="{{ $item->id }}" data-hasvariant="{{ $item->hasVariants }}"
                                            data-foodprice="{{ $item->delivery_price }}"
                                            data-collections="{{ $item->collections }}"
                                            data-foodtype="{{ $item->item_type == 'alcoholic-drink' ? 1 : 0 }}"
                                            style="cursor: pointer;">
                                            <div class="d-flex justify-content-between">
                                                <div class="food-content">
                                                    <p class="fw-bold mb-0">
                                                        {{ $item->food_item_name }}
                                                        <span class="info-ico" data-cereal="{{ $item->cereal }}"
                                                            data-nuts="{{ $item->nuts }}"
                                                            data-furthers="{{ $item->furthers }}">
                                                            <i style="font-size:14px;" class="fa fa-info-circle"
                                                                aria-hidden="true"></i>
                                                        </span>
                                                    </p>
                                                    <small class="text-muted">{{ $item->description }}</small>
                                                    <p class="mb-0 fw-bold text-dark">
                                                        {{ $item->hasVariants == 1 ? (isset($item->variants[0]->price) ? $item->variants[0]->price : 0) : $item->delivery_price }}
                                                        <i style="font-size:14px;" class="fas fa-euro-sign"></i>
                                                    </p>
                                                </div>
                                                <button class="add_cart view-food-details position-absolute"
                                                    data-food-id="{{ $item->id }}"
                                                    style="width:35px; height:35px;top:5%; right:2%;">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                        @foreach ($categories_data as $index => $category_data)
                            <div class="tab-pane" id="category-{{ $index }}">
                                <h6 class="fw-bold text-uppercase mt-2">{{ $category_data->name }}
                                </h6>
                                <p style="font-size:14px;">{{ $category_data->description }}</p>
                                @if (isset($category_data->image) && $category_data->image != '')
                                    <div class="w-100 text-center">
                                        <img src="{{ asset('uploads/category/' . $category_data->image) }}"
                                            alt="" class="img-fluid">
                                    </div>
                                @endif
                                @foreach ($category_data->food_items as $item)
                                    <div class="card mt-3 rounded-2 position-relative">
                                        <div class="card-body view-food-details" data-food-id="{{ $item->id }}"
                                            data-id="{{ $item->id }}" data-hasvariant="{{ $item->hasVariants }}"
                                            data-foodprice="{{ $item->delivery_price }}"
                                            data-collections="{{ $item->collections }}"
                                            data-foodtype="{{ $item->item_type == 'alcoholic-drink' ? 1 : 0 }}"
                                            style="cursor: pointer;">
                                            <div class="d-flex justify-content-between">
                                                <div class="food-content">
                                                    <p class="fw-bold mb-0">
                                                        {{ $item->food_item_name }}
                                                        <span class="info-ico" data-cereal="{{ $item->cereal }}"
                                                            data-nuts="{{ $item->nuts }}"
                                                            data-furthers="{{ $item->furthers }}">
                                                            <i style="font-size:14px;" class="fa fa-info-circle"
                                                                aria-hidden="true"></i>
                                                        </span>
                                                    </p>
                                                    <small class="text-muted">{{ $item->description }}</small>
                                                    <p class="mb-0 fw-bold text-dark">
                                                        {{ $item->hasVariants == 1 ? (isset($item->variants[0]->price) ? $item->variants[0]->price : 0) : $item->delivery_price }}
                                                        <i style="font-size:14px;" class="fas fa-euro-sign"></i>
                                                    </p>
                                                </div>
                                                <button class="add_cart view-food-details position-absolute"
                                                    data-food-id="{{ $item->id }}"
                                                    style="width:35px; height:35px;top:2%; right:2%;">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const tabButtons = document.querySelectorAll('.tabbtn');
                        const tabPanes = document.querySelectorAll('.tab-pane');
                        const container = document.querySelector('.category-list-container');
                        const categories = document.querySelector('.category-list');
                        const scrollLeftBtn = document.querySelector('.scroll-left');
                        const scrollRightBtn = document.querySelector('.scroll-right');
                        const searchInput = document.getElementById('searchfoodname');

                        let scrollAmount = 0;
                        const maxScroll = categories.scrollWidth - container.clientWidth;

                        // Show the first tab (All) and set it active by default
                        tabButtons[0].classList.add('active'); // Set "Popular" as active
                        tabPanes[0].classList.add('show', 'active'); // Show "All" items

                        // Handle tab click events
                        tabButtons.forEach((btn, index) => {
                            btn.addEventListener('click', function() {
                                // Reset all buttons
                                tabButtons.forEach(b => {
                                    b.classList.remove('active');
                                });

                                // Set the clicked button to active
                                this.classList.add('active');

                                // Hide all tab panes and show the selected one
                                tabPanes.forEach(pane => {
                                    pane.classList.remove('show', 'active');
                                });
                                tabPanes[index].classList.add('show',
                                    'active'); // Show the corresponding content
                            });
                        });

                        // Scroll left and right
                        scrollLeftBtn.addEventListener('click', () => {
                            if (scrollAmount > 0) {
                                scrollAmount -= container.clientWidth / 2;
                                if (scrollAmount < 0) scrollAmount = 0;
                                categories.style.transform = `translateX(-${scrollAmount}px)`;
                            }
                        });

                        scrollRightBtn.addEventListener('click', () => {
                            if (scrollAmount < maxScroll) {
                                scrollAmount += container.clientWidth / 2;
                                if (scrollAmount > maxScroll) scrollAmount = maxScroll;
                                categories.style.transform = `translateX(-${scrollAmount}px)`;
                            }
                        });

                        // Search functionality
                        searchInput.addEventListener('input', function() {
                            const searchTerm = searchInput.value.toLowerCase();

                            if (searchTerm.trim() === '') {
                                // If search input is cleared, show all categories and items
                                tabPanes.forEach(tabPane => {
                                    tabPane.style.display = ''; // Show the tab pane
                                    const items = tabPane.querySelectorAll('.card');
                                    items.forEach(item => item.style.display = ''); // Show all items
                                    const categoryShows = tabPane.querySelectorAll('.categoryshow');
                                    categoryShows.forEach(categoryShow => categoryShow.style.display =
                                    ''); // Show all category headers
                                });
                                return;
                            }

                            // Hide all categories and show only matching food items
                            tabPanes.forEach(tabPane => {
                                const items = tabPane.querySelectorAll('.card');
                                const categoryShows = tabPane.querySelectorAll('.categoryshow');

                                let hasVisibleItems = false;

                                items.forEach(item => {
                                    const itemName = item.querySelector('.food-content p').textContent
                                        .toLowerCase();
                                    if (itemName.includes(searchTerm)) {
                                        item.style.display = ''; // Show item if it matches
                                        hasVisibleItems = true;
                                    } else {
                                        item.style.display = 'none'; // Hide item if it doesn't match
                                    }
                                });

                                // Hide the entire category header if it has no matching items
                                categoryShows.forEach(categoryShow => {
                                    const categoryItems = categoryShow.nextElementSibling
                                        .querySelectorAll('.card');
                                    const hasMatchingItems = Array.from(categoryItems).some(card => card
                                        .style.display !== 'none');
                                    categoryShow.style.display = hasMatchingItems ? '' : 'none';
                                });

                                // Hide the entire tab pane if it has no visible items
                                tabPane.style.display = hasVisibleItems ? '' : 'none';
                            });
                        });

                        // Scrollspy with IntersectionObserver
                        const observer = new IntersectionObserver(entries => {
                            entries.forEach(entry => {
                                const targetID = entry.target.getAttribute('id');
                                if (entry.isIntersecting) {
                                    tabButtons.forEach(btn => {
                                        btn.classList.remove('active');
                                        if (btn.getAttribute('data-target') === targetID) {
                                            btn.classList.add('active');
                                        }
                                    });
                                }
                            });
                        }, {
                            threshold: 0.6
                        });

                        tabPanes.forEach(pane => observer.observe(pane));
                    });
                </script>

            </div>
            <div class="col-xl-4  overlay-cart d-xl-block d-none"  id="cartOverlay">
                <div class="card rounded-0 border-0 " style="position:sticky; top:0px;">
                    <!-- Close Icon -->
                    <div class="close-icon" id="closeCartOverlay">
                        <i class="fa-solid fa-times fa-lg"></i>
                    </div>

                    <div class="card-body mt-4 basketcontainer">
                        <h5 class="fs-1 text-center fw-bold">Basket</h5>
                        <div class="w-100 d-flex justify-content-center">
                            <div class="switch-button">
                                <input class="switch-button-checkbox" type="checkbox" id="toggleDeliveryPickup">
                                <label class="switch-button-label" for="toggleDeliveryPickup">
                                    <span class="switch-button-label-span"></span>
                                </label>
                            </div>
                        </div>

                        <div id="cartContainer" class="filter_content mt-3 text-center slidecontainer"
                            style="max-height:40rem; overflow-y:scroll; padding-bottom:2rem;">
                            <i class="fa-solid fa-bag-shopping fs-2 text-center"></i>
                            <h5 class="text-center fs-1 mt-2 fw-bold">Fill your basket</h5>
                            <small class="text-center ">Your basket is empty</small>
                        </div>
                        <div class="px-2 py-3 mt-3 bg-white" id="cartcheckout">

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mt-3">
            <div class="col-xl-9">
                <div class="card ">
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
                                <button class="btn btn-primary px-4 py-1 rating-submit " type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    <div class="form-group mb-3 d-none" id="foodVariantsSelect">
                        <input type="hidden" id="foodDefaultPrice" class="foodDefaultPrice" value="0">
                        <label for="variantSelect">Choose Variant:</label>
                        <div class="custom-select-wrapper">
                            <div class="custom-select">
                                <select id="variantSelect" class="custom-select rounded-0">

                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- Extras Selection -->
                    <div class="form-group " id="extrasSection">
                        <div id="extrasContainer">

                        </div>
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
                    <div class="form-group mb-3 d-none" id="editfoodVariantsSelect">
                        <input type="hidden" id="editfoodDefaultPrice" class="editfoodDefaultPrice" value="0">
                        <label for="variantSelect">Choose Variant:</label>
                        <div class="custom-select-wrapper">
                            <div class="custom-select">
                                <select id="editvariantSelect" class="custom-select rounded-0">

                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Extras Selection -->
                    <div class="form-group bg-nue" id="editextrasSection">

                        <div id="editextrasContainer"></div>
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

    <!-- Modal -->
    <div class="modal fade" id="foodInfoModal" tabindex="-1" aria-labelledby="foodInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="foodInfoModalLabel">Food Allergens</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Cereal:</strong> <span id="modalCereal">N/A</span></p>
                    <p><strong>Nuts:</strong> <span id="modalNuts">N/A</span></p>
                    <p><strong>Furthers:</strong> <span id="modalFurthers">N/A</span></p>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('external-js')
    <script>
        $(document).ready(function() {
            function toggleCartOverlay() {
                $('#cartOverlay').toggleClass('show');
            }

            $('#openCartOverlay').on('click', function() {
                if ($(window).width() < 1200) {
                    toggleCartOverlay();
                }
            });

            $('#closeCartOverlay').on('click', function() {
                if ($(window).width() < 1200) {
                    toggleCartOverlay();
                }
            });

            let resizeTimeout;
            $(window).on('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    if ($(window).width() >= 1200) {
                        $('#cartOverlay').removeClass('show');
                    }
                }, 200);
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.body.classList.add("loading");
        });

        window.addEventListener("load", function() {
            const loader = document.getElementById("loader");
            loader.style.display = "none";
            document.body.classList.remove("loading");
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    var cartProductQty = cartItems.length;
                    cartContainer.empty(); // Clear existing content

                    $.each(cartItems, function(index, item) {
                        totalPrice = parseFloat(totalPrice) + parseFloat(item.total_price);
                        var food_item = item?.food_item;
                        var hasFoodVar = food_item?.hasVariants;
                        var hasFoodCollections = food_item?.collections;
                        var iconEdit = (hasFoodVar == 1 || (hasFoodCollections != '' && hasFoodCollections !=
                                null)) ?
                            `<a class='btn btn-sm btn-success p-1 position-absolute'  style="cursor:pointer;right:5px;top:5px;" onclick="updateCartProduct(${item?.id})"><i class="fa-solid fa-pencil" aria-hidden="true"></i></a>` :
                            '';
                        imaUrl = (food_item?.image) ? "{{ asset('uploads/menu/') }}/" + food_item?.image :
                            "{{ asset('uploads/foodu.png') }}";

                        var isAlco = (item?.isAlcohol == 1) ? "<span class='badge bg-danger'>18+</span>" : "";
                        var dressing = (item?.dressing) ? item?.dressing : "";
                        var food_variant = item?.variant?.variant_item;
                        var foodvarName = (hasFoodVar == 1) ? `(${food_variant?.name})` : '';
                        var liElement = `${food_item.food_item_name} ${foodvarName} ${isAlco} `;

                        var extrasAdded = '';
                        if (item?.collection_items) {
                            $.each(item.collection_items, function(index, collectionItem) {
                                extrasAdded += collectionItem?.sub_items?.name + ', ';
                            });
                        }

                        let card = `
<div class="card mb-2 position-relative">
    <div class="card-body d-flex justify-content-between align-items-center flex-column">
        <div class="row">
            <div class="col-12">
                <div>
                    <img src="${imaUrl}" class="rounded-2" style="height:5rem; max-width:7rem;" />
                </div>
                <span class="mt-2 fw-bold" onclick="updateCartProduct(${item?.id})">${liElement}</span>
                <div style="font-size:13px;">
                    <strong>Extra Note:</strong> ${item?.extra_note ? item?.extra_note : "NA"}
                </div>
                <div class="w-100 d-flex justify-content-center mt-2 align-items-center">
                    <div class="mt-2 mt-md-0" style="font-size:11px;">
                        <span class="mb-0 text-primary">${item.total_price} €</span>/
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
            <button class="btn btn-primary p-2 me-2 py-1 btn-sm add-note-btn" data-id="${item.id}">Add Note</button>
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

        ${iconEdit}

        <div class="bg-nue mt-2">
            ${extrasAdded}
        </div>
    </div>
</div>
`;
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
                    $('#priceCart').html(`&euro; ${totalPricePay.toFixed(2)}`);
                    $('#qtyCart').html(`${cartProductQty}`);
                    // Append calculation at the end
                    var isDisable = isDeliveryMin ? '' : 'disabled';
                    var buttonCheck = true;
                    if (isPickupSelected) {
                        buttonCheck = isPickOpen;
                    } else {
                        buttonCheck = isDeliverOpen;
                    }
                    var classNone = buttonCheck ? '' : 'd-none'
                    $('#cartcheckout').html(
                        `
                        <div id="checkoutgroup" class="w-100"> 
                      <ul class="mx-0 px-0">
                       ${calCaulation}
                      </ul>
                     <button ${isDisable} class="btn btn-primary mt-3 w-100 rounded-1 ${classNone}" type="button" id="checkoutNowBtn">Checkout Now</button>
                     <small class="text-center w-100 d-block">Minimum Order Price Must be : ${min_order_price}€</small>
                
                        </div>
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
                } else {
                    cartContainer.html(
                        `<i class="fa-solid fa-bag-shopping fs-2 text-center"></i>
                                <h5 class="text-center fs-1 mt-2 fw-bold">Fill your basket</h5>
                                <small class="text-center ">Your basket is empty</small>`
                    );
                    $('#priceCart').html(`&euro; 0.00`);
                    $('#qtyCart').html(`0`);

                }
            } else {
                cartContainer.html(`<p class="text-center">Please choose a location on home page!</p>`);
                $('#priceCart').html(`&euro; 0.00`);
                $('#qtyCart').html(`0`);
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
                // location.reload();
                getCart();
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
                    } else {
                        getCart();

                    }
                }
            });
        }



        let editbasePrice = 0;
        let edittotalPrice = 0;
        let editcurrentQty = 1;
        let edit_dressing = 0;
        let edit_collections = [];
        let collectionIds = [];
        let isAlocoEd = 0;

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
                    var edHasVariant = response?.food?.hasVariants;
                    isAlocoEd = response.cart.isAlcohol;
                    edit_collections = response?.collections;
                    edit_dressing = response?.cart?.dressing_type;


                    // Load variants in select
                    $('#editvariantSelect').empty();
                    if (edHasVariant == 1) {
                        $('#editfoodVariantsSelect').removeClass('d-none');
                        $.each(response?.food?.variants, function(key, variant) {
                            var edit_food_select = (variant?.id == response?.cart?.variant_id) ?
                                "selected" : "";
                            $('#editvariantSelect').append(
                                `<option ${edit_food_select} value="${variant.id}" data-key="${variant.variant_id}" data-price="${variant.price}">${variant.variant_item.name} (€${variant.price})  ${variant.variant_item.other_info}</option>`
                            );
                        });

                    } else {
                        $('#editfoodVariantsSelect').addClass('d-none');

                        $('#editfoodDefaultPrice').val(response?.food?.delivery_price);
                    }

                    // Load extras and other data
                    let varinats = response?.cart?.variant;
                    let dressing = response?.cart?.dressing_type;
                    collectionIds = response?.extraIds;

                    edit_loadExtras(response?.collections, collectionIds, varinats?.variant_id, dressing);
                    editcurrentQty = response?.cart?.quantity;
                    updateTotalPrice();
                    $('#editfoodModal').modal('show');
                }
            });
        }



        // function to load extras based on the selected variant
        function edit_loadExtras(extras, checks, variant_id, dressing) {
            $('#editextrasContainer').empty();
            edit_loadCheckboxItems('#editextrasContainer', extras, checks, 'edit-extra-checkbox', variant_id, dressing);
        }

        function checkValueInArray(checks, value) {

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
        // Function to load and show checkbox items (toppings, extras, etc.)
        function edit_loadCheckboxItems(container, collections, checks, className, variant_id, dressing) {
            $(container).empty();
            $.each(collections, function(key, collection) {
                const items = collection?.collection_items;
                const collectionType = collection.type;
                const isMultiple = collection.isMultiple;
                const collectionBlock = $('<div>', {
                    class: 'collection-block bg-nue mt-3'
                });

                const maxVisibleItems = 5;
                const showMoreButton =
                    `<p class="show-more-btn cursor-pointer text-primary pb-0 mb-0 fs-1 mt-2">Show More</p>`;
                const showLessButton =
                    `<p class="show-less-btn cursor-pointer text-primary pb-0 mb-0 fs-1 mt-2">Show Less</p>`;

                // Check if the collection type is 'dressing'
                if (collectionType === 'dressing' || isMultiple == 0) {
                    collectionBlock.append(
                        `<h5>${collection.name} <span class="text-danger">*</span></h5>`);

                    const selectDropdown = $('<select>', {
                        class: `form-select edit_single_extras bg-white w-100 py-3  px-2 rounded-0 ${className}-select`,
                        id: `editdressing_type`
                    });


                    $.each(items, function(index, item) {
                        var isDrSelect = checkValueInArray(checks, item?.id) == "checked" ? "selected" : "";
                        let dprice = item?.dprice;
                        let price = item?.prices[variant_id] || dprice;
                        let sub_item = item?.sub_items?.name;
                        let isPrice = price == 0 ? "" : `<span>${price}€</span>`;
                        // let isDrSelect = (dressing == item?.id) ? "selected" : '';
                        selectDropdown.append(
                            `<option ${isDrSelect} value="${item.id}" data-price="${price}">${sub_item} ${isPrice}</option>`
                        );
                    });
                    collectionBlock.append(selectDropdown);
                } else {
                    collectionBlock.append(`<h5>${collection.name}</h5>`);
                    $.each(items, function(index, item) {
                        var isChecked = checkValueInArray(checks, item?.id);
                        let dprice = item?.dprice;
                        let price = item?.prices[variant_id] || dprice;
                        let sub_item = item?.sub_items?.name;
                        let sub_item_info = item?.sub_items?.info;
                        let collection_type = item?.sub_items?.type;
                        let isPrice = price == 0 ? "" : `<span>${price}€</span>`;
                        let isAlcohol = collection_type == 'alcohol-drink';
                        var flagAlcohal = (isAlcohol) ?
                            "<span class='badge bg-danger'>18+ Age</span>" : ""
                        const checkboxId = `${className}-${key}-${index}`;

                        // Create checkbox and append it
                        const checkboxItem = $(`
                                               <div class="mb-2">
                                                   <div class="form-check align-items-center ${className}-item" style="display:${index < maxVisibleItems ? 'flex' : 'none'};">
                                                       <input ${isChecked} id="${checkboxId}" style="height:25px; width:25px;" 
                                                           class="form-check-input mt-0 me-2 rounded-0 ${className}" 
                                                           type="checkbox" value="${item.id}" data-price="${price}" ${isAlcohol ? 'data-alcohol="true"' : ''}>
                                                       <label class="form-check-label fs-3 mb-0 pb-0" for="${checkboxId}">
                                                           ${sub_item} ${isPrice}  ${flagAlcohal}
                                                       </label>
                                                   </div>
                                                   <small class="${className}-info" style="display:${index < maxVisibleItems ? 'flex' : 'none'};">
                                                        ${(sub_item_info!="" && sub_item_info!=null)?sub_item_info:""}
                                                   </small>
                                               </div>
                                              `);

                        collectionBlock.append(checkboxItem);

                        // Attach event listener for alcohol confirmation
                        if (isAlcohol) {
                            checkboxItem.find(`#${checkboxId}`).on('change', function() {
                                const checkbox = $(this);

                                if (checkbox.is(':checked')) {
                                    if (!isAlocoEd) {
                                        Swal.fire({
                                            title: 'Age Confirmation',
                                            text: 'Are you 18 years or older?',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'Yes, I am 18+',
                                            cancelButtonText: 'No',
                                            confirmButtonColor: '#f41909'
                                        }).then((result) => {
                                            if (!result.isConfirmed) {
                                                checkbox.prop('checked',
                                                    false
                                                );
                                            } else {
                                                isAlocoEd = 1;
                                            }
                                        });
                                    }

                                } else {
                                    isAlocoEd = 0;
                                }
                            });
                        }
                    });

                    if (items.length > maxVisibleItems) {
                        collectionBlock.append(showMoreButton);

                        collectionBlock.on('click', '.show-more-btn', function() {
                            $(`.${className}-item`).slice(maxVisibleItems).show();
                            $(`.${className}-info`).slice(maxVisibleItems).show();
                            $(this).replaceWith(showLessButton);
                        });

                        collectionBlock.on('click', '.show-less-btn', function() {
                            $(`.${className}-item`).slice(maxVisibleItems).hide();
                            $(`.${className}-info`).slice(maxVisibleItems).hide();
                            $(this).replaceWith(showMoreButton);
                        });
                    }
                }
                $(container).append(collectionBlock);
            });
        }

        // Update extras prices based on selected variant
        $('#editvariantSelect').on('change', function() {
            let selectedVariant_Id = $(this).val();
            let dataKey = $(this).find(':selected').data('key');
            edit_loadExtras(edit_collections, collectionIds, dataKey, edit_dressing);
            updateTotalPrice();
        });

        // Helper function to calculate total price
        function updateTotalPrice() {
            let edittotalPrice = 0;

            // Get selected variant price
            let variantPrice = parseFloat($('#editvariantSelect option:selected').data('price')) || 0;
            edittotalPrice += variantPrice == undefined ? 0 : variantPrice;


            let editfoodDefaultPrice = $('#editfoodDefaultPrice').val();
            editfoodDefaultPrice = (editfoodDefaultPrice == undefined) ? 0 : parseFloat(editfoodDefaultPrice);
            edittotalPrice += editfoodDefaultPrice;

            // Get selected extras price
            $('#editextrasContainer input[type=checkbox]:checked, edit_single_extras option:selected').each(function() {
                edittotalPrice += parseFloat($(this).data('price'));
            });

            let qtyInput = $('.edit-qty-input');
            let editcurrentQty = parseInt(qtyInput.val()) || 1;

            // Update the modal's total price display
            $('#edittotalPrice').text(`€${edittotalPrice.toFixed(2)*editcurrentQty}`);
            $('#totalCostPay').val(edittotalPrice.toFixed(2) * editcurrentQty);
        }
        $('.modal-body').on('change',
            '.edit-extra-checkbox, .edit_single_extras',
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
            let editdressing_type = $('#editdressing_type').val();

            $('.edit-extra-checkbox:checked, .edit_single_extras option:selected').each(function() {
                editselectedExtras.push($(this).val());
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
                dressing_type: editdressing_type,
                isAlcohal: isAlocoEd,
                total_price: edittotalPrice
            };
            // console.log(dataCart);
            if (editdressing_type == 0) {
                alert('Please select a dressing');
            } else {
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
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            let basePrice = 0;
            let totalPrice = 0;
            let currentQty = 1;
            let extras = []; // To store extras and update their prices
            let isAloco = 0;
            // Function to open modal and load food details
            $('.view-food-details').on('click', function(event) {
                let foodId = $(this).data('id');
                let hasVariant = $(this).data('hasvariant');
                let hasCollections = $(this).data('collections');
                // alert(hasCollections);

                let foodtype = $(this).data('foodtype');
                let foodprice = $(this).data('foodprice');

                if ($(event.target).closest('.info-ico').length > 0) {
                    return;
                }
                if (hasVariant == 1 || (hasCollections != '' && hasCollections != null)) {
                    var urlGet = "{{ route('getFoodDetails') }}/" + foodId;
                    $.ajax({
                        url: urlGet,
                        method: 'GET',
                        success: function(response) {
                            // console.log(response);
                            // Set modal content
                            $('#foodModalContent').data('id', response?.data?.food?.id);
                            $('#foodModalLabel').text(response?.data?.food?.food_item_name);
                            $('#foodDescription').text(response?.data?.food?.description);
                            basePrice = response?.data?.food?.base_price;
                            collections = response?.data?.collections;


                            // Load variants in select
                            $('#variantSelect').empty();
                            if (hasVariant == 1) {
                                $('#foodVariantsSelect').removeClass('d-none')
                                $.each(response?.data?.food?.variants, function(key, variant) {
                                    $('#variantSelect').append(
                                        `<option value="${variant.id}" data-key="${variant.variant_id}" data-price="${variant.price}">${variant.variant_item.name} (€${variant.price})  ${variant.variant_item.other_info}</option>`
                                    );
                                });
                            } else {
                                $('#foodVariantsSelect').addClass('d-none')
                                $('#foodDefaultPrice').val(response?.data?.food
                                    ?.delivery_price);
                            }

                            // Load extras and other data
                            let varinats = response?.data?.food?.variants;
                            loadExtras(response?.data?.collections, varinats[0]?.variant_id);
                            currentQty = 1;
                            updatePrice();
                            $('#foodModal').modal('show');
                        }
                    });
                } else {
                    var dataCart = {
                        _token: "{{ csrf_token() }}",
                        food_id: foodId,
                        variant_id: null,
                        quantity: 1,
                        extras: [],
                        dressing_type: null,
                        isAlcohal: foodtype,
                        total_price: foodprice
                    };
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
                        },
                        error: function(err) {
                            console.error(err);
                            toastr.error('Please try again')
                        }
                    });
                }
            });



            function loadExtras(extras, variant_id) {
                // alert(variant_id);
                $('#extrasContainer').empty();
                loadCheckboxItems('#extrasContainer', extras, 'extra-checkbox', variant_id);
            }


            function loadCheckboxItems(container, collections, className, variant_id) {
                $(container).empty();
                $.each(collections, function(key, collection) {
                    const items = collection?.collection_items;
                    const collectionType = collection.type;
                    const isMultiple = collection.isMultiple;
                    const collectionBlock = $('<div>', {
                        class: 'collection-block bg-nue mt-3'
                    });

                    const maxVisibleItems = 5;
                    const showMoreButton =
                        `<p class="show-more-btn cursor-pointer text-primary pb-0 mb-0 fs-1 mt-2">Show More</p>`;
                    const showLessButton =
                        `<p class="show-less-btn cursor-pointer text-primary pb-0 mb-0 fs-1 mt-2">Show Less</p>`;

                    // Check if the collection type is 'dressing'
                    if (collectionType === 'dressing' || isMultiple == 0) {
                        collectionBlock.append(
                            `<h5>${collection.name} <span class="text-danger">*</span></h5>`);

                        const selectDropdown = $('<select>', {
                            class: `form-select single_extras bg-white w-100 py-3  px-2 rounded-0 ${className}-select`,
                            id: `dressing_type`
                        });

                        // selectDropdown.append(
                        //     `<option value="0" data-price="0">Please select an option</option>`);

                        $.each(items, function(index, item) {

                            let dprice = item?.dprice;
                            let price = item?.prices[variant_id] || dprice;
                            let sub_item = item?.sub_items?.name;
                            let isPrice = price == 0 ? "" : `<span>${price}€</span>`;
                            selectDropdown.append(
                                `<option value="${item.id}" data-price="${price}">${sub_item} ${isPrice}</option>`
                            );
                        });
                        collectionBlock.append(selectDropdown);
                    } else {
                        collectionBlock.append(`<h5>${collection.name}</h5>`);
                        $.each(items, function(index, item) {
                            let dprice = item?.dprice;
                            let price = item?.prices[variant_id] || dprice;
                            let sub_item = item?.sub_items?.name;
                            let sub_item_info = item?.sub_items?.info;
                            let collection_type = item?.sub_items?.type;
                            let isPrice = price == 0 ? "" : `<span>${price}€</span>`;
                            let isAlcohol = collection_type == 'alcohol-drink';
                            var flagAlcohal = (isAlcohol) ?
                                "<span class='badge bg-danger'>18+ Age</span>" : ""
                            const checkboxId = `${className}-${key}-${index}`;

                            // Create checkbox and append it
                            const checkboxItem = $(`
                                               <div class="mb-2">
                                                   <div class="form-check align-items-center ${className}-item" style="display:${index < maxVisibleItems ? 'flex' : 'none'};">
                                                       <input id="${checkboxId}" style="height:25px; width:25px;" 
                                                           class="form-check-input mt-0 me-2 rounded-0 ${className}" 
                                                           type="checkbox" value="${item.id}" data-price="${price}" ${isAlcohol ? 'data-alcohol="true"' : ''}>
                                                       <label class="form-check-label fs-3 mb-0 pb-0" for="${checkboxId}">
                                                           ${sub_item} ${isPrice}  ${flagAlcohal}
                                                       </label>
                                                   </div>
                                                   <small class="${className}-info" style="display:${index < maxVisibleItems ? 'flex' : 'none'};">
                                                       ${(sub_item_info!="" && sub_item_info!=null)?sub_item_info:""}
                                                   </small>
                                               </div>
                                              `);

                            collectionBlock.append(checkboxItem);

                            // Attach event listener for alcohol confirmation
                            if (isAlcohol) {
                                checkboxItem.find(`#${checkboxId}`).on('change', function() {
                                    const checkbox = $(this);

                                    if (checkbox.is(':checked')) {
                                        if (!isAloco) {

                                            Swal.fire({
                                                title: 'Age Confirmation',
                                                text: 'Are you 18 years or older?',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonText: 'Yes, I am 18+',
                                                cancelButtonText: 'No',
                                                confirmButtonColor: '#f41909'
                                            }).then((result) => {
                                                if (!result.isConfirmed) {
                                                    checkbox.prop('checked',
                                                        false
                                                    );
                                                } else {
                                                    isAloco = 1;
                                                }
                                            });
                                        }

                                    }
                                });
                            }
                        });
                        if (items.length > maxVisibleItems) {
                            collectionBlock.append(showMoreButton);

                            collectionBlock.on('click', '.show-more-btn', function() {
                                $(`.${className}-item`).slice(maxVisibleItems).show();
                                $(`.${className}-info`).slice(maxVisibleItems).show();
                                $(this).replaceWith(showLessButton);
                            });

                            collectionBlock.on('click', '.show-less-btn', function() {
                                $(`.${className}-item`).slice(maxVisibleItems).hide();
                                $(`.${className}-info`).slice(maxVisibleItems).hide();
                                $(this).replaceWith(showMoreButton);
                            });
                        }
                    }
                    $(container).append(collectionBlock);
                });
            }



            // Update extras prices based on selected variant
            $('#variantSelect').on('change', function() {
                let selectedVariantId = $(this).val();
                let dataKey = $(this).find(':selected').data('key');

                loadExtras(collections, dataKey);
                updatePrice();
            });

            // Function to update the price
            function updatePrice() {
                let selectedVariantPrice = parseFloat($('#variantSelect option:selected').data('price')) ||
                    basePrice;
                selectedVariantPrice = selectedVariantPrice == undefined ? 0 : selectedVariantPrice;
                let foodDefaultPrice = $('#foodDefaultPrice').val();
                foodDefaultPrice = (foodDefaultPrice == undefined) ? 0 : parseFloat(foodDefaultPrice);
                let extraCost = 0;

                $('.extra-checkbox:checked, .single_extras option:selected')
                    .each(function() {
                        // console.log($(this).val())
                        extraCost += parseFloat($(this).data('price')) || 0;
                    });

                totalPrice = (selectedVariantPrice + extraCost + foodDefaultPrice) * currentQty;
                $('#totalPrice').text(`€${totalPrice.toFixed(2)}`);
            }

            // Update price when extras or toppings are selected
            $('.modal-body').on('change',
                '.extra-checkbox,.single_extras',
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
                let dressing_type = $('#dressing_type').val();


                $('.extra-checkbox:checked,.single_extras option:selected').each(function() {
                    selectedExtras.push($(this).val());
                });
                if (dressing_type == 0) {
                    toastr.warning('Please select a dressing');
                } else {

                    currentQty = $('.qty-input').val();
                    var dataCart = {
                        _token: "{{ csrf_token() }}",
                        food_id: foodId,
                        variant_id: selectedVariantId,
                        quantity: currentQty,
                        extras: selectedExtras,
                        dressing_type: dressing_type,
                        isAlcohal: isAloco,
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
                }
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.info-ico').forEach(function(element) {
                element.addEventListener('click', function(event) {
                    event.stopPropagation();
                    // Get the data attributes from the clicked info icon
                    let cereal = this.getAttribute('data-cereal');
                    let nuts = this.getAttribute('data-nuts');
                    let furthers = this.getAttribute('data-furthers');

                    // Parse the data (JSON encoded), if null, set default values
                    cereal = cereal !== 'null' ? JSON.parse(cereal) : 'N/A';
                    nuts = nuts !== 'null' ? JSON.parse(nuts) : 'N/A';
                    furthers = furthers !== 'null' ? JSON.parse(furthers) : 'N/A';

                    // Set the data in the modal
                    document.getElementById('modalCereal').textContent = cereal;
                    document.getElementById('modalNuts').textContent = nuts;
                    document.getElementById('modalFurthers').textContent = furthers;

                    // Show the modal
                    var modal = new bootstrap.Modal(document.getElementById('foodInfoModal'), {
                        keyboard: false
                    });
                    modal.show();
                });
            });
        });
    </script>
<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     let stickyContainer = document.getElementById("stickycontainer");
    //     let slideContainer = document.getElementById("slidecontainer");

    //     if (stickyContainer && slideContainer) {
    //         let initialStickyPosition = stickyContainer.offsetTop;
    //         let isFixed = false;

    //         function checkScroll() {
    //             let windowScroll = window.pageYOffset || document.documentElement.scrollTop;
    //             let slideContainerOffset = slideContainer.getBoundingClientRect().top;
    //             let combinedScroll = windowScroll - slideContainerOffset + slideContainer.scrollTop;

                
    //             if ((windowScroll > initialStickyPosition || combinedScroll > initialStickyPosition) && !isFixed) {
    //                 stickyContainer.style.position = "fixed";
    //                 stickyContainer.style.top = "0px";
    //                 stickyContainer.style.left = "0px";
    //                 stickyContainer.style.width = "100%";
    //                 isFixed = true;
    //             }
                
    //             else if (windowScroll <= initialStickyPosition && combinedScroll <= initialStickyPosition && isFixed) {
    //                 stickyContainer.style.position = "static";
    //                 isFixed = false;
    //             }
    //         }

            
    //         window.addEventListener("scroll", checkScroll);
    //         slideContainer.addEventListener("scroll", checkScroll);
    //     }
    // });
</script>

  
@endsection
