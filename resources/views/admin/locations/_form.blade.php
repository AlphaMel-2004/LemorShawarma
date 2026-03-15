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
</style>
@endpush

<div class="row g-3">
    <div class="col-md-6">
        <label class="admin-form-label">Location Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="admin-form-control w-100 @error('name') is-invalid @enderror" value="{{ $locationName }}" required>
        @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="admin-form-label">Phone <span class="text-danger">*</span></label>
        <input type="text" name="phone" class="admin-form-control w-100 @error('phone') is-invalid @enderror" value="{{ $locationPhone }}" required>
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

    <div class="col-md-6">
        <label class="admin-form-label">Operating Hours <span class="text-danger">*</span></label>
        <input type="text" name="hours" class="admin-form-control w-100 @error('hours') is-invalid @enderror" value="{{ $locationHours }}" required>
        @error('hours')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="admin-form-label">Status <span class="text-danger">*</span></label>
        <select name="is_active" class="admin-form-select w-100 @error('is_active') is-invalid @enderror" required>
            <option value="1" @selected($locationIsActive === 1)>Active</option>
            <option value="0" @selected($locationIsActive === 0)>Inactive</option>
        </select>
        @error('is_active')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="admin-form-label">Location Image</label>
        <input type="file" name="image" class="admin-form-control w-100 @error('image') is-invalid @enderror" accept="image/*">
        @error('image')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror

        @if($location?->image)
            <div class="mt-2">
                <img src="{{ Storage::url($location->image) }}" alt="Current location image" style="width: 140px; height: 90px; object-fit: cover; border-radius: 8px; border: 1px solid var(--admin-border);">
            </div>
        @endif
    </div>

    <div class="col-12">
        <label class="admin-form-label">Search Location</label>
        <div class="d-flex gap-2">
            <input type="text" id="locationSearch-{{ $formId }}" class="admin-form-control w-100" placeholder="Search address or place">
            <button type="button" class="btn-admin-primary" id="locationSearchBtn-{{ $formId }}">Search</button>
        </div>
        <p class="location-hint">Search a place or click directly on the map. Coordinates and address update automatically.</p>
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
        const addressInput = document.getElementById(`locationAddress-${formId}`);
        const searchInput = document.getElementById(`locationSearch-${formId}`);
        const searchBtn = document.getElementById(`locationSearchBtn-${formId}`);

        if (!latitudeInput || !longitudeInput || !addressInput || !searchInput || !searchBtn) {
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
    })();
</script>
@endpush
