<nav id="navbar" class="navbar navbar-expand-lg navbar-white bg-white " data-navbar-on-scroll="data-navbar-on-scroll" style="z-index: 1030;">
    <div class="container-fluid">
        <a class="navbar-brand d-inline-flex" href="{{ route('home') }}">
            <img class="d-inline-block" src="{{ asset('uploads/logo/logo5.png') }}" alt="logo"
                style="height: 4rem;" />
        </a>
        <div class="d-flex">
            <a href="{{ route('business-service') }}" class="btn btn-light d-md-flex align-items-center d-none">
                <i class="fa me-2 fa-building"></i> Corporate Ordering
            </a>
            <a href="{{ route('courier-service') }}" class="btn btn-light d-md-flex align-items-center d-none">
                <i class="fa fw-bolder fs-1 me-2 fa-bicycle"></i>
                Become a courier
            </a>
            <button class="country-btn" id="countryLangButton" data-bs-toggle="modal"
                data-bs-target="#countryLangModal">
                <img src="https://flagcdn.com/256x192/us.png" id="currentFlag" alt="Country Flag">
            </button>
            <button class="btn btn-white text-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                type="button">
                <i class="fa fa-bars fs-2"></i>
            </button>
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
                            <a href="{{ route('logout') }}" class="btn btn-light fw-bold text-dark fs-1  w-100">
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
                        <a href="{{ route('myaccount') }}?opt=orders" class="btn btn-light fw-bold text-dark fs-1 text-start w-100 mt-3 ">
                            <i class="fa-solid fa-bag-shopping me-2"></i>
                            Order
                        </a>
                        <a href="{{route('user.getFavoritesRestaurants')}}" class="btn btn-light fw-bold text-dark fs-1 text-start w-100 mt-1">
                            <i class="fa-regular fa-heart me-2"></i>
                            Favourites
                        </a>
                        <hr>
                        <a href="#" class="btn btn-light text-start fw-bold text-dark fs-1 w-100 mt-1">
                            <i class="fa-solid fa-gift me-2"></i>
                            Punkte
                        </a>
                        <a href="#" class="btn btn-light d-flex align-items-center text-start fw-bold text-dark fs-1 w-100 mt-1">
                            <i class="fa-solid fa-percent me-2"></i>

                            StampCards
                        </a>
                        <a href="#" class="btn btn-light text-start w-100 mt-1">
                            <i class="fa-solid fa-circle-info me-2"></i>
                            Need Help?
                        </a>
                        <a href="#" class="btn btn-light text-start w-100 mt-1">
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
