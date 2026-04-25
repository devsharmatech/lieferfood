<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed layout-compact"
    dir="ltr" data-theme="theme-default" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title> @yield('title') </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('uploads/logo/logo5.png') }}" />

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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .bg-menu-theme .menu-link,
        .bg-menu-theme .menu-horizontal-prev,
        .bg-menu-theme .menu-horizontal-next,
        .bg-menu-theme .menu-header {
            color: #000 !important;
        }

        p,
        small,
        span {
            color: #000 !important;
        }

        td,
        th {
            color: #000 !important;
        }

        input,
        select {
            color: #000 !important;
        }

        label {
            color: #000 !important;
        }
    </style>
    <style>
        .skiptranslate {
            display: none !important;
        }

        font {
            background: unset !important;
            box-shadow: unset !important;
        }

        .country-option,
        .language-option {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 10px;
            border: 1px solid transparent;
            border-radius: 5px;
            transition: all 0.2s;
            position: relative;
        }

        .country-option:hover,
        .language-option:hover {
            border-color: #ddd;
        }

        .country-option input[type="radio"],
        .language-option input[type="radio"] {
            display: none;
        }

        .country-option img {
            width: 30px;
            margin-right: 10px;
        }

        .country-option label,
        .language-option label {
            margin: 0;
            flex-grow: 1;
        }

        .country-option .check-icon,
        .language-option .check-icon {
            display: none;
            position: absolute;
            right: 10px;
            color: green;
        }

        .country-option.selected,
        .language-option.selected {
            background-color: #e9ecef;
            border-color: #007bff;
        }

        .country-option.selected .check-icon,
        .language-option.selected .check-icon {
            display: block;
        }

        #countryLangButton img {
            width: 100% !important;
            height: 100% !important;
            border-radius: 50% !important;
            object-fit: cover !important;
        }

        body {
            top: 0 !important;
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            @include('admin.part.sidebar')
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

                @include('admin.part.navbar')

                <!-- / Navbar -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <!-- Content wrapper -->
                    @yield('admin_body')
                    <!-- Content wrapper -->
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('admin.part.footer')
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
        <a href="" target="_blank" class="btn btn-danger btn-buy-now">Go to website</a>
    </div> --}}

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('pizza-admin-template/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('pizza-admin-template/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('pizza-admin-template/assets/vendor/js/bootstrap.js') }}"></script>
    <script
        src="{{ asset('pizza-admin-template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
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
    @yield('custome_script')
    <script>
        $(function () {
            $(document).on('click', '#delete', function (e) {
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
                        user_id: "{{auth()->id() ?? ''}}"
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

    <!-- Country and Language Modal -->
    <div class="modal fade" id="countryLangModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="countryLangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-scroll">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="countryLangModalLabel">Select Country and Language</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x fs-4"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6" action="#" id="languageForm">
                            <h5 class="fw-bold fs-5 mb-3">Select Language</h5>
                            <div class="language-option" data-lang="German">
                                <input type="radio" id="lang-de" name="language" value="de">
                                <label for="lang-de"><img src="https://flagcdn.com/16x12/de.png" width="16" height="12"
                                        alt="German"> German</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="English">
                                <input type="radio" id="lang-en" name="language" value="en">
                                <label for="lang-en"><img src="https://flagcdn.com/16x12/gb.png" width="16" height="12"
                                        alt="English"> English</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="Punjabi">
                                <input type="radio" id="lang-pa" name="language" value="pa">
                                <label for="lang-pa"><img src="https://flagcdn.com/16x12/in.png" width="16" height="12"
                                        alt="Punjabi"> Punjabi</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="Arabic">
                                <input type="radio" id="lang-ar" name="language" value="ar">
                                <label for="lang-ar"><img src="https://flagcdn.com/16x12/sa.png" width="16" height="12"
                                        alt="Arabic"> Arabic</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="Chinese">
                                <input type="radio" id="lang-zh" name="language" value="zh">
                                <label for="lang-zh"><img src="https://flagcdn.com/16x12/cn.png" width="16" height="12"
                                        alt="Chinese"> Chinese</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="Spanish">
                                <input type="radio" id="lang-es" name="language" value="es">
                                <label for="lang-es"><img src="https://flagcdn.com/16x12/es.png" width="16" height="12"
                                        alt="Spanish"> Spanish</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="French">
                                <input type="radio" id="lang-fr" name="language" value="fr">
                                <label for="lang-fr"><img src="https://flagcdn.com/16x12/fr.png" width="16" height="12"
                                        alt="French"> French</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="Hindi">
                                <input type="radio" id="lang-hi" name="language" value="hi">
                                <label for="lang-hi"><img src="https://flagcdn.com/16x12/in.png" width="16" height="12"
                                        alt="Hindi"> Hindi</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="Italian">
                                <input type="radio" id="lang-it" name="language" value="it">
                                <label for="lang-it"><img src="https://flagcdn.com/16x12/it.png" width="16" height="12"
                                        alt="Italian"> Italian</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="Japanese">
                                <input type="radio" id="lang-ja" name="language" value="ja">
                                <label for="lang-ja"><img src="https://flagcdn.com/16x12/jp.png" width="16" height="12"
                                        alt="Japanese"> Japanese</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="Korean">
                                <input type="radio" id="lang-ko" name="language" value="ko">
                                <label for="lang-ko"><img src="https://flagcdn.com/16x12/kr.png" width="16" height="12"
                                        alt="Korean"> Korean</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="Dutch">
                                <input type="radio" id="lang-nl" name="language" value="nl">
                                <label for="lang-nl"><img src="https://flagcdn.com/16x12/nl.png" width="16" height="12"
                                        alt="Dutch"> Dutch</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="Norwegian">
                                <input type="radio" id="lang-no" name="language" value="no">
                                <label for="lang-no"><img src="https://flagcdn.com/16x12/no.png" width="16" height="12"
                                        alt="Norwegian"> Norwegian</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="Polish">
                                <input type="radio" id="lang-pl" name="language" value="pl">
                                <label for="lang-pl"><img src="https://flagcdn.com/16x12/pl.png" width="16" height="12"
                                        alt="Polish"> Polish</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="Portuguese (Brazil)">
                                <input type="radio" id="lang-pt-br" name="language" value="pt-BR">
                                <label for="lang-pt-br"><img src="https://flagcdn.com/16x12/br.png" width="16"
                                        height="12" alt="Portuguese (Brazil)"> Portuguese (Brazil)</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="Finnish">
                                <input type="radio" id="lang-fi" name="language" value="fi">
                                <label for="lang-fi"><img src="https://flagcdn.com/16x12/fi.png" width="16" height="12"
                                        alt="Finnish"> Finnish</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                            <div class="language-option" data-lang="Russian">
                                <input type="radio" id="lang-ru" name="language" value="ru">
                                <label for="lang-ru"><img src="https://flagcdn.com/16x12/ru.png" width="16" height="12"
                                        alt="Russian"> Russian</label>
                                <span class="check-icon">&#10003;</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-md-12 col-12" id="country-list-1">
                                    <h5 class="fw-bold fs-5 mb-3">Select Country</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="google_translate_element" style="display:none;"></div>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en'
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript"
        src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script src="{{ asset('pizza-client/assets/js/country.js') }}"></script>
</body>

</html>
