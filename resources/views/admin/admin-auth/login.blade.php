<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes">
    <title>Admin Login - Lieferfood</title>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #dc2626;
            --primary-dark: #b91c1c;
            --primary-light: #fee2e2;
            --primary-extra-light: #fef2f2;
            --secondary-color: #059669;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --background-light: #f9fafb;
            --border-color: #e5e7eb;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --border-radius-lg: 20px;
            --border-radius-md: 14px;
            --border-radius-sm: 10px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #fecaca 0%, #fee2e2 50%, #fef2f2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            line-height: 1.5;
        }
        
        .login-container {
            width: 100%;
            max-width: 500px;
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-card {
            background: white;
            border-radius: var(--border-radius-lg);
            box-shadow: 0 25px 50px rgba(220, 38, 38, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(220, 38, 38, 0.1);
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(220, 38, 38, 0.2);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            padding: 1rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.15' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
        
        .logo-container {
            position: relative;
            z-index: 2;
            margin-bottom: 1.8rem;
        }
        
        .logo {
            height: 90px;
            width: 90px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            border: 3px solid rgba(255, 255, 255, 0.3);
        }
        
        .logo i {
            font-size: 2.8rem;
            color: var(--primary-color);
        }
        
        .logo-text {
            font-size: 2.2rem;
            font-weight: 800;
            margin-top: 0.8rem;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .welcome-text {
            font-size: 1.6rem;
            font-weight: 600;
            margin-top: 0rem;
            opacity: 0.95;
        }
        
        .card-body {
            padding: 2.8rem;
        }
        
        .form-group {
            margin-bottom: 2rem;
        }
        
        .form-label {
            display: block;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        
        .input-group {
            position: relative;
        }
        
        .form-control {
            width: 100%;
            padding: 1.3rem 1.3rem 1.3rem 4rem;
            border: 2.5px solid var(--border-color);
            border-radius: var(--border-radius-md);
            font-size: 1.5rem;
            font-weight: 500;
            color: var(--text-primary);
            transition: all 0.3s ease;
            background-color: white;
            line-height: 1.5;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.15);
            background-color: var(--primary-extra-light);
        }
        
        .form-control::placeholder {
            color: #9ca3af;
            font-size: 1.3rem;
            font-weight: 400;
        }
        
        .input-icon {
            position: absolute;
            left: 1.3rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 1.6rem;
        }
        
        .password-toggle {
            position: absolute;
            right: 1.3rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.6rem;
            cursor: pointer;
            padding: 0.6rem;
            transition: all 0.2s;
            border-radius: 50%;
        }
        
        .password-toggle:hover {
            color: var(--primary-color);
            background-color: var(--primary-light);
        }
        
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.2rem;
            font-size: 1.3rem;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            cursor: pointer;
            user-select: none;
        }
        
        .checkbox {
            width: 1.6rem;
            height: 1.6rem;
            accent-color: var(--primary-color);
            cursor: pointer;
        }
        
        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.2s;
            padding: 0.6rem 0.8rem;
            border-radius: var(--border-radius-sm);
            font-size: 1.3rem;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
            background-color: var(--primary-light);
        }
        
        .btn-login {
            width: 100%;
            padding: 1.4rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            border-radius: var(--border-radius-md);
            font-size: 1.6rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2.2rem;
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.35);
            letter-spacing: 0.5px;
        }
        
        .btn-login:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.45);
        }
        
        .btn-login:active {
            transform: translateY(-1px);
        }
        
        .security-info {
            background-color: var(--primary-light);
            border-radius: var(--border-radius-md);
            padding: 1.4rem;
            margin-top: 1.8rem;
            border-left: 5px solid var(--primary-color);
        }
        
        .security-info p {
            font-size: 1.3rem;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 500;
        }
        
        .error-message {
            color: var(--danger-color);
            font-size: 1.3rem;
            font-weight: 600;
            margin-top: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem;
            background-color: #fef2f2;
            border-radius: var(--border-radius-sm);
            border-left: 4px solid var(--danger-color);
        }
        
        .success-message {
            color: var(--secondary-color);
            font-size: 1.3rem;
            font-weight: 600;
            margin-top: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem;
            background-color: #f0fdf4;
            border-radius: var(--border-radius-sm);
            border-left: 4px solid var(--secondary-color);
        }
        
        /* MOBILE RESPONSIVE STYLES */
        @media (max-width: 768px) {
            body {
                padding: 15px;
                background: linear-gradient(135deg, #fee2e2 0%, #fef2f2 100%);
            }
            
            .login-container {
                max-width: 100%;
                margin: 0 10px;
            }
            
            .login-card {
                box-shadow: 0 15px 35px rgba(220, 38, 38, 0.15);
                border-radius: 18px;
            }
            
            .card-header {
                padding: 1rem;
            }
            
            .card-body {
                padding: 2.2rem 1.8rem;
            }
            
            .logo {
                height: 75px;
                width: 75px;
            }
            
            .logo i {
                font-size: 2.2rem;
            }
            
            .logo-text {
                font-size: 1.9rem;
            }
            
            .welcome-text {
                font-size: 1.4rem;
            }
            
            .form-label {
                font-size: 1.3rem;
                margin-bottom: 0.9rem;
            }
            
            .form-control {
                font-size: 1.4rem;
                padding: 1.1rem 1.1rem 1.1rem 3.5rem;
                border-width: 2px;
            }
            
            .input-icon {
                font-size: 1.4rem;
                left: 1.1rem;
            }
            
            .password-toggle {
                font-size: 1.4rem;
                right: 1.1rem;
            }
            
            .btn-login {
                font-size: 1.4rem;
                padding: 1.2rem;
            }
            
            .form-options {
                font-size: 1.2rem;
            }
            
            .forgot-password {
                font-size: 1.2rem;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 10px;
                align-items: flex-start;
                padding-top: 30px;
            }
            
            .login-card {
                border-radius: 16px;
                box-shadow: 0 10px 25px rgba(220, 38, 38, 0.15);
            }
            
            .card-header {
                padding: 1rem;
            }
            
            .card-body {
                padding: 1.8rem 1.5rem;
            }
            
            .logo {
                height: 65px;
                width: 65px;
            }
            
            .logo i {
                font-size: 1.9rem;
            }
            
            .logo-text {
                font-size: 1.7rem;
            }
            
            .welcome-text {
                font-size: 1.3rem;
            }
            
            .form-label {
                font-size: 1.25rem;
                margin-bottom: 0.8rem;
            }
            
            .form-control {
                font-size: 1.35rem;
                padding: 1rem 1rem 1rem 3.2rem;
            }
            
            .form-control::placeholder {
                font-size: 1.2rem;
            }
            
            .input-icon {
                font-size: 1.35rem;
                left: 1rem;
            }
            
            .btn-login {
                font-size: 1.35rem;
                padding: 1.1rem;
            }
            
            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                margin-bottom: 1.8rem;
            }
            
            .forgot-password {
                align-self: flex-end;
            }
            
            .security-info {
                padding: 1.2rem;
            }
            
            .security-info p {
                font-size: 1.2rem;
            }
        }
        
        @media (max-width: 360px) {
            .card-header {
                padding: 1.5rem 1.2rem;
            }
            
            .card-body {
                padding: 1.5rem 1.2rem;
            }
            
            .logo {
                height: 55px;
                width: 55px;
            }
            
            .logo i {
                font-size: 1.7rem;
            }
            
            .logo-text {
                font-size: 1.5rem;
            }
            
            .welcome-text {
                font-size: 1.2rem;
            }
            
            .form-control {
                font-size: 1.3rem;
                padding: 0.9rem 0.9rem 0.9rem 2.8rem;
            }
            
            .btn-login {
                font-size: 1.3rem;
                padding: 1rem;
            }
        }
        
        /* Tablet Landscape */
        @media (min-width: 769px) and (max-width: 1024px) {
            .login-container {
                max-width: 450px;
            }
            
            .card-header {
                padding: 2.5rem;
            }
            
            .card-body {
                padding: 2.5rem;
            }
        }
        
        /* Large Desktop */
        @media (min-width: 1400px) {
            .login-container {
                max-width: 550px;
            }
            
            .card-header {
                padding: 3.2rem;
            }
            
            .card-body {
                padding: 3.2rem;
            }
            
            .form-control {
                font-size: 1.6rem;
                padding: 1.5rem 1.5rem 1.5rem 4.5rem;
            }
            
            .btn-login {
                font-size: 1.8rem;
                padding: 1.6rem;
            }
        }
        
        /* Toast Container for Mobile */
        @media (max-width: 768px) {
            .toast-container {
                position: fixed;
                top: 10px;
                right: 10px;
                left: 10px;
                z-index: 9999;
            }
            
            .toast {
                min-width: auto;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="card-header">
               <img src="{{ asset('uploads/logo/logo5.png') }}"  style="height: 4rem;border-radius:10px;"
                                    alt="">
                <div class="welcome-text">Administrator Login</div>
            </div>
            
            <div class="card-body">
                <form id="adminLoginForm" method="post" action="{{ route('admin.signin') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-user-tie"></i>
                            </span>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="form-control"
                                   placeholder="Enter your admin email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   autofocus>
                        </div>
                        @if($errors->has('email'))
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-key"></i> Password
                        </label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-control"
                                   placeholder="Enter your password"
                                   required
                                   autocomplete="current-password">
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @if($errors->has('password'))
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    
                    
                    
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Sign In as Admin
                    </button>
                    
                   
                </form>
            </div>
        </div>
    </div>
    
    <!-- Toast Notification Container -->
    <div class="toast-container" id="toastContainer"></div>
    
    <script>
        // Password visibility toggle
        document.addEventListener('DOMContentLoaded', function() {
            // Simplified password toggle
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = this.querySelector('i');
    
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
            
            // Form validation and submission
            const loginForm = document.getElementById('adminLoginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            
            // Auto-focus email field
            if (emailInput && !emailInput.value) {
                setTimeout(() => emailInput.focus(), 300);
            }
            
            // Mobile-specific adjustments
            function adjustForMobile() {
                if (window.innerWidth <= 480) {
                    // Add touch-friendly styles for mobile
                    document.querySelectorAll('.form-control, .btn-login, .password-toggle').forEach(el => {
                        el.style.minHeight = '44px'; // Apple's recommended touch target size
                    });
                }
            }
            
            // Call on load and resize
            adjustForMobile();
            window.addEventListener('resize', adjustForMobile);
            
            // Form validation
            loginForm.addEventListener('submit', function(e) {
                let isValid = true;
                const email = emailInput.value.trim();
                const password = passwordInput.value.trim();
                
                // Reset styles
                emailInput.style.borderColor = '';
                passwordInput.style.borderColor = '';
                
                // Validate email
                if (!email) {
                    emailInput.style.borderColor = 'var(--danger-color)';
                    emailInput.focus();
                    isValid = false;
                } else if (!/\S+@\S+\.\S+/.test(email)) {
                    emailInput.style.borderColor = 'var(--danger-color)';
                    emailInput.focus();
                    isValid = false;
                }
                
                // Validate password
                if (!password) {
                    if (isValid) passwordInput.focus();
                    passwordInput.style.borderColor = 'var(--danger-color)';
                    isValid = false;
                }
                
                if (!isValid) {
                    e.preventDefault();
                    // Add visual feedback
                    if (!email) emailInput.classList.add('shake');
                    if (!password) passwordInput.classList.add('shake');
                    
                    setTimeout(() => {
                        emailInput.classList.remove('shake');
                        passwordInput.classList.remove('shake');
                    }, 500);
                } else {
                    // Show loading state
                    const submitButton = loginForm.querySelector('.btn-login');
                    const originalText = submitButton.innerHTML;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
                    submitButton.disabled = true;
                    
                    // Re-enable button after 3 seconds if form doesn't submit
                    setTimeout(() => {
                        submitButton.innerHTML = originalText;
                        submitButton.disabled = false;
                    }, 3000);
                }
            });
            
            // Add input validation styling
            [emailInput, passwordInput].forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.style.borderColor = 'var(--primary-color)';
                        this.style.backgroundColor = 'var(--primary-extra-light)';
                        setTimeout(() => {
                            this.style.borderColor = '';
                            this.style.backgroundColor = '';
                        }, 1000);
                    }
                });
            });
            
            // Add animation to form elements
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.opacity = '0';
                group.style.transform = 'translateY(20px)';
                group.style.animation = `fadeIn 0.5s ease-out ${index * 0.1}s forwards`;
            });
            
            // Add shake animation for errors
            const style = document.createElement('style');
            style.textContent = `
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                    20%, 40%, 60%, 80% { transform: translateX(5px); }
                }
                .shake {
                    animation: shake 0.5s ease-in-out;
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>
</html>