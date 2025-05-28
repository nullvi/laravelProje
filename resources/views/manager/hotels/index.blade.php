@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Otellerim</h1>
        <a href="{{ route('manager.hotels.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Yeni Otel Ekle
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($hotels->count() > 0)
    <div class="row">
        @foreach($hotels as $hotel)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                @if($hotel->image)
                <img src="{{ Storage::url($hotel->image) }}" class="card-img-top" alt="{{ $hotel->name }}" style="height: 200px; object-fit: cover;">
                @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="fas fa-hotel fa-4x text-muted"></i>
                </div>
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class="card-title">{{ $hotel->name }}</h5>
                        <span class="badge {{ $hotel->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $hotel->is_active ? 'Aktif' : 'Pasif' }}
                        </span>
                    </div>
                    <p class="card-text text-muted mb-2">
                        <i class="fas fa-map-marker-alt me-1"></i> {{ $hotel->location }}
                    </p>
                    <p class="card-text small">
                        {{ Str::limit($hotel->description, 100) }}
                    </p>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-bed me-1"></i> {{ $hotel->rooms->count() }} Oda
                            </small>
                        </div>
                        <div>
                            <a href="{{ route('manager.hotels.edit', $hotel->id) }}" class="btn btn-sm btn-primary me-1">
                                <i class="fas fa-edit"></i> Düzenle
                            </a>
                            <a href="{{ route('manager.hotels.rooms.create', $hotel->id) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-plus"></i> Oda Ekle
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <i class="fas fa-hotel fa-5x text-muted mb-3"></i>
            <h3>Henüz Oteliniz Bulunmuyor</h3>
            <p class="mb-4">İlk otelinizi ekleyerek sistemi kullanmaya başlayabilirsiniz.</p>
            <a href="{{ route('manager.hotels.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle me-1"></i> İlk Otelinizi Ekleyin
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
