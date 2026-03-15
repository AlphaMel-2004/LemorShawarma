@extends('layouts.admin')

@section('title', 'Testimonials')
@section('page-title', 'Testimonials')

@push('styles')
<style>
    .testimonial-message-preview {
        max-width: 360px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .testimonial-rating {
        color: var(--admin-warning);
        letter-spacing: 1px;
        white-space: nowrap;
    }

    .testimonial-status {
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 999px;
        padding: 0.3rem 0.65rem;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .testimonial-status-visible {
        background: rgba(34, 197, 94, 0.15);
        color: var(--admin-success);
    }

    .testimonial-status-hidden {
        background: rgba(239, 68, 68, 0.15);
        color: var(--admin-danger);
    }
</style>
@endpush

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <form method="GET" action="{{ route('admin.testimonials.index') }}" class="d-flex flex-wrap align-items-center gap-2">
        <div class="search-wrapper">
            <i class="bi bi-search"></i>
            <input type="text" class="admin-search" name="search" placeholder="Search testimonials..." value="{{ request('search') }}">
        </div>

        <select class="admin-form-select" name="rating" style="width: auto; min-width: 140px;">
            <option value="">All Ratings</option>
            @for($rating = 5; $rating >= 1; $rating--)
                <option value="{{ $rating }}" @selected((string) request('rating') === (string) $rating)>{{ $rating }} Stars</option>
            @endfor
        </select>

        <select class="admin-form-select" name="visibility" style="width: auto; min-width: 150px;">
            <option value="">All Visibility</option>
            <option value="visible" @selected(request('visibility') === 'visible')>Visible</option>
            <option value="hidden" @selected(request('visibility') === 'hidden')>Hidden</option>
        </select>

        <button type="submit" class="btn-admin-primary">
            <i class="bi bi-funnel-fill me-1"></i> Filter
        </button>

        @if(request()->filled('search') || request()->filled('rating') || request()->filled('visibility'))
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle me-1"></i> Clear
            </a>
        @endif
    </form>
</div>

@if(session('status'))
    <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        <span>{{ session('status') }}</span>
    </div>
@endif

<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Rating</th>
                    <th>Visibility</th>
                    <th>Message</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $testimonial)
                    <tr>
                        <td class="fw-semibold">{{ $testimonial->customer_name }}</td>
                        <td>{{ $testimonial->customer_email ?: '—' }}</td>
                        <td>
                            <div class="testimonial-rating" aria-label="{{ $testimonial->rating }} out of 5 stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $testimonial->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </div>
                        </td>
                        <td>
                            @if($testimonial->is_visible)
                                <span class="testimonial-status testimonial-status-visible">
                                    <i class="bi bi-eye-fill"></i> Visible
                                </span>
                            @else
                                <span class="testimonial-status testimonial-status-hidden">
                                    <i class="bi bi-eye-slash-fill"></i> Hidden
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="testimonial-message-preview" title="{{ $testimonial->message }}">
                                {{ $testimonial->message }}
                            </span>
                        </td>
                        <td class="text-muted" style="font-size: 0.85rem;">{{ $testimonial->created_at->format('M d, Y h:i A') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_visible" value="{{ $testimonial->is_visible ? 0 : 1 }}">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="rating" value="{{ request('rating') }}">
                                <input type="hidden" name="visibility" value="{{ request('visibility') }}">
                                <input type="hidden" name="page" value="{{ request('page') }}">
                                <button type="submit" class="btn-action" title="{{ $testimonial->is_visible ? 'Hide testimonial' : 'Show testimonial' }}">
                                    <i class="bi {{ $testimonial->is_visible ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Delete this testimonial?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-action-danger" title="Delete">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div style="color: var(--admin-text-muted);">
                                <i class="bi bi-chat-square-text" style="font-size: 2.5rem; display: block; margin-bottom: 0.75rem;"></i>
                                <p class="mb-0">No testimonials found.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($testimonials->hasPages())
    <div class="mt-3">
        {{ $testimonials->links() }}
    </div>
@endif
@endsection
