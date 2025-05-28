@extends('layouts.admin')

@section('admin-content')
@if(!$reservation || !is_object($reservation))
<div class="py-4">
    <div class="alert alert-danger">
        Rezervasyon bulunamadı.
    </div>
    <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Geri Dön
    </a>
</div>
@else
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Rezervasyon Detayı #{{ $reservation->id ?? 'N/A' }}</h1>
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
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

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-calendar-check"></i> Rezervasyon Bilgileri</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Rezervasyon ID:</strong> #{{ $reservation->id ?? 'N/A' }}<br>
                            <strong>Durum:</strong>
                            @if(($reservation->status ?? '') == 'confirmed')
                                <span class="badge bg-success">Onaylı</span>
                            @elseif(($reservation->status ?? '') == 'pending')
                                <span class="badge bg-warning">Beklemede</span>
                            @elseif(($reservation->status ?? '') == 'cancelled')
                                <span class="badge bg-danger">İptal</span>
                            @elseif(($reservation->status ?? '') == 'completed')
                                <span class="badge bg-info">Tamamlandı</span>
                            @else
                                <span class="badge bg-secondary">{{ $reservation->status ?? 'Belirsiz' }}</span>
                            @endif
                            <br><br>
                            <strong>Giriş Tarihi:</strong> {{ $reservation->check_in_date?->format('d.m.Y') ?? 'N/A' }}<br>
                            <strong>Çıkış Tarihi:</strong> {{ $reservation->check_out_date?->format('d.m.Y') ?? 'N/A' }}<br>
                            <strong>Gece Sayısı:</strong> {{ $reservation->check_in_date && $reservation->check_out_date ? $reservation->check_in_date->diffInDays($reservation->check_out_date) : 'N/A' }}<br>
                            <strong>Misafir Sayısı:</strong> {{ $reservation->guests_count ?? 'N/A' }}<br>
                        </div>
                        <div class="col-md-6">
                            <strong>Toplam Fiyat:</strong> {{ number_format($reservation->total_price ?? 0, 2) }} ₺<br>
                            <strong>Ödeme Durumu:</strong>
                            @if(($reservation->payment_status ?? '') == 'completed')
                                <span class="badge bg-success">Ödendi</span>
                            @elseif(($reservation->payment_status ?? '') == 'pending')
                                <span class="badge bg-warning">Beklemede</span>
                            @elseif(($reservation->payment_status ?? '') == 'failed')
                                <span class="badge bg-danger">Başarısız</span>
                            @else
                                <span class="badge bg-secondary">{{ $reservation->payment_status ?? 'Belirsiz' }}</span>
                            @endif
                            <br><br>
                            @if($reservation->payment_method ?? false)
                                <strong>Ödeme Yöntemi:</strong> {{ $reservation->payment_method }}<br>
                            @endif
                            @if($reservation->transaction_id ?? false)
                                <strong>İşlem ID:</strong> {{ $reservation->transaction_id }}<br>
                            @endif
                            <strong>Rezervasyon Tarihi:</strong> {{ $reservation->created_at?->format('d.m.Y H:i') ?? 'N/A' }}<br>
                        </div>
                    </div>

                    @if($reservation->special_requests ?? false)
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <strong>Özel İstekler:</strong><br>
                            <p class="text-muted">{{ $reservation->special_requests }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5><i class="fas fa-user"></i> Müşteri Bilgileri</h5>
                </div>
                <div class="card-body">
                    <strong>Ad Soyad:</strong> {{ $reservation->user?->name ?? 'N/A' }}<br>
                    <strong>E-posta:</strong> {{ $reservation->user?->email ?? 'N/A' }}<br>
                    @if($reservation->user?->phone)
                        <strong>Telefon:</strong> {{ $reservation->user->phone }}<br>
                    @endif
                    @if($reservation->user?->address)
                        <strong>Adres:</strong> {{ $reservation->user->address }}<br>
                    @endif
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5><i class="fas fa-hotel"></i> Otel Bilgileri</h5>
                </div>
                <div class="card-body">
                    <strong>Otel Adı:</strong> {{ $reservation->room?->hotel?->name ?? 'N/A' }}<br>
                    @if($reservation->room?->hotel?->location)
                        <strong>Konum:</strong> {{ $reservation->room->hotel->location }}<br>
                    @endif
                    @if($reservation->room?->hotel?->address)
                        <strong>Adres:</strong> {{ $reservation->room->hotel->address }}<br>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-bed"></i> Oda Bilgileri</h5>
                </div>
                <div class="card-body">
                    <strong>Oda Numarası:</strong> {{ $reservation->room?->room_number ?? 'Oda #' . ($reservation->room?->id ?? 'N/A') }}<br>
                    @if($reservation->room?->type)
                        <strong>Oda Tipi:</strong> {{ $reservation->room->type }}<br>
                    @endif
                    @if($reservation->room?->capacity)
                        <strong>Kapasite:</strong> {{ $reservation->room->capacity }} kişi<br>
                    @endif
                    <strong>Gecelik Fiyat:</strong> {{ number_format($reservation->room?->price_per_night ?? 0, 2) }} ₺<br>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
