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
            width: 100%;
            background-color: #fff;
            overflow: hidden;
            border-radius: 0;
            margin-top: -80px;
            padding-top: 80px;
        }

        /* Left Side: Image / Hero */
        .auth-hero {
            flex: 1;
            display: none;
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
            overflow-y: auto;
            /* Required for potentially longer registration forms */
        }

        @media (min-width: 576px) {
            .auth-form-wrapper {
                padding: 3rem;
            }
        }

        @media (min-width: 992px) {
            .auth-form-wrapper {
                padding: 2rem 5rem;
                max-width: 600px;
                margin: 0 auto;
            }
        }

        .auth-header {
            margin-bottom: 2rem;
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
            margin-bottom: 1.25rem;
        }

        /* Adjusted height for registration form */
        .form-control-custom {
            width: 100%;
            height: 56px;
            padding: 1.25rem 1rem 0.5rem;
            font-size: 1rem;
            color: var(--text-main);
            background-color: var(--input-bg);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            transition: all 0.2s ease-in-out;
            font-weight: 500;
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
            padding: 0.85rem 1rem;
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
            transform: scale(.8) translateY(-0.7rem) translateX(0.5rem);
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
            margin-top: 1rem;
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
            margin: 1.5rem 0;
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
            margin-top: 2rem;
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
            font-size: 0.85rem;
            margin-top: 0.4rem;
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

        /* Checkbox styling */
        .checkbox-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1rem;
            margin-top: 0.5rem;
        }

        .custom-checkbox {
            appearance: none;
            background-color: #fff;
            margin: 0;
            font: inherit;
            color: currentColor;
            width: 1.25em;
            height: 1.25em;
            border: 2px solid var(--border-color);
            border-radius: 4px;
            display: grid;
            place-content: center;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            margin-top: 0.15rem;
        }

        .custom-checkbox::before {
            content: "";
            width: 0.65em;
            height: 0.65em;
            transform: scale(0);
            transition: 120ms transform ease-in-out;
            box-shadow: inset 1em 1em white;
            transform-origin: center;
            clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
        }

        .custom-checkbox:checked {
            background-color: var(--brand-primary);
            border-color: var(--brand-primary);
        }

        .custom-checkbox:checked::before {
            transform: scale(1);
        }

        .checkbox-label {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.4;
            cursor: pointer;
        }

        /* Row for side-by-side inputs on larger screens */
        .form-row {
            display: flex;
            gap: 1rem;
            flex-direction: column;
        }

        @media (min-width: 768px) {
            .form-row {
                flex-direction: row;
            }

            .form-row .form-floating {
                flex: 1;
            }
        }
    </style>
@endsection

@section('external-home-content')
    <div class="auth-container">
        <!-- Left Side: Interactive Hero / Image -->
        <div class="auth-hero">
            <div class="hero-content">
                <h1>Join the<br>Food Revolution.</h1>
                <p>Create an account to unlock exclusive deals, save your favorite restaurants, and enjoy lightning-fast
                    delivery.</p>
            </div>
        </div>

        <!-- Right Side: Registration Form -->
        <div class="auth-form-wrapper">
            <div class="auth-header">
                <h2>Create Account ✨</h2>
                <p>Join us today to get started.</p>
            </div>

            <form method="post" action="{{ route('register_save') }}" id="registerForm">
                @csrf

                <!-- Name Input -->
                <div class="form-floating">
                    <input type="text" class="form-control-custom @error('name') invalid-input @enderror" id="name"
                        name="name" value="{{ old('name') }}" placeholder="" autocomplete="name" required>
                    <label for="name">Full Name</label>
                    @error('name')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

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

                <!-- Passwords Row -->
                <div class="form-row">
                    <!-- Password Input -->
                    <div class="form-floating">
                        <input type="password" class="form-control-custom @error('password') invalid-input @enderror"
                            id="password" name="password" placeholder="" required>
                        <label for="password">Password</label>
                        <button type="button" class="password-toggle" id="togglePassword1"
                            aria-label="Toggle password visibility">
                            <i class="fas fa-eye" id="eyeIcon1"></i>
                        </button>
                        @error('password')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="form-floating">
                        <input type="password"
                            class="form-control-custom @error('confirm_password') invalid-input @enderror"
                            id="confirm_password" name="confirm_password" placeholder="" required>
                        <label for="confirm_password">Confirm Password</label>
                        <button type="button" class="password-toggle" id="togglePassword2"
                            aria-label="Toggle confirm password visibility">
                            <i class="fas fa-eye" id="eyeIcon2"></i>
                        </button>
                        @error('confirm_password')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="checkbox-wrapper">
                    <input type="checkbox" class="custom-checkbox @error('term_and_condition') invalid-input @enderror"
                        id="term_and_condition" name="term_and_condition" value="checkedValue" required>
                    <label for="term_and_condition" class="checkbox-label">
                        Yes, I want to receive discounts, loyalty offers, and other updates. I agree to the Terms.
                    </label>
                </div>
                @error('term_and_condition')
                    <div class="error-message" style="margin-top: -10px; margin-bottom: 10px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror

                <!-- Submit Button -->
                <button type="submit" class="btn-auth-primary">
                    Create Account <i class="fas fa-user-plus ml-2" style="font-size: 0.9em;"></i>
                </button>

                <!-- Divider -->
                <div class="auth-divider">Or sign up with</div>

                <!-- Social Login -->
                <a href="{{ url('login/google') }}" class="btn-google">
                    <img src="{{ asset('pizza-client/assets/img/icons/google.png') }}" alt="Google Logo"
                        onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg'">
                    Continue with Google
                </a>

                <!-- Sign In Link -->
                <div class="auth-footer">
                    Already have an account? <a href="{{ route('login') }}">Sign in here</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password Visibility Toggle for main password
            const togglePassword1 = document.getElementById('togglePassword1');
            const passwordInput1 = document.getElementById('password');
            const eyeIcon1 = document.getElementById('eyeIcon1');

            if (togglePassword1 && passwordInput1) {
                togglePassword1.addEventListener('click', function () {
                    const type = passwordInput1.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput1.setAttribute('type', type);

                    if (type === 'text') {
                        eyeIcon1.classList.remove('fa-eye');
                        eyeIcon1.classList.add('fa-eye-slash');
                    } else {
                        eyeIcon1.classList.remove('fa-eye-slash');
                        eyeIcon1.classList.add('fa-eye');
                    }
                });
            }

            // Password Visibility Toggle for confirm password
            const togglePassword2 = document.getElementById('togglePassword2');
            const passwordInput2 = document.getElementById('confirm_password');
            const eyeIcon2 = document.getElementById('eyeIcon2');

            if (togglePassword2 && passwordInput2) {
                togglePassword2.addEventListener('click', function () {
                    const type = passwordInput2.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput2.setAttribute('type', type);

                    if (type === 'text') {
                        eyeIcon2.classList.remove('fa-eye');
                        eyeIcon2.classList.add('fa-eye-slash');
                    } else {
                        eyeIcon2.classList.remove('fa-eye-slash');
                        eyeIcon2.classList.add('fa-eye');
                    }
                });
            }

            // Basic Client-Side Validation UX
            const form = document.getElementById('registerForm');
            const inputs = form.querySelectorAll('input[required]');

            inputs.forEach(input => {
                input.addEventListener('invalid', function (e) {
                    e.target.classList.add('invalid-input');
                });

                input.addEventListener('input', function (e) {
                    if (e.target.value.trim() !== '' && e.target.type !== 'checkbox') {
                        e.target.classList.remove('invalid-input');
                    }
                });

                if (input.type === 'checkbox') {
                    input.addEventListener('change', function (e) {
                        if (e.target.checked) {
                            e.target.classList.remove('invalid-input');
                        }
                    });
                }
            });

            // Validate password match before submit
            form.addEventListener('submit', function (e) {
                if (passwordInput1.value !== passwordInput2.value) {
                    passwordInput2.classList.add('invalid-input');
                    // Add a custom error message if it doesn't exist
                    let errorContainer = passwordInput2.parentElement.querySelector('.error-message');
                    if (!errorContainer) {
                        errorContainer = document.createElement('div');
                        errorContainer.className = 'error-message';
                        errorContainer.innerHTML = '<i class="fas fa-exclamation-circle"></i> Passwords do not match';
                        passwordInput2.parentElement.appendChild(errorContainer);
                    } else {
                        errorContainer.innerHTML = '<i class="fas fa-exclamation-circle"></i> Passwords do not match';
                    }
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection