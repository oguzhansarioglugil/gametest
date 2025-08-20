# 🎮 Game Compatibility Analyzer

Modern bir oyun uyumluluk analiz platformu. Kullanıcıların sistem bilgilerini girerek oyunları çalıştırıp çalıştıramayacaklarını öğrenebilecekleri kapsamlı bir Laravel uygulaması.

![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3.x-green.svg)

## 🌟 Özellikler

### 🔐 Kullanıcı Yönetimi
- **Rol Bazlı Erişim Kontrolü**: User, Admin, SuperAdmin rolleri
- **Rütbe Sistemi**: Deneyim puanlarına göre kullanıcı rütbeleri
- **Profil Yönetimi**: Kişisel bilgiler ve sistem bilgileri
- **Güvenli Kimlik Doğrulama**: Laravel Sanctum entegrasyonu

### 🎯 Oyun Yönetimi
- **Kapsamlı Oyun Veritabanı**: Sistem gereksinimleri ile birlikte
- **Minimum & Önerilen Gereksinimler**: CPU, GPU, RAM, Disk
- **Oyun Puanlama Sistemi**: 1-10 arası puanlama
- **Gelişmiş Arama ve Filtreleme**: Sayfalama ile birlikte

### 🔧 Sistem Uyumluluk Analizi
- **Akıllı Donanım Eşleştirme**: Fuzzy string matching algoritması
- **Performans Bazlı Karşılaştırma**: Benchmark skorlarına dayalı analiz
- **Detaylı Uyumluluk Raporu**: Yüzdelik ve renk kodlu sonuçlar
- **Yükseltme Önerileri**: Otomatik donanım önerileri

### ⚡ Donanım Yönetimi
- **Marka ve Model Yönetimi**: Intel, AMD, NVIDIA vs.
- **Benchmark Skorları**: Performans karşılaştırması
- **Otomatik Tamamlama**: Admin panelinde akıllı arama
- **Çakışma Çözümü**: Duplicate marka/model temizleme

### 🎨 Modern Arayüz
- **Responsive Tasarım**: Mobile-first yaklaşım
- **Tailwind CSS**: Modern ve hızlı stilizasyon
- **Alpine.js**: Reaktif JavaScript bileşenleri
- **Gradient Tasarımı**: Görsel olarak çekici arayüz

## 🚀 Kurulum

### Gereksinimler
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0+
- Git

### Adım Adım Kurulum

1. **Projeyi klonlayın:**
```bash
git clone https://github.com/[username]/game-compatibility-analyzer.git
cd game-compatibility-analyzer
```

2. **Bağımlılıkları yükleyin:**
```bash
composer install
npm install
```

3. **Ortam dosyasını yapılandırın:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Veritabanı ayarları (.env dosyası):**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gametest
DB_USERNAME=root
DB_PASSWORD=
```

5. **Veritabanını oluşturun ve migrate edin:**
```bash
php artisan migrate
```

6. **Seed verilerini yükleyin:**
```bash
php artisan db:seed
```

7. **Frontend assets'leri derleyin:**
```bash
npm run build
```

8. **Serveri başlatın:**
```bash
php artisan serve
```

## 👥 Varsayılan Kullanıcılar

Sistem varsayılan olarak şu test kullanıcılarıyla gelir:

| Kullanıcı | Email | Şifre | Rol |
|-----------|--------|--------|-----|
| Super Admin | superadmin@test.com | password | super_admin |
| Admin | admin@test.com | password | admin |
| Test User | testuser@test.com | password | user |

## 🎮 Kullanım

### Kullanıcı İşlemleri
1. **Kayıt Ol / Giriş Yap**
2. **Profil → Sistem Bilgileri** bölümünden donanımınızı girin
3. **Oyunlar** sayfasından istediğiniz oyunu seçin
4. **"Sistemi Test Et"** butonuna tıklayarak uyumluluk analizi yapın

### Admin İşlemleri
- **Oyun Yönetimi**: Yeni oyunlar ekleyin, düzenleyin
- **Sistem Gereksinimleri**: CPU/GPU seçenekleri ve öneriler
- **Donanım Yönetimi**: (Sadece SuperAdmin) Markalar ve modeller

### SuperAdmin İşlemleri
- **Kullanıcı Yönetimi**: Rol ve rütbe düzenleme
- **Donanım Veritabanı**: Marka/model ekleme ve düzenleme
- **Sistem Ayarları**: Platform yapılandırması

## 🏗️ Teknik Mimari

### Backend
- **Framework**: Laravel 11.x
- **Veritabanı**: MySQL (Eloquent ORM)
- **Kimlik Doğrulama**: Laravel Sanctum
- **API**: RESTful endpoints

### Frontend
- **CSS Framework**: Tailwind CSS 3.x
- **JavaScript**: Alpine.js + Vanilla JS
- **Icons**: Font Awesome 6
- **Build Tool**: Vite

### Önemli Sınıflar
- `SystemAnalysisController`: Uyumluluk analizi
- `HardwareManagementController`: Donanım yönetimi
- `GameController`: Oyun işlemleri
- `AdminController`: Yönetim paneli

## 📊 Veritabanı Şeması

### Temel Tablolar
- `users`: Kullanıcı bilgileri ve roller
- `games`: Oyun veritabanı
- `game_requirements`: Oyun sistem gereksinimleri
- `hardware_brands`: Donanım markaları
- `hardware_models`: CPU/GPU modelleri
- `user_systems`: Kullanıcı sistem bilgileri

### İlişkiler
- User → UserSystem (One-to-Many)
- Game → GameRequirement (One-to-Many)
- HardwareBrand → HardwareModel (One-to-Many)
- GameRequirement → HardwareModel (Many-to-Many)

## 🔧 Özelleştirme

### Yeni Donanım Markası Ekleme
```bash
php artisan tinker
```
```php
$brand = \App\Models\HardwareBrand::create([
    'name' => 'Yeni Marka',
    'logo_url' => 'https://example.com/logo.png'
]);
```

### Benchmark Skorları Güncelleme
```php
$model = \App\Models\HardwareModel::where('name', 'RTX 4090')->first();
$model->update(['benchmark_score' => 35000]);
```

## 🐛 Bilinen Sorunlar

- [ ] Bazı eski GPU modelleri için benchmark skorları eksik
- [ ] Mobil cihazlarda pagination görünümü optimize edilebilir
- [ ] Bulk işlemler için progress bar eklenebilir

## 🤝 Katkıda Bulunma

1. Fork edin
2. Feature branch oluşturun (`git checkout -b feature/AmazingFeature`)
3. Değişikliklerinizi commit edin (`git commit -m 'Add some AmazingFeature'`)
4. Branch'inizi push edin (`git push origin feature/AmazingFeature`)
5. Pull Request oluşturun

## 📝 Değişiklik Günlüğü

### v1.0.0 (2025-01-XX)
- ✅ Rol bazlı kullanıcı sistemi
- ✅ Oyun uyumluluk analizi
- ✅ Donanım veritabanı yönetimi
- ✅ Modern responsive arayüz
- ✅ Admin paneli
- ✅ Rütbe sistemi

## 📄 Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Detaylar için [LICENSE](LICENSE) dosyasına bakınız.

## 👨‍💻 Geliştirici

Projeyi geliştirirken kullanılan teknolojiler ve katkıda bulunanlar:

- **Backend**: Laravel 11, PHP 8.2+
- **Frontend**: Tailwind CSS, Alpine.js
- **Database**: MySQL 8.0+
- **AI Assistant**: Claude Sonnet (Development Support)


## 📞 İletişim

Sorularınız için:
- 📧 Email: [oguzhansarioglugil@hotmail.com]

---

⭐ Bu projeyi beğendiyseniz star vermeyi unutmayın!
