@extends('external.frame')
@section('external-css')
    <style>
        :root {
            --primary-color: red;
            --primary-dark: #c0392b;
            --primary-light: #fadbd8;
            --accent-color: #3498db;
        }
        
        body {
            background: #f8f9fa !important;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        .forgot-card {
            border-radius: 1.25rem;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        .forgot-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 1.5rem;
            text-align: center;
            border-bottom: none;
        }
        
        .card-header h3 {
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: white ;
        }
        
        .logo-container {
            margin: 0.5rem 0;
            text-align: center;
        }
        
        .logo-container img {
            height: 5rem;
            transition: transform 0.3s;
        }
        
        .logo-container:hover img {
            transform: scale(1.05);
        }
        
        .form-control-lg {
            padding: 0.8rem 1.2rem !important;
            border-radius: 0.75rem !important;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 0.25rem rgba(231, 76, 60, 0.2);
        }
        
        .btn-send-otp {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 0.75rem;
            transition: all 0.3s;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }
        
        .btn-send-otp:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        }
        
        .create-account-link {
            color: red;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
            margin-top: 1rem;
            position: relative;
        }
        
        .create-account-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: red;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s;
        }
        
        .create-account-link:hover {
            color: red !important;
        }
        
        .create-account-link:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .text-danger {
            color: var(--primary-color) !important;
            font-size: 0.85rem;
            margin-top: 0.25rem;
            display: block;
        }
        
        .instruction-text {
            color: #666;
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }
    </style>
@endsection

@section('external-home-content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="forgot-card card">
                <div class="card-header">
                    <h3 class="mb-0">Reset Your Password</h3>
                    <p class="mb-0">We'll send you a verification code</p>
                </div>
                
                <div class="card-body p-3 p-lg-4">
                    <form method="post" action="{{ route('sendotp') }}">
                        @csrf
                        
                        
                        
                        <p class="instruction-text">
                            Enter your email address below and we'll send you an OTP to reset your password.
                        </p>
                        
                        <div class="form-group mb-4">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" value="{{ old('email') }}" name="email" id="email"
                                class="form-control form-control-lg" 
                                placeholder="Enter your registered email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-send-otp w-100">
                            Send Verification Code
                        </button>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('register') }}" class="create-account-link">
                                Don't have an account? Create one
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection