@extends('layouts.app')

@section('title', 'Terms of Service - Pita Queen')
@section('meta_description', 'Terms of Service for Pita Queen website use, menu information, food-service disclaimers, and legal limitations.')
@section('canonical', route('legal.terms'))
@section('meta_robots', 'index, follow')
@section('hide_layout_chrome', '1')

@section('structured_data')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "WebPage",
            "name": "Terms of Service",
            "url": "{{ route('legal.terms') }}",
            "description": "Terms of Service for Pita Queen website visitors and customers.",
            "isPartOf": {
                "@@type": "WebSite",
                "name": "{{ config('app.name') }}",
                "url": "{{ route('home') }}"
            }
        }
    </script>
@endsection

@push('styles')
    <style>
        .legal-page {
            background: var(--color-black-light);
            min-height: 70vh;
            padding-top: 90px;
        }

        .legal-top-links {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
            margin: 1.25rem 0 1.5rem;
        }

        .legal-link-chip {
            display: inline-flex;
            align-items: center;
            border: 1px solid rgba(212, 175, 55, 0.35);
            border-radius: 999px;
            padding: 0.35rem 0.8rem;
            font-size: 0.82rem;
            color: var(--color-text-secondary);
            background: rgba(212, 175, 55, 0.08);
        }

        .legal-link-chip:hover {
            color: var(--color-gold);
            border-color: rgba(212, 175, 55, 0.6);
        }

        .legal-page .legal-updated {
            color: var(--color-text-secondary) !important;
            font-size: 0.95rem;
        }

        .legal-summary {
            border: 1px solid rgba(212, 175, 55, 0.22);
            background: rgba(212, 175, 55, 0.06);
            border-radius: 14px;
            padding: 1rem 1rem 0.9rem;
        }

        .legal-summary h2 {
            color: var(--color-gold);
            font-size: 1.02rem;
            margin-bottom: 0.65rem;
        }

        .legal-summary ul {
            margin: 0;
            padding-left: 1rem;
            color: var(--color-text-secondary);
        }

        .legal-summary li {
            margin-bottom: 0.35rem;
        }

        .legal-section {
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 1rem;
            background: rgba(0, 0, 0, 0.16);
        }

        .legal-page .legal-content h2 {
            color: var(--color-gold);
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .legal-page .legal-content p {
            color: var(--color-text-secondary);
            margin-bottom: 0;
        }
    </style>
@endpush

@section('content')
    <section class="section-padding legal-page">
        <div class="container" style="max-width: 840px;">
            <div class="mb-4">
                <span class="section-badge">Legal</span>
                <h1 class="section-title mt-3">Terms of Service</h1>
                <p class="legal-updated mb-0">Last updated: {{ $lastUpdated }}</p>
                <p class="legal-updated mt-2 mb-0">{{ $introText }}</p>
            </div>

            <div class="legal-top-links" aria-label="Legal page links">
                <a class="legal-link-chip" href="{{ route('home') }}">Back to Website</a>
                <a class="legal-link-chip" href="{{ route('legal.privacy') }}">Privacy Policy</a>
                <a class="legal-link-chip" href="{{ route('legal.cookies') }}">Cookie Policy</a>
            </div>

            <div class="legal-summary mb-4">
                <h2>Quick Summary</h2>
                <ul>
                    @foreach($summaryItems as $summaryItem)
                        <li>{{ $summaryItem }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="contact-form legal-content" style="display: grid; gap: 1.5rem;">
                @foreach($sections as $section)
                    <div class="legal-section">
                        <h2 style="font-size: 1.2rem;">{{ $section['heading'] }}</h2>
                        @foreach($section['paragraphs'] as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>
                @endforeach

                <div class="legal-section">
                    <h2 style="font-size: 1.2rem;">Need help?</h2>
                    <p>You can also review our <a href="{{ route('legal.privacy') }}">Privacy Policy</a> and <a href="{{ route('legal.cookies') }}">Cookie Policy</a>.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
