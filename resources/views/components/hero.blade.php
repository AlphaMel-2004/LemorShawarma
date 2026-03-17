@props(['contactSettings' => []])

<!-- Hero Section -->
<section class="hero-section" id="home">
    @php
        $hoursSource = trim((string) ($contactSettings['contact_hours'] ?? ''));
        $dayOrder = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $dayLookup = [
            'mon' => 'Mon',
            'tue' => 'Tue',
            'wed' => 'Wed',
            'thu' => 'Thu',
            'fri' => 'Fri',
            'sat' => 'Sat',
            'sun' => 'Sun',
        ];

        $normalizeDay = static function (?string $rawDay) use ($dayLookup): ?string {
            $key = strtolower(substr(trim((string) $rawDay), 0, 3));

            return $dayLookup[$key] ?? null;
        };

        $expandDayRange = static function (string $startDay, string $endDay) use ($dayOrder): array {
            $startIndex = array_search($startDay, $dayOrder, true);
            $endIndex = array_search($endDay, $dayOrder, true);

            if ($startIndex === false || $endIndex === false) {
                return [];
            }

            if ($startIndex <= $endIndex) {
                return array_slice($dayOrder, $startIndex, ($endIndex - $startIndex) + 1);
            }

            return array_merge(array_slice($dayOrder, $startIndex), array_slice($dayOrder, 0, $endIndex + 1));
        };

        $parseTimeToMinutes = static function (?string $rawTime): ?int {
            $normalized = strtoupper(preg_replace('/\s+/', '', trim((string) $rawTime)) ?? '');
            if (! preg_match('/^(\d{1,2})(?::(\d{2}))?(AM|PM)$/', $normalized, $matches)) {
                return null;
            }

            $hour = (int) $matches[1];
            $minute = isset($matches[2]) ? (int) $matches[2] : 0;

            if ($hour < 1 || $hour > 12 || $minute < 0 || $minute > 59) {
                return null;
            }

            $hour24 = $hour % 12;
            if ($matches[3] === 'PM') {
                $hour24 += 12;
            }

            return ($hour24 * 60) + $minute;
        };

        $formatMinutesToDisplay = static function (?int $minutes): string {
            if ($minutes === null) {
                return '';
            }

            $hour24 = intdiv($minutes, 60);
            $minute = $minutes % 60;
            $period = $hour24 >= 12 ? 'PM' : 'AM';
            $hour12 = $hour24 % 12;
            if ($hour12 === 0) {
                $hour12 = 12;
            }

            return sprintf('%d:%02d %s', $hour12, $minute, $period);
        };

        $selectedDays = [];
        $openMinutes = null;
        $closeMinutes = null;

        if ($hoursSource !== '' && preg_match('/^(.*?):\s*(.*?)\s*-\s*(.*?)$/', $hoursSource, $matches)) {
            $dayPart = trim($matches[1]);
            $openMinutes = $parseTimeToMinutes($matches[2]);
            $closeMinutes = $parseTimeToMinutes($matches[3]);

            if (preg_match('/^([A-Za-z]{3,})\s*-\s*([A-Za-z]{3,})$/', $dayPart, $dayRangeMatch)) {
                $startDay = $normalizeDay($dayRangeMatch[1]);
                $endDay = $normalizeDay($dayRangeMatch[2]);

                if ($startDay !== null && $endDay !== null) {
                    $selectedDays = $expandDayRange($startDay, $endDay);
                }
            } else {
                $selectedDays = array_values(array_filter(array_map(function (string $part) use ($normalizeDay): ?string {
                    return $normalizeDay($part);
                }, explode(',', $dayPart))));
            }
        }

        $todayShort = now()->format('D');
        $nowMinutes = (((int) now()->format('H')) * 60) + ((int) now()->format('i'));
        $isTodaySelected = in_array($todayShort, $selectedDays, true);

        $isOpenNow = false;
        if ($isTodaySelected && $openMinutes !== null && $closeMinutes !== null) {
            if ($openMinutes <= $closeMinutes) {
                $isOpenNow = $nowMinutes >= $openMinutes && $nowMinutes <= $closeMinutes;
            } else {
                $isOpenNow = $nowMinutes >= $openMinutes || $nowMinutes <= $closeMinutes;
            }
        }

        $nextTimeLabel = $isOpenNow
            ? 'Closes '.($formatMinutesToDisplay($closeMinutes) ?: 'soon')
            : 'Opens '.($formatMinutesToDisplay($openMinutes) ?: 'soon');

        $addressText = trim(collect([
            trim((string) ($contactSettings['contact_address_line1'] ?? '')),
            trim((string) ($contactSettings['contact_address_line2'] ?? '')),
        ])->filter()->implode(', '));
        $heroSchedulePayload = [
            'selectedDays' => $selectedDays,
            'openMinutes' => $openMinutes,
            'closeMinutes' => $closeMinutes,
            'timezone' => config('app.timezone'),
        ];
    @endphp

    <!-- Background Elements -->
    <div class="hero-bg">
        <div class="hero-gradient"></div>
        <div class="hero-pattern"></div>
        <div class="hero-particles" id="heroParticles"></div>
    </div>
    
    <!-- Floating Elements -->
    <div class="hero-floating-elements">
        <div class="floating-spice floating-spice-1"></div>
        <div class="floating-spice floating-spice-2"></div>
        <div class="floating-spice floating-spice-3"></div>
    </div>
    
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <div class="hero-content" data-aos="fade-right" data-aos-duration="1000">
                    <!-- Badge -->
                    <div class="hero-badge">
                        <span class="badge-icon"><i class="bi bi-star-fill" aria-hidden="true"></i></span>
                        <span class="badge-text">Premium Quality Since 2010</span>
                    </div>
                    
                    <!-- Heading -->
                    <h1 class="hero-title">
                        <span class="title-line">Experience The</span>
                        <span class="title-highlight">Royal Taste</span>
                        <span class="title-line">of Authentic</span>
                        <span class="title-accent">Canadian Cuisine</span>
                    </h1>
                    
                    <!-- Description -->
                    <p class="hero-description">
                        Indulge in the finest Canadian flavors, crafted with premium ingredients 
                        and time-honored recipes. Every bite is a journey to culinary excellence.
                    </p>

                    <div class="hero-live-badge" id="heroLiveBadge" data-hero-schedule='@json($heroSchedulePayload)' aria-live="polite" aria-atomic="true">
                        <div class="hero-live-address-row">
                            <span class="hero-live-address-icon" aria-hidden="true"><i class="bi bi-geo-alt-fill"></i></span>
                            <span class="hero-live-address-text">{{ $addressText !== '' ? $addressText : 'Visit our nearest branch today.' }}</span>
                        </div>
                        <div class="hero-live-top-row">
                            <span class="hero-open-pill {{ $isOpenNow ? 'is-open' : 'is-closed' }}" id="heroOpenPill">
                                <i class="bi bi-circle-fill" aria-hidden="true"></i>
                                <span id="heroOpenStatusText">{{ $isOpenNow ? 'Open now' : 'Closed now' }}</span>
                            </span>
                            <span class="hero-live-closing" id="heroNextTimeLabel">{{ $nextTimeLabel }}</span>
                        </div>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="hero-cta">
                        <a href="#menu" class="btn btn-golden btn-lg">
                            <span>Explore Menu</span>
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="#order" class="btn btn-outline-golden btn-lg">
                            <i class="bi bi-play-circle me-2"></i>
                            <span>Order Now</span>
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="hero-stats">
                        <div class="stat-item">
                            <span class="stat-number" data-count="15">0</span>
                            <span class="stat-label">Years Experience</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-number" data-count="50">0</span>
                            <span class="stat-suffix">K+</span>
                            <span class="stat-label">Happy Customers</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-number" data-count="30">0</span>
                            <span class="stat-suffix">+</span>
                            <span class="stat-label">Menu Items</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="hero-image" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="image-wrapper">
                        <!-- Main Image -->
                        <div class="main-image">
                               <img src="{{ asset('images/lemorfood1.png') }}" 
                                 alt="Delicious Mediterranean Cuisine at Pita Queen" 
                                 class="img-fluid"
                                 loading="eager">
                        </div>
                        
                        <!-- Decorative Ring -->
                        <div class="image-ring"></div>
                        <div class="image-ring image-ring-2"></div>
                        
                        <!-- Floating Cards -->
                        <div class="floating-card card-rating">
                            <div class="card-icon"><i class="bi bi-star-fill" aria-hidden="true"></i></div>
                            <div class="card-content">
                                <span class="card-value">4.9</span>
                                <span class="card-label">Rating</span>
                            </div>
                        </div>
                        
                        <div class="floating-card card-delivery">
                            <div class="card-icon"><i class="bi bi-truck" aria-hidden="true"></i></div>
                            <div class="card-content">
                                <span class="card-value">30 Min</span>
                                <span class="card-label">Delivery</span>
                            </div>
                        </div>
                        
                        <div class="floating-card card-fresh">
                            <div class="card-icon"><i class="bi bi-leaf-fill" aria-hidden="true"></i></div>
                            <div class="card-content">
                                <span class="card-value">100%</span>
                                <span class="card-label">Fresh</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="scroll-indicator">
        <a href="#about" class="scroll-link">
            <span class="scroll-text">Scroll Down</span>
            <span class="scroll-icon">
                <i class="bi bi-mouse"></i>
                <span class="scroll-dot"></span>
            </span>
        </a>
    </div>
</section>

@once
    @push('scripts')
        <script>
            (function () {
                var heroLiveBadge = document.getElementById('heroLiveBadge');
                var heroOpenPill = document.getElementById('heroOpenPill');
                var heroOpenStatusText = document.getElementById('heroOpenStatusText');
                var heroNextTimeLabel = document.getElementById('heroNextTimeLabel');

                if (! heroLiveBadge || ! heroOpenPill || ! heroOpenStatusText || ! heroNextTimeLabel) {
                    return;
                }

                var schedule = JSON.parse(heroLiveBadge.dataset.heroSchedule || '{}');
                var selectedDays = Array.isArray(schedule.selectedDays) ? schedule.selectedDays : [];
                var openMinutes = Number.isInteger(schedule.openMinutes) ? schedule.openMinutes : Number.parseInt(schedule.openMinutes, 10);
                var closeMinutes = Number.isInteger(schedule.closeMinutes) ? schedule.closeMinutes : Number.parseInt(schedule.closeMinutes, 10);
                var storeTimeZone = typeof schedule.timezone === 'string' ? schedule.timezone : 'UTC';

                if (selectedDays.length === 0 || Number.isNaN(openMinutes) || Number.isNaN(closeMinutes)) {
                    return;
                }

                function formatMinutesToDisplay(minutes) {
                    if (! Number.isInteger(minutes)) {
                        return 'soon';
                    }

                    var hour24 = Math.floor(minutes / 60);
                    var minute = minutes % 60;
                    var period = hour24 >= 12 ? 'PM' : 'AM';
                    var hour12 = hour24 % 12;

                    if (hour12 === 0) {
                        hour12 = 12;
                    }

                    return hour12 + ':' + String(minute).padStart(2, '0') + ' ' + period;
                }

                function getCurrentStoreTimeParts() {
                    if (! storeTimeZone || storeTimeZone === 'UTC') {
                        var browserNow = new Date();
                        var browserDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

                        return {
                            dayShort: browserDays[browserNow.getDay()],
                            minutes: (browserNow.getHours() * 60) + browserNow.getMinutes(),
                        };
                    }

                    var formatter = new Intl.DateTimeFormat('en-US', {
                        timeZone: storeTimeZone,
                        weekday: 'short',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false,
                    });

                    var parts = formatter.formatToParts(new Date());
                    var partLookup = parts.reduce(function (carry, part) {
                        carry[part.type] = part.value;

                        return carry;
                    }, {});

                    return {
                        dayShort: partLookup.weekday || '',
                        minutes: (Number.parseInt(partLookup.hour || '0', 10) * 60) + Number.parseInt(partLookup.minute || '0', 10),
                    };
                }

                function updateHeroOpenStatus() {
                    var currentStoreTime = getCurrentStoreTimeParts();
                    var isTodaySelected = selectedDays.indexOf(currentStoreTime.dayShort) !== -1;
                    var isOpenNow = false;

                    if (isTodaySelected) {
                        if (openMinutes <= closeMinutes) {
                            isOpenNow = currentStoreTime.minutes >= openMinutes && currentStoreTime.minutes <= closeMinutes;
                        } else {
                            isOpenNow = currentStoreTime.minutes >= openMinutes || currentStoreTime.minutes <= closeMinutes;
                        }
                    }

                    heroOpenPill.classList.toggle('is-open', isOpenNow);
                    heroOpenPill.classList.toggle('is-closed', ! isOpenNow);
                    heroOpenStatusText.textContent = isOpenNow ? 'Open now' : 'Closed now';
                    heroNextTimeLabel.textContent = (isOpenNow ? 'Closes ' : 'Opens ') + formatMinutesToDisplay(isOpenNow ? closeMinutes : openMinutes);
                }

                updateHeroOpenStatus();
                window.setInterval(updateHeroOpenStatus, 60000);
            })();
        </script>
    @endpush
@endonce
