@extends('external.frame')
@section('external-css')
    <style>
        :root {
            --red-primary: red;
            --red-dark: #c0392b;
            --red-light: #fadbd8;
            --red-lighter: #fdedec;
        }
        body {
            background: #f9f9f9 !important;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        .register-card {
            border-radius: 1.25rem !important;
            border: none;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .register-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }
        .card-header {
            background: linear-gradient(135deg, var(--red-primary), var(--red-dark));
            color: white;
            padding: 1.5rem;
            text-align: center;
            border-bottom: none;
        }
        .card-header h3 {
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: white !important;
        }
        .form-control-lg {
            padding: 0.8rem 1.2rem !important;
            border-radius: 0.75rem !important;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: var(--red-light);
            box-shadow: 0 0 0 0.25rem rgba(231, 76, 60, 0.2);
        }
        .btn-register {
            background-color: var(--red-primary);
            border-color: var(--red-primary);
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 0.75rem;
            transition: all 0.3s;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }
        .btn-register:hover {
            background-color: var(--red-dark);
            border-color: var(--red-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        }
        .btn-social {
            border: 1px solid #e0e0e0;
            border-radius: 0.75rem;
            padding: 0.7rem;
            font-weight: 500;
            transition: all 0.3s;
            background: white;
        }
        .btn-social:hover {
            background-color: #f9f9f9;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .password-input-group {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 9px;
            top: 68%;
            transform: translateY(-50%);
            color: #777;
            transition: color 0.2s;
            cursor: pointer;
            z-index: 5;
            background: transparent;
            border: none;
            padding: 0 10px;
        }
        .password-toggle:hover {
            color: var(--red-primary);
        }
        /* New Custom Divider */
        .custom-divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }
        .custom-divider-line {
            flex-grow: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, #e0e0e0, transparent);
        }
        .custom-divider-text {
            padding: 0 12px;
            color: #777;
            font-size: 0.85rem;
            font-weight: 500;
            white-space: nowrap;
        }
        .checkbox-label {
            position: relative;
            padding-left: 1.75rem;
            cursor: pointer;
        }
        .checkbox-label input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 1.25rem;
            width: 1.25rem;
            background-color: white;
            border: 2px solid #ddd;
            border-radius: 0.25rem;
            transition: all 0.2s;
        }
        .checkbox-label:hover input ~ .checkmark {
            border-color: var(--red-primary);
        }
        .checkbox-label input:checked ~ .checkmark {
            background-color: var(--red-primary);
            border-color: var(--red-primary);
        }
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }
        .checkbox-label input:checked ~ .checkmark:after {
            display: block;
        }
        .checkbox-label .checkmark:after {
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        .text-danger {
            color: var(--red-primary) !important;
            font-size: 0.85rem;
            margin-top: 0.25rem;
            display: block;
        }
        .login-link {
            color: var(--red-primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s;
        }
        .login-link:hover {
            color: var(--red-dark);
            text-decoration: underline;
        }
        .bg-1000{
            display: none !important;
        }
        input:placeholder{
            color:#000 !important;
        }
    </style>
@endsection
@section('external-home-content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="register-card card">
                <div class="card-header py-2">
                    <h3 class="mb-0">Create Your Account</h3>
                    <p class="mb-0">Join us today and get started</p>
                </div>
                <div class="card-body p-3 p-lg-4">
                    <form method="post" action="{{route('register_save')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-2">
                                    <label for="name" class="form-label fw-bold">Full Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control px-3 py-2 bg-white fs-1" value="{{ old('name') }}"
                                        placeholder="Enter your full name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-2">
                                    <label for="email" class="form-label fw-bold">Email Address</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control px-3 py-2 bg-white  fs-1" value="{{ old('email') }}"
                                        placeholder="Enter your email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2 password-input-group">
                                    <label for="password" class="form-label fw-bold">Password</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control px-3 py-2 bg-white  fs-1" value="{{ old('password') }}"
                                        placeholder="Create password">
                                    <button type="button" class="password-toggle" onclick="togglePassword('password', 'togglePasswordIcon1')">
                                        <i id="togglePasswordIcon1" class="bi bi-eye"></i>
                                    </button>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2 password-input-group">
                                    <label for="cpassword" class="form-label fw-bold">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="cpassword"
                                        class="form-control px-3 py-2 bg-white  fs-1" value="{{ old('cpassword') }}"
                                        placeholder="Confirm password">
                                    <button type="button" class="password-toggle" onclick="togglePassword('cpassword', 'togglePasswordIcon2')">
                                        <i id="togglePasswordIcon2" class="bi bi-eye"></i>
                                    </button>
                                    @error('cpassword')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="checkbox-label d-block mb-3">
                                    <input type="checkbox" name="term_and_condition" value="checkedValue">
                                    <span class="checkmark"></span>
                                    Yes, I want to receive discounts, loyalty offers, and other updates.
                                </label>
                                @error('term_and_condition')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button class="btn btn-register w-100 mb-3" type="submit">
                            Create Account
                        </button>
                        
                        <div class="text-center mb-3">
                            <span>Already have an account? </span>
                            <a href="{{ route('login') }}" class="login-link">Sign In</a>
                        </div>
                        
                        <!-- New Custom Divider -->
                        <div class="custom-divider">
                            <div class="custom-divider-line"></div>
                            <div class="custom-divider-text">Or sign up with</div>
                            <div class="custom-divider-line"></div>
                        </div>
                        
                        <div class="row g-2">
                            <div class="col-md-12">
                                <a href="{{ url('login/google') }}" class="btn btn-social w-100 text-dark">
                                    <img src="{{ asset('pizza-client/assets/img/icons/google.png') }}"
                                        style="height: 20px; width:20px; margin-right: 10px;" alt="">
                                    Continue with Google
                                </a>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }
</script>
@endsection