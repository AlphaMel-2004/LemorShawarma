@extends('layouts.admin')

@section('title', 'Manage Branch Location')
@section('page-title', 'Manage Branch Location')

@push('styles')
<style>
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
    .field-icon-phone { background: rgba(22, 219, 170, 0.10); color: var(--admin-success); }
    .field-icon-clock { background: rgba(245, 158, 11, 0.10); color: #f59e0b; }
    .field-icon-link { background: rgba(124, 58, 237, 0.10); color: #7c3aed; }
    .field-icon-image { background: rgba(254, 92, 115, 0.10); color: var(--admin-danger); }

    .field-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--admin-text);
    }

    .preview-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 1rem;
        border: 1px solid var(--admin-border);
    }

    .preview-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.65rem 0;
        border-bottom: 1px solid var(--admin-border);
    }

    .preview-item:last-child {
        border-bottom: none;
    }

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
        word-break: break-word;
    }

    .preview-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .btn-save {
        background: var(--admin-primary);
        color: #fff;
        border: none;
        padding: 0.65rem 1.75rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-save:hover {
        background: var(--admin-primary-hover);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(57, 106, 255, 0.3);
    }

    .btn-action-link {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.55rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        border: 1px solid var(--admin-border);
        color: var(--admin-text);
        font-size: 0.82rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-action-link:hover {
        border-color: var(--admin-primary);
        color: var(--admin-primary);
        background: rgba(57, 106, 255, 0.05);
    }

    .success-alert {
        background: rgba(22, 219, 170, 0.1);
        border: 1px solid rgba(22, 219, 170, 0.3);
        color: #0d7a5f;
        border-radius: 10px;
        padding: 0.85rem 1.25rem;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    @media (min-width: 992px) {
        .sidebar-sticky {
            position: sticky;
            top: 100px;
        }
    }
</style>
@endpush

@section('content')
    @if (session('success'))
        <div class="success-alert mb-4">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="settings-card">
                <div class="card-header-bar">
                    <div class="card-header-icon card-header-icon-blue">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <p class="card-header-title">Branch Location Details</p>
                        <p class="card-header-sub">Update the branch details shown in the homepage location section</p>
                    </div>
                </div>

                <div class="card-body-inner">
                    <form method="POST" action="{{ route('admin.branch-locations.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="field-group">
                            <div class="field-row">
                                <div class="field-icon field-icon-location"><i class="bi bi-shop"></i></div>
                                <span class="field-label">Branch Name</span>
                            </div>
                            <input
                                type="text"
                                name="branch_location_name"
                                class="admin-form-control w-100 @error('branch_location_name') is-invalid @enderror"
                                value="{{ old('branch_location_name', $settings['branch_location_name']) }}"
                                placeholder="e.g. Downtown Flagship"
                            >
                            @error('branch_location_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <div class="field-row">
                                <div class="field-icon field-icon-location"><i class="bi bi-geo-alt-fill"></i></div>
                                <span class="field-label">Branch Address</span>
                            </div>
                            <input
                                type="text"
                                name="branch_location_address"
                                class="admin-form-control w-100 @error('branch_location_address') is-invalid @enderror"
                                value="{{ old('branch_location_address', $settings['branch_location_address']) }}"
                                placeholder="e.g. 123 Golden Avenue, Downtown District"
                            >
                            @error('branch_location_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <div class="field-row">
                                <div class="field-icon field-icon-phone"><i class="bi bi-telephone-fill"></i></div>
                                <span class="field-label">Branch Phone</span>
                            </div>
                            <input
                                type="text"
                                name="branch_location_phone"
                                class="admin-form-control w-100 @error('branch_location_phone') is-invalid @enderror"
                                value="{{ old('branch_location_phone', $settings['branch_location_phone']) }}"
                                placeholder="e.g. +1 (555) 123-4567"
                            >
                            @error('branch_location_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <div class="field-row">
                                <div class="field-icon field-icon-clock"><i class="bi bi-clock-fill"></i></div>
                                <span class="field-label">Operating Hours</span>
                            </div>
                            <input
                                type="text"
                                name="branch_location_hours"
                                class="admin-form-control w-100 @error('branch_location_hours') is-invalid @enderror"
                                value="{{ old('branch_location_hours', $settings['branch_location_hours']) }}"
                                placeholder="e.g. Mon - Sun: 11AM - 11PM"
                            >
                            @error('branch_location_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <div class="field-row">
                                <div class="field-icon field-icon-link"><i class="bi bi-sign-turn-right-fill"></i></div>
                                <span class="field-label">Directions URL</span>
                            </div>
                            <input
                                type="url"
                                name="branch_location_map_url"
                                class="admin-form-control w-100 @error('branch_location_map_url') is-invalid @enderror"
                                value="{{ old('branch_location_map_url', $settings['branch_location_map_url']) }}"
                                placeholder="https://maps.google.com/..."
                            >
                            @error('branch_location_map_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <div class="field-row">
                                <div class="field-icon field-icon-image"><i class="bi bi-image-fill"></i></div>
                                <span class="field-label">Branch Image URL</span>
                            </div>
                            <input
                                type="url"
                                name="branch_location_image_url"
                                class="admin-form-control w-100 @error('branch_location_image_url') is-invalid @enderror"
                                value="{{ old('branch_location_image_url', $settings['branch_location_image_url']) }}"
                                placeholder="https://example.com/branch.jpg"
                            >
                            @error('branch_location_image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-3 pt-3" style="border-top: 1px solid var(--admin-border);">
                            <button type="submit" class="btn-save">
                                <i class="bi bi-check2 me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="sidebar-sticky">
                <div class="settings-card">
                    <div class="card-header-bar">
                        <div class="card-header-icon card-header-icon-green">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <div>
                            <p class="card-header-title">Live Preview</p>
                            <p class="card-header-sub">How the branch card appears on the homepage</p>
                        </div>
                    </div>
                    <div class="card-body-inner">
                        <img
                            id="previewImage"
                            src="{{ $settings['branch_location_image_url'] }}"
                            alt="Branch preview"
                            class="preview-image"
                        >

                        <div class="preview-item">
                            <div class="preview-icon"><i class="bi bi-shop"></i></div>
                            <div>
                                <div class="preview-label">Branch Name</div>
                                <div class="preview-value" id="previewName">{{ $settings['branch_location_name'] }}</div>
                            </div>
                        </div>

                        <div class="preview-item">
                            <div class="preview-icon"><i class="bi bi-geo-alt"></i></div>
                            <div>
                                <div class="preview-label">Address</div>
                                <div class="preview-value" id="previewAddress">{{ $settings['branch_location_address'] }}</div>
                            </div>
                        </div>

                        <div class="preview-item">
                            <div class="preview-icon"><i class="bi bi-telephone"></i></div>
                            <div>
                                <div class="preview-label">Phone</div>
                                <div class="preview-value" id="previewPhone">{{ $settings['branch_location_phone'] }}</div>
                            </div>
                        </div>

                        <div class="preview-item">
                            <div class="preview-icon"><i class="bi bi-clock"></i></div>
                            <div>
                                <div class="preview-label">Hours</div>
                                <div class="preview-value" id="previewHours">{{ $settings['branch_location_hours'] }}</div>
                            </div>
                        </div>

                        <div class="preview-item">
                            <div class="preview-icon"><i class="bi bi-sign-turn-right"></i></div>
                            <div>
                                <div class="preview-label">Directions Link</div>
                                <div class="preview-value" id="previewMapUrl">{{ $settings['branch_location_map_url'] }}</div>
                            </div>
                        </div>

                        <div class="preview-actions">
                            <a href="{{ $settings['branch_location_map_url'] }}" id="previewDirectionsLink" class="btn-action-link" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-map"></i>
                                Open Directions
                            </a>
                            <a href="{{ route('home') }}#locations" class="btn-action-link" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-box-arrow-up-right"></i>
                                View on Site
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    var textBindings = {
        branch_location_name: 'previewName',
        branch_location_address: 'previewAddress',
        branch_location_phone: 'previewPhone',
        branch_location_hours: 'previewHours',
        branch_location_map_url: 'previewMapUrl'
    };

    Object.keys(textBindings).forEach(function(fieldName) {
        var input = document.querySelector('[name="' + fieldName + '"]');
        var preview = document.getElementById(textBindings[fieldName]);

        if (!input || !preview) {
            return;
        }

        input.addEventListener('input', function(event) {
            preview.textContent = event.target.value;

            if (fieldName === 'branch_location_map_url') {
                document.getElementById('previewDirectionsLink').href = event.target.value;
            }
        });
    });

    document.querySelector('[name="branch_location_image_url"]')?.addEventListener('input', function(event) {
        document.getElementById('previewImage').src = event.target.value;
    });
</script>
@endpush