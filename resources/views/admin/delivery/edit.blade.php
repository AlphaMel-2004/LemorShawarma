@extends('layouts.admin')

@section('title', 'Delivery & QR Settings')
@section('page-title', 'Delivery & QR Settings')

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

    .card-header-icon-gold   { background: rgba(212,175,55,0.14); color: var(--admin-primary); }
    .card-header-icon-violet { background: rgba(124, 58, 237, 0.12); color: #7c3aed; }

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

    /* ── Delivery App Rows ── */
    .app-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        border: 1px solid var(--admin-border);
        border-radius: 12px;
        background: var(--admin-bg);
        transition: border-color 0.18s;
    }

    .app-row + .app-row { margin-top: 0.75rem; }

    .app-row:has(.app-toggle:checked) {
        border-color: rgba(212,175,55,0.4);
        background: rgba(212,175,55,0.04);
    }

    .app-logo {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        padding: 9px;
    }

    .app-logo img { width: 100%; height: 100%; object-fit: contain; filter: brightness(0) invert(1); }
    .app-logo .app-logo-initials {
        display: none;
        font-size: 0.7rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.02em;
        text-align: center;
        line-height: 1.1;
        text-transform: uppercase;
    }

    .app-logo-ubereats       { background: #06C167; }
    .app-logo-doordash       { background: #FF3008; }
    .app-logo-skipthedishes  { background: #FF5A00; }

    /* ── Disabled / locked state ── */
    .app-row:has(.app-toggle:not(:checked)) {
        border-color: var(--admin-border);
        background: var(--admin-bg);
        opacity: 0.55;
    }

    .app-row:has(.app-toggle:not(:checked)) .app-fields input {
        pointer-events: none;
        background: rgba(255,255,255,0.03);
        color: var(--admin-text-muted);
        cursor: not-allowed;
    }

    .app-row:has(.app-toggle:not(:checked)) .app-logo {
        filter: grayscale(0.7);
    }

    .app-disabled-badge {
        display: none;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.68rem;
        font-weight: 600;
        color: var(--admin-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--admin-border);
        border-radius: 6px;
        padding: 0.2rem 0.55rem;
        margin-top: 0.35rem;
        width: fit-content;
    }

    .app-row:has(.app-toggle:not(:checked)) .app-disabled-badge { display: flex; }

    .app-meta { flex: 1; min-width: 0; }

    .app-name {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--admin-text);
        margin-bottom: 0.1rem;
    }

    .app-fields {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-top: 0.55rem;
    }

    .app-fields input {
        flex: 1;
        min-width: 140px;
        background: var(--admin-card);
        border: 1px solid var(--admin-border);
        border-radius: 8px;
        color: var(--admin-text);
        font-size: 0.78rem;
        padding: 0.4rem 0.65rem;
        transition: border-color 0.15s;
    }

    .app-fields input:focus {
        outline: none;
        border-color: var(--admin-primary);
    }

    .app-fields input::placeholder { color: var(--admin-text-muted); }

    .app-toggle-wrap {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        min-width: 136px;
    }

    .app-toggle-control {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
    }

    .app-toggle-wrap .form-check-input {
        width: 2.55rem;
        height: 1.45rem;
        margin: 0;
        border-radius: 999px;
        cursor: pointer;
        border-color: rgba(212, 175, 55, 0.42);
        background-color: #0f0f0f;
        background-position: left center;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3E%3Ccircle r='3' fill='%23efe5c8'/%3E%3C/svg%3E");
        transition: background-color 0.2s, border-color 0.2s, box-shadow 0.2s;
    }

    .app-toggle-wrap .form-check-input:checked {
        background-color: rgba(212, 175, 55, 0.9);
        border-color: rgba(212, 175, 55, 1);
        background-position: right center;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3E%3Ccircle r='3' fill='%23160f02'/%3E%3C/svg%3E");
    }

    .app-toggle-wrap .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.24);
    }

    .app-toggle-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--admin-text);
        white-space: nowrap;
    }

    @media (max-width: 767.98px) {
        .app-row {
            flex-wrap: wrap;
        }

        .app-toggle-wrap {
            width: 100%;
            justify-content: flex-start;
            margin-left: 3.85rem;
        }
    }

    .field-label {
        font-size: 0.7rem;
        color: var(--admin-text-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 0.25rem;
    }

    .field-pair { flex: 1; min-width: 140px; }

    /* ── QR Code ── */
    .qr-wrapper { text-align: center; }

    .qr-canvas-box {
        background: #ffffff;
        border-radius: 14px;
        padding: 1.25rem;
        display: inline-block;
        margin-bottom: 1rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
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
        text-decoration: none;
    }

    .btn-qr:hover {
        border-color: var(--admin-primary);
        color: var(--admin-primary);
    }

    .btn-qr-primary {
        background: var(--admin-primary);
        color: #0d0d0d;
        border-color: var(--admin-primary);
    }

    .btn-qr-primary:hover {
        background: var(--admin-primary-hover);
        color: #0d0d0d;
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

    .qr-tip i { color: var(--admin-primary); margin-top: 2px; flex-shrink: 0; }

    .qr-switcher {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.65rem;
        margin-bottom: 1.25rem;
    }

    .qr-toggle-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        width: 100%;
        padding: 0.8rem 1rem;
        border-radius: 12px;
        border: 1px solid var(--admin-border);
        background: var(--admin-bg);
        color: var(--admin-text-muted);
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .qr-toggle-btn:hover {
        border-color: rgba(212,175,55,0.35);
        color: var(--admin-text);
    }

    .qr-toggle-btn.is-active {
        background: rgba(212,175,55,0.12);
        border-color: rgba(212,175,55,0.45);
        color: var(--admin-text);
        box-shadow: inset 0 0 0 1px rgba(212,175,55,0.1);
    }

    .qr-toggle-btn i {
        color: var(--admin-primary);
        font-size: 0.88rem;
    }

    .qr-toggle-btn span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .qr-block-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--admin-text);
        text-transform: uppercase;
        letter-spacing: 0.07em;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .qr-block-label i { color: var(--admin-primary); font-size: 0.85rem; }

    @media (max-width: 575.98px) {
        .qr-switcher {
            grid-template-columns: 1fr;
        }
    }

    /* ── Save ── */
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

    .btn-save:hover { background: var(--admin-primary-hover); }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row g-4">

        {{-- Delivery Apps Form --}}
        <div class="col-12 col-xl-7">
            <form method="POST" action="{{ route('admin.delivery.update') }}">
                @csrf
                @method('PUT')

                <div class="settings-card">
                    <div class="card-header-bar">
                        <div class="card-header-icon card-header-icon-gold">
                            <i class="bi bi-bag-fill"></i>
                        </div>
                        <div>
                            <p class="card-header-title">Delivery Apps</p>
                            <p class="card-header-sub">Paste your <strong style="color:var(--admin-text)">restaurant listing URL</strong> from each platform. Customers tap the button and land directly on your store page in the app.</p>
                        </div>
                    </div>
                    <div class="card-body-inner">

                        @if($errors->any())
                            <div class="alert alert-danger py-2 px-3 mb-3" style="font-size:0.82rem;">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                {{ $errors->first() }}
                            </div>
                        @endif

                        @foreach($settings as $key => $app)
                            <div class="app-row">
                                <div class="app-logo app-logo-{{ $key }}">
                                    <img src="{{ $app['logo'] ?? 'https://cdn.jsdelivr.net/npm/simple-icons@latest/icons/'.$key.'.svg' }}"
                                         alt="{{ $app['name'] }}"
                                         loading="lazy"
                                         onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                                    <span class="app-logo-initials">{{ implode('', array_map(fn($w) => $w[0], array_slice(explode(' ', $app['name']), 0, 2))) }}</span>
                                </div>

                                <div class="app-meta">
                                    <div class="app-name">{{ $app['name'] }}</div>
                                    <div class="app-disabled-badge">
                                        <i class="bi bi-lock-fill"></i> Not shown to customers
                                    </div>
                                    <div class="app-fields">
                                        <div class="field-pair">
                                            <div class="field-label">Display name</div>
                                            <input type="text"
                                                   name="delivery_{{ $key }}_name"
                                                   value="{{ old('delivery_'.$key.'_name', $app['name']) }}"
                                                   placeholder="Display name"
                                                   maxlength="60">
                                        </div>
                                        <div class="field-pair">
                                            <div class="field-label">Restaurant page URL</div>
                                            <input type="url"
                                                   name="delivery_{{ $key }}_url"
                                                   value="{{ old('delivery_'.$key.'_url', $app['fallback']) }}"
                                                   placeholder="https://www.ubereats.com/store/your-restaurant/…">
                                        </div>
                                    </div>
                                </div>

                                <div class="app-toggle-wrap">
                                    <div class="app-toggle-control form-check form-switch">
                                        <input class="form-check-input app-toggle"
                                               type="checkbox"
                                               role="switch"
                                               id="delivery_{{ $key }}_enabled"
                                               name="delivery_{{ $key }}_enabled"
                                               value="1"
                                               @checked(old('delivery_'.$key.'_enabled', $app['enabled'] ? '1' : '0') === '1')>
                                        <label class="app-toggle-label" for="delivery_{{ $key }}_enabled">Show app</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn-save">
                                <i class="bi bi-floppy-fill me-1"></i> Save Changes
                            </button>
                        </div>

                        <div class="mt-3 p-3 rounded-3" style="background:rgba(212,175,55,0.06);border:1px solid rgba(212,175,55,0.18);font-size:0.78rem;color:var(--admin-text-muted);">
                            <i class="bi bi-lightbulb-fill me-1" style="color:var(--admin-primary);"></i>
                            <strong style="color:var(--admin-text);">How to find your restaurant URL:</strong>
                            open each delivery app, go to your restaurant's page, tap <em>Share</em> and copy the link. On mobile browsers, tapping that link will open the app directly to your store.
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- QR Code Panel --}}
        <div class="col-12 col-xl-5">
            @php
                $qrCodes = [
                    'home' => [
                        'label' => 'Website Home',
                        'button_label' => 'Home',
                        'icon' => 'bi bi-house-door-fill',
                        'url' => $websiteHomeUrl,
                        'preview' => 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='.urlencode($websiteHomeUrl),
                        'download' => 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&format=png&data='.urlencode($websiteHomeUrl),
                        'filename' => 'website-home-qr.png',
                        'alt' => 'Website Home QR Code',
                    ],
                    'locations' => [
                        'label' => 'Store Locations',
                        'button_label' => 'Locations',
                        'icon' => 'bi bi-geo-alt-fill',
                        'url' => $websiteLocationsUrl,
                        'preview' => 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='.urlencode($websiteLocationsUrl),
                        'download' => 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&format=png&data='.urlencode($websiteLocationsUrl),
                        'filename' => 'website-locations-qr.png',
                        'alt' => 'Locations QR Code',
                    ],
                    'menu' => [
                        'label' => 'Menu & Order',
                        'button_label' => 'Menu',
                        'icon' => 'bi bi-bag-fill',
                        'url' => $mobileMenuUrl,
                        'preview' => 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='.urlencode($mobileMenuUrl),
                        'download' => 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&format=png&data='.urlencode($mobileMenuUrl),
                        'filename' => 'menu-qr.png',
                        'alt' => 'Menu QR Code',
                    ],
                    'feedback' => [
                        'label' => 'Feedback & Reviews',
                        'button_label' => 'Reviews',
                        'icon' => 'bi bi-chat-heart-fill',
                        'url' => $mobileFeedbackUrl,
                        'preview' => 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='.urlencode($mobileFeedbackUrl),
                        'download' => 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&format=png&data='.urlencode($mobileFeedbackUrl),
                        'filename' => 'feedback-qr.png',
                        'alt' => 'Feedback QR Code',
                    ],
                ];
                $defaultQrCode = $qrCodes['home'];
            @endphp
            <div class="settings-card">
                <div class="card-header-bar">
                    <div class="card-header-icon card-header-icon-violet">
                        <i class="bi bi-qr-code"></i>
                    </div>
                    <div>
                        <p class="card-header-title">Quick QR Links</p>
                        <p class="card-header-sub">Choose a page, then copy the link or download its QR code.</p>
                    </div>
                </div>
                <div class="card-body-inner">
                    <div class="qr-switcher" role="tablist" aria-label="QR code views">
                        @foreach($qrCodes as $key => $qrCode)
                            <button
                                type="button"
                                class="qr-toggle-btn {{ $loop->first ? 'is-active' : '' }}"
                                id="qrToggle{{ ucfirst($key) }}"
                                data-qr-trigger="{{ $key }}"
                                role="tab"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                aria-controls="qrPreviewPanel"
                            >
                                <i class="{{ $qrCode['icon'] }}"></i>
                                <span>{{ $qrCode['button_label'] }}</span>
                            </button>
                        @endforeach
                    </div>

                    <div class="qr-wrapper" id="qrPreviewPanel">
                        <div class="qr-block-label" id="qrPanelLabel">
                            <i class="{{ $defaultQrCode['icon'] }}" id="qrPanelIcon"></i>
                            <span id="qrPanelTitle">{{ $defaultQrCode['label'] }}</span>
                        </div>
                        <div class="qr-canvas-box">
                            <img
                                id="qrPreviewImage"
                                src="{{ $defaultQrCode['preview'] }}"
                                alt="{{ $defaultQrCode['alt'] }}"
                                width="200"
                                height="200"
                                style="display:block;"
                            >
                        </div>
                        <div class="qr-url-text">
                            <span id="qrCurrentUrl">{{ $defaultQrCode['url'] }}</span>
                        </div>
                        <div class="qr-actions">
                            <a
                                href="{{ $defaultQrCode['download'] }}"
                                download="{{ $defaultQrCode['filename'] }}"
                                class="btn-qr btn-qr-primary"
                                id="qrDownloadBtn"
                            >
                                <i class="bi bi-download"></i> Download
                            </a>
                            <button type="button" class="btn-qr" id="qrCopyBtn">
                                <i class="bi bi-clipboard"></i> Copy Link
                            </button>
                        </div>
                    </div>

                    <div class="qr-tip" style="margin-top:1.25rem;">
                        <i class="bi bi-lightbulb"></i>
                        <span>Great for tables, counter cards, and takeaway packaging.</span>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    var qrCodes = @json($qrCodes);
    var activeQrKey = 'home';
    var qrButtons = document.querySelectorAll('[data-qr-trigger]');
    var qrPanelIcon = document.getElementById('qrPanelIcon');
    var qrPanelTitle = document.getElementById('qrPanelTitle');
    var qrPreviewImage = document.getElementById('qrPreviewImage');
    var qrCurrentUrl = document.getElementById('qrCurrentUrl');
    var qrDownloadBtn = document.getElementById('qrDownloadBtn');
    var qrCopyBtn = document.getElementById('qrCopyBtn');

    function setActiveQr(key) {
        var selectedQr = qrCodes[key];

        if (! selectedQr) {
            return;
        }

        activeQrKey = key;
        qrPanelIcon.className = selectedQr.icon;
        qrPanelTitle.textContent = selectedQr.label;
        qrPreviewImage.src = selectedQr.preview;
        qrPreviewImage.alt = selectedQr.alt;
        qrCurrentUrl.textContent = selectedQr.url;
        qrDownloadBtn.href = selectedQr.download;
        qrDownloadBtn.setAttribute('download', selectedQr.filename);

        qrButtons.forEach(function (button) {
            var isActive = button.dataset.qrTrigger === key;
            button.classList.toggle('is-active', isActive);
            button.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });
    }

    qrButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            setActiveQr(button.dataset.qrTrigger);
        });
    });

    qrCopyBtn.addEventListener('click', function () {
        var btn = this;

        navigator.clipboard.writeText(qrCodes[activeQrKey].url).then(function () {
            var original = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check2"></i> Copied!';
            btn.style.color = 'var(--admin-success)';
            btn.style.borderColor = 'var(--admin-success)';
            setTimeout(function () {
                btn.innerHTML = original;
                btn.style.color = '';
                btn.style.borderColor = '';
            }, 2000);
        });
    });

</script>
@endpush
