@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit User</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Users
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
            <i class="fas fa-user-edit"></i> Edit User: {{ is_object($user) ? $user->name : 'Unknown User' }}
        </div>
        <div class="card-body">
            <form action="{{ $user ? route('admin.users.update', $user) : route('admin.users.index') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="customer" {{ isset($user->role) && $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="hotel_manager" {{ isset($user->role) && $user->role == 'hotel_manager' ? 'selected' : '' }}>Hotel Manager</option>
                        <option value="admin" {{ isset($user->role) && $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update User' : 'Save User' }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
