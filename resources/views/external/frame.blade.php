<!DOCTYPE html>
<html lang="ar" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lieferfood</title>
    
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('./logo51.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('./logo51.png') }}">
     <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('./logo51.png') }}">
   
<meta name="theme-color" content="#f41909">
     <!--<meta name="color-scheme" content="light only">-->
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Lieferfood">
     
     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <link href="{{ asset('pizza-client/assets/css/theme.css') }}" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="{{ asset('pizza-client/assets/nice-select/dist/css/nice-select2.css') }}">
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
    @yield('external-css')
    <style>
        .skiptranslate{
            display: none !important;
        }
        font{
    background:unset !important;
    box-shadow:unset !important;
}
#install-btn {
    position: fixed;
    bottom: 20px;       /* Distance from bottom */
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999;      /* On top of everything */
    background-color: #f41909;
    color: #fff;
    border: none;
    padding: 12px 24px;
    border-radius: 25px;
    font-size: 16px;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    display: none;      /* Initially hidden, shown via JS */
    transition: opacity 0.3s ease;
}
#install-btn.show {
    display: block;
}
.ios-install {
    position: fixed;
    bottom: 80px;
    left: 50%;
    transform: translateX(-50%);
    background: #f41909;
    color: #fff;
    padding: 12px 18px;
    border-radius: 25px;
    font-size: 14px;
    display: none;
    z-index: 9999;
    box-shadow: 0 4px 6px rgba(0,0,0,0.2);
}

@media (prefers-color-scheme: dark) {

    #home .home-message,
    #home .home-submessage {
        color: #f41909 !important;
        -webkit-text-fill-color: #f41909 !important;
    }

    /* 🔥 CRITICAL: override Google Translate <font> */
    #home .home-message font,
    #home .home-submessage font,.text-decoration-line-through {
        color: #f41909 !important;
        -webkit-text-fill-color: #f41909 !important;
        opacity: 1 !important;
    }
    .home-search-input{
        background-color:white !important;
        color: #000 !important;
        -webkit-text-fill-color: #000 !important;
        opacity: 1 !important;
    }
    .ads-info, .test-badge{
        background-color: rgba(0,0,0,0.2) !important;
    }
    .ads-info h1, .test-badge{
        
        color: #fff !important;
        -webkit-text-fill-color: #fff !important;
        opacity: 1 !important;
    }
}
font{
    background:unset !important;
    box-shadow:unset !important;
}
#home .home-message font,
#home .home-submessage font {
    color: inherit !important;
}


    </style>
    
</head>


<body style="top:0px !important;" class="top-0">

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        @if (Route::is('shop'))
            @include('external.part.navbar-shop')
        @elseif (Route::is('courier-service'))
            @include('external.part.navbar-courier')
        @elseif (Route::is('business-service'))
            @include('external.part.navbar-business')
        @elseif (Route::is('shop.view'))
            @include('external.part.navbar-ordering')
        @else
            @include('external.part.nav')
        @endif
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

        @yield('external-home-content')


        <!-- ============================================-->
        <!-- <section> begin ============================-->
        @include('external.part.footer')
        <!-- <section> close ============================-->
        <!-- ============================================-->

    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->



    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('pizza-client/vendors/@popperjs/popper.min.js') }}"></script>
    <script src="{{ asset('pizza-client/vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('pizza-client/vendors/is/is.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    <script src="{{ asset('pizza-client/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('pizza-client/assets/nice-select/dist/js/nice-select2.js') }}"></script>
    <script src="{{ asset('pizza-client/assets/js/theme.js') }}"></script>
    <script src="{{ asset('pizza-client/assets/js/country.js') }}"></script>
    <div id="google_translate_element" style="display:none;"></div>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en'
            }, 'google_translate_element');
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>
   <script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl,{
    placement: "top",
    fallbackPlacements: [] // 👈 disables auto switch to right/left
  })
        })
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


    @yield('external-js')
</body>

</html>
