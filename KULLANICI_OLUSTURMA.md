# 🏨 Otel Rezervasyon Sistemi - Kullanıcı Oluşturma Rehberi

Bu Laravel projesinde 3 farklı tip kullanıcı bulunmaktadır:
- **Admin**: Sistem yöneticisi
- **Otel Yöneticisi**: Otel işletmecisi
- **Müşteri**: Rezervasyon yapan kullanıcı

## 📋 Mevcut Örnek Kullanıcılar

Sistem kurulumunda otomatik olarak aşağıdaki örnek kullanıcılar oluşturulmuştur:

### 👨‍💼 Admin
- **E-posta**: `admin@otelrezervasyon.com`
- **Şifre**: `admin123`
- **Rol**: Admin
- **Ad Soyad**: Sistem Yöneticisi

### 🏨 Otel Yöneticisi
- **E-posta**: `manager@otelrezervasyon.com`
- **Şifre**: `manager123`
- **Rol**: Otel Yöneticisi
- **Ad Soyad**: Ahmet Yılmaz

### 👤 Müşteri
- **E-posta**: `customer@otelrezervasyon.com`
- **Şifre**: `customer123`
- **Rol**: Müşteri
- **Ad Soyad**: Ayşe Demir

## 🚀 Yeni Kullanıcı Oluşturma Yöntemleri

### 1. Seeder ile Toplu Oluşturma

Tüm örnek kullanıcıları tekrar oluşturmak için:

```bash
php artisan db:seed --class=UserRolesSeeder
```

### 2. Artisan Komutu ile İnteraktif Oluşturma

Yeni kullanıcı oluşturmak için özel komutumuz:

```bash
php artisan user:create
```

Bu komut size şunları soracak:
- Kullanıcı rolü (admin/hotel_manager/customer)
- Ad Soyad
- E-posta
- Şifre
- Telefon (opsiyonel)
- Adres (opsiyonel)

#### Belirli bir rolle kullanıcı oluşturma:

```bash
# Admin oluştur
php artisan user:create --role=admin

# Otel yöneticisi oluştur
php artisan user:create --role=hotel_manager

# Müşteri oluştur
php artisan user:create --role=customer
```

### 3. Tinker ile Manuel Oluşturma

Laravel Tinker kullanarak:

```bash
php artisan tinker
```

Tinker içinde:

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Admin oluştur
User::create([
    'name' => 'Yeni Admin',
    'email' => 'yeniadmin@example.com',
    'password' => Hash::make('şifre123'),
    'role' => 'admin',
    'is_approved' => true,
    'phone' => '+90 555 000 00 00',
    'address' => 'Adres bilgisi'
]);

// Otel yöneticisi oluştur
User::create([
    'name' => 'Yeni Otel Yöneticisi',
    'email' => 'yenimanager@example.com',
    'password' => Hash::make('şifre123'),
    'role' => 'hotel_manager',
    'is_approved' => true,
    'phone' => '+90 555 000 00 01',
    'address' => 'Otel adresi'
]);

// Müşteri oluştur
User::create([
    'name' => 'Yeni Müşteri',
    'email' => 'yenimusteri@example.com',
    'password' => Hash::make('şifre123'),
    'role' => 'customer',
    'is_approved' => true,
    'phone' => '+90 555 000 00 02',
    'address' => 'Müşteri adresi'
]);
```

## 📊 Mevcut Kullanıcıları Listeleme

Tüm kullanıcıları görmek için:

```bash
php artisan tinker --execute="echo json_encode(App\Models\User::all(['id', 'name', 'email', 'role'])->toArray(), JSON_PRETTY_PRINT);"
```

## 🔧 Kullanıcı Rolleri ve Yetkiler

### Admin (`admin`)
- Tüm sistem yönetimi
- Kullanıcı onaylama/reddetme
- Otel ve rezervasyon yönetimi

### Otel Yöneticisi (`hotel_manager`)
- Kendi otellerini yönetme
- Oda tanımlama ve fiyatlandırma
- Rezervasyon onaylama

### Müşteri (`customer`)
- Otel arama ve görüntüleme
- Rezervasyon yapma
- Profil yönetimi

## 📝 Notlar

- Tüm kullanıcılar varsayılan olarak onaylı (`is_approved = true`) oluşturulur
- Admin kullanıcıları her zaman otomatik onaylıdır
- E-posta adresleri benzersiz olmalıdır
- Şifreler minimum 6 karakter olmalıdır
- Telefon ve adres bilgileri opsiyoneldir

## 🔍 Sorun Giderme

### Veritabanı Bağlantı Hatası
Eğer MySQL bağlantı hatası alıyorsanız:
1. Laragon'u başlatın
2. MySQL servisinin çalıştığından emin olun
3. `.env` dosyasındaki veritabanı ayarlarını kontrol edin

### Seeder Hatası
Eğer seeder çalışmıyorsa:
1. `composer dump-autoload` komutunu çalıştırın
2. Cache'i temizleyin: `php artisan cache:clear`
3. Config cache'i temizleyin: `php artisan config:clear`
```

</rewritten_file>
