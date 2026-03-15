@extends('layouts.admin')

@section('title', 'Edit Location')
@section('page-title', 'Edit Location')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Locations
    </a>
</div>

<div class="admin-card">
    <div class="p-4">
        <form method="POST" action="{{ route('admin.locations.update', $location) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.locations._form', ['location' => $location])
        </form>
    </div>
</div>
@endsection
