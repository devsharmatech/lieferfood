@extends('external.frame')
@section('external-css')
    <style>
        :root {
            --liefer-primary: #E53935;
            --liefer-secondary: #C62828;
            --liefer-light: #EF5350;
            --liefer-dark: #B71C1C;
            --liefer-bg-gradient: linear-gradient(135deg, var(--liefer-primary) 0%, var(--liefer-dark) 100%);
            --liefer-text-light: #FFEBEE;
        }
        
        .dropshadow {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .bg-liefer-primary {
            background-color: var(--liefer-primary);
        }
        
        .bg-liefer-gradient {
            background: var(--liefer-bg-gradient);
        }
        
        .btn-liefer {
            background-color: var(--liefer-primary);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-liefer:hover {
            background-color: var(--liefer-dark);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .shadow-icon {
            transition: transform 0.3s ease;
        }
        
        .shadow-icon:hover {
            transform: scale(1.1);
        }
        
        .divider {
            height: 4px;
            width: 80px;
            background: var(--liefer-primary);
            margin: 15px auto;
            border-radius: 2px;
        }
        
        /* Updated Bootstrap 5 Accordion Styles */
        .accordion-button {
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .accordion-button:not(.collapsed) {
            background-color: var(--liefer-primary);
            color: white;
            box-shadow: none;
        }
        
        .accordion-button:not(.collapsed)::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='white'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        }
        
        .accordion-button:hover:not(.collapsed) {
            background-color: var(--liefer-dark);
        }
        
        .accordion-button:hover {
            background-color: #f9f9f9;
            color: var(--liefer-primary);
        }
        
        .accordion-item {
            border: 1px solid #f0f0f0;
            margin-bottom: 10px;
            border-radius: 8px !important;
            overflow: hidden;
        }
        
        .accordion-item:last-child {
            margin-bottom: 0;
        }
        
        .accordion-body {
            background-color: #f9f9f9;
        }
        
        .card-hover {
            transition: all 0.3s ease;
            border-radius: 10px;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Hero Animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .floating-img {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Pulse Animation for CTA */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(229, 57, 53, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(229, 57, 53, 0); }
            100% { box-shadow: 0 0 0 0 rgba(229, 57, 53, 0); }
        }
        
        .pulse-btn {
            animation: pulse 2s infinite;
        }
        
        /* Testimonial Styles */
        .testimonial-card {
            border-left: 4px solid var(--liefer-primary);
        }
    </style>
@endsection
@section('external-home-content')
    <!-- Hero Section -->
    <section class="py-5 overflow-hidden bg-liefer-gradient" id="home">
        <div class="container">
            <div class="row flex-center">
                <div class="col-md-5 col-lg-6 order-0 order-md-1 mt-5 mt-md-5">
                    <div class="position-relative">
                        <img class="img-fluid floating-img dropshadow rounded-3" src="{{ asset('pizza-client/assets/img/icons/courier.png') }}" alt="LieferFood delivery rider" />
                        <div class="position-absolute top-0 start-0 bg-white p-2 rounded-pill shadow" style="transform: translate(-20%, -20%);">
                            <span class="badge bg-liefer-primary text-white">HIRING NOW</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-lg-6 py-8 pb-5 text-md-start text-center">
                    <h1 class="display-3 fw-bold text-white mb-4">Deliver with <span class="text-white">Lieferfood</span></h1>
                    <p class="lead text-white mb-5">Join Germany's fastest growing food delivery platform and earn great money on your schedule!</p>
                    
                    <div class="d-flex align-items-center gap-3 mb-4 justify-content-center justify-content-md-start">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-white me-2 fs-5"></i>
                            <span class="text-white">Flexible hours</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-white me-2 fs-5"></i>
                            <span class="text-white">Great earnings</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-white me-2 fs-5"></i>
                            <span class="text-white">Keep 100% tips</span>
                        </div>
                    </div>
                    
                    <div class=" bg-transparent border-0 mb-0">
                        <a href="{{route('courier.apply')}}" class="btn btn-warning btn-lg px-5 fw-bold pulse-btn">Apply Today</a>
                        <p class="text-white mt-3">Average earnings: €12-€18/hour + tips</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-6 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-5">
                    <h2 class="fw-bold display-5 mb-3" style="color: var(--liefer-dark)">Why Deliver with LieferFood?</h2>
                    <p class="lead">We're changing food delivery by putting our couriers first. Here's what makes us different:</p>
                    <div class="divider"></div>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm card-hover h-100">
                        <div class="card-body p-4 text-center">
                            <div class="bg-liefer-primary rounded-circle p-3 d-inline-flex mb-4">
                                <i class="fas fa-euro-sign text-white fs-2"></i>
                            </div>
                            <h4 class="fw-bold" style="color: var(--liefer-primary)">Higher Earnings</h4>
                            <p>Our pay structure ensures you earn more per delivery than competitors, plus you keep 100% of your tips.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm card-hover h-100">
                        <div class="card-body p-4 text-center">
                            <div class="bg-liefer-primary rounded-circle p-3 d-inline-flex mb-4">
                                <i class="fas fa-calendar-alt text-white fs-2"></i>
                            </div>
                            <h4 class="fw-bold" style="color: var(--liefer-primary)">Flexible Schedule</h4>
                            <p>Work when you want - morning, afternoon, evening or late night. Choose your own hours each week.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm card-hover h-100">
                        <div class="card-body p-4 text-center">
                            <div class="bg-liefer-primary rounded-circle p-3 d-inline-flex mb-4">
                                <i class="fas fa-hands-helping text-white fs-2"></i>
                            </div>
                            <h4 class="fw-bold" style="color: var(--liefer-primary)">Supportive Team</h4>
                            <p>24/7 support and mentorship program to help you succeed. We invest in our couriers' success.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-6 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-5">
                    <h2 class="fw-bold display-5 mb-3" style="color: var(--liefer-dark)">How LieferFood Works</h2>
                    <p class="lead">Simple steps to start earning with Germany's favorite delivery platform</p>
                    <div class="divider"></div>
                </div>
            </div>
            
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="pe-lg-5">
                        <div class="d-flex mb-4">
                            <div class="bg-liefer-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <h4 class="mb-0">1</h4>
                            </div>
                            <div class="ms-4">
                                <h4 class="fw-bold" style="color: var(--liefer-primary)">Apply Online</h4>
                                <p>Complete our quick application form - takes less than 10 minutes. No resume needed!</p>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-4">
                            <div class="bg-liefer-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <h4 class="mb-0">2</h4>
                            </div>
                            <div class="ms-4">
                                <h4 class="fw-bold" style="color: var(--liefer-primary)">Get Approved</h4>
                                <p>We'll review your application and get back to you within 24-48 hours.</p>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-4">
                            <div class="bg-liefer-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <h4 class="mb-0">3</h4>
                            </div>
                            <div class="ms-4">
                                <h4 class="fw-bold" style="color: var(--liefer-primary)">Complete Onboarding</h4>
                                <p>Short orientation session to learn our systems and best practices.</p>
                            </div>
                        </div>
                        
                        <div class="d-flex">
                            <div class="bg-liefer-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <h4 class="mb-0">4</h4>
                            </div>
                            <div class="ms-4">
                                <h4 class="fw-bold" style="color: var(--liefer-primary)">Start Delivering</h4>
                                <p>Download our app, choose your first shifts, and start earning!</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="ratio ratio-16x9 " >
                        <div class="bg-liefer-primary rounded-3 d-flex align-items-center justify-content-center text-white" style="
    background-image: url('https://cdn.pixabay.com/photo/2021/07/20/06/04/restaurant-6479818_960_720.jpg');
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-blend-mode: overlay;
    background-color: rgba(229, 57, 53, 0.85);
">
                            <i class="fas fa-play-circle" style="font-size:3rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Requirements Section -->
    <section class="py-6 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-5">
                    <h2 class="fw-bold display-5 mb-3" style="color: var(--liefer-dark)">What You'll Need</h2>
                    <p class="lead">Basic requirements to get started with LieferFood</p>
                    <div class="divider"></div>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-sm card-hover h-100">
                        <div class="card-body p-4 text-center">
                            <div class="bg-liefer-primary rounded-circle p-3 d-inline-flex mb-4">
                                <i class="fas fa-bicycle text-white fs-2"></i>
                            </div>
                            <h5 class="fw-bold" style="color: var(--liefer-primary)">Transportation</h5>
                            <p class="mb-0">Bike, scooter, or car (depending on city)</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-sm card-hover h-100">
                        <div class="card-body p-4 text-center">
                            <div class="bg-liefer-primary rounded-circle p-3 d-inline-flex mb-4">
                                <i class="fas fa-mobile-alt text-white fs-2"></i>
                            </div>
                            <h5 class="fw-bold" style="color: var(--liefer-primary)">Smartphone</h5>
                            <p class="mb-0">iOS or Android with data plan</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-sm card-hover h-100">
                        <div class="card-body p-4 text-center">
                            <div class="bg-liefer-primary rounded-circle p-3 d-inline-flex mb-4">
                                <i class="fas fa-id-card text-white fs-2"></i>
                            </div>
                            <h5 class="fw-bold" style="color: var(--liefer-primary)">Valid ID</h5>
                            <p class="mb-0">Must be 18+ to deliver</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-sm card-hover h-100">
                        <div class="card-body p-4 text-center">
                            <div class="bg-liefer-primary rounded-circle p-3 d-inline-flex mb-4">
                                <i class="fas fa-smile text-white fs-2"></i>
                            </div>
                            <h5 class="fw-bold" style="color: var(--liefer-primary)">Positive Attitude</h5>
                            <p class="mb-0">Friendly service is key!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-6 bg-liefer-gradient">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-5">
                    <h2 class="fw-bold display-5 mb-3 text-white">What Our Couriers Say</h2>
                    <p class="lead text-white">Hear from LieferFood delivery partners across Germany</p>
                    <div class="divider" style="background: white;"></div>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 testimonial-card">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://randomuser.me/api/portraits/women/32.jpg" class="rounded-circle me-3" width="50" alt="Courier">
                                <div>
                                    <h5 class="mb-0 fw-bold">Anna K.</h5>
                                    <small class="text-muted">Berlin • 2 years with LieferFood</small>
                                </div>
                            </div>
                            <p class="mb-0">"I've delivered for several platforms, but LieferFood pays the best and treats their couriers with respect. The support team is always helpful when I have questions."</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 testimonial-card">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://randomuser.me/api/portraits/men/45.jpg" class="rounded-circle me-3" width="50" alt="Courier">
                                <div>
                                    <h5 class="mb-0 fw-bold">Markus T.</h5>
                                    <small class="text-muted">Munich • 1 year with LieferFood</small>
                                </div>
                            </div>
                            <p class="mb-0">"The flexibility is perfect for my student schedule. I can work around my classes and still make great money. The app is easy to use and payments are always on time."</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 testimonial-card">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle me-3" width="50" alt="Courier">
                                <div>
                                    <h5 class="mb-0 fw-bold">Sarah L.</h5>
                                    <small class="text-muted">Hamburg • 8 months with LieferFood</small>
                                </div>
                            </div>
                            <p class="mb-0">"I love being able to explore the city while working. The customers are nice and tips are good. The best part is choosing my own hours - it's perfect as a side gig."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-6 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-5">
                    <h2 class="fw-bold display-5 mb-3" style="color: var(--liefer-dark)">Frequently Asked Questions</h2>
                    <p class="lead">Everything you need to know about delivering with LieferFood</p>
                    <div class="divider"></div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    How much can I earn with LieferFood?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        Most LieferFood couriers earn between €12-€18 per hour including tips. During peak times (lunch, dinner, weekends) you can earn even more. 
                                        You'll receive a base pay per delivery plus 100% of your tips. The more you work, the more you can earn!
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    What cities is LieferFood available in?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        We currently operate in Berlin, Munich, Hamburg, Frankfurt, Cologne, and Stuttgart with plans to expand to more German cities soon. 
                                        During the application process, you can select your preferred delivery area.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    How does payment work?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        You'll be paid weekly via direct deposit to your bank account. Each payment includes your base earnings plus all tips from the previous week. 
                                        You can track your earnings in real-time through the LieferFood Courier app.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Can I choose my own schedule?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        Absolutely! You choose when you want to work through our app. You can schedule shifts in advance or pick up last-minute delivery opportunities. 
                                        There are no minimum hours required - work as much or as little as you want.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    What support is available for new couriers?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        We provide comprehensive training materials in our app and assign each new courier a mentor for their first week. 
                                        Our support team is available 24/7 via phone, chat, and email to answer any questions you may have.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-5">
                        <h4 class="fw-bold mb-4" style="color: var(--liefer-primary)">Ready to join our team?</h4>
                        <a href="{{route('courier.apply')}}" class="btn btn-liefer btn-lg px-5 fw-bold">Start Your Application Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('external-js')
    <!-- No custom JS needed since we're using Bootstrap's built-in accordion functionality -->
@endsection