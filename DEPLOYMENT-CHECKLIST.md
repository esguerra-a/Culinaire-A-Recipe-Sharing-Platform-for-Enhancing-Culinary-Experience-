# Culinaire Deployment Checklist

## ✅ Pre-Deployment Steps (Do BEFORE copying to htdocs)

### Step 1: Setup Blog Images
- [ ] Run `setup-blog-images.bat` script
- [ ] Verify images copied to `uploads/blogs/thumbnails/`
- [ ] Verify images copied to `uploads/blogs/banners/`

---

## 🚀 Deployment to htdocs

### Step 2: Copy to htdocs
- [ ] Copy entire project folder to `C:\xampp\htdocs\culinaire\`
- [ ] Verify all files are present

### Step 3: Start XAMPP
- [ ] Start Apache service
- [ ] Start MySQL service
- [ ] Both services showing "Running" (green)

### Step 4: Database Setup
- [ ] Open phpMyAdmin: `http://localhost/phpmyadmin`
- [ ] Click "SQL" tab
- [ ] Copy entire contents of `database-setup.sql`
- [ ] Paste and click "Go"
- [ ] Verify: Should see "4 rows inserted"
- [ ] Check: culinaire_db → blogs → Browse (should show 4 entries)

---

## 🧪 Testing Phase

### Step 5: Test Homepage
- [ ] Open: `http://localhost/culinaire/index.php`
- [ ] ✅ Featured recipes load from MealDB (3 recipes with images)
- [ ] ✅ Categories load from MealDB (6 categories)
- [ ] ✅ Recently added recipes show (5 recipes)
- [ ] ✅ Latest blogs show (3 blogs with images)
- [ ] ✅ Navigation links work
- [ ] ✅ No console errors (F12)

### Step 6: Test Recipe System
- [ ] Open: `http://localhost/culinaire/all-recipes.php`
- [ ] ✅ Categories carousel loads
- [ ] ✅ Click category → recipes filter correctly
- [ ] ✅ Search "chicken" → results appear
- [ ] ✅ Pagination buttons work (if >6 recipes)
- [ ] ✅ Click recipe → opens recipe.php with details
- [ ] ✅ Recipe page shows: title, image, ingredients, instructions
- [ ] ✅ YouTube video loads (if available)
- [ ] ✅ Suggested recipes appear at bottom

### Step 7: Test Blog Listing
- [ ] Open: `http://localhost/culinaire/blogs.php`
- [ ] ✅ Shows 4 blog posts
- [ ] ✅ All thumbnails load correctly
- [ ] ✅ Author names display
- [ ] ✅ "Create New Blog" button present
- [ ] ✅ "Read More" buttons work

### Step 8: Test Blog Detail
- [ ] Click any "Read More" button
- [ ] ✅ Banner image loads
- [ ] ✅ Full content displays
- [ ] ✅ Author name shows
- [ ] ✅ Date displays correctly
- [ ] ✅ "Edit Blog" button present
- [ ] ✅ "Delete Blog" button present
- [ ] ✅ Recent blogs sidebar shows

### Step 9: Test Blog Create
- [ ] Open: `http://localhost/culinaire/blog-create.php`
- [ ] Fill test data:
  - Title: "Test Blog"
  - Author: "Test Author"
  - Excerpt: "Test excerpt"
  - Content: `<p>Test content</p>`
  - Thumbnail: Select image (<5MB, JPG/PNG)
  - Banner: Select image (<5MB, JPG/PNG)
- [ ] Click "Create Blog Post"
- [ ] ✅ Redirects to blog detail page
- [ ] ✅ New blog appears in blogs.php

### Step 10: Test Blog Edit
- [ ] Open any blog detail page
- [ ] Click "Edit Blog"
- [ ] Change title to "Updated Test"
- [ ] Click "Update Blog Post"
- [ ] ✅ Redirects back to detail
- [ ] ✅ Title updated correctly
- [ ] ✅ Slug may have changed

### Step 11: Test Blog Delete
- [ ] Open test blog detail page
- [ ] Click "Delete Blog"
- [ ] ✅ Confirmation modal appears
- [ ] Click "Cancel" → modal closes
- [ ] Click "Delete Blog" again
- [ ] Click "Yes, Delete"
- [ ] ✅ Redirects to blogs.php
- [ ] ✅ Blog removed from list
- [ ] Check: Images deleted from uploads folder

### Step 12: Test API Endpoints Directly
- [ ] `http://localhost/culinaire/api/blogs/read.php`
  - [ ] ✅ Returns JSON with blog list
- [ ] `http://localhost/culinaire/api/blogs/read-single.php?slug=kitchen-hacks`
  - [ ] ✅ Returns JSON with single blog

### Step 13: Test Navigation
- [ ] Test all nav links from homepage
- [ ] Test all nav links from recipe pages
- [ ] Test all nav links from blog pages
- [ ] Test About Us page
- [ ] ✅ All links work correctly
- [ ] ✅ No Favorites link anywhere

### Step 14: Test Responsive Design
- [ ] Resize browser window
- [ ] ✅ Mobile menu (hamburger) works
- [ ] ✅ Layout adjusts correctly
- [ ] Test on mobile device (if available)

---

## 🐛 Troubleshooting

### If Homepage Doesn't Load
- [ ] Check Apache is running
- [ ] Check URL is `http://localhost/culinaire/index.php`
- [ ] Check project is in correct folder

### If Recipes Don't Load
- [ ] Check internet connection (MealDB needs internet)
- [ ] Open browser console (F12) for errors
- [ ] Try refreshing page

### If Blogs Don't Show
- [ ] Verify database-setup.sql was run
- [ ] Check images are in uploads/blogs/
- [ ] Test API: `http://localhost/culinaire/api/blogs/read.php`
- [ ] Check MySQL is running

### If Image Upload Fails
- [ ] Check uploads/blogs/ folders exist
- [ ] Check folder permissions
- [ ] Verify file size <5MB
- [ ] Check file type (JPG, PNG, WebP only)

---

## 🧹 Cleanup (Do AFTER all tests pass!)

### Step 15: Clean Up Old Files
- [ ] **IMPORTANT:** Only do this after everything works!
- [ ] Run `cleanup-old-files.bat` script
- [ ] OR manually delete:
  - [ ] Favorites.html
  - [ ] All 23 recipe HTML files
  - [ ] All 4 blog HTML files
  - [ ] Old index.html, All-Recipes.html, Blogs.html

---

## ✅ Final Verification

### Step 16: Final Checks
- [ ] All features working
- [ ] No console errors
- [ ] All images loading
- [ ] Database has data
- [ ] Old files deleted
- [ ] Navigation all uses .php links
- [ ] No Favorites references anywhere

---

## 🎉 Deployment Complete!

### Success Criteria
✅ Homepage loads with MealDB recipes
✅ Recipe browsing works
✅ Recipe detail pages work
✅ Blog CRUD fully functional
✅ No old static files
✅ All navigation updated
✅ Database operational
✅ API endpoints working

---

## 📊 Before & After Summary

| Feature | Before | After |
|---------|--------|-------|
| Recipe Pages | 23 static HTML | 1 dynamic template |
| Recipe Count | 23 | Thousands (MealDB) |
| Blog Management | 4 static HTML | MySQL + CRUD |
| Search | None | Full search |
| Data Updates | Manual | Automatic (MealDB) |

---

## 🔜 Optional Enhancements

- [ ] Add user authentication
- [ ] Implement blog categories
- [ ] Add comment system
- [ ] Social media sharing
- [ ] Recipe favorites
- [ ] Advanced search

---

**Congratulations! Your Culinaire platform is now fully dynamic! 🎉**
