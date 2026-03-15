@extends('layouts.admin')

@section('title', 'Legal Pages')
@section('page-title', 'Legal Pages')

@push('styles')
<style>
    .settings-card {
        background-color: var(--admin-card);
        border: 1px solid var(--admin-border);
        border-radius: 14px;
        overflow: hidden;
    }

    .card-header-bar {
        padding: 1.1rem 1.4rem;
        border-bottom: 1px solid var(--admin-border);
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .card-header-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        background: rgba(57, 106, 255, 0.12);
        color: var(--admin-primary);
        flex-shrink: 0;
    }

    .card-header-title {
        font-size: 0.98rem;
        font-weight: 700;
        margin-bottom: 0;
        color: var(--admin-text);
    }

    .card-header-sub {
        font-size: 0.74rem;
        color: var(--admin-text-muted);
        margin-bottom: 0;
    }

    .card-body-inner {
        padding: 1.25rem 1.4rem;
    }

    .helper-box {
        background: rgba(57, 106, 255, 0.06);
        border: 1px solid rgba(57, 106, 255, 0.2);
        border-radius: 10px;
        padding: 0.8rem 0.9rem;
        margin-bottom: 1rem;
        font-size: 0.78rem;
        color: var(--admin-text-muted);
        line-height: 1.5;
    }

    .helper-box code {
        color: var(--admin-primary);
        font-size: 0.75rem;
    }

    .meta-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.9rem;
        margin-bottom: 1rem;
    }

    .quick-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: flex-start;
        align-items: center;
    }

    .quick-action-link {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        border: 1px solid var(--admin-border);
        color: var(--admin-text);
        font-size: 0.78rem;
        font-weight: 600;
        background: var(--admin-card);
    }

    .quick-action-link:hover {
        border-color: var(--admin-primary);
        color: var(--admin-primary);
    }

    .legal-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 0.55rem;
        margin-bottom: 1rem;
    }

    .legal-tab-btn {
        border: 1px solid var(--admin-border);
        border-radius: 8px;
        background: var(--admin-card);
        color: var(--admin-text-muted);
        padding: 0.5rem 0.8rem;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.01em;
    }

    .legal-tab-btn.active {
        border-color: var(--admin-primary);
        color: var(--admin-primary);
        background: rgba(57, 106, 255, 0.06);
    }

    .legal-panel {
        display: none;
        border: 1px solid var(--admin-border);
        border-radius: 12px;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.01);
    }

    .legal-panel.active {
        display: block;
    }

    .panel-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--admin-text);
        margin-bottom: 0.75rem;
    }

    .field-note {
        font-size: 0.72rem;
        color: var(--admin-text-muted);
        margin-top: 0.35rem;
    }

    .char-counter {
        font-size: 0.7rem;
        color: var(--admin-text-muted);
        text-align: right;
        margin-top: 0.35rem;
    }

    .editor-toolbar {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        flex-wrap: wrap;
    }

    .editor-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.74rem;
        padding: 0.35rem 0.6rem;
        border-radius: 7px;
        border: 1px solid var(--admin-border);
        color: var(--admin-text-muted);
        background: var(--admin-card);
    }

    .editor-action-btn:hover {
        color: var(--admin-primary);
        border-color: var(--admin-primary);
    }

    .sticky-save-bar {
        position: sticky;
        bottom: 0;
        background: var(--admin-card);
        border-top: 1px solid var(--admin-border);
        margin: 1rem -1.4rem -1.25rem;
        padding: 0.85rem 1.4rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 -6px 20px rgba(15, 23, 42, 0.06);
    }

    .sticky-save-text {
        font-size: 0.76rem;
        color: var(--admin-text-muted);
    }

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
    }
</style>
@endpush

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="settings-card">
            <div class="card-header-bar">
                <div class="card-header-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div>
                    <p class="card-header-title">Legal Page Content</p>
                    <p class="card-header-sub">Manage Privacy Policy, Terms of Service, and Cookie Policy from admin</p>
                </div>
            </div>

            <div class="card-body-inner">
                <form method="POST" action="{{ route('admin.legal.update') }}" id="legalSettingsForm">
                    @csrf
                    @method('PUT')

                    <div class="meta-grid">
                        <div>
                            <label for="legal_last_updated" class="form-label fw-semibold">Last Updated Label</label>
                            <input
                                id="legal_last_updated"
                                type="text"
                                name="legal_last_updated"
                                maxlength="60"
                                data-counter-target="legal_last_updated_counter"
                                class="admin-form-control w-100 @error('legal_last_updated') is-invalid @enderror"
                                value="{{ old('legal_last_updated', $settings['legal_last_updated'] ?? '') }}"
                                placeholder="March 15, 2026"
                            >
                            <div id="legal_last_updated_counter" class="char-counter"></div>
                            @error('legal_last_updated')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <div class="quick-actions">
                                <a class="quick-action-link" href="{{ route('legal.privacy') }}" target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-box-arrow-up-right"></i> Preview Privacy
                                </a>
                                <a class="quick-action-link" href="{{ route('legal.terms') }}" target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-box-arrow-up-right"></i> Preview Terms
                                </a>
                                <a class="quick-action-link" href="{{ route('legal.cookies') }}" target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-box-arrow-up-right"></i> Preview Cookies
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="helper-box">
                        <strong>Editor format:</strong> Start section headings with <code>##</code> on a new line, then write the paragraph below.<br>
                        Example: <code>## 1. Scope</code><br>
                        Summary fields: use one bullet per line.
                    </div>

                    <div class="legal-tabs" role="tablist" aria-label="Legal page editors">
                        <button type="button" class="legal-tab-btn active" data-tab="privacy" role="tab" aria-selected="true">Privacy Policy</button>
                        <button type="button" class="legal-tab-btn" data-tab="terms" role="tab" aria-selected="false">Terms of Service</button>
                        <button type="button" class="legal-tab-btn" data-tab="cookies" role="tab" aria-selected="false">Cookie Policy</button>
                    </div>

                    <div class="legal-panel active" data-panel="privacy" role="tabpanel">
                        <p class="panel-title">Privacy Policy Content</p>
                        <div class="mb-3">
                            <label for="legal_privacy_intro" class="form-label">Intro</label>
                            <input id="legal_privacy_intro" type="text" name="legal_privacy_intro" maxlength="255" data-counter-target="legal_privacy_intro_counter" class="admin-form-control w-100 @error('legal_privacy_intro') is-invalid @enderror" value="{{ old('legal_privacy_intro', $settings['legal_privacy_intro'] ?? '') }}">
                            <div id="legal_privacy_intro_counter" class="char-counter"></div>
                            @error('legal_privacy_intro')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="legal_privacy_summary" class="form-label">Quick Summary (one line per bullet)</label>
                            <textarea id="legal_privacy_summary" name="legal_privacy_summary" rows="5" maxlength="1200" data-counter-target="legal_privacy_summary_counter" class="admin-form-control w-100 @error('legal_privacy_summary') is-invalid @enderror">{{ old('legal_privacy_summary', $settings['legal_privacy_summary'] ?? '') }}</textarea>
                            <div id="legal_privacy_summary_counter" class="char-counter"></div>
                            @error('legal_privacy_summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-0">
                            <label for="legal_privacy_content" class="form-label">Page Content</label>
                            <div class="editor-toolbar">
                                <button type="button" class="editor-action-btn" data-insert-target="legal_privacy_content" data-insert-value="## 1. New Section\nDescribe this section here.\n\n"><i class="bi bi-plus-circle"></i> Add Section Template</button>
                            </div>
                            <textarea id="legal_privacy_content" name="legal_privacy_content" rows="14" maxlength="12000" data-counter-target="legal_privacy_content_counter" class="admin-form-control w-100 @error('legal_privacy_content') is-invalid @enderror">{{ old('legal_privacy_content', $settings['legal_privacy_content'] ?? '') }}</textarea>
                            <div id="legal_privacy_content_counter" class="char-counter"></div>
                            @error('legal_privacy_content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="legal-panel" data-panel="terms" role="tabpanel">
                        <p class="panel-title">Terms of Service Content</p>
                        <div class="mb-3">
                            <label for="legal_terms_intro" class="form-label">Intro</label>
                            <input id="legal_terms_intro" type="text" name="legal_terms_intro" maxlength="255" data-counter-target="legal_terms_intro_counter" class="admin-form-control w-100 @error('legal_terms_intro') is-invalid @enderror" value="{{ old('legal_terms_intro', $settings['legal_terms_intro'] ?? '') }}">
                            <div id="legal_terms_intro_counter" class="char-counter"></div>
                            @error('legal_terms_intro')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="legal_terms_summary" class="form-label">Quick Summary (one line per bullet)</label>
                            <textarea id="legal_terms_summary" name="legal_terms_summary" rows="5" maxlength="1200" data-counter-target="legal_terms_summary_counter" class="admin-form-control w-100 @error('legal_terms_summary') is-invalid @enderror">{{ old('legal_terms_summary', $settings['legal_terms_summary'] ?? '') }}</textarea>
                            <div id="legal_terms_summary_counter" class="char-counter"></div>
                            @error('legal_terms_summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-0">
                            <label for="legal_terms_content" class="form-label">Page Content</label>
                            <div class="editor-toolbar">
                                <button type="button" class="editor-action-btn" data-insert-target="legal_terms_content" data-insert-value="## 1. New Section\nDescribe this section here.\n\n"><i class="bi bi-plus-circle"></i> Add Section Template</button>
                            </div>
                            <textarea id="legal_terms_content" name="legal_terms_content" rows="14" maxlength="12000" data-counter-target="legal_terms_content_counter" class="admin-form-control w-100 @error('legal_terms_content') is-invalid @enderror">{{ old('legal_terms_content', $settings['legal_terms_content'] ?? '') }}</textarea>
                            <div id="legal_terms_content_counter" class="char-counter"></div>
                            @error('legal_terms_content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="legal-panel" data-panel="cookies" role="tabpanel">
                        <p class="panel-title">Cookie Policy Content</p>
                        <div class="mb-3">
                            <label for="legal_cookies_intro" class="form-label">Intro</label>
                            <input id="legal_cookies_intro" type="text" name="legal_cookies_intro" maxlength="255" data-counter-target="legal_cookies_intro_counter" class="admin-form-control w-100 @error('legal_cookies_intro') is-invalid @enderror" value="{{ old('legal_cookies_intro', $settings['legal_cookies_intro'] ?? '') }}">
                            <div id="legal_cookies_intro_counter" class="char-counter"></div>
                            @error('legal_cookies_intro')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="legal_cookies_summary" class="form-label">Quick Summary (one line per bullet)</label>
                            <textarea id="legal_cookies_summary" name="legal_cookies_summary" rows="5" maxlength="1200" data-counter-target="legal_cookies_summary_counter" class="admin-form-control w-100 @error('legal_cookies_summary') is-invalid @enderror">{{ old('legal_cookies_summary', $settings['legal_cookies_summary'] ?? '') }}</textarea>
                            <div id="legal_cookies_summary_counter" class="char-counter"></div>
                            @error('legal_cookies_summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-0">
                            <label for="legal_cookies_content" class="form-label">Page Content</label>
                            <div class="editor-toolbar">
                                <button type="button" class="editor-action-btn" data-insert-target="legal_cookies_content" data-insert-value="## 1. New Section\nDescribe this section here.\n\n"><i class="bi bi-plus-circle"></i> Add Section Template</button>
                            </div>
                            <textarea id="legal_cookies_content" name="legal_cookies_content" rows="14" maxlength="12000" data-counter-target="legal_cookies_content_counter" class="admin-form-control w-100 @error('legal_cookies_content') is-invalid @enderror">{{ old('legal_cookies_content', $settings['legal_cookies_content'] ?? '') }}</textarea>
                            <div id="legal_cookies_content_counter" class="char-counter"></div>
                            @error('legal_cookies_content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="sticky-save-bar">
                        <span class="sticky-save-text">Tip: Save before previewing to see latest changes on public pages.</span>
                        <button type="submit" class="btn-save">
                            <i class="bi bi-save2 me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const tabButtons = document.querySelectorAll('.legal-tab-btn');
        const tabPanels = document.querySelectorAll('.legal-panel');

        const activateTab = (tabName) => {
            tabButtons.forEach((button) => {
                const isActive = button.getAttribute('data-tab') === tabName;
                button.classList.toggle('active', isActive);
                button.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });

            tabPanels.forEach((panel) => {
                panel.classList.toggle('active', panel.getAttribute('data-panel') === tabName);
            });
        };

        tabButtons.forEach((button) => {
            button.addEventListener('click', () => activateTab(button.getAttribute('data-tab')));
        });

        const updateCounter = (input) => {
            const counterId = input.getAttribute('data-counter-target');
            if (!counterId) {
                return;
            }

            const counter = document.getElementById(counterId);
            if (!counter) {
                return;
            }

            const maxLength = Number(input.getAttribute('maxlength') || 0);
            const length = input.value.length;
            counter.textContent = maxLength > 0 ? `${length}/${maxLength}` : `${length}`;
        };

        const counterInputs = document.querySelectorAll('[data-counter-target]');
        counterInputs.forEach((input) => {
            updateCounter(input);
            input.addEventListener('input', () => updateCounter(input));
        });

        const insertButtons = document.querySelectorAll('[data-insert-target]');
        insertButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-insert-target');
                const insertValue = button.getAttribute('data-insert-value') || '';
                const target = document.getElementById(targetId);

                if (!target) {
                    return;
                }

                const start = target.selectionStart ?? target.value.length;
                const end = target.selectionEnd ?? target.value.length;
                const before = target.value.slice(0, start);
                const after = target.value.slice(end);

                target.value = `${before}${insertValue}${after}`;
                const cursor = start + insertValue.length;
                target.focus();
                target.setSelectionRange(cursor, cursor);
                updateCounter(target);
            });
        });
    })();
</script>
@endpush
