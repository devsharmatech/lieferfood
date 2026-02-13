<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed layout-compact"
    dir="ltr" data-theme="theme-default" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title> Vendor Dashboard </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
        href="{{ asset('uploads/logo/logo5.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('pizza-admin-template/assets/vendor/fonts/boxicons.css') }}" />

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('pizza-admin-template/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('pizza-admin-template/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('pizza-admin-template/assets/css/demo.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('pizza-admin-template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('pizza-admin-template/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->
    @yield('custome_style')
    <!-- Helpers -->
    <script src="{{ asset('pizza-admin-template/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('pizza-admin-template/assets/js/config.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<style>
    .bg-menu-theme .menu-link, .bg-menu-theme .menu-horizontal-prev, .bg-menu-theme .menu-horizontal-next,.bg-menu-theme .menu-header{
        color: #000 !important;
    }
    p, small, span{
        color: #000 !important;
    }
    td, th{
        color:#000 !important;
    }
     input, select{
        color:#000 !important;
    }
    label{
        color:#000 !important;
    }
</style>
<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            @include('vendor.part.sidebar')
            <!-- / Menu -->
            <script>
                @if (Session::has('message'))

                    var type = "{{ Session::get('alert-type', 'info') }}";



                    switch (type) {
                        case 'info':
                            toastr.info(" {{ Session::get('message') }} ");
                            break;

                        case 'success':

                            toastr.success(" {{ Session::get('message') }} ");
                            break;

                        case 'warning':
                            toastr.warning(" {{ Session::get('message') }} ");
                            break;

                        case 'error':
                            toastr.error(" {{ Session::get('message') }} ");
                            break;
                    }
                @endif
            </script>
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('vendor.part.navbar')

                <!-- / Navbar -->
                <div class="content-wrapper">
                    
                    <!-- Content -->
                    <!-- Content wrapper -->
                    @yield('vendor_body')
                    <!-- Content wrapper -->
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('vendor.part.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    {{-- <div class="buy-now">
        <a href="" target="_blank"
            class="btn btn-danger btn-buy-now">Go to website</a>
    </div> --}}

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('pizza-admin-template/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('pizza-admin-template/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('pizza-admin-template/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('pizza-admin-template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('pizza-admin-template/assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('pizza-admin-template/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('pizza-admin-template/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('pizza-admin-template/assets/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @yield('vendor_custome_script')
    <script>
        $(function() {
            $(document).on('click', '#delete', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = link;
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            })
        });
    </script>
    <script>
        $(document).on('change', '.vendor_detail_al', function() {
            var vendorId = $(this).data('id');
            var key = $(this).data('key');
            var restaurantStatus = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: '{{route("update.status.vendor")}}', 
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', 
                    vendor_id: vendorId,
                    col: key,
                    restaurant_status: restaurantStatus
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Status updated successfully!');
                    } else {
                        toastr.error('Failed to update status.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });
    </script>
    
@auth
<script>
async function initFirebaseMessaging() {

    if (!("Notification" in window)) return;

    // Ask permission
    const permission = await Notification.requestPermission();
    if (permission !== "granted") return;

    // Get FCM token
    const token = await messaging.getToken({
        vapidKey: "{{ env('FIREBASE_VAPID_KEY') }}"
    });

    if (!token) return;

    // Save token to Laravel
    fetch("{{ route('update-device') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{csrf_token()}}"
        },
        body: JSON.stringify({
            token: token,
            user_id:"{{auth()->id() ?? ''}}"
        })
    });

}

// Run after page load
document.addEventListener("DOMContentLoaded", initFirebaseMessaging);
</script>
@endauth

<script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js"></script>

<script>
 const firebaseConfig = {
  apiKey: "AIzaSyA-QBqdIO6R93OTvYfo5P0_lkegBQFByNg",
  authDomain: "lieferfood-38eaf.firebaseapp.com",
  projectId: "lieferfood-38eaf",
  storageBucket: "lieferfood-38eaf.firebasestorage.app",
  messagingSenderId: "64404788496",
  appId: "1:64404788496:web:0e25cca1dd530f02e40195"
};

  firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging();
</script>

</body>

</html>
