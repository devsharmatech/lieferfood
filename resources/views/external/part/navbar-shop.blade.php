<style>
    #searchInput {
        transition: opacity 0.3s ease, visibility 0.3s ease;

    }

    .ms-3 {
        margin-left: 1rem !important;
    }

    .switch-container {
        position: relative;
        width: 260px;
        height: 40px;
        border: 1px solid #ddd;
        border-radius: 30px;
        background: rgba(0, 0, 0, 0.1);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: width 0.3s ease;
    }

    .switch-container .switch-label {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        letter-spacing: 1px;
        color: #000;
        transition: color 0.3s ease;
    }

    .switch-container .switch-label.pickup {
        right: 0;
    }

    .switch-container .switch-label.delivery {
        left: 0;
    }

    .switch-container .switch-slider {
        position: absolute;
        font-size: 18px !important;
        left: 0;
        width: 130px;
        height: 100%;
        background: white;
        border-radius: 30px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .switch-container.checked .switch-slider {
        transform: translateX(130px);
    }

    .switch-container.checked .switch-label.pickup {
        color: #aaa;
    }

    .switch-container.checked .switch-label.delivery {
        color: #000;
    }

    /* Hidden checkbox */
    .switch-container input[type="checkbox"] {
        display: none;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light px-0 px-md-3" data-navbar-on-scroll="data-navbar-on-scroll">
    <div class="container-fluid px-0 mx-0">
        <a class="navbar-brand d-inline-flex me-0" id="logolt" href="{{ route('home') }}">
            <img class="d-inline-block" src="{{ asset('uploads/logo/logo5.png') }}" alt="logo" style="height: 4rem;" />
        </a>
        <div class="d-flex align-items-center  justify-content-center mx-sm-auto" id="searchcont">
            <!-- Search Icon -->
            <span class="input-group-icon-2 me-2 d-block" id="toggleSearchIcon">
                <i class="fa-solid fa-magnifying-glass fs-2 text-dark"></i>
            </span>

            <!-- Search Input -->
            <div class="input-group d-none mx-2" id="searchInput" style="border-radius: 50px; overflow: hidden;">
    <span id="closeSearch" class="input-group-text bg-primary d-none px-3" style="cursor: pointer; border-radius: 50px 0 0 50px;">
        <i class="fa-solid fa-times fs-2 text-light"></i>
    </span>
    <input class="form-control px-3 bg-white input" 
           value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}" 
           name="search" type="search" placeholder="Search" 
           style="border-radius: 0;">
    <span class="input-group-text bg-primary px-3" style="border-radius: 0 50px 50px 0;">
        <i class="fa-solid fa-magnifying-glass fs-2 text-light"></i>
    </span>
</div>




            <!-- Filter Icon -->
            <span class="input-group-icon-2 ms-2 d-md-none d-block" id="ftl" data-bs-toggle="modal"
                data-bs-target="#filtermodal">
                <i class="fa-solid fa-sliders text-dark fs-2"></i>
            </span>
        </div>
        <div id="toggt" class="d-flex justify-content-between order-lg-2  order-1 justify-content-md-center ">
            <a href="{{ route('home') }}" id="location-btn"
                class=" top-btn  d-lg-flex align-items-center d-none me-3 bg-white border-0 p-0 outline-0">
                <i class="fa-solid me-2 fa-location-dot text-dark d-md-block d-none"></i>
                <span id="location-display">6345 Griesheim</span>
                <input id="place-input" type="text" placeholder="Enter a location"
                    class=" border-0 bg-transparent form-control d-none" style="width: 300px;" />
                <i class="fa-solid ml-2 fa-chevron-down d-block d-md-none"
                    style="font-size: 12px; margin-left:5px;"></i>
            </a>
            <button class="country-btn me-3" id="countryLangButton" data-bs-toggle="modal"
                data-bs-target="#countryLangModal">
                <img src="https://flagcdn.com/256x192/us.png" id="currentFlag" alt="Country Flag">
            </button>

            <button class="btn btn-white text-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                type="button">
                <i class="fa fa-bars fs-2"></i>
            </button>

        </div>
        <div
            class="d-flex justify-content-center order-lg-1 mx-auto order-2 justify-content-xl-end mt-xl-0 mt-2 w-100 w-lg-auto">
            <div class="d-flex justify-content-center w-100">
                <div class="switch-container" id="switch-container">
                    <input type="checkbox" id="switch-checkbox" class="input" name="service_type" value="0"
                        @checked(isset($_GET['service_type']) && $_GET['service_type'] == 0)>
                    <div class="switch-label delivery" id="delivery-label">🚚 Delivery</div>
                    <div class="switch-label pickup" id="pickup-label">🧺 Pickup</div>
                    <div class="switch-slider" id="switch-slider">🚚 Delivery</div>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2 fw-bolder" id="staticBackdropLabel">My account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row ">
                    @if (isset(auth()->user()->name))
                        <div class="col-md-6">
                            <a href="@if (auth()->user()->role == 'user') {{ route('myaccount') }}
                                @elseif (auth()->user()->role == 'vendor')
                                    {{ route('vendor.dashboard') }}
                                @elseif (auth()->user()->role == 'admin')
                                    {{ route('admin.dashboard') }} @endif"
                                class="btn btn-primary  w-100">
                                <i class="fa fa-user" aria-hidden="true"></i> My Account
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('logout') }}" class="btn btn-light fw-bold text-dark fs-1 w-100">
                                <i class="fa fa-lock" aria-hidden="true"></i> Logout
                            </a>
                        </div>
                    @else
                        <div class="col-md-6">
                            <a href="{{ route('login') }}" class="btn btn-light fw-bold text-dark fs-1 w-100">
                                Sign in
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('register') }}" class="btn fs-1 btn-warning w-100">
                                Create account
                            </a>
                        </div>
                    @endif


                    <div class="col-md-12 ">
                        <a href="{{ route('myaccount') }}?opt=orders" class="btn btn-light text-start w-100 mt-3 fw-bold text-dark fs-1">
                            <i class="fa-solid fa-bag-shopping me-2"></i>
                            Order
                        </a>
                        <a href="#" class="btn btn-light d-none text-start w-100 mt-1 fw-bold text-dark fs-1">
                            <i class="fa-regular fa-heart me-2"></i>
                            Favourites
                        </a>
                        <hr>
                        <a href="#" class="btn btn-light d-none text-start w-100 mt-1 fw-bold text-dark fs-1">
                            <i class="fa-solid fa-gift me-2"></i>
                            Punkte
                        </a>
                        <a href="#" class="btn btn-light d-none align-items-center text-start w-100 mt-1 fw-bold text-dark fs-1">
                            <i class="fa-solid fa-percent me-2"></i>

                            StampCards
                        </a>
                        <a href="#" class="btn btn-light d-none text-start w-100 mt-1 fw-bold text-dark fs-1">
                            <i class="fa-solid fa-circle-info me-2"></i>
                            Need Help?
                        </a>
                        <a href="#" class="btn btn-light d-none text-start w-100 mt-1 fw-bold text-dark fs-1">
                            <i class="fa-solid fa-gift me-2"></i>
                            Gift Cards
                        </a>
                        <hr>
                        <a href="{{ route('courier-service') }}" class="btn btn-light text-start fw-bold text-dark fs-1 w-100 mt-1">
                            <i class="fa-solid fa-bicycle me-2"></i>
                            Become a Courier
                        </a>
                        <a href="{{ route('business-service') }}" class="btn btn-light text-start fw-bold text-dark fs-1 w-100 mt-1">
                            <i class="fa-solid fa-building me-2"></i>
                            Corporat Ordering
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<script>
    const toggleSearchIcon = document.getElementById('toggleSearchIcon');
    const searchInput = document.getElementById('searchInput');
    const closeSearch = document.getElementById('closeSearch');
    const toggtElement = document.getElementById('toggt');
    const logolt = document.getElementById('logolt');
    const ftl = document.getElementById('ftl');
    const searchcont = document.getElementById('searchcont');


    toggleSearchIcon.addEventListener('click', function() {
        searchInput.classList.remove('d-none');
        searchcont.classList.add('w-100');
        closeSearch.classList.remove('d-none');
        toggtElement.classList.add('d-none');
        ftl.classList.add('d-none');
        toggleSearchIcon.classList.add('d-none');
        logolt.classList.add('d-none');
        searchInput.focus();
    });


    closeSearch.addEventListener('click', function() {
        searchInput.value = '';
        searchInput.classList.add('d-none');
        searchcont.classList.remove('w-100');
        closeSearch.classList.add('d-none');
        toggleSearchIcon.classList.remove('d-none');
        toggtElement.classList.remove('d-none');
        logolt.classList.remove('d-none');
        ftl.classList.remove('d-none');
    });
</script>
