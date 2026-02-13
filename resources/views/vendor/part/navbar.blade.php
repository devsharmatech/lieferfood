<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
         <div class="d-flex">
                        <div class="mt-2 me-4 text-center d-md-block d-none">
    <small>🏪 Shop</small>
    <div class="form-check form-switch mb-2 " style="cursor: pointer;">
        <input class="form-check-input vendor_detail_al" type="checkbox"
            data-id="{{ auth()->user()->id }}" data-key="restaurant_status"
            @checked(isset(auth()->user()->vendor_details->restaurant_status) && auth()->user()->vendor_details->restaurant_status == 1)
            id="status_restaurant" />
    </div>
</div>
         <div class="mt-2 me-4 text-center  d-md-block d-none">
    <small>🚚 Delivery</small>
    <div class="form-check form-switch mb-2" style="cursor: pointer;">
        <input class="form-check-input vendor_detail_al" type="checkbox"
            data-id="{{ auth()->user()->id }}" data-key="isDelivery"
            @checked(isset(auth()->user()->vendor_details->isDelivery) && auth()->user()->vendor_details->isDelivery == 1)
            id="isDelivery" />
    </div>
</div>
         <div class="mt-2 me-4 text-center  d-md-block d-none">
    <small>📦 Pickup</small>
    <div class="form-check form-switch mb-2" style="cursor: pointer;">
        <input class="form-check-input vendor_detail_al" type="checkbox"
            data-id="{{ auth()->user()->id }}" data-key="isPickup"
            @checked(isset(auth()->user()->vendor_details->isPickup) && auth()->user()->vendor_details->isPickup == 1)
            id="isPickup" />
    </div>
</div>
         <div class="mt-2 text-center  d-md-block d-none">
    <small>🍽️ Table</small>
    <div class="form-check form-switch mb-2" style="cursor: pointer;">
        <input class="form-check-input vendor_detail_al" type="checkbox"
            data-id="{{ auth()->user()->id }}" data-key="isTable"
            @checked(isset(auth()->user()->vendor_details->isTable) && auth()->user()->vendor_details->isTable == 1)
            id="isTable" />
    </div>
</div>
<div class="mt-2 mx-2 text-center ">
    <button class="btn btn-primary" type="button" id="fetchLocation"
        data-bs-toggle="modal" data-bs-target="#manualLocationModal">
        <i class="fa-solid fa-location-dot me-1"></i> Update Location
    </button>
</div>
                    </div>
         <ul class="navbar-nav flex-row align-items-center ms-auto">

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="@if (isset(auth()->user()->profile)) {{ asset('uploads/users/' . auth()->user()->profile) }}
                                                @else
                                                    {{ asset('uploads/avtarlg.jpg') }} @endif"
                            alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="@if (isset(auth()->user()->profile)) {{ asset('uploads/users/' . auth()->user()->profile) }}
                                                @else
                                                    {{ asset('uploads/avtarlg.jpg') }} @endif"
                                            alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span
                                        class="fw-medium d-block">{{ isset(auth()->user()->name) ? auth()->user()->name : '' }}</span>

                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('vendor.my.profile') }}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">My Profile</span>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('logout.vendor') }}">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
<div class="d-flex justify-content-center ">
                        <div class="mt-2 me-4 text-center d-md-none d-block">
    <small>🏪 Shop</small>
    <div class="form-check form-switch mb-2 " style="cursor: pointer;">
        <input class="form-check-input vendor_detail_al" type="checkbox"
            data-id="{{ auth()->user()->id }}" data-key="restaurant_status"
            @checked(isset(auth()->user()->vendor_details->restaurant_status) && auth()->user()->vendor_details->restaurant_status == 1)
            id="status_restaurant" />
    </div>
</div>
         <div class="mt-2 me-4 text-center d-md-none d-block">
    <small>🚚 Delivery</small>
    <div class="form-check form-switch mb-2" style="cursor: pointer;">
        <input class="form-check-input vendor_detail_al" type="checkbox"
            data-id="{{ auth()->user()->id }}" data-key="isDelivery"
            @checked(isset(auth()->user()->vendor_details->isDelivery) && auth()->user()->vendor_details->isDelivery == 1)
            id="isDelivery" />
    </div>
</div>
         <div class="mt-2 me-4 text-center d-md-none d-block">
    <small>📦 Pickup</small>
    <div class="form-check form-switch mb-2" style="cursor: pointer;">
        <input class="form-check-input vendor_detail_al" type="checkbox"
            data-id="{{ auth()->user()->id }}" data-key="isPickup"
            @checked(isset(auth()->user()->vendor_details->isPickup) && auth()->user()->vendor_details->isPickup == 1)
            id="isPickup" />
    </div>
</div>
         <div class="mt-2 text-center d-md-none d-block">
    <small>🍽️ Table</small>
    <div class="form-check form-switch mb-2" style="cursor: pointer;">
        <input class="form-check-input vendor_detail_al" type="checkbox"
            data-id="{{ auth()->user()->id }}" data-key="isTable"
            @checked(isset(auth()->user()->vendor_details->isTable) && auth()->user()->vendor_details->isTable == 1)
            id="isTable" />
    </div>
</div>
                    </div>


@if (session('admin_user_id'))
    <div class="alert alert-warning mx-auto mt-1">
        You are impersonating {{ Auth::user()->name }}. 
        <form action="{{ route('admin.return') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-link text-dark" >Return to Admin</button>
        </form>
    </div>
@endif

<!-- Modal -->
<div class="modal fade" id="manualLocationModal" tabindex="-1" aria-labelledby="manualLocationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title">Set Your Location</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <!-- Address to coordinates -->
        <div class="mb-3">
          <label for="addressInput" class="form-label">Enter Address</label>
          <input type="text" id="addressInput" class="form-control" value="{{Auth::user()->address ?? ''}}" placeholder="Enter full address">
          <button class="btn btn-sm btn-info mt-2" id="getCoordsFromAddress">Get Coordinates</button>
        </div>

        <hr>

        <!-- Manual lat/lng input -->
        <div class="mb-3">
          <label for="manualLatitude" class="form-label">Latitude</label>
          <input type="text" class="form-control" id="manualLatitude"  value="{{Auth::user()->latitude ?? ''}}" placeholder="e.g. 28.123456">
        </div>

        <div class="mb-3">
          <label for="manualLongitude" class="form-label">Longitude</label>
          <input type="text" class="form-control" id="manualLongitude" value="{{Auth::user()->longitude ?? ''}}" placeholder="e.g. 77.123456">
        </div>

        <!-- Optional: display resolved address -->
        <div class="mb-3">
          <label for="resolvedAddress" class="form-label">Resolved Address</label>
          <textarea class="form-control" id="resolvedAddress" rows="2" readonly></textarea>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-success" id="saveManualLocation">Save Location</button>
      </div>
      
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
    const apiKey = "AIzaSyAonK15hotzDslX4ePjIbmizRii-7Ng4QE";

    // Get coordinates from address
    $('#getCoordsFromAddress').on('click', function () {
        const address = $('#addressInput').val().trim();
        if (!address) return alert("Please enter an address.");

        $.get(`https://maps.googleapis.com/maps/api/geocode/json`, {
            address: address,
            key: apiKey
        }, function (res) {
            if (res.status === 'OK') {
                const location = res.results[0].geometry.location;
                const formattedAddress = res.results[0].formatted_address;

                $('#manualLatitude').val(location.lat);
                $('#manualLongitude').val(location.lng);
                $('#resolvedAddress').val(formattedAddress);
            } else {
                alert("⚠️ Address could not be resolved.");
            }
        });
    });

    // Save location to backend
    $('#saveManualLocation').on('click', function () {
        const lat = $('#manualLatitude').val().trim();
        const lng = $('#manualLongitude').val().trim();
        const address = $('#resolvedAddress').val().trim() || $('#addressInput').val().trim();

        if (!lat || !lng) return alert("Please enter or fetch both Latitude and Longitude.");

        $.ajax({
            url: "{{ route('update.location.vendor') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                latitude: lat,
                longitude: lng,
                address: address
            },
            success: function () {
                alert("✅ Location saved successfully!");
                $('#manualLocationModal').modal('hide');
            },
            error: function () {
                alert("❌ Failed to save location.");
            }
        });
    });
});
</script>


