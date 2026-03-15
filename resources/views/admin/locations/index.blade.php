@extends('layouts.admin')

@section('title', 'Locations')
@section('page-title', 'Manage Locations')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <form method="GET" action="{{ route('admin.locations.index') }}" class="d-flex flex-wrap align-items-center gap-2">
        <div class="search-wrapper">
            <label for="locationSearchInput" class="visually-hidden">Search locations</label>
            <i class="bi bi-search"></i>
            <input type="text" class="admin-search" id="locationSearchInput" name="search" placeholder="Search locations..." value="{{ request('search') }}">
        </div>

        <label for="locationStatusFilter" class="visually-hidden">Filter locations by status</label>
        <select class="admin-form-select" id="locationStatusFilter" name="status" style="width: auto; min-width: 140px;">
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
                                <button
                                    type="button"
                                    class="btn-action"
                                    title="Edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editLocationModal"
                                    data-update-url="{{ route('admin.locations.update', $location) }}"
                                    data-name="{{ $location->name }}"
                                    data-address="{{ $location->address }}"
                                    data-phone="{{ $location->phone }}"
                                    data-hours="{{ $location->hours }}"
                                    data-latitude="{{ $location->latitude }}"
                                    data-longitude="{{ $location->longitude }}"
                                    data-is-active="{{ $location->is_active ? 1 : 0 }}"
                                    data-image-url="{{ $location->image ? $location->image_url : '' }}"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button
                                    type="button"
                                    class="btn-action btn-action-danger"
                                    title="Delete"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteLocationModal"
                                    data-delete-url="{{ route('admin.locations.destroy', $location) }}"
                                    data-delete-label="{{ $location->name }}"
                                >
                                    <i class="bi bi-trash3"></i>
                                </button>
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

<div class="modal fade" id="editLocationModal" tabindex="-1" aria-labelledby="editLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLocationModalLabel">Edit Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editLocationForm" action="{{ route('admin.locations.index') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('admin.locations._form', ['location' => null, 'isModal' => true, 'formId' => 'edit-location'])
                </form>
            </div>
        </div>
    </div>
</div>

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

<div class="modal fade" id="deleteLocationModal" tabindex="-1" aria-labelledby="deleteLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="confirm-icon">
                    <i class="bi bi-trash3"></i>
                </div>
                <h5 class="mb-2" id="deleteLocationModalLabel">Delete Location?</h5>
                <p class="text-muted mb-0" style="font-size: 0.9rem;" id="deleteLocationMessage">This will be moved to archived records.</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" id="deleteLocationForm" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const editLocationModal = document.getElementById('editLocationModal');
    if (editLocationModal) {
        editLocationModal.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const form = document.getElementById('editLocationForm');
            const updateUrl = trigger?.getAttribute('data-update-url') || '';
            const controller = window.locationFormControllers?.['edit-location'];

            if (form && updateUrl) {
                form.setAttribute('action', updateUrl);
            }

            if (controller) {
                controller.setFormData({
                    name: trigger?.getAttribute('data-name') || '',
                    address: trigger?.getAttribute('data-address') || '',
                    phone: trigger?.getAttribute('data-phone') || '',
                    hours: trigger?.getAttribute('data-hours') || '',
                    latitude: trigger?.getAttribute('data-latitude') || '',
                    longitude: trigger?.getAttribute('data-longitude') || '',
                    isActive: trigger?.getAttribute('data-is-active') || '1',
                    imageUrl: trigger?.getAttribute('data-image-url') || '',
                });
            }
        });
    }

    const deleteLocationModal = document.getElementById('deleteLocationModal');
    if (deleteLocationModal) {
        deleteLocationModal.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const form = document.getElementById('deleteLocationForm');
            const message = document.getElementById('deleteLocationMessage');
            const deleteUrl = trigger?.getAttribute('data-delete-url') || '';
            const deleteLabel = trigger?.getAttribute('data-delete-label') || 'this location';

            form.setAttribute('action', deleteUrl);
            message.textContent = `Delete ${deleteLabel}? This will be moved to archived records.`;
        });
    }
</script>
@endpush
