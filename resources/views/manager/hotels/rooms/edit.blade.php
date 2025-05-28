@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Room - {{ $hotel->name }}</h1>
        <a href="{{ route('manager.hotels.rooms.index', $hotel) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Rooms
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
            <i class="fas fa-door-open"></i> Room Details
        </div>
        <div class="card-body">
            <form action="{{ route('manager.hotels.rooms.update', [$hotel, $room]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Room Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $room->name) }}" required>
                        <div class="form-text">Example: "Deluxe Double Room", "Suite 101", etc.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="room_number" class="form-label">Room Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="room_number" name="room_number" value="{{ old('room_number', $room->room_number) }}" required>
                        <div class="form-text">The room number in the hotel (required)</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="price_per_night" class="form-label">Price Per Night (₺)</label>
                        <input type="number" class="form-control" id="price_per_night" name="price_per_night" value="{{ old('price_per_night', $room->price_per_night) }}" min="0" step="0.01" required>
                    </div>

                    <div class="col-md-6">
                        <label for="capacity" class="form-label">Room Capacity</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" value="{{ old('capacity', $room->capacity) }}" min="1" required>
                        <div class="form-text">Maximum number of guests allowed.</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="type" class="form-label">Room Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="" disabled>Select room type</option>
                            <option value="Single" {{ old('type', $room->type) == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Double" {{ old('type', $room->type) == 'Double' ? 'selected' : '' }}>Double</option>
                            <option value="Twin" {{ old('type', $room->type) == 'Twin' ? 'selected' : '' }}>Twin</option>
                            <option value="Suite" {{ old('type', $room->type) == 'Suite' ? 'selected' : '' }}>Suite</option>
                            <option value="Deluxe" {{ old('type', $room->type) == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                            <option value="Family" {{ old('type', $room->type) == 'Family' ? 'selected' : '' }}>Family</option>
                        </select>
                        <div class="form-text">The type of the room.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label">Room Image</label>
                        @if($room->image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($room->image) }}" alt="{{ $room->name }}" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        @endif
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="form-text">Upload a new image to replace the current one (max 2MB).</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $room->description) }}</textarea>
                    <div class="form-text">Describe the room, its features, size, view, etc.</div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Room Amenities</label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="has_wifi" name="has_wifi" {{ old('has_wifi', $room->has_wifi) ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_wifi">
                                <i class="fas fa-wifi me-1"></i> WiFi
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="has_ac" name="has_ac" {{ old('has_ac', $room->has_ac) ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_ac">
                                <i class="fas fa-snowflake me-1"></i> Air Conditioning
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="has_tv" name="has_tv" {{ old('has_tv', $room->has_tv) ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_tv">
                                <i class="fas fa-tv me-1"></i> TV
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="has_fridge" name="has_fridge" {{ old('has_fridge', $room->has_fridge) ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_fridge">
                                <i class="fas fa-box me-1"></i> Refrigerator
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', $room->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Room is available for booking</label>
                </div>

                <button type="submit" class="btn btn-primary">Update Room</button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-warning text-white">
            <i class="fas fa-trash"></i> Danger Zone
        </div>
        <div class="card-body">
            <h5>Delete this room</h5>
            <p>Once you delete a room, all of its reservations will be removed. This action cannot be undone.</p>

            <form action="{{ route('manager.hotels.rooms.destroy', [$hotel, $room]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this room? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Room</button>
            </form>
        </div>
    </div>
</div>
@endsection
