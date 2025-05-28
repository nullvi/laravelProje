@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Oda Başlık ve Temel Bilgiler -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h1 class="h3 mb-2">{{ $room->name }}</h1>
                    <p class="text-muted mb-3">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        <a href="{{ route('hotels.show', $room->hotel->id) }}" class="text-decoration-none">{{ $room->hotel->name }}</a>
                    </p>

                    <div class="mb-4">
                        <span class="badge bg-success me-2">{{ $room->type }}</span>
                        <span class="badge bg-info me-2">{{ $room->capacity }} Kişilik</span>
                        <span class="badge bg-primary me-2">{{ $room->size }} m²</span>
                        @if($room->has_balcony)
                        <span class="badge bg-secondary me-2">Balkonlu</span>
                        @endif
                        @if($room->has_sea_view)
                        <span class="badge bg-secondary me-2">Deniz Manzaralı</span>
                        @endif
                        @if($room->has_city_view)
                        <span class="badge bg-secondary me-2">Şehir Manzaralı</span>
                        @endif
                    </div>

                    <hr>

                    <!-- Oda Fotoğrafları Slider -->
                    <div id="roomCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @for($i = 0; $i < 3; $i++)
                            <button type="button" data-bs-target="#roomCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $i+1 }}"></button>
                            @endfor
                        </div>
                        <div class="carousel-inner rounded">
                            <div class="carousel-item active">
                                <img src="{{ asset('img/rooms/placeholder-1.jpg') }}" class="d-block w-100" alt="Oda Resmi 1" style="height: 400px; object-fit: cover;">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/rooms/placeholder-2.jpg') }}" class="d-block w-100" alt="Oda Resmi 2" style="height: 400px; object-fit: cover;">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/rooms/placeholder-3.jpg') }}" class="d-block w-100" alt="Oda Resmi 3" style="height: 400px; object-fit: cover;">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Önceki</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Sonraki</span>
                        </button>
                    </div>

                    <h4 class="mb-3">Oda Açıklaması</h4>
                    <p>{{ $room->description }}</p>
                </div>
            </div>

            <!-- Oda Özellikleri -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h4 class="card-title mb-0">Oda Özellikleri</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-bed text-primary me-2"></i> {{ $room->bed_type ?? 'Çift Kişilik Yatak' }}</li>
                                <li class="mb-2"><i class="fas fa-bath text-primary me-2"></i> Özel Banyo</li>
                                <li class="mb-2"><i class="fas fa-wifi text-primary me-2"></i> Ücretsiz Wi-Fi</li>
                                <li class="mb-2"><i class="fas fa-wind text-primary me-2"></i> Klima</li>
                                <li class="mb-2"><i class="fas fa-tv text-primary me-2"></i> Düz Ekran TV</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-coffee text-primary me-2"></i> Çay/Kahve Makinesi</li>
                                <li class="mb-2"><i class="fas fa-snowflake text-primary me-2"></i> Mini Buzdolabı</li>
                                <li class="mb-2"><i class="fas fa-lock text-primary me-2"></i> Kasa</li>
                                <li class="mb-2"><i class="fas fa-phone text-primary me-2"></i> Telefon</li>
                                <li class="mb-2"><i class="fas fa-concierge-bell text-primary me-2"></i> Oda Servisi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Değerlendirmeler -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="card-title mb-0">Oda Değerlendirmeleri</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="border text-center p-3 rounded me-3">
                            <h2 class="mb-0">4.8</h2>
                            <div class="text-warning mb-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <small class="text-muted">18 Değerlendirme</small>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-1">
                                <span class="me-2">5</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 80%"></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <span class="me-2">4</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 15%"></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <span class="me-2">3</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 5%"></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <span class="me-2">2</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="me-2">1</span>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Yorum Örnekleri -->
                    <div class="mb-4 pb-4 border-bottom">
                        <div class="d-flex">
                            <img src="{{ asset('img/avatar-placeholder.jpg') }}" alt="Kullanıcı" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 me-2">Ayşe Y.</h5>
                                    <small class="text-muted">2 hafta önce</small>
                                </div>
                                <div class="text-warning mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="mb-0">Oda çok temiz ve rahattı. Personel çok yardımseverdi. Manzara harikaydı. Kesinlikle tekrar tercih ederim.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex">
                            <img src="{{ asset('img/avatar-placeholder.jpg') }}" alt="Kullanıcı" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 me-2">Mehmet K.</h5>
                                    <small class="text-muted">1 ay önce</small>
                                </div>
                                <div class="text-warning mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <p class="mb-0">Konumu mükemmel, oda gayet temiz ve düzenliydi. Kahvaltı biraz daha çeşitli olabilirdi. Yine de çok memnun kaldım.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sağ Sidebar - Rezervasyon Formu -->
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card shadow-sm sticky-top" style="top: 20px; z-index: 10;">
                <div class="card-header bg-white">
                    <h4 class="card-title mb-0">Rezervasyon</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0">{{ number_format($room->price_per_night, 2) }} ₺</h3>
                        <span class="text-muted">/ gece</span>
                    </div>

                    <form action="{{ route('reservations.create', $room->id) }}" method="GET">
                        <div class="mb-3">
                            <label for="check_in" class="form-label">Giriş Tarihi</label>
                            <input type="date" class="form-control" id="check_in" name="check_in" min="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="check_out" class="form-label">Çıkış Tarihi</label>
                            <input type="date" class="form-control" id="check_out" name="check_out" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="guests" class="form-label">Misafir Sayısı</label>
                            <select class="form-select" id="guests" name="guests" required>
                                @for($i = 1; $i <= $room->capacity; $i++)
                                <option value="{{ $i }}">{{ $i }} Kişi</option>
                                @endfor
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">Rezervasyon Yap</button>

                        <div class="text-center">
                            <small class="text-muted">Odanın müsaitlik durumu seçtiğiniz tarihlere göre değişiklik gösterebilir.</small>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ number_format($room->price_per_night, 2) }} ₺ x 1 gece</span>
                        <span>{{ number_format($room->price_per_night, 2) }} ₺</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Temizlik Ücreti</span>
                        <span>{{ number_format($room->price_per_night * 0.05, 2) }} ₺</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Hizmet Bedeli</span>
                        <span>{{ number_format($room->price_per_night * 0.03, 2) }} ₺</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Toplam</span>
                        <span>{{ number_format($room->price_per_night * 1.08, 2) }} ₺</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

