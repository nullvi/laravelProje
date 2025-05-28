@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Yeni Oda Ekle - {{ $hotel->name }}</h1>
        <a href="{{ route('manager.hotels.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Odalara Dön
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
            <i class="fas fa-door-open"></i> Oda Bilgileri
        </div>
        <div class="card-body">
            <form action="{{ route('manager.hotels.rooms.store', $hotel) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Oda Adı/Numarası</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        <div class="form-text">Örnek: "Deluxe Çift Kişilik Oda", "Suit 101", vb.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="room_number" class="form-label">Oda Numarası <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="room_number" name="room_number" value="{{ old('room_number') }}" required>
                        <div class="form-text">Oteldeki oda numarası (gerekli)</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="price_per_night" class="form-label">Gecelik Fiyat (₺)</label>
                        <input type="number" class="form-control" id="price_per_night" name="price_per_night" value="{{ old('price_per_night') }}" min="0" step="0.01" required>
                    </div>

                    <div class="col-md-6">
                        <label for="capacity" class="form-label">Oda Kapasitesi</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" value="{{ old('capacity', 2) }}" min="1" required>
                        <div class="form-text">İzin verilen maksimum misafir sayısı.</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="type" class="form-label">Oda Tipi <span class="text-danger">*</span></label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="" disabled {{ old('type') ? '' : 'selected' }}>Oda tipini seçin</option>
                            <option value="Single" {{ old('type') == 'Single' ? 'selected' : '' }}>Tek Kişilik</option>
                            <option value="Double" {{ old('type') == 'Double' ? 'selected' : '' }}>Çift Kişilik</option>
                            <option value="Twin" {{ old('type') == 'Twin' ? 'selected' : '' }}>İkiz Yataklı</option>
                            <option value="Suite" {{ old('type') == 'Suite' ? 'selected' : '' }}>Suit</option>
                            <option value="Deluxe" {{ old('type') == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                            <option value="Family" {{ old('type') == 'Family' ? 'selected' : '' }}>Aile</option>
                        </select>
                        <div class="form-text">Odanın tipini seçin.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label">Oda Fotoğrafı</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="form-text">Odanın yüksek kaliteli bir fotoğrafını yükleyin (maks. 2MB).</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                    <div class="form-text">Odayı, özelliklerini, büyüklüğünü, manzarasını vb. açıklayın.</div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Oda Özellikleri</label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="hidden" name="has_wifi" value="0">
                            <input class="form-check-input" type="checkbox" id="has_wifi" name="has_wifi" value="1" {{ old('has_wifi') ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_wifi">
                                <i class="fas fa-wifi me-1"></i> WiFi
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="hidden" name="has_ac" value="0">
                            <input class="form-check-input" type="checkbox" id="has_ac" name="has_ac" value="1" {{ old('has_ac') ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_ac">
                                <i class="fas fa-snowflake me-1"></i> Klima
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="hidden" name="has_tv" value="0">
                            <input class="form-check-input" type="checkbox" id="has_tv" name="has_tv" value="1" {{ old('has_tv') ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_tv">
                                <i class="fas fa-tv me-1"></i> Televizyon
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="hidden" name="has_fridge" value="0">
                            <input class="form-check-input" type="checkbox" id="has_fridge" name="has_fridge" value="1" {{ old('has_fridge') ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_fridge">
                                <i class="fas fa-box me-1"></i> Buzdolabı
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Bu odayı hemen rezervasyon için müsait yap</label>
                </div>

                <button type="submit" class="btn btn-primary">Oda Oluştur</button>
            </form>
        </div>
    </div>
</div>
@endsection
