@extends('external.frame')
@section('external-css')
<style>
    .bg-primary, .btn-primary {
        background-color: #f41909 !important;
        border-color: #f41909 !important;
    }
    .text-primary {
        color: #f41909 !important;
    }
    .bg-primary-gradient {
        background: linear-gradient(to right, #f41909, #ff5c4d) !important;
    }
    .divider {
        background-color: #f41909 !important;
    }
</style>
@endsection
@section('external-home-content')
<section class="py-5 overflow-hidden" id="home" style="background-color: #f41909;">
    <div class="container">
        <div class="row flex-center">
            <div class="col-md-5 d-flex justify-content-center col-lg-6 order-0 order-md-1 mt-8 mt-md-0">
                <img src="https://img.freepik.com/free-vector/food-delivery-isometric-concept_1284-18097.jpg" class="img-fluid  shadow" style="border-radius: 25px !important; height: 400px; object-fit: cover;" alt="Lieferfood Delivery">
            </div>
            <div class="col-md-7 col-lg-6 py-8 text-md-start text-center">
                <h1 class="display-1 fs-md-5 fs-lg-6 fs-xl-8 text-light">The Lieferfood Pay Card</h1>
                <h1 class="text-100 mb-5 fs-4">Enjoy delicious food moments anywhere with our <br class="d-none d-xxl-block" />corporate meal solutions</h1>
                <div class="card border-0 bg-transparent w-xxl-75">
                    <div class="d-flex justify-content-around flex-wrap">
                        <a class="btn btn-light btn-lg btn-block mb-3" href="#!" style="color: #f41909;"><i class="fa fa-phone-alt me-2" aria-hidden="true"></i> Book a call <i class="fa fa-arrow-right mx-2" aria-hidden="true"></i></a>
                        <a class="btn btn-light btn-lg btn-block mb-3" href="#!" style="color: #f41909;"><i class="fa fa-envelope me-2" aria-hidden="true"></i> Get Started <i class="fa fa-arrow-right mx-2" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-0 my-3 mt-0" style="background: linear-gradient(to right, #f41909, #ff5c4d);">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 mt-5">
                <h5 class="fs-5 fw-bold text-center text-white">What is Lieferfood for business?</h5>
                <div class="divider bg-white"></div>
                <p class="text-center mt-3 text-white">A comprehensive meal solution for modern workplaces. Empower your employees with flexible food options whether they're in the office, working remotely, or traveling for business.</p>
            </div>
           
            <div class="col-md-4 mt-3">
                <a href="" class="card shadow border-0 h-100">
                    <img src="https://img.freepik.com/free-vector/credit-card-payment-concept-illustration_114360-7413.jpg" class="card-img-top" alt="Corporate Cards" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="text-center fs-3 fw-bold" style="color: #f41909;">Corporate Cards</h5>
                        <p class="mt-3 text-center">
                            Prepaid cards accepted at thousands of restaurants and food vendors.
                        </p>
                        
                    </div>
                </a>
            </div>
            <div class="col-md-4 mt-3">
                <a href="" class="card shadow h-100 border-0">
                    <img src="https://img.freepik.com/free-vector/online-order-concept-illustration_114360-7300.jpg" class="card-img-top" alt="Digital Allowance" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="text-center fs-3 fw-bold" style="color: #f41909;">Digital Allowance</h5>
                        <p class="mt-3 text-center">
                            Flexible meal budgets with real-time spending controls and reporting.
                        </p>
                        
                    </div>
                </a>
            </div>
            <div class="col-md-4 mt-3">
                <a href="" class="card shadow border-0 h-100">
                    <img src="https://img.freepik.com/free-vector/gift-card-concept-illustration_114360-7420.jpg" class="card-img-top" alt="Gift Vouchers" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="text-center fs-3 fw-bold" style="color: #f41909;">Gift Vouchers</h5>
                        <p class="mt-3 text-center">
                            Reward employees and clients with meal vouchers redeemable across our network.
                        </p>
                       
                    </div>
                </a>
            </div>
            <div class="my-4 text-center">
                <a href="" class="btn text-white" style="background-color: #f41909; border-color: #f41909;">Get Started</a>
            </div>
        </div>
    </div>
</section>



<section id="testimonial" class="py-5">
    <div class="container">
        <div class="row h-100">
            <div class="col-lg-10 mx-auto text-center mb-6">
                <h5 class="fw-bold fs-3 fs-lg-5 lh-sm mb-3" style="color: #f41909;">Success stories from our partners</h5>
                <div class="divider" style="background-color: #f41909;"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3 h-100 mb-3">
                <div class="card card-span h-100 text-white rounded-3" style="border-color: #f41909;">
                    <img class="img-fluid rounded-3 h-100" src="https://argosmob.uk/dhillon/public/uploads/users/profile_673898071c06f.jpg" alt="Business Meeting" style="height: 200px; object-fit: cover;"/>
                    <div class="card-body ps-0">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-1 ms-3">
                                <h5 class="mb-0 fw-bold">Pizzaria Dhillon</h5>
                                <span class="fs--1 me-1" style="color: #f41909;"><i class="fas fa-star"></i></span>
                                <span class="mb-0" style="color: #f41909;">4.8/5</span>
                            </div>
                        </div>
                        <p class="text-dark">"Lieferfood reduced our meal management overhead by 60% while improving employee satisfaction."</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 h-100 mb-3">
                <div class="card card-span h-100 text-white rounded-3" style="border-color: #f41909;">
                    <img class="img-fluid rounded-3 h-100" src="https://argosmob.uk/dhillon/public/uploads/users/profile_6761fc451cabe.png" alt="Team Lunch" style="height: 200px; object-fit: cover;"/>
                    <div class="card-body ps-0">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-1 ms-3">
                                <h5 class="mb-0 fw-bold">Maharaja Restaurant</h5>
                                <span class="fs--1 me-1" style="color: #f41909;"><i class="fas fa-star"></i></span>
                                <span class="mb-0" style="color: #f41909;">4.9/5</span>
                            </div>
                        </div>
                        <p class="text-dark">"Our team loves the variety and quality of food options available through Lieferfood."</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 h-100 mb-3">
                <div class="card card-span h-100 text-white rounded-3" style="border-color: #f41909;">
                    <img class="img-fluid rounded-3 h-100" src="https://argosmob.uk/dhillon/public/uploads/users/profile_676960fbe1c90.png" alt="Chef Cooking" style="height: 200px; object-fit: cover;"/>
                    <div class="card-body ps-0">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-1 ms-3">
                                <h5 class="mb-0 fw-bold">Pizzaria Rosario</h5>
                                <span class="fs--1 me-1" style="color: #f41909;"><i class="fas fa-star"></i></span>
                                <span class="mb-0" style="color: #f41909;">5/5</span>
                            </div>
                        </div>
                        <p class="text-dark">"The reporting tools helped us optimize our meal budget while keeping employees happy."</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 h-100 mb-3">
                <div class="card card-span h-100 text-white rounded-3" style="border-color: #f41909;">
                    <img class="img-fluid rounded-3 h-100" src="https://argosmob.uk/dhillon/public/uploads/users/profile_67540ea3544ac.png" alt="Food Delivery" style="height: 200px; object-fit: cover;"/>
                    <div class="card-body ps-0">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-1 ms-3">
                                <h5 class="mb-0 fw-bold">Pizzaria Ragazzi</h5>
                                <span class="fs--1 me-1" style="color: #f41909;"><i class="fas fa-star"></i></span>
                                <span class="mb-0" style="color: #f41909;">4.7/5</span>
                            </div>
                        </div>
                        <p class="text-dark">"The dietary restriction filters are a game-changer for our diverse workforce."</p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<section class="py-0 my-3 mt-0" style="background: linear-gradient(to right, #f41909, #ff5c4d);">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 mt-5">
                <h5 class="fs-5 fw-bold text-center text-white">Here's where we can help you...</h5>
                <div class="divider bg-white"></div>
                <p class="text-center mt-3 text-white">Simplify corporate food management with solutions designed for modern workplace needs.</p>
            </div>
            <div class="col-md-11 my-5">
                <div class="card shadow border-0 bg-white">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="card-body faqs">
                                <div class="accordion border-0">
                                    <div class="accordion-item">
                                        <button id="accordion-button-1" aria-expanded="false" style="color: #f41909;">
                                            <span class="accordion-title">How does Lieferfood for business work?</span>
                                            <span class="icon" aria-hidden="true" style="color: #f41909;"></span>
                                        </button>
                                        <div class="accordion-content">
                                            <p>
                                                Our platform integrates seamlessly with your HR systems to provide meal solutions. Set budgets, manage preferences, and track usage all from one dashboard. Employees can order from our network of restaurants with their allocated meal budgets.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <button id="accordion-button-2" aria-expanded="false" style="color: #f41909;">
                                            <span class="accordion-title">What size companies do you work with?</span>
                                            <span class="icon" aria-hidden="true" style="color: #f41909;"></span>
                                        </button>
                                        <div class="accordion-content">
                                            <p>
                                                We cater to businesses of all sizes, from startups with 10 employees to large enterprises with thousands of staff members. Our solutions scale to meet your specific needs.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <button id="accordion-button-3" aria-expanded="false" style="color: #f41909;">
                                            <span class="accordion-title">Can we set dietary restrictions?</span>
                                            <span class="icon" aria-hidden="true" style="color: #f41909;"></span>
                                        </button>
                                        <div class="accordion-content">
                                            <p>
                                                Absolutely. Our platform allows employees to set dietary preferences (vegetarian, vegan, gluten-free, etc.) and only shows them appropriate meal options. Administrators can also set company-wide guidelines.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <button id="accordion-button-4" aria-expanded="false" style="color: #f41909;">
                                            <span class="accordion-title">How is billing handled?</span>
                                            <span class="icon" aria-hidden="true" style="color: #f41909;"></span>
                                        </button>
                                        <div class="accordion-content">
                                            <p>
                                                You'll receive one consolidated monthly invoice detailing all meal expenses. Our reporting dashboard provides detailed breakdowns by department, employee, or any other category you need.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img src="https://cdn.pixabay.com/photo/2012/06/13/00/27/question-mark-49958_640.jpg" class="img-fluid rounded-end h-100" alt="Businesswoman using tablet" style="object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 mt-5">
                <h5 class="fs-5 fw-bold text-center text-white">How Lieferfood for business works</h5>
                <div class="divider bg-white"></div>
                <p class="text-center mt-3 text-white">Get started in 3 simple steps</p>
            </div>

            <div class="col-md-11 my-5">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="py-3">
                            <h5 class="fs-2 fw-bold text-white">1. Account Setup</h5>
                            <p class="mb-0 text-white">Our team works with you to configure your company account, set budgets, and import employee data.</p>
                            <p class="text-white">Implementation typically takes less than 48 hours with our automated onboarding process.</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="position-relative" style="height: 26rem;">
                            <img src="https://img.freepik.com/free-vector/business-analytics-concept-illustration_114360-1554.jpg" class="position-absolute p-2 top-0 bottom-0 mb-8 h-100 w-100" style="object-fit: cover; border-radius: 20px;" alt="Business analytics">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-11 my-5">
                <div class="row">
                    <div class="col-md-8">
                        <div class="position-relative" style="height: 26rem;">
                            <img src="https://cdn.pixabay.com/photo/2021/02/03/00/10/receptionist-5975961_640.jpg" class="position-absolute p-2 top-0 bottom-0 mb-8 h-100 w-100" style="object-fit: cover; border-radius: 20px;" alt="Team discussion">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="py-3">
                            <h5 class="fs-2 fw-bold text-white">2. Employee Onboarding</h5>
                            <p class="mb-0 text-white">Employees receive welcome emails with instructions to set up their accounts.</p>
                            <p class="text-white">We provide training materials and can host orientation sessions for your team.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-11 my-5">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="py-3">
                            <h5 class="fs-2 fw-bold text-white">3. Start Ordering</h5>
                            <p class="mb-0 text-white">Employees begin ordering meals using their allocated budgets.</p>
                            <p class="text-white">Administrators gain access to real-time reporting and spending controls.</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="position-relative" style="height: 26rem;">
                            <img src="https://cdn.pixabay.com/photo/2022/01/28/12/17/fast-food-6974507_640.jpg" class="position-absolute p-2 top-0 bottom-0 mb-8 h-100 w-100" style="object-fit: cover; border-radius: 20px;" alt="Online ordering">
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-5 text-center">
                <a href="" class="btn text-white" style="background-color: #f41909; border-color: #f41909;">Get Started</a>
            </div>
        </div>
    </div>
</section>

<section class="py-0">
    <div class="container my-8">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <h5 class="fs-4 fw-bold text-center" style="color: #f41909;">FAQ</h5>
                <div class="divider" style="background-color: #f41909;"></div>
            </div>
            <div class="col-12"></div>
            <div class="col-md-8">
                <div class="card-body faqs">
                    <div class="accordion border-0">
                        <div class="accordion-item">
                            <button id="accordion-button-1" aria-expanded="false" style="color: #f41909;">
                                <span class="accordion-title">What restaurants are available?</span>
                                <span class="icon" aria-hidden="true" style="color: #f41909;"></span>
                            </button>
                            <div class="accordion-content">
                                <p>
                                    We partner with hundreds of local restaurants in each market, ranging from healthy options to comfort food. Our platform allows you to curate approved vendor lists if needed.
                                </p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button id="accordion-button-2" aria-expanded="false" style="color: #f41909;">
                                <span class="accordion-title">Can we set spending limits?</span>
                                <span class="icon" aria-hidden="true" style="color: #f41909;"></span>
                            </button>
                            <div class="accordion-content">
                                <p>
                                    Yes, you can set daily, weekly, or monthly spending limits by employee, department, or location. Our system prevents overspending in real-time.
                                </p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button id="accordion-button-3" aria-expanded="false" style="color: #f41909;">
                                <span class="accordion-title">How do deliveries work for offices?</span>
                                <span class="icon" aria-hidden="true" style="color: #f41909;"></span>
                            </button>
                            <div class="accordion-content">
                                <p>
                                    We offer flexible delivery options including scheduled bulk deliveries for teams, individual meal drops, and dedicated reception handling. Our system coordinates delivery timing to minimize disruption.
                                </p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button id="accordion-button-4" aria-expanded="false" style="color: #f41909;">
                                <span class="accordion-title">What about remote employees?</span>
                                <span class="icon" aria-hidden="true" style="color: #f41909;"></span>
                            </button>
                            <div class="accordion-content">
                                <p>
                                    Our platform works equally well for in-office and remote teams. Employees can get meals delivered to their home offices or choose pickup options near their location.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <img src="https://img.freepik.com/free-vector/faq-concept-illustration_114360-5185.jpg" class="img-fluid" alt="FAQ illustration">
            </div>
        </div>
    </div>
</section>

<section class="pb-2">
    <div class="bg-holder" style="background-color: #f41909; background-position:center;background-size:cover;">
    </div>
    <!--/.bg-holder-->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-10">
                <div class="card card-span" style="border-radius: 35px; border-color: #f41909;">
                    <div class="card-body py-5">
                        <div class="row justify-content-evenly">
                            <div class="col-md-3">
                                <div class="d-flex d-md-block d-xl-flex justify-content-evenly justify-content-lg-between">
                                    <img src="https://img.freepik.com/free-vector/discount-concept-illustration_114360-2003.jpg" width="100" alt="Discounts" />
                                    <div class="d-flex d-lg-block d-xl-flex flex-center">
                                        <h2 class="fw-bolder text-1000 mb-0">Corporate<br class="d-none d-md-block" />Discounts </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 hr-vertical">
                                <div class="d-flex d-md-block d-xl-flex justify-content-evenly justify-content-lg-between">
                                    <img src="https://img.freepik.com/free-vector/location-tracking-concept-illustration_114360-4948.jpg" width="100" alt="Tracking" />
                                    <div class="d-flex d-lg-block d-xl-flex flex-center">
                                        <h2 class="fw-bolder text-1000 mb-0">Real-time Tracking</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 hr-vertical">
                                <div class="d-flex d-md-block d-xl-flex justify-content-evenly justify-content-lg-between">
                                    <img src="https://img.freepik.com/free-vector/fast-delivery-concept-illustration_114360-7430.jpg" width="100" alt="Fast Delivery" />
                                    <div class="d-flex d-lg-block d-xl-flex flex-center">
                                        <h2 class="fw-bolder text-1000 mb-0">Priority Delivery </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row flex-center mt-md-8">
            <div class="col-lg-5 d-none d-lg-block" style="margin-bottom: -10px;"> 
                <img class="w-100" src="https://img.freepik.com/free-vector/hand-holding-smartphone-with-food-delivery-app-screen_74855-5250.jpg" alt="Mobile app" style="height: 400px; object-fit: contain;"/>
            </div>
            <div class="col-lg-5 mt-7 mt-md-0">
                <h1 class="text-white">Install the app</h1>
                <p class="text-white">Get access to exclusive corporate discounts and seamless meal management on the go.</p>
                <div class="d-flex justify-content-md-start justify-content-between">
                    <a class="pe-2 mt-2 d-block" href="#!" target="_blank">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Download_on_the_App_Store_Badge.svg/2560px-Download_on_the_App_Store_Badge.svg.png" style="height: 3rem;" width="160" alt="App Store" />
                    </a>
                    <a href="#!" class="mt-2 d-block" target="_blank">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Google_Play_Store_badge_EN.svg/2560px-Google_Play_Store_badge_EN.svg.png" style="height: 3rem;" width="160" alt="Google Play" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
@section('external-js')
<script>
    const items = document.querySelectorAll('.accordion button');

    function toggleAccordion() {
        const itemToggle = this.getAttribute('aria-expanded');

        for (i = 0; i < items.length; i++) {
            items[i].setAttribute('aria-expanded', 'false');
        }

        if (itemToggle == 'false') {
            this.setAttribute('aria-expanded', 'true');
        }
    }

    items.forEach((item) => item.addEventListener('click', toggleAccordion));
</script>
@endsection