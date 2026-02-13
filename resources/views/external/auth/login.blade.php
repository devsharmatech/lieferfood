@extends('external.frame')

@section('external-css')
    <style>
        :root {
            --primary-color: #e74c3c;
            --primary-dark: #c0392b;
            --primary-light: #fadbd8;
            --accent-color: #f39c12;
        }
        
       
        
        .login-wrapper {
            padding: 15px;
            height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            overflow: hidden;
            animation: fadeInUp 0.4s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card-header {
            background: white;
            padding:  1rem;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .app-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        
        .logo-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        
        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }
        
        .card-header h4 {
            color: #333;
            font-weight: 600;
            font-size: 1.3rem;
            margin: 0.5rem 0;
        }
        
        .card-header p {
            color: #666;
            font-size: 0.9rem;
            margin: 0;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .input-group {
            margin-bottom: 1.25rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #000;
            font-weight: bolder;
            font-size: 1rem;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .form-control {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1.5rem;
            transition: all 0.3s;
            background: #fff;
        }
        .bg-1000{
            display: none !important;
        }
        .form-control:focus {
            border-color: var(--primary-color);
            background: white;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
        }
        .form-control:placeholder {
            color: #000 !important;
            
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }
        
        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #777;
            cursor: pointer;
            padding: 0;
        }
        
        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .forgot-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .forgot-link:hover {
            text-decoration: underline;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.9rem;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s;
            cursor: pointer;
            margin-bottom: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.25);
        }
        
        .dividerl {
            display: flex;
            align-items: center;
            margin: 5px 0;
            color: #999;
            font-size: 0.85rem;
            display: block;
            text-align:center;
        }
        
        
        
        .divider span {
            padding: 0 1rem;
            background: white;
        }
        
        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
            color: #444;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .btn-google:hover {
            border-color: var(--primary-light);
            background: #f9f9f9;
            transform: translateY(-1px);
        }
        
        .btn-google img {
            width: 18px;
            height: 18px;
        }
        
        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .signup-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            margin-left: 0.5rem;
        }
        
        .signup-link a:hover {
            text-decoration: underline;
        }
        
        .text-danger {
            font-size: 0.85rem;
            margin-top: 0.25rem;
            color: #dc3545;
            display: block;
        }
        
        .app-tagline {
            color: var(--accent-color);
            font-weight: 500;
            margin-top: 0.25rem;
        }
    </style>
@endsection

@section('external-home-content')
    <div class="login-wrapper">
        <div class="login-card">
            <div class="card-header">
                <!--<div class="app-logo">-->
                <!--    <div class="logo-icon">-->
                <!--        <i class="fas fa-utensils"></i>-->
                <!--    </div>-->
                <!--    <span class="logo-text">Lieferfood</span>-->
                <!--</div>-->
                <h4>Welcome!</h4>
                <p>Sign in to order your favorite food</p>
                <!--<div class="app-tagline">Delicious food delivered fast</div>-->
            </div>
            
            <div class="card-body">
                <form method="post" action="{{ route('login_verify') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" 
                                   value="{{ old('email') }}" 
                                   name="email" 
                                   id="email"
                                   class="form-control"
                                   placeholder="your.email@example.com"
                                   autocomplete="email"
                                   required>
                        </div>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control"
                                   placeholder="Enter your password"
                                   required>
                            <button type="button" class="toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="options-row">
                        <!--<div class="form-check">-->
                        <!--    <input class="form-check-input" -->
                        <!--           type="checkbox" -->
                        <!--           name="remember" -->
                        <!--           id="remember">-->
                        <!--    <label class="form-check-label" for="remember">-->
                        <!--        Remember me-->
                        <!--    </label>-->
                        <!--</div>-->
                        <a href="{{ route('forgetpassword') }}" class="forgot-link">
                            Forgot password?
                        </a>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Sign In
                    </button>
                    
                    <div class="dividerl">
                        <span>Or continue with</span>
                    </div>
                    
                    <a href="{{ url('login/google') }}" class="btn-google">
                        <img src="{{ asset('pizza-client/assets/img/icons/google.png') }}" alt="Google">
                        Continue with Google
                    </a>
                    
                    <div class="signup-link">
                        Don't have an account?
                        <a href="{{ route('register') }}">Sign up here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle
            const toggleBtn = document.querySelector('.toggle-password');
            const passwordInput = document.getElementById('password');
            const eyeIcon = toggleBtn.querySelector('i');
            
            toggleBtn.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            });
            
            // Form validation
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input[required]');
            
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.style.borderColor = '#dc3545';
                        setTimeout(() => {
                            input.style.borderColor = '';
                        }, 1500);
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                }
            });
            
            // Card hover effect
            const card = document.querySelector('.login-card');
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.transition = 'transform 0.3s ease';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });
    </script>
@endsection