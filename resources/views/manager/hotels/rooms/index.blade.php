@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Odaları Yönet - {{ $hotel->name }}</h1>
        <div>
            <a href="{{ route('manager.hotels.edit', $hotel) }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Otele Dön
            </a>
            <a href="{{ route('manager.hotels.rooms.create', $hotel) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Yeni Oda Ekle
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <i class="fas fa-door-open"></i> Oda Listesi
        </div>
        <div class="card-body">
            @if($rooms->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Fotoğraf</th>
                                <th>Ad</th>
                                <th>Kapasite</th>
                                <th>Gecelik Fiyat</th>
                                <th>Durum</th>
                                <th>Özellikler</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                            <tr>
                                <td>
                                    @if($room->image)
                                        <img src="{{ Storage::url($room->image) }}" alt="{{ $room->name }}" class="img-thumbnail" style="max-height: 50px;">
                                    @else
                                        <span class="badge bg-secondary">Fotoğraf Yok</span>
                                    @endif
                                </td>
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
                                <td>
                                    @if($room->has_wifi)
                                        <span class="badge bg-info"><i class="fas fa-wifi"></i> WiFi</span>
                                    @endif

                                    @if($room->has_ac)
                                        <span class="badge bg-info"><i class="fas fa-snowflake"></i> Klima</span>
                                    @endif

                                    @if($room->has_tv)
                                        <span class="badge bg-info"><i class="fas fa-tv"></i> TV</span>
                                    @endif

                                    @if($room->has_fridge)
                                        <span class="badge bg-info"><i class="fas fa-box"></i> Buzdolabı</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('manager.hotels.rooms.edit', [$hotel, $room]) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Düzenle
                                        </a>
                                        <form action="{{ route('manager.hotels.rooms.destroy', [$hotel, $room]) }}" method="POST" onsubmit="return confirm('Bu odayı silmek istediğinize emin misiniz? Bu işlem geri alınamaz.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger ms-1">
                                                <i class="fas fa-trash"></i> Sil
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $rooms->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <p>Bu otel için henüz oda eklenmemiş.</p>
                    <a href="{{ route('manager.hotels.rooms.create', $hotel) }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> İlk Odanızı Ekleyin
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
