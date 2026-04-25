@extends('external.frame')

@section('external-css')
    <style>
        :root {
            --brand-primary: #f41909;
            --brand-dark: #c41407;
            --brand-light: #fbeae9;
            --brand-gradient: linear-gradient(135deg, #f41909 0%, #c41407 100%);
            --text-main: #1a1a2e;
            --text-muted: #6b7280;
            --bg-body: #f4f6fb;
            --border-color: #e5e7eb;
            --input-bg: #fff;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.05);
            --shadow-md: 0 4px 24px rgba(0,0,0,.10);
            --shadow-lg: 0 12px 48px rgba(0,0,0,.14);
            --radius-lg: 20px;
            --radius-xl: 28px;
        }
.bg-1000{
    display: none !important;
}
        /* ── Base ── */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            background-color: var(--bg-body);
            font-family: 'Source Sans Pro', sans-serif;
        }

        /* ── Page Shell ── */
        .auth-page {
            /* min-height: 100vh; */
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-body);
            padding: 0.5rem 1.25rem;
            /* padding-top: calc(2.5rem + 80px); */
        }

        .auth-card {
            width: 100%;
            max-width: 700px;
            background: #fff;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            padding: 1.5rem 1.5rem;
            animation: cardIn .45s cubic-bezier(.22,.61,.36,1) both;
        }

        /* Card header */
        .auth-card__header {
            margin-bottom: 0.5rem;
        }
        .auth-card__badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: var(--brand-light);
            color: var(--brand-primary);
            border-radius: 999px;
            padding: .4rem 1rem;
            font-size: .95rem;
            font-weight: 700;
            letter-spacing: .3px;
            margin-bottom: .5rem;
        }
        .auth-card__title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.2;
            margin-bottom: 0rem;
        }
        .auth-card__sub {
            font-size: 1rem;
            color: var(--text-muted);
            padding-bottom: 0px !important;
            margin-bottom: 0px !important;
        }

        /* ── Inputs ── */
        .input-group-custom {
            position: relative;
            margin-bottom: 1rem;
        }
        .input-group-custom__icon {
            position: absolute;
            left: 1.1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.15rem;
            pointer-events: none;
            transition: color .2s;
            z-index: 1;
        }
        .input-group-custom:focus-within .input-group-custom__icon {
            color: var(--brand-primary);
        }
        .input-field {
            width: 100%;
            height: 58px;
            padding: 0 3.25rem 0 3rem;
            font-size: 18px;
            font-family: inherit;
            font-weight: 500;
            color: var(--text-main);
            background: #f8f9fb;
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            outline: none;
            transition: border-color .2s, background .2s, box-shadow .2s;
            -webkit-appearance: none;
        }
        .input-field::placeholder {
            color: #9ca3af;
            font-weight: 400;
            font-size: 17px;
            opacity: 1;
        }
        .input-field:focus {
            background: #fff;
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3.5px rgba(244,25,9,.1);
        }
        .input-field.is-invalid {
            border-color: #ef4444;
            background: #fef2f2;
        }
        .input-field.is-invalid:focus {
            box-shadow: 0 0 0 3.5px rgba(239,68,68,.1);
        }

        /* eye toggle */
        .btn-eye {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: .4rem;
            border-radius: 8px;
            line-height: 1;
            font-size: 1rem;
            transition: color .2s, background .2s;
        }
        .btn-eye:hover { background: #f0f0f0; color: var(--text-main); }

        /* field label */
        .field-label {
            display: block;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: .55rem;
        }

        /* validation error */
        .field-error {
            display: flex;
            align-items: center;
            gap: .3rem;
            color: #ef4444;
            font-size: .95rem;
            font-weight: 600;
            margin-top: .4rem;
            animation: fadeUp .25s ease;
        }

        /* ── Row: remember + forgot ── */
        .auth-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: .5rem 0 .5rem;
        }
        .remember-label {
            display: flex;
            align-items: center;
            gap: .6rem;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            user-select: none;
        }
        .remember-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            accent-color: var(--brand-primary);
            cursor: pointer;
        }
        .forgot-link {
            font-size: 1rem;
            font-weight: 700;
            color: var(--brand-primary);
            text-decoration: none;
            transition: color .2s;
        }
        .forgot-link:hover { color: var(--brand-dark); text-decoration: underline; }

        /* ── Primary button ── */
        .btn-signin {
            width: 100%;
            height: 58px;
            background: var(--brand-gradient);
            color: #fff;
            border: none;
            border-radius: 14px;
            font-size: 1.2rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
            box-shadow: 0 4px 18px rgba(244,25,9,.32);
            transition: transform .2s, box-shadow .2s, opacity .2s;
            position: relative;
            overflow: hidden;
        }
        .btn-signin:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(244,25,9,.42);
        }
        .btn-signin:active:not(:disabled) {
            transform: translateY(0);
            box-shadow: 0 3px 12px rgba(244,25,9,.28);
        }
        .btn-signin:disabled {
            opacity: .7;
            cursor: not-allowed;
        }
        /* shimmer on hover */
        .btn-signin::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.22), transparent);
            transition: left .5s;
        }
        .btn-signin:hover::after { left: 160%; }

        /* spinner */
        .btn-spinner {
            display: none;
            width: 20px; height: 20px;
            border: 2.5px solid rgba(255,255,255,.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        .btn-signin.loading .btn-label { display: none; }
        .btn-signin.loading .btn-spinner { display: block; }

        /* ── Divider ── */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 0.5rem 0;
            color: var(--text-muted);
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: .4px;
            text-transform: uppercase;
        }
        .auth-divider::before, .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        /* ── Google button ── */
        .btn-google {
            width: 100%;
            height: 56px;
            background: #fff;
            color: var(--text-main);
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            font-size: 1.1rem;
            font-weight: 600;
            font-family: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .75rem;
            cursor: pointer;
            text-decoration: none;
            transition: border-color .2s, box-shadow .2s, transform .2s;
            box-shadow: var(--shadow-sm);
        }
        .btn-google:hover {
            border-color: #c5c9d3;
            box-shadow: 0 4px 14px rgba(0,0,0,.08);
            transform: translateY(-1px);
            color: var(--text-main);
        }
        .btn-google img {
            width: 22px; height: 22px;
            flex-shrink: 0;
        }

        /* ── Footer ── */
        .auth-card__footer {
            margin-top: 0.5rem;
            text-align: center;
            font-size: 1.05rem;
            color: var(--text-muted);
        }
        .auth-card__footer a {
            color: var(--brand-primary);
            font-weight: 700;
            text-decoration: none;
            margin-left: .2rem;
            transition: color .2s;
        }
        .auth-card__footer a:hover { color: var(--brand-dark); text-decoration: underline; }

        /* ── Animations ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(24px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ── Alert banner (session flash errors) ── */
        .alert-banner {
            display: flex;
            align-items: flex-start;
            gap: .75rem;
            padding: .65rem .9rem;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 12px;
            margin-bottom: 1rem;
            font-size: .875rem;
            color: #b91c1c;
            font-weight: 500;
        }
        .alert-banner i { margin-top: 1px; flex-shrink: 0; }
    </style>
@endsection

@section('external-home-content')
<div class="auth-page">

    <div class="auth-card">

            {{-- Card header --}}
            <div class="auth-card__header">
                <div class="auth-card__badge">
                    <i class="fas fa-utensils" style="font-size:.7rem;"></i>
                    Welcome back
                </div>
                <h1 class="auth-card__title">Sign in to your account</h1>
                <p class="auth-card__sub">Enter your credentials to continue ordering.</p>
            </div>

            {{-- Flash / session error --}}
            @if(session('error'))
                <div class="alert-banner">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form method="post" action="{{ route('login_verify') }}" id="loginForm" novalidate>
                @csrf

                {{-- Email --}}
                <div style="margin-bottom:1rem;">
                    <label class="field-label" for="email">Email address</label>
                    <div class="input-group-custom">
                        <i class="fas fa-envelope input-group-custom__icon"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="input-field @error('email') is-invalid @enderror"
                            placeholder="you@example.com"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required
                        >
                    </div>
                    @error('email')
                        <div class="field-error">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Password --}}
                <div style="margin-bottom:1.25rem;">
                    <label class="field-label" for="password">Password</label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock input-group-custom__icon"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="input-field @error('password') is-invalid @enderror"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="btn-eye" id="togglePassword" aria-label="Toggle password visibility">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="field-error">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Remember me + Forgot password --}}
                <div class="auth-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    <a href="{{ route('forgetpassword') }}" class="forgot-link">Forgot password?</a>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-signin" id="submitBtn">
                    <span class="btn-label">
                        Sign In &nbsp;<i class="fas fa-arrow-right" style="font-size:.85em;"></i>
                    </span>
                    <span class="btn-spinner"></span>
                </button>

                {{-- Divider --}}
                <div class="auth-divider">or</div>

                {{-- Google --}}
                <a href="{{ url('login/google') }}" class="btn-google">
                    <img
                        src="{{ asset('pizza-client/assets/img/icons/google.png') }}"
                        alt="Google"
                        onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg'"
                    >
                    Continue with Google
                </a>

                {{-- Footer --}}
                <div class="auth-card__footer">
                    Don't have an account?
                    <a href="{{ route('register') }}">Create one free</a>
                </div>

            </form>
        </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Password toggle ── */
    const toggleBtn   = document.getElementById('togglePassword');
    const passwordFld = document.getElementById('password');
    const eyeIcon     = document.getElementById('eyeIcon');

    if (toggleBtn && passwordFld) {
        toggleBtn.addEventListener('click', function () {
            const isText = passwordFld.type === 'text';
            passwordFld.type = isText ? 'password' : 'text';
            eyeIcon.className = isText ? 'fas fa-eye' : 'fas fa-eye-slash';
        });
    }

    /* ── Form submit: loading state ── */
    const form      = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function (e) {
        const emailVal    = document.getElementById('email').value.trim();
        const passwordVal = passwordFld.value;

        if (!emailVal || !passwordVal) return; // let HTML5 validation fire

        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
    });

    /* ── Inline validation feedback ── */
    form.querySelectorAll('input[required]').forEach(function (input) {
        input.addEventListener('blur', function () {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });
        input.addEventListener('input', function () {
            if (input.value.trim()) {
                input.classList.remove('is-invalid');
            }
        });
    });

});
</script>
@endsection