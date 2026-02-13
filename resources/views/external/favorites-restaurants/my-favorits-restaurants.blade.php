@extends('external.frame')
@section('external-css')
    <style>
        :root {
            --primary-red: #ff0000;
            --dark-red: #cc0000;
            --light-red: #ff3333;
            --accent-gold: #ffd700;
            --text-dark: #333;
            --text-light: #fff;
            --bg-light: #fff8f8;
        }
        
        body {
            background-color: var(--bg-light);
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--dark-red) 100%);
            padding: 3rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path fill="rgba(255,255,255,0.05)" d="M0,0 L100,0 L100,100 L0,100 Z" /></svg>');
            background-size: cover;
            opacity: 0.1;
        }
        
        .hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .hero-title span {
            color: var(--accent-gold);
        }
        
        /* Search and Filter */
        .search-box {
            position: relative;
            box-shadow: 0 5px 15px rgba(255, 0, 0, 0.2);
            border-radius: 50px;
            overflow: hidden;
        }
        
        .search-input {
            padding: 0.6rem 0.8rem;
            border: none;
            width: 100%;
            font-size: 1.1rem;
        }
        
        .search-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--primary-red);
        }
        
        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-red);
            font-size: 1.2rem;
        }
        
        .custom-select-wrapper {
            position: relative;
            width: 100%;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(255, 0, 0, 0.2);
        }
        
        .custom-select select {
            width: 100%;
            padding: 0.6rem;
            border: none;
            background-color: white;
            appearance: none;
            font-size: 1.1rem;
            cursor: pointer;
        }
        
        .custom-select::after {
            content: '\f078';
            font-family: 'FontAwesome';
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-red);
            pointer-events: none;
        }
        
        /* Restaurant Cards */
        .restaurant-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(255, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            border: none;
        }
        
        .restaurant-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(255, 0, 0, 0.2);
        }
        
        .card-image {
            height: 13rem;
            display: block;
            position: relative;
            overflow: hidden;
        }
        
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .restaurant-card:hover .card-image img {
            transform: scale(1.05);
        }
        
        .favorite-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-red);
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            border: none;
        }
        
        .favorite-btn:hover {
            background: var(--primary-red);
            color: white;
            transform: scale(1.1);
        }
        
        .sponsored-badge {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background: var(--accent-gold);
            color: var(--text-dark);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .restaurant-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        .restaurant-cuisine {
            color: var(--primary-red);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .restaurant-info {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }
        
        .info-item i {
            margin-right: 5px;
            color: var(--primary-red);
        }
        
        .rating {
            color: var(--accent-gold);
            font-weight: bold;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--dark-red) 100%);
            padding: 4rem 0;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .cta-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            position: relative;
            z-index: 2;
        }
        
        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-red);
            margin-bottom: 1.5rem;
        }
        
        .cta-feature {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .cta-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-red);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 1.5rem;
            flex-shrink: 0;
        }
        
        .cta-feature-text {
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .app-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .app-btn {
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .app-btn:hover {
            transform: translateY(-5px);
        }
        
        /* Pulse Animation */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        /* Floating Hearts */
        .floating-hearts {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 1;
        }
        
        .heart {
            position: absolute;
            color: rgba(255,255,255,0.3);
            animation: float 15s linear infinite;
            font-size: 1.5rem;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 1.5rem;
            }
            
            .restaurant-card {
                margin-bottom: 1.5rem;
            }
            
            .app-buttons {
                flex-direction: column;
            }
        }
    </style>
@endsection

@section('external-home-content')
    <!-- Hero Section -->
    <section class="hero-section py-2">
        <div class="floating-hearts">
            @for ($i = 0; $i < 15; $i++)
                <div class="heart" style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 10) }}s;">
                    <i class="fas fa-heart"></i>
                </div>
            @endfor
        </div>
        
        <div class="container position-relative">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="hero-title mb-1">My <span>Favorite</span> Restaurants</h1>
                    <p class="text-white mb-1 " style="font-size:16px;">All your loved restaurants in one place, ready to serve you again!</p>
                </div>
            </div>
            
            <div class="row justify-content-center mt-1">
                <div class="col-lg-10">
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-4">
                            <div class="search-box">
                                <input type="text" class="search-input" placeholder="Search your favorite restaurants..." 
                                    value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}" name="search">
                                <i class="fas fa-search search-icon"></i>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-select-wrapper">
                                <div class="custom-select">
                                    <select name="sort_by" class="form-select">
                                        <option value="">Sort By</option>
                                        <option value="rating" @if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'rating') selected @endif>Top Rated</option>
                                        <option value="price_low_to_high" @if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'price_low_to_high') selected @endif>
                                            Price: Low to High</option>
                                        <option value="price_high_to_low" @if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'price_high_to_low') selected @endif>
                                            Price: High to Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Restaurants Section -->
    <section class="py-5">
        <div class="container">
            <div class="row" id="listview">
                @forelse ($open_vendors as $open_vendor)
                    <div class="col-md-3 col-sm-4 ">
                        <div class="restaurant-card">
                            <a href="{{ route('shop.view', $open_vendor->unid) }}" class="card-image position-relative">
                                <img src="@if (isset($open_vendor->profile) && !empty($open_vendor->profile)) {{ asset('uploads/users/' . $open_vendor->profile) }}
                                    @else https://placehold.co/600x400/ff0000/ffffff?text=Restaurant @endif" 
                                    alt="{{ $open_vendor->name }}">
                                
                                <button class="favorite-btn">
                                    <i class="fas fa-heart"></i>
                                </button>
                                
                                @if (isset($open_vendor->vendor_details->isSponsored) && $open_vendor->vendor_details->isSponsored == 1)
                                    <div class="sponsored-badge">
                                        <i class="fas fa-crown me-1"></i> Sponsored
                                    </div>
                                @endif
                            </a>
                            
                            <div class="card-body pt-2">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h3 class="restaurant-name">{{ $open_vendor->name }}</h3>
                                        <p class="restaurant-cuisine">
                                            {{ isset($open_vendor->vendor_details->restuarnat_title) ? $open_vendor->vendor_details->restuarnat_title : 'Premium Dining' }}
                                        </p>
                                    </div>
                                    <div class="rating text-danger">
                                        <i class="fas fa-star"></i> {{ rand(3, 5) }}.{{ rand(0, 9) }}
                                    </div>
                                </div>
                                
                                <div class="restaurant-info">
                                    <div class="info-item">
                                        <i class="fas fa-clock me-2" ></i>
                                        <span>{{ isset($open_vendor->vendor_details->min_prepare_time) ? $open_vendor->vendor_details->min_prepare_time : '0' }}-{{ isset($open_vendor->vendor_details->max_prepare_time) ? $open_vendor->vendor_details->max_prepare_time : '0' }} min</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-motorcycle me-2" ></i>
                                        <span>{{ isset($open_vendor->vendor_details->delivery_cost) ? number_format($open_vendor->vendor_details->delivery_cost) : '0' }} €</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-shopping-bag  me-2"></i>
                                        <span>Min {{ isset($open_vendor->vendor_details->minimum_price) ? number_format($open_vendor->vendor_details->minimum_price) : '0' }} €</span>
                                    </div>
                                </div>
                                
                                
                                
                                <a href="{{ route('shop.view', $open_vendor->unid) }}" class="btn btn-danger mt-3">
                                    Order Now <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <img src="https://placehold.co/300x300/ff0000/ffffff?text=No+Favorites" alt="No favorites" class="img-fluid mb-4" style="max-width: 200px;">
                        <h3 class="text-danger">No Favorite Restaurants Yet</h3>
                        <p class="text-muted">Start adding restaurants to your favorites and they'll appear here!</p>
                        <a href="{{ route('home') }}" class="btn btn-danger btn-lg mt-3">
                            <i class="fas fa-utensils me-2"></i> Explore Restaurants
                        </a>
                    </div>
                @endforelse
            </div>
            
            @if(count($open_vendors) > 0)
                <div class="row justify-content-center mt-4">
                    <div class="col-auto">
                        {{ $open_vendors->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
      <section class="pb-md-2 pb-5 steps1"
        style="background-image: url('{{ asset('uploads/bg.jpg') }}'); background-repeat: no-repeat; background-size: cover; background-attachment: fixed; background-position: center; "
        id="steps">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="card card-span w-100 shadow" style="border-radius: 35px;">
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
                <div class="col-lg-5 mt-7 mt-md-0">
                    <h1 class="text-light">Install the app</h1>
                    <p class="text-light fw-bold">It's never been easier to order food. Look for the finest <br
                            class="d-none d-xl-block" />discounts
                        and you'll be lost in a world of delectable food.</p>
                    <div class="d-flex justify-content-md-start justify-content-between">
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
    <section class="py-0 mt-4">

        <div class="container-fluid">
            <div class="row justify-content-center g-0">
                <div class="col-xl-12">
                    <div class="col-lg-6 text-center mx-auto mb-4 ">
                        <h5 class="fw-bold fs-3 fs-lg-5 lh-sm ">How does it work</h5>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-3 mb-6">
                            <div class="text-center">
                                <img class="shadow-icon"
                                    src="{{ asset('pizza-client/assets/img/illustrations/location.svg') }}"
                                    height="112" alt="..." />
                                <h5 class="mt-4 fw-bold">Select location</h5>
                                <p class="mb-md-0">Choose the location where your food will be delivered.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-6">
                            <div class="text-center"><img class="shadow-icon"
                                    src="{{ asset('pizza-client/assets/img/illustrations/select-food.svg') }}"
                                    height="112" alt="..." />
                                <h5 class="mt-4 fw-bold">Choose order</h5>
                                <p class="mb-md-0">Check over hundreds of menus to pick your favorite food</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-6">
                            <div class="text-center"><img class="shadow-icon"
                                    src="{{ asset('pizza-client/assets/img/illustrations/pay.svg') }}" height="112"
                                    alt="..." />
                                <h5 class="mt-4 fw-bold">Pay advanced</h5>
                                <p class="mb-md-0">It's quick, safe, and simple. Select several methods of payment</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 mb-6">
                            <div class="text-center"><img class="shadow-icon"
                                    src="{{ asset('pizza-client/assets/img/illustrations/meal.svg') }}" height="112"
                                    alt="..." />
                                <h5 class="mt-4 fw-bold">Enjoy meals</h5>
                                <p class="mb-md-0">Food is made and delivered directly to your home.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end of .container-->

    </section>
@endsection

@section('external-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search and filter functionality
            const inputs = document.querySelectorAll('.search-input, select');
            
            inputs.forEach(input => {
                input.addEventListener('change', function() {
                    const params = new URLSearchParams();

                    inputs.forEach(i => {
                        if (i.value) {
                            params.append(i.name, i.value);
                        }
                    });

                    const url = `${window.location.pathname}?${params.toString()}`;
                    window.location.href = url;
                });
            });
            
            // Add typing delay for search input
            const searchInput = document.querySelector('.search-input');
            let typingTimer;
            
            searchInput.addEventListener('keyup', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(function() {
                    const params = new URLSearchParams();
                    params.append('search', searchInput.value);
                    
                    const sortBy = document.querySelector('select[name="sort_by"]').value;
                    if (sortBy) {
                        params.append('sort_by', sortBy);
                    }
                    
                    const url = `${window.location.pathname}?${params.toString()}`;
                    window.location.href = url;
                }, 800);
            });
            
            // Favorite button animation
            const favoriteButtons = document.querySelectorAll('.favorite-btn');
            
            favoriteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const icon = this.querySelector('i');
                    
                    if (icon.classList.contains('fas')) {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        this.style.animation = 'none';
                        void this.offsetWidth; // Trigger reflow
                        this.style.animation = 'pulse 0.5s';
                    } else {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        this.style.animation = 'none';
                        void this.offsetWidth; // Trigger reflow
                        this.style.animation = 'pulse 0.5s';
                    }
                    
                    // Here you would typically make an AJAX call to update favorites
                });
            });
            
            // Add floating hearts animation
            function createHeart() {
                const heart = document.createElement('div');
                heart.classList.add('heart');
                heart.innerHTML = '<i class="fas fa-heart"></i>';
                heart.style.left = Math.random() * 100 + 'vw';
                heart.style.animationDuration = Math.random() * 10 + 10 + 's';
                document.querySelector('.floating-hearts').appendChild(heart);
                
                setTimeout(() => {
                    heart.remove();
                }, 15000);
            }
            
            setInterval(createHeart, 500);
        });
    </script>
@endsection