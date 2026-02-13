@extends('external.frame')
@section('external-css')
<style>
    .hero-gradient {
        background: linear-gradient(135deg, #f41909 0%, #a71008 100%);
    }
    .feature-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(244, 25, 9, 0.2);
    }
    .divider-red {
        height: 3px;
        width: 80px;
        background-color: #f41909;
        margin: 0 auto 20px;
    }
    .testimonial-card {
        border-left: 4px solid #f41909;
        transition: all 0.3s ease;
    }
    .testimonial-card:hover {
        box-shadow: 0 5px 15px rgba(244, 25, 9, 0.1);
    }
    .accordion-button:not(.collapsed) {
        color: #f41909;
        background-color: rgba(244, 25, 9, 0.05);
    }
    .btn-red {
        background-color: #f41909;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-red:hover {
        background-color: #d11507;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(244, 25, 9, 0.3);
    }
    .btn-outline-red {
        border: 2px solid #f41909;
        color: #f41909;
        background: transparent;
        padding: 10px 25px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-outline-red:hover {
        background-color: #f41909;
        color: white;
    }
    .benefit-card {
        border-radius: 15px;
        padding: 30px;
        height: 100%;
        transition: all 0.3s ease;
        border: 1px solid rgba(244, 25, 9, 0.1);
    }
    .benefit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(244, 25, 9, 0.1);
    }
    .process-step {
        position: relative;
        padding-left: 40px;
        margin-bottom: 30px;
    }
    .process-step:before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 30px;
        height: 30px;
        background-color: #f41909;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }
    .process-step:nth-child(1):before { content: "1"; }
    .process-step:nth-child(2):before { content: "2"; }
    .process-step:nth-child(3):before { content: "3"; }
</style>
@endsection
@section('external-home-content')

<!-- Hero Section -->
<section class="py-5 overflow-hidden hero-gradient">
    <div class="container mt-7">
        <div class="row flex-center align-items-center">
            <div class="col-md-6 order-1 order-md-0 mt-8 mt-md-0">
                <div class="card border-0 shadow-lg bg-transparent">
                    <div class="card-body p-0 overflow-hidden rounded-lg" style="height:24rem;">
                        <img src="https://cdn.pixabay.com/photo/2020/08/27/07/31/restaurant-5521372_1280.jpg" class="img-fluid h-100 w-100" alt="Food Delivery" style="object-fit: cover;">
                    </div>
                </div>
            </div>
            <div class="col-md-6 py-8 text-md-start text-center">
                <h1 class="display-4 fw-bold text-white mb-4">Lieferfood Business Solutions</h1>
                <p class="lead text-light mb-5">Streamline corporate food delivery with our tailored solutions for businesses of all sizes</p>
                <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3">
                    <a class="btn btn-light btn-red" href="#!">
                        <i class="fas fa-calendar me-2"></i> Book a Demo
                    </a>
                    <a class="btn btn-outline-red text-white" href="#!">
                        <i class="fas fa-envelope me-2"></i> Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3" style="color: #f41909;">What is Lieferfood for a business?</h2>
                <div class="divider-red"></div>
                <p class="lead">A comprehensive food delivery solution designed for modern workplaces. Whether it's daily employee meals, client meetings, or corporate events, we provide seamless food delivery services that keep your team fueled and focused.</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card card h-100 border-0">
                    <img src="https://cdn.pixabay.com/photo/2022/09/07/06/56/vegetables-7438072_640.jpg" class="card-img-top" alt="Corporate Catering" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="fw-bold mt-3" style="color: #f41909;">Corporate Catering</h5>
                        <p class="text-muted">Scheduled daily meals for your entire team from top local restaurants.</p>
                        <a href="#" class="btn btn-sm btn-outline-red mt-2">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card card h-100 border-0">
                    <img src="https://cdn.pixabay.com/photo/2017/09/28/18/13/bread-2796393_640.jpg" class="card-img-top" alt="Meal Allowance" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="fw-bold mt-3" style="color: #f41909;">Meal Allowance</h5>
                        <p class="text-muted">Flexible meal budgets with real-time spending controls and reporting.</p>
                        <a href="#" class="btn btn-sm btn-outline-red mt-2">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card card h-100 border-0">
                    <img src="https://cdn.pixabay.com/photo/2019/08/27/01/39/wedding-4433122_640.jpg" class="card-img-top" alt="Event Catering" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="fw-bold mt-3" style="color: #f41909;">Event Catering</h5>
                        <p class="text-muted">Hassle-free catering for meetings, conferences, and corporate events.</p>
                        <a href="#" class="btn btn-sm btn-outline-red mt-2">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="#" class="btn btn-red px-4 py-2">Get Started Today</a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3" style="color: #f41909;">Success Stories</h2>
                <div class="divider-red"></div>
                <p class="lead">Hear what our partners say about Lieferfood Business Solutions</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="testimonial-card card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://argosmob.uk/dhillon/public/uploads/users/profile_673898071c06f.jpg" class="rounded-circle me-3" width="50" height="50" alt="Pizzaria Dhillon">
                            <div>
                                <h6 class="mb-0 fw-bold">Pizzaria Dhillon</h6>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="text-muted ms-1">4.8</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted">"Lieferfood reduced our meal management overhead by 60% while improving employee satisfaction."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="testimonial-card card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://argosmob.uk/dhillon/public/uploads/users/profile_6761fc451cabe.png" class="rounded-circle me-3" width="50" height="50" alt="Maharaja Restaurant">
                            <div>
                                <h6 class="mb-0 fw-bold">Maharaja Restaurant</h6>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="text-muted ms-1">5.0</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted">"Our team loves the variety and quality of food options available through Lieferfood."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="testimonial-card card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://argosmob.uk/dhillon/public/uploads/users/profile_676960fbe1c90.png" class="rounded-circle me-3" width="50" height="50" alt="Pizzaria Rosario">
                            <div>
                                <h6 class="mb-0 fw-bold">Pizzaria Rosario</h6>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="text-muted ms-1">5.0</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted">"The reporting tools helped us optimize our meal budget while keeping employees happy."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="testimonial-card card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://argosmob.uk/dhillon/public/uploads/users/profile_67540ea3544ac.png" class="rounded-circle me-3" width="50" height="50" alt="Pizzaria Ragazzi">
                            <div>
                                <h6 class="mb-0 fw-bold">Pizzaria Ragazzi</h6>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="text-muted ms-1">4.7</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted">"The dietary restriction filters are a game-changer for our diverse workforce."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3" style="color: #f41909;">How It Works</h2>
                <div class="divider-red"></div>
                <p class="lead">Get started with Lieferfood Business Solutions in just 3 simple steps</p>
            </div>
        </div>
        
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 order-lg-1 order-2">
                <div class="process-step">
                    <h4 class="fw-bold mb-3">Account Setup</h4>
                    <p class="text-muted">Our team works with you to configure your company account, set budgets, and import employee data. Implementation typically takes less than 48 hours with our automated onboarding process.</p>
                </div>
            </div>
            <div class="col-lg-6 order-lg-2 order-1 mb-4 mb-lg-0">
                <img src="https://img.freepik.com/free-vector/business-analytics-concept-illustration_114360-1554.jpg" class="img-fluid rounded shadow" alt="Account Setup">
            </div>
        </div>
        
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://cdn.pixabay.com/photo/2021/02/03/00/10/receptionist-5975961_640.jpg" class="img-fluid rounded shadow" alt="Employee Onboarding">
            </div>
            <div class="col-lg-6">
                <div class="process-step">
                    <h4 class="fw-bold mb-3">Employee Onboarding</h4>
                    <p class="text-muted">Employees receive welcome emails with instructions to set up their accounts. We provide training materials and can host orientation sessions for your team.</p>
                </div>
            </div>
        </div>
        
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-1 order-2">
                <div class="process-step">
                    <h4 class="fw-bold mb-3">Start Ordering</h4>
                    <p class="text-muted">Employees begin ordering meals using their allocated budgets. Administrators gain access to real-time reporting and spending controls.</p>
                </div>
            </div>
            <div class="col-lg-6 order-lg-2 order-1 mb-4 mb-lg-0">
                <img src="https://cdn.pixabay.com/photo/2022/01/28/12/17/fast-food-6974507_640.jpg" class="img-fluid rounded shadow" alt="Start Ordering">
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="#" class="btn btn-red px-4 py-2">Schedule a Demo</a>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3" style="color: #f41909;">Frequently Asked Questions</h2>
                <div class="divider-red"></div>
                <p class="lead">Find answers to common questions about Lieferfood Business Solutions</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-3">
                        <h3 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed shadow-none bg-light rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                How does Lieferfood for business work?
                            </button>
                        </h3>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Our platform integrates seamlessly with your HR systems to provide meal solutions. Set budgets, manage preferences, and track usage all from one dashboard. Employees can order from our network of restaurants with their allocated meal budgets.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 mb-3">
                        <h3 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed shadow-none bg-light rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                What size companies do you work with?
                            </button>
                        </h3>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                We cater to businesses of all sizes, from startups with 10 employees to large enterprises with thousands of staff members. Our solutions scale to meet your specific needs.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 mb-3">
                        <h3 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed shadow-none bg-light rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Can we set dietary restrictions?
                            </button>
                        </h3>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Absolutely. Our platform allows employees to set dietary preferences (vegetarian, vegan, gluten-free, etc.) and only shows them appropriate meal options. Administrators can also set company-wide guidelines.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="accordion" id="faqAccordion2">
                    <div class="accordion-item border-0 mb-3">
                        <h3 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed shadow-none bg-light rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                How is billing handled?
                            </button>
                        </h3>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion2">
                            <div class="accordion-body text-muted">
                                You'll receive one consolidated monthly invoice detailing all meal expenses. Our reporting dashboard provides detailed breakdowns by department, employee, or any other category you need.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 mb-3">
                        <h3 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed shadow-none bg-light rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                What restaurants are available?
                            </button>
                        </h3>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion2">
                            <div class="accordion-body text-muted">
                                We partner with hundreds of local restaurants in each market, ranging from healthy options to comfort food. Our platform allows you to curate approved vendor lists if needed.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 mb-3">
                        <h3 class="accordion-header" id="headingSix">
                            <button class="accordion-button collapsed shadow-none bg-light rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Can we set spending limits?
                            </button>
                        </h3>
                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion2">
                            <div class="accordion-body text-muted">
                                Yes, you can set daily, weekly, or monthly spending limits by employee, department, or location. Our system prevents overspending in real-time.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-5" style="background-color: rgba(244, 25, 9, 0.05);">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3" style="color: #f41909;">Why Choose Lieferfood?</h2>
                <div class="divider-red"></div>
                <p class="lead">Discover the benefits of our corporate food delivery solution</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="benefit-card bg-white">
                    <div class="text-center mb-4">
                        <img src="https://img.freepik.com/free-vector/discount-concept-illustration_114360-2003.jpg" width="80" alt="Corporate Discounts">
                    </div>
                    <h4 class="text-center fw-bold mb-3" style="color: #f41909;">Corporate Discounts</h4>
                    <p class="text-center text-muted">Enjoy exclusive discounts and volume pricing not available to individual customers.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="benefit-card bg-white">
                    <div class="text-center mb-4">
                        <img src="https://img.freepik.com/free-vector/location-tracking-concept-illustration_114360-4948.jpg" width="80" alt="Real-time Tracking">
                    </div>
                    <h4 class="text-center fw-bold mb-3" style="color: #f41909;">Real-time Tracking</h4>
                    <p class="text-center text-muted">Monitor all deliveries in real-time with our advanced tracking system.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="benefit-card bg-white">
                    <div class="text-center mb-4">
                        <img src="https://img.freepik.com/free-vector/fast-delivery-concept-illustration_114360-7430.jpg" width="80" alt="Priority Delivery">
                    </div>
                    <h4 class="text-center fw-bold mb-3" style="color: #f41909;">Priority Delivery</h4>
                    <p class="text-center text-muted">Your corporate orders get priority handling to ensure timely delivery.</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="#" class="btn btn-red px-4 py-2 me-3">Get Started</a>
            <a href="#" class="btn btn-outline-red px-4 py-2">Contact Sales</a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 hero-gradient">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="fw-bold text-white mb-4">Ready to Transform Your Corporate Food Delivery?</h2>
                <p class="lead text-light mb-5">Join hundreds of businesses that trust Lieferfood for their meal solutions.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="#" class="btn btn-light btn-lg px-4" style="color: #f41909;">Request a Demo</a>
                    <a href="#" class="btn btn-outline-light btn-lg px-4">Contact Our Team</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('external-js')
<script>
    // Bootstrap 5 accordion functionality is built-in, no need for custom JS
</script>
@endsection