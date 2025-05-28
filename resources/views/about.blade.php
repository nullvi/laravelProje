@extends('layouts.app')

@section('title', 'Hakkımızda - Otel Rezervasyon Sistemi')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); padding: 5rem 0;">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4 text-white" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                        <i class="fas fa-heart me-3"></i>Hakkımızda
                    </h1>
                    <p class="lead text-white" style="font-size: 1.3rem; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                        Seyahat tutkunlarına en iyi konaklama deneyimini sunmak için buradayız
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section style="padding: 6rem 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Company Story -->
                    <div class="card mb-5" style="border-radius: 2rem; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: none; overflow: hidden;">
                        <div class="row g-0">
                            <div class="col-md-6">
                                <div class="card-body" style="padding: 4rem;">
                                    <h2 class="mb-4" style="color: var(--primary-color); font-weight: 700; font-size: 2.5rem;">
                                        <i class="fas fa-star-of-life me-3"></i>Hikayemiz
                                    </h2>
                                    <p class="text-muted fs-5 mb-4">
                                        Otel Rezervasyon Sistemi, seyahat severlere en uygun konaklama seçeneklerini bulmalarında yardımcı olmak için 2023 yılında kurulmuştur.
                                    </p>
                                    <p class="text-muted fs-5 mb-4">
                                        Misyonumuz, kullanıcılarımıza güvenilir, şeffaf ve kullanımı kolay bir rezervasyon deneyimi sunmaktır. Platformumuz, Türkiye'nin dört bir yanındaki otellerle işbirliği yaparak, her bütçeye ve tercihe uygun seçenekler sunmaktadır.
                                    </p>
                                    <p class="text-muted fs-5">
                                        İster lüks bir tatil, ister ekonomik bir iş seyahati için konaklama arıyor olun, sizin için en uygun seçenekleri bulmanıza yardımcı oluyoruz.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6" style="background: linear-gradient(135deg, var(--primary-light) 0%, rgba(224, 247, 250, 0.5) 100%); display: flex; align-items: center; justify-content: center;">
                                <div class="text-center" style="padding: 2rem;">
                                    <div style="width: 150px; height: 150px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 20px 40px rgba(0, 188, 212, 0.3);">
                                        <i class="fas fa-hotel fa-4x text-white"></i>
                                    </div>
                                    <h3 class="mt-4" style="color: var(--primary-color); font-weight: 700;">2023'ten Beri</h3>
                                    <p class="text-muted fs-5">Güvenilir hizmet veriyoruz</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vision -->
                    <div class="card mb-5" style="border-radius: 2rem; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: none;">
                        <div class="card-body text-center" style="padding: 4rem;">
                            <div class="mb-4">
                                <div style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 15px 30px rgba(0, 188, 212, 0.3);">
                                    <i class="fas fa-eye fa-3x text-white"></i>
                                </div>
                            </div>
                            <h2 class="mb-4" style="color: var(--text-primary); font-weight: 700; font-size: 2.5rem;">Vizyonumuz</h2>
                            <p class="text-muted fs-4 mb-0 mx-auto" style="max-width: 600px;">
                                Türkiye'nin en kapsamlı ve kullanıcı dostu otel rezervasyon platformu olmayı hedefliyoruz. Teknolojik yenilikleri takip ederek, müşterilerimize ve otel ortaklarımıza sürekli gelişen bir hizmet sunmak için çalışıyoruz.
                            </p>
                        </div>
                    </div>

                    <!-- Team -->
                    <div class="card mb-5" style="border-radius: 2rem; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: none; background: linear-gradient(135deg, #F8FAFC 0%, #E0F7FA 100%);">
                        <div class="card-body text-center" style="padding: 4rem;">
                            <div class="mb-4">
                                <div style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 15px 30px rgba(0, 188, 212, 0.3);">
                                    <i class="fas fa-users fa-3x text-white"></i>
                                </div>
                            </div>
                            <h2 class="mb-4" style="color: var(--text-primary); font-weight: 700; font-size: 2.5rem;">Ekibimiz</h2>
                            <p class="text-muted fs-4 mb-0 mx-auto" style="max-width: 600px;">
                                Deneyimli turizm profesyonelleri ve yazılım geliştiricilerinden oluşan ekibimiz, size en iyi rezervasyon deneyimini sunmak için çalışmaktadır. Müşteri memnuniyeti ve kaliteli hizmet anlayışımızla, seyahatlerinizi kolaylaştırmak için buradayız.
                            </p>
                        </div>
                    </div>

                    <!-- Why Choose Us -->
                    <div class="card" style="border-radius: 2rem; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: none;">
                        <div class="card-body" style="padding: 4rem;">
                            <div class="text-center mb-5">
                                <h2 style="color: var(--text-primary); font-weight: 700; font-size: 2.5rem;">
                                    <i class="fas fa-check-double me-3" style="color: var(--primary-color);"></i>Neden Bizi Tercih Etmelisiniz?
                                </h2>
                                <p class="text-muted fs-4">Sizi öne çıkaran avantajlarımız</p>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start" style="padding: 2rem; background: white; border-radius: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;"
                                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'"
                                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'">
                                        <div class="me-3">
                                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0, 188, 212, 0.3);">
                                                <i class="fas fa-shield-check fa-lg text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="mb-2" style="color: var(--text-primary); font-weight: 700;">Güvenilir Rezervasyon Sistemi</h5>
                                            <p class="text-muted mb-0">SSL sertifikalı güvenli ödeme sistemi ile kişisel bilgilerinizi koruyoruz.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start" style="padding: 2rem; background: white; border-radius: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;"
                                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'"
                                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'">
                                        <div class="me-3">
                                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0, 188, 212, 0.3);">
                                                <i class="fas fa-tags fa-lg text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="mb-2" style="color: var(--text-primary); font-weight: 700;">En İyi Fiyat Garantisi</h5>
                                            <p class="text-muted mb-0">Piyasadaki en uygun fiyatları bulmanızı garanti ediyoruz.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start" style="padding: 2rem; background: white; border-radius: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;"
                                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'"
                                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'">
                                        <div class="me-3">
                                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0, 188, 212, 0.3);">
                                                <i class="fas fa-headset fa-lg text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="mb-2" style="color: var(--text-primary); font-weight: 700;">7/24 Müşteri Desteği</h5>
                                            <p class="text-muted mb-0">Her zaman ulaşabileceğiniz uzman destek ekibimiz.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start" style="padding: 2rem; background: white; border-radius: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;"
                                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'"
                                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'">
                                        <div class="me-3">
                                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0, 188, 212, 0.3);">
                                                <i class="fas fa-bolt fa-lg text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="mb-2" style="color: var(--text-primary); font-weight: 700;">Kolay ve Hızlı Rezervasyon</h5>
                                            <p class="text-muted mb-0">Birkaç tıkla kolayca rezervasyon yapabilirsiniz.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start" style="padding: 2rem; background: white; border-radius: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;"
                                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'"
                                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'">
                                        <div class="me-3">
                                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0, 188, 212, 0.3);">
                                                <i class="fas fa-star fa-lg text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="mb-2" style="color: var(--text-primary); font-weight: 700;">Detaylı Otel Bilgileri</h5>
                                            <p class="text-muted mb-0">Gerçek müşteri yorumları ve detaylı otel açıklamaları.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start" style="padding: 2rem; background: white; border-radius: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease;"
                                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'"
                                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'">
                                        <div class="me-3">
                                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0, 188, 212, 0.3);">
                                                <i class="fas fa-mobile-alt fa-lg text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="mb-2" style="color: var(--text-primary); font-weight: 700;">Mobil Uyumlu Platform</h5>
                                            <p class="text-muted mb-0">Her cihazdan kolayca erişim sağlayabilirsiniz.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="padding: 5rem 0; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold mb-4 text-white" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                        Siz de Aramıza Katılın!
                    </h2>
                    <p class="lead mb-5 text-white" style="font-size: 1.2rem; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                        Rezervasyon yapmaya hazır mısınız? Hemen başlayın ve en iyi otelleri keşfedin.
                    </p>
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <a href="{{ route('hotels.index') }}" class="btn btn-light btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            <i class="fas fa-search me-2"></i>Otelleri İncele
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600; border-width: 2px;">
                            <i class="fas fa-envelope me-2"></i>İletişime Geç
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
