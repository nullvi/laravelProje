@extends('layouts.app')

@section('content')
<style>
    /* Admin Panel Özel Stilleri */
    .admin-container {
        background-color: var(--background-light);
        min-height: 100vh;
        padding: 0;
    }

    .admin-sidebar {
        background: linear-gradient(180deg, var(--secondary-color) 0%, #F8FAFC 100%);
        border-right: 2px solid var(--border-color);
        min-height: calc(100vh - 80px);
        padding: 1.5rem 0;
        box-shadow: var(--shadow-sm);
    }

    .sidebar-heading {
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
        padding: 0 1.5rem;
    }

    .admin-nav-link {
        color: var(--text-primary);
        text-decoration: none;
        padding: 0.75rem 1.5rem;
        display: block;
        font-weight: 500;
        transition: all 0.3s ease;
        border-radius: 0;
        margin: 0.125rem 0;
        border-left: 3px solid transparent;
    }

    .admin-nav-link:hover {
        background: linear-gradient(90deg, var(--primary-light) 0%, rgba(224, 247, 250, 0.3) 100%);
        color: var(--primary-color);
        border-left-color: var(--primary-color);
        transform: translateX(2px);
    }

    .admin-nav-link.active {
        background: linear-gradient(90deg, var(--primary-light) 0%, rgba(224, 247, 250, 0.5) 100%);
        color: var(--primary-color);
        border-left-color: var(--primary-color);
        font-weight: 600;
    }

    .admin-nav-link i {
        width: 20px;
        text-align: center;
        margin-right: 0.75rem;
    }

    .admin-content {
        background-color: var(--background-light);
        padding: 1rem 2rem 2rem 2rem;
        min-height: calc(100vh - 80px);
    }

    .admin-main-content {
        background: var(--secondary-color);
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    /* Admin Cards */
    .admin-card {
        background: var(--secondary-color);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .admin-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-1px);
    }

    .admin-card-header {
        background: linear-gradient(135deg, var(--primary-light) 0%, rgba(224, 247, 250, 0.3) 100%);
        border-bottom: 1px solid var(--border-color);
        padding: 1.25rem;
        font-weight: 600;
        color: var(--primary-color);
    }

    .admin-card-body {
        padding: 1.5rem;
    }

    /* Quick Action Button */
    .admin-quick-btn {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
        margin-bottom: 0.5rem;
    }

    .admin-quick-btn:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-sidebar {
            min-height: auto;
        }

        .admin-content {
            padding: 1rem;
        }

        .admin-main-content {
            padding: 1rem;
        }
    }
</style>

<div class="admin-container">
    <div class="row g-0">
        <!-- Admin Sidebar -->
        <div class="col-lg-2 col-md-3">
            <div class="admin-sidebar">
                <h6 class="sidebar-heading">
                    <i class="fas fa-tachometer-alt me-2"></i>Admin Panel
                </h6>
                <nav class="nav flex-column">
                    <a class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>Dashboard
                    </a>
                    <a class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i>Kullanıcılar
                    </a>
                    <a class="admin-nav-link {{ request()->routeIs('admin.hotel-managers.*') ? 'active' : '' }}" href="{{ route('admin.hotel-managers.index') }}">
                        <i class="fas fa-user-tie"></i>Otel Yöneticileri
                    </a>
                    <a class="admin-nav-link {{ request()->routeIs('admin.hotels.*') ? 'active' : '' }}" href="{{ route('admin.hotels.index') }}">
                        <i class="fas fa-hotel"></i>Oteller
                    </a>
                    <a class="admin-nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}" href="{{ route('admin.rooms.index') }}">
                        <i class="fas fa-bed"></i>Odalar
                    </a>
                    <a class="admin-nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}" href="{{ route('admin.reservations.index') }}">
                        <i class="fas fa-calendar-check"></i>Rezervasyonlar
                    </a>
                </nav>

                <h6 class="sidebar-heading mt-4">
                    <i class="fas fa-chart-line me-2"></i>Raporlar
                </h6>
                <nav class="nav flex-column">
                    <a class="admin-nav-link {{ request()->routeIs('admin.reports.revenue') ? 'active' : '' }}" href="{{ route('admin.reports.revenue') }}">
                        <i class="fas fa-dollar-sign"></i>Gelir Raporu
                    </a>
                    <a class="admin-nav-link {{ request()->routeIs('admin.reports.occupancy') ? 'active' : '' }}" href="{{ route('admin.reports.occupancy') }}">
                        <i class="fas fa-chart-bar"></i>Doluluk Raporu
                    </a>
                </nav>

                <h6 class="sidebar-heading mt-4">
                    <i class="fas fa-cog me-2"></i>Ayarlar
                </h6>
                <nav class="nav flex-column">
                    <a class="admin-nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                        <i class="fas fa-sliders-h"></i>Sistem Ayarları
                    </a>
                </nav>

                <div class="mt-4 px-3">
                    <a href="{{ route('register.admin.form') }}" class="admin-quick-btn">
                        <i class="fas fa-user-shield me-2"></i>Yeni Admin
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-10 col-md-9">
            <div class="admin-content">
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

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="admin-main-content">
                    @yield('admin-content')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
