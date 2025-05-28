@extends('layouts.app')

@section('title', 'Ana Sayfa - Otel Rezervasyon Sistemi')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <div class="hero-content position-relative" style="z-index: 2;">
                <h1 class="display-4 fw-bold mb-4" style="color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                    Mükemmel Konaklamanızı Keşfedin
                </h1>
                <p class="lead mb-4" style="color: rgba(255,255,255,0.9); text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                    En iyi otellerde rezervasyon yapın, konforun ve lüksün tadını çıkarın
                </p>
                <a href="{{ route('hotels.index') }}" class="btn btn-light btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                    <i class="fas fa-search me-2"></i>Otelleri Keşfet
                </a>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section style="padding: 4rem 0; background: linear-gradient(135deg, #F8FAFC 0%, #E0F7FA 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card" style="border-radius: 1.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.1); border: none;">
                        <div class="card-body" style="padding: 3rem;">
                            <div class="text-center mb-5">
                                <h3 style="color: var(--text-primary); font-weight: 700; margin-bottom: 1rem;">
                                    <i class="fas fa-search me-3" style="color: var(--primary-color);"></i>Otel Ara
                                </h3>
                                <p class="text-muted mb-0">Size en uygun oteli bulmak için detaylı arama yapın</p>
                            </div>
                            <form action="{{ route('hotels.index') }}" method="GET">
                                <div class="row g-4">
                                    <div class="col-lg-4">
                                        <label for="location" class="form-label">
                                            <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-color);"></i>Konum
                                        </label>
                                        <input type="text" class="form-control" id="location" name="location"
                                               placeholder="Şehir veya bölge girin" style="padding: 0.875rem 1.25rem;">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="check_in" class="form-label">
                                            <i class="fas fa-calendar-alt me-2" style="color: var(--primary-color);"></i>Giriş Tarihi
                                        </label>
                                        <input type="date" class="form-control" id="check_in" name="check_in"
                                               min="{{ date('Y-m-d') }}" style="padding: 0.875rem 1.25rem;">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="check_out" class="form-label">
                                            <i class="fas fa-calendar-check me-2" style="color: var(--primary-color);"></i>Çıkış Tarihi
                                        </label>
                                        <input type="date" class="form-control" id="check_out" name="check_out"
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}" style="padding: 0.875rem 1.25rem;">
                                    </div>
                                    <div class="col-lg-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100" style="padding: 0.875rem 1.25rem;">
                                            <i class="fas fa-search me-2"></i>Ara
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Hotels Section -->
    <section style="padding: 5rem 0;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3" style="color: var(--text-primary); font-weight: 700; font-size: 2.5rem;">
                    <i class="fas fa-star me-3" style="color: var(--primary-color);"></i>Öne Çıkan Oteller
                </h2>
                <p class="text-muted fs-5">Misafirlerimizin en çok tercih ettiği lüks oteller</p>
            </div>

            @if($featuredHotels->count() > 0)
                <div class="row g-4">
                    @foreach($featuredHotels as $hotel)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100" style="border-radius: 1.25rem; overflow: hidden; transition: all 0.3s ease; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);"
                                 onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'">
                                <div class="position-relative overflow-hidden">
                                    @if($hotel->image)
                                        <img src="{{ asset('storage/' . $hotel->image) }}" class="card-img-top" alt="{{ $hotel->name }}" style="height: 250px; object-fit: cover;">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80"
                                             class="card-img-top" alt="{{ $hotel->name }}" style="height: 250px; object-fit: cover;">
                                    @endif
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); padding: 0.5rem 0.75rem; border-radius: 20px; font-weight: 600;">
                                            <i class="fas fa-star me-1"></i>{{ $hotel->rating }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body" style="padding: 1.75rem;">
                                    <h5 class="card-title mb-3" style="color: var(--text-primary); font-weight: 700; font-size: 1.25rem;">
                                        {{ $hotel->name }}
                                    </h5>
                                    <p class="card-text mb-3 text-muted">
                                        <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-color);"></i>{{ $hotel->location }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $hotel->rating)
                                                    <i class="fas fa-star" style="color: #F59E0B;"></i>
                                                @elseif($i - 0.5 <= $hotel->rating)
                                                    <i class="fas fa-star-half-alt" style="color: #F59E0B;"></i>
                                                @else
                                                    <i class="far fa-star" style="color: #D1D5DB;"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <a href="{{ route('hotels.show', $hotel) }}" class="btn btn-outline-primary btn-sm" style="border-radius: 25px; padding: 0.5rem 1.25rem; font-weight: 600;">
                                            <i class="fas fa-eye me-1"></i>Detaylar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('hotels.index') }}" class="btn btn-outline-primary btn-lg" style="border-radius: 50px; padding: 0.875rem 2.5rem; font-weight: 600;">
                        <i class="fas fa-building me-2"></i>Tüm Otelleri Görüntüle
                    </a>
                </div>
            @else
                <div class="alert alert-info text-center" style="border-radius: 1rem; padding: 2rem; border: none; background: linear-gradient(135deg, #E0F7FA 0%, #B2EBF2 100%);">
                    <i class="fas fa-info-circle fa-2x mb-3" style="color: var(--primary-color);"></i>
                    <h5 style="color: var(--text-primary); font-weight: 600;">Henüz öne çıkan otel bulunmamaktadır</h5>
                    <p class="mb-0 text-muted">Yeni oteller eklendiğinde burada görüntülenecektir.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section style="padding: 5rem 0; background: linear-gradient(135deg, #F8FAFC 0%, #E0F7FA 100%);">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3" style="color: var(--text-primary); font-weight: 700; font-size: 2.5rem;">
                    <i class="fas fa-heart me-3" style="color: var(--primary-color);"></i>Neden Bizi Seçmelisiniz?
                </h2>
                <p class="text-muted fs-5">Size en iyi hizmeti sunmak için çalışıyoruz</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="text-center h-100" style="background: white; padding: 3rem 2rem; border-radius: 1.25rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;"
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'">
                        <div class="mb-4">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-hotel fa-2x text-white"></i>
                            </div>
                        </div>
                        <h4 class="mb-3" style="color: var(--text-primary); font-weight: 700;">En İyi Otel Seçenekleri</h4>
                        <p class="text-muted mb-0">Türkiye'nin dört bir yanından en iyi oteller, en detaylı bilgiler ve en güncel fiyatlar ile hizmetinizdeyiz.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text-center h-100" style="background: white; padding: 3rem 2rem; border-radius: 1.25rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;"
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'">
                        <div class="mb-4">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-shield-alt fa-2x text-white"></i>
                            </div>
                        </div>
                        <h4 class="mb-3" style="color: var(--text-primary); font-weight: 700;">Güvenli Ödeme</h4>
                        <p class="text-muted mb-0">Tüm ödemelerinizi güvenli bir şekilde gerçekleştirin, rezervasyonunuzu anında onaylayın ve keyifle tatile başlayın.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text-center h-100" style="background: white; padding: 3rem 2rem; border-radius: 1.25rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;"
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'">
                        <div class="mb-4">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-headset fa-2x text-white"></i>
                            </div>
                        </div>
                        <h4 class="mb-3" style="color: var(--text-primary); font-weight: 700;">7/24 Destek</h4>
                        <p class="text-muted mb-0">Konaklamanız öncesinde, sırasında ve sonrasında 7/24 müşteri desteği sunuyoruz. Her zaman yanınızdayız.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
