@extends('layouts.admin')

@section('admin-content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Rezervasyonlar Yönetimi</h1>
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
            <i class="fas fa-calendar-check"></i> Tüm Rezervasyonlar
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Müşteri</th>
                            <th>Otel</th>
                            <th>Oda</th>
                            <th>Giriş Tarihi</th>
                            <th>Çıkış Tarihi</th>
                            <th>Toplam Fiyat</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>{{ $reservation->user->name }}</td>
                            <td>{{ $reservation->room->hotel->name }}</td>
                            <td>{{ $reservation->room->room_number ?? 'Oda #' . $reservation->room->id }}</td>
                            <td>{{ $reservation->check_in_date->format('d.m.Y') }}</td>
                            <td>{{ $reservation->check_out_date->format('d.m.Y') }}</td>
                            <td>{{ number_format($reservation->total_price, 2) }} ₺</td>
                            <td>
                                @if($reservation->status == 'confirmed')
                                    <span class="badge bg-success">Onaylı</span>
                                @elseif($reservation->status == 'pending')
                                    <span class="badge bg-warning">Beklemede</span>
                                @elseif($reservation->status == 'cancelled')
                                    <span class="badge bg-danger">İptal</span>
                                @elseif($reservation->status == 'completed')
                                    <span class="badge bg-info">Tamamlandı</span>
                                @else
                                    <span class="badge bg-secondary">{{ $reservation->status }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detay
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(count($reservations) === 0)
            <div class="text-center py-4">
                <p class="text-muted">Henüz hiç rezervasyon yok.</p>
            </div>
            @endif

            <div class="mt-4">
                @if(is_object($reservations) && method_exists($reservations, 'links'))
                    {{ $reservations->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
