# 🎮 Game Compatibility Analyzer

A modern game compatibility analysis platform. A comprehensive Laravel application where users can enter their system information and find out whether they can run games.

![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3.x-green.svg)

## 🌟 Features

### 🔐 User Management
- **Role-Based Access Control**: User, Admin, SuperAdmin roles
- **Rank System**: User ranks based on experience points
- **Profile Management**: Personal information and system specifications
- **Secure Authentication**: Laravel Sanctum integration

### 🎯 Game Management
- **Comprehensive Game Database**: Complete with system requirements
- **Minimum & Recommended Requirements**: CPU, GPU, RAM, Disk
- **Game Rating System**: 1-10 scale rating
- **Advanced Search and Filtering**: With pagination support

### 🔧 System Compatibility Analysis
- **Smart Hardware Matching**: Fuzzy string matching algorithm
- **Performance-Based Comparison**: Analysis based on benchmark scores
- **Detailed Compatibility Report**: Percentage and color-coded results
- **Upgrade Recommendations**: Automatic hardware suggestions

### ⚡ Hardware Management
- **Brand and Model Management**: Intel, AMD, NVIDIA, etc.
- **Benchmark Scores**: Performance comparison
- **Auto-completion**: Smart search in admin panel
- **Conflict Resolution**: Duplicate brand/model cleanup

### 🎨 Modern Interface
- **Responsive Design**: Mobile-first approach
- **Tailwind CSS**: Modern and fast styling
- **Alpine.js**: Reactive JavaScript components
- **Gradient Design**: Visually appealing interface

### 📷 Screenshots

<img width="1856" height="919" alt="Image" src="https://github.com/user-attachments/assets/68364e0e-5a4c-4435-afba-a6a11c957c1c" />
<img width="1856" height="923" alt="Image" src="https://github.com/user-attachments/assets/cf240dc0-7b6a-40f2-898e-34b8fe464964" />
<img width="1859" height="923" alt="Image" src="https://github.com/user-attachments/assets/99d41830-a245-4ef0-9048-7be8db67248b" />
<img width="1857" height="921" alt="Image" src="https://github.com/user-attachments/assets/629f2ba0-54cf-482c-b296-30b1ceeb9207" />
<img width="1860" height="921" alt="Image" src="https://github.com/user-attachments/assets/c680c661-f428-4ae1-bcaf-caba12643a8d" />
<img width="1855" height="923" alt="Image" src="https://github.com/user-attachments/assets/59e79e47-34ea-4e62-9591-3bed19d7b04b" />
<img width="1857" height="919" alt="Image" src="https://github.com/user-attachments/assets/1fa48055-45af-4474-a069-7e771dd4adc1" />
<img width="1857" height="918" alt="Image" src="https://github.com/user-attachments/assets/83311073-a8c4-4a95-bdc7-599d0e5a0136" />
<img width="1858" height="925" alt="Image" src="https://github.com/user-attachments/assets/36e99ce0-b792-49e1-ad05-2bf4fe68f588" />
<img width="1856" height="921" alt="Image" src="https://github.com/user-attachments/assets/12cee0d7-67fc-45ba-84d5-454708585c59" />

## 🚀 Installation

### Requirements
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0+
- Git

### Step-by-Step Installation

1. **Clone the project:**
```bash
git clone https://github.com/[username]/game-compatibility-analyzer.git
cd game-compatibility-analyzer
```

2. **Install dependencies:**
```bash
composer install
npm install
```

3. **Configure environment file:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database settings (.env file):**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gametest
DB_USERNAME=root
DB_PASSWORD=
```

5. **Create database and run migrations:**
```bash
php artisan migrate
```

6. **Load seed data:**
```bash
php artisan db:seed
```

7. **Compile frontend assets:**
```bash
npm run build
```

8. **Start the server:**
```bash
php artisan serve
```

## 👥 Default Users

The system comes with the following test users by default:

| User | Email | Password | Role |
|------|--------|----------|------|
| Super Admin | superadmin@test.com | password | super_admin |
| Admin | admin@test.com | password | admin |
| Test User | testuser@test.com | password | user |

## 🎮 Usage

### User Operations
1. **Register / Login**
2. Enter your hardware information from **Profile → System Information**
3. Select the desired game from **Games** page
4. Click **"Test System"** button to perform compatibility analysis

### Admin Operations
- **Game Management**: Add and edit new games
- **System Requirements**: CPU/GPU options and recommendations
- **Hardware Management**: (SuperAdmin only) Brands and models

### SuperAdmin Operations
- **User Management**: Edit roles and ranks
- **Hardware Database**: Add and edit brands/models
- **System Settings**: Platform configuration

## 🏗️ Technical Architecture

### Backend
- **Framework**: Laravel 11.x
- **Database**: MySQL (Eloquent ORM)
- **Authentication**: Laravel Sanctum
- **API**: RESTful endpoints

### Frontend
- **CSS Framework**: Tailwind CSS 3.x
- **JavaScript**: Alpine.js + Vanilla JS
- **Icons**: Font Awesome 6
- **Build Tool**: Vite

### Important Classes
- `SystemAnalysisController`: Compatibility analysis
- `HardwareManagementController`: Hardware management
- `GameController`: Game operations
- `AdminController`: Admin panel

## 📊 Database Schema

### Core Tables
- `users`: User information and roles
- `games`: Game database
- `game_requirements`: Game system requirements
- `hardware_brands`: Hardware brands
- `hardware_models`: CPU/GPU models
- `user_systems`: User system information

### Relationships
- User → UserSystem (One-to-Many)
- Game → GameRequirement (One-to-Many)
- HardwareBrand → HardwareModel (One-to-Many)
- GameRequirement → HardwareModel (Many-to-Many)

## 🔧 Customization

### Adding New Hardware Brand
```bash
php artisan tinker
```
```php
$brand = \App\Models\HardwareBrand::create([
    'name' => 'New Brand',
    'logo_url' => 'https://example.com/logo.png'
]);
```

### Updating Benchmark Scores
```php
$model = \App\Models\HardwareModel::where('name', 'RTX 4090')->first();
$model->update(['benchmark_score' => 35000]);
```

## 🐛 Known Issues

- [ ] Missing benchmark scores for some older GPU models
- [ ] Pagination view can be optimized for mobile devices
- [ ] Progress bar can be added for bulk operations

## 🤝 Contributing

1. Fork it
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Create a Pull Request

## 📝 Changelog

### v1.0.0 (2025-01-XX)
- ✅ Role-based user system
- ✅ Game compatibility analysis
- ✅ Hardware database management
- ✅ Modern responsive interface
- ✅ Admin panel
- ✅ Rank system

## 📄 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## 👨‍💻 Developer

Technologies used and contributors during project development:

- **Backend**: Laravel 11, PHP 8.2+
- **Frontend**: Tailwind CSS, Alpine.js
- **Database**: MySQL 8.0+
- **AI Assistant**: Claude Sonnet (Development Support)

## 📞 Contact

For questions:
- 📧 Email: [oguzhansarioglugil@hotmail.com]

---

⭐ If you liked this project, don't forget to give it a star!
