@extends('external.frame')
@section('external-css')
    <style>
       

        
        .error-toast {
            position: fixed;
            top: 0% !important;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(220, 53, 69, 0.9);
            color: #fff;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 18px !important;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease-out;
        }

        #toast-container {
            position: fixed;
            top: 0% !important;
            left: 50%;
            transform: translateX(-50%);
        }

        .toast-message {
            font-size: 18px !important;
        }

        #toast-container .toast-close-button {
            position: absolute !important;
            cursor: pointer;
            font-weight: bold;
            line-height: 1;
            border: none;
            background: transparent;
            color: #fff;
            font-size: 25px;
            top: 50%;
            right: 2% !important;
            transform: translateY(-50%);
        }

        .error-toast.hide {
            opacity: 0;
            transition: opacity 0.5s ease-out;
        }
 .autocomplete-suggestions {
            position: absolute;
            background: #fff;
            border: 1px solid #ddd;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            max-height: 250px;
            overflow-y: auto;
            z-index: 1000;
            -webkit-overflow-scrolling: touch;
            width: 100%;
            display: none;
           
            border-radius: 10px;

        }
        .autocomplete-suggestions div {
            padding: 12px;
            font-size: 16px;
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

       
        #home.home-section {

            max-height: 70vh;
            margin-top: 80px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            
        }


        
        #home .home-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

       
        #home .home-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

       
        #home .home-content {
            z-index: 2;
            color: white;
            padding: 1rem;
            max-width: 900px;
        }

       
        #home .home-message {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        #home .home-submessage {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        
        #home .home-search-form {
            max-width: 600px;
            margin: 0 auto;
        }

        #home .input-group {
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

      
        #home .home-search-input {
            height: 3rem;
            border: none;
            outline: none;
            padding: 0 1rem;
            font-size: 1rem;
            border-top-left-radius: 50px;
            border-bottom-left-radius: 50px;
            box-shadow: none !important;
        }

        
        #home .home-search-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5);
        }

       
        #home .home-search-button {
            height: 3rem;
            padding: 0 1rem;
            font-size: 1rem;
            color: white;
            border: none;
            border-top-right-radius: 50px;
            border-bottom-right-radius: 50px;
            transition: background-color 0.3s;
        }

        .btn-success{
            background-color: green !important;
        }

        
        @media (max-width: 768px) {
            .autocomplete-suggestions div {
                padding: 8px;
                font-size: 14px;
            }

            #home.home-section {
                max-height: 50vh;
            }

            #home .home-message {
                font-size: 2rem;
            }

            #home .home-submessage {
                font-size: 1rem;
            }

            #home .home-search-input {
                font-size: 0.9rem;
                padding: 0 0.75rem;
            }

            #home .home-search-button {
                font-size: 0.9rem;
                padding: 0 1rem;
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

        #pizzaimg {

            animation: spin 8s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .food-img {
            width: 100%;
            max-height: 20rem;
            border-radius: 10px;
            overflow: hidden;
        }

        .food-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            border-radius: 10px;
        }

        #home::after {
            bottom: -2px;
            position: absolute;
            content: "";
            width: 100%;
            height: 85px;
            left: 0;
            z-index: 1;
            background: url({{ asset('overlay-bottom.png') }}) bottom center no-repeat;
            background-size: contain;
        }

        .steps1::before {
            bottom: -2px;
            position: absolute;
            content: "";
            width: 100%;
            height: 85px;
            left: 0;
            z-index: 1;
            background: url({{ asset('overlay-bottom.png') }}) bottom center no-repeat;
            background-size: contain;
        }

        #steps::after {
            top: -2px;
            position: absolute;
            content: "";
            width: 100%;
            height: 85px;
            transform: rotate(180deg);
            left: 0;
            z-index: 1;
            background: url("{{ asset('overlay-bottom.png') }}") bottom center no-repeat;
            background-size: contain;
        }
        
        .video-container {
    top: 0;
    left: 0;
    overflow: hidden;
    z-index: -1;
}

.home-video {
    object-fit: cover;
}

.video-overlay {
    background-color: rgba(0, 0, 0, 0.3);
    pointer-events: none; /* Allows clicks to pass through */
    top: 0;
    left: 0;
    z-index: 1;
}

.home-overlay {
    /* Your existing overlay styles */
    z-index: 2; /* Above video overlay but below content */
}

.home-content {
    z-index: 3; /* Above both overlays */
}
    </style>
    <style>
   
    .clear-input-icon {
        right: 90px !important;
    }
    
    @media (min-width: 992px) {
        .clear-input-icon {
            right: 8.8rem !important;
        }
    }

    /* Why Choose Us Section */
    .feature-card {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        padding: 2.5rem 1.5rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
        height: 100%;
    }
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
    }
    .feature-icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }
    .icon-fast { background: #ffe4e6; color: #e11d48; }
    .icon-price { background: #dcfce7; color: #16a34a; }
    .icon-fresh { background: #fef08a; color: #ca8a04; }
    .icon-support { background: #dbeafe; color: #2563eb; }

    /* Deals Banner */
    .deals-banner {
        background: linear-gradient(135deg, var(--brand-primary, #f41909), var(--brand-dark, #cc1508));
        border-radius: 25px;
        color: white;
        overflow: hidden;
        position: relative;
    }
    .deals-banner::after {
        content: '';
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        background: url('https://www.transparenttextures.com/patterns/food.png');
        opacity: 0.1;
        pointer-events: none;
    }
    .deal-badge {
        background: #fff;
        color: var(--brand-dark, #cc1508);
        padding: 0.5rem 1rem;
        border-radius: 30px;
        font-weight: 800;
        font-size: 0.9rem;
        display: inline-block;
        margin-bottom: 1rem;
    }

    /* Top Rated Section */
    .top-rated-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .top-rated-card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }
    .rating-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #fbbf24;
        color: #fff;
        font-weight: bold;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 5px;
        z-index: 10;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
</style>
@endsection
@section('external-home-content')
    <section id="home" class="home-section mt-0 py-md-5 py-3 position-relative">
    <!-- Video container with overlay solution -->
    <div class="video-container position-absolute w-100 h-100">
        <video autoplay muted loop playsinline class="home-video w-100 h-100">
            <source src="{{ asset('uploads/home-bg.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <!-- Overlay to prevent iOS play button -->
        <div class="video-overlay position-absolute w-100 h-100"></div>
    </div>
    
    <!-- Content overlay -->
    <div class="home-overlay"></div>
    <div class="home-content py-5  pt-2  pb-4 position-relative">
        <h1 class="home-message text-center text-light mb-0">Discover Delicious Meals Nearby</h1>
        <p class="home-submessage text-center mb-1">Search and order from the best restaurants in your area.</p>
        <form class="home-search-form position-relative mt-2 flex-column d-flex justify-content-center align-items-center" action="{{ route('shop') }}">
    

    <div class="input-group position-relative">
        <input type="text" class="form-control home-search-input fw-bold"
            style="padding-left:1rem !important; -webkit-appearance: textfield;font-size:1.2rem;color:#000; "
            placeholder="Please give your full address."
            id="place-input" name="location" required autocomplete="off" />

        <i class="fa-solid fa-times clear-input-icon position-absolute justify-content-center align-items-center rounded-circle"
           style="right: 100px !important; top: 50%; transform: translateY(-50%); cursor: pointer; display: none; z-index: 10; color: #000; border:1px solid red;height:25px !important; width:25px !important"></i>

        <button class="btn btn-primary d-flex align-items-center justify-content-center home-search-button disabled" disabled id="search-loc"
            type="submit"> <i class="fa-solid fa-location-dot me-2"></i> Search </button>
    </div>
    
     <div class="text-center bg-white position-relative rounded-pill mt-3 py-1 px-3" style="width:fit-content;">
        <span id="getMyAddress" style="cursor:pointer; color:red; font-size:1.1rem;">
            <i class="fa-solid fa-location-crosshairs me-2" ></i> Click here get current location
        </span>
    </div>
    <!-- Combined Suggestions + History -->
    <div id="location-dropdown" class="location-dropdown-card text-dark"></div>
</form>

<style>
.location-dropdown-card {
    position: absolute;
    top: 47%;
    left: 0;
    right: 0;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #fff;
    max-height: 300px;
    overflow-y: auto;
    z-index: 999;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    display: none;
}
.location-dropdown-card div {
    padding: 10px 15px;
    cursor: pointer;
    border-bottom: 1px solid #f1f1f1;
    display: flex !important;
}
.location-dropdown-card div:last-child {
    border-bottom: none;
}
.location-dropdown-card div:hover {
    background-color: #f2f2f2;
}
.location-dropdown-card .dropdown-header {
    font-weight: 800;
    color: red;
    font-size: 1.2rem;
    background-color: #f9f9f9;
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('place-input');
    const clearIcon = document.querySelector('.clear-input-icon');
    
    // Show/hide clear icon based on input
    searchInput.addEventListener('input', function() {
        clearIcon.style.display = this.value.length > 0 ? 'flex' : 'none';
    });
    
    // Clear input when icon is clicked
    clearIcon.addEventListener('click', function() {
        searchInput.value = '';
        clearIcon.style.display = 'none';
        searchInput.focus();
    });
    
    // Also check on focus in case value was changed programmatically
    searchInput.addEventListener('focus', function() {
        clearIcon.style.display = this.value.length > 0 ? 'fles' : 'none';
    });
});
</script>
    </div>
</section>

    <section id="testimonial" class="pt-4 pb-0">
        <div class="container-fluid">
            <div class="row h-100">
                <div class="col-lg-7 mx-auto text-center ">
                    <h5 class="fw-bold fs-3 fs-lg-5 lh-sm mb-3 d-flex align-items-center justify-content-center">
                               <a href="javaScript:void(0)" class="text-primary me-3 d-flex align-items-center justify-content-center" id="featured_left"> <i
                                class="fa-solid fa-chevron-left fs-4" aria-hidden="true"></i> </a> 
                                Featured Restaurants
                                
                                 <a href="javaScript:void(0)" style="margin-left:15px;" class="text-primary d-flex align-items-center justify-content-center" id="featured_right"> <i
                                class="fa-solid fa-chevron-right fs-4 " aria-hidden="true"></i> </a>
                                </h5>
                </div>
                
            </div>
            <div class="row gx-2 owl-carousel featured_items">
                @foreach ($featureds as $featured)
                    <a href="{{ route('shop.view', $featured->unid) }}" class="card card-span h-100 text-white rounded-3">
                        <img class="img-fluid rounded-3 h-100" src="{{ asset('uploads/users/' . $featured->profile) }}"
                            alt="..." style="height:9rem !important;" />

                        <div class="card-body px-1">
                            <div class="d-flex align-items-center mb-3">

                                <div class="w-100">
                                    <h6 class="mb-0 fw-bold text-1000 text-center fs-1">{{ $featured->name }}</h5>
                                </div>
                            </div>

                        </div>
                    </a>
                @endforeach


            </div>
        </div>
    </section>
    <section class="py-4 pt-0 overflow-hidden">

        <div class="container-fluid">
            <div class="row h-100">
                <div class="col-lg-7 mx-auto text-center ">
                    <h5 class="fw-bold fs-3 fs-lg-5 lh-sm d-flex align-items-center justify-content-center">
                        <a href="javaScript:void(0)" class="text-primary me-3 d-flex align-items-center justify-content-center" id="popular_left"> <i
                                class="fa-solid fa-chevron-left fs-4" aria-hidden="true"></i> </a>
                        Popular Restaurants
                        <a href="javaScript:void(0)" class="text-primary d-flex align-items-center justify-content-center" style="margin-left:15px;" id="popular_right"> <i
                                class="fa-solid fa-chevron-right fs-4" aria-hidden="true"></i> </a>
                    </h5>
                </div>
                <div class="col-12">
                    
                    <div class="owl-carousel popular_items">
                        @foreach ($vendors as $item)
                            <a href="{{ route('shop.view', $item->unid) }}" class="card card-span h-100 rounded-3">

                                @if (Str::startsWith($item->image, 'http'))
                                    <img src="{{ $item->profile }}" class="img-fluid rounded-3 h-100"
                                        alt="{{ $item->name }}" style="height:9rem !important;">
                                @else
                                    <img src="{{ asset('uploads/users/' . $item->profile) }}"
                                        class="img-fluid rounded-3 h-100" alt="{{ $item->name }}"
                                        style="height:9rem !important;">
                                @endif
                                <div class="card-body ps-0 text-center">
                                    <h5 class="fw-bold text-primary  text-truncate mb-1 fs-1">
                                        {{ $item->name }}</h5>

                                    <span class="text-1000 fw-bold d-flex gap-2 justify-content-center"
                                        style="font-size:15px;"><span>Minimum</span>
                                        &euro;{{ isset($item->vendor_details->minimum_price) ? $item->vendor_details->minimum_price : '20' }}</span>
                                </div>
                               
                            </a>
                        @endforeach
                    </div>

                </div>
                <div class="col-12 d-flex justify-content-center fw-bold mt-4"> <a class="btn fw-bold btn-lg btn-primary"
                        href="{{ route('shop') }}">Show All Shops<i class="fas fa-chevron-right ms-2"> </i></a></div>
            </div>

        </div><!-- end of .container-->

    </section>

    <section class=" pt-4 overflow-hidden pb-0 d-none">

        <div class="container-fluid">
            <div class="row flex-center ">
                <div class="col-lg-12">
                    <h5 class="fw-bold fs-3 fs-lg-5 lh-sm text-center">Search by Food</h5>
                </div>


            </div>
            <div class="row flex-center">
                <div class="col-12">
                    <div class="d-flex justify-content-center mt-2">
                        <a href="javaScript:void(0)" class="text-primary me-2" id="popular_left1"> <i
                                class="fa-solid fa-chevron-left fs-4" aria-hidden="true"></i> </a>
                        <a href="javaScript:void(0)" class="text-primary" id="popular_right1"> <i
                                class="fa-solid fa-chevron-right fs-4" aria-hidden="true"></i> </a>
                    </div>
                    <div class="owl-carousel search_foods">
                        @foreach ($items as $food)
                            <div class="card card-span h-100 rounded-circle">
                                @if (isset($food->image) && !empty($food->image))
                                    <img src="{{ asset('uploads/menu/' . $food->image) }}"
                                        class="img-fluid rounded-3 h-100" alt="{{ $food->food_item_name }}"
                                        style="height:9rem !important;">
                                @else
                                    <img src="{{ asset('uploads/foodu.png') }}" class="img-fluid rounded-3 h-100"
                                        alt="{{ $food->food_item_name }}" style="height:9rem !important;">
                                @endif
                                <div class="card-body ps-0">
                                    <h5 style="font-size: 14px;" class="text-center fw-bold text-1000 text-truncate mb-2">
                                        {{ $food->food_item_name }}
                                    </h5>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div><!-- end of .container-->

    </section>
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

    <!-- Why Choose Lieferfood Section -->
    <section class="py-4 bg-light mt-4">
        <div class="container-fluid">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-6 text-center">
                    <h5 class="fw-bold fs-3 fs-lg-5 lh-sm text-dark mb-2">Why Choose Lieferfood?</h5>
                    <p class="text-dark fs-1 mb-0">We bring you the best culinary experiences with unmatched convenience.</p>
                </div>
            </div>
            <div class="row g-4 px-lg-5">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card text-center text-dark">
                        <div class="feature-icon-wrapper icon-fast mb-2">
                            <i class="fas fa-shipping-fast fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Lightning Fast</h4>
                        <p class="text-dark mb-0">Experience delivery in under 30 minutes. Your food arrives hot and fresh.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card text-center text-dark">
                        <div class="feature-icon-wrapper icon-price mb-2">
                            <i class="fas fa-tags fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Best Prices</h4>
                        <p class="text-dark mb-0">No hidden fees or sneaky surcharges. Enjoy your meals at the best value.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card text-center text-dark">
                        <div class="feature-icon-wrapper icon-fresh mb-2">
                            <i class="fas fa-utensils fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Premium Quality</h4>
                        <p class="text-dark mb-0">We partner only with top-rated local chefs and highly reviewed restaurants.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card text-center text-dark">
                        <div class="feature-icon-wrapper icon-support mb-2">
                            <i class="fas fa-headset fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-2">24/7 Support</h4>
                        <p class="text-dark mb-0">Got a problem? Our dedicated customer happiness team is always awake.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Deals Banner Section -->
    <section class="py-5">
        <div class="container-fluid px-lg-6">
            <div class="deals-banner p-4 p-md-5 d-flex flex-column flex-lg-row align-items-center justify-content-between shadow-lg">
                <div class="mb-4 mb-lg-0 text-center text-lg-start z-index-1" style="z-index: 2;">
                    <div class="deal-badge"><i class="fas fa-gift me-2"></i>LIMITED TIME OFFER</div>
                    <h2 class="display-5 fw-bolder text-white mb-2" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">Craving Something Special?</h2>
                    <p class="fs-2 text-white opacity-75 mb-0">Get exactly what you want, delivered straight to your door.</p>
                </div>
                <div style="z-index: 2;">
                    <a href="{{ route('shop') }}" class="btn btn-light btn-lg fw-bold rounded-pill px-5 py-3 shadow">
                        Explore Menus <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Rated Restaurants Section -->
    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row h-100">
                <div class="col-lg-7 mx-auto text-center mb-4">
                    <h5 class="fw-bold fs-3 fs-lg-5 lh-sm d-flex align-items-center justify-content-center">
                        <a href="javaScript:void(0)" class="text-primary me-3 d-flex align-items-center justify-content-center" id="top_rated_left"> 
                            <i class="fa-solid fa-chevron-left fs-4" aria-hidden="true"></i> 
                        </a>
                        Top Rated Customers Picks <i class="fas fa-star text-warning ms-3"></i>
                        <a href="javaScript:void(0)" class="text-primary d-flex align-items-center justify-content-center" style="margin-left:15px;" id="top_rated_right"> 
                            <i class="fa-solid fa-chevron-right fs-4" aria-hidden="true"></i> 
                        </a>
                    </h5>
                    <p class="text-muted">The highest reviewed restaurants in your area.</p>
                </div>
                <div class="col-12">
                    <div class="owl-carousel top_rated_items">
                        {{-- 
                            For now, we will reuse the $vendors array, but in a real-world scenario, 
                            this should be sorted by average rating from the controller ($topRatedVendors). 
                        --}}
                        @foreach ($vendors->take(8) as $item)
                            <a href="{{ route('shop.view', $item->unid) }}" class="card top-rated-card h-100 rounded-4 text-decoration-none">
                                <div class="position-relative">
                                    <div class="rating-badge">
                                        {{-- Mocking a high rating for visual presentation --}}
                                        <i class="fas fa-star"></i> {{ number_format(rand(45, 50) / 10, 1) }}
                                    </div>
                                    @if (Str::startsWith($item->image, 'http'))
                                        <img src="{{ $item->profile }}" class="card-img-top h-100" alt="{{ $item->name }}" style="height: 200px !important; object-fit: cover; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                    @else
                                        <img src="{{ asset('uploads/users/' . $item->profile) }}" class="card-img-top h-100" alt="{{ $item->name }}" style="height: 200px !important; object-fit: cover; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                    @endif
                                </div>
                                <div class="card-body text-center bg-white">
                                    <h5 class="fw-bold text-dark text-truncate mb-2 fs-2">{{ $item->name }}</h5>
                                    @if(isset($item->vendor_details->category))
                                        <p class="text-muted small mb-2">{{ $item->vendor_details->category }}</p>
                                    @endif
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <span class="badge bg-light text-dark border"><i class="fas fa-motorcycle text-primary me-1"></i> 30-40 min</span>
                                        <span class="text-success fw-bold fs-0">Min &euro;{{ isset($item->vendor_details->minimum_price) ? $item->vendor_details->minimum_price : '20' }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-0" id="steps">
        <div class="bg-holder"  style="background-image:url({{ asset('uploads/ft-banner2.jpg') }});background-position:center;background-size:fill;">
        </div>
        <div class="container ads-info">
            <div class="row flex-center">
                <div class="col-xxl-9 py-7 text-center">
                    <h1 class="fw-bold  mb-4 text-white fs-6" style="text-shadow:3px 2px 4px black;">Are you ready to order <br />with the best deals? </h1><a
                        class="btn btn-danger" href="#"> PROCEED TO ORDER<i
                            class="fas fa-chevron-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('external-js')
    <script>
        $(function() {
            // Owl Carousel
            var owl = $(".sliderhome");
            owl.owlCarousel({
                items: 1,
                margin: 10,
                autoplay: true,
                delay: 1500,
                loop: true,
                nav: false,
                dots: false,
                lazyLoad: true,
                animateOut: 'fadeOut'
            });
        });
        $('.popular_items').owlCarousel({
            loop: true,
            margin: 20,
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1.5,
                    nav: false,
                },
                600: {
                    items: 4,
                    nav: false
                },
                1000: {
                    items: 6,
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

        $('.featured_items').owlCarousel({
            loop: true,
            margin: 20,
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1.5,
                    nav: false,
                },
                600: {
                    items: 4,
                    nav: false
                },
                1000: {
                    items: 6,
                    nav: false,
                    loop: false
                }
            }
        })
        var featured_items = $(".featured_items");
        featured_items.owlCarousel();
        $("#featured_right").click(function() {
            featured_items.trigger("next.owl.carousel");
        });
        $("#featured_left").click(function() {
            featured_items.trigger("prev.owl.carousel");
        });
        $("#featured_left").addClass("disabled");
        $(featured_items).on("translated.owl.carousel", function(event) {
            if ($(".owl-prev").hasClass("disabled")) {
                $("#featured_left").addClass("disabled");
            } else {
                $("#featured_left").removeClass("disabled");
            }
            if ($(".owl-next").hasClass("disabled")) {
                $("#featured_left").addClass("disabled");
            } else {
                $("#featured_right").removeClass("disabled");
            }
        });

        // Top Rated Carousel
        $('.top_rated_items').owlCarousel({
            loop: true,
            margin: 20,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            responsiveClass: true,
            responsive: {
                0: { items: 1.2, nav: false },
                600: { items: 3, nav: false },
                1000: { items: 4, nav: false, loop: true }
            }
        });
        var top_rated_items = $(".top_rated_items");
        $("#top_rated_right").click(function() { top_rated_items.trigger("next.owl.carousel"); });
        $("#top_rated_left").click(function() { top_rated_items.trigger("prev.owl.carousel"); });


        $('.search_foods').owlCarousel({
            loop: true,
            margin: 20,
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1.5,
                    nav: false,
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
    </script>

   
<script>
const searchButton = document.getElementById('search-loc');
const input = document.getElementById('place-input');
const dropdown = document.getElementById('location-dropdown');

/* ---------- Show error ---------- */
function showError(message) {
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            positionClass: 'toast-top-center',
            timeOut: 20000,
            closeButton: true,
            extendedTimeOut: 2000,
            tapToDismiss: false
        };
        toastr.error(message);
    } else {
        alert(message);
    }
}

/* ---------- Validate Postcode ---------- */
function validatePostCode(locationData) {
    searchButton.disabled = true;
    searchButton.classList.add('disabled', 'btn-primary');
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
        success: function(response) {
            if (response.status) {
                searchButton.disabled = false;
                searchButton.classList.remove('disabled', 'btn-primary');
                searchButton.classList.add('btn-success');
                localStorage.setItem("location_saved", "true");
                localStorage.setItem("selected_address_id",null)
            } else {
                showError(response.message || 'This location is not serviceable');
            }
        },
        error: function(err) {
            console.error(err);
            showError('Error validating location');
        }
    });
}

/* ---------- Save last 4 searches ---------- */
function saveLocationToLocalStorage(locationData) {
    let history = JSON.parse(localStorage.getItem('location_history')) || [];
    const address = { label: locationData.label || input.value, data: locationData };

    // Remove duplicates
    history = history.filter(item => item.label !== address.label);
    history.unshift(address);
    
    if (history.length > 4) history = history.slice(0, 4);
    localStorage.setItem('location_history', JSON.stringify(history));
    localStorage.setItem('location', JSON.stringify(locationData));
}

/* ---------- Format label without country ---------- */
function formatLabelWithoutCountry(place) {
    const street = extractComponent(place, 'route') || '';
    const streetNumber = extractComponent(place, 'street_number') || '';
    const postalCode = extractComponent(place, 'postal_code') || '';
    const city = extractComponent(place, 'locality') || extractComponent(place, 'postal_town') || '';
    const state = extractComponent(place, 'administrative_area_level_1') || '';

    let parts = [];
    if (street) parts.push(street + (streetNumber ? ' ' + streetNumber : ''));
    if (postalCode) parts.push(postalCode);
    if (city) parts.push(city);
    if (state) parts.push(state);

    return parts.join(', ');
}

/* ---------- Remove country from prediction description ---------- */
function formatPredictionLabel(description) {
    return description.replace(/,?\s*Germany$/, '').trim();
}

/* ---------- Render dropdown for suggestions + history ---------- */
function renderDropdown(predictions = []) {
    dropdown.innerHTML = '';
    const history = JSON.parse(localStorage.getItem('location_history')) || [];

    if (predictions.length) {
        const header = document.createElement('div');
        header.textContent = "Suggestions";
        header.classList.add('dropdown-header');
        dropdown.appendChild(header);

        predictions.forEach(prediction => {
            const div = document.createElement('div');
            div.textContent = formatPredictionLabel(prediction.description);
            div.dataset.placeId = prediction.place_id;

            div.addEventListener('click', () => {
                getPlaceDetails(prediction.place_id, prediction.description);
            });

            dropdown.appendChild(div);
        });
    }

    if (history.length) {
    const header = document.createElement('div');
    header.textContent = "Recent Searches";
    header.classList.add('dropdown-header');
    dropdown.appendChild(header);

    // --- CLEAR ALL BUTTON ---
    const clearAll = document.createElement('div');
    clearAll.innerHTML = "<span style='color:red; cursor:pointer; font-size:0.9rem;'>Clear All</span>";
    clearAll.style.textAlign = "right";
    clearAll.style.padding = "5px 15px";
    clearAll.style.borderBottom = "1px solid #eee";

    clearAll.addEventListener("click", function (event) {
        event.stopPropagation();
        localStorage.removeItem("location_history");
        renderDropdown([]); // Re-render
    });

    dropdown.appendChild(clearAll);

    // --- HISTORY ITEMS ---
    history.forEach((item, index) => {
        const div = document.createElement("div");
        div.classList.add("dropdown-item");
        div.style.position = "relative";

        // Map Marker
        const icon = document.createElement("span");
        if (index === 0) {
            icon.innerHTML = "<i class='fa fa-map-marker me-2' style='color:red !important;'></i>";
        } else {
            icon.innerHTML = "<i class='fa fa-map-marker me-2' style='color:#777;'></i>";
        }

        // Label
        const label = document.createElement("span");
        label.textContent = item.label;
        label.style.whiteSpace = "break-spaces";

        if (index === 0) {
            label.style.fontWeight = "700";
            label.style.color = "#111";
        } else {
            label.style.fontWeight = "400";
            label.style.color = "#333";
        }

        div.appendChild(icon);
        div.appendChild(label);

        // Delete (X) icon
        const deleteBtn = document.createElement("span");
        deleteBtn.innerHTML = "<i class='fa-solid fa-xmark'></i>";
        deleteBtn.style.position = "absolute";
        deleteBtn.style.right = "10px";
        deleteBtn.style.top = "50%";
        deleteBtn.style.transform = "translateY(-50%)";
        deleteBtn.style.cursor = "pointer";
        deleteBtn.style.color = "red";
        deleteBtn.style.fontSize = "1rem";

        div.appendChild(deleteBtn);

        // Delete single item
        deleteBtn.addEventListener("click", function (event) {
            event.stopPropagation();
            history.splice(index, 1);
            localStorage.setItem('location_history', JSON.stringify(history));
            renderDropdown([]);
        });

        // Select item
        div.addEventListener("click", function () {
            input.value = item.label;
            validatePostCode(item.data);
            dropdown.style.display = "none";
        });

        dropdown.appendChild(div);
    });
}



    dropdown.style.display = (predictions.length || history.length) ? 'block' : 'none';
}

/* ---------- Google Autocomplete ---------- */
function initAutocomplete() {
    if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
        console.error('Google Maps API not loaded');
        return;
    }

    const autocompleteService = new google.maps.places.AutocompleteService();
    const placesService = new google.maps.places.PlacesService(document.createElement('div'));

    input.addEventListener('input', debounce(() => {
        const value = input.value.trim();
        if (!value) return renderDropdown();

        autocompleteService.getPlacePredictions({
            input: value,
            componentRestrictions: { country: 'de' },
        }, function(predictions, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK && predictions) {
                renderDropdown(predictions);
            } else {
                renderDropdown();
            }
        });
    }, 300));

    input.addEventListener('focus', () => {
        renderDropdown(); // show history on focus
    });

    /* ---------- Get place details ---------- */
    window.getPlaceDetails = function(placeId, description) {
        placesService.getDetails({ placeId }, function(place, status) {
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

                if (!locationData.city || !locationData.postalCode) {
                    showError('Please enter valid city & postal code.');
                    return;
                }

                const label = formatLabelWithoutCountry(place);
                input.value = label;

                saveLocationToLocalStorage({ ...locationData, label });
                validatePostCode(locationData);
                dropdown.style.display = "none";
            } else {
                showError('Could not retrieve address details.');
            }
        });
    }

    /* ---------- Extract component helper ---------- */
    function extractComponent(place, type) {
        const component = place.address_components.find(c => c.types.includes(type));
        return component ? component.long_name : '';
    }

    /* ---------- Debounce helper ---------- */
    function debounce(func, wait) {
        let timeout;
        return function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, arguments), wait);
        };
    }
}

/* ---------- Load Google Maps API ---------- */
function loadGoogleMapsAPI() {
    if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyAonK15hotzDslX4ePjIbmizRii-7Ng4QE&libraries=places&callback=initAutocomplete`;
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

    placesService.getDetails({ placeId: placeId }, function(place, status) {
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

     $("#getMyAddress").on("click", function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

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

                        // Now validate like manual search
                        getPlaceDetails(placeId, address);
                    } else {
                        alert("Address not found.");
                    }
                }).fail(function () {
                    alert("Error fetching address.");
                });
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

@endsection
