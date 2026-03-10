@extends('external.frame')

@section('external-css')
    <style>
        :root {
            --brand-primary: #f41909;
            --brand-dark: #cc1508;
            --brand-light: #fbeae9;
            --text-main: #2b2b2b;
            --text-muted: #6b7280;
            --bg-body: #f9fafb;
            --border-color: #e5e7eb;
            --input-bg: #fff;
        }

        body {
            background-color: var(--bg-body);
        }

        /* Split Screen Layout */
        .auth-container {
            display: flex;
            min-height: 100vh;
            /* Using full viewport height */
            width: 100%;
            background-color: #fff;
            overflow: hidden;
            border-radius: 0;
            margin-top: -80px;
            /* Offset the frame's top margin if any to make it truly full screen */
            padding-top: 80px;
        }

        /* Left Side: Image / Hero */
        .auth-hero {
            flex: 1;
            display: none;
            /* Hidden on mobile */
            position: relative;
            background: linear-gradient(135deg, rgba(244, 25, 9, 0.8), rgba(204, 21, 8, 0.9)),
                url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 3rem;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        @media (min-width: 992px) {
            .auth-hero {
                display: flex;
            }

            .auth-container {
                min-height: calc(100vh - 80px);
                /* Adjusting for potential navbar */
            }
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: #fff;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
        }

        .hero-content p {
            font-size: 1.25rem;
            max-width: 80%;
            opacity: 0.9;
            line-height: 1.6;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
        }

        /* Right Side: Form */
        .auth-form-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem 1.5rem;
            max-width: 100%;
        }

        @media (min-width: 576px) {
            .auth-form-wrapper {
                padding: 3rem;
            }
        }

        @media (min-width: 992px) {
            .auth-form-wrapper {
                padding: 4rem 5rem;
                max-width: 600px;
                margin: 0 auto;
            }
        }

        .auth-header {
            margin-bottom: 2.5rem;
        }

        .auth-header h2 {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .auth-header p {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        /* Modern Inputs */
        .form-floating {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-control-custom {
            width: 100%;
            height: 60px;
            padding: 1.25rem 1rem 0.5rem;
            font-size: 1rem;
            color: var(--text-main);
            background-color: var(--input-bg);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            transition: all 0.2s ease-in-out;
            font-weight: 500;
            /* iOS Fix */
            font-size: 16px !important;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 4px var(--brand-light);
            background-color: #fff;
        }

        .form-floating label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            padding: 1rem;
            pointer-events: none;
            border: 2px solid transparent;
            transform-origin: 0 0;
            transition: opacity .1s ease-in-out, transform .1s ease-in-out;
            color: var(--text-muted);
            font-weight: 500;
        }

        .form-control-custom:focus~label,
        .form-control-custom:not(:placeholder-shown)~label {
            opacity: .8;
            transform: scale(.8) translateY(-0.8rem) translateX(0.5rem);
            color: var(--brand-primary);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.5rem;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.2s;
        }

        .password-toggle:hover {
            color: var(--text-main);
            background: var(--bg-body);
        }

        /* Options */
        .auth-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .forgot-link {
            color: var(--brand-primary);
            font-weight: 600;
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: var(--brand-dark);
            text-decoration: underline;
        }

        /* Buttons */
        .btn-auth-primary {
            width: 100%;
            height: 56px;
            background-color: var(--brand-primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 14px rgba(244, 25, 9, 0.3);
        }

        .btn-auth-primary:hover,
        .btn-auth-primary:focus {
            background-color: var(--brand-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(244, 25, 9, 0.4);
            color: white;
        }

        .btn-auth-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(244, 25, 9, 0.3);
        }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2rem 0;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }

        .auth-divider::before {
            margin-right: 1rem;
        }

        .auth-divider::after {
            margin-left: 1rem;
        }

        /* Social Auth */
        .btn-google {
            width: 100%;
            height: 56px;
            background-color: #fff;
            color: var(--text-main);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 600;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-google img {
            width: 24px;
            height: 24px;
        }

        .btn-google:hover,
        .btn-google:focus {
            background-color: #f9fafb;
            border-color: #d1d5db;
            color: var(--text-main);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Footer Links */
        .auth-footer {
            margin-top: 2.5rem;
            text-align: center;
            font-size: 1rem;
            color: var(--text-muted);
        }

        .auth-footer a {
            color: var(--brand-primary);
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
            margin-left: 0.25rem;
        }

        .auth-footer a:hover {
            color: var(--brand-dark);
            text-decoration: underline;
        }

        /* Error Messages */
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .invalid-input {
            border-color: #ef4444 !important;
            background-color: #fef2f2 !important;
        }

        .invalid-input~label {
            color: #ef4444 !important;
        }
    </style>
@endsection

@section('external-home-content')
    <div class="auth-container">

        <!-- Left Side: Interactive Hero / Image -->
        <div class="auth-hero">
            <div class="hero-content">
                <h1>Hungry?<br>We've got you covered.</h1>
                <p>Sign in to discover local favorites, exclusive deals, and lightning-fast delivery straight to your door.
                </p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="auth-form-wrapper">
            <div class="auth-header">
                <h2>Welcome Back! 👋</h2>
                <p>Please enter your details to sign in.</p>
            </div>

            <form method="post" action="{{ route('login_verify') }}" id="loginForm">
                @csrf

                <!-- Email Input -->
                <div class="form-floating">
                    <input type="email" class="form-control-custom @error('email') invalid-input @enderror" id="email"
                        name="email" value="{{ old('email') }}" placeholder="" autocomplete="email" required>
                    <label for="email">Email address</label>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-floating">
                    <input type="password" class="form-control-custom @error('password') invalid-input @enderror"
                        id="password" name="password" placeholder="" required>
                    <label for="password">Password</label>
                    <button type="button" class="password-toggle" id="togglePassword"
                        aria-label="Toggle password visibility">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Options: Forgot Password -->
                <div class="auth-options">
                    <div></div>
                    <!-- Spacer for keeping 'Forgot Password' on the right if needed, or we can just justify-end -->
                    <a href="{{ route('forgetpassword') }}" class="forgot-link">Forgot password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-auth-primary">
                    Sign In <i class="fas fa-arrow-right ml-2" style="font-size: 0.9em;"></i>
                </button>

                <!-- Divider -->
                <div class="auth-divider">Or continue with</div>

                <!-- Social Login -->
                <a href="{{ url('login/google') }}" class="btn-google">
                    <img src="{{ asset('pizza-client/assets/img/icons/google.png') }}" alt="Google Logo"
                        onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg'">
                    Sign in with Google
                </a>

                <!-- Sign Up Link -->
                <div class="auth-footer">
                    Don't have an account? <a href="{{ route('register') }}">Sign up here</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password Visibility Toggle
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    if (type === 'text') {
                        eyeIcon.classList.remove('fa-eye');
                        eyeIcon.classList.add('fa-eye-slash');
                    } else {
                        eyeIcon.classList.remove('fa-eye-slash');
                        eyeIcon.classList.add('fa-eye');
                    }
                });
            }

            // Basic Client-Side Validation UX
            const form = document.getElementById('loginForm');
            const inputs = form.querySelectorAll('input[required]');

            inputs.forEach(input => {
                input.addEventListener('invalid', function (e) {
                    e.target.classList.add('invalid-input');
                });

                input.addEventListener('input', function (e) {
                    if (e.target.value.trim() !== '') {
                        e.target.classList.remove('invalid-input');
                    }
                });
            });
        });
    </script>
@endsection