@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Otel Düzenle - {{ $hotel->name }}</h1>
        <a href="{{ route('admin.hotels.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Otellere Dön
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
            <i class="fas fa-edit"></i> Otel Bilgileri
        </div>
        <div class="card-body">
            <form action="{{ route('admin.hotels.update', $hotel) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Otel Adı</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $hotel->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="location" class="form-label">Konum</label>
                        <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $hotel->location) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Adres</label>
                    <textarea class="form-control" id="address" name="address" rows="2" required>{{ old('address', $hotel->address) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $hotel->description) }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="image" class="form-label">Otel Resmi</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="form-text">Yeni bir resim yüklerseniz, mevcut resim değiştirilecektir.</div>
                    </div>
                    <div class="col-md-6">
                        @if($hotel->image)
                        <div class="text-center">
                            <img src="{{ Storage::url($hotel->image) }}" alt="{{ $hotel->name }}" class="img-thumbnail" style="max-height: 150px;">
                            <p class="form-text">Mevcut resim</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="manager_id" class="form-label">Otel Yöneticisi</label>
                        <select class="form-select" id="manager_id" name="manager_id">
                            @if($hotel->manager_id)
                                <option value="{{ $hotel->manager_id }}">{{ $hotel->manager->name }} (Mevcut)</option>
                            @else
                                <option value="">Yönetici Seçin</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $hotel->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Bu otel aktif mi? (Müşteriler tarafından görülebilir)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Otel Bilgilerini Kaydet</button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-door-open"></i> Odalar</span>
        </div>
        <div class="card-body">
            @if($hotel->rooms->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Adı</th>
                                <th>Kapasite</th>
                                <th>Fiyat</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hotel->rooms as $room)
                            <tr>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->capacity }} kişi</td>
                                <td>₺{{ number_format($room->price_per_night, 2) }}</td>
                                <td>
                                    @if($room->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Pasif</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    Bu otele ait oda bulunmamaktadır.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
