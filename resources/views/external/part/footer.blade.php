<style>
    .VIpgJd-ZVi9od-aZ2wEe-wOHMyf {
        display: none !important;
    }
</style>
<button id="scrollToTopBtn" class="scroll-to-top">
    <i class="fa-solid fa-arrow-up"></i>
</button>
<section class="py-0 pt-7 bg-1000">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3  mb-3">
                <h5 class="lh-lg fw-bold text-white">COMPANY</h5>
                <ul class="list-unstyled mb-md-4 mb-lg-0">
                    <li class="lh-lg"><a class="text-200 text-decoration-none" href="{{ route('home') }}">Home</a></li>
                    <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">About Us</a></li>
                    <li class="lh-lg"><a class="text-200 text-decoration-none" href="{{ route('shop') }}">Shop</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <h5 class="lh-lg fw-bold text-white">CONTACT</h5>
                <ul class="list-unstyled mb-md-4 mb-lg-0">
                    <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Help &amp; Support</a>
                    </li>
                    <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Partner with us</a></li>
                    <li class="lh-lg"><a class="text-200 text-decoration-none"
                            href="mailto:support@lieferfood.de">support@lieferfood.de</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <h5 class="lh-lg fw-bold text-white">LEGAL</h5>
                <ul class="list-unstyled mb-md-4 mb-lg-0">
                    <li class="lh-lg"><a class="text-200 text-decoration-none"
                            href="{{ route('terms-conditions') }}">Terms &amp;
                            Conditions</a></li>

                    <li class="lh-lg"><a class="text-200 text-decoration-none"
                            href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                    <li class="lh-lg"><a class="text-200 text-decoration-none"
                            href="{{ route('cookie-policy') }}">Cookie Policy</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <h5 class="lh-lg fw-bold text-white">CONNECT ON</h5>
                <ul class="list-unstyled mb-md-4 mb-lg-0">
                    <li class="lh-lg">
                        <a class="text-200 text-decoration-none" href="mailto:info@lieferfood.de"><i
                                class="fa fa-envelope me-2"></i>info@lieferfood.de</a>
                    </li>

                    <li class="lh-lg">
                        <a class="text-200 text-decoration-none" href="tel:+491796756786"><i
                                class="fa fa-phone-alt me-2"></i> +49 179 6756786</a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-8 col-lg-6 col-xxl-4">
                <h5 class="lh-lg fw-bold text-500">FOLLOW US</h5>
                <div class="text-start my-3">
                    <a href="#!" class="text-white fs-2 me-2" style="cursor:pointer;">
                        <i class="fa-brands  fa-instagram"></i>
                    </a>
                    <a href="#!" class="text-white fs-2 me-2" style="cursor:pointer;">
                        <i class="fa-brands fa-square-facebook"></i>
                    </a>
                    <a href="#!" class="text-white fs-2 me-2" style="cursor:pointer;">
                        <i class="fa-brands fa-square-x-twitter"></i>
                    </a>
                </div>

            </div>
        </div>

        <div class="row flex-center pb-3">
            <div class="col-md-12 order-0">
                <p class="text-200 text-center text-md-start">All rights Reserved &copy; Lieferfood.de,
                    {{ date('Y') }}</p>
            </div>

        </div>
    </div>
</section>



<div class="modal fade" id="countryLangModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="countryLangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-scroll">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="countryLangModalLabel">Select Country and Language</h5>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6" action="#" id="languageForm">
                        <h5 class="fw-bold fs-1">Select Language</h5>
                          <div class="language-option" data-lang="German">
                            <input type="radio" id="lang-de" name="language" value="de">
                            <label for="lang-de">
                                <img src="https://flagcdn.com/16x12/de.png"
                                    srcset="https://flagcdn.com/32x24/de.png 2x, https://flagcdn.com/48x36/de.png 3x"
                                    width="16" height="12" alt="German">
                                German
                            </label>
                            <span class="check-icon">&#10003;</span>
                        </div>
                        <div class="language-option" data-lang="English">
                            <input type="radio" id="lang-en" name="language" value="en">
                            <label for="lang-en">
                                <img src="https://flagcdn.com/16x12/gb.png"
                                    srcset="https://flagcdn.com/32x24/gb.png 2x, https://flagcdn.com/48x36/gb.png 3x"
                                    width="16" height="12" alt="English">
                                English
                            </label>
                            <span class="check-icon">&#10003;</span>
                        </div>

                        <div class="language-option" data-lang="Punjabi">
                            <input type="radio" id="lang-pa" name="language" value="pa">
                            <label for="lang-pa">
                                <img src="https://flagcdn.com/16x12/in.png"
                                    srcset="https://flagcdn.com/32x24/in.png 2x, https://flagcdn.com/48x36/in.png 3x"
                                    width="16" height="12" alt="Punjabi">
                                Punjabi
                            </label>
                            <span class="check-icon">&#10003;</span>
                        </div>

                        <div class="language-option" data-lang="Arabic">
                            <input type="radio" id="lang-ar" name="language" value="ar">
                            <label for="lang-ar">
                                <img src="https://flagcdn.com/16x12/sa.png"
                                    srcset="https://flagcdn.com/32x24/sa.png 2x, https://flagcdn.com/48x36/sa.png 3x"
                                    width="16" height="12" alt="Arabic">
                                Arabic
                            </label>
                            <span class="check-icon">&#10003;</span>
                        </div>

                        <div class="language-option" data-lang="Chinese">
                            <input type="radio" id="lang-zh" name="language" value="zh">
                            <label for="lang-zh">
                                <img src="https://flagcdn.com/16x12/cn.png"
                                    srcset="https://flagcdn.com/32x24/cn.png 2x, https://flagcdn.com/48x36/cn.png 3x"
                                    width="16" height="12" alt="Chinese">
                                Chinese
                            </label>
                            <span class="check-icon">&#10003;</span>
                        </div>

                        <div class="language-option" data-lang="Spanish">
                            <input type="radio" id="lang-es" name="language" value="es">
                            <label for="lang-es">
                                <img src="https://flagcdn.com/16x12/es.png"
                                    srcset="https://flagcdn.com/32x24/es.png 2x, https://flagcdn.com/48x36/es.png 3x"
                                    width="16" height="12" alt="Spanish">
                                Spanish
                            </label>
                            <span class="check-icon">&#10003;</span>
                        </div>

                        <div class="language-option" data-lang="French">
                            <input type="radio" id="lang-fr" name="language" value="fr">
                            <label for="lang-fr">
                                <img src="https://flagcdn.com/16x12/fr.png"
                                    srcset="https://flagcdn.com/32x24/fr.png 2x, https://flagcdn.com/48x36/fr.png 3x"
                                    width="16" height="12" alt="French">
                                French
                            </label>
                            <span class="check-icon">&#10003;</span>
                        </div>

                        <div class="language-option" data-lang="Hindi">
                            <input type="radio" id="lang-hi" name="language" value="hi">
                            <label for="lang-hi">
                                <img src="https://flagcdn.com/16x12/in.png"
                                    srcset="https://flagcdn.com/32x24/in.png 2x, https://flagcdn.com/48x36/in.png 3x"
                                    width="16" height="12" alt="Hindi">
                                Hindi
                            </label>
                            <span class="check-icon">&#10003;</span>
                        </div>

                        <div class="language-option" data-lang="Italian">
                            <input type="radio" id="lang-it" name="language" value="it">
                            <label for="lang-it">
                                <img src="https://flagcdn.com/16x12/it.png"
                                    srcset="https://flagcdn.com/32x24/it.png 2x, https://flagcdn.com/48x36/it.png 3x"
                                    width="16" height="12" alt="Italian">
                                Italian
                            </label>
                            <span class="check-icon">&#10003;</span>
                        </div>

                        <div class="language-option" data-lang="Japanese">
                            <input type="radio" id="lang-ja" name="language" value="ja">
                            <label for="lang-ja">
                                <img src="https://flagcdn.com/16x12/jp.png"
                                    srcset="https://flagcdn.com/32x24/jp.png 2x, https://flagcdn.com/48x36/jp.png 3x"
                                    width="16" height="12" alt="Japanese">
                                Japanese
                            </label>
                            <span class="check-icon">&#10003;</span>
                        </div>

                        <div class="language-option" data-lang="Korean">
                            <input type="radio" id="lang-ko" name="language" value="ko">
                            <label for="lang-ko">
                                <img src="https://flagcdn.com/16x12/kr.png"
                                    srcset="https://flagcdn.com/32x24/kr.png 2x, https://flagcdn.com/48x36/kr.png 3x"
                                    width="16" height="12" alt="Korean">
                                Korean
                            </label>
                            <span class="check-icon">&#10003;</span>
                        </div>
 <div class="language-option" data-lang="Dutch">
        <input type="radio" id="lang-nl" name="language" value="nl">
        <label for="lang-nl">
            <img src="https://flagcdn.com/16x12/nl.png"
                srcset="https://flagcdn.com/32x24/nl.png 2x, https://flagcdn.com/48x36/nl.png 3x"
                width="16" height="12" alt="Dutch">
            Dutch
        </label>
        <span class="check-icon">&#10003;</span>
    </div>

    <div class="language-option" data-lang="Norwegian">
        <input type="radio" id="lang-no" name="language" value="no">
        <label for="lang-no">
            <img src="https://flagcdn.com/16x12/no.png"
                srcset="https://flagcdn.com/32x24/no.png 2x, https://flagcdn.com/48x36/no.png 3x"
                width="16" height="12" alt="Norwegian">
            Norwegian
        </label>
        <span class="check-icon">&#10003;</span>
    </div>

    <div class="language-option" data-lang="Polish">
        <input type="radio" id="lang-pl" name="language" value="pl">
        <label for="lang-pl">
            <img src="https://flagcdn.com/16x12/pl.png"
                srcset="https://flagcdn.com/32x24/pl.png 2x, https://flagcdn.com/48x36/pl.png 3x"
                width="16" height="12" alt="Polish">
            Polish
        </label>
        <span class="check-icon">&#10003;</span>
    </div>

    <div class="language-option" data-lang="Portuguese (Brazil)">
        <input type="radio" id="lang-pt-br" name="language" value="pt-BR">
        <label for="lang-pt-br">
            <img src="https://flagcdn.com/16x12/br.png"
                srcset="https://flagcdn.com/32x24/br.png 2x, https://flagcdn.com/48x36/br.png 3x"
                width="16" height="12" alt="Portuguese (Brazil)">
            Portuguese (Brazil)
        </label>
        <span class="check-icon">&#10003;</span>
    </div>

    <div class="language-option" data-lang="Finnish">
        <input type="radio" id="lang-fi" name="language" value="fi">
        <label for="lang-fi">
            <img src="https://flagcdn.com/16x12/fi.png"
                srcset="https://flagcdn.com/32x24/fi.png 2x, https://flagcdn.com/48x36/fi.png 3x"
                width="16" height="12" alt="Finnish">
            Finnish
        </label>
        <span class="check-icon">&#10003;</span>
    </div>

    <div class="language-option" data-lang="Russian">
        <input type="radio" id="lang-ru" name="language" value="ru">
        <label for="lang-ru">
            <img src="https://flagcdn.com/16x12/ru.png"
                srcset="https://flagcdn.com/32x24/ru.png 2x, https://flagcdn.com/48x36/ru.png 3x"
                width="16" height="12" alt="Russian">
            Russian
        </label>
        <span class="check-icon">&#10003;</span>
    </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                         <div class="col-md-12 col-12" id="country-list-1">
                            <h5 class="fw-bold fs-1">Select Country</h5>
                         </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



@if (Route::currentRouteName() == 'shop.view')
    <style>
        .test-cart-container {
            position: fixed;
            right: 12px;
            bottom: 3px;
            cursor: grab;
            z-index: 1046;
            height: 60px;
            width: 60px;
        }

        .test-cart-btn {
            background-color: #f41909;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 24px;
            position: relative;
            animation: wave 2s infinite;
        }

        .test-cart-btn:hover {
            background-color: #d31308;
        }

        .test-badge {
            position: absolute;
            top: -2px;
            right: 17px;
            background-color: white;
            color: black;
            font-size: 21px;
            font-weight: bold;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
    </style>
    <div id="test-cart-container" class="test-cart-container d-xl-none d-block" draggable="true">
        <button class="test-cart-btn" id="openCartOverlay">
            <i class="fa-solid fa-basket-shopping"></i>
            <span class="text-light d-none" id="priceCart">0.00 &euro;</span>
            <span class="test-badge" id="qtyCart">0</span>
        </button>
    </div>
    <script>
        const cartContainer = document.getElementById('test-cart-container');

        let isDragging = false;
        let offsetX = 0;
        let offsetY = 0;

        // Mouse down event to start dragging
        cartContainer.addEventListener('mousedown', (event) => {
            isDragging = true;
            offsetX = event.clientX - cartContainer.getBoundingClientRect().left;
            offsetY = event.clientY - cartContainer.getBoundingClientRect().top;
            cartContainer.style.cursor = 'grabbing'; // Change cursor to indicate dragging
        });

        // Mouse move event to handle dragging
        document.addEventListener('mousemove', (event) => {
            if (isDragging) {
                const x = event.clientX - offsetX;
                const y = event.clientY - offsetY;
                cartContainer.style.left = `${x}px`;
                cartContainer.style.top = `${y}px`;
                cartContainer.style.position = 'absolute';
            }
        });

        // Mouse up event to stop dragging
        document.addEventListener('mouseup', () => {
            if (isDragging) {
                isDragging = false;
                cartContainer.style.cursor = 'grab'; // Reset cursor
            }
        });
    </script>
@endif
<style>
    .scroll-to-top {
        position: fixed;
        bottom: 10px;
        left: 10px;
        display: none;
        background-color: transparent;
        color: #f41909;
        border: none;
        border-radius: 50%;
        width: 60px !important;
        height: 60px !important;
        font-size: 20px;
        font-weight: 800 !important;
        cursor: pointer;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1046;
        align-items: center;
        justify-content: center;
        transition: opacity 0.3s, transform 0.3s;
        text-align: center;
        line-height: 1;
    }

    .scroll-to-top:hover {
        background-color: #f41909;
        color: #fff !important;
    }

    .scroll-to-top:active {
        transform: scale(0.9);
    }
</style>
@if (Route::currentRouteName() != 'shop.view')
    <script>
        const scrollToTopBtn = document.getElementById('scrollToTopBtn');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                scrollToTopBtn.style.display = 'flex';
            } else {
                scrollToTopBtn.style.display = 'none';
            }
        });
        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
@endif
<script>
    function saveLocationToLocalStorage(locationData) {
        localStorage.setItem('location', JSON.stringify(locationData));
    }

    $(document).ready(function() {
        // console.log(localStorage.getItem("location_saved"));
        if (!localStorage.getItem("location_saved")) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        let latitude = position.coords.latitude;
                        let longitude = position.coords.longitude;

                        let apiKey = "AIzaSyAonK15hotzDslX4ePjIbmizRii-7Ng4QE";
                        let geocodeUrl =
                            `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=${apiKey}`;
                        
                        $.get(geocodeUrl, function(data) {
    if (data.results.length > 0) {
        let result = data.results[0];
        let components = result.address_components;

        function getComponent(type) {
            const comp = components.find(c => c.types.includes(type));
            return comp ? comp.long_name : "";
        }

        const locationData = {
            latitude: latitude,
            longitude: longitude,
            city: getComponent("locality") || getComponent("administrative_area_level_2"),
            state: getComponent("administrative_area_level_1"),
            country: getComponent("country"),
            postalCode: getComponent("postal_code"),
            sublocality: getComponent("sublocality") || getComponent("neighborhood") || "",
            street: getComponent("route")
        };

        // Save to backend
        $.ajax({
            url: "{{ route('save.location') }}",
            type: "POST",
            data: {
                latitude: locationData.latitude,
                longitude: locationData.longitude,
                city: locationData.city,
                state: locationData.state,
                country: locationData.country,
                postalCode: locationData.postalCode,
                sublocality: locationData?.sublocality || locationData?.street,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                saveLocationToLocalStorage(locationData);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    } else {
        console.log("Reverse geocoding failed.");
    }
});

                    },
                    function(error) {
                        if (error.code === error.PERMISSION_DENIED) {
                            alert(
                                "You denied location access. Enable location services to save your location."
                            );
                        }
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
    });
</script>
