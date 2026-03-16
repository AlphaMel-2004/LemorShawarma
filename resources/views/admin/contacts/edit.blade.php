@extends('layouts.admin')

@section('title', 'Manage Contacts')
@section('page-title', 'Manage Contacts')

@push('styles')
<style>
    /* ── Cards ── */
    .settings-card {
        background-color: var(--admin-card);
        border: 1px solid var(--admin-border);
        border-radius: 14px;
        overflow: hidden;
    }

    .card-header-bar {
        padding: 1.25rem 1.75rem;
        border-bottom: 1px solid var(--admin-border);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-header-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .card-header-icon-blue {
        background: rgba(57, 106, 255, 0.12);
        color: var(--admin-primary);
    }

    .card-header-icon-green {
        background: rgba(22, 219, 170, 0.12);
        color: var(--admin-success);
    }

    .card-header-icon-violet {
        background: rgba(124, 58, 237, 0.12);
        color: #7c3aed;
    }

    .card-header-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--admin-text);
        margin-bottom: 0;
    }

    .card-header-sub {
        font-size: 0.75rem;
        color: var(--admin-text-muted);
        margin-bottom: 0;
    }

    .card-body-inner {
        padding: 1.5rem 1.75rem;
    }

    /* ── Form Fields ── */
    .field-group {
        margin-bottom: 1.35rem;
    }

    .field-group:last-of-type {
        margin-bottom: 0;
    }

    .field-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .field-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .field-icon-location { background: rgba(57, 106, 255, 0.10); color: var(--admin-primary); }
    .field-icon-phone    { background: rgba(22, 219, 170, 0.10); color: var(--admin-success); }
    .field-icon-email    { background: rgba(254, 92, 115, 0.10); color: var(--admin-danger); }
    .field-icon-clock    { background: rgba(245, 158, 11, 0.10); color: #f59e0b; }

    .field-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--admin-text);
    }

    /* ── Preview ── */
    .preview-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.65rem 0;
        border-bottom: 1px solid var(--admin-border);
    }

    .preview-item:last-child { border-bottom: none; }

    .preview-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(57, 106, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--admin-primary);
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .preview-label {
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--admin-text-muted);
        font-weight: 600;
    }

    .preview-value {
        font-size: 0.85rem;
        color: var(--admin-text);
        font-weight: 500;
    }

    /* ── Buttons ── */
    .btn-save {
        background: var(--admin-primary);
        color: #0d0d0d;
        border: none;
        padding: 0.65rem 1.75rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-save:hover {
        background: var(--admin-primary-hover);
        color: #0d0d0d;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(57, 106, 255, 0.3);
    }

    .btn-save:disabled {
        opacity: 0.65;
        transform: none;
        box-shadow: none;
    }

    .hours-builder {
        border: 1px solid var(--admin-border);
        border-radius: 10px;
        background: rgba(18, 18, 18, 0.92);
        padding: 0.95rem;
    }

    .hours-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 0.55rem;
    }

    .hours-top-label {
        margin: 0;
        font-size: 0.76rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--admin-text-muted);
        font-weight: 700;
    }

    .hours-presets {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 0.35rem;
    }

    .hours-preset {
        border: 1px solid var(--admin-border);
        background: rgba(255, 255, 255, 0.02);
        color: var(--admin-text-muted);
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.27rem 0.62rem;
        transition: all 0.16s ease;
    }

    .hours-preset:hover {
        color: #ffdca1;
        border-color: rgba(245, 158, 11, 0.58);
        background: rgba(245, 158, 11, 0.15);
    }

    .hours-days {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        gap: 0.4rem;
    }

    .hours-day {
        border: 1px solid var(--admin-border);
        background: transparent;
        color: var(--admin-text-muted);
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 0.42rem 0.25rem;
        transition: all 0.18s ease;
    }

    .hours-day:hover {
        border-color: rgba(245, 158, 11, 0.6);
        color: var(--admin-text);
    }

    .hours-day.active {
        border-color: rgba(245, 158, 11, 0.78);
        background: rgba(245, 158, 11, 0.18);
        color: #ffdca1;
    }

    .hours-time-wrap {
        margin-top: 0.75rem;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.65rem;
    }

    .hours-time-label {
        display: block;
        font-size: 0.72rem;
        color: var(--admin-text-muted);
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        font-weight: 700;
    }

    .hours-preview {
        margin-top: 0.7rem;
        border: 1px solid var(--admin-border);
        border-radius: 8px;
        padding: 0.55rem 0.7rem;
        background: rgba(255, 255, 255, 0.02);
    }

    .hours-preview-label {
        display: block;
        font-size: 0.68rem;
        color: var(--admin-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 0.15rem;
    }

    .hours-preview-value {
        font-size: 0.86rem;
        color: var(--admin-text);
        font-weight: 500;
    }

    .hours-help {
        font-size: 0.78rem;
        color: var(--admin-text-muted);
        margin-top: 0.48rem;
        margin-bottom: 0;
    }

    #contactHoursOpen,
    #contactHoursClose {
        color: var(--admin-text);
        color-scheme: dark;
        padding-right: 2.65rem;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='12' cy='12' r='9'/%3E%3Cpath d='M12 7v5l3 2'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.85rem center;
        background-size: 1.05rem 1.05rem;
    }

    #contactHoursOpen::-webkit-calendar-picker-indicator,
    #contactHoursClose::-webkit-calendar-picker-indicator {
        opacity: 0 !important;
        width: 1.2rem;
        height: 1.2rem;
        cursor: pointer;
    }

    #contactHoursOpen::-webkit-datetime-edit,
    #contactHoursClose::-webkit-datetime-edit {
        color: var(--admin-text);
    }

    /* ── Sticky sidebar ── */
    @media (min-width: 992px) {
        .sidebar-sticky {
            position: sticky;
            top: 100px;
        }
    }

    @media (max-width: 768px) {
        .hours-days {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .hours-time-wrap {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <div class="row g-4">
        {{-- ══ Edit Form ══ --}}
        <div class="col-lg-7">
            <div class="settings-card">
                <div class="card-header-bar">
                    <div class="card-header-icon card-header-icon-blue">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <p class="card-header-title">Contact Information</p>
                        <p class="card-header-sub">Update details shown on the website footer & contact section</p>
                    </div>
                </div>

                <div class="card-body-inner">
                    <form method="POST" action="{{ route('admin.contacts.update') }}" id="contactForm">
                        @csrf
                        @method('PUT')

                        {{-- Address Line 1 --}}
                        <div class="field-group">
                            <div class="field-row">
                                <div class="field-icon field-icon-location"><i class="bi bi-geo-alt-fill"></i></div>
                                <span class="field-label">Street Address</span>
                            </div>
                            <input
                                type="text"
                                name="contact_address_line1"
                                class="admin-form-control w-100 @error('contact_address_line1') is-invalid @enderror"
                                value="{{ old('contact_address_line1', $settings['contact_address_line1']) }}"
                                placeholder="e.g. 123 Royal Avenue"
                            >
                            @error('contact_address_line1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Address Line 2 --}}
                        <div class="field-group">
                            <div class="field-row">
                                <div class="field-icon field-icon-location"><i class="bi bi-building"></i></div>
                                <span class="field-label">City / District / Zip</span>
                            </div>
                            <input
                                type="text"
                                name="contact_address_line2"
                                class="admin-form-control w-100 @error('contact_address_line2') is-invalid @enderror"
                                value="{{ old('contact_address_line2', $settings['contact_address_line2']) }}"
                                placeholder="e.g. Downtown District, NY 10001"
                            >
                            @error('contact_address_line2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="field-group">
                            <div class="field-row">
                                <div class="field-icon field-icon-phone"><i class="bi bi-telephone-fill"></i></div>
                                <span class="field-label">Phone Number</span>
                            </div>
                            <input
                                type="text"
                                name="contact_phone"
                                class="admin-form-control w-100 @error('contact_phone') is-invalid @enderror"
                                value="{{ old('contact_phone', $settings['contact_phone']) }}"
                                placeholder="e.g. +1 (555) 123-4567"
                            >
                            @error('contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="field-group">
                            <div class="field-row">
                                <div class="field-icon field-icon-email"><i class="bi bi-envelope-fill"></i></div>
                                <span class="field-label">Email Address</span>
                            </div>
                            <input
                                type="email"
                                name="contact_email"
                                class="admin-form-control w-100 @error('contact_email') is-invalid @enderror"
                                value="{{ old('contact_email', $settings['contact_email']) }}"
                                placeholder="e.g. info@pitaqueenhub.com"
                            >
                            @error('contact_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Hours --}}
                        <div class="field-group">
                            <div class="field-row">
                                <div class="field-icon field-icon-clock"><i class="bi bi-clock-fill"></i></div>
                                <span class="field-label">Operating Hours</span>
                            </div>
                            <input
                                type="hidden"
                                id="contactHoursInput"
                                name="contact_hours"
                                value="{{ old('contact_hours', $settings['contact_hours']) }}"
                            >
                            <div class="hours-builder @error('contact_hours') is-invalid @enderror">
                                <div class="hours-top">
                                    <p class="hours-top-label">Quick Select</p>
                                    <div class="hours-presets" id="contactHoursPresets">
                                        <button type="button" class="hours-preset" data-preset="everyday">Everyday</button>
                                        <button type="button" class="hours-preset" data-preset="weekdays">Weekdays</button>
                                        <button type="button" class="hours-preset" data-preset="weekends">Weekends</button>
                                        <button type="button" class="hours-preset" data-preset="clear">Clear</button>
                                    </div>
                                </div>

                                <div class="hours-days" id="contactHoursDays">
                                    <button type="button" class="hours-day" data-day="Mon">Mon</button>
                                    <button type="button" class="hours-day" data-day="Tue">Tue</button>
                                    <button type="button" class="hours-day" data-day="Wed">Wed</button>
                                    <button type="button" class="hours-day" data-day="Thu">Thu</button>
                                    <button type="button" class="hours-day" data-day="Fri">Fri</button>
                                    <button type="button" class="hours-day" data-day="Sat">Sat</button>
                                    <button type="button" class="hours-day" data-day="Sun">Sun</button>
                                </div>
                                <div class="hours-time-wrap">
                                    <div>
                                        <label class="hours-time-label" for="contactHoursOpen">Open Time</label>
                                        <input type="time" id="contactHoursOpen" class="admin-form-control w-100" value="11:00">
                                    </div>
                                    <div>
                                        <label class="hours-time-label" for="contactHoursClose">Close Time</label>
                                        <input type="time" id="contactHoursClose" class="admin-form-control w-100" value="23:00">
                                    </div>
                                </div>
                                <p class="hours-help">Tip: Start with quick select, then fine-tune days and times.</p>
                                <div class="hours-preview" aria-live="polite" aria-atomic="true">
                                    <span class="hours-preview-label">Saved Hours</span>
                                    <div id="contactHoursValuePreview" class="hours-preview-value">{{ old('contact_hours', $settings['contact_hours']) }}</div>
                                </div>
                            </div>
                            @error('contact_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-3 pt-3" style="border-top: 1px solid var(--admin-border);">
                            <button type="submit" class="btn-save" id="saveBtn">
                                <i class="bi bi-check2 me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ══ Sidebar ══ --}}
        <div class="col-lg-5">
            <div class="sidebar-sticky d-flex flex-column gap-4">

                {{-- Live Preview --}}
                <div class="settings-card">
                    <div class="card-header-bar">
                        <div class="card-header-icon card-header-icon-green">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <div>
                            <p class="card-header-title">Live Preview</p>
                            <p class="card-header-sub">How visitors see your contact info</p>
                        </div>
                    </div>
                    <div class="card-body-inner">
                        <div class="preview-item">
                            <div class="preview-icon"><i class="bi bi-geo-alt"></i></div>
                            <div>
                                <div class="preview-label">Address</div>
                                <div class="preview-value" id="previewAddress1">{{ $settings['contact_address_line1'] }}</div>
                                <div class="preview-value" id="previewAddress2">{{ $settings['contact_address_line2'] }}</div>
                            </div>
                        </div>

                        <div class="preview-item">
                            <div class="preview-icon"><i class="bi bi-telephone"></i></div>
                            <div>
                                <div class="preview-label">Phone</div>
                                <div class="preview-value" id="previewPhone">{{ $settings['contact_phone'] }}</div>
                            </div>
                        </div>

                        <div class="preview-item">
                            <div class="preview-icon"><i class="bi bi-envelope"></i></div>
                            <div>
                                <div class="preview-label">Email</div>
                                <div class="preview-value" id="previewEmail">{{ $settings['contact_email'] }}</div>
                            </div>
                        </div>

                        <div class="preview-item">
                            <div class="preview-icon"><i class="bi bi-clock"></i></div>
                            <div>
                                <div class="preview-label">Hours</div>
                                <div class="preview-value" id="previewHours">{{ $settings['contact_hours'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // ── Live Preview Bindings ──
        'contact_address_line1': 'previewAddress1',
        'contact_address_line2': 'previewAddress2',
        'contact_phone': 'previewPhone',
        'contact_email': 'previewEmail'
    };

    Object.keys(bindings).forEach(function (inputName) {
        var previewId = bindings[inputName];
        var input = document.querySelector('[name="' + inputName + '"]');
        var preview = document.getElementById(previewId);

        if (input && preview) {
            input.addEventListener('input', function () {
                preview.textContent = this.value || '\u2014';
            });
        }
    });

    var dayOrder = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    var dayLookup = dayOrder.reduce(function (carry, day, index) {
        carry[day.toLowerCase()] = { day: day, index: index };

        return carry;
    }, {});
    var selectedDays = new Set();

    var contactHoursInput = document.getElementById('contactHoursInput');
    var contactHoursDays = document.getElementById('contactHoursDays');
    var contactHoursPresets = document.getElementById('contactHoursPresets');
    var contactHoursOpen = document.getElementById('contactHoursOpen');
    var contactHoursClose = document.getElementById('contactHoursClose');
    var contactHoursValuePreview = document.getElementById('contactHoursValuePreview');
    var previewHours = document.getElementById('previewHours');

    function expandDayRange(startDay, endDay) {
        var start = dayLookup[startDay.toLowerCase()] ? dayLookup[startDay.toLowerCase()].index : null;
        var end = dayLookup[endDay.toLowerCase()] ? dayLookup[endDay.toLowerCase()].index : null;

        if (start === null || end === null) {
            return [];
        }

        if (start <= end) {
            return dayOrder.slice(start, end + 1);
        }

        return dayOrder.slice(start).concat(dayOrder.slice(0, end + 1));
    }

    function normalizeDayToken(rawDay) {
        var clean = (rawDay || '').trim().slice(0, 3).toLowerCase();

        return dayLookup[clean] ? dayLookup[clean].day : null;
    }

    function parseDays(dayPart) {
        var normalizedPart = (dayPart || '').replace(/\s+/g, ' ').trim();
        if (!normalizedPart) {
            return [];
        }

        var rangeMatch = normalizedPart.match(/^([A-Za-z]{3,})\s*-\s*([A-Za-z]{3,})$/);
        if (rangeMatch) {
            var startDay = normalizeDayToken(rangeMatch[1]);
            var endDay = normalizeDayToken(rangeMatch[2]);

            if (startDay && endDay) {
                return expandDayRange(startDay, endDay);
            }
        }

        var parts = normalizedPart.split(',');
        var list = parts.map(function (part) {
            return normalizeDayToken(part);
        }).filter(Boolean);

        if (list.length > 0) {
            return dayOrder.filter(function (day) {
                return list.indexOf(day) !== -1;
            });
        }

        var single = normalizeDayToken(normalizedPart);

        return single ? [single] : [];
    }

    function parseHoursTokenToMinutes(token) {
        var normalized = (token || '').toUpperCase().replace(/\s+/g, '').trim();
        var match = normalized.match(/^(\d{1,2})(?::(\d{2}))?(AM|PM)$/);

        if (!match) {
            return null;
        }

        var hour = Number.parseInt(match[1], 10);
        var minute = Number.parseInt(match[2] || '0', 10);

        if (Number.isNaN(hour) || Number.isNaN(minute) || hour < 1 || hour > 12 || minute < 0 || minute > 59) {
            return null;
        }

        var hour24 = hour % 12;
        if (match[3] === 'PM') {
            hour24 += 12;
        }

        return (hour24 * 60) + minute;
    }

    function parseTimeValueToMinutes(timeValue) {
        var parts = (timeValue || '').split(':');
        if (parts.length !== 2) {
            return null;
        }

        var hour = Number.parseInt(parts[0], 10);
        var minute = Number.parseInt(parts[1], 10);

        if (Number.isNaN(hour) || Number.isNaN(minute) || hour < 0 || hour > 23 || minute < 0 || minute > 59) {
            return null;
        }

        return (hour * 60) + minute;
    }

    function minutesToTimeValue(totalMinutes) {
        if (totalMinutes === null || totalMinutes === undefined) {
            return '';
        }

        var hour = Math.floor(totalMinutes / 60);
        var minute = totalMinutes % 60;

        return String(hour).padStart(2, '0') + ':' + String(minute).padStart(2, '0');
    }

    function minutesToDisplay(totalMinutes) {
        if (totalMinutes === null || totalMinutes === undefined) {
            return '';
        }

        var hour24 = Math.floor(totalMinutes / 60);
        var minute = totalMinutes % 60;
        var period = hour24 >= 12 ? 'PM' : 'AM';
        var hour12 = (hour24 % 12) || 12;

        if (minute === 0) {
            return String(hour12) + period;
        }

        return String(hour12) + ':' + String(minute).padStart(2, '0') + period;
    }

    function formatSelectedDays(days) {
        if (days.length === 0) {
            return '';
        }

        if (days.length === dayOrder.length) {
            return 'Mon-Sun';
        }

        var isContiguous = true;
        for (var i = 1; i < days.length; i += 1) {
            var previous = dayOrder.indexOf(days[i - 1]);
            var current = dayOrder.indexOf(days[i]);

            if (current !== previous + 1) {
                isContiguous = false;
                break;
            }
        }

        if (isContiguous && days.length >= 2) {
            return days[0] + '-' + days[days.length - 1];
        }

        return days.join(', ');
    }

    function renderDaySelection() {
        if (!contactHoursDays) {
            return;
        }

        contactHoursDays.querySelectorAll('[data-day]').forEach(function (button) {
            var day = button.getAttribute('data-day') || '';
            var active = selectedDays.has(day);

            button.classList.toggle('active', active);
            button.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
    }

    function syncHoursValue() {
        if (!contactHoursInput || !contactHoursOpen || !contactHoursClose) {
            return;
        }

        var days = dayOrder.filter(function (day) {
            return selectedDays.has(day);
        });
        var openMinutes = parseTimeValueToMinutes(contactHoursOpen.value);
        var closeMinutes = parseTimeValueToMinutes(contactHoursClose.value);

        if (days.length === 0 || openMinutes === null || closeMinutes === null) {
            contactHoursInput.value = '';

            if (contactHoursValuePreview) {
                contactHoursValuePreview.textContent = 'Select days and set open/close time.';
            }
            if (previewHours) {
                previewHours.textContent = '--';
            }

            return;
        }

        var nextValue = formatSelectedDays(days) + ': ' + minutesToDisplay(openMinutes) + ' - ' + minutesToDisplay(closeMinutes);
        contactHoursInput.value = nextValue;

        if (contactHoursValuePreview) {
            contactHoursValuePreview.textContent = nextValue;
        }
        if (previewHours) {
            previewHours.textContent = nextValue;
        }
    }

    function applyHoursValue(rawHours) {
        var fallbackDays = dayOrder;
        var selected = fallbackDays.slice();
        var openMinutes = parseHoursTokenToMinutes('11AM');
        var closeMinutes = parseHoursTokenToMinutes('11PM');
        var normalizedHours = (rawHours || '').trim();
        var partsMatch = normalizedHours.match(/^(.*?):\s*(.*?)\s*-\s*(.*?)$/);

        if (partsMatch) {
            var parsedDays = parseDays(partsMatch[1]);
            var parsedOpen = parseHoursTokenToMinutes(partsMatch[2]);
            var parsedClose = parseHoursTokenToMinutes(partsMatch[3]);

            if (parsedDays.length > 0) {
                selected = parsedDays;
            }
            if (parsedOpen !== null) {
                openMinutes = parsedOpen;
            }
            if (parsedClose !== null) {
                closeMinutes = parsedClose;
            }
        }

        selectedDays.clear();
        selected.forEach(function (day) {
            selectedDays.add(day);
        });

        if (contactHoursOpen) {
            contactHoursOpen.value = minutesToTimeValue(openMinutes);
        }
        if (contactHoursClose) {
            contactHoursClose.value = minutesToTimeValue(closeMinutes);
        }

        renderDaySelection();
        syncHoursValue();
    }

    function applyDayPreset(preset) {
        selectedDays.clear();

        if (preset === 'everyday') {
            dayOrder.forEach(function (day) {
                selectedDays.add(day);
            });
        }

        if (preset === 'weekdays') {
            ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'].forEach(function (day) {
                selectedDays.add(day);
            });
        }

        if (preset === 'weekends') {
            ['Sat', 'Sun'].forEach(function (day) {
                selectedDays.add(day);
            });
        }

        renderDaySelection();
        syncHoursValue();
    }

    if (contactHoursDays && contactHoursPresets && contactHoursOpen && contactHoursClose && contactHoursInput) {
        contactHoursDays.addEventListener('click', function (event) {
            var target = event.target;
            if (!(target instanceof HTMLElement)) {
                return;
            }

            var dayButton = target.closest('[data-day]');
            if (!(dayButton instanceof HTMLElement)) {
                return;
            }

            var day = dayButton.getAttribute('data-day');
            if (!day) {
                return;
            }

            if (selectedDays.has(day)) {
                selectedDays.delete(day);
            } else {
                selectedDays.add(day);
            }

            renderDaySelection();
            syncHoursValue();
        });

        contactHoursOpen.addEventListener('change', syncHoursValue);
        contactHoursClose.addEventListener('change', syncHoursValue);

        contactHoursPresets.addEventListener('click', function (event) {
            var target = event.target;
            if (!(target instanceof HTMLElement)) {
                return;
            }

            var presetButton = target.closest('[data-preset]');
            if (!(presetButton instanceof HTMLElement)) {
                return;
            }

            var preset = presetButton.getAttribute('data-preset') || '';
            applyDayPreset(preset);
        });

        applyHoursValue(contactHoursInput.value);
    }
</script>
@endpush
