<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $seoTitle = trim($__env->yieldContent('title', 'Pita Queen - Premium Canadian Cuisine'));
        $seoDescription = trim($__env->yieldContent('meta_description', 'Pita Queen serves authentic Canadian cuisine with premium shawarma, fresh pita, grilled favorites, and fast delivery.'));
        $seoCanonical = trim($__env->yieldContent('canonical', url()->current()));
        $seoImage = trim($__env->yieldContent('og_image', asset('images/logo.png')));
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="pita queen, shawarma, canadian cuisine, fresh pita, authentic middle eastern food, premium restaurant, canadian delivery, best shawarma, grill, kebab, falafel, hummus">
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">
    <meta name="author" content="Pita Queen">
    <link rel="canonical" href="{{ $seoCanonical }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">
    <title>{{ $seoTitle }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    
    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "Restaurant",
            "name": "{{ config('app.name') }}",
            "url": "{{ url('/') }}",
            "image": "{{ $seoImage }}",
            "servesCuisine": "Canadian",
            "menu": "{{ route('mobile.menu') }}"
        }
    </script>

    @if (trim($__env->yieldContent('structured_data')) !== '')
        @yield('structured_data')
    @endif
    
    @stack('styles')
</head>
<body>
    <!-- Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-content">
            <div class="loader-logo">
                <img src="/images/logo.png" alt="Pita Queen" style="height: 50px; width: auto;">
                <span class="logo-text">Pita Queen</span>
            </div>
            <div class="loader-spinner"></div>
        </div>
    </div>

    <!-- Season Animation -->
    <canvas id="seasonCanvas" aria-hidden="true"></canvas>

    <!-- Main Content -->
    <div class="page-wrapper">
        @if(trim($__env->yieldContent('hide_layout_chrome')) !== '1')
            <x-navbar />
        @endif
        
        <main>
            @yield('content')
        </main>

        @if(trim($__env->yieldContent('hide_layout_chrome')) !== '1')
            <x-footer />
        @endif
    </div>

    @if(trim($__env->yieldContent('hide_layout_chrome')) !== '1')
        <!-- Scroll to Top Button -->
        <button class="scroll-to-top" id="scrollToTop" aria-label="Scroll to top">
            <i class="bi bi-arrow-up"></i>
        </button>

        <!-- Season Switcher -->
        <div class="season-switcher" role="group" aria-label="Season theme">
            <button class="season-btn" data-season="none"   title="No season" aria-label="No season theme">🌤️</button>
            <button class="season-btn" data-season="winter" title="Winter" aria-label="Winter theme">❄️</button>
            <button class="season-btn" data-season="spring" title="Spring" aria-label="Spring theme">🌸</button>
            <button class="season-btn" data-season="summer" title="Summer" aria-label="Summer theme">☀️</button>
            <button class="season-btn" data-season="fall"   title="Fall" aria-label="Fall theme">🍂</button>
        </div>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Season Animation Engine -->
    <script>
    (function () {
        var canvas = document.getElementById('seasonCanvas');
        if (!canvas) return;
        var ctx = canvas.getContext('2d');
        var particles = [];
        var WINTER_COUNT = 35;
        var SPRING_COUNT = 14;
        var SUMMER_COUNT = 22;
        var FALL_COUNT   = 16;
        var currentSeason = localStorage.getItem('pq_season') || 'winter';

        function applySeasonClass(season) {
            document.body.classList.remove('season-winter', 'season-spring', 'season-summer', 'season-fall', 'season-none');
            document.body.classList.add('season-' + season);
        }

        function resize() {
            var w = canvas.offsetWidth || window.innerWidth;
            var h = canvas.offsetHeight || window.innerHeight;
            canvas.width = w;
            canvas.height = h;
        }
        var resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(resize, 150);
        });
        /* Defer first resize so CSS 100% has resolved */
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', resize);
        } else {
            resize();
        }

        function random(min, max) {
            return Math.random() * (max - min) + min;
        }

        /* ---- Winter ---- */
        function createSnowflake() {
            return {
                x: random(0, canvas.width),
                y: random(-canvas.height, 0),
                r: random(1, 2.8),
                speed: random(0.4, 1.1),
                drift: random(-0.2, 0.2),
                opacity: random(0.3, 0.65),
                swing: random(0, Math.PI * 2),
                swingSpeed: random(0.004, 0.012)
            };
        }

        function updateWinter() {
            for (var i = 0; i < particles.length; i++) {
                var f = particles[i];
                f.swing += f.swingSpeed;
                f.x += Math.sin(f.swing) * 0.6 + f.drift;
                f.y += f.speed;
                if (f.x < -f.r)               { f.x = canvas.width + f.r; }
                if (f.x > canvas.width + f.r)  { f.x = -f.r; }
                if (f.y > canvas.height + 10) {
                    particles[i] = createSnowflake();
                    particles[i].y = -6;
                }
            }
        }

        function drawWinter() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (var i = 0; i < particles.length; i++) {
                var f = particles[i];
                ctx.beginPath();
                ctx.arc(f.x, f.y, f.r, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255,255,255,' + f.opacity + ')';
                ctx.fill();
            }
        }

        /* ---- Summer ---- */
        var SUMMER_COLORS = [
            'rgba(255,220,80,', 'rgba(255,180,40,', 'rgba(255,240,150,',
            'rgba(255,200,60,', 'rgba(255,255,200,'
        ];

        function createFirefly() {
            return {
                x: random(0, canvas.width),
                y: random(canvas.height * 0.5, canvas.height * 1.2),
                r: random(1.2, 3.0),
                speed: random(0.35, 0.9),
                drift: random(-0.3, 0.3),
                opacity: random(0.5, 0.92),
                pulse: random(0, Math.PI * 2),
                pulseSpeed: random(0.025, 0.055),
                swing: random(0, Math.PI * 2),
                swingSpeed: random(0.006, 0.016),
                colorBase: SUMMER_COLORS[Math.floor(random(0, SUMMER_COLORS.length))]
            };
        }

        function updateSummer() {
            for (var i = 0; i < particles.length; i++) {
                var f = particles[i];
                f.pulse += f.pulseSpeed;
                f.swing += f.swingSpeed;
                f.x += Math.sin(f.swing) * 0.8 + f.drift;
                f.y -= f.speed;
                if (f.x < -f.r)               { f.x = canvas.width + f.r; }
                if (f.x > canvas.width + f.r)  { f.x = -f.r; }
                if (f.y < -10) {
                    particles[i] = createFirefly();
                    particles[i].y = canvas.height + 10;
                }
            }
        }

        function drawSummer() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (var i = 0; i < particles.length; i++) {
                var f = particles[i];
                var alpha = f.opacity * (0.5 + 0.5 * Math.sin(f.pulse));
                ctx.save();
                ctx.globalAlpha = alpha;
                ctx.shadowColor = f.colorBase + '1)';
                ctx.shadowBlur = f.r * 5;
                ctx.beginPath();
                ctx.arc(f.x, f.y, f.r, 0, Math.PI * 2);
                ctx.fillStyle = f.colorBase + '1)';
                ctx.fill();
                ctx.restore();
            }
        }

        /* ---- Spring ---- */
        var SPRING_COLORS = [
            'rgba(255,182,193,', 'rgba(255,145,175,', 'rgba(255,218,225,',
            'rgba(240,210,240,', 'rgba(255,255,255,'
        ];

        function createPetal() {
            return {
                x: random(0, canvas.width),
                y: random(-canvas.height, 0),
                size: random(3, 6),
                speed: random(0.5, 1.5),
                drift: random(-0.9, 0.9),
                opacity: random(0.65, 0.95),
                swing: random(0, Math.PI * 2),
                swingSpeed: random(0.008, 0.02),
                angle: random(0, Math.PI * 2),
                spin: random(-0.035, 0.035),
                colorBase: SPRING_COLORS[Math.floor(random(0, SPRING_COLORS.length))]
            };
        }

        function updateSpring() {
            for (var i = 0; i < particles.length; i++) {
                var p = particles[i];
                p.swing += p.swingSpeed;
                p.x += Math.sin(p.swing) * 1.8 + p.drift;
                p.y += p.speed;
                p.angle += p.spin;
                /* Wrap horizontally so petals never breach the canvas edge */
                if (p.x < -p.size)  { p.x = canvas.width + p.size; }
                if (p.x > canvas.width + p.size) { p.x = -p.size; }
                if (p.y > canvas.height + 14) {
                    particles[i] = createPetal();
                    particles[i].y = -12;
                }
            }
        }

        function drawSpring() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (var i = 0; i < particles.length; i++) {
                var p = particles[i];
                ctx.save();
                ctx.globalAlpha = p.opacity;
                ctx.translate(p.x, p.y);
                ctx.rotate(p.angle);
                var s = p.size;
                for (var k = 0; k < 5; k++) {
                    ctx.save();
                    ctx.rotate((k * 2 * Math.PI) / 5);
                    ctx.beginPath();
                    ctx.moveTo(0, 0);
                    ctx.bezierCurveTo(s * 0.45, -s * 0.2, s * 0.55, -s * 0.85, 0, -s);
                    ctx.bezierCurveTo(-s * 0.55, -s * 0.85, -s * 0.45, -s * 0.2, 0, 0);
                    ctx.fillStyle = p.colorBase + '1)';
                    ctx.fill();
                    ctx.restore();
                }
                ctx.beginPath();
                ctx.arc(0, 0, s * 0.22, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255,230,80,0.95)';
                ctx.fill();
                ctx.restore();
            }
        }

        /* ---- Fall ---- */
        var FALL_COLORS = [
            '#e8622a', '#c0392b', '#e67e22', '#d4ac0d', '#b7500f',
            '#f39c12', '#922b21', '#f0a500'
        ];

        function createLeaf() {
            return {
                x: random(0, canvas.width),
                y: random(-canvas.height, 0),
                size: random(4, 7),
                speed: random(0.6, 1.6),
                drift: random(-1.0, 1.0),
                opacity: random(0.72, 0.95),
                swing: random(0, Math.PI * 2),
                swingSpeed: random(0.01, 0.025),
                angle: random(0, Math.PI * 2),
                spin: random(-0.05, 0.05),
                color: FALL_COLORS[Math.floor(random(0, FALL_COLORS.length))]
            };
        }

        function updateFall() {
            for (var i = 0; i < particles.length; i++) {
                var l = particles[i];
                l.swing += l.swingSpeed;
                l.x += Math.sin(l.swing) * 2.2 + l.drift;
                l.y += l.speed;
                l.angle += l.spin;
                if (l.x < -l.size)               { l.x = canvas.width + l.size; }
                if (l.x > canvas.width + l.size)  { l.x = -l.size; }
                if (l.y > canvas.height + 16) {
                    particles[i] = createLeaf();
                    particles[i].y = -14;
                }
            }
        }

        function drawFall() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (var i = 0; i < particles.length; i++) {
                var l = particles[i];
                ctx.save();
                ctx.globalAlpha = l.opacity;
                ctx.translate(l.x, l.y);
                ctx.rotate(l.angle);
                var s = l.size;
                /* Simple maple-like leaf: ellipse body + pointed tip */
                ctx.beginPath();
                ctx.ellipse(0, 0, s * 0.55, s, 0, 0, Math.PI * 2);
                ctx.fillStyle = l.color;
                ctx.fill();
                /* Stem */
                ctx.beginPath();
                ctx.moveTo(0, s);
                ctx.lineTo(0, s + s * 0.55);
                ctx.strokeStyle = l.color;
                ctx.lineWidth = 1;
                ctx.stroke();
                ctx.restore();
            }
        }

        /* ---- Engine ---- */
        function getTargetCount(season) {
            if (season === 'none')   { return 0; }
            if (season === 'spring') { return SPRING_COUNT; }
            if (season === 'summer') { return SUMMER_COUNT; }
            if (season === 'fall')   { return FALL_COUNT; }
            return WINTER_COUNT;
        }

        function makeParticle(season) {
            if (season === 'spring') { return createPetal(); }
            if (season === 'summer') { return createFirefly(); }
            if (season === 'fall')   { return createLeaf(); }
            return createSnowflake();
        }

        function swapParticles(season) {
            var targetCount = getTargetCount(season);
            /* Re-type existing particles in-place so array is never empty */
            for (var i = 0; i < particles.length; i++) {
                var cur = particles[i];
                var np  = makeParticle(season);
                np.x = cur.x;
                np.y = cur.y;
                particles[i] = np;
            }
            /* Add or remove to reach target count */
            while (particles.length < targetCount) {
                var p = makeParticle(season);
                p.y = random(0, canvas.height);
                particles.push(p);
            }
            while (particles.length > targetCount) {
                particles.pop();
            }
        }

        function initParticles(season) {
            particles = [];
            var count = getTargetCount(season);
            for (var i = 0; i < count; i++) {
                var p = makeParticle(season);
                p.y = random(0, canvas.height);
                particles.push(p);
            }
        }

        function loop() {
            if (currentSeason === 'none') {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            } else if (currentSeason === 'spring') {
                updateSpring();
                drawSpring();
            } else if (currentSeason === 'summer') {
                updateSummer();
                drawSummer();
            } else if (currentSeason === 'fall') {
                updateFall();
                drawFall();
            } else {
                updateWinter();
                drawWinter();
            }
            requestAnimationFrame(loop);
        }

        var SEASON_META = {
            none:   { icon: '🌤️', label: 'Normal' },
            winter: { icon: '❄️', label: 'Winter' },
            spring: { icon: '🌸', label: 'Spring' },
            summer: { icon: '☀️', label: 'Summer' },
            fall:   { icon: '🍂', label: 'Fall' }
        };

        function updateSeasonLabel(season) {
            var label = document.getElementById('seasonLabel');
            if (!label) { return; }
            var meta = SEASON_META[season] || SEASON_META.none;
            label.setAttribute('data-season', season);
            label.querySelector('.season-label-icon').textContent = meta.icon;
            label.querySelector('.season-label-text').textContent = meta.label;
        }

        function setSeason(season) {
            currentSeason = season;
            localStorage.setItem('pq_season', season);
            applySeasonClass(season);
            swapParticles(season);
            updateSeasonLabel(season);
            document.querySelectorAll('.season-btn').forEach(function (btn) {
                btn.classList.toggle('is-active', btn.dataset.season === season);
            });
        }

        /* init */
        applySeasonClass(currentSeason);
        initParticles(currentSeason);
        loop();

        document.addEventListener('DOMContentLoaded', function () {
            updateSeasonLabel(currentSeason);
            document.querySelectorAll('.season-btn').forEach(function (btn) {
                btn.classList.toggle('is-active', btn.dataset.season === currentSeason);
                btn.addEventListener('click', function () {
                    setSeason(btn.dataset.season);
                });
            });
        });
    })();
    </script>
    
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    @stack('scripts')
</body>
</html>
