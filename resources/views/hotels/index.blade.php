@extends('layouts.app')

@section('title', 'Available Hotels')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">Explore Our Hotels</h1>
            <p class="lead">Find the perfect place for your next stay.</p>
        </div>
    </div>

    <!-- Search and Filter Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form action="{{ route('hotels.index') }}" method="GET" class="card p-3 shadow-sm">
                <div class="row g-3">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Search by hotel name or location..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="location" class="form-control" placeholder="Filter by location..." value="{{ request('location') }}">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(isset($hotels) && $hotels->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($hotels as $hotel)
                <div class="col">
                    <div class="card h-100 shadow-sm hotel-card">
                        @if($hotel->image)
                            <img src="{{ Storage::url($hotel->image) }}" class="card-img-top" alt="{{ $hotel->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/400x250.png?text=No+Image+Available" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $hotel->name }}</h5>
                            <p class="card-text text-muted"><i class="fas fa-map-marker-alt me-2"></i>{{ $hotel->location }}</p>
                            <p class="card-text flex-grow-1">{{ Str::limit($hotel->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <a href="{{ route('hotels.show', $hotel->id) }}" class="btn btn-primary">View Details</a>
                                @if($hotel->rating > 0)
                                    <span class="badge bg-warning text-dark">Rating: {{ number_format($hotel->rating, 1) }}/5.0</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $hotels->appends(request()->query())->links() }}
        </div>
    @else
        <div class="col-12">
            <div class="alert alert-info text-center">
                <p class="lead mb-0">No hotels found matching your criteria. Try adjusting your search or filters.</p>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .hotel-card {
        transition: transform .2s ease-in-out, box-shadow .2s ease-in-out;
    }
    .hotel-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
    .display-4 {
        font-weight: 300;
    }
</style>
@endpush
