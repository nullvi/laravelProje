@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Add New Hotel</h1>
        <a href="{{ route('manager.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <i class="fas fa-hotel"></i> Hotel Details
        </div>
        <div class="card-body">
            <form action="{{ route('manager.hotels.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Hotel Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="location" class="form-label">Location/City</label>
                        <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Full Address</label>
                    <textarea class="form-control" id="address" name="address" rows="2" required>{{ old('address') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                    <div class="form-text">Describe your hotel, its amenities, unique features, etc.</div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Hotel Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <div class="form-text">Upload a high-quality image of your hotel (max 2MB).</div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
                    <label class="form-check-label" for="is_active">Make this hotel active immediately</label>
                </div>

                <button type="submit" class="btn btn-primary">Create Hotel</button>
            </form>
        </div>
    </div>
</div>
@endsection
