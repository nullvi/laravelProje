@extends('layouts.admin')

@section('admin-content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Odalar Yönetimi</h1>
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
            <i class="fas fa-bed"></i> Tüm Odalar
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Oda No</th>
                            <th>Otel</th>
                            <th>Yönetici</th>
                            <th>Tip</th>
                            <th>Fiyat</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $room)
                        <tr>
                            <td>{{ $room->id }}</td>
                            <td>{{ $room->room_number }}</td>
                            <td>{{ $room->hotel->name }}</td>
                            <td>{{ $room->hotel->manager->name ?? 'Yönetici Yok' }}</td>
                            <td>{{ $room->type }}</td>
                            <td>{{ number_format($room->price_per_night, 2) }} ₺</td>
                            <td>
                                @if($room->is_available)
                                    <span class="badge bg-success">Müsait</span>
                                @else
                                    <span class="badge bg-danger">Dolu</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.hotels.edit', $room->hotel) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Otel Detay
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                @if(is_object($rooms) && method_exists($rooms, 'links'))
                    {{ $rooms->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
