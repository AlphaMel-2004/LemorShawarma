<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login — Pita Queen</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --black:        #0D0D0D;
            --black-light:  #1A1A1A;
            --black-soft:   #242424;
            --black-border: #2D2D2D;
            --black-deep:   #090909;
            --gold:         #D4AF37;
            --gold-light:   #E5C158;
            --gold-dark:    #B8942F;
            --gold-pale:    rgba(212, 175, 55, 0.08);
            --gold-glow:    rgba(212, 175, 55, 0.25);
            --text:         #FFFFFF;
            --text-muted:   rgba(255,255,255,0.5);
            --text-dim:     rgba(255,255,255,0.7);
            --radius:       24px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background:
                radial-gradient(circle at 12% 8%, rgba(212, 175, 55, 0.16), transparent 32%),
                radial-gradient(circle at 88% 88%, rgba(184, 148, 47, 0.12), transparent 36%),
                repeating-linear-gradient(135deg, rgba(212, 175, 55, 0.03) 0 2px, transparent 2px 16px),
                linear-gradient(180deg, #0f0f0f 0%, #090909 100%);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* ── Outer Card ── */
        .login-card {
            display: flex;
            width: 100%;
            max-width: 1060px;
            min-height: 620px;
            background-color: var(--black-light);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid rgba(212, 175, 55, 0.18);
            box-shadow: 0 36px 90px rgba(0, 0, 0, 0.62), 0 0 0 1px rgba(212, 175, 55, 0.08);
        }

        /* ══════════════════════════════
           LEFT PANEL — Branding
        ══════════════════════════════ */
        .login-left {
            flex: 1.1;
            background: linear-gradient(150deg, #141414 0%, #0D0D0D 52%, #1a1500 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(112deg, rgba(9, 9, 9, 0.9) 0%, rgba(9, 9, 9, 0.68) 46%, rgba(9, 9, 9, 0.94) 100%),
                url('{{ asset('images/lemorfood1.png') }}') center/cover no-repeat;
            opacity: 0.5;
            z-index: 0;
        }

        /* Decorative circles */
        .deco-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.45;
        }

        .deco-circle-1 {
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(212,175,55,0.18) 0%, transparent 70%);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }

        .deco-circle-2 {
            width: 180px; height: 180px;
            border: 1.5px solid rgba(212,175,55,0.2);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }

        .deco-circle-3 {
            width: 260px; height: 260px;
            border: 1px solid rgba(212,175,55,0.12);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }

        .deco-blob-tl {
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(212,175,55,0.1) 0%, transparent 65%);
            top: -60px; left: -60px;
        }

        .deco-blob-br {
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(212,175,55,0.08) 0%, transparent 65%);
            bottom: -60px; right: -40px;
        }

        /* Leaf / plant sprigs */
        .leaf {
            position: absolute;
            font-size: 2.2rem;
            opacity: 0.35;
            display: none;
        }
        .leaf-1 { bottom: 120px; left: 24px; transform: rotate(-20deg); }
        .leaf-2 { bottom: 80px;  left: 60px; transform: rotate(10deg); font-size: 1.6rem; }
        .leaf-3 { top: 110px; right: 28px;  transform: rotate(25deg); }
        .leaf-4 { top: 140px; right: 60px;  transform: rotate(-10deg); font-size: 1.4rem; }

        /* Centre illustration */
        .illustration-wrap {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -54%);
            z-index: 2;
            text-align: center;
            display: none;
        }

        .illustration-avatar {
            width: 140px; height: 140px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e1a00, #2a2200);
            border: 2px solid rgba(212,175,55,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4.5rem;
            margin: 0 auto;
            box-shadow: 0 0 40px rgba(212,175,55,0.15);
        }

        /* Brand top-left */
        .left-brand {
            position: relative;
            z-index: 3;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .brand-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            background: rgba(0, 0, 0, 0.46);
            border: 1px solid rgba(212, 175, 55, 0.3);
            box-shadow: 0 10px 24px rgba(212, 175, 55, 0.2);
            overflow: hidden;
        }

        .brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .brand-name {
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.3px;
        }

        .brand-tagline {
            font-size: 0.7rem;
            color: var(--gold);
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .left-hero-copy {
            position: relative;
            z-index: 3;
            margin-top: 2.1rem;
            max-width: 390px;
        }

        .left-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            border: 1px solid rgba(212, 175, 55, 0.34);
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold-light);
            font-size: 0.68rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            border-radius: 999px;
            padding: 0.4rem 0.72rem;
            font-weight: 600;
        }

        .left-hero-title {
            margin-top: 0.9rem;
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            line-height: 1.1;
            color: #fff;
            letter-spacing: -0.01em;
            text-wrap: balance;
        }

        .left-hero-title span {
            color: var(--gold);
            font-style: italic;
        }

        .left-hero-sub {
            margin-top: 0.75rem;
            font-size: 0.9rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.78);
        }

        .left-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.5rem;
            margin-top: 1rem;
            max-width: 360px;
        }

        .left-stat {
            border: 1px solid rgba(212, 175, 55, 0.24);
            background: rgba(12, 12, 12, 0.58);
            border-radius: 12px;
            padding: 0.48rem 0.54rem;
        }

        .left-stat strong {
            display: block;
            color: var(--gold-light);
            font-size: 0.9rem;
            line-height: 1;
        }

        .left-stat span {
            display: block;
            margin-top: 0.28rem;
            color: rgba(255, 255, 255, 0.58);
            font-size: 0.62rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        /* Bottom caption */
        .left-caption {
            position: relative;
            z-index: 3;
        }

        .left-caption p {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.7;
            max-width: 320px;
        }

        /* ══════════════════════════════
           RIGHT PANEL — Form
        ══════════════════════════════ */
        .login-right {
            flex: 1;
            background: linear-gradient(180deg, #212121 0%, #1a1a1a 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 2.75rem;
            position: relative;
            border-left: 1px solid rgba(212, 175, 55, 0.14);
        }

        /* "Welcome back" badge — top-right corner of the card */
        .welcome-badge {
            position: absolute;
            top: 0; right: 0;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--black);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 0.6rem 1.4rem;
            border-radius: 0 var(--radius) 0 var(--radius);
        }

        .form-heading {
            font-size: 1.7rem;
            font-weight: 700;
            margin-bottom: 0.35rem;
            letter-spacing: -0.01em;
        }

        .form-sub {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.64);
            margin-bottom: 2rem;
        }

        .admin-mark {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-bottom: 0.85rem;
            color: var(--gold-light);
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 600;
        }

        /* Input Groups */
        .input-group-custom {
            margin-bottom: 1.2rem;
        }

        .input-group-custom label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: var(--text-dim);
            text-transform: uppercase;
            margin-bottom: 0.4rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .field-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .input-wrapper input {
            width: 100%;
            background-color: var(--black-deep);
            border: 1.5px solid var(--black-border);
            color: var(--text);
            border-radius: 12px;
            padding: 0.78rem 2.9rem 0.78rem 2.6rem;
            font-size: 0.9rem;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: border-color 0.25s, box-shadow 0.25s;
        }

        .input-wrapper input::placeholder {
            color: rgba(255,255,255,0.25);
        }

        .input-wrapper input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px var(--gold-glow);
        }

        .input-wrapper input:focus + .field-icon,
        .input-wrapper input:focus ~ .field-icon {
            color: var(--gold);
        }

        /* Password toggle */
        .pw-toggle {
            position: absolute;
            right: 0.65rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1.95rem;
            height: 1.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            border-radius: 8px;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1rem;
            padding: 0;
            transition: color 0.2s;
            z-index: 2;
        }

        .pw-toggle:hover { color: var(--gold); }
        .pw-toggle:focus-visible {
            outline: 1px solid rgba(212, 175, 55, 0.55);
            outline-offset: 1px;
        }

        /* Is-invalid state */
        .input-wrapper input.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.18);
        }

        .error-msg {
            font-size: 0.78rem;
            color: #f87171;
            margin-top: 0.35rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* Row: remember + forgot */
        .form-row-extras {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.6rem;
            margin-top: -0.25rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: var(--text-dim);
            cursor: pointer;
            user-select: none;
        }

        .remember-label input[type="checkbox"] {
            accent-color: var(--gold);
            width: 15px; height: 15px;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }
        .forgot-link:hover { color: var(--gold); }

        /* Login Button */
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 50%, var(--gold-dark) 100%);
            color: var(--black);
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            cursor: pointer;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0);
            transition: background 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212,175,55,0.4);
        }

        .btn-login:hover::after { background: rgba(255,255,255,0.07); }

        .btn-login:active { transform: translateY(0); }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Alert */
        .auth-alert {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            color: #f87171;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.82rem;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 720px) {
            body { padding: 1rem; align-items: flex-start; }
            .login-card { flex-direction: column; min-height: auto; }
            .login-left { min-height: 320px; padding: 1.7rem; }
            .illustration-avatar { width: 84px; height: 84px; font-size: 2.6rem; }
            .deco-circle-1 { width: 200px; height: 200px; }
            .deco-circle-2 { width: 120px; height: 120px; }
            .deco-circle-3 { width: 160px; height: 160px; }
            .left-hero-title { font-size: 1.55rem; }
            .left-stats { grid-template-columns: repeat(3, minmax(0, 1fr)); max-width: none; }
            .left-caption { display: none; }
            .login-right { padding: 2.5rem 1.75rem 2rem; }
            .welcome-badge { font-size: 0.7rem; padding: 0.5rem 1rem; }
        }
    </style>
</head>
<body>

<div class="login-card">

    {{-- ── LEFT PANEL ── --}}
    <div class="login-left">
        <!-- Decorative blobs -->
        <span class="deco-circle deco-blob-tl"></span>
        <span class="deco-circle deco-blob-br"></span>
        <!-- Concentric circles -->
        <span class="deco-circle deco-circle-1"></span>
        <span class="deco-circle deco-circle-3"></span>
        <span class="deco-circle deco-circle-2"></span>

        <!-- Leaf sprigs -->
        <i class="bi bi-flower1 leaf leaf-1" aria-hidden="true"></i>
        <i class="bi bi-flower1 leaf leaf-2" aria-hidden="true"></i>
        <i class="bi bi-flower1 leaf leaf-3" aria-hidden="true"></i>
        <i class="bi bi-flower1 leaf leaf-4" aria-hidden="true"></i>

        <!-- Brand Logo -->
        <div class="left-brand">
            <div class="brand-icon"><img src="{{ asset('images/logo.png') }}" alt="Pita Queen logo"></div>
            <div>
                <div class="brand-name">Pita Queen</div>
                <div class="brand-tagline">Admin Portal</div>
            </div>
        </div>

        <div class="left-hero-copy">
            <div class="left-badge"><i class="bi bi-star-fill" aria-hidden="true"></i> Premium Kitchen Ops</div>
            <h2 class="left-hero-title">Keep The <span>Royal Taste</span> running flawlessly.</h2>
            <p class="left-hero-sub">Sign in to manage menu quality, store visibility, and guest feedback in one streamlined control center.</p>
            <div class="left-stats" aria-hidden="true">
                <div class="left-stat"><strong>24/7</strong><span>Control</span></div>
                <div class="left-stat"><strong>Fast</strong><span>Updates</span></div>
                <div class="left-stat"><strong>Secure</strong><span>Access</span></div>
            </div>
        </div>

        <!-- Centre Illustration -->
        <div class="illustration-wrap">
            <div class="illustration-avatar"><i class="bi bi-person-workspace" aria-hidden="true"></i></div>
        </div>

        <!-- Bottom Caption -->
        <div class="left-caption">
            <p>
                Manage your menu, track products, and keep your restaurant running
                smoothly — all from one secure dashboard.
            </p>
        </div>
    </div>

    {{-- ── RIGHT PANEL (FORM) ── --}}
    <div class="login-right">
        <!-- Welcome Badge -->
        <div class="welcome-badge">Welcome back</div>

        <div class="admin-mark"><i class="bi bi-shield-check" aria-hidden="true"></i> Admin Access</div>
        <h1 class="form-heading">Welcome Back, Team</h1>
        <p class="form-sub">Enter your credentials to access the admin panel.</p>

        <form method="POST" action="{{ route('admin.login.submit') }}" id="loginForm">
            @csrf

            {{-- Email --}}
            <div class="input-group-custom">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <i class="bi bi-envelope field-icon"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="admin@example.com"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        autofocus
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        required
                    >
                </div>
                @error('email')
                    <div class="error-msg">
                        <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="input-group-custom">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i class="bi bi-lock field-icon"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        required
                    >
                    <button type="button" class="pw-toggle" id="pwToggle" aria-label="Toggle password">
                        <i class="bi bi-eye" id="pwIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="error-msg">
                        <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Remember / Forgot --}}
            <div class="form-row-extras">
                <label class="remember-label">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>
                <span class="forgot-link" aria-disabled="true">Password reset unavailable</span>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-login" id="loginBtn">
                <span id="btnText">Login</span>
                <span id="btnLoader" style="display:none;">
                    <svg width="18" height="18" viewBox="0 0 38 38" stroke="currentColor" style="vertical-align:middle;">
                        <g fill="none"><g transform="translate(1 1)" stroke-width="2">
                            <circle stroke-opacity=".25" cx="18" cy="18" r="18"/>
                            <path d="M36 18c0-9.94-8.06-18-18-18">
                                <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="0.8s" repeatCount="indefinite"/>
                            </path>
                        </g></g>
                    </svg>
                    Signing in…
                </span>
            </button>
        </form>
    </div>

</div>

<script>
    // Password toggle
    document.getElementById('pwToggle').addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon  = document.getElementById('pwIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    });

    // Loading state on submit
    document.getElementById('loginForm').addEventListener('submit', function () {
        document.getElementById('btnText').style.display   = 'none';
        document.getElementById('btnLoader').style.display = 'inline';
        document.getElementById('loginBtn').disabled = true;
    });
</script>
</body>
</html>
