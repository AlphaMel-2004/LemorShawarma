@extends('layouts.admin')

@section('title', 'Locations')
@section('page-title', 'Manage Locations')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <form method="GET" action="{{ route('admin.locations.index') }}" class="d-flex flex-wrap align-items-center gap-2">
        <div class="search-wrapper">
            <i class="bi bi-search"></i>
            <input type="text" class="admin-search" name="search" placeholder="Search locations..." value="{{ request('search') }}">
        </div>

        <select class="admin-form-select" name="status" style="width: auto; min-width: 140px;">
            <option value="">All Status</option>
            <option value="active" @selected(request('status') === 'active')>Active</option>
            <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
        </select>

        <button type="submit" class="btn-admin-primary">
            <i class="bi bi-funnel-fill me-1"></i> Filter
        </button>

        @if(request()->filled('search') || request()->filled('status'))
            <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle me-1"></i> Clear
            </a>
        @endif
    </form>

    <button type="button" class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#addLocationModal">
        <i class="bi bi-plus-lg me-1"></i> Add Location
    </button>
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
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($locations as $location)
                    <tr>
                        <td class="fw-semibold">{{ $location->name }}</td>
                        <td>
                            <span class="text-description-preview d-inline-block" style="max-width: 280px;" title="{{ $location->address }}">
                                {{ $location->address }}
                            </span>
                        </td>
                        <td>{{ $location->phone }}</td>
                        <td>
                            @if($location->is_active)
                                <span class="badge-status badge-active">Active</span>
                            @else
                                <span class="badge-status badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $location->latitude }},{{ $location->longitude }}" class="btn-action" title="Open in Maps" target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-map"></i>
                                </a>
                                <button type="button" class="btn-action" title="Edit" data-bs-toggle="modal" data-bs-target="#editLocationModal-{{ $location->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.locations.destroy', $location) }}" onsubmit="return confirm('Delete this location?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-action-danger" title="Delete">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div style="color: var(--admin-text-muted);">
                                <i class="bi bi-geo-alt" style="font-size: 2.5rem; display: block; margin-bottom: 0.75rem;"></i>
                                <p class="mb-0">No locations found.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($locations->hasPages())
    <div class="mt-3">
        {{ $locations->links() }}
    </div>
@endif

@foreach($locations as $location)
    <div class="modal fade" id="editLocationModal-{{ $location->id }}" tabindex="-1" aria-labelledby="editLocationModalLabel-{{ $location->id }}" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLocationModalLabel-{{ $location->id }}">Edit Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.locations.update', $location) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.locations._form', ['location' => $location, 'isModal' => true, 'formId' => 'edit-location-'.$location->id])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<div class="modal fade" id="addLocationModal" tabindex="-1" aria-labelledby="addLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLocationModalLabel">Add Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.locations.store') }}" enctype="multipart/form-data">
                    @csrf
                    @include('admin.locations._form', ['location' => null, 'isModal' => true, 'formId' => 'add-location'])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
