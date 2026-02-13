@extends('external.frame')
@section('external-css')
    <style>
        html {
            overflow-x: hidden !important;
        }
        * {
  -webkit-touch-callout: none; 
  -webkit-user-select: none;
  user-select: none;
}

        .textcontent-desc {
    display: inline;
}
 .discount-section::-webkit-scrollbar {
    display: none; 
}
 .discount-section {
    -ms-overflow-style: none;
    scrollbar-width: none;
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
    
    .textcontent-desc.truncated {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 300px; 
    display: inline-block;
    vertical-align: bottom;
}

       .form-check{
    display:flex;
}
       .bg-1000{
           display:none !important;
       }
        body {
            overflow: hidden !important;
            height: 100vh !important;
        }
        #scrollspyContainer {
    overflow-x: auto;
    white-space: nowrap;
    scroll-behavior: smooth; 
    -ms-overflow-style: none; 
    scrollbar-width: none;
}


       #scrollspyContainer::-webkit-scrollbar {
    display: none;
}
p{
    white-space:normal !important;
}
.nav-link{
    color:#000;
}
.nav-link.actve{
 color:#fff !important;   
}
        .modal-header{
            padding:1rem 1rem !important;
        }
       .discount-section {
    padding: 5px 5px;
    background-color:transparent;
    margin-top: 10px;
    display:inline-block;
}
.discount-item {
    display: flex;
    align-items: center;
}
.discount-item i {
    font-size: 18px;
    color: red !important; 
    margin-right: 8px;
}
.discount-type {
    font-weight: bold;
    margin-right: 5px;
    color: #333;
}
.discount-value {
    color: #000;
    font-weight: bold;
}


        /* Custom styling for SweetAlert */
        .swal2-title {
            font-size: 18px !important; 
        }
        .swal2-popup {
            padding: 15px !important;
        }
        .swal2-html-container {
            font-size: 14px !important; 
        }
        .swal2-icon {
            display: none !important;
        }
        .modal-backdrop{
            z-index:1047 !important;
        }
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            /* Adjust as needed */
            z-index: 9999;
            overflow: hidden;
        }
        .form-check-input{
            border-radius:50% !important;
            cursor: pointer !important;
        }
        label{
           cursor: pointer !important; 
        }
      .form-check-input:checked[type="checkbox"] {
           border-radius:50% !important;
           background-image: url('{{asset("uploads/apr2.png")}}') !important;
       }

        body.loading {
            overflow: hidden;
        }

        #loader img {
            width: 100px;
        }

        .category-slider {
            display: flex;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .category-list-container {
            overflow-x: hidden;
            width: 80%;
        }

        .category-list {
            display: flex;
            transition: transform 0.3s ease;
            white-space: nowrap;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .category-list li {
            margin-right: 0px;
        }

        .scroll-left,
        .scroll-right {
            padding: 5px;
            cursor: pointer;
            font-size: 14px;
            border: none;
        }

        .scroll-left:disabled,
        .scroll-right:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }





        .bg-nue {
            background: #FEF3E2;
            color: #333;
            padding: 8px;
        }

        .form-control:hover,
        .form-control:focus {
            box-shadow: none !important;
        }

        .favorit {
            color: #ff0000 !important;
        }

        .review-card {
            border: 1px solid #ddd;
        }

        .review-card .rating {
            font-size: 1.5rem !important;

        }

        .custom-select-wrapper {
            position: relative;
            width: 100%;
        }

        .custom-select select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            background-color: #fff;
            border: 1px solid #ddd;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            font-size: 13px;
            transition: border-color 0.3s ease;
        }

        .custom-select select:focus {
            outline: none;
            border-color: #ff0400;
        }

        select:focus {
            outline: none;
            border-color: #ff0400;
        }

        .custom-select select:hover {
            border-color: #ff0400;
        }

        .custom-select::after {
            content: '\25BC';
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            pointer-events: none;
            font-size: 14px;
            color: #999;
        }

        .custom-select select:hover~.custom-select::after {
            color: #ff0400;
        }

        .custom-select select option {
            padding: 10px;
        }

        select {
            border: 1px solid #ddd;
            font-size: 22px !important;
        }

        select option {
            font-size: 22px !important;
        }

        .category-list-container {
            width: 100%;
            height: 49px;
            overflow-x: auto;
            white-space: nowrap;
            overflow-y: hidden;
            padding: 10px;
            box-sizing: border-box;

        }

        .category-list-container::-webkit-scrollbar {
            display: none;
        }

        .category-list {
            display: inline-block;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .category-list li {
            display: inline-block;
            margin: 0;
        }

        .add_cart {
            background-color: #fff !important;
            color: #ff0000;
            height: 35px;
            width: 35px;
            border: 1px solid #ddd;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.4s ease-in;

        }

        .add_cart:hover {
            background-color: #fff;
            color: #ddd;

        }

        .qty-box {
            /*min-width: 8rem;*/
            display: flex;

        }

        .qty-box button {
            height: 40px;
            width: 30px;
            border-radius: 0%;
            border: 0px;
            color: #ff0000;
            font-size: 1rem;
            font-weight:700;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
        }

        .qty-box input {
            height: 40px !important;
            width: 40px !important;
            border-radius: 0%;
            border: 0px;
            font-weight:700;
            color: #ff0000 !important;
            background:white;
        }


        .tabbtn {
            border: none;
            margin-right: 10px;
            transition: background-color 0.3s, color 0.3s;
        }





        .star-rating {
            direction: rtl;
            display: inline-flex;
            font-size: 2rem;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #ddd;
            cursor: pointer;
            transition: color 0.3s;
        }

        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #f41909;
        }

        .filled {
            color: #f41909 !important;
        }

        /* Blurred overlay styles */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            z-index: 100001;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .loading-text {
            font-size: 1.5rem;
            color: #333;
            font-weight: bold;
        }

        body.no-scroll {
            overflow: hidden;
        }

        .status-indicate .light {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 14px;
            position: relative;
        }

        .status-indicate .red {
            background-color: red;
            animation: blink 2s infinite, wave 2s infinite;
        }

        .status-indicate .green {
            background-color: green;
            animation: blink 2s infinite, wave 2s infinite;
            animation-delay: 1s;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .3;
            }
        }

        @keyframes wave {
            0% {
                box-shadow: 0 0 0px rgba(255, 0, 0, 0.7);
            }

            50% {
                box-shadow: 0 0 30px 10px rgba(255, 0, 0, 0.3);
            }

            100% {
                box-shadow: 0 0 0px rgba(255, 0, 0, 0.7);
            }
        }

        .status-indicate .green {
            animation: blink 2s infinite, wave-green 2s infinite;
        }

        @keyframes wave-green {
            0% {
                box-shadow: 0 0 0px rgba(0, 255, 0, 0.7);
            }

            50% {
                box-shadow: 0 0 30px 10px rgba(0, 255, 0, 0.3);
            }

            100% {
                box-shadow: 0 0 0px rgba(0, 255, 0, 0.7);
            }
        }
        @keyframes wave-green2 {
    0% {
        box-shadow: 0 0 0px rgba(102, 255, 102, 0.7); /* Parrot green */
    }

    50% {
        box-shadow: 0 0 30px 10px rgba(102, 255, 102, 0.3); /* Softer parrot green */
    }

    100% {
        box-shadow: 0 0 0px rgba(102, 255, 102, 0.7); /* Parrot green */
    }
}


        .form-group {
            margin-bottom: 8px !important;
        }

        #stickycontainer {
            position: sticky;
            z-index: 5;
            overflow: hidden;
        }

        /*.slidecontainer {*/
        /*    overflow-y: scroll;*/
        /*    -ms-overflow-style: none;*/
        /*    scrollbar-width: none;*/
        /*}*/

        /*.slidecontainer::-webkit-scrollbar {*/
        /*    display: none;*/
        /*}*/

       

        .overlay-cart {
            /* background: white; */
            z-index: 1000;
            overflow-y: auto;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            transform: translateX(100%);
        }

        .overlay-cart.show {
            display: block !important;
            z-index: 1051 !important;
            margin-top: 0px !important;
            background: white;
            position: fixed;
            top: 0;
            bottom: -5px;
            right: 0;
            height: 100vh; 
            height: 100dvh;
            width: 100%;
            overflow: hidden;
            transform: translateX(0);
            padding: 0 !important;
        }

        .overlay-cart.show #cartcheckout {
            background: #fff;
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            padding:0 10px;
            max-height: 12rem;
        }

        .close-icon {
            position: fixed;
            top: 10px;
            right: 15px;
            cursor: pointer;
            color: #333;
            font-size: 1.5rem;
            z-index: 1100;
        }
        .back-icon {
            position: fixed;
            top: 10px;
            left: 15px;
            cursor: pointer;
            color: #333;
            font-size: 1.5rem;
            z-index: 1100;
        }

        .overlay-cart.show .basketcontainer {
            margin-top: 0px !important;
        }

        .overlay-cart.show #cartContainer {
            margin-top: 10px !important;
        }

        @media (min-width: 1200px) {
            .overlay-cart {

                position: static;
                transform: translateX(0);
                height: auto;
                box-shadow: none;
            }
             .back-icon,
            .close-icon,
            .drag-icon {
                display: none;
            }
        }


        .tabbtn.active {
            border-radius: 23px !important;
            background-color: black !important;
            color: white !important;
        }

        .tabbtn:not(.active) {
            border-radius: 23px !important;
            background-color: #f7f7f7 !important;
            color: black !important;
        }

        /*for tablet and desktop */
        @media (min-width: 1025px) {


            .fs-1 {
                font-size: 16px !important;
            }
           .fs-2{
    font-size: 19px !important;
}
            select {
                font-size: 22px !important;
            }

            label {
                font-size: 20px !important;
            }
          #cartContainer {
            max-height: calc(100vh - 22rem);
            padding-bottom:2rem;
            overflow-y: scroll;
            overflow-x: hidden;
         }
            #cartcheckout {
                max-height: 15rem;
                
            }
        }
.checkoutbtnnow{
    font-size:16px ;
}
.add-to-cart-btn{
    font-size:16px ;
}
        /* Mobile and Smaller Tablets: for screens less than 768px */
        @media (max-width: 575.98px) {
            
            .fs-2 {
                font-size: 18px !important;
            }

            .fs-1 {
                font-size: 15px !important;
            }

        }
      #foodModal .modal-footer .btn, #foodModal .modal-footer input{
        font-size:23px;
        font-weight:700;
      }
      #editfoodModal .modal-footer .btn, #editfoodModal .modal-footer input{
    font-size:23px;
    font-weight:700;
}
        @media (max-width: 1024px) {


            label,
            select {
                font-size: 15px !important;
            }

            #foodModal .modal-dialog {
                margin: 0 !important;
                max-width: 100% !important;
                overflow: hidden;
            }
          .checkoutbtnnow{
            font-size:20px ;
           }

            .modal {
                bottom: 0 !important;
                overflow: hidden !important;
            }
            #countryLangModal .modal-body {
                max-height: calc(100vh - 7rem) !important;
                overflow-y:scroll;
            }
            #foodModal .modal-header {
                height: 4rem;
            }

            #foodModal .modal-dialog .modal-content {
                position: relative;
                height: 100vh !important;
                overflow-y: hidden;
                border-radius: 0px !important;
                background-clip: unset !important;
                margin: 0 !important;
            }

            #foodModal .modal-body {
                max-height: calc(100vh - 4rem) !important;
                padding-bottom:4rem;
            }

            #foodModal .modal-footer {
                position:fixed;
                bottom:0;
                left:0;
                right:0;
                display: flex;
                justify-content: space-between !important;
                align-items: center !important;
                background:white !important;
                border-radius: 0px !important;
                height: 4rem !important;
            }
           #foodModal .modal-footer .btn span{
              font-size: 23px;
              font-weight:700;
            }
          #foodModal .modal-footer input{
               font-size: 23px;
               font-weight:700;
               width:35px !important;
               border:0;
          }
            #foodModal .modal-footer .btn {
                padding: 0.3rem 0;
                font-size: 23px;
                border-radius: 15px;
            }
         #foodModal .modal-footer .quantity-controls .btn{
             padding: 0.5rem;
             background:white;
             color:red;
             border:0;
         }
            /*edit modal*/
            #editfoodModal .modal-dialog {
                margin: 0 !important;
                max-width: 100% !important;
                overflow: hidden !important;
            }

            #editfoodModal .modal-header {
                height: 4rem;
            }

            #editfoodModal .modal-dialog .modal-content {
                position: relative;
                height: 100vh;
                overflow-y: hidden;
                border-radius: 0px !important;
                background-clip: unset !important;
                margin: 0 !important;
            }

            #editfoodModal .modal-body {
                max-height: calc(100vh - 10rem) !important;
                /*max-height: calc(100vh - 12rem) !important;*/
            }

            #editfoodModal .modal-footer {
                 position:fixed;
                bottom:0;
                left:0;
                right:0;
                display: flex;
                justify-content: space-between !important;
                background:white;
                /*height: 6rem !important;*/
            }
            #editfoodModal .modal-footer input{
              font-size: 23px;
              width:35px !important;
              font-weight:700;
              border:0;
            }
            #editfoodModal .modal-footer .btn {
                padding: 0.3rem 0;
               font-size: 23px;
                border-radius: 15px;
            }
            #editfoodModal .modal-footer .btn span{
                font-size: 23px;
                font-weight:700;
            }
            #editfoodModal .modal-footer .quantity-controls .btn{
               padding: 0.5rem;
               background:white;
               border:0;
               color:red;
            }
            #cartContainer {
            max-height: calc(100vh - 16rem);
            padding-bottom:6rem;
            overflow-y: scroll;
            overflow-x: hidden;
         }
         .fs-3{
             font-size:20px !important;
         }
        }
        @media (max-width: 767px) {
            #foodModal .modal-body {
                max-height: calc(100vh - 4rem) !important;
                padding-bottom:4rem;
            }

            #editfoodModal .modal-body {
                max-height: calc(100vh - 4rem) !important;
                padding-bottom:4rem;
            }
        }
        .ml-2{
            margin-left:5px;
        }
        .logo_block{
            height:3rem !important;
            width:3rem !important;
        }
    </style>
@endsection
@section('external-home-content')
  <script>
  const elem = document.documentElement;
  let fullscreenEnabled = false;

  function enterFullscreen() {
    if (!document.fullscreenElement) {
      if (elem.requestFullscreen) {
        elem.requestFullscreen();
      } else if (elem.webkitRequestFullscreen) { // Safari iOS
        elem.webkitRequestFullscreen();
      }
    }
  }

  function exitFullscreen() {
    if (document.fullscreenElement) {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.webkitExitFullscreen) { // Safari iOS
        document.webkitExitFullscreen();
      }
    }
  }

  // On the very first touch, request fullscreen (allowed as a gesture)
  window.addEventListener("touchstart", () => {
    if (!fullscreenEnabled) {
      fullscreenEnabled = true;
      enterFullscreen();
    }
  }, { once: true });

  // After fullscreen is enabled, control it with scroll
  window.addEventListener("scroll", () => {
    if (!fullscreenEnabled) return;

    if (window.scrollY > 100) {
      enterFullscreen();
    } else {
      exitFullscreen();
    }
  });
</script>



    <!-- Blurred Overlay -->
    <div id="loading-overlay" class="loading-overlay" style="display: none;">
        <div class="loading-text">Processing...</div>
    </div>
    <div id="loader">
        <img src="{{ asset('uploads/giphy.gif') }}" alt="Loading..." />
    </div>
    <div class="row g-0">
        <div class="col-xl-9 pe-0  slidecontainer bg-white scrollspy-example position-relative" id="slidecontainer"
            style="max-height:100vh;overflow-y:scroll;"  data-bs-spy="scroll" data-bs-target="#navbar-scrollspy" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true">
            <div class="card pt-2 border-0 rounded-0">
                <div class="card-body">
                    <div class="rest_card_img">
                        <img src="{{ isset($vendor->vendor_details->banner) ? asset('uploads/banner/' . $vendor->vendor_details->banner) : 'https://placehold.co/1200x400' }}"
                            class="img-fluid-2 rounded-2" alt="">
                        <div class="logo_block" style="left:8% !important;bottom:5% !important;">
                            <img src="{{ isset($vendor->vendor_details->logo) ? asset('uploads/logo/' . $vendor->vendor_details->logo) : 'https://placehold.co/300x300' }}"
                                class="img-fluid-2 rounded-2" alt="">
                        </div>
                    </div>
                    <div class="row mt-2 ">
                        <div class="col-md-8 justify-content-md-start justify-content-center">
                            <h2 class="fs-3 card-title text-md-start text-center">{{ $vendor->name }} </h2>
                        </div>
                         <!--status-indicate-->
                        <div class="col-md-4 d-flex justify-content-md-end justify-content-between align-items-center ">
                            <a data-bs-toggle="modal" data-vendor-id="{{ $vendor->id }}"
                                                            data-bs-target="#staticBackdrop2" class="fw-bold me-2" style="white-space: nowrap;cursor:pointer;"> 
                                <i class="fas text-danger fa-star"></i>
                                {{ number_format($averageRating, 1) }} ({{ $ratingCount }}) 
                               
                            </a>
                               
                            @if ((isset($availability['is_delivery_open']) && $availability['is_delivery_open']==1) || (isset($availability['is_pickup_open']) && $availability['is_pickup_open']))
                                
                                @if(isset($vendor->vendor_details->isDelivery, $vendor->vendor_details->isPickup) && ($vendor->vendor_details->isDelivery==1 || $vendor->vendor_details->isPickup==1))
                                  @if(isset($vendor->vendor_details->restaurant_status) && $vendor->vendor_details->restaurant_status==1)
                                     <span style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#vendorDeliveryInfo" class="badge px-2 py-1 rounded-1 bg-success text-white me-2">Open</span>
                                  @else
                                   <span style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#vendorDeliveryInfo" class="badge px-2 py-1 rounded-1 bg-danger text-white me-2">Closed</span> 
                                  @endif
                                @else
                                  @if(isset($vendor->vendor_details->restaurant_status) && $vendor->vendor_details->restaurant_status==1)
                                     <span style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#vendorDeliveryInfo" class="badge px-2 py-1 rounded-1 bg-success text-white me-2">Open</span>
                                 @else
                                   <span style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#vendorDeliveryInfo" class="badge px-2 py-1 rounded-1 bg-danger text-white me-2">Closed</span> 
                                 @endif
                              @endif
                            @else
                                <span style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#vendorDeliveryInfo" class="badge px-2 py-1 rounded-1 bg-danger text-white me-2">Closed</span>
                            @endif
                            <a style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#vendorInfo" title="{{ $vendor->name }}" class="btn-lighter me-3">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </a>
                            <a style="cursor:pointer;" id="show-search"  title="Search" class="btn-lighter me-3">
                                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                            </a>

                            <label for="favorite" class="d-flex justify-content-center align-items-center mb-0 btn-lighter"
                                style="cursor:pointer;">
                                <i class="fa-solid fa-heart @if ($isFav) favorit @endif "
                                    id="heart-icon" aria-hidden="true"></i>
                                <input @checked($isFav) onchange="isFavorite({{ $vendor->id }},event)"
                                    type="checkbox" id="favorite" style="display:none;">
                            </label>


                        </div>
                    </div>
                    <div class="input-group d-flex justify-content-center  flex-nowrap mt-3">
                        <span class="input-group-text px-md-3 px-1 bg-light">
                            <i class="fa fa-percent me-2 text-primary" aria-hidden="true"></i>
                            <span class="text-dark fw-bold"> StampCards</span>
                        </span>

                         @if (isset($vendor->table_service->status,$vendor->vendor_details->isTable,$vendor->vendor_details->isTable) && $vendor->table_service->status == 1 && $vendor->vendor_details->isTable==1)
                            <a href="{{ route('shop.table', $vendor->unid) }}" class=" btn btn-white text-dark fw-bold" style="border:1px solid #ddd;font-size:18px;">
                                <img src="{{asset('uploads/table.png')}}" class="me-2" alt="Table booking start" style="height:20px; width:20px;"/>
                                Table Booking
                            </a>
                               
                        @endif

                    </div>
                    
                    
                    <div id="hidden-div" class="input-group my-3 mb-0 px-xl-5 px-3  rounded-0 " style="display:none;">
                         <span class="input-group-text p-3 bg-primary  rounded-pill rounded-end-0" style="cursor:pointer;" id="closesearch">
                            <i class="fa-solid fa-xmark fs-1 text-light"></i>
                        </span>
                        <input type="search" id="searchfoodname" class="form-control px-3 fs-1  bg-transparent  rounded-0"
                            placeholder="Food name...." />
                        <span class="input-group-text p-3 bg-primary  rounded-pill rounded-start-0" style="cursor:pointer;" id="closesearch">
                            <i class="fa-solid fa-magnifying-glass fs-1 text-light"></i>
                        </span>
                    </div>
                    

                </div>
            </div>
            <div id="stickycontainer" class="w-100"
                style="position:sticky;top:0;z-index: 1045;  overflow: hidden;  background: #fff;">

                <div class="category-slider">
                    <span class="scroll-left ">
                        <i class="fa-solid fs-4 fa-chevron-left text-primary"></i>
                    </span>
                    <nav class="category-list-container navbar " id="navbar-scrollspy">
                        <ul class="category-list nav-pills mx-0 px-0 d-flex" >
                            
                            @foreach ($categories_data as $index => $category_data)
                                <li class="nav-item">
                                    <a href="#s{{ $category_data->slug }}"
                                        class="nav-link fw-bolder  rounded-pill p-1 px-3" style="font-size:18px;">
                                        {{ $category_data->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                    <span class="scroll-right ">
                        <i class="fa-solid fa-chevron-right fs-4 text-primary"></i>
                    </span>
                </div>
            </div>
            <div class="card p-2 rounded-1 mt-2" >
                @if($vendorOffer->isNotEmpty())
                   <div class="discount-section w-100  text-center d-flex " style="overflow-x:scroll;">
        @foreach($vendorOffer as $offer)
            <div class="discount-item d-inline-block me-3 px-md-2 px-1 py-3 " 
                style="border: 2px solid #ffcc00; background: linear-gradient(135deg, #fff3c4, #ffeb99); 
                       border-radius: 12px; display: flex !important; align-items: center; 
                       min-width: 250px; max-width: 350px; text-align: left;">

                <!-- Big Percentage Icon -->
                <div class="discount-icon me-3" 
                     style="background: #ffcc00; padding: 12px; border-radius: 50%; 
                            display: flex; align-items: center; justify-content: center;">
                    <i class="fa fa-percent text-white" style="font-size: 1.8rem;"></i>
                </div>
                
                <!-- Offer Details -->
                <div class="discount-details">
                    @if($offer->offer_type == 'percentage')
                        <span class="discount-value d-block fw-bold text-danger" style="font-size: 1.4rem;">
                            {{ number_format($offer->discount_value) }}% OFF
                        </span>
                    @else
                        <span class="discount-value d-block fw-bold text-danger" style="font-size: 1.4rem;">
                            &euro;{{ number_format($offer->discount_value) }} OFF
                        </span>
                    @endif

                    <span class="discount-title text-dark fw-semibold d-block" style="font-size: 1rem;">
                        {{ $offer->title }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
                @endif
                
                
                
                <div class="tab-content " style="margin-bottom:8rem !important;">
                      <div>
                        
                        @foreach ($categories_data as $index => $category_data)
                            
                            <div class="categoryshow" id="s{{ $category_data->slug }}">
                                <h6 class="fw-bold text-primary mt-2 fs-3">{{ $category_data->name }}</h6>
                                <p style="font-size:14px;">{{ $category_data->description }}</p>
                                @if (isset($category_data->image) && $category_data->image != '')
                                    <div class="w-100 text-center">
                                        <img src="{{ asset('uploads/category/' . $category_data->image) }}"
                                            alt="" class="img-fluid">
                                    </div>
                                @endif
                                 @if(isset($category_data->offer))
    @php
        $categoryOffer = $category_data->offer;
    @endphp
    <div class="discount-section" style="margin: 15px 0; display: inline-block; background: #fff8e1; border: 2px solid #ffd54f; border-radius: 10px; padding: 15px 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div class="discount-item" style="display: flex; align-items: center;">
            <i class="fa fa-percent" aria-hidden="true" style="font-size: 30px; color: #ff6f00; margin-right: 12px;"></i>
            
            <div style="font-size: 18px; font-weight: bold; color: #6d4c41;">
                {{ $categoryOffer->title }} — 
                @if($categoryOffer->offer_type == 'percentage')
                    <span class="discount-value">{{ number_format($categoryOffer->discount_value) }}% Off</span>
                @else
                    <span class="discount-value">&euro;{{ number_format($categoryOffer->discount_value, 2) }} Off</span>
                @endif
            </div>
        </div>
    </div>
@endif

                            </div>
                            @foreach ($category_data->food_items as $item)
                                <div class="card mt-3 rounded-2 position-relative food-item" data-name="{{ $item->food_item_name }}">
                                    <div class="card-body py-1 view-food-details" data-food-id="{{ $item->id }}"
                                        data-id="{{ $item->id }}" data-hasvariant="{{ $item->hasVariants }}"
                                        data-foodprice="{{ $item->delivery_price }}"
                                        data-collections="{{ $item->collections }}"
                                        data-foodtype="{{ $item->item_type == 'alcoholic-drink' ? 1 : 0 }}"
                                        style="cursor: pointer;">
                                        <div class="d-flex justify-content-between">
                                            <div class="food-content w-100">
                                                <p class="fw-bold mb-0 fs-2 text-dark" style="width: calc(100% - 35px);">
                                                    {{ $item->food_item_name }}
                                                    <span class="info-ico" data-cereal="{{ $item->cereal }}"
                                                        data-nuts="{{ $item->nuts }}"
                                                        data-furthers="{{ $item->furthers }}">
                                                        <i style="font-size:14px;" class="fa fa-info-circle text-muted"
                                                            aria-hidden="true"></i>
                                                    </span>
                                                   @if(isset($item->item_type))
    @php
        $iconMap = [
    'food-item' => '🍽️',
    'veg' => '🥦',
    'veg2' => '🍃',
    'non-veg' => '🍖',
    'vegan' => '🌱',
    'eggetarian' => '🥚',
    'pescatarian' => '🐟',
    'halal' => '🕌',
    'jain-food' => '🧘',
    'gluten-free' => '🚫🌾',
    'organic' => '🍃',
    'spicy' => '🌶️',
    'sauce'    => '🧂',
    'dip'      => '🥫',
    'ketchup'  => '🍅',
    'mustard'  => '🌭',
    'mayo'     => '🍶',
    'bbq'      => '🔥',
    'chili'    => '🌶️',
    'soy'      => '🥢',
    'garlic'   => '🧄',
    'tartar'   => '🐟',
    'chicken' => '🐔',
    'lamb' => '🐑',
    'beef' => '🐃',
    'cow' => '🐂',
    'pig' => '🐖',
    'goat' => '🐐',
    'duck' => '🦆',
    'turkey' => '🦃',
    'fish' => '🐠',
    'shrimp' => '🍤',
    'seafood' => '🦐',
    'burger' => '🍔',
    'pizza' => '🍕',
    'sandwich' => '🥪',
    'fries' => '🍟',
    'taco' => '🌮',
    'hotdog' => '🌭',
    'non-alcoholic-drink' => '🥤',
    'alcoholic-drink' => '🍸',
    'beer' => '🍺',
    'beer-mug' => '🍻',
    'red-wine' => '🍷',
    'white-wine' => '🥂',
    'cocktail' => '🍹',
    'whiskey' => '🥃',
    'sparkling-wine' => '🥂',
    'coffee' => '☕',
    'tea' => '🫖',
    'ice-cream1' => '🍦',
    'ice-cream2' => '🍨',
    'ice-cream3' => '🍧',
    'cake' => '🍰',
    'chocolate' => '🍫',
    'donut' => '🍩',
    'cookie' => '🍪',
    'cheese' => '🧀',
    'salad' => '🥗',
    'pasta' => '🍝',
    'rice' => '🍚',
    'bread' => '🍞',
    'soup' => '🥣',
    'fruit' => '🍎',
];
        $iconClass = $iconMap[$item->item_type] ?? '🍽️'; // Fallback emoji
    @endphp
    <span title="{{ $item->item_type }}">{{ $iconClass }}</span>
@endif




                                                </p>
                                                <p class="fw-semibold fs-1 pb-1 mb-1" style="width: calc(100% - 35px);">{{ $item->description }}</p>
                                                @php
    $types = [
        'food-item' => '🍽️ Food Item',
        'veg' => '🥦 Vegetarian',
        'veg2' => '🍃 Vegetarian',
        'non-veg' => '🍖 Non-Vegetarian',
        'vegan' => '🌱 Vegan',
        'eggetarian' => '🥚 Eggetarian',
        'pescatarian' => '🐟 Pescatarian',
        'fish' => '🐠 Fish',
        'seafood' => '🦐 Seafood',
        'halal' => '🕌 Halal',
        'jain-food' => '🧘 Jain Food',
        'gluten-free' => '🚫🌾 Gluten-Free',
        'organic' => '🍃 Organic',
        'non-alcoholic-drink' => '🥤 Non-Alcoholic Drink',
        'alcoholic-drink' => '🍸 Alcoholic Drink',
        'hot-spicy' => '🌶️ Hot & Spicy',
        'sauce'    => '🧂 Sauce',
'dip'      => '🥫 Dip',
'ketchup'  => '🍅 Ketchup',
'mustard'  => '🌭 Mustard',
'mayo'     => '🍶 Mayonnaise',
'bbq'      => '🔥 BBQ Sauce',
'chili'    => '🌶️ Chili Sauce',
'soy'      => '🥢 Soy Sauce',
'garlic'   => '🧄 Garlic Dip',
'tartar'   => '🐟 Tartar Sauce',

        'lamb' => '🐑 Lamb',
        'chicken' => '🐔 Chicken',
        'beef' => '🐄 Beef',
        'buffalo' => '🐃 Buffalo',
        'shrimp' => '🍤 Shrimp',
        'meat' => '🥩 Meat',
        'cow' => '🐂 Cow',
        'pig' => '🐖 Pork',
        'beer' => '🍺 Beer',
        'beer-mug' => '🍻 Beer Mug',
        'red-wine' => '🍷 Red Wine',
        'white-wine' => '🥂 White Wine',
        'cocktail' => '🍹 Cocktail',
        'whiskey' => '🥃 Whiskey',
        'sparkling-wine' => '🥂 Sparkling Wine',
        'ice-cream' => '🍦 Ice Cream',
        'gelato' => '🍨 Gelato',
        'shaved-ice' => '🍧 Shaved Ice',
        'pizza' => '🍕 Pizza',
        'burger' => '🍔 Burger',
        'sushi' => '🍣 Sushi',
        'salad' => '🥗 Salad',
        'dessert' => '🍰 Dessert',
        'sandwich' => '🥪 Sandwich',
        'noodles' => '🍜 Noodles',
        'taco' => '🌮 Taco',
        'fries' => '🍟 Fries',
        'steak' => '🥩 Steak',
        'soup' => '🥣 Soup',
        'bread' => '🍞 Bread',
        'cheese' => '🧀 Cheese',
        'fruit' => '🍇 Fruit',
        'chocolate' => '🍫 Chocolate',
        'tea' => '🍵 Tea',
        'coffee' => '☕ Coffee',
        'soft-drink' => '🧃 Soft Drink',
        'water' => '💧 Water',
    ];
@endphp

    @if(!empty($item->types) && json_decode($item->types, true))
     <p>
        @php
            $itemTypes = json_decode($item->types, true);
        @endphp
        @foreach($itemTypes as $itemType)
            @php
                $typeDisplay = $types[$itemType] ?? '🍽️ Food Item';
                $iconOnly = Str::before($typeDisplay, ' ');
            @endphp
            <span title="{{ $typeDisplay }}">{{ $iconOnly }}</span>
        @endforeach
</p>
    @endif

@php
    $offer = null;
    $originalPrice = $item->hasVariants == 1 
        ? (isset($item->variants[0]->price) ? $item->variants[0]->price : 0) 
        : $item->delivery_price;
    if (isset($item->offer)) {
        $offer = $item->offer;
    } elseif (isset($category_data->offer)) {
        $offer = $category_data->offer;
    } elseif (isset($vendorOffer)) {
        $offer = $vendorOffer[0] ?? [];
    }
    if ($offer) {
        if ($offer->offer_type == 'percentage') {
            $discountedPrice = $originalPrice - ($originalPrice * $offer->discount_value / 100);
        } else {
            $discountedPrice = $originalPrice - $offer->discount_value;
        }
    } else {
        $discountedPrice = $originalPrice; 
    }
@endphp
<div>
    @if($offer)
        <div class="discount-section mt-0">
            <div class="discount-item">
               <div class="d-flex justify-content-center align-items-center rounded-circle me-2" style="height:25px;width:25px; background:gold; color:#2f2e2e;">
                    <i class="fa fa-tag" aria-hidden="true"></i>
               </div>
                @if($offer->offer_type == 'percentage')
                    <span class="discount-value me-2">{{ number_format($offer->discount_value) }}% Off</span>
                @else
                    <span class="discount-value me-2">&euro;{{ number_format($offer->discount_value) }} Off</span>
                @endif
                 <p class="mb-0 fw-bold text-dark fs-2">
              @if($offer)
                <span class="text-decoration-line-through me-2  text-danger">
                &euro;{{ number_format($originalPrice, 2) }}
            </span>
              @endif
                <span>
                &euro;{{ number_format($discountedPrice, 2) }}
              </span>
              </p>
            </div>
        </div>
    @else
        <div class="discount-section mt-0">
            <div class="discount-item">
               <p class="mb-0 fw-bold text-dark fs-2">
                <span>
                  &euro;{{ number_format($discountedPrice, 2) }}
                </span>
              </p>
            </div>
        </div>
    @endif
</div>

                                            </div>
                                            <button class="add_cart view-food-details position-absolute"
                                                data-food-id="{{ $item->id }}"
                                        data-id="{{ $item->id }}" data-hasvariant="{{ $item->hasVariants }}"
                                        data-foodprice="{{ $item->delivery_price }}"
                                        data-collections="{{ $item->collections }}"
                                        data-foodtype="{{ $item->item_type == 'alcoholic-drink' ? 1 : 0 }}"
                                                style="width:35px; height:35px;top:5%; right:2%;display:flex !important; justify-content:center !important; align-items:center !important;">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                         @if(isset($item->offer))
                                           <div class="discount-section">
                                             <div class="discount-item">
            <i class="fa fa-tag me-2" aria-hidden="true"></i> 
            
           @php
             $itemOffer= $item->offer;
           @endphp
                @if($itemOffer->offer_type == 'percentage')
                    <span class="discount-value">{{ number_format($itemOffer->discount_value) }}% Off</span>
                @else
                    <span class="discount-value">&euro;{{ number_format($itemOffer->discount_value) }} Off</span>
                @endif
           </div>
                                           </div>
                                        @endif
                                        
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
       <script>
    $(document).ready(function () {
        $('#searchfoodname').on('keyup change', function () {
            let searchValue = $(this).val().toLowerCase().trim();

            if (searchValue === '') {
                $('.categoryshow').show();
                $('.food-item').show();
                return; 
            }
            let categoryVisibility = {};

            $('.food-item').each(function () {
                let foodItem = $(this);
                let foodName = foodItem.data('name').toLowerCase();

                if (foodName.includes(searchValue)) {
                    foodItem.show(); // Show the matching food item
                    let categoryId = foodItem.closest('.categoryshow').attr('id');
                    categoryVisibility[categoryId] = true; // Mark the category as having visible items
                } else {
                    foodItem.hide(); // Hide non-matching food items
                }
            });

            // Show or hide each category based on its food items
            $('.categoryshow').each(function () {
                let category = $(this);
                let categoryId = category.attr('id');

                if (categoryVisibility[categoryId]) {
                    category.show(); // Show category if it has visible food items
                } else {
                    category.hide(); // Hide category if it has no visible food items
                }
            });
        });
    });
</script>
       <script>
   document.addEventListener("DOMContentLoaded", () => {
    const scrollspyContainer = document.getElementById("slidecontainer");
    const navbarScrollSpy = document.getElementById("navbar-scrollspy");
    const links = navbarScrollSpy.querySelectorAll("a");

    function scrollNavIntoView(activeLink) {
        const containerWidth = navbarScrollSpy.offsetWidth;
        const scrollPosition = activeLink.offsetLeft + activeLink.offsetWidth / 2;
        navbarScrollSpy.scrollLeft = scrollPosition - containerWidth / 2;
    }
    scrollspyContainer.addEventListener("scroll", () => {
        links.forEach(link => {
            const targetId = link.getAttribute("href").substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                const rect = targetElement.getBoundingClientRect();
                const containerRect = scrollspyContainer.getBoundingClientRect();

                // Check if the section is in view
                if (
                    rect.top >= containerRect.top &&
                    rect.bottom <= containerRect.bottom
                ) {
                    // Remove active class from all links
                    links.forEach(link => link.classList.remove("active"));

                    // Add active class to current link
                    link.classList.add("active");

                    // Scroll navbar to keep the active link visible
                    scrollNavIntoView(link);
                }
            }
        });
    });
    links.forEach(link => {
        link.addEventListener("click", e => {
            e.preventDefault();
            const targetId = link.getAttribute("href").substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        });
    });
    const scrollLeftBtn = document.querySelector(".scroll-left");
    const scrollRightBtn = document.querySelector(".scroll-right");

    scrollLeftBtn.addEventListener("click", () => {
        navbarScrollSpy.scrollBy({ left: -200, behavior: "smooth" });
    });

    scrollRightBtn.addEventListener("click", () => {
        navbarScrollSpy.scrollBy({ left: 200, behavior: "smooth" });
    });
});


</script>


        <div class="col-xl-3 pt-0 pt-md-5 pr-0 overlay-cart d-xl-block d-none bg-white" id="cartOverlay"
            style="height:100%;overflow:hidden;position:fixed;right:0;bottom:0;">
            <div class="card rounded-0 border-0 h-100">
                <!-- Back Icon -->
                <div class="back-icon" id="closeCartOverlay2">
                    <i class="fa-solid fa-arrow-left fa-lg"></i>
                </div>
                
                <div class="card-body px-0 pt-0 h-100 basketcontainer">
                    <div class="w-100 text-center pt-3" style="height:7.7rem; border-bottom:1px solid #ddd;">
                        <h5 class="fs-1 text-center fw-bold text-uppercase">Shopping Cart</h5>
                        <div class="w-100 d-flex justify-content-center flex-column align-items-center">
                            
                             <div class="switch-container" id="switch-container">
                                <input type="checkbox" id="toggleDeliveryPickup" class="input">
                                <div class="switch-label delivery" id="delivery-label">🚚 Delivery</div>
                                <div class="switch-label pickup" id="pickup-label">🧺 Pickup</div>
                                <div class="switch-slider" id="switch-slider">🚚 Delivery</div>
                            </div>
                            <a class="text-dark mt-md-1 mt-2 d-md-none d-block " id="closeCartOverlay3" style="cursor:pointer;">Add More Product</a>
                        </div>
                    </div>
                    <div id="cartContainer" class="filter_content mt-3 px-2  text-center slidecontainer">
                        <i class="fa-solid fa-bag-shopping fs-2 text-center"></i>
                        <h5 class="text-center fs-1 mt-2 fw-bold">Fill your basket</h5>
                        <small class="text-center ">Your basket is empty</small>
                    </div>
                    <div class="px-2 py-3 pt-0 bg-white" id="cartcheckout"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Food Item Details -->
    <div class="modal fade" id="foodModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"  aria-labelledby="foodModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" id="foodModalContent" data-id="">
                <div class="modal-header mb-0 pb-0">
                    <h5 class="modal-title" id="foodModalLabel">Food Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mt-0 pt-0" style="max-height: 440px; overflow-y:scroll;">
                    <!-- Food Description -->
                    <p id="foodDescription" class="my-0 py-0 fw-semibold"></p>
                    <!-- Variant Selection -->
                    <div class="form-group mb-3 d-none mt-0 " id="foodVariantsSelect">
                        <input type="hidden" id="foodDefaultPrice" class="foodDefaultPrice" value="0">
                        <label for="variantSelect" class="fw-bold fs-1">Choose Variant:</label>
                        <div class="custom-select-wrapper">
                            <div class="custom-select">
                                <select id="variantSelect" class="custom-select rounded-0">

                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- Extras Selection -->
                    <div class="form-group " id="extrasSection">
                        <div id="extrasContainer">

                        </div>
                    </div>

                </div>

                <div class="modal-footer pt-0 pb-2 d-flex justify-content-between">
                    <!-- Quantity Controls -->
                    <div class="quantity-controls d-flex">
                        <button type="button" class="btn btn-primary rounded-0 decrease-qty ">
                            <i class="fa fa-minus"></i>
                        </button>
                        <input type="number" style="width: 50px;text-align:center;"
                            class="form-control mx-2 bg-transparent text-primary px-0 rounded-0 qty-input" value="1"
                            min="1" readonly>
                        <button type="button" class="btn btn-primary rounded-0 increase-qty ">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- Add to Cart Button -->
                    <button type="button" class="btn btn-primary flex-1 add-to-cart-btn">
                       <span id="totalPrice" class="mx-2">0.00 €</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for edit Food Item Details -->
    <div class="modal fade" id="editfoodModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="foodModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" id="editfoodModalContent" data-id="">
                <div class="modal-header">
                    <h5 class="modal-title " id="editfoodModalLabel">Food Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 440px; overflow-y:scroll;">
                    <small class="text-muted">Update Cart</small>
                    <!-- Food Description -->
                    <p id="editfoodDescription" class="fw-semibold"></p>
                    <!-- Variant Selection -->
                    <div class="form-group mb-3 d-none" id="editfoodVariantsSelect">
                        <input type="hidden" id="editfoodDefaultPrice" class="editfoodDefaultPrice" value="0">
                        <label for="variantSelect fs-1 fw-bold">Choose Variant:</label>
                        <div class="custom-select-wrapper">
                            <div class="custom-select">
                                <select id="editvariantSelect" class="custom-select rounded-0">

                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Extras Selection -->
                    <div class="form-group" id="editextrasSection">

                        <div id="editextrasContainer"></div>
                    </div>

                </div>

                <div class="modal-footer pt-0 pb-2 d-flex justify-content-between">
                    <!-- Quantity Controls -->
                    <div class="quantity-controls d-flex">
                        <button type="button" class="btn btn-primary rounded-0 edit-decrease-qty ">
                            <i class="fa fa-minus"></i>
                        </button>
                        <input type="number" style="width: 50px;text-align:center;"
                            class="form-control mx-2 bg-transparent text-primary px-0 rounded-0 edit-qty-input"
                            value="1" min="1" readonly>
                        <button type="button" class="btn btn-primary rounded-0 edit-increase-qty ">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- Add to Cart Button -->
                    <button type="button" class="btn btn-primary flex-1 edit-to-cart-btn">
                        <input type="hidden" name="totalCostPay" id="totalCostPay">
                          <span id="edittotalPrice" class="mx-2">0.00€</span>
                    </button>
                </div>
                
                 <div id="custom-modal" style="display: none;">
        <h2>Modal Content</h2>
        <p id="modal-text"></p> <!-- Placeholder for dynamic text -->
    </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="foodInfoModal" tabindex="-1" aria-labelledby="foodInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="foodInfoModalLabel">Food Allergens</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalAllergines">
                  
                </div>
            </div>
        </div>
    </div>

    <!--vendor info-->
    <div class="modal fade" id="vendorInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg ">
    <div class="modal-content rounded-1">
      <div class="modal-header">
        <h1 class="modal-title fs-2" id="staticBackdropLabel">Information about the shop</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-0 pb-0 pt-0">
    <div class="card rounded-0 border-0">
        <div class="card-header rounded-0 bg-primary text-white">
            <h5 class="card-title text-white mb-0">
                <i class="fas fa-utensils"></i> 
                {{ isset($vendor->name) ? $vendor->name : 'No Vendor Name Available' }}
            </h5>
        </div>
        <div class="card-body">
            <!-- Restaurant Description -->
<p class="fs-2 descriptionText">
    
    <span class="textcontent-desc">
        {{ isset($vendor->vendor_details->description) ? $vendor->vendor_details->description : 'Description not available.' }}
    </span>
    <a href="javascript:void(0);" class="readmore-desc text-primary">Read More</a>
</p>

            <!-- Operating Hours -->
            <h6 class="mt-3 fs-2 fw-bold"><strong class="fw-bold"><i class="fa-regular fa-clock text-danger me-2"></i> Operating Hours:</strong></h6>
            <div class=" mt-2 d-flex justify-content-start justify-content-md-between gap-2 w-100 flex-wrap">
                        <div class="text-md-start ">
                            @if (isset($availability['is_delivery_open'],$vendor->vendor_details->isDelivery,$vendor->vendor_details->restaurant_status) && $availability['is_delivery_open'] && $vendor->vendor_details->isDelivery==1 && $vendor->vendor_details->restaurant_status==1)
                                <h6 class="fs-2">🚚 Delivery Time</h6>
                                @foreach ($availability['deliveryTimes'] as $dtime)
                                    <div class="d-flex fw-bold">
                                        <span class="fs-2">
                                            <strong class="me-2">From</strong>
                                            {{ date('h:i A', strtotime($dtime->start)) }}</span>
                                        <span class="fs-2"> <strong class="mx-2">To</strong>
                                            {{ date('h:i A', strtotime($dtime->end)) }}</span>
                                    </div>
                                @endforeach
                            @else
                                <span class="text-danger fw-bolder " class="fs-2">🚚 Delivery Closed</span>
                                 @foreach ($availability['deliveryTimes'] as $dtime)
                                    <div class="d-flex fw-bold">
                                        <span class="fs-2">
                                            <strong class="me-2">From</strong>
                                            {{ date('h:i A', strtotime($dtime->start)) }}</span>
                                        <span class="fs-2"> <strong class="mx-2">To</strong>
                                            {{ date('h:i A', strtotime($dtime->end)) }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="text-md-start">
                            @if (isset($availability['is_pickup_open'],$vendor->vendor_details->isPickup, $vendor->vendor_details->restaurant_status) && $availability['is_pickup_open'] && $vendor->vendor_details->isPickup==1 && $vendor->vendor_details->restaurant_status==1)
                                <h6 class="fs-2">🧺 Pickup Time</h6>
                                @foreach ($availability['pickupTimes'] as $dtime)
                                    <div class="d-flex fw-bold">
                                        <span class="fs-2">
                                            <strong class="me-2">From</strong>
                                            {{ date('h:i A', strtotime($dtime->start)) }}</span>
                                        <span class="fs-2"> <strong class="mx-2">To</strong>
                                            {{ date('h:i A', strtotime($dtime->end)) }}</span>
                                    </div>
                                @endforeach
                            @else
                                <span class="text-danger fw-bolder" class="fs-2">🧺 Pickup Closed</span>
                                @foreach ($availability['pickupTimes'] as $dtime)
                                    <div class="d-flex fw-bold">
                                        <span class="fs-2">
                                            <strong class="me-2">From</strong>
                                            {{ date('h:i A', strtotime($dtime->start)) }}</span>
                                        <span class="fs-2"> <strong class="mx-2">To</strong>
                                            {{ date('h:i A', strtotime($dtime->end)) }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
            <!-- Delivery Information -->
            <h6 class="mt-3 fs-2"><strong><i class="fas fa-truck me-2"></i> Delivery Information:</strong></h6>
            <p class="mb-1 fs-2">
                @isset($vendor->vendor_details->minimum_price)
                    <i class="fas fa-hand-holding-usd me-2"></i> Minimum Order: €{{ number_format($vendor->vendor_details->minimum_price, 2) }}
                @else
                    Minimum order information not available
                @endisset
            </p>
            <p class="mb-1 fs-2">
                @isset($vendor->vendor_details->delivery_cost)
                    <i class="fas fa-shipping-fast me-2"></i> Delivery Cost: €{{ number_format($vendor->vendor_details->delivery_cost, 2) }}
                @else
                    Delivery cost information not available
                @endisset
            </p>        
            <!-- Address Section -->
            <h6 class="mt-3 fs-2"><strong><i class="fas fa-map-marker-alt me-2"></i> Address:</strong></h6>
            <p class="mb-1 fs-2">
                @isset($vendor->vendor_details)
                    {{ $vendor->vendor_details->company_street ?? 'Street not available' }}
                    <br/>
                    {{ $vendor->vendor_details->company_zipcode ?? 'Zipcode not available' }}
                    
                    {{ $vendor->vendor_details->company_city ?? 'City not available' }}
                    <br/>
                    {{ $vendor->vendor_details->company_state ?? 'State not available' }}
                @else
                    Address not available
                @endisset
            </p>

            <!-- Contact Information -->
            <h6 class="mt-3 fs-2"><i class="fas fa-tty me-2"></i><strong>Contact Information:</strong></h6>
           
            <a href="tel:{{$vendor->vendor_details->company_phone ?? ''}}" class="mb-1 fs-2 text-dark d-block">
                @isset($vendor->vendor_details->company_phone)
                    <i class="fas fa-phone-alt me-2"></i> Phone: {{ $vendor->vendor_details->company_phone }}
                @endisset
            </a>
            <a href="{{$vendor->vendor_details->shop_url ?? ''}}" class="mb-1 fs-2 text-dark d-flex flex-wrap">
                @isset($vendor->vendor_details->shop_url)
                    <span><i class="fas fa-globe me-2"></i>Online Shop:</span> {{ $vendor->vendor_details->shop_url ?? '' }}
                @endisset
            </a>
            <a href="mailto:{{$vendor->vendor_details->company_email ?? ''}}" class="mb-1 fs-2 text-dark d-block">
                @isset($vendor->vendor_details->company_email)
                    <i class="fas fa-envelope me-2"></i> Email: {{ $vendor->vendor_details->company_email }}
                @endisset
            </a>
             <a class="mb-1 fs-2 text-dark d-block">
                @isset($vendor->vendor_details->vendor_full_name)
                    <i class="fas fa-user me-2"></i> Owner: {{ $vendor->vendor_details->vendor_full_name }}
                @endisset
            </a>
            <!-- Services Section -->
            <h6 class="mt-3 fs-2"><strong><i class="fas fa-concierge-bell me-2"></i> Available Services:</strong></h6>
            <ul class="list-unstyled fs-2">
                @if (isset($vendor->vendor_details))
                    @if ($vendor->vendor_details->isDelivery)
                        <li><i class="fas fa-check-circle text-success me-2"></i> Delivery</li>
                    @endif
                    @if ($vendor->vendor_details->isPickup)
                        <li><i class="fas fa-check-circle text-success me-2"></i> Pickup</li>
                    @endif
                    @if ($vendor->vendor_details->isTable)
                        <li><i class="fas fa-check-circle text-success me-2"></i> Table Service</li>
                    @endif
                
                @endif
            </ul>

           
        </div>
    </div>
</div>

    </div>
  </div>
</div>

  <!--Delivery info-->
   <div class="modal fade" id="vendorDeliveryInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg ">
    <div class="modal-content rounded-1">
      <div class="modal-header">
        <h1 class="modal-title fs-3" id="staticBackdropLabel">Delivery Service & Pickup Service Info</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-0 pb-0 pt-0">
    <div class="card rounded-0 border-0 p-0 m-0">
        <div class="card-header rounded-0 bg-primary text-center text-white">
            <h5 class="card-title fs-3 text-white mb-0">
                <i class="fas fa-utensils"></i> 
                {{ isset($vendor->name) ? $vendor->name : 'No Vendor Name Available' }}
            </h5>
        </div>
        <div class="card-body main-scrolled">
          <div class="vendor-opening-times">
    <h3 class="fw-bold fs-3 text-center">🚚 Delivery Times</h3>
       @php
    $currentDay = date('l'); // Get current day (e.g., "Monday")
@endphp
    @if (isset($vendor->vendor_opening_times) && !empty($vendor->vendor_opening_times))
      <table class="table table-bordered fs-3" style="vertical-align: middle; border-color:black !important;">
    <thead>
        <tr>
            <th class="text-center">Day</th>
            <th class="text-center">Opening Times</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vendor->vendor_opening_times as $time)
            @php
                $isCurrentDay = ($time['day'] ?? '') === $currentDay;
            @endphp
            <tr style="{{ $isCurrentDay ? 'background-color: #d4edda; color: #155724;' : '' }}">
                <td class="text-center">
                    {{ $time['day'] ?? '' }}
                </td>
                <td>
                    @php
                        $deliveryTimes = isset($time['delivery_times']) ? json_decode($time['delivery_times'], true) : [];
                    @endphp
                    @if (!empty($deliveryTimes) && $time['is_delivery'] == 1)
                        @foreach ($deliveryTimes as $slot)
                            <p class="my-1 text-center">
                                {{ isset($slot['start']) ? date('h:i A', strtotime($slot['start'])) : '' }} - 
                                {{ isset($slot['end']) ? date('h:i A', strtotime($slot['end'])) : '' }}
                            </p>
                        @endforeach
                    @else
                        <p class="my-1 text-center">Closed</p>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
    @else
        <p class="text-center">Closed</p>
    @endif
</div>
          <div class="vendor-opening-times text-center">
    <h3 class="fw-bold fs-3 mt-2 text-center" >🧺 Pickup Times</h3>
    @if (isset($vendor->vendor_opening_times) && !empty($vendor->vendor_opening_times))
        <table class="table table-bordered fs-3 " style="vertical-align: middle;border-color:black !important;">
            <thead>
                <tr>
                    <th class="text-center">Day</th>
                    <th class="text-center">Opening Times</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendor->vendor_opening_times as $time)
                 @php
                  $isCurrentDay = ($time['day'] ?? '') === $currentDay;
                 @endphp
                    <tr style="{{ $isCurrentDay ? 'background-color: #d4edda; color: #155724;' : '' }}">
                        <td class="text-center">
                            {{ $time['day'] ?? '' }}
                        </td>
                        
                        <td>
                            @php
                                $pickupTimes = isset($time['pickup_times']) ? json_decode($time['pickup_times'], true) : [];
                            @endphp
                            @if (!empty($pickupTimes) && $time['is_pickup']==1)
                                @foreach ($pickupTimes as $slot)
                                    <p class="my-1 text-center">{{ isset($slot['start'])?date('h:i A',strtotime($slot['start'])):"" }} - {{ isset($slot['end'])?date('h:i A',strtotime($slot['end'])):"" }}</p>
                                                                   
                                @endforeach
                            @else
                                <p class="my-1 text-center">Closed</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center">Closed</p>
    @endif
</div>
          <div class="delivery-areas">
                            <h5 class="fw-bold fs-3 text-center">Delivery Areas/Min Order Value</h5>

                            @if (isset($vendor->delivery_areas) && count($vendor->delivery_areas) > 0)
                            
                            <table class="table table-bordered fs-3" style="table-layout: fixed; vertical-align: middle; border-color:black !important;">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="vertical-align: top;">Area Name and Postal Code</th>
                                        <th class="text-center">Minimum order value and Delivery fees</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vendor->delivery_areas as $index => $area)
                                    @if(isset($area['status']) && $area['status'])
                                    <tr class="delivery-row" style="{{ $index >= 0 ? 'display:none;' : '' }}">
                                        <td style="width:50%" class="text-center">
                                            {{ $area['area_name'] ?? '' }}
                                            <br>
                                            ({{ $area['postcode'] ?? '' }})
                                        </td>
                                        <td style="width:50%">
                                            Min Order Price: &euro;{{ $area['min_order_price'] ?? '0.00' }}
                                            <br>
                                            Delivery Charge: &euro;{{ $area['delivery_charge'] ?? '0.00' }}
                                            <br>
                                            Free Delivery Min Price: &euro;{{ $area['min_order_price_free_delivery'] ?? '0.00' }}
                                            <br>
                                            Max Delivery Time: {{ $area['max_delivery_time'] ?? '0' }} mins
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
<div class="d-flex justify-content-center mb-2 position-sticky top-0">
                                <button class="btn btn-primary" id="show-more-btn" onclick="toggleRows()">Show More Information   <i class="fas fa-chevron-down"></i></button>
                            </div>
                            @else
                            <p>No delivery areas available</p>
                            @endif
                        </div>
          <script>
                            function toggleRows() {
                                const rows = document.querySelectorAll('.delivery-row');
                                const showMoreBtn = document.getElementById('show-more-btn');
                                const mainScroll = document.querySelector('.main-scrolled'); 
                                rows.forEach((row, index) => {
                                    if (index >= 0) {
                                        row.style.display = row.style.display === 'none' ? '' : 'none';
                                    }
                                });
                                const allRowsVisible = Array.from(rows).every(row => row.style.display === '');
                                showMoreBtn.innerHTML = allRowsVisible ? 'Show Less Information  <i class="fas fa-chevron-up"></i>' : 'Show More Information  <i class="fas fa-chevron-down"></i>';
                                 if (allRowsVisible && mainScroll) {
                                       setTimeout(() => {
            mainScroll.scrollTo({ top: mainScroll.scrollHeight, behavior: 'smooth' });
        }, 100); 
                                 }
                            }
                        </script>
        </div>
    </div>
</div>

    </div>
  </div>
</div>

   <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title fs-3 fw-bold" id="staticBackdropLabel">
                    <i class="bi bi-star-fill me-2"></i>Customer Reviews From {{ $vendor->name ?? '_'}}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Overall Rating Summary -->
                <div class="rating-summary bg-light py-4 px-4 border-bottom">
                    <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap">
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="overall-rating-display me-4">
                                <div class="display-3 fw-bold text-primary mb-1" id="averageRating">0.0</div>
                                <div class="stars-large mb-1" id="overallStars">
                                    <span class="text-warning">☆☆☆☆☆</span>
                                </div>
                            </div>
                            <div class="rating-info">
                                <div class="fs-5 fw-bolder text-dark">Overall Rating</div>
                                <div class="text-muted">
                                    Based on <span class="fw-bold text-primary" id="totalReviewsCount">0</span> ratings
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary fs-6 px-3 py-2" style="line-height:normal;" id="ratingBadge">
                                0.0 ★
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<style>
    .bg-gradient-primary {
        background: red !important;
    }
    .bi-star-fill{
        color: gold !important;
    }
    .stars-large {
        font-size: 1.5rem;
        letter-spacing: 2px;
    }
    
    .review-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border: 1px solid #eef2f7;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .review-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    
    .review-rating {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    
    .rating-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #ff6b35;
        margin-right: 10px;
    }
    
    .rating-stars {
        color: #ffc107;
        font-size: 1.1rem;
        letter-spacing: 2px;
    }
    
    .review-message {
        color: #2d3748;
        line-height: 1.6;
        font-size: 1rem;
        background: #f8fafc;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid #667eea;
        margin-top: 0.5rem;
    }
    
    .review-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
        font-size: 0.85rem;
        color: #718096;
    }
    
    .review-date {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .report-btn {
        font-size: 0.85rem;
        padding: 0.25rem 0.75rem;
    }
    
    .badge {
        font-size: 1.1rem;
        font-weight: 600;
    }
</style>
    
    <!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Report a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Help us keep our platform safe by reporting inappropriate reviews. Please select a reason and provide details.</p>
                
                <input type="hidden" id="reportReviewId">

                <label for="reportReason" class="fw-bold">Reason for Reporting:</label>
                <div class="custom-select-wrapper">
                            <div class="custom-select">
                                
                <select id="reportReason" class="custom-select mb-3">
                    <option value="">Select a reason</option>
                    <option value="spam">Spam or Advertisement</option>
                    <option value="hate_speech">Hate Speech or Harassment</option>
                    <option value="false_information">False Information</option>
                    <option value="inappropriate_content">Inappropriate Content</option>
                    <option value="other">Other</option>
                </select>
</div>
</div>
                <label for="reportMessage" class="fw-bold">Additional Details:</label>
                <textarea id="reportMessage" class="form-control fs-2 p-2 bg-white" rows="3" placeholder="Provide more details (optional)"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id="submitReport" class="btn btn-danger">Submit Report</button>
            </div>
        </div>
    </div>
</div>


@endsection
@section('external-js')
    <script>
        $(document).ready(function() {
            function toggleCartOverlay() {
                $('#cartOverlay').toggleClass('show');
            }

            $('#openCartOverlay').on('click', function() {
                if ($(window).width() < 1200) {
                    toggleCartOverlay();
                }
            });

            $('#closeCartOverlay').on('click', function() {
                if ($(window).width() < 1200) {
                    toggleCartOverlay();
                }
            });
            $('#closeCartOverlay2').on('click', function() {
                if ($(window).width() < 1200) {
                    toggleCartOverlay();
                }
            });
            $('#closeCartOverlay3').on('click', function() {
                if ($(window).width() < 1200) {
                    toggleCartOverlay();
                }
            });

            let resizeTimeout;
            $(window).on('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    if ($(window).width() >= 1200) {
                        $('#cartOverlay').removeClass('show');
                    }
                }, 200);
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.body.classList.add("loading");
        });

        window.addEventListener("load", function() {
            const loader = document.getElementById("loader");
            loader.style.display = "none";
            document.body.classList.remove("loading");
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        
        let isPickupSelected = false;
        let isDeliverOpen = "{{ $availability['delivery_start'] ?? '' }}";
        let isPickOpen = "{{ $availability['pickup_start'] ?? ''}}";
        let isDeliverOpenNed = "{{ $availability['is_delivery_open']}}";
        let isPickOpenNed = "{{ $availability['is_pickup_open']}}";

        
        $('#toggleDeliveryPickup').on('change', function() {
            isPickupSelected = this.checked;
            getCart();
        });
      document.addEventListener('DOMContentLoaded', function() {
          
          const checkbox = document.getElementById('toggleDeliveryPickup');
          const switchContainer = document.getElementById('switch-container');
          const switchSlider = document.getElementById('switch-slider');
          const switchLabels = document.querySelectorAll('.switch-label');
          
          function switchChanged() {
             if (checkbox.checked) {
               switchContainer.classList.add('checked');
               switchSlider.textContent = '🧺 Pickup';
              } else {
               switchContainer.classList.remove('checked');
               switchSlider.textContent = '🚚 Delivery';
              }
             checkbox.dispatchEvent(new Event('change'));
            }
           switchChanged();
           switchContainer.addEventListener('click', function() {
            isPickupSelected = !checkbox.checked;
            checkbox.checked = !checkbox.checked;
            switchChanged();
            });  
        });   
      $(document).on('click', '.show-more-btn', function() {
                            // console.log('clicked');
                            const $hiddenItems = $(this).prev('.hidden-items');
                            $hiddenItems.toggle(); // Show/hide the hidden items
                            $(this).html($hiddenItems.is(':visible') ? '— &nbsp; Show Less' :
                                `+ &nbsp;${$hiddenItems.find('li').length} Show more`); // Toggle button text
                        });
        function displayCartItems(cartItems,mainDiscount, area) {
            let cartContainer = $('#cartContainer');
            let delivery_cost = 0;
            let min_order_price = 0;
            let free_on = 0;
            
            let discounts=mainDiscount;
             
            let onResturantDiscount=discounts?.onResturant;
            let onCategoryDiscount=discounts?.onCategory;
            let totalDisc=parseFloat(onResturantDiscount)+parseFloat(onCategoryDiscount);
             
            let isDeliveryMin = true;
            let min_order_price_free_delivery = 0;
            if (area != undefined && area != null && area.length != 0) {
                delivery_cost = area?.delivery_charge;
                min_order_price = area?.min_order_price;
                
                min_order_price_free_delivery = area?.min_order_price_free_delivery;
                if (cartItems != null && cartItems != undefined && cartItems.length != 0) {
                    var totalPrice = 0;
                    var calCaulation = '';
                    var DeliveryCost = 0;
                    var PickupCost = 0;
                    var totalPricePay = 0;
                    var cartProductQty = 0;
                    cartContainer.empty(); 

                    $.each(cartItems, function(index, item) {
                        totalPrice = parseFloat(totalPrice) + parseFloat(item.total_price);
                        var food_item = item?.food_item;
                        var hasFoodVar = food_item?.hasVariants;
                        var hasFoodCollections = food_item?.collections;
                        cartProductQty+=item.quantity || 0;
                        var iconEdit = (hasFoodVar == 1 || (hasFoodCollections != '' && hasFoodCollections !=
                                null)) ?
                            `<a class='p-1 mt-2 btn btn-sm btn-outline-dark text-dark bg-white' title="Edit Food" onclick="updateCartProduct(${item?.id})" style="font-size:13px;cursor:pointer;float:right;">Edit Article <i class="fa-solid fa-pencil text-success" style="margin-left:3px;" aria-hidden="true"></i></a>` :
                            '';
                        imaUrl = (food_item?.image) ? "{{ asset('uploads/menu/') }}/" + food_item?.image :
                            "{{ asset('uploads/foodu.png') }}";

                        var isAlco = (item?.isAlcohol == 1) ? "<span style='font-size:10px;' class='btn btn-sm fw-bold btn-outline-danger text-danger p-0 px-1 mx-2 bg-white'>18+</span>" : "";
                        var dressing = (item?.dressing) ? item?.dressing : "";
                        var food_variant = item?.variant?.variant_item;
                        var foodvarName = (hasFoodVar == 1) ? `(${food_variant?.name})` : '';
                        var liElement = `${food_item.food_item_name} ${foodvarName} ${isAlco} `;

                        var extrasAdded = '';
                        var extrasDressing = '';

                        if (item?.collection_items) {
                            // Sort `collection_items` by `collection_data.sort`, with null values first
                            item.collection_items.sort((a, b) => {
                                const sortA = a.collection_data?.sort;
                                const sortB = b.collection_data?.sort;

                                if (sortA === null && sortB !== null) return -1;
                                if (sortA !== null && sortB === null) return 1;
                                return sortA - sortB;
                            });

                            let itemsInCollection = [];

                            $.each(item.collection_items, function(index, collectionItem) {
                                const subItemName = collectionItem?.sub_items?.name;

                                // Add items to either Dressing or Added collections based on `isMultiple`
                                if (collectionItem?.collection_data?.isMultiple != 'empty') {
                                    itemsInCollection.push(subItemName);
                                }
                            });

                            // Create a list with "Show More" functionality for items
                            if (itemsInCollection.length > 0) {
                                extrasAdded +=
                                    `<ul class="collection-list mb-0 px-0" style="list-style:none;">${renderListWithShowMore(itemsInCollection)}</ul>`;
                            }
                        }

                        // Function to render the list with a "Show More" button
                        function renderListWithShowMore(items) {
                            let output = '';
                            const visibleItems = items.slice(0, 2); // First 2 items to show
                            const hiddenItems = items.slice(2); // Remaining items

                            // Generate list items for the first 2 items
                            visibleItems.forEach(item => {
                                output += `<li class="d-flex">+ <span class="ml-2">${item}</span></li>`;
                            });

                            // Create a hidden div for remaining items, shown when "Show More" is clicked
                            if (hiddenItems.length > 0) {
                                output += `<div class="hidden-items" style="display: none;">`;
                                hiddenItems.forEach(item => {
                                    output += `<li class="d-flex">+ <span class="ml-2">${item}</span></li>`;
                                });
                                output += `</div>`;
                                output +=
                                    `<a href="javaScript:void(0)" class="show-more-btn mb-2 fw-bolder text-primary" type="button" style="font-size:16px;">+ &nbsp; ${hiddenItems.length} Show more</a>`;
                            }

                            return output;
                        }

                        var isTrash=(item.quantity==1)?` <i
                    data-id="${item.id}"
                    class="fa-solid removeProduct fa-trash text-dark"
                    style="cursor: pointer"
                ></i>`:`<button
                    style="height: 25px !important; width: 13px !important"
                    class="btn p-0 btn-outline-dark btn-sm bg-white overflow-hidden btn-decrease text-dark fs-3"
                    data-id="${item.id}"
                >
                   <i class="fa-solid fa-minus"></i>
                </button>`;
                       




                        let card = `<div class="col-md-12 mb-2">
    <div class="row">
        <div class="col-7 text-start ">
            <span
                style="font-size: 17px"
                class="mt-2 fw-bold d-flex align-items-baseline"
                onclick="updateCartProduct(${item?.id})"
                >${item.quantity} <span class="text-muted px-1">x</span> ${liElement}
            </span>
           ${extrasAdded}
           <abbr class="text-danger">${item?.extra_note ? item?.extra_note : ""}</abbr>
        </div>
        <div class="col-5 ">
            <div class="pb-2 text-end" style="font-size: 17px">
                <span class="mb-0 text-dark text-end fw-bold"
                    >${item.total_price} €</span
                >
            </div>
            <div
                class="qty-box d-flex align-items-center justify-content-end  mt-md-0"
            >
               
                ${isTrash}
                <input
                    style="height: 25px !important; width: 30px !important; font-size:18px;color:#000 !important;"
                    type="text"
                    class="form-control text-center bg-white  text-dark mx-2 p-0"
                    value="${item.quantity}"
                    data-id="${item.id}"
                    readonly
                />
                <button
                    style="height: 25px !important; width: 20px !important;font-size:35px !important;"
                    class="btn p-0 btn-outline-dark bg-white btn-sm btn-increase fs-3 text-dark"
                    data-id="${item.id}"
                >
                    +
                </button>
            </div>
        </div>
       
        <div class="col-12 mt-3">
            <!-- Add Note Section -->
            <div class="note-section w-100 mt-2">
                <span
                    class="p-1 me-2 text-danger btn-sm btn btn-outline-dark add-note-btn  bg-white"
                    data-id="${item.id}"
                    style="cursor: pointer; font-size: 13px; float: left"
                >
                    Add Note
                </span>
                ${iconEdit}
                <div
                    class="note-input-section w-100"
                    style="display: none; margin-top: 2px"
                >
                    <textarea
                        class="form-control my-2 note-input p-2 bg-white"
                        placeholder="Enter your note here"
                    >${item?.extra_note ? item?.extra_note : ""}</textarea>
                    <div class="d-flex justify-content-center">
                        <button
                            class="btn btn-outline-dark btn-sm bg-white text-dark save-note-btn px-2 py-1 me-4"
                            data-id="${item.id}"
                        >
                             <i class="fa-solid fa-check text-dark"></i>
                             Save
                        </button>
                        <button
                            class="btn btn-outline-dark bg-white text-dark btn-sm close-note-btn px-2 py-1"
                            data-id="${item.id}"
                        >
                             <i class="fa-solid fa-x text-dark"></i>
                             Remove
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>`;
                        cartContainer.append(card);
                    });
                    
                    // console.log(totalPrice)
                    var leftTotalPrice=parseFloat(totalPrice)-parseFloat(totalDisc);
                    if (totalPrice >= min_order_price_free_delivery) {
                        DeliveryCost = 0;
                    } else {
                        DeliveryCost = parseFloat(delivery_cost);
                    }
                    totalPricePay = isPickupSelected ? (parseFloat(totalPrice)-parseFloat(totalDisc)) : (parseFloat(totalPrice) + parseFloat(DeliveryCost)-parseFloat(totalDisc));
                    if (totalPricePay < min_order_price) {
                        isDeliveryMin = false;
                    } else {
                        isDeliveryMin = true;
                    }
                    
                    var disElement='';
                    // alert(totalDisc)
                    if(totalDisc>0){
                        disElement=`<li class="d-flex justify-content-between fw-bold text-success"><strong class="text-dark">Discount:</strong> - ${totalDisc.toFixed(2)} €</li>`;
                    }

                    // alert(totalPricePay)
                    calCaulation = `
                    <li class="d-flex justify-content-between fw-bold"><strong>Sub Total:</strong> ${totalPrice.toFixed(2)} €</li>
                    ${disElement}
                    <li class="d-flex justify-content-between mt-1 fw-bold text-dark ${isPickupSelected ? 'd-none' : ''}" id="deliveryPrice"><strong class="text-dark">Delivery Costs:</strong> +${DeliveryCost.toFixed(2)} €</li>
                    
                    <li class="d-flex justify-content-between mt-1 fw-bold"><strong>Total Price:</strong> ${totalPricePay.toFixed(2)} €</li>
                `;
                    $('#priceCart').html(`${totalPricePay.toFixed(2)} &euro;`);
                    $('#qtyCart').html(`${cartProductQty}`);
                    // Append calculation at the end
                   
                     var leftAm=(parseFloat(min_order_price)-parseFloat(totalPricePay)).toFixed(2);
                    if(parseFloat(min_order_price_free_delivery)<=totalPrice){
                      var isPass='';  
                    }else{
                      var isPass=(parseFloat(min_order_price_free_delivery)>0)?`<small style="font-size:14px;" class="text-center w-100 d-block fw-bold">Free Delivery On Order: ${min_order_price_free_delivery}€</small>`:'';
                    }
                    var isLeft=(parseFloat(min_order_price)>parseFloat(totalPricePay))?`<small style="font-size:14px;" class="text-center w-100 d-block fw-bold">Add <span class="text-danger">${leftAm}€</span> more to reach ${min_order_price}€ min order</small>`:'';
                    var buttonCheck = true;
                    var checkoutMesg='';
                    if (isPickupSelected) {
                        isLeft='';
                        
                        isDeliveryMin=true;
                        buttonCheck = ((isPickOpen!='' && isPickOpen!=null) || isPickOpenNed) ? true : false ;
                        if(buttonCheck){
                            checkoutMesg="";
                        }else{
                            checkoutMesg='<p class="mb-0 text-center text-danger">Sorry! Pickup not available at this time.</p>';
                        }
                    } else {
                        buttonCheck = ((isDeliverOpen!='' && isDeliverOpen!=null) || isDeliverOpenNed) ? true : false;
                         if(buttonCheck){
                            checkoutMesg="";
                        }else{
                            checkoutMesg='<p class="mb-0 text-center text-danger">Sorry! Delivery not available at this time.</p>';
                        }
                    }
                    
                    var isDisable = isDeliveryMin ? '' : 'disabled';
                    var isDisableClass = isDeliveryMin ? 'btn btn-primary' : 'btn btn-white d-none text-dark opacity-1';
                    var classNone = buttonCheck ? '' : 'd-none';
                   
                    // console.log(isPass);
                    $('#cartcheckout').html(
                        `<div id="checkoutgroup" class="w-100"> 
                      <ul class="mx-0 px-0">
                       ${calCaulation}
                      </ul>
                      ${isLeft}
                     <button ${isDisable} class=" ${isDisableClass} w-100 rounded-1 checkoutbtnnow fw-bold ${classNone}" type="button" id="checkoutNowBtn">Checkout Now</button>
                        ${isPass}
                        ${checkoutMesg}
                        </div>
                        
                        `
                    );

                   
                    $('.add-note-btn').click(function() {
                       const noteSection = $(this).siblings('.note-input-section');
                       noteSection.stop(true, true).slideToggle();
                       noteSection.find('textarea').focus();
                      if (noteSection.is(':visible')) {
                         $('#cartContainer').stop(true, true).animate({
                          scrollTop: $('#cartContainer').scrollTop() + 10 * parseFloat(getComputedStyle(document.documentElement).fontSize)
                         }, 300);
                      } else {
                        $('#cartContainer').stop(true, true).animate({
                            scrollTop: $('#cartContainer').scrollTop() - 10 * parseFloat(getComputedStyle(document.documentElement).fontSize)
                      }, 300); 
                      }
                    });

                    // Close Note Button Click Event
                    $('.close-note-btn').click(function() {
                        $(this).closest('.note-input-section').hide();
                         var itemId = $(this).data('id');
                         var noteText = '';

                        $.ajax({
                            url: '{{ route('cart.update.note') }}',
                            method: 'POST',
                            data: {
                                cart_item_id: itemId,
                                extra_note: noteText,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                // toastr.success('Note Removed successfully!');
                                $(`.save-note-btn[data-id="${itemId}"]`).closest('.note-input-section')
                                    .hide();
                                getCart();
                            },
                            error: function(xhr, status, error) {
                                toastr.error('Error removing note. Please try again.');
                            }
                        });
                    });

                    // Save Note Button Click Event
                    $('.save-note-btn').click(function() {
                        var itemId = $(this).data('id');
                        var noteText = $(this).closest('.note-input-section').find('.note-input').val();

                        $.ajax({
                            url: '{{ route('cart.update.note') }}',
                            method: 'POST',
                            data: {
                                cart_item_id: itemId,
                                extra_note: noteText,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                toastr.success('Note saved successfully!');
                                $(`.save-note-btn[data-id="${itemId}"]`).closest('.note-input-section')
                                    .hide();
                                getCart();
                            },
                            error: function(xhr, status, error) {
                                toastr.error('Error saving note. Please try again.');
                            }
                        });
                    });
                } else {
                    $('#cartcheckout').html('');
                    cartContainer.html(
                        `<i class="fa-solid fa-bag-shopping fs-2 text-center"></i>
                                <h5 class="text-center fs-1 mt-2 fw-bold">Fill your basket</h5>
                                <small class="text-center ">Your basket is empty</small>`
                    );
                    $('#priceCart').html(`&euro; 0.00`);
                    $('#qtyCart').html(`0`);

                }
            } else {
                $('#cartcheckout').html('');
                cartContainer.html(`<p class="text-center">Please choose a location on home page!</p>`);
                $('#priceCart').html(`&euro; 0.00`);
                $('#qtyCart').html(`0`);
            }


        }

        $(document).on('click', '.btn-increase', function() {
            let input = $(this).siblings('input');
            let newQty = parseInt(input.val()) + 1;
            input.val(newQty);
            updateCart($(this).data('id'), newQty);
            getCart();
        });
        $(document).on('click', '.removeProduct', function() {
            updateCart($(this).data('id'), 0);
            getCart();
        });

        // Handle quantity decrease
        $(document).on('click', '.btn-decrease', function() {
            let input = $(this).siblings('input');
            let newQty = parseInt(input.val()) - 1;
            if (newQty >= 1) {
                input.val(newQty);
                updateCart($(this).data('id'), newQty);
                getCart();
            } else {
                input.val(0);
                updateCart($(this).data('id'), 0);
                // location.reload();
                getCart();
            }
        });
        $(document).on('click', '#checkoutNowBtn', function() {
            // alert('yes');
            if (isPickupSelected) {
                var method = "pickup";
            } else {
                var method = "delivery";
            }
            // alert('Please wait. We are on development mode. Thank you!');
            window.location.href = "{{ route('checkout.now') }}/" + method;
        })

        function getCart() {
            // alert('hello')
            var location_address = localStorage.getItem('location');
            // alert(location_address);
            var postalCode = 203001;
            if (location_address) {
                location_address = JSON.parse(location_address);
                postalCode = location_address?.postalCode;
                if (!postalCode) {
                    // alert('here 1');
                    window.location.href = "{{ route('home') }}";
                }
            } else {
                    // alert('here 2');
                window.location.href = "{{ route('home') }}";
            }
            $.ajax({
                url: "{{ route('cart.get') }}",
                method: "POST",
                data: {
                    postalcode: postalCode,
                    vendor_id: "{{ $vendor->id }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status) {
                        // console.log(response);
                        if (response.area == null) {
    Swal.fire({
        title: 'Address Required!',
        html: `
            <p>Please set your address on the home page.</p>
            <p>Without choosing your delivery address, we cannot deliver/pick up.</p>
            <p class="text-danger"><strong>Postcode/Address is mandatory to view cart items.</strong></p>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, I give now',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#000',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '{{route("home")}}'; // Redirect to home page
        }
    });
}

                        let cartItems = response.data;
                        let mainDiscount=response?.discounts;
                        displayCartItems(cartItems,mainDiscount,response.area);
                    }
                },
                error: function(er) {
                    console.log(er);
                }
            });
        }

        getCart();


        function updateCart(itemId, quantity) {
            $.ajax({
                url: "{{ route('cart.update') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cart_id: itemId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.status) {
                        // console.log(response);
                        getCart();
                    } else {
                        getCart();

                    }
                }
            });
        }



        let editbasePrice = 0;
        let edittotalPrice = 0;
        let editcurrentQty = 1;
        let edit_dressing = 0;
        let edit_collections = [];
        let collectionIds = [];
        let isAlocoEd = 0;

        function updateCartProduct(cartId) {
            // alert(cartId)
            $.ajax({
                url: '{{ route('cart.get.product.detail') }}',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    cart_item_id: cartId
                },
                success: function(response) {
                    // console.log(response)
                    $('#editfoodModalContent').data('id', response.food.id);
                    $('#editfoodModalLabel').text(response.food.food_item_name);
                    $('#editfoodDescription').text(response.food.description);
                    $('.edit-qty-input').val(response?.cart?.quantity);
                    editbasePrice = response.food.base_price;
                    var edHasVariant = response?.food?.hasVariants;
                    isAlocoEd = response.cart.isAlcohol;
                    edit_collections = response?.collections;
                    edit_dressing = response?.cart?.dressing_type;


                    // Load variants in select
                    $('#editvariantSelect').empty();
                    if (edHasVariant == 1) {
                        $('#editfoodVariantsSelect').removeClass('d-none');
                        $.each(response?.food?.variants, function(key, variant) {
                            var edit_food_select = (variant?.id == response?.cart?.variant_id) ?
                                "selected" : "";
                            $('#editvariantSelect').append(
                                `<option ${edit_food_select} value="${variant.id}" data-key="${variant.variant_id}" data-price="${variant.price}">${variant.variant_item.name} (€${variant.price})  ${variant.variant_item.other_info}</option>`
                            );
                        });

                    } else {
                        $('#editfoodVariantsSelect').addClass('d-none');

                        $('#editfoodDefaultPrice').val(response?.food?.delivery_price);
                    }

                    // Load extras and other data
                    let varinats = response?.cart?.variant;
                    let dressing = response?.cart?.dressing_type;
                    collectionIds = response?.extraIds;

                    edit_loadExtras(response?.collections, collectionIds, varinats?.variant_id, dressing);
                    editcurrentQty = response?.cart?.quantity;
                    updateTotalPrice();
                    $('#editfoodModal').modal('show');
                }
            });
        }



        // function to load extras based on the selected variant
        function edit_loadExtras(extras, checks, variant_id, dressing) {
            $('#editextrasContainer').empty();
            edit_loadCheckboxItems('#editextrasContainer', extras, checks, 'edit-extra-checkbox', variant_id, dressing);
        }

        function checkValueInArray(checks, value) {

            if (Array.isArray(checks) && checks !== null && checks.length > 0) {

                if (checks.map(Number).includes(value)) {
                    return 'checked';
                } else {
                    return '';
                }
            } else {
                return '';
            }
        }
        // Function to load and show checkbox items (toppings, extras, etc.)
        function edit_loadCheckboxItems(container, collections, checks, classNamed, variant_id, dressing) {
            $(container).empty();
            $.each(collections, function(key, collection) {
                const items = collection?.collection_items;
                const collectionType = collection?.type;
                var className = "class-gn-" + collectionType;
                const isMultiple = collection?.isMultiple;
                const collectionBlock = $('<div>', {
                    class: 'collection-block mt-3'
                });

                const maxVisibleItems = 5;
                const showMoreButton =
                    `<p class="show-more-btn cursor-pointer text-primary pb-0 mb-0 fs-1 mt-2">Show More</p>`;
                const showLessButton =
                    `<p class="show-less-btn cursor-pointer text-primary pb-0 mb-0 fs-1 mt-2">Show Less</p>`;

                // Check if the collection type is 'dressing'
                if (collectionType === 'dressing' || isMultiple == 0) {
                    collectionBlock.append(`<h5>${collection.name} <span class="text-danger">*</span></h5>`);

                    const selectDropdown = $('<select>', {
                        class: `form-select edit_single_extras bg-white w-100 py-2  px-2 rounded-0 ${className}-select ${classNamed}-select`,
                        id: `editdressing_type`
                    });


                    $.each(items, function(index, item) {
                        var isDrSelect = checkValueInArray(checks, item?.id) == "checked" ? "selected" : "";
                        let dprice = item?.dprice;
                        let price = item?.prices[variant_id] || dprice;
                        let sub_item = item?.sub_items?.name;
                        let isPrice = price == 0 ? "" : `<span>${price}€</span>`;
                        // let isDrSelect = (dressing == item?.id) ? "selected" : '';
                        selectDropdown.append(
                            `<option ${isDrSelect} value="${item.id}" data-price="${price}">${sub_item} ${isPrice}</option>`
                        );
                    });
                    collectionBlock.append(selectDropdown);
                } else {
                    collectionBlock.append(`<h5>${collection.name}</h5>`);
                        let deposit_bottle = collection?.return_price!="" && collection?.return_price!=null?`<p class="py-0 my-0 text-capitalize fw-semibold fs-1">(${collection?.return_price}€ Deposit Refund on Bottle Return) </p>`:"";
                    $.each(items, function(index, item) {
                        var isChecked = checkValueInArray(checks, item?.id);
                        let dprice = item?.dprice;
                        let price = item?.prices[variant_id] || dprice;
                        let sub_item = item?.sub_items?.name;
                        let sub_item_info = item?.sub_items?.info;
                        let collection_type = item?.sub_items?.type;
                        let isPrice = price == 0 ? "" : `<span>+${price}€</span>`;
                        let isAlcohol = collection_type == 'alcohol-drink' || collection?.isAlcohal;
                        var flagAlcohal = (isAlcohol) ?
                            "<span class='badge bg-danger'>18+ Age</span>" : ""
                        const checkboxId = `${className}-${key}-${index}`;

                        // Create checkbox and append it
                        const checkboxItem = $(`
                                               <div class="mb-2">
                                                   <div class="form-check align-items-center ${className}-item" style="display:${index < maxVisibleItems ? 'flex' : 'none'};">
                                                       <input ${isChecked} id="${checkboxId}" style="height:25px; width:25px;" 
                                                           class="form-check-input mt-0 me-2 rounded-0 ${classNamed}" 
                                                           type="checkbox" value="${item.id}" data-price="${price}" ${isAlcohol ? 'data-alcohol="true"' : ''}>
                                                       <label class="form-check-label d-flex justify-content-between w-100 fw-semibold text-dark mb-0 pb-0" for="${checkboxId}">
                                                             <span>
                                                              ${sub_item} <i style="font-size:15px;cursor:pointer;" class="fa fa-info-circle info-checkbox  text-muted me-2" data-info="${(sub_item_info!="" && sub_item_info!=null)?sub_item_info:"Information not found!"}"></i>${flagAlcohal}
                                                              <br>
                                                              ${deposit_bottle}
                                                             </span>
                                                             
                                                             ${isPrice}  
                                                       </label>
                                                       
                                                   </div>
                                                   
                                               </div>
                                              `);
 
                        collectionBlock.append(checkboxItem);

                        // Attach event listener for alcohol confirmation
                        if (isAlcohol) {
                            checkboxItem.find(`#${checkboxId}`).on('change', function() {
                                const checkbox = $(this);

                                if (checkbox.is(':checked')) {
                                    if (!isAlocoEd) {
                                        Swal.fire({
                                            title: 'Age Confirmation',
                                            text: 'Are you 18 years or older?',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'Yes, I am 18+',
                                            cancelButtonText: 'No',
                                            confirmButtonColor: '#f41909'
                                        }).then((result) => {
                                            if (!result.isConfirmed) {
                                                checkbox.prop('checked',
                                                    false
                                                );
                                            } else {
                                                isAlocoEd = 1;
                                            }
                                        });
                                    }

                                } else {
                                    isAlocoEd = 0;
                                }
                            });
                        }
                    });

                    if (items.length > maxVisibleItems) {
                        collectionBlock.append(showMoreButton);

                        collectionBlock.on('click', '.show-more-btn', function() {
                            $(`.${className}-item`).slice(maxVisibleItems).show();
                            $(`.${className}-info`).slice(maxVisibleItems).show();
                            $(this).replaceWith(showLessButton);
                        });

                        collectionBlock.on('click', '.show-less-btn', function() {
                            $(`.${className}-item`).slice(maxVisibleItems).hide();
                            $(`.${className}-info`).slice(maxVisibleItems).hide();
                            $(this).replaceWith(showMoreButton);
                        });
                    }
                     collectionBlock.on('click','.info-checkbox', function () {
                           const infoText = $(this).data('info');
                           Swal.fire({
                    title: 'Information',
                    text: infoText,
                    icon: 'info',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#f41909'
                });
                        });
                }
                $(container).append(collectionBlock);
            });
        }

        // Update extras prices based on selected variant
        $('#editvariantSelect').on('change', function() {
            let selectedVariant_Id = $(this).val();
            let dataKey = $(this).find(':selected').data('key');
            edit_loadExtras(edit_collections, collectionIds, dataKey, edit_dressing);
            updateTotalPrice();
        });

        // Helper function to calculate total price
        function updateTotalPrice() {
            let edittotalPrice = 0;

            // Get selected variant price
            let variantPrice = parseFloat($('#editvariantSelect option:selected').data('price')) || 0;
            edittotalPrice += variantPrice == undefined ? 0 : variantPrice;


            let editfoodDefaultPrice = $('#editfoodDefaultPrice').val();
            editfoodDefaultPrice = (editfoodDefaultPrice == undefined) ? 0 : parseFloat(editfoodDefaultPrice);
            edittotalPrice += editfoodDefaultPrice;

            // Get selected extras price
            $('#editextrasContainer input[type=checkbox]:checked, .edit_single_extras option:selected').each(function() {
                edittotalPrice += parseFloat($(this).data('price'));
            });

            let qtyInput = $('.edit-qty-input');
            let editcurrentQty = parseInt(qtyInput.val()) || 1;
            let edit_total = edittotalPrice * editcurrentQty;
            // Update the modal's total price display
            $('#edittotalPrice').text(`${edit_total.toFixed(2)}€`);
            
            $('#totalCostPay').val(edittotalPrice.toFixed(2) * editcurrentQty);
        }
        $('.modal-body').on('change',
            '.edit-extra-checkbox, .edit_single_extras',
            function() {
                updateTotalPrice();
            });
        // Quantity controls
        $('.edit-increase-qty').click(function() {
            let qtyInput = $('.edit-qty-input');
            let editcurrentQty = parseInt(qtyInput.val()) || 1;
            qtyInput.val(editcurrentQty + 1);
            updateTotalPrice();
        });

        $('.edit-decrease-qty').click(function() {
            let qtyInput = $('.edit-qty-input');
            let editcurrentQty = parseInt(qtyInput.val()) || 1;
            if (editcurrentQty > 1) {
                qtyInput.val(editcurrentQty - 1);
            }
            updateTotalPrice();
        });

        // Add to cart functionality

        $('.modal-footer').on('click', '.edit-to-cart-btn', function() {
            let editfoodId = $('#editfoodModalContent').data('id');
            let editselectedVariantId = $('#editvariantSelect').val();
            let editselectedExtras = [];
            let editdressing_type = $('#editdressing_type').val();

            $('.edit-extra-checkbox:checked, .edit_single_extras option:selected').each(function() {
                editselectedExtras.push($(this).val());
            });
            edittotalPrice = $('#totalCostPay').val();
            let qtyInput = $('.edit-qty-input');
            let editcurrentQty = parseInt(qtyInput.val()) || 1;
            // alert(edittotalPrice)
            var dataCart = {
                _token: "{{ csrf_token() }}",
                food_id: editfoodId,
                variant_id: editselectedVariantId,
                quantity: editcurrentQty,
                extras: editselectedExtras,
                dressing_type: editdressing_type,
                isAlcohal: isAlocoEd,
                total_price: edittotalPrice
            };
            // console.log(dataCart);
            if (editdressing_type == 0) {
                alert('Please select a dressing');
            } else {
                $.ajax({
                    url: '{{ route('cart.store') }}',
                    method: 'POST',
                    data: dataCart,
                    success: function(response) {
                        if (response.status) {
                            // toastr.success('Item updated to cart successfully');
                        } else {
                            toastr.error('Sorry we could not added your item in food.');
                        }
                        getCart();
                        $('#editfoodModal').modal('hide');
                    },
                    error: function(err) {
                        console.error(err);
                        toastr.error('Please login first.')
                    }
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            let basePrice = 0;
            let totalPrice = 0;
            let currentQty = 1;
            let extras = []; // To store extras and update their prices
            let isAloco = 0;
            // Function to open modal and load food details
            $('.view-food-details').on('click', function(event) {
                let foodId = $(this).data('id');
                let hasVariant = $(this).data('hasvariant');
                let hasCollections = $(this).data('collections');
                // alert(hasCollections);
                let foodtype = $(this).data('foodtype');
                let foodprice = $(this).data('foodprice');

                if ($(event.target).closest('.info-ico').length > 0) {
                    return;
                }
                if (hasVariant == 1 || (hasCollections != '' && hasCollections != null)) {
                    var urlGet = "{{ route('getFoodDetails') }}/" + foodId;
                    $.ajax({
                        url: urlGet,
                        method: 'GET',
                        success: function(response) {
                            // console.log(response);
                            // Set modal content
                            $('#foodModalContent').data('id', response?.data?.food?.id);
                            $('#foodModalLabel').text(response?.data?.food?.food_item_name);
                            $('#foodDescription').text(response?.data?.food?.description);
                            basePrice = response?.data?.food?.base_price;
                            collections = response?.data?.collections;


                            // Load variants in select
                            $('#variantSelect').empty();
                            if (hasVariant == 1) {
                                $('#foodVariantsSelect').removeClass('d-none')
                                $.each(response?.data?.food?.variants, function(key, variant) {
                                    $('#variantSelect').append(
                                        `<option value="${variant.id}" data-key="${variant.variant_id}" data-price="${variant.price}">${variant.variant_item.name} (€${variant.price})  ${variant.variant_item.other_info}</option>`
                                    );
                                });
                            } else {
                                $('#foodVariantsSelect').addClass('d-none')
                                $('#foodDefaultPrice').val(response?.data?.food
                                    ?.delivery_price);
                            }

                            // Load extras and other data
                            let varinats = response?.data?.food?.variants;
                            loadExtras(response?.data?.collections, varinats[0]?.variant_id);
                            currentQty = 1;
                            updatePrice();
                            $('#foodModal').modal('show');
                        }
                    });
                } else {
                    var hitAll=false;
                    if(foodtype){
                       Swal.fire({
                                                title: 'Age Confirmation',
                                                text: 'Are you 18 years or older?',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonText: 'Yes, I am 18+',
                                                cancelButtonText: 'No',
                                                confirmButtonColor: '#f41909'
                                            }).then((result) => {
                                                if (!result.isConfirmed) {
                                                   hitAll=false;
                                                } else {
                                                   var dataCart = {
                        _token: "{{ csrf_token() }}",
                        food_id: foodId,
                        variant_id: null,
                        quantity: 1,
                        extras: [],
                        dressing_type: null,
                        isAlcohal: foodtype,
                        total_price: foodprice
                    };
                    $.ajax({
                        url: '{{ route('cart.store') }}',
                        method: 'POST',
                        data: dataCart,
                        success: function(response) {
                            if (response.status) {
                                // toastr.success('Item added to cart successfully');
                            } else {
                                toastr.error('Sorry we could not added your item in food.');
                                window.location.href = "{{ route('login') }}"
                            }
                            getCart();
                        },
                        error: function(err) {
                            console.error(err);
                            toastr.error('Please login first.')
                            window.location.href = "{{ route('login') }}"
                            
                        }
                    });
                                                }
                                            });
                    }else{
                        var dataCart = {
                        _token: "{{ csrf_token() }}",
                        food_id: foodId,
                        variant_id: null,
                        quantity: 1,
                        extras: [],
                        dressing_type: null,
                        isAlcohal: foodtype,
                        total_price: foodprice
                    };
                    $.ajax({
                        url: '{{ route('cart.store') }}',
                        method: 'POST',
                        data: dataCart,
                        success: function(response) {
                            if (response.status) {
                                // toastr.success('Item added to cart successfully');
                            } else {
                                toastr.error('Sorry we could not added your item in food.');
                                window.location.href = "{{ route('login') }}"
                            }
                            getCart();
                        },
                        error: function(err) {
                            console.error(err);
                            toastr.error('Please login first.')
                            window.location.href = "{{ route('login') }}"
                            
                        }
                    });
                    }
                    
                }
            });



            function loadExtras(extras, variant_id) {
                // alert(variant_id);
                $('#extrasContainer').empty();
                loadCheckboxItems('#extrasContainer', extras, 'extra-checkbox', variant_id);
            }


            function loadCheckboxItems(container, collections, classNamed, variant_id) {
                $(container).empty();
                $.each(collections, function(key, collection) {
                    const items = collection?.collection_items;
                    const collectionType = collection.type;
                    var className = "class-en-" + collectionType;
                    const isMultiple = collection.isMultiple;
                    const collectionBlock = $('<div>', {
                        class: 'collection-block  mt-3'
                    });

                    const maxVisibleItems = 5;
                    const showMoreButton =
                        `<p class="show-more-btn cursor-pointer text-primary pb-0 mb-0 fs-1 mt-2">Show More</p>`;
                    const showLessButton =
                        `<p class="show-less-btn cursor-pointer text-primary pb-0 mb-0 fs-1 mt-2">Show Less</p>`;

                    // Check if the collection type is 'dressing'
                    if (collectionType === 'dressing' || isMultiple == 0) {
                        collectionBlock.append(
                            `<h5>${collection.name} <span class="text-danger">*</span></h5>`);

                        const selectDropdown = $('<select>', {
                            class: `form-select single_extras bg-white w-100 py-2  px-2 rounded-0 ${className}-select ${classNamed}-select`,
                            id: `dressing_type`
                        });

                        // selectDropdown.append(
                        //     `<option value="0" data-price="0">Please select an option</option>`);

                        $.each(items, function(index, item) {

                            let dprice = item?.dprice;
                            let price = item?.prices[variant_id] || dprice;
                            let sub_item = item?.sub_items?.name;
                            let isPrice = price == 0 ? "" : `<span>${price}€</span>`;
                            selectDropdown.append(
                                `<option value="${item.id}" data-price="${price}">${sub_item} ${isPrice}</option>`
                            );
                        });
                        collectionBlock.append(selectDropdown);
                    } else {
                        collectionBlock.append(`<h5>${collection.name}</h5>`);
                        $.each(items, function(index, item) {
                            let dprice = item?.dprice;
                            let price = item?.prices[variant_id] || dprice;
                            let sub_item = item?.sub_items?.name;
                            let deposit_bottle = collection?.return_price!="" && collection?.return_price!=null?`<p class="py-0 my-0 text-capitalize fw-semibold fs-1">(${collection?.return_price}€ Deposit Refund on Bottle Return) </p>`:"";
                            let sub_item_info = item?.sub_items?.info;
                            let collection_type = item?.sub_items?.type;

                            let isPrice = price == 0 ? "" : `<span>+${price}€</span>`;
                            let isAlcohol = (collection_type == 'alcohol-drink' || collection?.isAlcohal);
                            var flagAlcohal = (isAlcohol) ? "<span class='badge bg-danger'>18+ Age</span>" : ""
                            const checkboxId = `${className}-${key}-${index}`;

                            // Create checkbox and append it
                            const checkboxItem = $(`
                                               <div class="mb-2">
                                                   <div class="form-check  align-items-start ${className}-item" style="display:${index < maxVisibleItems ? 'flex' : 'none'};">
                                                       <input id="${checkboxId}" style="height:25px; width:25px;" 
                                                           class="form-check-input mt-0 me-2 rounded-0 ${classNamed}" 
                                                           type="checkbox" value="${item.id}" data-price="${price}" ${isAlcohol ? 'data-alcohol="true"' : ''}>
                                                       <label class="form-check-label d-flex justify-content-between w-100 text-dark fw-semibold mb-0 pb-0" for="${checkboxId}">
                                                            <span>
                                                             
                                                              ${sub_item}
                                                              <i style="font-size:15px;cursor:pointer;" class="fa fa-info-circle info-checkbox  text-muted me-2" data-info="${(sub_item_info!="" && sub_item_info!=null)?sub_item_info:"Information not found!"}">
                                                              </i>
                                                              ${flagAlcohal}
                                                              <br>
                                                              ${deposit_bottle}
                                                            </span>
                                                            ${isPrice}  
                                                            
                                                       </label>
                                                       
                                                   </div>
                                               </div>
                                              `);

                            collectionBlock.append(checkboxItem);

                            // Attach event listener for alcohol confirmation
                            if (isAlcohol) {
                                checkboxItem.find(`#${checkboxId}`).on('change', function() {
                                    const checkbox = $(this);

                                    if (checkbox.is(':checked')) {
                                        if (!isAloco) {

                                            Swal.fire({
                                                title: 'Age Confirmation',
                                                text: 'Are you 18 years or older?',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonText: 'Yes, I am 18+',
                                                cancelButtonText: 'No',
                                                confirmButtonColor: '#f41909'
                                            }).then((result) => {
                                                if (!result.isConfirmed) {
                                                    checkbox.prop('checked',
                                                        false
                                                    );
                                                } else {
                                                    isAloco = 1;
                                                }
                                            });
                                        }

                                    }
                                });
                            }
                        });
                        if (items.length > maxVisibleItems) {
                            collectionBlock.append(showMoreButton);

                            collectionBlock.on('click', '.show-more-btn', function() {
                                $(`.${className}-item`).slice(maxVisibleItems).show();
                                $(`.${className}-info`).slice(maxVisibleItems).show();
                                $(this).replaceWith(showLessButton);
                            });

                            collectionBlock.on('click', '.show-less-btn', function() {
                                $(`.${className}-item`).slice(maxVisibleItems).hide();
                                $(`.${className}-info`).slice(maxVisibleItems).hide();
                                $(this).replaceWith(showMoreButton);
                            });
                            
                        }
                        collectionBlock.on('click','.info-checkbox', function () {
                           const infoText = $(this).data('info');
                           Swal.fire({
                    title: 'Information',
                    text: infoText,
                    icon: 'info',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#f41909'
                });
                        });
                    }
                    $(container).append(collectionBlock);
                });
            }



            // Update extras prices based on selected variant
            $('#variantSelect').on('change', function() {
                let selectedVariantId = $(this).val();
                let dataKey = $(this).find(':selected').data('key');

                loadExtras(collections, dataKey);
                updatePrice();
            });
            
            // Function to update the price
            function updatePrice() {
                let selectedVariantPrice = parseFloat($('#variantSelect option:selected').data('price')) ||
                    basePrice;
                selectedVariantPrice = selectedVariantPrice == undefined ? 0 : selectedVariantPrice;
                let foodDefaultPrice = $('#foodDefaultPrice').val();
                foodDefaultPrice = (foodDefaultPrice == undefined) ? 0 : parseFloat(foodDefaultPrice);
                let extraCost = 0;

                $('.extra-checkbox:checked, .single_extras option:selected')
                    .each(function() {
                        // console.log($(this).val())
                        extraCost += parseFloat($(this).data('price')) || 0;
                    });

                totalPrice = (selectedVariantPrice + extraCost + foodDefaultPrice) * currentQty;
                $('#totalPrice').text(`${totalPrice.toFixed(2)}€`);
            }

            // Update price when extras or toppings are selected
            $('.modal-body').on('change',
                '.extra-checkbox,.single_extras',
                function() {
                    updatePrice();
                });

            // Increase quantity
            $('.modal-footer').on('click', '.increase-qty', function() {
                currentQty++;
                $('.qty-input').val(currentQty);
                updatePrice();

            });

            // Decrease quantity
            $('.modal-footer').on('click', '.decrease-qty', function() {
                if (currentQty > 1) {
                    currentQty--;
                    $('.qty-input').val(currentQty);
                    updatePrice();
                }
            });

            // Add to cart functionality
            $('.modal-footer').on('click', '.add-to-cart-btn', function() {
                let foodId = $('#foodModalContent').data('id');
                let selectedVariantId = $('#variantSelect').val();
                let selectedExtras = [];
                let dressing_type = $('#dressing_type').val();


                $('.extra-checkbox:checked,.single_extras option:selected').each(function() {
                    selectedExtras.push($(this).val());
                });
                if (dressing_type == 0) {
                    toastr.warning('Please select a dressing');
                } else {

                    currentQty = $('.qty-input').val();
                    var dataCart = {
                        _token: "{{ csrf_token() }}",
                        food_id: foodId,
                        variant_id: selectedVariantId,
                        quantity: currentQty,
                        extras: selectedExtras,
                        dressing_type: dressing_type,
                        isAlcohal: isAloco,
                        total_price: totalPrice
                    };
                    // console.log(dataCart);
                    $.ajax({
                        url: '{{ route('cart.store') }}',
                        method: 'POST',
                        data: dataCart,
                        success: function(response) {
                            if (response.status) {
                                // toastr.success('Item added to cart successfully');
                            } else {
                                toastr.error('Sorry we could not added your item in food.');
                                window.location.href = "{{ route('login') }}"
                            }
                            getCart();
                            $('#foodModal').modal('hide');
                        },
                        error: function(err) {
                            console.error(err);
                            toastr.error('Please login first')
                            window.location.href = "{{ route('login') }}"
                        }
                    });
                }
            });
        });
    </script>
    <script>
        function isFavorite(vendor_id, e) {
            var isFav = (e.target.checked === true) ? 1 : 0;

            $.ajax({
                url: '{{ route('addFavorite') }}',
                method: 'POST',
                data: {
                    vendor_id: vendor_id,
                    status: isFav,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    if (response.status) {
                        if (e.target.checked) {
                            $('#heart-icon').addClass('favorit')
                        } else {
                            $('#heart-icon').removeClass('favorit')
                        }
                        toastr.success(response.message);
                    } else {
                        toastr.info(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    $('#addcard .modal-body').html(
                        '<p>An error occurred while loading the data.</p>');
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.info-ico').forEach(function(element) {
                element.addEventListener('click', function(event) {
                    event.stopPropagation();
                    // Get the data attributes from the clicked info icon
                    let cereal = this.getAttribute('data-cereal');
                    let nuts = this.getAttribute('data-nuts');
                    let furthers = this.getAttribute('data-furthers');
                   
                    // Parse the data (JSON encoded), if null, set default values
                    cereal = (cereal !== 'null' && cereal!="") ? JSON.parse(cereal) : '';
                    nuts = (nuts !== 'null' && nuts !== '') ? JSON.parse(nuts) : '';
                    furthers = (furthers !== 'null' && furthers !== '') ? JSON.parse(furthers) : '';

                   
                    var innerContAllergy='';
                    if(cereal!=""){
                        innerContAllergy+=`<p><strong>Cereal:</strong> <span>${cereal}</span></p>`;
                    }
                    if(nuts!=""){
                        innerContAllergy+=`<p><strong>Nuts:</strong> <span>${nuts}</span></p>`;
                    }
                    if(cereal!=""){
                        innerContAllergy+=`<p><strong>Furthers:</strong> <span>${furthers}</span></p>`;
                    }
                    // console.log(innerContAllergy);
                    $('#modalAllergines').html(innerContAllergy);
                    

                    // Show the modal
                    var modal = new bootstrap.Modal(document.getElementById('foodInfoModal'), {
                        keyboard: false
                    });
                    modal.show();
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let stickyContainer = document.getElementById("stickycontainer");
            let cartOverlaym = document.getElementById("cartOverlay");
            let slideContainer = document.getElementById("slidecontainer");
            let navTopBar = document.getElementById("navbar");
            const scrollToTopBtn = document.getElementById('scrollToTopBtn');
            if (stickyContainer && slideContainer) {
                let initialStickyPosition = stickyContainer.offsetTop;
                let isFixed = false;

                function checkScroll() {
                    
                    let windowScroll = window.pageYOffset || document.documentElement.scrollTop;
                    let slideContainerOffset = slideContainer.getBoundingClientRect().top;
                    let combinedScroll = windowScroll - slideContainerOffset + slideContainer.scrollTop;
                    
                     if (windowScroll > 100 || combinedScroll > 100) {
                          scrollToTopBtn.style.display = 'flex';
                      } else {
                           scrollToTopBtn.style.display = 'none';
                      }
   
                    if ((windowScroll > initialStickyPosition || combinedScroll > initialStickyPosition) && !
                        isFixed) {
                        navTopBar.style.display = "none";
                        cartOverlaym.classList.remove('pt-md-5')
                        isFixed = true;
                    } else if (windowScroll <= initialStickyPosition && combinedScroll <= initialStickyPosition &&
                        isFixed) {
                        navTopBar.style.display = "block";
                        cartOverlaym.classList.add('pt-md-5')
                        isFixed = false;
                    }
                }
                window.addEventListener("scroll", checkScroll);
                slideContainer.addEventListener("scroll", checkScroll);
                
        scrollToTopBtn.addEventListener('click', () => {
           
            window.scrollTo({
                top: 0,
                behavior: 'smooth',
            });

           
            slideContainer.scrollTo({
                top: 0,
                behavior: 'smooth',
            });
        });
            }
        });
    </script>
     <script>
        $(document).ready(function(){
            $('#show-search').click(function(){
                $('#hidden-div').fadeIn(1000);
            });
            $('#closesearch').click(function(){
                $('#hidden-div').fadeOut(1000);  
            });
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('staticBackdrop2');
    var reportModal = document.getElementById('reportModal'); 
    var reportModalInstance = new bootstrap.Modal(reportModal, { backdrop: 'static' });
    
    modal.addEventListener('shown.bs.modal', function(event) {
        var triggerElement = event.relatedTarget;
        var vendorId = triggerElement.getAttribute('data-vendor-id');
        var authUserId = "{{ auth()->user()->id ?? '' }}";
        var url = "{{ route('shop.fetch.shop.details') }}/" + vendorId;
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Update overall rating display
                var avgRating = data.average_rating.toFixed(1);
                document.getElementById('averageRating').textContent = avgRating;
                document.getElementById('ratingBadge').textContent = avgRating + ' ★';
                document.getElementById('overallStars').innerHTML = generateStarRating(data.average_rating, 'large');
                document.getElementById('totalReviewsCount').textContent = data.total_reviews;
                
                
                // Clear and populate reviews list
                var reviewsList = document.getElementById('reviewsList');
                var noReviewsMessage = document.getElementById('noReviewsMessage');
                
                if (data.reviews && data.reviews.length > 0) {
                    if (noReviewsMessage) noReviewsMessage.style.display = 'none';
                    reviewsList.innerHTML = '';
                    
                    // data.reviews.forEach(review => {
                    //     var reviewCard = createReviewCard(review, authUserId, vendorId);
                    //     reviewsList.appendChild(reviewCard);
                    // });
                } else {
                    if (noReviewsMessage) noReviewsMessage.style.display = 'block';
                }
                
                // Add report button event listeners
                setupReportButtons();
            })
            .catch(error => {
                console.error('Error fetching vendor details:', error);
                document.getElementById('reviewsList').innerHTML = `
                    <div class="text-center py-5">
                        <i class="bi bi-exclamation-triangle display-6 text-danger mb-3"></i>
                        <p class="text-danger">Failed to load reviews. Please try again.</p>
                    </div>
                `;
            });
    });
    
    function generateStarRating(rating, size = 'normal') {
        var fullStars = Math.floor(rating);
        var hasHalfStar = (rating % 1) >= 0.5;
        var emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
        
        var stars = '';
        stars += '<span class="' + (size === 'large' ? 'stars-large' : 'rating-stars') + '">';
        stars += '<i class="bi bi-star-fill"></i>'.repeat(fullStars);
        if (hasHalfStar) {
            stars += '<i class="bi bi-star-half"></i>';
        }
        stars += '<i class="bi bi-star"></i>'.repeat(emptyStars);
        stars += '</span>';
        
        return stars;
    }
    
    function createReviewCard(review, authUserId, vendorId) {
        var reviewCard = document.createElement('div');
        reviewCard.className = 'review-card';
        
        reviewCard.innerHTML = `
            <div class="review-rating">
                <div class="rating-value">${review.rating.toFixed(1)}</div>
                ${generateStarRating(review.rating)}
            </div>
            
            <div class="review-message">
                ${review.review_msg || 'No message provided'}
            </div>
            
            <div class="review-meta">
                <div class="review-date">
                    <i class="bi bi-calendar"></i>
                    ${formatDate(review.date)}
                </div>
                ${authUserId == vendorId ? `
                <div>
                    <button class="btn btn-outline-danger btn-sm report-btn" 
                            data-review-id="${review.id}" 
                            data-review-msg="${review.review_msg || ''}"
                            data-bs-toggle="modal" 
                            data-bs-target="#reportModal">
                        <i class="bi bi-flag"></i> Report
                    </button>
                </div>
                ` : ''}
            </div>
        `;
        
        return reviewCard;
    }
    
    function formatDate(dateString) {
        var date = new Date(dateString);
        var options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return date.toLocaleDateString('en-US', options);
    }
    
    function setupReportButtons() {
        document.querySelectorAll('.report-btn').forEach(button => {
            button.addEventListener('click', function() {
                var reviewId = this.getAttribute('data-review-id');
                var reviewMsg = this.getAttribute('data-review-msg');
                document.querySelector('#reportReviewId').value = reviewId;
                document.querySelector('#reportMessage').value = reviewMsg;
                document.querySelector('#reportReason').value = '';
                document.querySelector('#additionalDetails').value = '';
                reportModalInstance.show();
            });
        });
    }
    
    // Report submission
    document.getElementById('submitReport')?.addEventListener('click', function() {
        var reviewId = document.querySelector('#reportReviewId').value;
        var reportMessage = document.querySelector('#reportMessage').value;
        var reportReason = document.querySelector('#reportReason').value;
        var additionalDetails = document.querySelector('#additionalDetails').value;
        
        if (!reportReason.trim()) {
            alert("Please select a reason for reporting.");
            return;
        }
        
        var csrfToken = "{{csrf_token()}}";
        
        fetch("{{ route('review.report') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({
                review_id: reviewId,
                message: reportMessage,
                reason: reportReason,
                additional_details: additionalDetails
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data?.success){
                toastr.success(data.message);
                document.getElementById('reportMessage').value = "";
                document.getElementById('reportReason').value = "";
                document.getElementById('additionalDetails').value = "";
                reportModalInstance.hide();   
            } else {
                toastr.error(data.message);  
            }
        })
        .catch(error => console.error('Error submitting report:', error));
    });
    
    reportModal.addEventListener('hidden.bs.modal', function() {
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
        document.body.classList.remove('modal-open');
        document.body.style.paddingRight = '';
    });
});

// Add Bootstrap Icons if not already included
if (!document.querySelector('link[href*="bootstrap-icons"]')) {
    var link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css';
    document.head.appendChild(link);
}
</script>
    <script>
        $(document).ready(function () {
          const maxLength = 300;
          $(".textcontent-desc").each(function () {
        const content = $(this).text();
        if (content.length > maxLength) {
            const truncatedContent = content.substring(0, maxLength) + "...";
            $(this).addClass('truncated').data('full-text', content).text(truncatedContent);
        }
    });
          $(".readmore-desc").on("click", function () {
        const $textContent = $(this).siblings(".textcontent-desc");

        if ($textContent.hasClass("truncated")) {
            $textContent.removeClass("truncated").text($textContent.data("full-text"));
            $(this).text("Read Less");
        } else {
            const fullText = $textContent.text();
            const truncatedContent = fullText.substring(0, maxLength) + "...";
            $textContent.addClass("truncated").text(truncatedContent);
            $(this).text("Read More");
        }
    });
        });

    </script>
    <script>
        document.addEventListener('visibilitychange', function () {
    if (document.visibilityState === 'visible') {
        location.reload();
    }
});

window.addEventListener('focus', function () {
    location.reload(); 
});
//     </script>
@endsection
