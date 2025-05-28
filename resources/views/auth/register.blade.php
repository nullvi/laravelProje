@extends('layouts.app')

@section('title', 'Kayıt Ol - Otel Rezervasyon Sistemi')

@section('content')
<!-- Hero Section -->
<div class="auth-hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-80">
            <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
                <div class="auth-hero-content">
                    <h1 class="auth-hero-title">Hesap Oluşturun</h1>
                    <p class="auth-hero-subtitle">
                        Sadece birkaç dakikada otel rezervasyon deneyiminizi başlatın. Ücretsiz hesap oluşturun ve özel avantajlardan yararlanın.
                    </p>
                    <div class="hero-features">
                        <div class="feature-item">
                            <i class="fas fa-gift"></i>
                            <span>Özel Teklifler</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-star"></i>
                            <span>Puan Kazanın</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-heart"></i>
                            <span>Favoriler</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="auth-card">
                    <div class="auth-card-header">
                        <div class="auth-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h2>Üye Ol</h2>
                        <p>Yeni hesabınızı oluşturun</p>
                    </div>

                    <div class="auth-card-body">
                        <form method="POST" action="{{ route('register') }}" class="auth-form">
                            @csrf

                            <div class="form-group mb-4">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2"></i>Ad Soyad
                                </label>
                                <input id="name" type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}"
                                       required autocomplete="name" autofocus
                                       placeholder="Adınızı ve soyadınızı giriniz">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>E-posta Adresi
                                </label>
                                <input id="email" type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}"
                                       required autocomplete="email"
                                       placeholder="ornek@email.com">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone me-2"></i>Telefon Numarası
                                </label>
                                <input id="phone" type="text"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       name="phone" value="{{ old('phone') }}"
                                       autocomplete="tel"
                                       placeholder="+90 5XX XXX XX XX">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="address" class="form-label">
                                    <i class="fas fa-map-marker-alt me-2"></i>Adres
                                </label>
                                <textarea id="address"
                                          class="form-control @error('address') is-invalid @enderror"
                                          name="address" rows="3"
                                          placeholder="Adres bilginizi giriniz (opsiyonel)">{{ old('address') }}</textarea>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="password" class="form-label">
                                            <i class="fas fa-lock me-2"></i>Şifre
                                        </label>
                                        <div class="password-input-wrapper">
                                            <input id="password" type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   name="password" required autocomplete="new-password"
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
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="password-confirm" class="form-label">
                                            <i class="fas fa-check-circle me-2"></i>Şifre Tekrar
                                        </label>
                                        <div class="password-input-wrapper">
                                            <input id="password-confirm" type="password"
                                                   class="form-control" name="password_confirmation"
                                                   required autocomplete="new-password"
                                                   placeholder="Şifrenizi tekrar giriniz">
                                            <button type="button" class="password-toggle" id="togglePasswordConfirm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="role" value="customer">

                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-4">
                                <i class="fas fa-user-plus me-2"></i>Hesap Oluştur
                            </button>

                            <div class="auth-divider">
                                <span>veya</span>
                            </div>

                            <div class="auth-links">
                                <p class="text-center mb-3">Zaten hesabınız var mı?</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 mb-3">
                                    <i class="fas fa-sign-in-alt me-2"></i>Giriş Yap
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
    max-width: 600px;
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
    // Password toggle for main password field
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

    // Password toggle for confirmation field
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordConfirmInput = document.getElementById('password-confirm');

    if (togglePasswordConfirm && passwordConfirmInput) {
        togglePasswordConfirm.addEventListener('click', function() {
            const type = passwordConfirmInput.type === 'password' ? 'text' : 'password';
            passwordConfirmInput.type = type;

            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }
});
</script>
@endsection
