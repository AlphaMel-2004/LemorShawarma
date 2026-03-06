@extends('layouts.admin')

@section('title', 'Manage Contacts')
@section('page-title', 'Manage Contacts')

@push('styles')
<style>
    .settings-card {
        background-color: var(--admin-card);
        border: 1px solid var(--admin-border);
        border-radius: 12px;
        padding: 2rem;
    }

    .settings-header {
        margin-bottom: 2rem;
    }

    .settings-header h5 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--admin-text);
        margin-bottom: 0.25rem;
    }

    .settings-header p {
        font-size: 0.85rem;
        color: var(--admin-text-muted);
        margin-bottom: 0;
    }

    .field-group {
        margin-bottom: 1.5rem;
    }

    .field-group:last-child {
        margin-bottom: 0;
    }

    .field-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .field-icon-location {
        background: rgba(57, 106, 255, 0.12);
        color: var(--admin-primary);
    }

    .field-icon-phone {
        background: rgba(22, 219, 170, 0.12);
        color: var(--admin-success);
    }

    .field-icon-email {
        background: rgba(254, 92, 115, 0.12);
        color: var(--admin-danger);
    }

    .field-icon-clock {
        background: rgba(245, 158, 11, 0.12);
        color: #f59e0b;
    }

    .preview-card {
        background-color: var(--admin-card);
        border: 1px solid var(--admin-border);
        border-radius: 12px;
        padding: 2rem;
    }

    .preview-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--admin-text);
        margin-bottom: 1.5rem;
    }

    .preview-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--admin-border);
    }

    .preview-item:last-child {
        border-bottom: none;
    }

    .preview-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(57, 106, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--admin-primary);
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .preview-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--admin-text-muted);
        font-weight: 600;
    }

    .preview-value {
        font-size: 0.9rem;
        color: var(--admin-text);
        font-weight: 500;
    }

    .btn-save {
        background: var(--admin-primary);
        color: #fff;
        border: none;
        padding: 0.7rem 2rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-save:hover {
        background: var(--admin-primary-hover);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(57, 106, 255, 0.3);
    }

    .btn-save:disabled {
        opacity: 0.65;
        transform: none;
        box-shadow: none;
    }

    .success-alert {
        background: rgba(22, 219, 170, 0.1);
        border: 1px solid rgba(22, 219, 170, 0.3);
        color: #0d7a5f;
        border-radius: 10px;
        padding: 0.85rem 1.25rem;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
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
        {{-- Edit Form --}}
        <div class="col-lg-7">
            <div class="settings-card">
                <div class="settings-header">
                    <h5>Contact Information</h5>
                    <p>Update the contact details displayed on the website footer and contact section.</p>
                </div>

                <form method="POST" action="{{ route('admin.contacts.update') }}" id="contactForm">
                    @csrf
                    @method('PUT')

                    {{-- Address Line 1 --}}
                    <div class="field-group">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="field-icon field-icon-location">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <label class="admin-form-label mb-0">Street Address</label>
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
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="field-icon field-icon-location">
                                <i class="bi bi-building"></i>
                            </div>
                            <label class="admin-form-label mb-0">City / District / Zip</label>
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
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="field-icon field-icon-phone">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <label class="admin-form-label mb-0">Phone Number</label>
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
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="field-icon field-icon-email">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <label class="admin-form-label mb-0">Email Address</label>
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
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="field-icon field-icon-clock">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <label class="admin-form-label mb-0">Operating Hours</label>
                        </div>
                        <input
                            type="text"
                            name="contact_hours"
                            class="admin-form-control w-100 @error('contact_hours') is-invalid @enderror"
                            value="{{ old('contact_hours', $settings['contact_hours']) }}"
                            placeholder="e.g. Mon - Sun: 11AM - 11PM"
                        >
                        @error('contact_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3" style="border-top: 1px solid var(--admin-border);">
                        <button type="submit" class="btn-save" id="saveBtn">
                            <i class="bi bi-check2 me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Live Preview --}}
        <div class="col-lg-5">
            <div class="preview-card">
                <div class="preview-title">
                    <i class="bi bi-eye me-1"></i> Live Preview
                </div>

                <div class="preview-item">
                    <div class="preview-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div>
                        <div class="preview-label">Address</div>
                        <div class="preview-value" id="previewAddress1">{{ $settings['contact_address_line1'] }}</div>
                        <div class="preview-value" id="previewAddress2">{{ $settings['contact_address_line2'] }}</div>
                    </div>
                </div>

                <div class="preview-item">
                    <div class="preview-icon">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <div>
                        <div class="preview-label">Phone</div>
                        <div class="preview-value" id="previewPhone">{{ $settings['contact_phone'] }}</div>
                    </div>
                </div>

                <div class="preview-item">
                    <div class="preview-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div>
                        <div class="preview-label">Email</div>
                        <div class="preview-value" id="previewEmail">{{ $settings['contact_email'] }}</div>
                    </div>
                </div>

                <div class="preview-item">
                    <div class="preview-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div>
                        <div class="preview-label">Hours</div>
                        <div class="preview-value" id="previewHours">{{ $settings['contact_hours'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Live preview bindings
    const bindings = {
        'contact_address_line1': 'previewAddress1',
        'contact_address_line2': 'previewAddress2',
        'contact_phone': 'previewPhone',
        'contact_email': 'previewEmail',
        'contact_hours': 'previewHours',
    };

    Object.entries(bindings).forEach(([inputName, previewId]) => {
        const input = document.querySelector(`[name="${inputName}"]`);
        const preview = document.getElementById(previewId);

        if (input && preview) {
            input.addEventListener('input', function () {
                preview.textContent = this.value || '—';
            });
        }
    });
</script>
@endpush
