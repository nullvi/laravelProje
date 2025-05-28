@extends('layouts.admin')

@section('admin-content')
<div class="settings-header mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-2" style="color: var(--text-primary); font-weight: 700;">
                <i class="fas fa-cog me-3" style="color: var(--primary-color);"></i>Sistem Ayarları
            </h1>
            <p class="text-muted mb-0">Platform yapılandırması ve sistem yönetimi</p>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <i class="fas fa-sliders-h me-2"></i>Genel Ayarlar
            </div>
            <div class="admin-card-body">
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="site_name" class="form-label">
                                <i class="fas fa-globe me-2" style="color: var(--primary-color);"></i>Site Adı
                            </label>
                            <input type="text" class="form-control" id="site_name" name="site_name"
                                   value="{{ config('app.name', 'Otel Rezervasyon') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="site_email" class="form-label">
                                <i class="fas fa-envelope me-2" style="color: var(--primary-color);"></i>Site E-posta
                            </label>
                            <input type="email" class="form-control" id="site_email" name="site_email"
                                   value="admin@otelrezervasy.com">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="site_phone" class="form-label">
                                <i class="fas fa-phone me-2" style="color: var(--primary-color);"></i>Site Telefon
                            </label>
                            <input type="text" class="form-control" id="site_phone" name="site_phone"
                                   value="+90 (212) 555-0123">
                        </div>
                        <div class="col-md-6">
                            <label for="currency" class="form-label">
                                <i class="fas fa-money-bill-wave me-2" style="color: var(--primary-color);"></i>Para Birimi
                            </label>
                            <select class="form-control" id="currency" name="currency">
                                <option value="TRY" selected>Türk Lirası (₺)</option>
                                <option value="USD">US Dollar ($)</option>
                                <option value="EUR">Euro (€)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="site_description" class="form-label">
                            <i class="fas fa-align-left me-2" style="color: var(--primary-color);"></i>Site Açıklaması
                        </label>
                        <textarea class="form-control" id="site_description" name="site_description" rows="3">Türkiye'nin en güvenilir otel rezervasyon platformu. Binlerce otel seçeneği ile konforlu konaklama deneyimi.</textarea>
                    </div>

                    <div class="mb-5">
                        <label for="site_address" class="form-label">
                            <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-color);"></i>Site Adresi
                        </label>
                        <textarea class="form-control" id="site_address" name="site_address" rows="2">İstanbul, Türkiye</textarea>
                    </div>

                    <div class="border-top pt-4 mb-5">
                        <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                            <i class="fas fa-calendar-check me-2" style="color: var(--primary-color);"></i>Rezervasyon Ayarları
                        </h5>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="booking_time_limit" class="form-label">Rezervasyon Süresi (saat)</label>
                                <input type="number" class="form-control" id="booking_time_limit" name="booking_time_limit"
                                       value="24" min="1" max="72">
                                <small class="text-muted">Müşterilerin rezervasyonları tamamlamak için sahip oldukları süre</small>
                            </div>
                            <div class="col-md-6">
                                <label for="cancellation_time_limit" class="form-label">İptal Süresi (saat)</label>
                                <input type="number" class="form-control" id="cancellation_time_limit" name="cancellation_time_limit"
                                       value="48" min="1" max="168">
                                <small class="text-muted">Check-in'den önce ücretsiz iptal süresi</small>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="auto_approve_bookings"
                                           name="auto_approve_bookings" checked>
                                    <label class="form-check-label" for="auto_approve_bookings">
                                        Rezervasyonları Otomatik Onayla
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="email_notifications"
                                           name="email_notifications" checked>
                                    <label class="form-check-label" for="email_notifications">
                                        E-posta Bildirimleri
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-top pt-4 mb-5">
                        <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                            <i class="fas fa-credit-card me-2" style="color: var(--primary-color);"></i>Ödeme Ayarları
                        </h5>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="payment_credit_card"
                                           name="payment_methods[]" value="credit_card" checked>
                                    <label class="form-check-label" for="payment_credit_card">
                                        <i class="fas fa-credit-card me-2"></i>Kredi Kartı
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="payment_bank_transfer"
                                           name="payment_methods[]" value="bank_transfer" checked>
                                    <label class="form-check-label" for="payment_bank_transfer">
                                        <i class="fas fa-university me-2"></i>Banka Havalesi
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="payment_cash"
                                           name="payment_methods[]" value="cash">
                                    <label class="form-check-label" for="payment_cash">
                                        <i class="fas fa-money-bill-alt me-2"></i>Nakit Ödeme
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Ayarları Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <i class="fas fa-info-circle me-2"></i>Sistem Bilgileri
            </div>
            <div class="admin-card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold" style="color: var(--text-primary);">Laravel Sürümü:</span>
                    <span class="badge" style="background-color: var(--primary-color); color: white;">{{ app()->version() }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold" style="color: var(--text-primary);">PHP Sürümü:</span>
                    <span class="badge" style="background-color: var(--primary-color); color: white;">{{ PHP_VERSION }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold" style="color: var(--text-primary);">Veritabanı:</span>
                    <span class="badge" style="background-color: var(--primary-color); color: white;">{{ config('database.default') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold" style="color: var(--text-primary);">Sunucu Zamanı:</span>
                    <span class="text-muted">{{ now()->format('d.m.Y H:i:s') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold" style="color: var(--text-primary);">Zaman Dilimi:</span>
                    <span class="text-muted">{{ config('app.timezone') }}</span>
                </div>
            </div>
        </div>

        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <i class="fas fa-chart-bar me-2"></i>Canlı İstatistikler
            </div>
            <div class="admin-card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold" style="color: var(--text-primary);">
                        <i class="fas fa-users me-2" style="color: var(--primary-color);"></i>Toplam Kullanıcı:
                    </span>
                    <span class="badge bg-primary">{{ \App\Models\User::count() }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold" style="color: var(--text-primary);">
                        <i class="fas fa-hotel me-2" style="color: var(--primary-color);"></i>Toplam Otel:
                    </span>
                    <span class="badge bg-primary">{{ \App\Models\Hotel::count() }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold" style="color: var(--text-primary);">
                        <i class="fas fa-bed me-2" style="color: var(--primary-color);"></i>Toplam Oda:
                    </span>
                    <span class="badge bg-primary">{{ \App\Models\Room::count() }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold" style="color: var(--text-primary);">
                        <i class="fas fa-calendar-check me-2" style="color: var(--primary-color);"></i>Toplam Rezervasyon:
                    </span>
                    <span class="badge bg-primary">{{ \App\Models\Reservation::count() }}</span>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <i class="fas fa-tools me-2"></i>Hızlı İşlemler
            </div>
            <div class="admin-card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('register.admin.form') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user-shield me-2"></i>Yeni Admin Oluştur
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-users me-2"></i>Kullanıcıları Yönet
                    </a>
                    <a href="{{ route('admin.hotel-managers.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user-tie me-2"></i>Otel Yöneticilerini Onayla
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
