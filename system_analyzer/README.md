# Game Compatibility Analyzer

Sistem donanımınızı otomatik olarak analiz eden ve oyun uyumluluğunu test eden Windows uygulaması.

## Özellikler

- 🔍 **Otomatik Donanım Tespiti**: CPU, GPU, RAM ve disk bilgilerini otomatik toplar
- 🎮 **Oyun Uyumluluk Analizi**: Sisteminizin hangi oyunları çalıştırabileceğini analiz eder
- 📊 **Detaylı Raporlama**: Her oyun için uyumluluk yüzdesi ve öneriler sunar
- 🚀 **Yükseltme Önerileri**: Sistem performansını artırmak için öneriler verir
- 🔒 **Güvenli**: Kişisel verilerinize erişmez, sadece donanım bilgilerini kullanır

## Sistem Gereksinimleri

- **İşletim Sistemi**: Windows 7/8/10/11
- **RAM**: Minimum 2GB
- **Disk Alanı**: 50MB boş alan
- **İnternet**: Analiz için internet bağlantısı gerekli

## Python ile Geliştirme

### Gereksinimler

```bash
pip install -r requirements.txt
```

### Geliştirme Modunda Çalıştırma

```bash
python system_analyzer.py
```

### EXE Dosyası Oluşturma

```bash
python build_exe.py
```

EXE dosyası `dist` klasörüne oluşturulacaktır.

## Kullanım

1. **Program Başlatma**: `GameCompatibilityAnalyzer.exe` dosyasını çalıştırın
2. **Sistem Tarama**: "Scan System" butonuna tıklayarak donanım bilgilerinizi toplayın
3. **Oyun Analizi**: "Analyze Games" butonuna tıklayarak uyumluluk analizini başlatın
4. **Sonuçları İnceleme**: Uyumluluk tablosundan oyun performanslarını görün

## API Entegrasyonu

Program aşağıdaki API endpoint'ini kullanır:

```
POST /api/analyze-system
```

### İstek Formatı

```json
{
    "cpu_name": "Intel Core i7-10700K",
    "gpu_name": "NVIDIA GeForce RTX 3070",
    "ram_gb": 16,
    "disk_free_gb": 500,
    "os": "Windows 10",
    "cpu_cores": 8,
    "cpu_threads": 16,
    "gpu_memory_gb": 8
}
```

### Yanıt Formatı

```json
{
    "success": true,
    "system_info": {
        "cpu": { "name": "Intel Core i7-10700K", "matched": "Intel Core i7-10700K" },
        "gpu": { "name": "NVIDIA GeForce RTX 3070", "matched": "RTX 3070" },
        "ram_gb": 16,
        "disk_free_gb": 500,
        "os": "Windows 10"
    },
    "games": [
        {
            "id": 1,
            "name": "Cyberpunk 2077",
            "compatibility": "excellent",
            "percentage": 85.5,
            "details": {},
            "recommendations": []
        }
    ],
    "summary": {
        "total_games": 6,
        "fully_compatible": 4,
        "partially_compatible": 2,
        "incompatible": 0
    }
}
```

## Güvenlik

- Program sadece sistem donanım bilgilerini okur
- Kişisel dosyalarınıza erişim yoktur
- Veriler analiz için kullanılır ve saklanmaz
- Tüm iletişim HTTPS üzerinden şifrelenir

## Sorun Giderme

### Program Açılmıyor
- Windows Defender'ı kontrol edin
- Antivirüs programınızda beyaz listeye ekleyin
- Yönetici olarak çalıştırmayı deneyin

### Bağlantı Hatası
- İnternet bağlantınızı kontrol edin
- Güvenlik duvarı ayarlarını kontrol edin
- VPN kullanıyorsanız kapatmayı deneyin

### Yanlış Donanım Tespiti
- Sürücülerinizi güncelleyin
- GPU-Z gibi alternatif araçlarla karşılaştırın
- Manuel olarak sistem bilgilerini girin

## Geliştirici Notları

### Bağımlılıklar

- `psutil`: Sistem bilgilerini toplama
- `GPUtil`: GPU bilgilerini alma
- `py-cpuinfo`: CPU detaylarını alma
- `requests`: API iletişimi
- `tkinter`: GUI arayüzü
- `Pillow`: Görsel işleme

### Yeni Özellikler Ekleme

1. `system_analyzer.py` dosyasını düzenleyin
2. Gerekirse yeni bağımlılıkları `requirements.txt`'ye ekleyin
3. `build_exe.py` ile yeni EXE oluşturun
4. Test edin ve websitesine yükleyin

### API Geliştirme

Laravel backend'de yeni özellikler için:

1. `SystemAnalysisController.php`'yi düzenleyin
2. Yeni route'ları `routes/api.php`'ye ekleyin
3. Frontend'de gerekli değişiklikleri yapın

## Lisans

Bu proje özel kullanım için geliştirilmiştir. 
