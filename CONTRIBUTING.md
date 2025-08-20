# Katkıda Bulunma Rehberi

Game Compatibility Analyzer projesine katkıda bulunmak istediğiniz için teşekkür ederiz! 

## 🚀 Başlamadan Önce

1. [Issues](https://github.com/[username]/game-compatibility-analyzer/issues) sayfasını kontrol edin
2. Eğer çalışmak istediğiniz bir feature/bug yoksa yeni bir issue açın
3. Fork edin ve local'de development ortamı kurun

## 💻 Development Kurulumu

```bash
# Projeyi fork edin ve klonlayın
git clone https://github.com/YOUR_USERNAME/game-compatibility-analyzer.git
cd game-compatibility-analyzer

# Bağımlılıkları yükleyin
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Frontend build
npm run dev
```

## 📝 Kod Standartları

### PHP (Laravel)
- PSR-12 coding standard
- Laravel best practices
- Type hints kullanın
- Doctrine block comments yazın

### JavaScript
- ES6+ syntax
- Meaningful variable names
- Comment complex logic

### CSS
- Tailwind CSS classes kullanın
- Custom CSS minimal tutun
- Responsive design principles

## 🔄 Pull Request Süreci

1. **Feature branch oluşturun:**
   ```bash
   git checkout -b feature/amazing-feature
   # veya
   git checkout -b bugfix/fix-something
   ```

2. **Değişikliklerinizi yapın ve test edin**

3. **Commit guidelines:**
   ```bash
   git commit -m "feat: add amazing feature"
   git commit -m "fix: resolve hardware matching issue"
   git commit -m "docs: update API documentation"
   ```

4. **Push edin ve PR oluşturun:**
   ```bash
   git push origin feature/amazing-feature
   ```

## 🧪 Testing

```bash
# PHP tests
php artisan test

# Frontend tests (if any)
npm run test
```

## 📋 PR Checklist

- [ ] Kod PHP ve JavaScript standartlarına uygun
- [ ] Yeni özellikler için testler yazıldı
- [ ] Documentation güncellendi (gerekirse)
- [ ] Migration'lar (varsa) geri alınabilir
- [ ] No breaking changes (major version değilse)

## 🐛 Bug Reports

Issue açarken şunları ekleyin:
- **Açık tanım**: Ne olduğu ve ne olması gerektiği
- **Reproduction steps**: Adım adım nasıl tekrarlanır
- **Environment**: PHP version, Laravel version, browser etc.
- **Screenshots**: (UI bugs için)

## ✨ Feature Requests

- **Use case**: Neden bu özellik gerekli?
- **Proposed solution**: Nasıl implement edilebilir?
- **Alternatives**: Başka çözüm yolları var mı?

## 🏷️ Issue Labels

- `bug`: Something isn't working
- `enhancement`: New feature or request
- `documentation`: Improvements or additions to docs
- `good first issue`: Good for newcomers
- `help wanted`: Extra attention is needed

## 📞 İletişim

Sorularınız için:
- GitHub Issues
- Email: [your-email@example.com]

Teşekkürler! 🙏
