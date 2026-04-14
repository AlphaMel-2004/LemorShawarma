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
        $phoneText = trim((string) ($contactSettings['contact_phone'] ?? ''));
        $phoneHref = preg_replace('/[^0-9+]/', '', $phoneText) ?? '';
        $hasPhoneContact = $phoneText !== '' && $phoneHref !== '';
        $heroSchedulePayload = [
            'selectedDays' => $selectedDays,
            'openMinutes' => $openMinutes,
            'closeMinutes' => $closeMinutes,
            'timezone' => config('app.timezone'),
        ];
    @endphp

    <!-- Background Image + Overlay -->
    <div class="hero-bg-image" style="background-image: url('{{ asset('images/background-image1.png') }}');"></div>
    <div class="hero-overlay"></div>

    <!-- Quick Info Bar -->
    <div
        class="hero-quick-info"
        id="heroLiveBadge"
        data-hero-schedule='@json($heroSchedulePayload)'
        aria-live="polite"
        aria-atomic="true"
    >
        <div class="quick-info-block">
            <span class="quick-info-title">QUICK INFO</span>
            @if($addressText !== '')
                <span class="quick-info-line quick-info-line--icon">
                    <i class="bi bi-geo-alt-fill quick-info-icon" aria-hidden="true"></i>
                    <span>{{ $addressText }}</span>
                </span>
            @endif
            @if($hasPhoneContact)
                <a href="tel:{{ $phoneHref }}" class="quick-info-line quick-info-line--icon quick-info-phone">
                    <i class="bi bi-telephone-fill quick-info-icon" aria-hidden="true"></i>
                    <span>{{ $phoneText }}</span>
                </a>
            @endif
        </div>

        <div class="quick-info-block quick-info-block--right">
            <span class="quick-info-title">HOURS</span>
            @if($openMinutes !== null && $closeMinutes !== null)
                <span class="quick-info-line" id="heroNextTimeLabel">
                    {{ $openMinutes !== null ? sprintf('%d:%02d %s', ($openMinutes % 720) === 0 ? 12 : intdiv($openMinutes, 60) % 12, $openMinutes % 60, $openMinutes >= 720 ? 'PM' : 'AM') . ' - ' . sprintf('%d:%02d %s', ($closeMinutes % 720) === 0 ? 12 : intdiv($closeMinutes, 60) % 12, $closeMinutes % 60, $closeMinutes >= 720 ? 'PM' : 'AM') : 'Hours not set' }}
                </span>
            @endif
            <span class="hero-open-pill {{ $isOpenNow ? 'is-open' : 'is-closed' }}" id="heroOpenPill">
                <i class="bi bi-circle-fill" aria-hidden="true"></i>
                <span id="heroOpenStatusText">{{ $isOpenNow ? 'Open now' : 'Closed now' }}</span>
            </span>
        </div>
    </div>

    <!-- Hero Main Content -->
    <div class="hero-main">
        <!-- Glass Card -->
        <div class="hero-glass-card" data-aos="fade-up" data-aos-duration="900">
            <h1 class="hero-script-name">Pita Queen</h1>
            <h2 class="hero-restaurant-label">RESTAURANT</h2>
            <p class="hero-tagline">Freshly made, always delicious.</p>
            <a href="{{ route('home') }}#order" class="hero-card-border-btn">
                <i class="bi bi-cart-fill" aria-hidden="true"></i>
                ORDER ONLINE
            </a>
        </div>
    </div>

    <!-- Snowman -->
    <div class="hero-snowman" aria-hidden="true">
        <!-- Hat -->
        <div class="snowman-hat">
            <div class="snowman-hat-brim"></div>
            <div class="snowman-hat-top"></div>
        </div>
        <!-- Head -->
        <div class="snowman-head">
            <div class="snowman-eye snowman-eye--left"></div>
            <div class="snowman-eye snowman-eye--right"></div>
            <div class="snowman-nose"></div>
            <div class="snowman-smile">
                <div class="snowman-tooth"></div>
                <div class="snowman-tooth"></div>
                <div class="snowman-tooth"></div>
            </div>
        </div>
        <!-- Body -->
        <div class="snowman-body">
            <div class="snowman-button"></div>
            <div class="snowman-button"></div>
            <div class="snowman-button"></div>
            <!-- Scarf -->
            <div class="snowman-scarf">
                <div class="snowman-scarf-knot"></div>
            </div>
            <!-- Arms -->
            <div class="snowman-arm snowman-arm--left"></div>
            <div class="snowman-arm snowman-arm--right"></div>
        </div>
        <!-- Snow base -->
        <div class="snowman-base"></div>
    </div>

    <!-- Spring Mascot -->
    <div class="hero-spring-mascot" aria-hidden="true">
        <div class="spring-flower-head">
            <div class="spring-petals">
                <div class="spring-petal spring-petal--1"></div>
                <div class="spring-petal spring-petal--2"></div>
                <div class="spring-petal spring-petal--3"></div>
                <div class="spring-petal spring-petal--4"></div>
                <div class="spring-petal spring-petal--5"></div>
                <div class="spring-petal spring-petal--6"></div>
                <div class="spring-petal spring-petal--7"></div>
                <div class="spring-petal spring-petal--8"></div>
            </div>
            <div class="spring-flower-center"></div>
        </div>
        <div class="spring-stem">
            <div class="spring-leaf spring-leaf--left"></div>
            <div class="spring-leaf spring-leaf--right"></div>
        </div>
        <div class="spring-pot-rim"></div>
        <div class="spring-pot"></div>
        <div class="spring-base"></div>
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
                }

                updateHeroOpenStatus();
                window.setInterval(updateHeroOpenStatus, 60000);
            })();
        </script>
    @endpush
@endonce
