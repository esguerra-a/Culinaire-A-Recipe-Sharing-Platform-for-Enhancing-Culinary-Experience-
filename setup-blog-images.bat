@echo off
REM Culinaire - Blog Images Setup Script
REM This script copies existing blog images to the new uploads directory

echo ========================================
echo Culinaire - Blog Images Setup
echo ========================================
echo.

REM Check if uploads directories exist
if not exist "uploads\blogs\thumbnails\" (
    echo Creating thumbnails directory...
    mkdir "uploads\blogs\thumbnails"
)

if not exist "uploads\blogs\banners\" (
    echo Creating banners directory...
    mkdir "uploads\blogs\banners"
)

echo.
echo Copying blog thumbnail images...
echo.

REM Copy thumbnails
if exist "Blogs_Images\kitchen-hacks.jpg" (
    copy "Blogs_Images\kitchen-hacks.jpg" "uploads\blogs\thumbnails\kitchen-hacks.jpg"
    echo [OK] kitchen-hacks.jpg
) else (
    echo [SKIP] kitchen-hacks.jpg not found
)

if exist "Blogs_Images\budget-friendly-bites.jpg" (
    copy "Blogs_Images\budget-friendly-bites.jpg" "uploads\blogs\thumbnails\budget-friendly-bites.jpg"
    echo [OK] budget-friendly-bites.jpg
) else (
    echo [SKIP] budget-friendly-bites.jpg not found
)

if exist "Blogs_Images\spice-up-your-life.jpg" (
    copy "Blogs_Images\spice-up-your-life.jpg" "uploads\blogs\thumbnails\spice-up-your-life.jpg"
    echo [OK] spice-up-your-life.jpg
) else (
    echo [SKIP] spice-up-your-life.jpg not found
)

if exist "Blogs_Images\5-Ways-Healthy-Cooking-Classes-Can-Help-With-Your-Diet.jpg" (
    copy "Blogs_Images\5-Ways-Healthy-Cooking-Classes-Can-Help-With-Your-Diet.jpg" "uploads\blogs\thumbnails\5-ways-healthy-cooking.jpg"
    echo [OK] 5-ways-healthy-cooking.jpg
) else (
    echo [SKIP] 5-ways-healthy-cooking.jpg not found
)

echo.
echo Copying blog banner images...
echo.

REM Try to find and copy banners from BLOGS-DETAILED
if exist "BLOGS-DETAILED\KITCHEN-HACKS\banner.jpg" (
    copy "BLOGS-DETAILED\KITCHEN-HACKS\banner.jpg" "uploads\blogs\banners\kitchen-hacks.jpg"
    echo [OK] kitchen-hacks banner
) else (
    REM Use thumbnail as fallback
    if exist "uploads\blogs\thumbnails\kitchen-hacks.jpg" (
        copy "uploads\blogs\thumbnails\kitchen-hacks.jpg" "uploads\blogs\banners\kitchen-hacks.jpg"
        echo [FALLBACK] Using thumbnail as banner for kitchen-hacks
    )
)

if exist "BLOGS-DETAILED\BUDGET-FRIENDLY\banner.jpg" (
    copy "BLOGS-DETAILED\BUDGET-FRIENDLY\banner.jpg" "uploads\blogs\banners\budget-friendly-bites.jpg"
    echo [OK] budget-friendly-bites banner
) else (
    if exist "uploads\blogs\thumbnails\budget-friendly-bites.jpg" (
        copy "uploads\blogs\thumbnails\budget-friendly-bites.jpg" "uploads\blogs\banners\budget-friendly-bites.jpg"
        echo [FALLBACK] Using thumbnail as banner for budget-friendly-bites
    )
)

if exist "BLOGS-DETAILED\SPICES\banner.jpg" (
    copy "BLOGS-DETAILED\SPICES\banner.jpg" "uploads\blogs\banners\spice-up-your-life.jpg"
    echo [OK] spice-up-your-life banner
) else (
    if exist "uploads\blogs\thumbnails\spice-up-your-life.jpg" (
        copy "uploads\blogs\thumbnails\spice-up-your-life.jpg" "uploads\blogs\banners\spice-up-your-life.jpg"
        echo [FALLBACK] Using thumbnail as banner for spice-up-your-life
    )
)

if exist "BLOGS-DETAILED\5-WAYS\banner.jpg" (
    copy "BLOGS-DETAILED\5-WAYS\banner.jpg" "uploads\blogs\banners\5-ways-healthy-cooking.jpg"
    echo [OK] 5-ways-healthy-cooking banner
) else (
    if exist "uploads\blogs\thumbnails\5-ways-healthy-cooking.jpg" (
        copy "uploads\blogs\thumbnails\5-ways-healthy-cooking.jpg" "uploads\blogs\banners\5-ways-healthy-cooking.jpg"
        echo [FALLBACK] Using thumbnail as banner for 5-ways-healthy-cooking
    )
)

echo.
echo ========================================
echo Blog images setup complete!
echo ========================================
echo.
echo Next steps:
echo 1. Run database-setup.sql in phpMyAdmin
echo 2. Test the website
echo.
pause
