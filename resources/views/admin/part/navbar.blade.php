<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
  id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

    <ul class="navbar-nav flex-row align-items-center ms-auto">

      <li class="nav-item me-3">
        <button class="btn btn-light" id="countryLangButton" data-bs-toggle="modal" data-bs-target="#countryLangModal"
          style="border-radius:50%; padding:2px; width:40px; height:40px; outline:none; box-shadow:none; border: 1px solid #ccc;">
          <img src="https://flagcdn.com/256x192/gb.png" id="currentFlag" alt="Country Flag"
            style="width: 100%; height: 100%; border-radius: 50%; object-fit:cover;">
        </button>
      </li>
      <!-- User -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <img src="@if (isset(auth()->user()->profile)) {{ asset('uploads/users/' . auth()->user()->profile) }}
            @else
                                                {{ asset('uploads/avtarlg.jpg') }} @endif" alt
              class="w-px-40 h-auto rounded-circle" />
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
                                                {{ asset('uploads/avtarlg.jpg') }} @endif" alt
                      class="w-px-40 h-auto rounded-circle" />
                  </div>
                </div>
                <div class="flex-grow-1">
                  <span class="fw-medium d-block">{{isset(auth()->user()->name) ? auth()->user()->name : ''}}</span>

                </div>
              </div>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="#">
              <i class="bx bx-user me-2"></i>
              <span class="align-middle">My Profile</span>
            </a>
          </li>

          <li>
            <a class="dropdown-item" href="{{route('admin.logout')}}">
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