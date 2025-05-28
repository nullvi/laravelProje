@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="hero-title">Bizimle İletişime Geçin</h1>
        <p class="hero-subtitle">Sorularınız için 7/24 buradayız. Size yardımcı olmaktan mutluluk duyarız.</p>
    </div>
</div>

<div class="container py-5">
    <!-- Contact Info Cards -->
    <div class="row mb-5">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Adresimiz</h3>
                <p>Merkez Mahallesi<br>Atatürk Caddesi No:123<br>İstanbul, Türkiye</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <h3>Telefon</h3>
                <p>+90 212 123 45 67<br>7/24 Rezervasyon Hattı</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>E-posta</h3>
                <p>info@otelrezervasyonsistemi.com<br>destek@otelrezervasyonsistemi.com</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Contact Form -->
        <div class="col-lg-8 mb-5">
            <div class="modern-card">
                <div class="card-header">
                    <h2><i class="fas fa-paper-plane me-2"></i>Mesaj Gönder</h2>
                    <p>Bize mesaj gönderin, en kısa sürede size dönüş yapalım.</p>
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success modern-alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST" class="modern-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user me-2"></i>Adınız Soyadınız
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2"></i>E-posta Adresiniz
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-group">
                                <label for="subject" class="form-label">
                                    <i class="fas fa-tag me-2"></i>Konu
                                </label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                       id="subject" name="subject" value="{{ old('subject') }}" required>
                                @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-group">
                                <label for="message" class="form-label">
                                    <i class="fas fa-comment me-2"></i>Mesajınız
                                </label>
                                <textarea class="form-control @error('message') is-invalid @enderror"
                                          id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                                @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-paper-plane me-2"></i>Mesajı Gönder
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Working Hours & Quick Info -->
        <div class="col-lg-4">
            <div class="modern-card mb-4">
                <div class="card-header">
                    <h3><i class="fas fa-clock me-2"></i>Çalışma Saatleri</h3>
                </div>
                <div class="card-body">
                    <div class="working-hours">
                        <div class="hour-item">
                            <span class="day">Pazartesi - Cuma</span>
                            <span class="time">09:00 - 18:00</span>
                        </div>
                        <div class="hour-item">
                            <span class="day">Cumartesi</span>
                            <span class="time">10:00 - 15:00</span>
                        </div>
                        <div class="hour-item">
                            <span class="day">Pazar</span>
                            <span class="time">Kapalı</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modern-card">
                <div class="card-header">
                    <h3><i class="fas fa-headset me-2"></i>Hızlı Destek</h3>
                </div>
                <div class="card-body">
                    <p class="mb-3">Acil durumlar için 7/24 destek hattımızı arayabilirsiniz.</p>
                    <div class="support-buttons">
                        <a href="tel:+902121234567" class="btn btn-outline-primary btn-sm mb-2 w-100">
                            <i class="fas fa-phone me-2"></i>Hemen Ara
                        </a>
                        <a href="mailto:info@otelrezervasyonsistemi.com" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="fas fa-envelope me-2"></i>E-posta Gönder
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header">
                    <h2><i class="fas fa-map-marked-alt me-2"></i>Konum</h2>
                    <p>Ofisimizi ziyaret etmek istiyorsanız, aşağıdaki harita size yol gösterecektir.</p>
                </div>
                <div class="card-body p-0">
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3008.896975058334!2d28.978696!3d41.037183!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cab7650656bd63%3A0x8ca058b28c20b6c3!2zVGFrc2ltIE1leWRhbsSxLCBHw7xtw7zFn3N1eXUsIDM0NDM1IEJleW_En2x1L8Swc3RhbmJ1bA!5e0!3m2!1str!2str!4v1715376197241!5m2!1str!2str"
                                width="100%" height="400" style="border:0; border-radius: 0 0 15px 15px;"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.contact-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid #f0f0f0;
}

.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(20, 184, 166, 0.15);
}

.contact-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem auto;
    font-size: 1.8rem;
}

.contact-card h3 {
    color: var(--text-dark);
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.contact-card p {
    color: var(--text-light);
    margin: 0;
    line-height: 1.6;
}

.working-hours {
    space-y: 1rem;
}

.hour-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.hour-item:last-child {
    border-bottom: none;
}

.hour-item .day {
    font-weight: 500;
    color: var(--text-dark);
}

.hour-item .time {
    color: var(--primary-color);
    font-weight: 600;
}

.support-buttons .btn {
    transition: all 0.3s ease;
}

.support-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.map-container {
    position: relative;
    overflow: hidden;
    border-radius: 0 0 15px 15px;
}

.modern-alert {
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border-left: 4px solid #047857;
}

@media (max-width: 768px) {
    .contact-card {
        margin-bottom: 2rem;
    }

    .hero-section {
        padding: 3rem 0;
    }

    .hour-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}
</style>
@endsection
