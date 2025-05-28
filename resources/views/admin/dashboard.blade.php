@extends('layouts.admin')

@section('admin-content')
<div class="dashboard-header mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-2" style="color: var(--text-primary); font-weight: 700;">
                <i class="fas fa-tachometer-alt me-3" style="color: var(--primary-color);"></i>Admin Dashboard
            </h1>
            <p class="text-muted mb-0">Sistem yönetimi ve genel bakış</p>
        </div>
        <div class="text-end">
            <small class="text-muted">Son güncelleme:</small><br>
            <small class="fw-bold" style="color: var(--primary-color);">{{ now()->format('d.m.Y H:i') }}</small>
        </div>
    </div>
</div>

<!-- İstatistik Kartları -->
<div class="row g-4 mb-5">
    <div class="col-lg-3 col-md-6">
        <div class="admin-card h-100">
            <div class="admin-card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-users fa-3x" style="color: var(--primary-color);"></i>
                </div>
                <h3 class="mb-2" style="color: var(--text-primary); font-weight: 700;">{{ $usersCount }}</h3>
                <h6 class="mb-3" style="color: var(--text-secondary);">Toplam Kullanıcı</h6>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-arrow-right me-1"></i>Detayları Görüntüle
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="admin-card h-100">
            <div class="admin-card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-hotel fa-3x" style="color: var(--primary-color);"></i>
                </div>
                <h3 class="mb-2" style="color: var(--text-primary); font-weight: 700;">{{ $hotelsCount }}</h3>
                <h6 class="mb-3" style="color: var(--text-secondary);">Kayıtlı Otel</h6>
                <a href="{{ route('admin.hotels.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-arrow-right me-1"></i>Detayları Görüntüle
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="admin-card h-100">
            <div class="admin-card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-bed fa-3x" style="color: var(--primary-color);"></i>
                </div>
                <h3 class="mb-2" style="color: var(--text-primary); font-weight: 700;">{{ $roomsCount }}</h3>
                <h6 class="mb-3" style="color: var(--text-secondary);">Toplam Oda</h6>
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-arrow-right me-1"></i>Detayları Görüntüle
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="admin-card h-100">
            <div class="admin-card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-calendar-check fa-3x" style="color: var(--primary-color);"></i>
                </div>
                <h3 class="mb-2" style="color: var(--text-primary); font-weight: 700;">{{ $reservationsCount }}</h3>
                <h6 class="mb-3" style="color: var(--text-secondary);">Toplam Rezervasyon</h6>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-arrow-right me-1"></i>Detayları Görüntüle
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Yönetim Kartları -->
<div class="row g-4 mb-5">
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <i class="fas fa-user-tie me-2"></i>Otel Yöneticileri
            </div>
            <div class="admin-card-body">
                <p class="text-muted mb-4">Otel yöneticilerinin onaylanması ve hesap yönetimi</p>
                <div class="d-grid">
                    <a href="{{ route('admin.hotel-managers.index') }}" class="btn btn-primary">
                        <i class="fas fa-users-cog me-2"></i>Yöneticileri Görüntüle
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <i class="fas fa-chart-line me-2"></i>Gelir Raporu
            </div>
            <div class="admin-card-body">
                <p class="text-muted mb-4">Gelir istatistikleri ve trend analizi</p>
                <div class="d-grid">
                    <a href="{{ route('admin.reports.revenue') }}" class="btn btn-primary">
                        <i class="fas fa-dollar-sign me-2"></i>Raporu Görüntüle
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <i class="fas fa-chart-bar me-2"></i>Doluluk Raporu
            </div>
            <div class="admin-card-body">
                <p class="text-muted mb-4">Oda doluluk oranları ve istatistikleri</p>
                <div class="d-grid">
                    <a href="{{ route('admin.reports.occupancy') }}" class="btn btn-primary">
                        <i class="fas fa-chart-pie me-2"></i>Raporu Görüntüle
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Son Aktiviteler -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <i class="fas fa-users me-2"></i>Son Kayıt Olan Kullanıcılar
            </div>
            <div class="admin-card-body">
                <div class="table-responsive">
                    <table class="table table-hover" style="table-layout: fixed; width: 100%;">
                        <thead>
                            <tr>
                                <th style="color: var(--text-primary); font-weight: 600; width: 25%;">Ad Soyad</th>
                                <th style="color: var(--text-primary); font-weight: 600; width: 35%;">E-posta</th>
                                <th style="color: var(--text-primary); font-weight: 600; width: 20%;">Rol</th>
                                <th style="color: var(--text-primary); font-weight: 600; width: 20%;">Katılım</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestUsers as $user)
                            <tr>
                                <td style="font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $user->name }}">{{ $user->name }}</td>
                                <td class="text-muted" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $user->email }}">{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="badge" style="background-color: #DC2626; color: white;">Admin</span>
                                    @elseif($user->role == 'hotel_manager')
                                        <span class="badge" style="background-color: #F59E0B; color: white;">Otel Yön.</span>
                                    @else
                                        <span class="badge" style="background-color: var(--primary-color); color: white;">Müşteri</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $user->created_at->format('d.m.Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <i class="fas fa-calendar-alt me-2"></i>Son Rezervasyonlar
            </div>
            <div class="admin-card-body">
                <div class="table-responsive">
                    <table class="table table-hover" style="table-layout: fixed; width: 100%;">
                        <thead>
                            <tr>
                                <th style="color: var(--text-primary); font-weight: 600; width: 25%;">Kullanıcı</th>
                                <th style="color: var(--text-primary); font-weight: 600; width: 30%;">Otel</th>
                                <th style="color: var(--text-primary); font-weight: 600; width: 20%;">Giriş</th>
                                <th style="color: var(--text-primary); font-weight: 600; width: 25%;">Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestReservations as $reservation)
                            <tr>
                                <td style="font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $reservation->user->name }}">{{ $reservation->user->name }}</td>
                                <td class="text-muted" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $reservation->room->hotel->name }}">{{ $reservation->room->hotel->name }}</td>
                                <td class="text-muted">{{ $reservation->check_in_date->format('d.m.Y') }}</td>
                                <td>
                                    @if($reservation->status == 'confirmed')
                                        <span class="badge" style="background-color: #22C55E; color: white;">
                                            <i class="fas fa-check me-1"></i>Onaylandı
                                        </span>
                                    @elseif($reservation->status == 'pending')
                                        <span class="badge" style="background-color: #F59E0B; color: white;">
                                            <i class="fas fa-clock me-1"></i>Beklemede
                                        </span>
                                    @elseif($reservation->status == 'cancelled')
                                        <span class="badge" style="background-color: #EF4444; color: white;">
                                            <i class="fas fa-times me-1"></i>İptal Edildi
                                        </span>
                                    @else
                                        <span class="badge" style="background-color: #64748B; color: white;">{{ $reservation->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
