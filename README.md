# Culinaire - Dynamic Recipe Sharing Platform

A modern recipe sharing platform powered by MealDB API and MySQL database with full blog management capabilities.

---

## 🌟 Overview

Culinaire has been transformed from a static HTML website to a fully dynamic platform featuring:
- **Thousands of recipes** from MealDB API
- **Blog CRUD system** with MySQL
- **RESTful PHP API** for data management
- **Responsive design** preserved from original

---

## 🚀 Quick Start

### Prerequisites
- Apache web server (XAMPP recommended)
- MySQL 5.7+
- PHP 7.4+

### Installation

1. **Clone/Move to htdocs:**
   ```bash
   # Move project to Apache htdocs folder
   Move to: C:\xampp\htdocs\culinaire\
   ```

2. **Setup Database:**
   ```bash
   # In MySQL, run:
   database-setup.sql
   ```

3. **Copy Blog Images:**
   ```bash
   # Copy existing blog images to uploads directory
   # See MIGRATION-GUIDE.md for detailed commands
   ```

4. **Start Services:**
   - Start Apache
   - Start MySQL

5. **Open in Browser:**
   ```
   http://localhost/culinaire/index.php
   ```

---

## 📁 Project Structure

```
culinaire/
├── index.php                 # Dynamic homepage
├── all-recipes.php           # Recipe browsing (MealDB)
├── recipe.php                # Dynamic recipe viewer
├── blogs.php                 # Blog listing
├── blog-detail.php           # Blog viewer
├── blog-create.php           # Create blog form
├── blog-edit.php             # Edit blog form
│
├── api/
│   ├── config.php            # Database config & helpers
│   └── blogs/                # Blog CRUD endpoints
│       ├── create.php        # POST - Create blog
│       ├── read.php          # GET - List all blogs
│       ├── read-single.php   # GET - Get single blog
│       ├── update.php        # PUT - Update blog
│       └── delete.php        # DELETE - Delete blog
│
├── js/
│   ├── scripts.js            # Utility functions
│   └── recipe-handler.js     # MealDB integration
│
├── uploads/blogs/            # Blog images
│   ├── thumbnails/
│   └── banners/
│
└── database-setup.sql        # Database creation script
```

---

## 🎯 Features

### Recipe System
- ✨ Browse thousands of recipes from MealDB
- 🔍 Search recipes by name
- 📂 Filter by categories (Beef, Chicken, Dessert, etc.)
- 📺 YouTube video integration
- 🎲 Random featured recipes
- 💡 Auto-suggested similar recipes

### Blog System
- ✍️ Create blogs with rich content
- 📝 Edit existing blogs
- 🗑️ Delete blogs with confirmation
- 🖼️ Upload thumbnail and banner images
- 🔗 SEO-friendly URLs with slugs
- 👥 Public CRUD (no authentication)

### Technical Features
- 🚀 RESTful PHP API
- 💾 MySQL database
- 🌐 AJAX data fetching
- 📱 Fully responsive design
- 🎨 Original styling preserved

---

## 🔌 API Documentation

### Base URL
```
http://localhost/culinaire/api/blogs/
```

### Endpoints

**List All Blogs**
```http
GET /read.php?limit=10&offset=0
```

**Get Single Blog**
```http
GET /read-single.php?slug=kitchen-hacks
```

**Create Blog**
```http
POST /create.php
Content-Type: multipart/form-data

title: "Blog Title"
author: "Author Name"
excerpt: "Short description"
content: "<p>Full content</p>"
thumbnail: [File]
banner: [File]
```

**Update Blog**
```http
PUT /update.php
Content-Type: application/x-www-form-urlencoded

id=1&title=Updated Title&author=Author&excerpt=...&content=...
```

**Delete Blog**
```http
DELETE /delete.php
Content-Type: application/json

{"id": 1}
```

---

## 🗄️ Database Schema

### blogs Table
```sql
CREATE TABLE blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(255) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100) NOT NULL,
    excerpt TEXT NOT NULL,
    content TEXT NOT NULL,
    thumbnail_path VARCHAR(255) NOT NULL,
    banner_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_created_at (created_at)
);
```

---

## 🎨 Pages Overview

| Page | Description | Key Features |
|------|-------------|--------------|
| `index.php` | Homepage | Featured recipes, categories, blogs |
| `all-recipes.php` | Recipe browser | Category filter, search, pagination |
| `recipe.php` | Recipe details | Ingredients, instructions, YouTube video |
| `blogs.php` | Blog listing | All blogs, create button |
| `blog-detail.php` | Blog viewer | Full content, edit/delete buttons |
| `blog-create.php` | Create blog | Form with image uploads |
| `blog-edit.php` | Edit blog | Pre-filled form |

---

## 🔧 Configuration

### Database Settings
Edit `api/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'culinaire_db');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### Upload Settings
```php
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp', 'gif']);
```

---

## 📖 Documentation

- **[MIGRATION-GUIDE.md](MIGRATION-GUIDE.md)** - Complete setup instructions
- **[database-setup.sql](database-setup.sql)** - Database creation script

---

## 🐛 Troubleshooting

**Recipes not loading?**
- Check internet connection (MealDB is external API)
- Open browser console for errors

**Blogs not showing?**
- Ensure database is setup (`database-setup.sql`)
- Check MySQL is running
- Verify images are in `uploads/blogs/`

**Can't create blogs?**
- Check `uploads/blogs/` directory permissions
- Verify image file size (<5MB)
- Check allowed file types (JPG, PNG, WebP)

---

## 📊 Migration Summary

### Before
- 23 static recipe HTML files
- 4 hardcoded blog HTML files
- All data in JavaScript/HTML
- No database
- No search functionality
- Manual content updates

### After
- ✅ 1 dynamic recipe template
- ✅ MySQL database for blogs
- ✅ RESTful API
- ✅ Thousands of recipes from MealDB
- ✅ Full text search
- ✅ CRUD operations
- ✅ Automatic updates from MealDB

---

## 🎉 Success Metrics

- **Code Reduction:** 23 recipe files → 1 template (95% reduction)
- **Recipe Count:** 23 recipes → Thousands from MealDB
- **Features Added:** Search, filter, CRUD, dynamic loading
- **Performance:** Faster page loads (no duplicate HTML)
- **Maintainability:** Centralized data management

---

## 🔜 Future Enhancements

- [ ] User authentication system
- [ ] Blog categories and tags
- [ ] Comment system
- [ ] Recipe favorites (localStorage)
- [ ] Social media sharing
- [ ] Advanced search filters
- [ ] Recipe ratings and reviews
- [ ] User profiles

---

## 📜 License

This project is for educational purposes.

---

## 🙏 Credits

- **MealDB API:** https://www.themealdb.com/
- **Original Design:** Culinaire Team
- **Migration:** Completed with Claude Code

---

**Built with ❤️ using PHP, MySQL, and MealDB API**
