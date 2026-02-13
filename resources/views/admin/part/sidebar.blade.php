<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('uploads/logo/logo5.png') }}" style="height: 4rem;" alt="">
            </span>
            
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item active">
            <a href="{{route('admin.dashboard')}}" class="menu-link ">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboards">Dashboards</div>

            </a>

        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Restaurant Manager</span>
        </li>
        <!-- Food Manager -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-bowl-hot"></i>
                <div data-i18n="Layouts">Food Management</div>
            </a>

            <ul class="menu-sub">
              
                <li class="menu-item">
                    <a href="{{route('admin.food.category')}}" class="menu-link">
                        <div>All Category</div>
                    </a>
                </li>
               
                <li class="menu-item">
                    <a href="{{route('admin.offer')}}" class="menu-link">
                        <div>Offers</div>
                    </a>
                </li>

            </ul>
        </li>
        <!-- Order Manager -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cart"></i>

                <div data-i18n="Layouts">Order Management</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{route('admin.all.order')}}" class="menu-link">
                        <div>All Order</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('admin.food.reviews')}}" class="menu-link">
                        <div>Customer Reviews</div>
                    </a>
                </li>


            </ul>
        </li>



        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Customer Manager</span>
        </li>
        <!-- Order Manager -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>

                <div >Customers</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{route('admin.all.customers')}}" class="menu-link">
                        <div>All Customer</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="" class="menu-link">
                        <div>Reports</div>
                    </a>
                </li>


            </ul>
        </li>
       
        <!-- vendor Manager -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-building"></i>

                <div >Vendors</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{route('admin.all.vendor')}}" class="menu-link">
                        <div>All Vendors</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('vendors.show.document')}}" class="menu-link">
                        <div>Vendors Document</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('admin.all.winorder')}}" class="menu-link">
                        <div>WinOrder APIs</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Delivery Partner Manager -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>

                <div >Delivery Partners</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{route('admin.all.courier.applications')}}" class="menu-link">
                        <div>All Applications</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('all.courier.partner')}}" class="menu-link">
                        <div>All Partners</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Financial Manager -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-wallet"></i>

                <div >Finance Manager</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{route('admin.payment.ladger')}}" class="menu-link">
                        <div>Ladger</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.all.revenue.vendor') }}" class="menu-link">
                        <div>Revenue Manager</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.payment.history') }}" class="menu-link">
                        <div>Payout History</div>
                    </a>
                </li>


            </ul>
        </li>
        <!-- Website Manager -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-globe"></i>

                <div>Website Manager</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{route('admin.home-slider')}}" class="menu-link">
                        <div>Home Slider</div>
                    </a>
                </li>
               
            </ul>
        </li>
    </ul>
</aside>
