@extends('layouts.admin')

@section('admin-content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Kullanıcı Yönetimi</h1>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <i class="fas fa-users"></i> Tüm Kullanıcılar
        </div>
        <div class="card-body">
            @php
                $validUsers = is_array($users) || is_object($users);
            @endphp

            @if($validUsers)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ad Soyad</th>
                                <th>E-posta</th>
                                <th>Rol</th>
                                <th>Kayıt Tarihi</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(is_iterable($users))
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id ?? 'N/A' }}</td>
                                    <td>{{ $user->name ?? 'N/A' }}</td>
                                    <td>{{ $user->email ?? 'N/A' }}</td>
                                    <td>
                                        @if(isset($user->role))
                                            @if($user->role == 'admin')
                                                <span class="badge bg-danger">Admin</span>
                                            @elseif($user->role == 'hotel_manager')
                                                <span class="badge bg-primary">Otel Yöneticisi</span>
                                            @else
                                                <span class="badge bg-success">Müşteri</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Bilinmiyor</span>
                                        @endif
                                    </td>
                                    <td>{{ isset($user->created_at) ? $user->created_at->format('d.m.Y') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Düzenle
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?')">
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
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">Kullanıcı verisi doğru formatta değil.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    @if(is_object($users) && method_exists($users, 'links'))
                        {{ $users->links() }}
                    @endif
                </div>
            @else
                <div class="alert alert-warning">
                    Kullanıcı verisi mevcut değil veya yanlış formatta.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
