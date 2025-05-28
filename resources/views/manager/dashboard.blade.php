@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4">Otel Yöneticisi Paneli</h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Oteller</h5>
                    <h2 class="card-text">{{ $stats['hotels_count'] }}</h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('manager.hotels.index') }}">Otelleri Görüntüle</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Odalar</h5>
                    <h2 class="card-text">{{ $stats['rooms_count'] }}</h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    @if($hotels->count() > 0)
                    <a class="small text-white stretched-link" href="{{ route('manager.hotels.rooms.index', $hotels->first()) }}">Odaları Görüntüle</a>
                    @else
                    <a class="small text-white stretched-link" href="{{ route('manager.hotels.index') }}">Önce Otel Ekleyin</a>
                    @endif
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Aktif Rezervasyonlar</h5>
                    <h2 class="card-text">{{ $stats['active_reservations'] }}</h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('manager.reservations.index') }}">Rezervasyonları Görüntüle</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Bugünkü Giriş</h5>
                    <h2 class="card-text">{{ $stats['today_check_ins'] }}</h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('manager.reservations.index') }}">Girişleri Görüntüle</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-hotel me-1"></i>
                    Otelleriniz
                </div>
                <div class="card-body">
                    @if($hotels->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Adı</th>
                                        <th>Konum</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($hotels as $hotel)
                                    <tr>
                                        <td>{{ $hotel->name }}</td>
                                        <td>{{ $hotel->location }}</td>
                                        <td>
                                            @if($hotel->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Pasif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('manager.hotels.edit', $hotel) }}" class="btn btn-sm btn-primary" title="Düzenle">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('manager.hotels.rooms.create', $hotel) }}" class="btn btn-sm btn-success" title="{{ $hotel->name }} otelina oda ekle">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p>Henüz hiç oteliniz bulunmuyor.</p>
                            <a href="{{ route('manager.hotels.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> İlk Otelinizi Ekleyin
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-calendar me-1"></i>
                    Son Rezervasyonlar
                </div>
                <div class="card-body">
                    @if($recentReservations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Misafir</th>
                                        <th>Oda</th>
                                        <th>Tarihler</th>
                                        <th>Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentReservations as $reservation)
                                    <tr>
                                        <td>{{ $reservation->user->name }}</td>
                                        <td>{{ $reservation->room->name ?? 'Oda #' . $reservation->room->id }}</td>
                                        <td>
                                            {{ $reservation->check_in_date->format('d.m') }} -
                                            {{ $reservation->check_out_date->format('d.m.Y') }}
                                        </td>
                                        <td>
                                            @if($reservation->status == 'confirmed')
                                                <span class="badge bg-success">Onaylandı</span>
                                            @elseif($reservation->status == 'pending')
                                                <span class="badge bg-warning">Beklemede</span>
                                            @elseif($reservation->status == 'cancelled')
                                                <span class="badge bg-danger">İptal</span>
                                            @elseif($reservation->status == 'checked_in')
                                                <span class="badge bg-primary">Giriş Yapıldı</span>
                                            @elseif($reservation->status == 'completed')
                                                <span class="badge bg-secondary">Tamamlandı</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $reservation->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-3">
                            <a href="{{ route('manager.reservations.index') }}" class="btn btn-primary">Tüm Rezervasyonları Görüntüle</a>
                        </div>
                    @else
                        <div class="alert alert-info">Henüz hiç rezervasyonunuz bulunmuyor.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Hızlı Erişim
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('manager.hotels.create') }}" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-plus"></i> Yeni Otel Ekle
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('manager.reservations.index') }}" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-calendar"></i> Rezervasyon Yönetimi
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('manager.reports.occupancy') }}" class="btn btn-info btn-lg w-100">
                                <i class="fas fa-chart-pie"></i> Doluluk Raporları
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('manager.reports.revenue') }}" class="btn btn-warning btn-lg w-100">
                                <i class="fas fa-chart-line"></i> Gelir Raporları
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
