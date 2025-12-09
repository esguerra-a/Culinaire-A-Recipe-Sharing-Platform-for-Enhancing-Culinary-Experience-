# Culinaire Migration Guide

## 🎉 Migration Complete!

Your Culinaire recipe platform has been successfully migrated from static HTML to a dynamic system using MealDB API and MySQL!

---

## 📋 What's Been Done

### ✅ Completed Changes

1. **Database & API Backend**
   - Created MySQL database schema
   - Implemented 5 RESTful PHP API endpoints for blog CRUD
   - Image upload handling with validation

2. **MealDB Integration**
   - Dynamic recipe loading from MealDB API
   - Single `recipe.php` template (replaces 23 static files!)
   - Category browsing with MealDB categories
   - Search functionality using MealDB API

3. **Blog System**
   - Full CRUD operations (Create, Read, Update, Delete)
   - No authentication required (public access)
   - Image upload for thumbnails and banners
   - Edit page with pre-populated data
   - Delete confirmation modal

4. **Pages Created/Updated**
   - `index.php` - Dynamic homepage
   - `all-recipes.php` - Recipe browsing with MealDB
   - `recipe.php` - Dynamic recipe detail page
   - `blogs.php` - Blog listing page
   - `blog-detail.php` - Blog viewer with edit/delete
   - `blog-create.php` - Blog creation form
   - `blog-edit.php` - Blog editing form

---

## 🚀 Setup Instructions

### Step 1: Database Setup

1. **Open your MySQL client** (phpMyAdmin, MySQL Workbench, or command line)

2. **Run the database setup script:**
   ```bash
   # In MySQL, execute this file:
   database-setup.sql
   ```

   This will:
   - Create `culinaire_db` database
   - Create `blogs` table
   - Insert 4 existing blog posts

3. **Verify the database:**
   ```sql
   USE culinaire_db;
   SELECT * FROM blogs;
   ```
   You should see 4 blog entries.

### Step 2: Copy Blog Images

**IMPORTANT:** Copy existing blog images to the new upload directories BEFORE running the database script!

```bash
# Copy blog thumbnails
copy "Blogs_Images\kitchen-hacks.jpg" "uploads\blogs\thumbnails\kitchen-hacks.jpg"
copy "Blogs_Images\budget-friendly-bites.jpg" "uploads\blogs\thumbnails\budget-friendly-bites.jpg"
copy "Blogs_Images\spice-up-your-life.jpg" "uploads\blogs\thumbnails\spice-up-your-life.jpg"
copy "Blogs_Images\5-Ways-Healthy-Cooking-Classes-Can-Help-With-Your-Diet.jpg" "uploads\blogs\thumbnails\5-ways-healthy-cooking.jpg"

# Copy blog banners
copy "BLOGS-DETAILED\KITCHEN-HACKS\banner.jpg" "uploads\blogs\banners\kitchen-hacks.jpg"
copy "BLOGS-DETAILED\BUDGET-FRIENDLY\banner.jpg" "uploads\blogs\banners\budget-friendly-bites.jpg"
copy "BLOGS-DETAILED\SPICES\banner.jpg" "uploads\blogs\banners\spice-up-your-life.jpg"
copy "BLOGS-DETAILED\5-WAYS\banner.jpg" "uploads\blogs\banners\5-ways-healthy-cooking.jpg"
```

**Note:** Adjust paths based on where your banner images are located.

### Step 3: Configure Apache/PHP

1. **Move project to htdocs:**
   ```bash
   # If using XAMPP:
   Move the project folder to: C:\xampp\htdocs\culinaire\
   ```

2. **Update database credentials** (if needed):
   - Open `api/config.php`
   - Update lines 13-16 if your MySQL credentials differ:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'culinaire_db');
     define('DB_USER', 'root');      // Change if needed
     define('DB_PASS', '');          // Change if needed
     ```

3. **Start Apache and MySQL:**
   - In XAMPP Control Panel, start both services

### Step 4: Test the Migration

1. **Test Homepage:**
   - Open: `http://localhost/culinaire/index.php`
   - Should show 3 random featured recipes from MealDB
   - Should show 6 categories from MealDB
   - Should show 5 recently added recipes
   - Should show latest 3 blogs

2. **Test Recipe System:**
   - Go to: `http://localhost/culinaire/all-recipes.php`
   - Categories should load from MealDB
   - Click a category - recipes should filter
   - Search for a recipe (e.g., "chicken")
   - Click a recipe - should open `recipe.php` with full details

3. **Test Blog System:**
   - Go to: `http://localhost/culinaire/blogs.php`
   - Should show 4 existing blogs
   - Click "Read More" - should open blog detail
   - Click "Edit Blog" - should open edit form
   - Click "Create New Blog" - test creating a blog

4. **Test Blog CRUD:**
   - **Create:** Fill form, upload images, submit
   - **Read:** View blog list and individual blogs
   - **Update:** Edit an existing blog
   - **Delete:** Delete a blog (confirm modal should appear)

### Step 5: Clean Up Static Files

**ONLY do this AFTER confirming everything works!**

1. **Delete Favorites page:**
   ```bash
   del Favorites.html
   ```

2. **Delete 23 static recipe HTML files:**
   ```bash
   del Chicken-Adobo.html
   del Chicken-Gravy.html
   del Smash-Burger.html
   del Real-American-Hamburger.html
   del Lechon-Kawali.html
   del Italian-Pasta.html
   del Pork-Sisig.html
   del Filet-Mignon.html
   del Shrimp-Sinigang.html
   del Creamy-Mushroom-Soup.html
   del Chicken-Noodle-Soup.html
   del Clam-Chowder.html
   del Avocado-Salad.html
   del Caesar-Salad.html
   del Greek-Salad.html
   del Tomato-Salad.html
   del CheeseCake.html
   del CassavaCake.html
   del BananaWithChocolate.html
   del Classic-Strawberry-Shortcake.html
   del Tasty-Mozarella-Buns.html
   del Mushroom-Pizza.html
   del Kare-kare.html
   ```

3. **Delete 4 static blog HTML files:**
   ```bash
   del Kitchen-Hacks.html
   del 5-Ways.html
   del Bites.html
   del Spice.html
   ```

4. **Update AboutUs.html navigation:**
   - Open `AboutUs.html`
   - Change line 16: `All-Recipes.html` → `all-recipes.php`
   - Change line 17: Remove Favorites link
   - Change line 18: `Blogs.html` → `blogs.php`
   - Change line 15: `index.html` → `index.php`

---

## 📁 New File Structure

```
culinaire/
├── index.php                    ✨ Dynamic homepage
├── all-recipes.php              ✨ Recipe browsing (MealDB)
├── recipe.php                   ✨ Single recipe template
├── blogs.php                    ✨ Blog listing
├── blog-detail.php              ✨ Blog viewer
├── blog-create.php              ✨ Blog creation form
├── blog-edit.php                ✨ Blog editing form
├── AboutUs.html                 (unchanged)
│
├── api/
│   ├── config.php               ✨ Database & utilities
│   └── blogs/
│       ├── create.php           ✨ POST /create
│       ├── read.php             ✨ GET /read
│       ├── read-single.php      ✨ GET /read-single
│       ├── update.php           ✨ PUT /update
│       └── delete.php           ✨ DELETE /delete
│
├── js/
│   ├── scripts.js               ✨ Simplified (toggleMenu only)
│   └── recipe-handler.js        ✨ MealDB integration
│
├── uploads/
│   └── blogs/
│       ├── thumbnails/          ✨ Blog thumbnail images
│       └── banners/             ✨ Blog banner images
│
├── database-setup.sql           ✨ Database creation script
└── MIGRATION-GUIDE.md           ✨ This file
```

---

## 🎯 Key Features

### Recipe System (MealDB)
- ✅ Thousands of recipes from MealDB
- ✅ Dynamic categories (Beef, Chicken, Dessert, etc.)
- ✅ Search functionality
- ✅ Auto-suggested recipes by category
- ✅ YouTube video integration
- ✅ Single dynamic template (no more 23 HTML files!)

### Blog System (MySQL)
- ✅ Create blogs with title, author, excerpt, content
- ✅ Upload thumbnail and banner images
- ✅ Edit existing blogs
- ✅ Delete blogs with confirmation
- ✅ No authentication required (public CRUD)
- ✅ Automatic slug generation from title

### Technical Stack
- ✅ PHP RESTful API
- ✅ MySQL database
- ✅ AJAX for data fetching
- ✅ MealDB API integration
- ✅ Apache server (htdocs)

---

## 🐛 Troubleshooting

### Issue: "Database connection failed"
- Check MySQL is running
- Verify credentials in `api/config.php`
- Ensure `culinaire_db` database exists

### Issue: "Blogs not showing"
- Run `database-setup.sql`
- Check blog images are copied to `uploads/blogs/`
- Open browser console for errors

### Issue: "Recipes not loading"
- Check internet connection (MealDB is external API)
- Open browser console to see API errors
- Try refreshing the page

### Issue: "Image upload fails"
- Check `uploads/blogs/` directories exist
- Verify folder permissions (755)
- Check file size (max 5MB)
- Ensure file is JPG, PNG, or WebP

### Issue: "404 errors on PHP files"
- Ensure Apache is running
- Check mod_rewrite is enabled
- Verify project is in htdocs folder

---

## 📝 API Endpoints Reference

### Blog API

**GET** `/api/blogs/read.php?limit=10&offset=0`
- Get all blogs with pagination

**GET** `/api/blogs/read-single.php?slug=kitchen-hacks`
- Get single blog by slug

**POST** `/api/blogs/create.php`
- Create new blog (multipart/form-data)
- Fields: title, author, excerpt, content, thumbnail, banner

**PUT** `/api/blogs/update.php`
- Update existing blog (application/x-www-form-urlencoded)
- Fields: id, title, author, excerpt, content

**DELETE** `/api/blogs/delete.php`
- Delete blog (application/json)
- Body: `{"id": 1}`

---

## 🎨 Design Preservation

All existing CSS classes and styling have been preserved:
- `.jost-semibold-30` - Titles
- `.julius-green` - Headers
- `.recipes-grid-container` - Grid layout
- `.view-button` - Action buttons
- All responsive breakpoints maintained

---

## 🚀 Next Steps (Optional)

1. **Add user authentication** for blog management
2. **Implement blog categories/tags**
3. **Add search for blogs**
4. **Implement recipe favorites** (using localStorage)
5. **Add comment system** for blogs
6. **Implement social sharing** buttons

---

## 📞 Support

If you encounter issues:
1. Check browser console for JavaScript errors
2. Check PHP error logs in XAMPP
3. Verify database connection
4. Ensure all files are in correct locations

---

## ✨ Success Metrics

- ✅ 23 static recipe files → 1 dynamic template
- ✅ Hardcoded blog posts → MySQL database
- ✅ Static categories → MealDB categories
- ✅ No search → Full text search
- ✅ Manual recipe updates → Automatic from MealDB
- ✅ No CRUD → Full blog CRUD operations

**Congratulations! Your Culinaire platform is now fully dynamic! 🎉**
