@extends('external.frame')
@section('external-css')
    <style>
     .bg-1000 {
            display: none !important;
        }
        
        .favorit {
            color: #ff0000 !important;
        }
        .textcontent-desc {
    display: inline;
}
body{
    background:white !important;
}
.textcontent-desc.truncated {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 300px; 
    display: inline-block;
    vertical-align: bottom;
}
        .owl-dots {
            width: 100%;
            text-align: center;
            margin-top: 1rem;
        }

        .owl-dot {
            height: 10px;
            width: 10px;
            border: 1px solid #ff1f1f !important;
            margin-right: 10px;
        }

        .owl-dot.active {
            background: #ff1f1f !important;
        }
       .nice-select{
           font-size:18px;
           font-weight:600;
           height:50px;
           line-height:51px;
       } 
       
    </style>
@endsection
@section('external-home-content')
    <section class="py-0  ">
        <div class="container pb-2 pt-0">
            <div class="card mt-0 border-0">
                        <div class="row gallery-block g-1">
                            <div class="col-md-12 ">
                                <div class="owl-carousel gallery-slider">
                                    @foreach ($gallery as $image)
                                        <div class="img-block rounded-2" style="height:auto !important;">
                                            <img src="{{ asset('uploads/gallery/' . $image->image) }}"
                                                class="img-fluid rounded-2" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <form method="post" action="{{ route('preBookTable') }}" class="card-body mt-2">
                            @csrf
                            <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2 class="fs-2 fw-bold card-title text-md-start text-center">{{ $vendor->name }}</h2>
                                        </div>
                                        
                                        <div class="col-md-12 mt-2">
                                            <p class="fs-1 descriptionText">
                                                <span class="textcontent-desc">
                                                 {{ isset($vendor->vendor_details->description) ? $vendor->vendor_details->description : 'Description not available.' }}
                                                </span>
                                               <a href="javascript:void(0);" class="readmore-desc text-primary">Read More</a>
                                             </p>
                                            
                                               @if(isset($todaySlot['is_table']) && $todaySlot['is_table']==1)
                                                <p class="rest-location d-flex flex-wrap flex-column align-items-md-start align-items-center  text-md-start text-center fs-1 fw-bold">
                                                    <span class="text-dark fs-2 fw-bold">
                                                        Open now
                                                    </span>
                                                    
                                                @foreach($todaySlot['start_end_times'] ?? [] as $timer)
                                                    <span class="text-dark">
                                                        {{date('h:i A',strtotime($timer['start']))}} To {{date('h:i A',strtotime($timer['end']))}}
                                                    </span>
                                                @endforeach
                                                </p>
                                                @else
                                                   <span class="text-danger fs-2 fw-bold">
                                                        Closed now
                                                    </span>
                                                @endif
                                            
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-4">

                                        <div class="col-12">
                                            <h5 class="fs-2 fw-bold text-md-start text-center">
                                                Select your booking details
                                            </h5>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <select id="seachable-select" name="table_date" class="wide selectize">
                                                
                                                <?php
                                                $start_date = new DateTime();
                                                for ($i = 0; $i < 7; $i++) {
                                                    $current_date = clone $start_date;
                                                    $current_date->modify("+$i days");
                                                    echo "<option value='" . $current_date->format('Y-m-d') . "'>" . $current_date->format('D, d F') . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <select id="seachable-select2" name="guest" class="wide selectize">

                                                <?php
                                                
                                                for ($i = 1; $i < 10; $i++) {
                                                    echo "<option value='" . $i . "'>" . $i . ' guest</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <select class="wide selectize" name="food_type">

                                                <option data-display="Select" value="lunch">Lunch</option>
                                                <option value="dinner">Dinner</option>
                                            </select>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <h5 class="fs-2 fw-bold text-md-start text-center">
                                                Please select your time slot
                                            </h5>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="slot-selection ">


                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <h5 class="fs-2 fw-bold text-md-start text-center">
                                                Choose an offer
                                            </h5>
                                        </div>
                                        <div id="offers-container" class="grid-wrapper grid-col-auto row w-100">
                                            <div class="w-100">
                                                <p class="text-danger text-md-start text-center w-100">Please select a time slot. Before continue.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="d-flex my-3 flex-wrap justify-content-md-start justify-content-center ">
                                                <h5 class="fs-2 me-3">Choose Table Menu Foods</h5>
                                                <button type="submit" class="btn text-light btn-primary fs-1 fw-bold">Choose
                                                    Menu</button>
                                            </div>

                                        </div>



                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
        </div>
    </section>

  
@endsection
@section('external-js')
    <script>
       document.addEventListener("DOMContentLoaded", function () {
    // Initialize NiceSelect for the dropdown
    var els = document.querySelectorAll(".selectize");
    els.forEach(function (select) {
        NiceSelect.bind(select);
    });

    // Handle the change event for the date dropdown
    const dateDropdown = document.querySelector("#seachable-select");
    dateDropdown.addEventListener("change", function () {
        const selectedDate = this.value;
        const vendorId = "{{$vendor->id}}";
        $.ajax({
            url: '{{route("shop.table.times")}}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                vendor_id: vendorId,
                date: selectedDate
            },
            success: function (response) {
                if (response.success) {
                    
                    const slotContainer = document.querySelector(".slot-selection");
                    slotContainer.innerHTML = ''; 
                    
                    response.slots.forEach(function (time) {
                        const slotHtml = `
                            <label onclick="getOffers(${response.vendorTableTimeId})">
                                <input type="radio" name="slot" value="${time}" 
                                    class="slot-input" >
                                <h6 class="text-center mb-0 fs-1">${time}</h6>
                                <small class="text-primary text-center d-block">${response.offers} Offers</small>
                            </label>`;
                        slotContainer.insertAdjacentHTML('beforeend', slotHtml);
                    });
                    const slotInputs = document.querySelectorAll('.slot-input');

                    slotInputs.forEach(input => {
                input.addEventListener('change', function() {
                    slotInputs.forEach(inp => inp.parentElement.style.borderColor = '#ddd');
                    if (this.checked) {
                        this.parentElement.style.borderColor = 'red';
                    }
                });
            });
                } else {
                    alert(response.message);
                    $('.slot-selection').html('<h6 class="text-center text-danger">No Slot Found!</h6>');
                }
            },
            error: function () {
                alert('An error occurred while fetching slots.');
            }
        });
    });
});

              function getOffers(id) {
                const slotId = id;
                var urlApi="{{url('/fetch-offers')}}/"+slotId;
                fetch(urlApi)
                    .then(response => response.json())
                    .then(data => {
                        const offersContainer = document.getElementById('offers-container');
                        offersContainer.innerHTML = '';
                        // console.log(data);
                        if (data.length > 0) {
                            data.forEach(offer => {
                                const imgVal = "{{ asset('uploads/offer/') }}/" + offer.image;
                                const disType = (offer.discount_type == "percentage") ? "%" :
                                    "€";
                                const offerHtml = `
                            <label class="radio-card col-lg-3 col-md-5 col-sm-6">
                                <input type="radio" name="offer" value="${offer.id}" />
                                <div class="card-content-wrapper">
                                    <span class="check-icon"></span>
                                    <div class="card-content">
                                        <div class="text-center d-flex justify-content-center">
                                            <img src="${imgVal}" style="height:3rem; " alt="${offer.title}" />
                                        </div>
                                        <h6 class=" fw-medium text-center">${offer.title}</h6>
                                        <h4>${offer.discount} ${disType} OFF</h4>
                                        <h5>Upto € ${offer.upto_price}</h5>
                                    </div>
                                </div>
                            </label>
                        `;
                                offersContainer.insertAdjacentHTML('beforeend', offerHtml);
                            });
                        } else {
                            offersContainer.innerHTML = '<p class="fw-bold">No offers available for this slot.</p>';
                        }
                    })
                    .catch(error => console.error('Error fetching offers:', error));
            }

    </script>
    <script>
        
        $("#menu-card").click(function() {
            $("#panel-card").slideToggle(1000);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.gallery-slider').owlCarousel({
                loop: true,
                margin: 20,
                dots: true,
                responsiveClass: true,
                items: 1
            })


            var owl = $(".gallery-slider");
            owl.owlCarousel();
            $(".next-btn").click(function() {
                owl.trigger("next.owl.carousel");
            });
            $(".prev-btn").click(function() {
                owl.trigger("prev.owl.carousel");
            });
            $(".prev-btn").addClass("disabled");
            $(owl).on("translated.owl.carousel", function(event) {
                if ($(".owl-prev").hasClass("disabled")) {
                    $(".prev-btn").addClass("disabled");
                } else {
                    $(".prev-btn").removeClass("disabled");
                }
                if ($(".owl-next").hasClass("disabled")) {
                    $(".next-btn").addClass("disabled");
                } else {
                    $(".next-btn").removeClass("disabled");
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
                    console.log(response);
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
@endsection
