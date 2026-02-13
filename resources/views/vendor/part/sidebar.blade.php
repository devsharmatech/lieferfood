<style>
    .menu-sub .menu-item a,.menu-sub .menu-item .menu-link{
        font-size: 17px !important;
    }
    .menu-vertical .menu-item .menu-link{
        font-size: 17px !important;
        padding: 7px 4px !important;
    }
    
</style>
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
            <a href="{{ route('vendor.dashboard') }}" class="menu-link ">
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
                    <a href="{{ route('vendor.all.category') }}" class="menu-link">
                        <div>Category Manager</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('vendor.all.types') }}" class="menu-link">
                        <div>Types</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('vendor.collections') }}" class="menu-link">
                        <div>Collection</div>
                    </a>
                </li>
               
                
                <li class="menu-item">
                    <a href="{{ route('vendor.all.include') }}" class="menu-link">
                        <div>Includes</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('vendor.all.foods') }}" class="menu-link">
                        <div>All Menu</div>
                    </a>
                </li>

               

            </ul>
        </li>
        <!-- Order Manager -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-gift"></i>
                <div data-i18n="Layouts">Offer Manager</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('vendor.offer') }}" class="menu-link">
                        <div>Offers</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('vendor.slot.offers') }}" class="menu-link">
                        <div>Table Offers</div>
                    </a>
                </li>

            </ul>
        </li>
        <!-- Delivery Manager -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div data-i18n="Layouts">Delivery Manager</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('vendor.all.delivery-areas') }}" class="menu-link">
                        <div>Postcode Manager</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('vendor.all.delivery-charge') }}" class="menu-link">
                        <div>Delivery Range</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('vendor.all.openings') }}" class="menu-link">
                        <div>Timing Manager</div>
                    </a>
                </li>

            </ul>
        </li>
        <!-- Allergen Manager -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-bowl-hot"></i>

                <div data-i18n="Layouts">Allergen Manager</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('vendor.all.allergen') }}" class="menu-link">
                        <div>Allergen Manager</div>
                    </a>
                </li>

            </ul>
        </li>
       
        <!-- Table Manager -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-chair"></i>

                <div data-i18n="Layouts">Table Management</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('vendor.table.service') }}" class="menu-link">
                        <div>Table Service</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('vendor.table.openings') }}" class="menu-link">
                        <div>Table Open Times</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('vendor.table.foods') }}" class="menu-link">
                        <div>Table Foods</div>
                    </a>
                </li>
               
                <li class="menu-item">
                    <a href="{{ route('vendor.table.bookings') }}" class="menu-link">
                        <div>Table Order</div>
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
                    <a href="{{ route('vendor.all.orders') }}" class="menu-link">
                        <div>All Order</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('vendor.food.reviews') }}" class="menu-link">
                        <div>Food Reviews</div>
                    </a>
                </li>


            </ul>
        </li>
        {{-- Account Manager --}}
        <li class="menu-item">
            <a href="{{ route('vendor.all.payments') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-bank"></i>
                <div>Account Manager</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('vendor.all.revenues') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-bank"></i>
                <div>Revenue Manager</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('vendor.all.tax') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-bank"></i>
                <div>Tax Manager</div>
            </a>
        </li>
    </ul>
</aside>
