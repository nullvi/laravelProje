@extends('layouts.app')

@section('title', 'Rezervasyon Yönetimi - Otel Yöneticisi')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 fw-bold text-primary mb-2">
                        <i class="fas fa-calendar-check me-2"></i>Rezervasyon Yönetimi
                    </h1>
                    <p class="text-muted mb-0">Otellerinizin tüm rezervasyonlarını buradan yönetebilirsiniz</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="fas fa-filter me-2"></i>Filtrele
                    </button>
                    <button class="btn btn-success" onclick="window.location.reload()">
                        <i class="fas fa-sync-alt me-2"></i>Yenile
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Rezervasyon İstatistikleri -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 text-white-50">Onaylanmış</h6>
                            <h3 class="mb-0 fw-bold">{{ $reservations->where('status', 'confirmed')->count() }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-check-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 text-white-50">Beklemede</h6>
                            <h3 class="mb-0 fw-bold">{{ $reservations->where('status', 'pending')->count() }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #dc3545 0%, #e91e63 100%);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 text-white-50">İptal Edilmiş</h6>
                            <h3 class="mb-0 fw-bold">{{ $reservations->where('status', 'cancelled')->count() }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-times-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 text-white-50">Toplam</h6>
                            <h3 class="mb-0 fw-bold">{{ $reservations->count() }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rezervasyon Tablosu -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2 text-primary"></i>Tüm Rezervasyonlar
                </h5>
                <small class="text-muted">{{ $reservations->count() }} rezervasyon gösteriliyor</small>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4 fw-bold text-uppercase small">
                                <i class="fas fa-hashtag me-1"></i>ID
                            </th>
                            <th scope="col" class="fw-bold text-uppercase small">
                                <i class="fas fa-user me-1"></i>Misafir
                            </th>
                            <th scope="col" class="fw-bold text-uppercase small">
                                <i class="fas fa-hotel me-1"></i>Otel / Oda
                            </th>
                            <th scope="col" class="fw-bold text-uppercase small">
                                <i class="fas fa-calendar me-1"></i>Tarihler
                            </th>
                            <th scope="col" class="fw-bold text-uppercase small">
                                <i class="fas fa-info-circle me-1"></i>Durum
                            </th>
                            <th scope="col" class="fw-bold text-uppercase small">
                                <i class="fas fa-money-bill me-1"></i>Fiyat
                            </th>
                            <th scope="col" class="pe-4 fw-bold text-uppercase small text-center">
                                <i class="fas fa-cogs me-1"></i>İşlemler
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $reservation)
                            <tr class="align-middle">
                                <td class="ps-4">
                                    <span class="badge bg-light text-dark fw-bold fs-6">#{{ $reservation->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $reservation->user->name }}</div>
                                            <small class="text-muted">{{ $reservation->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $reservation->room->hotel->name }}</div>
                                        <small class="text-muted">
                                            <i class="fas fa-bed me-1"></i>{{ $reservation->room->name ?? 'Oda #' . $reservation->room->id }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        <div class="text-success fw-bold">
                                            <i class="fas fa-sign-in-alt me-1"></i>{{ $reservation->check_in_date->format('d.m.Y') }}
                                        </div>
                                        <div class="text-danger">
                                            <i class="fas fa-sign-out-alt me-1"></i>{{ $reservation->check_out_date->format('d.m.Y') }}
                                        </div>
                                        <div class="text-muted">
                                            <i class="fas fa-moon me-1"></i>{{ $reservation->check_in_date->diffInDays($reservation->check_out_date) }} gece
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        @if($reservation->status == 'confirmed')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Onaylandı
                                            </span>
                                        @elseif($reservation->status == 'pending')
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Beklemede
                                            </span>
                                        @elseif($reservation->status == 'cancelled')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>İptal
                                            </span>
                                        @elseif($reservation->status == 'completed')
                                            <span class="badge bg-info">
                                                <i class="fas fa-flag-checkered me-1"></i>Tamamlandı
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">{{ $reservation->status }}</span>
                                        @endif
                                        <div class="small mt-1">
                                            @if($reservation->payment_status == 'completed')
                                                <span class="text-success small">
                                                    <i class="fas fa-check-circle me-1"></i>Ödendi
                                                </span>
                                            @elseif($reservation->payment_status == 'pending')
                                                <span class="text-warning small">
                                                    <i class="fas fa-clock me-1"></i>Ödeme Beklemede
                                                </span>
                                            @elseif($reservation->payment_status == 'failed')
                                                <span class="text-danger small">
                                                    <i class="fas fa-times-circle me-1"></i>Ödeme Başarısız
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-success fs-6">{{ number_format($reservation->total_price, 2) }} ₺</div>
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('manager.reservations.show', $reservation) }}"
                                           class="btn btn-sm btn-outline-primary" title="Detayları Görüntüle">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if($reservation->status == 'pending')
                                            <form action="{{ route('manager.reservations.status', $reservation) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="btn btn-sm btn-success" title="Onayla"
                                                        onclick="return confirm('Bu rezervasyonu onaylamak istediğinizden emin misiniz?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if(in_array($reservation->status, ['pending', 'confirmed']))
                                            <form action="{{ route('manager.reservations.status', $reservation) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="btn btn-sm btn-danger" title="İptal Et"
                                                        onclick="return confirm('Bu rezervasyonu iptal etmek istediğinizden emin misiniz?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        <h5>Henüz rezervasyon bulunmuyor</h5>
                                        <p class="mb-0">Yeni rezervasyonlar burada görünecektir.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(method_exists($reservations, 'hasPages') && $reservations->hasPages())
            <div class="card-footer bg-light border-top">
                <div class="d-flex justify-content-center">
                    {{ $reservations->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">
                    <i class="fas fa-filter me-2"></i>Rezervasyonları Filtrele
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('manager.reservations.index') }}" method="GET">
                    <div class="mb-3">
                        <label for="status" class="form-label">Durum</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Tümü</option>
                            <option value="pending">Beklemede</option>
                            <option value="confirmed">Onaylandı</option>
                            <option value="cancelled">İptal</option>
                            <option value="completed">Tamamlandı</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="hotel" class="form-label">Otel</label>
                        <select class="form-select" id="hotel" name="hotel_id">
                            <option value="">Tümü</option>
                            <!-- Hotel seçenekleri controller'dan gelecek -->
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="date_from" class="form-label">Başlangıç Tarihi</label>
                            <input type="date" class="form-control" id="date_from" name="date_from">
                        </div>
                        <div class="col-6">
                            <label for="date_to" class="form-label">Bitiş Tarihi</label>
                            <input type="date" class="form-control" id="date_to" name="date_to">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" onclick="document.querySelector('#filterModal form').submit()">
                    <i class="fas fa-search me-2"></i>Filtrele
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-light) 0%, rgba(224, 247, 250, 0.5) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.5rem;
}

.table-hover > tbody > tr:hover > * {
    background-color: rgba(0, 188, 212, 0.05);
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }

    .d-flex.gap-1 {
        flex-direction: column;
        gap: 0.25rem !important;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
}
</style>
@endsection
