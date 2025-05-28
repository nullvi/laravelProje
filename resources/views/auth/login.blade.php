@extends('layouts.app')

@section('title', 'Giriş Yap - Otel Rezervasyon Sistemi')

@section('content')
<!-- Hero Section -->
<div class="auth-hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-80">
            <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
                <div class="auth-hero-content">
                    <h1 class="auth-hero-title">Hesabınıza Giriş Yapın</h1>
                    <p class="auth-hero-subtitle">
                        Otel rezervasyonlarınızı yönetmek ve özel tekliflerden yararlanmak için giriş yapın.
                    </p>
                    <div class="hero-features">
                        <div class="feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>Güvenli Giriş</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-star"></i>
                            <span>Özel Teklifler</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-clock"></i>
                            <span>7/24 Destek</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="auth-card">
                    <div class="auth-card-header">
                        <div class="auth-icon">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <h2>Giriş Yap</h2>
                        <p>Hesabınıza erişim sağlayın</p>
                    </div>

                    <div class="auth-card-body">
                        <form method="POST" action="{{ route('login') }}" class="auth-form">
                            @csrf

                            <div class="form-group mb-4">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>E-posta Adresi
                                </label>
                                <input id="email" type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}"
                                       required autocomplete="email" autofocus
                                       placeholder="ornek@email.com">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Şifre
                                </label>
                                <div class="password-input-wrapper">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password" required autocomplete="current-password"
                                           placeholder="Şifrenizi giriniz">
                                    <button type="button" class="password-toggle" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <div class="custom-checkbox">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Beni Hatırla
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-4">
                                <i class="fas fa-sign-in-alt me-2"></i>Giriş Yap
                            </button>

                            @if (Route::has('password.request'))
                                <div class="text-center mb-4">
                                    <a href="{{ route('password.request') }}" class="forgot-password-link">
                                        <i class="fas fa-key me-1"></i>Şifrenizi mi unuttunuz?
                                    </a>
                                </div>
                            @endif

                            <div class="auth-divider">
                                <span>veya</span>
                            </div>

                            <div class="auth-links">
                                <p class="text-center mb-3">Henüz hesabınız yok mu?</p>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary w-100 mb-3">
                                    <i class="fas fa-user-plus me-2"></i>Yeni Hesap Oluştur
                                </a>
                                <a href="{{ route('register.hotel-manager') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-building me-2"></i>Otel Yöneticisi Olarak Kayıt Ol
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.auth-hero-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    padding: 2rem 0;
}

.min-vh-80 {
    min-height: 80vh;
}

.auth-hero-content {
    color: white;
}

.auth-hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.auth-hero-subtitle {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    line-height: 1.6;
}

.hero-features {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    color: white;
    font-weight: 500;
}

.feature-item i {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.auth-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    max-width: 480px;
    margin: 0 auto;
}

.auth-card-header {
    text-align: center;
    padding: 2.5rem 2rem 1rem;
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
}

.auth-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    box-shadow: 0 4px 20px rgba(20, 184, 166, 0.3);
}

.auth-card-header h2 {
    color: var(--text-dark);
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.auth-card-header p {
    color: var(--text-light);
    margin: 0;
}

.auth-card-body {
    padding: 2rem;
}

.auth-form .form-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.auth-form .form-label i {
    color: var(--primary-color);
    width: 20px;
}

.password-input-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-light);
    cursor: pointer;
    padding: 0;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.password-toggle:hover {
    color: var(--primary-color);
}

.custom-checkbox {
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.custom-checkbox .form-check-input {
    width: 20px;
    height: 20px;
    border: 2px solid #d1d5db;
    border-radius: 4px;
}

.custom-checkbox .form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.custom-checkbox .form-check-label {
    margin: 0;
    font-weight: 500;
    color: var(--text-dark);
    cursor: pointer;
}

.forgot-password-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.forgot-password-link:hover {
    color: var(--secondary-color);
    text-decoration: underline;
}

.auth-divider {
    text-align: center;
    position: relative;
    margin: 2rem 0;
}

.auth-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e5e7eb;
}

.auth-divider span {
    background: white;
    padding: 0 1rem;
    color: var(--text-light);
    font-weight: 500;
}

.auth-links p {
    color: var(--text-light);
    margin-bottom: 1rem;
}

@media (max-width: 991px) {
    .auth-hero-title {
        font-size: 2.5rem;
    }

    .hero-features {
        justify-content: center;
    }

    .auth-hero-section {
        min-height: auto;
        padding: 3rem 0;
    }
}

@media (max-width: 768px) {
    .auth-hero-title {
        font-size: 2rem;
    }

    .hero-features {
        gap: 1rem;
    }

    .feature-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }

    .auth-card {
        margin: 2rem 0;
    }

    .auth-card-header,
    .auth-card-body {
        padding: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;

            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }
});
</script>
@endsection
