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
        
        .reset-card {
            border-radius: 1.25rem;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        .reset-card:hover {
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
            color: white;
        }
        
        .form-control-lg {
            padding: 0.8rem 1.2rem !important;
            border-radius: 0.75rem !important;
            transition: all 0.3s;
            letter-spacing: 1px;
        }
        
        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 0.25rem rgba(231, 76, 60, 0.2);
        }
        
        .btn-verify {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 0.75rem;
            transition: all 0.3s;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }
        
        .btn-verify:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        }
        
        .password-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .password-icon:hover {
            color: var(--primary-color);
        }
        
        .input-group {
            position: relative;
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
        
        .otp-input {
            letter-spacing: 5px;
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
@endsection

@section('external-home-content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="reset-card card">
                    <div class="card-header">
                        <h3 class="mb-0">Reset Your Password</h3>
                        <p class="mb-0">Create a new secure password</p>
                    </div>
                    
                    <div class="card-body p-3 p-lg-4">
                        <form method="post" action="{{ route('setpassword') }}">
                            @csrf
                            
                            <p class="instruction-text">
                                Please enter the OTP sent to your email and create a new password
                            </p>
                            
                            <div class="form-group mb-4">
                                <label for="otp" class="form-label fw-semibold">Verification Code</label>
                                <input type="text" value="{{ old('otp') }}" name="otp" id="otp"
                                    class="form-control form-control-lg otp-input text-center" 
                                    placeholder="Enter 6-digit OTP">
                                @error('otp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-4">
                                <label for="password" class="form-label fw-semibold">New Password</label>
                                <div class="input-group">
                                    <input type="password" value="{{ old('password') }}" name="password" id="password"
                                        class="form-control form-control-lg" 
                                        placeholder="Create new password">
                                    <i class="bi bi-eye-slash password-icon" id="togglePassword1"></i>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-4">
                                <label for="cpassword" class="form-label fw-semibold">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" value="{{ old('password_confirmation') }}" name="password_confirmation" id="cpassword"
                                        class="form-control form-control-lg" 
                                        placeholder="Confirm new password">
                                    <i class="bi bi-eye-slash password-icon" id="togglePassword2"></i>
                                </div>
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-verify w-100">
                                Reset Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        function setupPasswordToggle(iconId, inputId) {
            const icon = document.getElementById(iconId);
            const input = document.getElementById(inputId);
            
            icon.addEventListener('click', function() {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                }
            });
        }
        
        setupPasswordToggle('togglePassword1', 'password');
        setupPasswordToggle('togglePassword2', 'cpassword');
        
        // Auto move between OTP digits
        const otpInput = document.getElementById('otp');
        if (otpInput) {
            otpInput.addEventListener('input', function() {
                if (this.value.length > 6) {
                    this.value = this.value.slice(0, 6);
                }
            });
        }
    });
</script>
@endsection