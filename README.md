# 👑 Pita Queen - Premium Mediterranean Cuisine

A luxurious, modern Laravel application showcasing premium Mediterranean cuisine with a sophisticated black & gold design theme.

## 🌟 About Pita Queen

Pita Queen is a premium restaurant website built with Laravel 12, featuring an elegant design that perfectly captures the essence of authentic Mediterranean dining experience. The application combines modern web technologies with performance optimizations to deliver a seamless user experience.

### ✨ Key Features

- **Responsive Design** - Fully responsive across all devices
- **Performance Optimized** - Enhanced CSS with will-change hints and reduced motion support
- **SEO Optimized** - Comprehensive meta tags and Open Graph protocol
- **Modern UI/UX** - Smooth animations using AOS library
- **Accessible** - Built with accessibility best practices
- **Premium Aesthetics** - Luxurious black & gold color scheme

## 🚀 Tech Stack

- **Laravel 12** - Latest PHP framework with streamlined structure
- **PHP 8.2.12** - Modern PHP version
- **Bootstrap 5.3.2** - Responsive CSS framework
- **Vite** - Modern frontend build tool
- **AOS** - Animate On Scroll library
- **Bootstrap Icons** - Icon library

## 🛠️ Installation

1. Clone the repository:
```bash
git clone https://github.com/AlphaMel-2004/LemorShawarma.git
cd LemorShawarma
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node dependencies:
```bash
npm install
```

4. Copy environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run migrations (if using database):
```bash
php artisan migrate
```

7. Build frontend assets:
```bash
npm run build
# or for development with hot reload
npm run dev
```

8. Start the development server:
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 📁 Project Structure

```
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── resources/
│   ├── css/                 # Custom CSS (app.css)
│   ├── js/                  # JavaScript files
│   └── views/               # Blade templates
│       ├── components/      # Reusable components (navbar, footer, etc.)
│       ├── layouts/         # Layout templates
│       └── home.blade.php   # Homepage
├── routes/
│   └── web.php             # Web routes
└── public/                 # Public assets
```

## 🎨 Optimizations Applied

### Performance Enhancements
- Added `will-change` CSS properties for animated elements
- Implemented `pointer-events: none` on hidden loader
- Added `prefers-reduced-motion` media query support
- Optimized image loading with `lazy` and `eager` attributes
- Preconnect to external font sources

### SEO Improvements
- Enhanced meta descriptions with targeted keywords
- Added Open Graph protocol tags
- Implemented proper heading hierarchy
- Added robots meta tag for indexing
- Optimized alt text for images

### Accessibility
- ARIA labels on interactive elements
- Proper semantic HTML structure
- Keyboard navigation support
- Reduced motion support for users with motion sensitivity

## 🔧 Configuration

The application name can be configured in `.env`:
```env
APP_NAME="Pita Queen"
```

## 📝 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Author

Built with ❤️ by AlphaMel-2004

---

**Note**: This is a demonstration project showcasing Laravel 12 capabilities with modern web development practices.
