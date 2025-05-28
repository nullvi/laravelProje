@extends('layouts.admin')

@section('admin-content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Otel Yöneticileri Başvuruları</h1>
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
            <i class="fas fa-user-tie"></i> Otel Yöneticileri
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ad Soyad</th>
                            <th>E-posta</th>
                            <th>Durum</th>
                            <th>Başvuru Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hotelManagers as $manager)
                        <tr>
                            <td>{{ $manager->id }}</td>
                            <td>{{ $manager->name }}</td>
                            <td>{{ $manager->email }}</td>
                            <td>
                                @if($manager->is_approved)
                                    <span class="badge bg-success">Onaylandı</span>
                                @else
                                    <span class="badge bg-warning">Beklemede</span>
                                @endif
                            </td>
                            <td>{{ $manager->created_at->format('d.m.Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if(!$manager->is_approved)
                                    <form action="{{ route('admin.hotel-managers.approve', $manager) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i> Onayla
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('admin.hotel-managers.reject', $manager) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-warning ms-1">
                                            <i class="fas fa-times"></i> Reddet
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                @if(is_object($hotelManagers) && method_exists($hotelManagers, 'links'))
                    {{ $hotelManagers->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
