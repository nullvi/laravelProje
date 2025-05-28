@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Hotel</h1>
        <a href="{{ route('manager.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-hotel"></i> Hotel Details
        </div>
        <div class="card-body">
            <form action="{{ route('manager.hotels.update', $hotel) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Hotel Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $hotel->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="location" class="form-label">Location/City</label>
                        <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $hotel->location) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Full Address</label>
                    <textarea class="form-control" id="address" name="address" rows="2" required>{{ old('address', $hotel->address) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $hotel->description) }}</textarea>
                    <div class="form-text">Describe your hotel, its amenities, unique features, etc.</div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Hotel Image</label>
                    @if($hotel->image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($hotel->image) }}" alt="{{ $hotel->name }}" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <div class="form-text">Upload a new image to replace the current one (max 2MB).</div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ $hotel->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Hotel is active and visible to customers</label>
                </div>

                <button type="submit" class="btn btn-primary">Update Hotel</button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-warning text-white">
            <i class="fas fa-trash"></i> Danger Zone
        </div>
        <div class="card-body">
            <h5>Delete this hotel</h5>
            <p>Once you delete a hotel, all of its rooms and reservations will be removed. This action cannot be undone.</p>

            <form action="{{ route('manager.hotels.destroy', $hotel) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this hotel? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Hotel</button>
            </form>
        </div>
    </div>
</div>
@endsection
