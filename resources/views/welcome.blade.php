@extends('layouts.app')

@section('title', 'Hoş Geldiniz - Otel Rezervasyon Sistemi')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); position: relative; overflow: hidden;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1000 100\" fill=\"%23ffffff\" opacity=\"0.1\"><polygon points=\"1000,100 1000,0 0,100\"/></svg>'); background-size: cover;"></div>
        <div class="container text-center position-relative" style="z-index: 2; padding: 6rem 0;">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-3 fw-bold mb-4 text-white" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                        <i class="fas fa-hotel me-3"></i>Otel Rezervasyon Sistemi
                    </h1>
                    <p class="lead mb-5 text-white" style="font-size: 1.5rem; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                        En iyi otellerde rezervasyon yapın, hayalinizdeki tatili gerçekleştirin
                    </p>
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <a href="{{ route('hotels.index') }}" class="btn btn-light btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            <i class="fas fa-search me-2"></i>Otelleri Keşfet
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600; border-width: 2px;">
                            <i class="fas fa-user-plus me-2"></i>Üye Ol
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section style="padding: 6rem 0; background: linear-gradient(135deg, #F8FAFC 0%, #E0F7FA 100%);">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3" style="color: var(--text-primary); font-weight: 700; font-size: 3rem;">
                    <i class="fas fa-gem me-3" style="color: var(--primary-color);"></i>Neden Biziz?
                </h2>
                <p class="text-muted fs-4">Size en iyi rezervasyon deneyimini sunuyoruz</p>
            </div>
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="text-center h-100" style="background: white; padding: 4rem 3rem; border-radius: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease;"
                         onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 50px rgba(0,0,0,0.2)'"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.1)'">
                        <div class="mb-4">
                            <div style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 10px 25px rgba(0, 188, 212, 0.3);">
                                <i class="fas fa-shield-alt fa-3x text-white"></i>
                            </div>
                        </div>
                        <h3 class="mb-3" style="color: var(--text-primary); font-weight: 700; font-size: 1.5rem;">Güvenli Rezervasyon</h3>
                        <p class="text-muted fs-5 mb-0">SSL sertifikası ile güvenli ödeme sistemi. Kişisel bilgileriniz %100 korunur ve güvenli rezervasyon yaparsınız.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text-center h-100" style="background: white; padding: 4rem 3rem; border-radius: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease;"
                         onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 50px rgba(0,0,0,0.2)'"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.1)'">
                        <div class="mb-4">
                            <div style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 10px 25px rgba(0, 188, 212, 0.3);">
                                <i class="fas fa-tags fa-3x text-white"></i>
                            </div>
                        </div>
                        <h3 class="mb-3" style="color: var(--text-primary); font-weight: 700; font-size: 1.5rem;">En İyi Fiyatlar</h3>
                        <p class="text-muted fs-5 mb-0">Binlerce otel arasından en uygun fiyatları bulun. Özel indirimler ve kampanyalardan yararlanın.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text-center h-100" style="background: white; padding: 4rem 3rem; border-radius: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease;"
                         onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 50px rgba(0,0,0,0.2)'"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.1)'">
                        <div class="mb-4">
                            <div style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 10px 25px rgba(0, 188, 212, 0.3);">
                                <i class="fas fa-headset fa-3x text-white"></i>
                            </div>
                        </div>
                        <h3 class="mb-3" style="color: var(--text-primary); font-weight: 700; font-size: 1.5rem;">7/24 Destek</h3>
                        <p class="text-muted fs-5 mb-0">Uzman müşteri hizmetleri ekibimiz her zaman yanınızda. Soru ve sorunlarınız için 7/24 destek alın.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Search Section -->
    <section style="padding: 6rem 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center mb-5">
                        <h2 class="mb-3" style="color: var(--text-primary); font-weight: 700; font-size: 3rem;">
                            <i class="fas fa-search me-3" style="color: var(--primary-color);"></i>Hızlı Rezervasyon
                        </h2>
                        <p class="text-muted fs-4">Birkaç tıkla hayalinizdeki oteli bulun</p>
                    </div>
                    <div class="card" style="border-radius: 2rem; box-shadow: 0 20px 60px rgba(0,0,0,0.15); border: none;">
                        <div class="card-body" style="padding: 4rem;">
                            <form action="{{ route('hotels.index') }}" method="GET">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <label for="location" class="form-label fs-5 fw-bold">
                                            <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-color);"></i>Nereye gitmek istiyorsunuz?
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="location" name="location"
                                               placeholder="Şehir, bölge veya otel adı" style="padding: 1rem 1.5rem; border-radius: 1rem; font-size: 1.1rem;">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="check_in" class="form-label fs-5 fw-bold">
                                            <i class="fas fa-calendar-alt me-2" style="color: var(--primary-color);"></i>Giriş Tarihi
                                        </label>
                                        <input type="date" class="form-control form-control-lg" id="check_in" name="check_in"
                                               min="{{ date('Y-m-d') }}" style="padding: 1rem 1.5rem; border-radius: 1rem;">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="check_out" class="form-label fs-5 fw-bold">
                                            <i class="fas fa-calendar-check me-2" style="color: var(--primary-color);"></i>Çıkış Tarihi
                                        </label>
                                        <input type="date" class="form-control form-control-lg" id="check_out" name="check_out"
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}" style="padding: 1rem 1.5rem; border-radius: 1rem;">
                                    </div>
                                </div>
                                <div class="text-center mt-5">
                                    <button type="submit" class="btn btn-primary btn-lg px-5 py-3" style="border-radius: 50px; font-size: 1.2rem; font-weight: 700;">
                                        <i class="fas fa-search me-2"></i>Otelleri Ara ve Bul
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="padding: 6rem 0; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); position: relative; overflow: hidden;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1000 100\" fill=\"%23ffffff\" opacity=\"0.1\"><polygon points=\"1000,100 1000,0 0,100\"/></svg>'); background-size: cover;"></div>
        <div class="container text-center position-relative" style="z-index: 2;">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="display-4 fw-bold mb-4 text-white" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                        Hemen Katılın!
                    </h2>
                    <p class="lead mb-5 text-white" style="font-size: 1.3rem; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                        Ücretsiz üye olun ve özel indirimleri kaçırmayın
                    </p>
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            <i class="fas fa-user-plus me-2"></i>Ücretsiz Kayıt Ol
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600; font-size: 1.1rem; border-width: 2px;">
                            <i class="fas fa-info-circle me-2"></i>Daha Fazla Bilgi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
