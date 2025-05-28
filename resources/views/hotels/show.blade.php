@extends('layouts.app')

@section('title', $hotel->name ?? 'Hotel Details')

@section('content')
<div class="container py-4">
    @if(isset($hotel))
        <div class="row">
            <div class="col-lg-8">
                <!-- Hotel Image -->
                @if($hotel->image)
                    <img src="{{ Storage::url($hotel->image) }}" class="img-fluid rounded mb-4 shadow" alt="{{ $hotel->name }}">
                @else
                    <img src="https://via.placeholder.com/800x500.png?text=Image+Not+Available" class="img-fluid rounded mb-4 shadow" alt="No Image">
                @endif

                <!-- Hotel Details -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h1 class="card-title display-5">{{ $hotel->name }}</h1>
                        <p class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>{{ $hotel->location }} - {{ $hotel->address }}</p>
                        @if($hotel->rating > 0)
                            <p class="mb-2">
                                <strong class="me-2">Rating:</strong>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= round($hotel->rating) ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                                <span class="ms-1">({{ number_format($hotel->rating, 1) }}/5.0)</span>
                            </p>
                        @endif
                        <hr>
                        <h5 class="mt-4">About this hotel</h5>
                        <p class="card-text">{{ $hotel->description }}</p>
                    </div>
                </div>

                <!-- Available Rooms -->
                <h2 class="mb-4">Available Rooms</h2>
                @if(isset($rooms) && $rooms->count() > 0)
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        @foreach($rooms as $room)
                            <div class="col">
                                <div class="card h-100 shadow-sm room-card">
                                    @if($room->image)
                                        <img src="{{ Storage::url($room->image) }}" class="card-img-top" alt="{{ $room->name }}" style="height: 200px; object-fit: cover;">
                                    @else
                                        <img src="https://via.placeholder.com/400x250.png?text=Room+Image" class="card-img-top" alt="No Room Image" style="height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $room->name }}</h5>
                                        <p class="card-text">Kapasite: {{ $room->capacity }} kişi</p>
                                        <p class="card-text">{{ Str::limit($room->description, 80) }}</p>
                                        <div class="mb-2">
                                            @if($room->has_wifi)
                                                <span class="badge bg-info me-1"><i class="fas fa-wifi"></i> WiFi</span>
                                            @endif
                                            @if($room->has_ac)
                                                <span class="badge bg-info me-1"><i class="fas fa-snowflake"></i> Klima</span>
                                            @endif
                                            @if($room->has_tv)
                                                <span class="badge bg-info me-1"><i class="fas fa-tv"></i> TV</span>
                                            @endif
                                            @if($room->has_fridge)
                                                <span class="badge bg-info me-1"><i class="fas fa-box"></i> Buzdolabı</span>
                                            @endif
                                        </div>
                                        <h6 class="card-subtitle mb-2 text-success fw-bold">₺{{ number_format($room->price_per_night, 2) }} / gece</h6>
                                        @if($room->is_available)
                                            <a href="{{ route('reservations.create', $room->id) }}" class="btn btn-primary mt-auto">Rezervasyon Yap</a>
                                        @else
                                            <button class="btn btn-secondary mt-auto" disabled>Müsait Değil</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        <p class="lead mb-0">Bu otel için şu anda müsait oda bulunmamaktadır.</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar / Additional Info -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Hotel Information</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <strong>Location:</strong> {{ $hotel->location }}
                        </div>
                        <div class="list-group-item">
                            <strong>Address:</strong> {{ $hotel->address }}
                        </div>
                        @if($hotel->rating > 0)
                        <div class="list-group-item">
                            <strong>Rating:</strong> {{ number_format($hotel->rating, 1) }} / 5.0
                        </div>
                        @endif
                        <div class="list-group-item">
                            <a href="#" class="btn btn-outline-primary w-100"><i class="fas fa-phone me-2"></i>Contact Hotel</a>
                        </div>
                        <div class="list-group-item">
                            <a href="{{ route('hotels.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-arrow-left me-2"></i>Back to Hotels</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger text-center">
            <h4 class="alert-heading">Hotel Not Found!</h4>
            <p>The hotel you are looking for could not be found. It might have been removed or the link is incorrect.</p>
            <hr>
            <p class="mb-0">Please <a href="{{ route('hotels.index') }}" class="alert-link">return to the hotel list</a> and try again.</p>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .room-card {
        transition: transform .2s ease-in-out, box-shadow .2s ease-in-out;
    }
    .room-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
    }
    .display-5 {
        font-weight: 300;
    }
</style>
@endpush
