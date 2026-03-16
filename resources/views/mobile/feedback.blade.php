<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $pageTitle = 'Pita Queen - Feedback';
        $pageDescription = 'Share your experience with Pita Queen. Your feedback helps us improve every meal.';
        $pageCanonical = route('mobile.feedback.page');
        $pageImage = asset('images/logo.png');
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $pageDescription }}">
    <link rel="canonical" href="{{ $pageCanonical }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $pageCanonical }}">
    <meta property="og:image" content="{{ $pageImage }}">
    <title>{{ $pageTitle }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --gold: #D4AF37;
            --gold-light: #E5C158;
            --bg-dark: #0D0D0D;
            --bg-card: #1A1A1A;
            --bg-surface: #2D2D2D;
            --text-primary: #FFFFFF;
            --text-secondary: #A0A0A0;
            --text-muted: #6B6B6B;
            --border: #333333;
            --success: #22c55e;
            --danger: #ef4444;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .mobile-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(13, 13, 13, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: calc(0.75rem + env(safe-area-inset-top)) 1rem 0.75rem;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .header-brand img {
            height: 32px;
            width: auto;
        }

        .header-brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gold);
        }

        /* Page Hero */
        .feedback-page-hero {
            background: linear-gradient(165deg, rgba(212,175,55,0.12) 0%, rgba(13,13,13,0) 65%);
            border-bottom: 1px solid rgba(212,175,55,0.15);
            padding: 2.25rem 1.5rem 2rem;
            text-align: center;
        }

        .feedback-hero-ring {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: rgba(212,175,55,0.15);
            border: 1.5px solid rgba(212,175,55,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 1.85rem;
            margin: 0 auto 1rem;
        }

        .feedback-hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0 0 0.4rem;
            line-height: 1.25;
        }

        .feedback-hero-sub {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.5;
        }

        .content-area {
            padding: 1.25rem;
            padding-bottom: 3rem;
        }

        .feedback-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.5rem;
        }

        .fb-field { margin-bottom: 1.25rem; }

        .fb-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            margin-bottom: 0.4rem;
        }

        .fb-input, .fb-textarea {
            width: 100%;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.7rem 0.85rem;
            color: var(--text-primary);
            font-size: 0.85rem;
        }

        .fb-input:focus, .fb-textarea:focus {
            outline: none;
            border-color: var(--gold);
        }

        .fb-textarea { min-height: 120px; resize: vertical; }

        .star-rating {
            display: flex;
            gap: 0.5rem;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .star-rating input { display: none; }

        .star-rating label {
            font-size: 1.75rem;
            color: var(--border);
            cursor: pointer;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: var(--gold);
        }

        .btn-submit-feedback {
            width: 100%;
            background: var(--gold);
            color: var(--bg-dark);
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-submit-feedback:hover { background: var(--gold-light); }

        .feedback-success {
            text-align: center;
            padding: 2rem 0;
            display: none;
        }

        .feedback-success.show { display: block; }
        .feedback-success i { font-size: 3.5rem; color: var(--success); display: block; margin-bottom: 0.75rem; }

        .fb-error {
            color: var(--danger);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .mobile-toast {
            position: fixed;
            top: 1rem;
            left: 50%;
            transform: translateX(-50%) translateY(-120%);
            background: var(--bg-card);
            border: 1px solid var(--gold);
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            z-index: 999;
            color: var(--text-primary);
            font-size: 0.85rem;
            font-weight: 500;
            transition: transform 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .mobile-toast.show { transform: translateX(-50%) translateY(0); }

        .mobile-toast i { color: var(--gold); }
    </style>
</head>
<body>
    <header class="mobile-header">
        <div class="header-brand">
            <img src="/images/logo.png" alt="Pita Queen">
            <span class="header-brand-name">Pita Queen</span>
        </div>
    </header>

    {{-- Page Hero --}}
    <div class="feedback-page-hero">
        <div class="feedback-hero-ring">
            <i class="bi bi-chat-heart-fill"></i>
        </div>
        <h1 class="feedback-hero-title">Share Your <span style="color:var(--gold)">Experience</span></h1>
        <p class="feedback-hero-sub">We'd love to hear your thoughts about our food &amp; service</p>
    </div>

    <div class="content-area">
        <div class="feedback-card" id="feedbackFormCard">
            <form id="feedbackForm">
                <div class="fb-field">
                    <label class="fb-label">Your Name</label>
                    <input type="text" name="customer_name" class="fb-input" placeholder="Enter your name" required>
                    <div class="fb-error" id="err_customer_name"></div>
                </div>

                <div class="fb-field">
                    <label class="fb-label">Email <span style="color:var(--text-muted);font-weight:400">(optional)</span></label>
                    <input type="email" name="customer_email" class="fb-input" placeholder="your@email.com">
                    <div class="fb-error" id="err_customer_email"></div>
                </div>

                <div class="fb-field">
                    <label class="fb-label">Rating</label>
                    <div class="star-rating">
                        <input type="radio" name="rating" value="5" id="star5" checked>
                        <label for="star5"><i class="bi bi-star-fill"></i></label>
                        <input type="radio" name="rating" value="4" id="star4">
                        <label for="star4"><i class="bi bi-star-fill"></i></label>
                        <input type="radio" name="rating" value="3" id="star3">
                        <label for="star3"><i class="bi bi-star-fill"></i></label>
                        <input type="radio" name="rating" value="2" id="star2">
                        <label for="star2"><i class="bi bi-star-fill"></i></label>
                        <input type="radio" name="rating" value="1" id="star1">
                        <label for="star1"><i class="bi bi-star-fill"></i></label>
                    </div>
                    <div class="fb-error" id="err_rating"></div>
                </div>

                <div class="fb-field">
                    <label class="fb-label">Your Feedback</label>
                    <textarea name="message" class="fb-textarea" placeholder="Tell us about your experience..." maxlength="500" required></textarea>
                    <div class="fb-error" id="err_message"></div>
                </div>

                <button type="submit" class="btn-submit-feedback" id="submitFeedbackBtn">
                    <i class="bi bi-send me-1"></i> Submit Feedback
                </button>
            </form>
        </div>

        <div class="feedback-success" id="feedbackSuccess">
            <i class="bi bi-heart-fill"></i>
            <h3>Thank You!</h3>
            <p>Your feedback means everything to us.</p>
            <button class="btn-submit-feedback mt-3" onclick="resetFeedbackForm()" style="max-width: 200px; margin: 0 auto; display: block;">
                Submit Another
            </button>
        </div>
    </div>

    <div class="mobile-toast" id="mobileToast">
        <i class="bi bi-check-circle-fill"></i>
        <span id="toastMsg"></span>
    </div>

    <script>
        const feedbackForm = document.getElementById('feedbackForm');

        feedbackForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const btn = document.getElementById('submitFeedbackBtn');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Sending...';

            document.querySelectorAll('.fb-error').forEach(el => el.textContent = '');

            const data = new FormData(this);
            try {
                const res = await fetch("{{ route('mobile.feedback') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: data,
                });

                if (res.status === 422) {
                    const json = await res.json();
                    Object.entries(json.errors || {}).forEach(([key, msgs]) => {
                        const el = document.getElementById('err_' + key);
                        if (el) el.textContent = msgs[0];
                    });
                } else if (res.ok) {
                    document.getElementById('feedbackFormCard').style.display = 'none';
                    document.getElementById('feedbackSuccess').classList.add('show');
                }
            } catch (err) {
                showToast('Something went wrong. Please try again.');
            }

            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-send me-1"></i> Submit Feedback';
        });

        function resetFeedbackForm() {
            feedbackForm.reset();
            document.getElementById('feedbackFormCard').style.display = '';
            document.getElementById('feedbackSuccess').classList.remove('show');
            document.querySelectorAll('.fb-error').forEach(el => el.textContent = '');
        }

        function showToast(msg) {
            const toast = document.getElementById('mobileToast');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2000);
        }
    </script>
</body>
</html>
