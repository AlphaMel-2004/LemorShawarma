@php
    $isModal = $isModal ?? false;
    $formId = $formId ?? 'location-form';
    $locationName = old('name', $location?->name ?? '');
    $locationAddress = old('address', $location?->address ?? '');
    $locationPhone = old('phone', $location?->phone ?? '');
    $locationHours = old('hours', $location?->hours ?? 'Mon-Sun: 10AM - 10PM');
    $locationLatitude = old('latitude', $location?->latitude ?? 14.5995);
    $locationLongitude = old('longitude', $location?->longitude ?? 120.9842);
    $locationIsActive = (int) old('is_active', $location?->is_active ?? 1);
@endphp

@push('styles')
@once
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
@endonce
<style>
    #locationMap-{{ $formId }} {
        height: 360px;
        border: 1px solid var(--admin-border);
        border-radius: 10px;
        margin-top: 0.5rem;
    }

    #locationMap-{{ $formId }} .leaflet-control-attribution {
        font-size: 10px;
        line-height: 1.2;
        padding: 2px 6px;
        opacity: 0.6;
        background: rgba(255, 255, 255, 0.72);
    }

    #locationMap-{{ $formId }} .leaflet-control-attribution a {
        color: #5b6b7c;
    }

    .location-hint {
        font-size: 0.8rem;
        color: var(--admin-text-muted);
        margin-top: 0.35rem;
    }

    .selected-address-preview {
        margin-top: 0.65rem;
        padding: 0.6rem 0.75rem;
        border-radius: 10px;
        border: 1px solid var(--admin-border);
        background: rgba(18, 18, 18, 0.94);
    }

    .selected-address-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        color: var(--admin-text-muted);
        margin-bottom: 0.2rem;
        text-transform: uppercase;
    }

    .selected-address-value {
        font-size: 0.9rem;
        color: var(--admin-text);
        line-height: 1.45;
        word-break: break-word;
    }

    #locationImageInput-{{ $formId }} {
        padding: 0.4rem;
    }

    #locationImageInput-{{ $formId }}::file-selector-button {
        background: rgba(212, 175, 55, 0.16);
        border: 1px solid rgba(212, 175, 55, 0.34);
        color: var(--admin-primary);
        border-radius: 8px;
        padding: 0.45rem 0.8rem;
        margin-right: 0.7rem;
        font-weight: 700;
        cursor: pointer;
    }

    #locationImageInput-{{ $formId }}::file-selector-button:hover {
        background: rgba(212, 175, 55, 0.24);
    }

    .location-hours-builder {
        border: 1px solid var(--admin-border);
        border-radius: 10px;
        background: rgba(18, 18, 18, 0.92);
        padding: 0.95rem;
    }

    .location-hours-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 0.6rem;
    }

    .location-hours-top-label {
        margin: 0;
        font-size: 0.76rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--admin-text-muted);
        font-weight: 700;
    }

    .location-hours-presets {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 0.35rem;
    }

    .location-hours-preset {
        border: 1px solid var(--admin-border);
        background: rgba(255, 255, 255, 0.02);
        color: var(--admin-text-muted);
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.27rem 0.62rem;
        transition: all 0.16s ease;
    }

    .location-hours-preset:hover {
        color: #ffe79a;
        border-color: rgba(212, 175, 55, 0.58);
        background: rgba(212, 175, 55, 0.15);
    }

    .location-hours-days {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        gap: 0.4rem;
    }

    .location-hours-day {
        border: 1px solid var(--admin-border);
        background: transparent;
        color: var(--admin-text-muted);
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 700;
        padding: 0.4rem 0.25rem;
        transition: all 0.18s ease;
    }

    .location-hours-day:hover {
        border-color: rgba(212, 175, 55, 0.45);
        color: var(--admin-text);
    }

    .location-hours-day.active {
        border-color: rgba(212, 175, 55, 0.65);
        background: rgba(212, 175, 55, 0.18);
        color: #ffe79a;
    }

    .location-hours-time-wrap {
        margin-top: 0.7rem;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.65rem;
    }

    .location-hours-time-label {
        display: block;
        font-size: 0.72rem;
        color: var(--admin-text-muted);
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        font-weight: 700;
    }

    .location-hours-time-input-wrap {
        position: relative;
    }

    .location-hours-time-trigger {
        position: absolute;
        top: 50%;
        right: 0.55rem;
        transform: translateY(-50%);
        width: 2rem;
        height: 2rem;
        border: 1px solid rgba(212, 175, 55, 0.24);
        border-radius: 999px;
        background: rgba(212, 175, 55, 0.08);
        color: #f4d989;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.16s ease, border-color 0.16s ease, color 0.16s ease;
    }

    .location-hours-time-trigger:hover {
        background: rgba(212, 175, 55, 0.16);
        border-color: rgba(212, 175, 55, 0.42);
        color: #ffe7a6;
    }

    .location-hours-preview {
        margin-top: 0.65rem;
    }

    #locationHoursOpen-{{ $formId }},
    #locationHoursClose-{{ $formId }} {
        color: var(--admin-text);
        color-scheme: dark;
        padding-right: 3.2rem;
    }

    #locationHoursOpen-{{ $formId }}::-webkit-calendar-picker-indicator,
    #locationHoursClose-{{ $formId }}::-webkit-calendar-picker-indicator {
        opacity: 0 !important;
        width: 1.2rem;
        height: 1.2rem;
        cursor: pointer;
    }

    #locationHoursOpen-{{ $formId }}::-webkit-datetime-edit,
    #locationHoursClose-{{ $formId }}::-webkit-datetime-edit {
        color: var(--admin-text);
    }

    @media (max-width: 768px) {
        .location-hours-days {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .location-hours-time-wrap {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

<div class="row g-3">
    <div class="col-md-6">
        <label class="admin-form-label">Location Name <span class="text-danger">*</span></label>
        <input type="text" id="locationName-{{ $formId }}" name="name" class="admin-form-control w-100 @error('name') is-invalid @enderror" value="{{ $locationName }}" required>
        @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="admin-form-label">Phone <span class="text-danger">*</span></label>
        <input type="text" id="locationPhone-{{ $formId }}" name="phone" class="admin-form-control w-100 @error('phone') is-invalid @enderror" value="{{ $locationPhone }}" required>
        @error('phone')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="admin-form-label">Address <span class="text-danger">*</span></label>
        <input type="text" id="locationAddress-{{ $formId }}" name="address" class="admin-form-control w-100 @error('address') is-invalid @enderror" value="{{ $locationAddress }}" required>
        @error('address')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="admin-form-label">Operating Hours <span class="text-danger">*</span></label>
        <input type="hidden" id="locationHours-{{ $formId }}" name="hours" value="{{ $locationHours }}" required>
        <div class="location-hours-builder @error('hours') is-invalid @enderror">
            <div class="location-hours-top">
                <p class="location-hours-top-label">Quick Select</p>
                <div class="location-hours-presets" id="locationHoursPresets-{{ $formId }}">
                    <button type="button" class="location-hours-preset" data-preset="everyday">Everyday</button>
                    <button type="button" class="location-hours-preset" data-preset="weekdays">Weekdays</button>
                    <button type="button" class="location-hours-preset" data-preset="weekends">Weekends</button>
                    <button type="button" class="location-hours-preset" data-preset="clear">Clear</button>
                </div>
            </div>

            <div class="location-hours-days" id="locationHoursDays-{{ $formId }}">
                <button type="button" class="location-hours-day" data-day="Mon">Mon</button>
                <button type="button" class="location-hours-day" data-day="Tue">Tue</button>
                <button type="button" class="location-hours-day" data-day="Wed">Wed</button>
                <button type="button" class="location-hours-day" data-day="Thu">Thu</button>
                <button type="button" class="location-hours-day" data-day="Fri">Fri</button>
                <button type="button" class="location-hours-day" data-day="Sat">Sat</button>
                <button type="button" class="location-hours-day" data-day="Sun">Sun</button>
            </div>

            <div class="location-hours-time-wrap">
                <div>
                    <label class="location-hours-time-label" for="locationHoursOpen-{{ $formId }}">Open Time</label>
                    <div class="location-hours-time-input-wrap">
                        <input type="time" id="locationHoursOpen-{{ $formId }}" class="admin-form-control w-100" value="10:00">
                        <button type="button" class="location-hours-time-trigger" data-time-picker-trigger="locationHoursOpen-{{ $formId }}" aria-label="Open time picker">
                            <i class="bi bi-clock"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="location-hours-time-label" for="locationHoursClose-{{ $formId }}">Close Time</label>
                    <div class="location-hours-time-input-wrap">
                        <input type="time" id="locationHoursClose-{{ $formId }}" class="admin-form-control w-100" value="22:00">
                        <button type="button" class="location-hours-time-trigger" data-time-picker-trigger="locationHoursClose-{{ $formId }}" aria-label="Close time picker">
                            <i class="bi bi-clock"></i>
                        </button>
                    </div>
                </div>
            </div>

            <p class="location-hint mb-0">Tip: Use quick select first, then adjust individual days and times.</p>

            <div class="selected-address-preview location-hours-preview" aria-live="polite" aria-atomic="true">
                <span class="selected-address-label">Saved Hours</span>
                <div id="locationHoursPreview-{{ $formId }}" class="selected-address-value">{{ $locationHours }}</div>
            </div>
        </div>
        @error('hours')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="admin-form-label">Status <span class="text-danger">*</span></label>
        <select id="locationStatus-{{ $formId }}" name="is_active" class="admin-form-select w-100 @error('is_active') is-invalid @enderror" required>
            <option value="1" @selected($locationIsActive === 1)>Active</option>
            <option value="0" @selected($locationIsActive === 0)>Inactive</option>
        </select>
        @error('is_active')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="admin-form-label">Location Image</label>
        <input type="file" id="locationImageInput-{{ $formId }}" name="image" class="admin-form-control w-100 @error('image') is-invalid @enderror" accept="image/*">
        @error('image')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        <div class="mt-2" id="locationImagePreview-{{ $formId }}">
            @if($location?->image)
                <img src="{{ $location->image_url }}" alt="Current location image" style="width: 140px; height: 90px; object-fit: cover; border-radius: 8px; border: 1px solid var(--admin-border);">
            @endif
        </div>
    </div>

    <div class="col-12">
        <label class="admin-form-label">Search Location</label>
        <div class="d-flex gap-2">
            <input type="text" id="locationSearch-{{ $formId }}" class="admin-form-control w-100" placeholder="Search address or place">
            <button type="button" class="btn-admin-primary" id="locationSearchBtn-{{ $formId }}">Search</button>
        </div>
        <p class="location-hint">Search a place or click directly on the map. Coordinates and address update automatically.</p>
        <div class="selected-address-preview" aria-live="polite" aria-atomic="true">
            <span class="selected-address-label">Pinned Address</span>
            <div id="selectedAddressPreview-{{ $formId }}" class="selected-address-value">{{ $locationAddress ?: 'Select a point on the map to detect the full address.' }}</div>
        </div>
    </div>

    <input type="hidden" id="latitudeInput-{{ $formId }}" name="latitude" value="{{ $locationLatitude }}">
    <input type="hidden" id="longitudeInput-{{ $formId }}" name="longitude" value="{{ $locationLongitude }}">

    @error('latitude')
        <div class="col-12">
            <div class="invalid-feedback d-block">{{ $message }}</div>
        </div>
    @enderror

    @error('longitude')
        <div class="col-12">
            <div class="invalid-feedback d-block">{{ $message }}</div>
        </div>
    @enderror

    <div class="col-12">
        <div id="locationMap-{{ $formId }}"></div>
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    @if($isModal)
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
    @else
        <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary">Cancel</a>
    @endif
    <button type="submit" class="btn-admin-primary">
        <i class="bi bi-check2-circle me-1"></i>
        {{ $location ? 'Update Location' : 'Save Location' }}
    </button>
</div>

@push('scripts')
@once
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
@endonce
<script>
    (function () {
        const formId = @json($formId);
        const mapElementId = `locationMap-${formId}`;

        const latitudeInput = document.getElementById(`latitudeInput-${formId}`);
        const longitudeInput = document.getElementById(`longitudeInput-${formId}`);
        const nameInput = document.getElementById(`locationName-${formId}`);
        const addressInput = document.getElementById(`locationAddress-${formId}`);
        const phoneInput = document.getElementById(`locationPhone-${formId}`);
        const hoursInput = document.getElementById(`locationHours-${formId}`);
        const hoursPreview = document.getElementById(`locationHoursPreview-${formId}`);
        const hoursDaysContainer = document.getElementById(`locationHoursDays-${formId}`);
        const hoursPresetsContainer = document.getElementById(`locationHoursPresets-${formId}`);
        const hoursOpenInput = document.getElementById(`locationHoursOpen-${formId}`);
        const hoursCloseInput = document.getElementById(`locationHoursClose-${formId}`);
        const statusInput = document.getElementById(`locationStatus-${formId}`);
        const imageInput = document.getElementById(`locationImageInput-${formId}`);
        const imagePreview = document.getElementById(`locationImagePreview-${formId}`);
        const searchInput = document.getElementById(`locationSearch-${formId}`);
        const searchBtn = document.getElementById(`locationSearchBtn-${formId}`);
        const selectedAddressPreview = document.getElementById(`selectedAddressPreview-${formId}`);

        const dayOrder = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const dayLookup = dayOrder.reduce(function (carry, day, index) {
            carry[day.toLowerCase()] = { day, index };

            return carry;
        }, {});
        const selectedDays = new Set();

        if (!latitudeInput || !longitudeInput || !addressInput || !searchInput || !searchBtn || !nameInput || !phoneInput || !hoursInput || !hoursPreview || !hoursDaysContainer || !hoursPresetsContainer || !hoursOpenInput || !hoursCloseInput || !statusInput || !imageInput || !imagePreview || !selectedAddressPreview) {
            return;
        }

        const lat = parseFloat(latitudeInput.value) || 14.5995;
        const lng = parseFloat(longitudeInput.value) || 120.9842;

        const map = L.map(mapElementId).setView([lat, lng], 13);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            subdomains: 'abcd',
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO'
        }).addTo(map);

        let marker = L.marker([lat, lng], { draggable: true }).addTo(map);

        const modalElement = document.getElementById(mapElementId)?.closest('.modal');
        if (modalElement) {
            modalElement.addEventListener('shown.bs.modal', function () {
                setTimeout(function () {
                    map.invalidateSize();
                    map.setView(marker.getLatLng(), 15);
                }, 100);
            });
        }

        function setCoordinates(newLat, newLng) {
            latitudeInput.value = Number(newLat).toFixed(7);
            longitudeInput.value = Number(newLng).toFixed(7);
        }

        function setImagePreview(imageUrl) {
            imagePreview.innerHTML = '';

            if (!imageUrl) {
                return;
            }

            imagePreview.innerHTML = `<img src="${imageUrl}" alt="Current location image" style="width: 140px; height: 90px; object-fit: cover; border-radius: 8px; border: 1px solid var(--admin-border);">`;
        }

        function setSelectedAddress(address) {
            const value = (address || '').trim();
            selectedAddressPreview.textContent = value || 'Select a point on the map to detect the full address.';
        }

        function expandDayRange(startDay, endDay) {
            const start = dayLookup[startDay.toLowerCase()]?.index;
            const end = dayLookup[endDay.toLowerCase()]?.index;

            if (start === undefined || end === undefined) {
                return [];
            }

            if (start <= end) {
                return dayOrder.slice(start, end + 1);
            }

            return dayOrder.slice(start).concat(dayOrder.slice(0, end + 1));
        }

        function parseHoursTokenToMinutes(token) {
            const normalized = (token || '').toUpperCase().replace(/\s+/g, '').trim();
            const match = normalized.match(/^(\d{1,2})(?::(\d{2}))?(AM|PM)$/);

            if (!match) {
                return null;
            }

            const hour = Number.parseInt(match[1], 10);
            const minute = Number.parseInt(match[2] || '0', 10);

            if (Number.isNaN(hour) || Number.isNaN(minute) || hour < 1 || hour > 12 || minute < 0 || minute > 59) {
                return null;
            }

            let hour24 = hour % 12;
            if (match[3] === 'PM') {
                hour24 += 12;
            }

            return (hour24 * 60) + minute;
        }

        function parseTimeValueToMinutes(timeValue) {
            const parts = (timeValue || '').split(':');
            if (parts.length !== 2) {
                return null;
            }

            const hour = Number.parseInt(parts[0], 10);
            const minute = Number.parseInt(parts[1], 10);

            if (Number.isNaN(hour) || Number.isNaN(minute) || hour < 0 || hour > 23 || minute < 0 || minute > 59) {
                return null;
            }

            return (hour * 60) + minute;
        }

        function minutesToTimeValue(totalMinutes) {
            if (totalMinutes === null || totalMinutes === undefined) {
                return '';
            }

            const hour = Math.floor(totalMinutes / 60);
            const minute = totalMinutes % 60;

            return `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
        }

        function minutesToDisplay(totalMinutes) {
            if (totalMinutes === null || totalMinutes === undefined) {
                return '';
            }

            const hour24 = Math.floor(totalMinutes / 60);
            const minute = totalMinutes % 60;
            const period = hour24 >= 12 ? 'PM' : 'AM';
            const hour12 = (hour24 % 12) || 12;

            if (minute === 0) {
                return `${hour12}${period}`;
            }

            return `${hour12}:${String(minute).padStart(2, '0')}${period}`;
        }

        function normalizeDayToken(rawDay) {
            const clean = (rawDay || '').trim().slice(0, 3).toLowerCase();

            return dayLookup[clean]?.day || null;
        }

        function parseDays(dayPart) {
            const normalizedPart = (dayPart || '').replace(/\s+/g, ' ').trim();
            if (!normalizedPart) {
                return [];
            }

            const rangeMatch = normalizedPart.match(/^([A-Za-z]{3,})\s*-\s*([A-Za-z]{3,})$/);
            if (rangeMatch) {
                const startDay = normalizeDayToken(rangeMatch[1]);
                const endDay = normalizeDayToken(rangeMatch[2]);

                if (startDay && endDay) {
                    return expandDayRange(startDay, endDay);
                }
            }

            const list = normalizedPart
                .split(',')
                .map(function (part) {
                    return normalizeDayToken(part);
                })
                .filter(Boolean);

            if (list.length > 0) {
                return dayOrder.filter(function (day) {
                    return list.includes(day);
                });
            }

            const singleDay = normalizeDayToken(normalizedPart);

            return singleDay ? [singleDay] : [];
        }

        function formatSelectedDays(days) {
            if (days.length === 0) {
                return '';
            }

            if (days.length === dayOrder.length) {
                return 'Mon-Sun';
            }

            let isContiguous = true;
            for (let index = 1; index < days.length; index += 1) {
                const previous = dayOrder.indexOf(days[index - 1]);
                const current = dayOrder.indexOf(days[index]);

                if (current !== previous + 1) {
                    isContiguous = false;
                    break;
                }
            }

            if (isContiguous && days.length >= 2) {
                return `${days[0]}-${days[days.length - 1]}`;
            }

            return days.join(', ');
        }

        function openTimePicker(input) {
            if (!(input instanceof HTMLInputElement)) {
                return;
            }

            input.focus({ preventScroll: true });

            if (typeof input.showPicker === 'function') {
                try {
                    input.showPicker();
                } catch (error) {
                    // Some browsers only allow the native picker during direct user gestures.
                }
            }
        }

        function renderDaySelection() {
            hoursDaysContainer.querySelectorAll('[data-day]').forEach(function (button) {
                const day = button.getAttribute('data-day') || '';
                button.classList.toggle('active', selectedDays.has(day));
                button.setAttribute('aria-pressed', selectedDays.has(day) ? 'true' : 'false');
            });
        }

        function syncHoursValue() {
            const days = dayOrder.filter(function (day) {
                return selectedDays.has(day);
            });
            const openMinutes = parseTimeValueToMinutes(hoursOpenInput.value);
            const closeMinutes = parseTimeValueToMinutes(hoursCloseInput.value);

            if (days.length === 0 || openMinutes === null || closeMinutes === null) {
                hoursInput.value = '';
                hoursPreview.textContent = 'Select one or more days, then set open and close times.';
                return;
            }

            const nextValue = `${formatSelectedDays(days)}: ${minutesToDisplay(openMinutes)} - ${minutesToDisplay(closeMinutes)}`;
            hoursInput.value = nextValue;
            hoursPreview.textContent = nextValue;
        }

        function applyHoursValue(rawHours) {
            const fallbackDays = dayOrder;
            let selected = [...fallbackDays];
            let openMinutes = parseHoursTokenToMinutes('10AM');
            let closeMinutes = parseHoursTokenToMinutes('10PM');

            const normalizedHours = (rawHours || '').trim();
            const partsMatch = normalizedHours.match(/^(.*?):\s*(.*?)\s*-\s*(.*?)$/);

            if (partsMatch) {
                const parsedDays = parseDays(partsMatch[1]);
                const parsedOpen = parseHoursTokenToMinutes(partsMatch[2]);
                const parsedClose = parseHoursTokenToMinutes(partsMatch[3]);

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

            hoursOpenInput.value = minutesToTimeValue(openMinutes);
            hoursCloseInput.value = minutesToTimeValue(closeMinutes);

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

        hoursDaysContainer.addEventListener('click', function (event) {
            const target = event.target;
            if (!(target instanceof HTMLElement)) {
                return;
            }

            const dayButton = target.closest('[data-day]');
            if (!(dayButton instanceof HTMLElement)) {
                return;
            }

            const day = dayButton.getAttribute('data-day');
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

        hoursOpenInput.addEventListener('change', syncHoursValue);
        hoursCloseInput.addEventListener('change', syncHoursValue);
        hoursOpenInput.addEventListener('click', function () {
            openTimePicker(hoursOpenInput);
        });
        hoursCloseInput.addEventListener('click', function () {
            openTimePicker(hoursCloseInput);
        });

        document.querySelectorAll(`[data-time-picker-trigger$="${formId}"]`).forEach(function (button) {
            button.addEventListener('click', function () {
                const targetId = button.getAttribute('data-time-picker-trigger');
                const input = targetId ? document.getElementById(targetId) : null;

                openTimePicker(input);
            });
        });

        hoursPresetsContainer.addEventListener('click', function (event) {
            const target = event.target;
            if (!(target instanceof HTMLElement)) {
                return;
            }

            const presetButton = target.closest('[data-preset]');
            if (!(presetButton instanceof HTMLElement)) {
                return;
            }

            const preset = presetButton.getAttribute('data-preset') || '';
            applyDayPreset(preset);
        });

        async function reverseGeocode(newLat, newLng) {
            try {
                const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${encodeURIComponent(newLat)}&lon=${encodeURIComponent(newLng)}`;
                const response = await fetch(url, { headers: { 'Accept': 'application/json' } });

                if (!response.ok) {
                    return;
                }

                const data = await response.json();
                if (data && data.display_name) {
                    addressInput.value = data.display_name;
                    setSelectedAddress(data.display_name);
                }
            } catch (error) {
                console.error('Reverse geocoding failed:', error);
            }
        }

        function moveMarker(newLat, newLng, updateAddress = true) {
            marker.setLatLng([newLat, newLng]);
            map.setView([newLat, newLng], 15);
            setCoordinates(newLat, newLng);

            if (updateAddress) {
                reverseGeocode(newLat, newLng);
            }
        }

        imageInput.addEventListener('change', function () {
            const [file] = this.files;
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (event) {
                setImagePreview(event.target?.result || '');
            };
            reader.readAsDataURL(file);
        });

        window.locationFormControllers = window.locationFormControllers || {};
        window.locationFormControllers[formId] = {
            setFormData(data) {
                nameInput.value = data.name || '';
                addressInput.value = data.address || '';
                phoneInput.value = data.phone || '';
                hoursInput.value = data.hours || '';
                applyHoursValue(data.hours || '');
                statusInput.value = String(data.isActive ?? '1');
                setSelectedAddress(data.address || '');

                const nextLat = parseFloat(data.latitude);
                const nextLng = parseFloat(data.longitude);

                if (!Number.isNaN(nextLat) && !Number.isNaN(nextLng)) {
                    moveMarker(nextLat, nextLng, false);
                }

                imageInput.value = '';
                setImagePreview(data.imageUrl || '');
            },
        };

        map.on('click', function (event) {
            moveMarker(event.latlng.lat, event.latlng.lng, true);
        });

        marker.on('dragend', function (event) {
            const position = event.target.getLatLng();
            moveMarker(position.lat, position.lng, true);
        });

        async function searchLocation() {
            const query = (searchInput.value || '').trim();
            if (!query) {
                return;
            }

            try {
                const url = `https://nominatim.openstreetmap.org/search?format=jsonv2&limit=1&q=${encodeURIComponent(query)}`;
                const response = await fetch(url, { headers: { 'Accept': 'application/json' } });

                if (!response.ok) {
                    return;
                }

                const data = await response.json();
                if (!Array.isArray(data) || data.length === 0) {
                    alert('No location found. Try a more specific search.');
                    return;
                }

                const result = data[0];
                const resultLat = parseFloat(result.lat);
                const resultLng = parseFloat(result.lon);

                moveMarker(resultLat, resultLng, false);
                if (result.display_name) {
                    addressInput.value = result.display_name;
                    setSelectedAddress(result.display_name);
                }
            } catch (error) {
                console.error('Search location failed:', error);
                alert('Failed to search location. Please try again.');
            }
        }

        searchBtn.addEventListener('click', searchLocation);
        searchInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                searchLocation();
            }
        });

        addressInput.addEventListener('input', function () {
            setSelectedAddress(addressInput.value);
        });

        setSelectedAddress(addressInput.value);
        applyHoursValue(hoursInput.value);
    })();
</script>
@endpush
