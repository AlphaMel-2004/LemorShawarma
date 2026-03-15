@extends('layouts.admin')

@section('title', 'AI Chatbot Settings')
@section('page-title', 'AI Chatbot Settings')

@push('styles')
<style>
    .chatbot-settings-card {
        border: 1px solid rgba(212, 175, 55, 0.22);
        border-radius: 16px;
        background: linear-gradient(180deg, rgba(28, 28, 28, 0.97), rgba(18, 18, 18, 0.96));
        box-shadow: 0 14px 34px rgba(0, 0, 0, 0.38);
    }

    .chatbot-section {
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 14px;
        padding: 1rem;
        background: rgba(20, 20, 20, 0.92);
    }

    .chatbot-section-title {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        font-weight: 700;
        color: #f7f2e5;
        margin-bottom: 0.2rem;
    }

    .chatbot-section-desc {
        color: rgba(255, 232, 186, 0.66);
        font-size: 0.86rem;
        margin-bottom: 0.9rem;
    }

    .chatbot-help {
        font-size: 0.78rem;
        color: rgba(255, 232, 186, 0.62);
        margin-top: 0.35rem;
    }

    .chatbot-counter {
        font-size: 0.72rem;
        color: rgba(255, 232, 186, 0.58);
        text-align: right;
        margin-top: 0.35rem;
    }

    .chatbot-mini-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.6rem;
        border-radius: 999px;
        border: 1px solid rgba(212, 175, 55, 0.34);
        background: rgba(212, 175, 55, 0.12);
        color: #f4d989;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .chatbot-save-row {
        position: sticky;
        bottom: 0;
        background: linear-gradient(180deg, rgba(18, 18, 18, 0), #121212 32%);
        padding-top: 0.9rem;
        margin-top: 0.3rem;
    }

    .chatbot-preview {
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 12px;
        background: rgba(17, 17, 17, 0.96);
        padding: 0.9rem;
    }

    .chatbot-preview-label {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: rgba(255, 232, 186, 0.64);
        margin-bottom: 0.4rem;
    }

    .chatbot-preview-bubble {
        border: 1px solid rgba(212, 175, 55, 0.22);
        border-radius: 10px;
        background: rgba(22, 22, 22, 0.96);
        padding: 0.7rem;
        color: #f7f2e5;
        font-size: 0.87rem;
        line-height: 1.4;
    }

    .chatbot-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border-radius: 999px;
        padding: 0.38rem 0.72rem;
        font-size: 0.76rem;
        font-weight: 700;
    }

    .chatbot-status-pill.enabled {
        color: #0f7d5f;
        background: rgba(21, 183, 140, 0.14);
        border: 1px solid rgba(21, 183, 140, 0.24);
    }

    .chatbot-status-pill.disabled {
        color: #9a4a50;
        background: rgba(244, 82, 111, 0.1);
        border: 1px solid rgba(244, 82, 111, 0.2);
    }

    .chatbot-inline-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
        margin-top: 0.5rem;
    }

    .chatbot-pill-btn {
        border: 1px solid rgba(212, 175, 55, 0.28);
        border-radius: 999px;
        background: rgba(212, 175, 55, 0.1);
        color: #f4d989;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 0.32rem 0.64rem;
        line-height: 1.2;
    }

    .chatbot-pill-btn:hover {
        background: rgba(212, 175, 55, 0.2);
        border-color: rgba(212, 175, 55, 0.42);
    }

    .chatbot-range-wrap {
        display: grid;
        gap: 0.6rem;
    }

    .chatbot-range-row {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 0.6rem;
        align-items: center;
    }

    .chatbot-range-value {
        min-width: 64px;
        text-align: center;
        border-radius: 8px;
        border: 1px solid rgba(212, 175, 55, 0.28);
        background: rgba(212, 175, 55, 0.1);
        padding: 0.3rem 0.45rem;
        color: #f4d989;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .chatbot-range-wrap input[type='range'] {
        width: 100%;
    }

    .chatbot-disabled-note {
        border: 1px dashed rgba(244, 82, 111, 0.4);
        border-radius: 10px;
        padding: 0.6rem 0.75rem;
        color: #94444f;
        background: rgba(244, 82, 111, 0.06);
        font-size: 0.78rem;
        margin-top: 0.7rem;
    }

    .chatbot-section.is-disabled {
        opacity: 0.62;
    }

    .chatbot-quick-link {
        font-size: 0.78rem;
        text-decoration: none;
        font-weight: 700;
        color: var(--admin-primary);
    }

    .chatbot-quick-link:hover {
        text-decoration: underline;
        color: #f4d989;
    }

    .chatbot-preset-grid {
        display: grid;
        gap: 0.75rem;
    }

    .chatbot-preset-btn {
        width: 100%;
        border: 1px solid rgba(212, 175, 55, 0.24);
        border-radius: 12px;
        background: linear-gradient(180deg, rgba(212, 175, 55, 0.1), rgba(212, 175, 55, 0.04));
        text-align: left;
        padding: 0.78rem 0.85rem;
        color: #f7f2e5;
        transition: all 0.18s ease;
    }

    .chatbot-preset-btn:hover {
        border-color: rgba(212, 175, 55, 0.44);
        background: linear-gradient(180deg, rgba(212, 175, 55, 0.18), rgba(212, 175, 55, 0.08));
        transform: translateY(-1px);
    }

    .chatbot-preset-title {
        display: block;
        font-size: 0.85rem;
        font-weight: 800;
        color: #f7f2e5;
        margin-bottom: 0.2rem;
    }

    .chatbot-preset-text {
        display: block;
        font-size: 0.76rem;
        color: rgba(255, 232, 186, 0.64);
        line-height: 1.35;
    }

    .chatbot-preset-feedback {
        margin-top: 0.75rem;
        border-radius: 10px;
        border: 1px solid rgba(21, 183, 140, 0.24);
        background: rgba(21, 183, 140, 0.1);
        color: #0f7d5f;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 0.5rem 0.65rem;
    }

    .chatbot-icon-grid {
        display: grid;
        gap: 0.65rem;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        margin-top: 0.35rem;
    }

    .chatbot-icon-option-input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .chatbot-icon-option {
        border: 1px solid rgba(212, 175, 55, 0.24);
        border-radius: 12px;
        background: #161616;
        display: grid;
        gap: 0.42rem;
        place-items: center;
        min-height: 88px;
        padding: 0.68rem 0.55rem;
        cursor: pointer;
        transition: all 0.16s ease;
        color: #f4d989;
    }

    .chatbot-icon-option i {
        font-size: 1.18rem;
    }

    .chatbot-icon-option span {
        font-size: 0.74rem;
        font-weight: 700;
        text-align: center;
        line-height: 1.2;
    }

    .chatbot-icon-option-input:checked + .chatbot-icon-option {
        border-color: rgba(212, 175, 55, 0.56);
        background: linear-gradient(180deg, rgba(212, 175, 55, 0.2), rgba(212, 175, 55, 0.08));
        color: #fff2cd;
        box-shadow: 0 6px 16px rgba(212, 175, 55, 0.2);
        transform: translateY(-1px);
    }

    .chatbot-icon-option:hover {
        border-color: rgba(212, 175, 55, 0.38);
        background: linear-gradient(180deg, rgba(212, 175, 55, 0.14), rgba(212, 175, 55, 0.05));
    }

    .chatbot-settings-card .form-control,
    .chatbot-settings-card .form-select,
    .chatbot-settings-card .form-check-input {
        background-color: #0f0f0f;
        border-color: var(--admin-border);
        color: var(--admin-text);
    }

    .chatbot-settings-card .form-control:focus,
    .chatbot-settings-card .form-select:focus,
    .chatbot-settings-card .form-check-input:focus {
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
    }

    .chatbot-settings-card .form-label,
    .chatbot-settings-card h2,
    .chatbot-settings-card h3,
    .chatbot-settings-card .h4,
    .chatbot-settings-card .h5,
    .chatbot-settings-card .h6,
    .chatbot-settings-card .form-check-label {
        color: var(--admin-text);
    }

    .chatbot-save-row .btn-primary {
        background: linear-gradient(135deg, var(--admin-primary), #e5c158);
        border-color: transparent;
        color: #0d0d0d;
        font-weight: 700;
    }

    .chatbot-save-row .btn-primary:hover,
    .chatbot-save-row .btn-primary:focus {
        background: linear-gradient(135deg, var(--admin-primary-hover), #d4af37);
        color: #0d0d0d;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="card border-0 chatbot-settings-card">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <div>
                            <h2 class="h4 mb-1">Assistant Behavior</h2>
                            <p class="text-muted mb-0">Tune answers, safety, and model behavior for a better customer chat experience.</p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span id="chatbotRuntimeStatus" class="chatbot-status-pill {{ old('chatbot_enabled', $settings['chatbot_enabled'] ?? '0') === '1' ? 'enabled' : 'disabled' }}">
                                <i class="bi {{ old('chatbot_enabled', $settings['chatbot_enabled'] ?? '0') === '1' ? 'bi-check-circle-fill' : 'bi-slash-circle-fill' }}"></i>
                                <span>{{ old('chatbot_enabled', $settings['chatbot_enabled'] ?? '0') === '1' ? 'Live on homepage' : 'Hidden from homepage' }}</span>
                            </span>
                            <span class="chatbot-mini-chip"><i class="bi bi-shield-check"></i> Safe Mode Config</span>
                        </div>
                    </div>

                    @php
                        $fabIconOptions = \App\Models\SiteSetting::CHATBOT_FAB_ICON_OPTIONS;
                        $selectedFabIcon = old('chatbot_fab_icon', $settings['chatbot_fab_icon'] ?? 'chat-dots');
                    @endphp

                    <form method="POST" action="{{ route('admin.chatbot.update') }}" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-12 chatbot-section">
                            <div class="chatbot-section-title">
                                <i class="bi bi-eye-fill"></i>
                                <span>Visibility</span>
                            </div>
                            <p class="chatbot-section-desc">Control if the chatbot widget appears on the homepage.</p>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="chatbot_enabled" name="chatbot_enabled" value="1" @checked(old('chatbot_enabled', $settings['chatbot_enabled'] ?? '0') === '1')>
                                <label class="form-check-label fw-semibold" for="chatbot_enabled">Enable chatbot on homepage</label>
                            </div>
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-2">
                                <p class="chatbot-help mb-0">When disabled, all public chatbot replies are blocked and users will not see the widget.</p>
                                <a href="{{ route('home') }}" target="_blank" rel="noopener" class="chatbot-quick-link">Preview homepage <i class="bi bi-box-arrow-up-right"></i></a>
                            </div>
                        </div>

                        <div class="col-12 chatbot-section" data-requires-enabled="true">
                            <div class="chatbot-section-title">
                                <i class="bi bi-person-badge"></i>
                                <span>Assistant Identity</span>
                            </div>
                            <p class="chatbot-section-desc">Set the displayed name and first message users will see.</p>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="chatbot_name" class="form-label fw-semibold">Assistant Name</label>
                                    <input type="text" id="chatbot_name" name="chatbot_name" class="form-control @error('chatbot_name') is-invalid @enderror" value="{{ old('chatbot_name', $settings['chatbot_name'] ?? '') }}" maxlength="80" required>
                                    @error('chatbot_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="chatbot_model" class="form-label fw-semibold">Hugging Face Model ID</label>
                                    <input type="text" id="chatbot_model" name="chatbot_model" class="form-control @error('chatbot_model') is-invalid @enderror" value="{{ old('chatbot_model', $settings['chatbot_model'] ?? '') }}" required>
                                    <p class="chatbot-help mb-0">Use a chat-capable model. Example: meta-llama/Llama-3.1-8B-Instruct:fastest</p>
                                    <div class="chatbot-inline-actions">
                                        <button type="button" class="chatbot-pill-btn" data-model-value="meta-llama/Llama-3.1-8B-Instruct:fastest">Llama 3.1 8B</button>
                                        <button type="button" class="chatbot-pill-btn" data-model-value="openai/gpt-oss-120b:fastest">GPT OSS 120B</button>
                                        <button type="button" class="chatbot-pill-btn" data-model-value="deepseek-ai/DeepSeek-R1:fastest">DeepSeek R1</button>
                                    </div>
                                    @error('chatbot_model')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold d-block mb-2">Chat Button Icon</label>
                                    <div class="chatbot-icon-grid">
                                        @foreach($fabIconOptions as $iconKey => $iconOption)
                                            <div>
                                                <input
                                                    class="chatbot-icon-option-input"
                                                    type="radio"
                                                    name="chatbot_fab_icon"
                                                    id="chatbot_fab_icon_{{ $iconKey }}"
                                                    value="{{ $iconKey }}"
                                                    @checked($selectedFabIcon === $iconKey)
                                                >
                                                <label class="chatbot-icon-option" for="chatbot_fab_icon_{{ $iconKey }}">
                                                    <i class="bi {{ $iconOption['icon'] }}"></i>
                                                    <span>{{ $iconOption['label'] }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('chatbot_fab_icon')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="chatbot_welcome_message" class="form-label fw-semibold">Welcome Message</label>
                                    <textarea id="chatbot_welcome_message" name="chatbot_welcome_message" rows="2" class="form-control @error('chatbot_welcome_message') is-invalid @enderror" maxlength="400" required>{{ old('chatbot_welcome_message', $settings['chatbot_welcome_message'] ?? '') }}</textarea>
                                    <div class="chatbot-inline-actions">
                                        <button type="button" class="chatbot-pill-btn" data-welcome-value="Hi! Looking for a quick menu recommendation?">Quick recommendation tone</button>
                                        <button type="button" class="chatbot-pill-btn" data-welcome-value="Welcome! I can help with menu items, opening hours, and contact info.">Info assistant tone</button>
                                    </div>
                                    <div class="chatbot-counter" data-counter-target="chatbot_welcome_message"></div>
                                    @error('chatbot_welcome_message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="chatbot-preview">
                                        <div class="chatbot-preview-label">Live Preview</div>
                                        <div class="chatbot-preview-bubble" id="chatbotWelcomePreview">{{ old('chatbot_welcome_message', $settings['chatbot_welcome_message'] ?? '') }}</div>
                                    </div>
                                </div>
                            </div>

                            <div id="chatbotDisabledNote" class="chatbot-disabled-note d-none">
                                This section is inactive while chatbot visibility is turned off.
                            </div>
                        </div>

                        <div class="col-12 chatbot-section" data-requires-enabled="true">
                            <div class="chatbot-section-title">
                                <i class="bi bi-journal-richtext"></i>
                                <span>Knowledge and Safety</span>
                            </div>
                            <p class="chatbot-section-desc">Define what the assistant knows and what it must avoid.</p>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="chatbot_knowledge" class="form-label fw-semibold">AI Knowledge Base</label>
                                    <textarea id="chatbot_knowledge" name="chatbot_knowledge" rows="5" class="form-control @error('chatbot_knowledge') is-invalid @enderror" maxlength="5000" placeholder="Write core facts about your menu, service, and store policies.">{{ old('chatbot_knowledge', $settings['chatbot_knowledge'] ?? '') }}</textarea>
                                    <p class="chatbot-help mb-0">Include opening hours, best sellers, delivery areas, and payment options.</p>
                                    <div class="chatbot-counter" data-counter-target="chatbot_knowledge"></div>
                                    @error('chatbot_knowledge')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="chatbot_restrictions" class="form-label fw-semibold">Safety Restrictions</label>
                                    <textarea id="chatbot_restrictions" name="chatbot_restrictions" rows="4" class="form-control @error('chatbot_restrictions') is-invalid @enderror" maxlength="3000" placeholder="Define what the bot should refuse or avoid.">{{ old('chatbot_restrictions', $settings['chatbot_restrictions'] ?? '') }}</textarea>
                                    <p class="chatbot-help mb-0">Add hard boundaries such as no medical advice, no legal guidance, and no unsafe instructions.</p>
                                    <div class="chatbot-counter" data-counter-target="chatbot_restrictions"></div>
                                    @error('chatbot_restrictions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 chatbot-section" data-requires-enabled="true">
                            <div class="chatbot-section-title">
                                <i class="bi bi-sliders"></i>
                                <span>Response Tuning</span>
                            </div>
                            <p class="chatbot-section-desc">Balance response creativity and length.</p>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="chatbot_temperature" class="form-label fw-semibold">Temperature</label>
                                    <div class="chatbot-range-wrap">
                                        <div class="chatbot-range-row">
                                            <input type="range" min="0" max="1.5" step="0.1" value="{{ old('chatbot_temperature', $settings['chatbot_temperature'] ?? '0.4') }}" data-sync-target="chatbot_temperature">
                                            <span class="chatbot-range-value" data-sync-label="chatbot_temperature">{{ old('chatbot_temperature', $settings['chatbot_temperature'] ?? '0.4') }}</span>
                                        </div>
                                        <input type="number" step="0.1" min="0" max="1.5" id="chatbot_temperature" name="chatbot_temperature" class="form-control @error('chatbot_temperature') is-invalid @enderror" value="{{ old('chatbot_temperature', $settings['chatbot_temperature'] ?? '0.4') }}" required>
                                    </div>
                                    <p class="chatbot-help mb-0">Lower is more consistent. Higher is more creative.</p>
                                    @error('chatbot_temperature')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="chatbot_max_tokens" class="form-label fw-semibold">Max Response Tokens</label>
                                    <div class="chatbot-range-wrap">
                                        <div class="chatbot-range-row">
                                            <input type="range" min="50" max="600" step="10" value="{{ old('chatbot_max_tokens', $settings['chatbot_max_tokens'] ?? '180') }}" data-sync-target="chatbot_max_tokens">
                                            <span class="chatbot-range-value" data-sync-label="chatbot_max_tokens">{{ old('chatbot_max_tokens', $settings['chatbot_max_tokens'] ?? '180') }}</span>
                                        </div>
                                        <input type="number" min="50" max="600" id="chatbot_max_tokens" name="chatbot_max_tokens" class="form-control @error('chatbot_max_tokens') is-invalid @enderror" value="{{ old('chatbot_max_tokens', $settings['chatbot_max_tokens'] ?? '180') }}" required>
                                    </div>
                                    <p class="chatbot-help mb-0">Higher values allow longer replies.</p>
                                    @error('chatbot_max_tokens')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 chatbot-save-row d-flex flex-wrap justify-content-end gap-2">
                            <span id="chatbotDirtyState" class="chatbot-status-pill enabled d-none">
                                <i class="bi bi-pencil-square"></i>
                                <span>Unsaved changes</span>
                            </span>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-2"></i>Save Chatbot Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card border-0 chatbot-settings-card">
                <div class="card-body p-4">
                    <h3 class="h5 mb-3">Usage Tips</h3>
                    <ul class="mb-0 text-muted ps-3">
                        <li>Keep knowledge factual and short for better responses.</li>
                        <li>Add strict restrictions for sensitive topics.</li>
                        <li>Use lower temperature for consistent replies.</li>
                        <li>Set max tokens to control response length and cost.</li>
                        <li>Keep your Hugging Face token in environment variables only.</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 chatbot-settings-card mt-3">
                <div class="card-body p-4">
                    <h3 class="h6 mb-3">One-Click Assistant Presets</h3>
                    <div class="chatbot-preset-grid">
                        <button type="button" class="chatbot-preset-btn" data-chatbot-preset="balanced">
                            <span class="chatbot-preset-title"><i class="bi bi-stars me-1"></i>Balanced Helper</span>
                            <span class="chatbot-preset-text">Best default for menu suggestions, opening hours, and contact guidance.</span>
                        </button>

                        <button type="button" class="chatbot-preset-btn" data-chatbot-preset="strict">
                            <span class="chatbot-preset-title"><i class="bi bi-shield-lock me-1"></i>Strict Safety</span>
                            <span class="chatbot-preset-text">Lower creativity, tighter restrictions, safer responses for public use.</span>
                        </button>

                        <button type="button" class="chatbot-preset-btn" data-chatbot-preset="creative">
                            <span class="chatbot-preset-title"><i class="bi bi-lightbulb me-1"></i>Creative Seller</span>
                            <span class="chatbot-preset-text">Higher personality and persuasive product suggestions for marketing tone.</span>
                        </button>
                    </div>

                    <div id="chatbotPresetFeedback" class="chatbot-preset-feedback d-none"></div>

                    <div class="small text-muted mt-3 mb-0">
                        Tap a preset, review changes in the form, then save.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const targets = document.querySelectorAll('[data-counter-target]');

        targets.forEach((counter) => {
            const inputId = counter.getAttribute('data-counter-target');
            const input = document.getElementById(inputId);

            if (!input) {
                return;
            }

            const render = () => {
                const max = Number(input.getAttribute('maxlength') || 0);
                const used = input.value.length;
                counter.textContent = max > 0 ? `${used}/${max}` : `${used}`;
            };

            input.addEventListener('input', render);
            render();
        });

        const welcomeInput = document.getElementById('chatbot_welcome_message');
        const welcomePreview = document.getElementById('chatbotWelcomePreview');
        const enabledToggle = document.getElementById('chatbot_enabled');
        const dependantSections = document.querySelectorAll('[data-requires-enabled="true"]');
        const statusPill = document.getElementById('chatbotRuntimeStatus');
        const disabledNote = document.getElementById('chatbotDisabledNote');
        const modelInput = document.getElementById('chatbot_model');
        const dirtyState = document.getElementById('chatbotDirtyState');
        const knowledgeInput = document.getElementById('chatbot_knowledge');
        const restrictionsInput = document.getElementById('chatbot_restrictions');
        const temperatureInput = document.getElementById('chatbot_temperature');
        const maxTokensInput = document.getElementById('chatbot_max_tokens');
        const presetFeedback = document.getElementById('chatbotPresetFeedback');

        const setEnabledState = () => {
            if (!enabledToggle) {
                return;
            }

            const enabled = enabledToggle.checked;

            dependantSections.forEach((section) => {
                section.classList.toggle('is-disabled', !enabled);
                section.querySelectorAll('input, textarea, select, button').forEach((element) => {
                    if (element.id === 'chatbot_enabled') {
                        return;
                    }

                    if (element.dataset.keepEnabled === 'true') {
                        return;
                    }

                    element.disabled = !enabled;
                });
            });

            if (disabledNote) {
                disabledNote.classList.toggle('d-none', enabled);
            }

            if (statusPill) {
                statusPill.classList.toggle('enabled', enabled);
                statusPill.classList.toggle('disabled', !enabled);
                statusPill.innerHTML = enabled
                    ? '<i class="bi bi-check-circle-fill"></i><span>Live on homepage</span>'
                    : '<i class="bi bi-slash-circle-fill"></i><span>Hidden from homepage</span>';
            }
        };

        const markDirty = () => {
            if (dirtyState) {
                dirtyState.classList.remove('d-none');
            }
        };

        if (welcomeInput && welcomePreview) {
            welcomeInput.addEventListener('input', () => {
                const next = welcomeInput.value.trim();
                welcomePreview.textContent = next !== '' ? next : 'Your welcome message preview will appear here.';
            });
        }

        document.querySelectorAll('[data-model-value]').forEach((button) => {
            button.dataset.keepEnabled = 'true';

            button.addEventListener('click', () => {
                if (!modelInput) {
                    return;
                }

                modelInput.value = String(button.dataset.modelValue || '');
                modelInput.dispatchEvent(new Event('input', { bubbles: true }));
            });
        });

        document.querySelectorAll('[data-welcome-value]').forEach((button) => {
            button.dataset.keepEnabled = 'true';

            button.addEventListener('click', () => {
                if (!welcomeInput) {
                    return;
                }

                welcomeInput.value = String(button.dataset.welcomeValue || '');
                welcomeInput.dispatchEvent(new Event('input', { bubbles: true }));
            });
        });

        document.querySelectorAll('[data-sync-target]').forEach((rangeInput) => {
            const targetId = rangeInput.getAttribute('data-sync-target');

            if (!targetId) {
                return;
            }

            const numberInput = document.getElementById(targetId);
            const label = document.querySelector(`[data-sync-label="${targetId}"]`);

            if (!numberInput) {
                return;
            }

            const render = (value) => {
                if (label) {
                    label.textContent = String(value);
                }
            };

            rangeInput.addEventListener('input', () => {
                numberInput.value = rangeInput.value;
                render(rangeInput.value);
            });

            numberInput.addEventListener('input', () => {
                rangeInput.value = numberInput.value;
                render(numberInput.value);
            });

            render(numberInput.value);
        });

        const presetConfigs = {
            balanced: {
                welcome: 'Hi! I can help you choose the best meal, check opening hours, and share quick store info.',
                knowledge: 'Pita Queen serves premium Mediterranean meals including shawarma wraps, grilled platters, rice bowls, and signature sauces. Share clear menu guidance, store hours, locations, and contact options. For final order changes, advise customers to use official ordering channels.',
                restrictions: 'Do not provide medical, legal, or financial advice. Refuse unsafe or harmful instructions. If uncertain, say you are not fully sure and guide users to contact the restaurant.',
                temperature: '0.4',
                maxTokens: '180',
                label: 'Balanced Helper preset applied.',
            },
            strict: {
                welcome: 'Welcome. I can provide concise menu details and official store information.',
                knowledge: 'Focus on objective business information: menu categories, prices when available, opening hours, location, contact details, and ordering guidance. Keep replies short and factual.',
                restrictions: 'Never provide harmful instructions. Never guess unknown facts. Avoid off-topic advice. Refuse medical, legal, financial, or dangerous content. Always prioritize safety and official store channels.',
                temperature: '0.2',
                maxTokens: '140',
                label: 'Strict Safety preset applied.',
            },
            creative: {
                welcome: 'Hey there! Tell me your craving and I will suggest the perfect Pita Queen combo.',
                knowledge: 'Pita Queen offers shawarma wraps, bowls, grill plates, sides, and refreshing drinks with bold Mediterranean flavor. Highlight upsells like fries, sauces, and combo bundles when relevant.',
                restrictions: 'Stay family-friendly and safe. Do not provide medical, legal, or harmful advice. Keep suggestions realistic and avoid making promises about unavailable items.',
                temperature: '0.8',
                maxTokens: '240',
                label: 'Creative Seller preset applied.',
            },
        };

        document.querySelectorAll('[data-chatbot-preset]').forEach((button) => {
            button.addEventListener('click', () => {
                const presetKey = String(button.getAttribute('data-chatbot-preset') || '');
                const preset = presetConfigs[presetKey];

                if (!preset || !welcomeInput || !knowledgeInput || !restrictionsInput || !temperatureInput || !maxTokensInput) {
                    return;
                }

                welcomeInput.value = preset.welcome;
                knowledgeInput.value = preset.knowledge;
                restrictionsInput.value = preset.restrictions;
                temperatureInput.value = preset.temperature;
                maxTokensInput.value = preset.maxTokens;

                [welcomeInput, knowledgeInput, restrictionsInput, temperatureInput, maxTokensInput].forEach((field) => {
                    field.dispatchEvent(new Event('input', { bubbles: true }));
                    field.dispatchEvent(new Event('change', { bubbles: true }));
                });

                if (presetFeedback) {
                    presetFeedback.textContent = preset.label;
                    presetFeedback.classList.remove('d-none');
                }

                markDirty();
            });
        });

        if (enabledToggle) {
            enabledToggle.addEventListener('change', () => {
                setEnabledState();
                markDirty();
            });
        }

        document.querySelectorAll('form input, form textarea, form select').forEach((field) => {
            field.addEventListener('input', markDirty);
            field.addEventListener('change', markDirty);
        });

        setEnabledState();
    })();
</script>
@endpush
