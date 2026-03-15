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

    /* ── QR Code ── */
    .qr-wrapper {
        text-align: center;
    }

    .qr-canvas-box {
        background: #ffffff;
        border-radius: 14px;
        padding: 1.25rem;
        display: inline-block;
        margin-bottom: 1rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .qr-canvas-box canvas {
        display: block;
    }

    .qr-url-text {
        font-size: 0.78rem;
        color: var(--admin-text-muted);
        word-break: break-all;
        margin-bottom: 1rem;
        background: var(--admin-bg);
        border: 1px solid var(--admin-border);
        border-radius: 8px;
        padding: 0.5rem 0.85rem;
        display: inline-block;
    }

    .qr-url-text i { color: var(--admin-primary); margin-right: 0.35rem; }

    .qr-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-qr {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        border: 1px solid var(--admin-border);
        background: var(--admin-card);
        color: var(--admin-text);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-qr:hover {
        border-color: var(--admin-primary);
        color: var(--admin-primary);
        background: rgba(57, 106, 255, 0.05);
    }

    .btn-qr-primary {
        background: var(--admin-primary);
        color: #fff;
        border-color: var(--admin-primary);
    }

    .btn-qr-primary:hover {
        background: var(--admin-primary-hover);
        color: #fff;
    }

    .qr-tip {
        font-size: 0.72rem;
        color: var(--admin-text-muted);
        margin-top: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.4rem;
        text-align: left;
        background: rgba(57, 106, 255, 0.04);
        border-radius: 8px;
        padding: 0.65rem 0.85rem;
    }

    .qr-tip i {
        color: var(--admin-primary);
        margin-top: 2px;
        flex-shrink: 0;
    }

    /* ── Buttons ── */
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

    .btn-save:disabled {
        opacity: 0.65;
        transform: none;
        box-shadow: none;
    }

    /* ── Sticky sidebar ── */
    @media (min-width: 992px) {
        .sidebar-sticky {
            position: sticky;
            top: 100px;
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

                {{-- QR Code Generator --}}
                <div class="settings-card">
                    <div class="card-header-bar">
                        <div class="card-header-icon card-header-icon-violet">
                            <i class="bi bi-qr-code"></i>
                        </div>
                        <div>
                            <p class="card-header-title">Menu QR Code</p>
                            <p class="card-header-sub">Customers scan to view menu &amp; order</p>
                        </div>
                    </div>
                    <div class="card-body-inner">
                        <div class="qr-wrapper">
                            <div class="qr-canvas-box">
                                <img
                                    id="qrImage"
                                    src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(route('mobile.menu')) }}"
                                    alt="Menu QR Code"
                                    width="200"
                                    height="200"
                                    style="display:block;"
                                >
                            </div>

                            <div>
                                <div class="qr-url-text">
                                    <i class="bi bi-link-45deg"></i>
                                    <span id="qrUrlText">{{ route('mobile.menu') }}</span>
                                </div>
                            </div>

                            <div class="qr-actions">
                                <a href="https://api.qrserver.com/v1/create-qr-code/?size=600x600&format=png&data={{ urlencode(route('mobile.menu')) }}" download="pita-queen-menu-qr.png" class="btn-qr btn-qr-primary">
                                    <i class="bi bi-download"></i> Download PNG
                                </a>
                                <button type="button" class="btn-qr" id="copyLinkBtn">
                                    <i class="bi bi-clipboard"></i> Copy Link
                                </button>
                                <button type="button" class="btn-qr" id="printQrBtn">
                                    <i class="bi bi-printer"></i> Print
                                </button>
                            </div>

                            <div class="qr-tip">
                                <i class="bi bi-lightbulb"></i>
                                <span>Print this QR code and place it on tables, counter, or packaging so customers can browse the menu and place orders from their phone.</span>
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
    var bindings = {
        'contact_address_line1': 'previewAddress1',
        'contact_address_line2': 'previewAddress2',
        'contact_phone': 'previewPhone',
        'contact_email': 'previewEmail',
        'contact_hours': 'previewHours'
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

    // ── QR Code Actions ──
    var menuUrl = document.getElementById('qrUrlText').textContent.trim();

    document.getElementById('copyLinkBtn').addEventListener('click', function () {
        var btn = this;
        navigator.clipboard.writeText(menuUrl).then(function () {
            var original = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check2"><\/i> Copied!';
            btn.style.color = 'var(--admin-success)';
            btn.style.borderColor = 'var(--admin-success)';
            setTimeout(function () {
                btn.innerHTML = original;
                btn.style.color = '';
                btn.style.borderColor = '';
            }, 2000);
        });
    });

    document.getElementById('printQrBtn').addEventListener('click', function () {
        var imgSrc = document.getElementById('qrImage').src;
        var printWindow = window.open('', '_blank');
        var html = [];
        html.push('<html>');
        html.push('<head><title>Pita Queen - Menu QR Code<\/title><\/head>');
        html.push('<body style="display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:100vh;margin:0;font-family:Arial,sans-serif;">');
        html.push('<h2 style="margin-bottom:0.5rem;">Pita Queen<\/h2>');
        html.push('<p style="color:#888;margin-bottom:1.5rem;">Scan to view our menu<\/p>');
        html.push('<img src="' + imgSrc + '" style="width:280px;height:280px;">');
        html.push('<p style="margin-top:1rem;color:#aaa;font-size:0.85rem;">' + menuUrl + '<\/p>');
        html.push('<\/body><\/html>');
        printWindow.document.write(html.join(''));
        printWindow.document.close();
        printWindow.onload = function () { printWindow.print(); printWindow.close(); };
    });
</script>
@endpush
