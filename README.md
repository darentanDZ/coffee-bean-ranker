# ☕ Coffee Bean Discovery Platform

A community-driven platform where coffee enthusiasts can track their coffee bean purchases, rate and review beans, engage in discussions, and discover new coffee recommendations through data-driven insights.

## 🚀 Tech Stack

- **Backend:** PHP 8.4 | Laravel 12.38.1
- **Frontend:** Tailwind CSS 4.x | Alpine.js | Livewire 3
- **Database:** MySQL/PostgreSQL (configurable)
- **Search:** Laravel Scout
- **Authentication:** Laravel Sanctum
- **Image Processing:** Intervention Image | Spatie Media Library

## ✨ Features (Planned)

### Core Features
- ✅ **User Management** - Registration, authentication, profiles with social links
- ✅ **Coffee Bean Library** - Comprehensive bean catalog with metadata
- ✅ **Personal Coffee Journal** - Track purchases, brew logs, and preferences
- ✅ **Rating & Review System** - Multi-dimensional ratings (aroma, acidity, body, flavor, aftertaste)
- ✅ **Community Discussions** - Forums for bean recommendations and brewing techniques
- ✅ **Social Features** - Follow users, activity feeds, mentions
- ✅ **Flavor Taxonomy** - Tag beans with taste profiles
- 🔄 **Discovery & Recommendations** - Data-driven bean suggestions
- 🔄 **Search & Filtering** - Advanced search with Scout integration
- 🔄 **Analytics Dashboard** - User statistics and insights

## 📊 Database Schema

### Core Tables
- **users** - Extended with avatar, bio, location, brewing preferences, role
- **beans** - Coffee bean catalog with origin, roast level, processing method
- **user_beans** - Personal coffee collections (purchases)
- **reviews** - Multi-dimensional ratings and written reviews
- **review_images** - Photo uploads for reviews
- **flavor_tags** - Taste profile taxonomy (chocolate, fruity, nutty, etc.)
- **bean_flavor_tags** - Many-to-many relationship
- **brew_logs** - Individual brewing session tracking
- **discussion_threads** - Community forum threads
- **thread_replies** - Forum replies with best answer marking
- **follows** - Social following relationships
- **notifications** - User notification system

## 🛠️ Setup Instructions

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 8.0+ or PostgreSQL 15+

### Installation

1. **Clone the repository**
```bash
git clone <repository-url>
cd coffee-bean-ranker
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install NPM dependencies**
```bash
npm install
```

4. **Environment configuration**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database**
Edit `.env` and set your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coffee_beans
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **Run migrations**
```bash
php artisan migrate
```

7. **Build frontend assets**
```bash
npm run build
# Or for development with hot reload:
npm run dev
```

8. **Start the development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 🎨 Design System

### Color Palette
The platform uses a warm, coffee-inspired color scheme:

**Coffee Tones:**
- `coffee-50` to `coffee-900` - Rich brown tones
- `cream-50` to `cream-900` - Warm cream accents

**Usage:**
```html
<div class="bg-coffee-700 text-cream-100">
    Coffee-themed component
</div>
```

### Components
The platform uses Shadcn-inspired Blade components built with Tailwind CSS and enhanced with Alpine.js for interactivity.

## 📁 Project Structure

```
coffee-bean-ranker/
├── app/
│   ├── Http/Controllers/     # Request handlers
│   ├── Models/               # Eloquent models
│   │   ├── Bean.php          # Coffee bean model with search
│   │   ├── Review.php        # Review system
│   │   ├── User.php          # Extended user model
│   │   └── ...
│   └── Services/             # Business logic
├── database/
│   ├── migrations/           # Database schema
│   └── seeders/             # Sample data
├── resources/
│   ├── css/
│   │   └── app.css          # Tailwind styles
│   ├── js/
│   │   └── app.js           # Alpine.js setup
│   └── views/               # Blade templates
├── routes/
│   ├── web.php              # Web routes
│   └── api.php              # API endpoints
└── tests/                    # PHPUnit tests
```

## 🔐 User Roles

- **Guest** - Browse public content
- **Member** - Full access to personal features and community
- **Moderator** - Community management capabilities
- **Admin** - Full platform management

## 📱 API Endpoints (Planned)

### Authentication
- `POST /api/register`
- `POST /api/login`
- `POST /api/logout`

### Beans
- `GET /api/beans` - List beans with filters
- `GET /api/beans/{id}` - Bean details
- `POST /api/beans` - Create new bean
- `PUT /api/beans/{id}` - Update bean
- `DELETE /api/beans/{id}` - Delete bean

### Reviews
- `GET /api/beans/{id}/reviews` - Get bean reviews
- `POST /api/beans/{id}/reviews` - Create review
- `PUT /api/reviews/{id}` - Update review
- `DELETE /api/reviews/{id}` - Delete review

### Discovery
- `GET /api/recommendations` - Personalized recommendations
- `GET /api/trending` - Trending beans
- `GET /api/search` - Advanced search

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

Run with coverage:
```bash
php artisan test --coverage
```

## 🚢 Deployment

### Production Setup

1. **Environment**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

2. **Assets**
```bash
npm run build
```

3. **Storage**
```bash
php artisan storage:link
```

4. **Queue Worker**
```bash
php artisan queue:work
```

5. **Scheduler**
Add to crontab:
```
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

## 📈 Development Roadmap

### Phase 1: Foundation (✅ Completed)
- [x] Laravel installation and configuration
- [x] Tailwind CSS setup
- [x] Database schema design
- [x] Eloquent models with relationships
- [x] Authentication scaffolding

### Phase 2: Core Features (In Progress)
- [ ] Bean CRUD operations
- [ ] Review system implementation
- [ ] User authentication with email verification
- [ ] Personal coffee journal
- [ ] Image upload functionality

### Phase 3: Community
- [ ] Discussion forums
- [ ] Social features (follow, activity feed)
- [ ] Notifications system
- [ ] User profiles

### Phase 4: Discovery
- [ ] Landing page with data visualizations
- [ ] Recommendation algorithm
- [ ] Advanced search and filters
- [ ] Trending beans analytics

### Phase 5: Polish & Launch
- [ ] Admin dashboard
- [ ] Moderation tools
- [ ] Performance optimization
- [ ] Security audit
- [ ] Beta testing

## 🤝 Contributing

This is currently a development project following the PRD specifications. Contributions will be welcome after the initial release.

## 📄 License

To be determined.

## 🙏 Acknowledgments

Built with Laravel, Tailwind CSS, and Alpine.js. Inspired by specialty coffee culture and community-driven platforms.

---

**Current Status:** Phase 1 Complete - Foundation established with full database schema and model relationships.

For detailed feature specifications, see the Product Requirements Document.
