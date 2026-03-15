@extends('layouts.admin')

@section('title', 'Add Location')
@section('page-title', 'Add Location')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Locations
    </a>
</div>

<div class="admin-card">
    <div class="p-4">
        <form method="POST" action="{{ route('admin.locations.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.locations._form', ['location' => null])
        </form>
    </div>
</div>
@endsection
