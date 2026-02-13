@extends('external.frame')
@section('external-css')
    <style>
     .bg-1000 {
            display: none !important;
        }
        .card-input-element {
            display: none;
        }

        .card-label {
            cursor: pointer;

            padding: 15px;

            transition: all 0.3s ease-in-out;
        }

        .card-input-element:checked+.card-label {
            border: 2px solid #ff0400;
            position: relative;
        }

        .card-input-element:checked+.card-label::before {
            content: "✓";
            position: absolute;
            top: 10px;
            right: 10px;
            height: 30px;
            width: 30px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background-color: #f6f3f3a5;
            font-size: 1rem;
            font-weight: bolder !important;
            color: #ff0400 !important;
        }

        .custom-select-wrapper {
            position: relative;
            width: 100%;
        }

        .custom-select select {
            width: 100%;
            padding: 9px;
            border-radius: 8px;
            background-color: #fff;
            border: 1px solid #ddd;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .custom-select select:focus {
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

        .location-filter {
            height: 2.8rem !important;
            width: 2.8rem !important;
            background-color: #fff;
            color: #111;
            margin-left: 5px !important;
            outline: none !important;
            border: none !important;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd !important;
        }

        .map-view {
            height: 26rem;
            width: 100% !important;
            background-color: #111 !important;
            position: relative;

        }

        .google-map-area {
            height: 100%;
            width: 100%;
        }

        .google-map {
            height: 100%;
            width: 100%;
        }

        .backtolist {
            position: absolute;
            top: 1rem !important;
            left: 50%;
            transform: translateX(-50%);
            background-color: #111 !important;
            color: #ddd !important;
            outline: none !important;
            border: none !important;
            padding: 8px 12px;
            border-radius: 6px;
        }

        .ft-ic {
            font-size: 14px !important;
            padding: 3px 7px;
            background-color: #111;
            color: #ddd !important;
            position: absolute;
            right: 6%;
            bottom: 5%;
            border-bottom-left-radius: 10px;
            border-top-left-radius: 10px;
        }

        .btn-primary:hover {
            color: #fff !important;

        }

        .rating {
            direction: rtl;
            font-size: 20px;
        }

        .rating input[type="radio"] {
            display: none;
        }

        .rating label {
            cursor: pointer;
            color: #ddd;
            font-size: 20px;
        }

        .rating label:before {
            content: '\f005';
            font-family: "FontAwesome";
            color: #ddd;
        }

        .rating label:hover~label:before,
        .rating label:hover:before,
        .rating input[type="radio"]:checked~label:before {
            color: #ff5100;
        }

        .form-control:hover,
        .form-control:focus {
            box-shadow: none !important;
        }
    </style>
@endsection
@section('external-home-content')
   


    <section class="py-0 ">
        <div class="container-fluid py-5 pt-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-center mb-4">
                        <h5 class="text-center fs-1 fw-bold text-uppercase">Table Food Menu</h5>
                        <div class="col-md-4">

                            <form method="get" action="?" class="input-group">
                                <input type="search" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}"
                                    name="search" id="search" placeholder="Search your food here..."
                                    class="form-control px-3 bg-light">
                                <button class="btn btn-primary"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" action="{{route('addFoodToTable')}}" class="row">
                @csrf
                <input type="hidden" name="unid" value="{{$table_book->unid}}">
                <div class="col-md-8">
                    <div class="row">
                        @foreach ($foods as $food)
                            <div class="col-sm-4 col-md-4 mb-2">
                                <div class="card rounded-2 p-0">
                                    <input type="checkbox" @checked($loop->iteration==1) id="card{{ $food->id }}" name="foods[]"
                                        value="{{ $food->id }}" class="card-input-element" />
                                    <label for="card{{ $food->id }}" class="card-body p-0 card-label rounded-2 mb-0">
                                        <div class="card-img rounded-2 text-center" style="height:6rem;">
                                            <img src="{{ asset('uploads/table-foods/' . $food->image) }}" class="rounded-2"
                                                style="height:100%; " alt="">
                                        </div>
                                        <div class="p-2">
                                            <h5 class="mt-2 mb-0 pb-0" style="font-size: 14px; font-weight:700;">
                                                {{ $food->name }}
                                            </h5>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-success fw-bold" style="font-size: 13px;">€
                                                    {{ number_format($food->price) }}</span>
                                                <span class="text-danger"
                                                    style="font-size: 12px; text-decoration:line-through;">€
                                                    {{ $food->price * (intval($food->discount + 100) / 100) }}</span>
                                            </div>
                                            <span
                                                style="font-weight:500;font-size:13px;">{{ $food->category->name }}</span>
                                            <br>
                                            <small>
                                                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                                                {{ $food->preparation_time }} Min
                                            </small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card rounded-0 ">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="" class="fw-bold text-center">Extra Requirments / Message</label>
                                <textarea name="extra_note" class="form-control bg-light" rows="5" placeholder="Enter your requirement"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 fs-1 fw-bold w-100">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>


@endsection
@section('external-js')
    <script>
        $(document).ready(function() {
            $('.category_items').owlCarousel({
                loop: true,
                margin: 20,
                dots: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 3,
                        nav: false
                    },
                    600: {
                        items: 5,
                        nav: false
                    },
                    1000: {
                        items: 9,
                        nav: false,
                        loop: false
                    }
                }
            })
            var owl = $(".category_items");
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
@endsection
