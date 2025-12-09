@echo off
REM Culinaire - Cleanup Old Static Files
REM WARNING: This will DELETE old HTML files! Only run after testing!

echo ========================================
echo Culinaire - Cleanup Old Files
echo ========================================
echo.
echo WARNING: This will DELETE the following:
echo - Favorites.html
echo - 23 static recipe HTML files
echo - 4 static blog HTML files
echo.
echo Make sure you have TESTED the new site first!
echo.
set /p confirm="Are you sure you want to continue? (Y/N): "

if /i not "%confirm%"=="Y" (
    echo.
    echo Cleanup cancelled.
    pause
    exit /b
)

echo.
echo Deleting files...
echo.

REM Delete Favorites page
if exist "Favorites.html" (
    del "Favorites.html"
    echo [DELETED] Favorites.html
)

REM Delete recipe HTML files
if exist "Chicken-Adobo.html" del "Chicken-Adobo.html" & echo [DELETED] Chicken-Adobo.html
if exist "Chicken-Gravy.html" del "Chicken-Gravy.html" & echo [DELETED] Chicken-Gravy.html
if exist "Smash-Burger.html" del "Smash-Burger.html" & echo [DELETED] Smash-Burger.html
if exist "Real-American-Hamburger.html" del "Real-American-Hamburger.html" & echo [DELETED] Real-American-Hamburger.html
if exist "Lechon-Kawali.html" del "Lechon-Kawali.html" & echo [DELETED] Lechon-Kawali.html
if exist "Italian-Pasta.html" del "Italian-Pasta.html" & echo [DELETED] Italian-Pasta.html
if exist "Pork-Sisig.html" del "Pork-Sisig.html" & echo [DELETED] Pork-Sisig.html
if exist "Filet-Mignon.html" del "Filet-Mignon.html" & echo [DELETED] Filet-Mignon.html
if exist "Shrimp-Sinigang.html" del "Shrimp-Sinigang.html" & echo [DELETED] Shrimp-Sinigang.html
if exist "Creamy-Mushroom-Soup.html" del "Creamy-Mushroom-Soup.html" & echo [DELETED] Creamy-Mushroom-Soup.html
if exist "Chicken-Noodle-Soup.html" del "Chicken-Noodle-Soup.html" & echo [DELETED] Chicken-Noodle-Soup.html
if exist "Clam-Chowder.html" del "Clam-Chowder.html" & echo [DELETED] Clam-Chowder.html
if exist "Avocado-Salad.html" del "Avocado-Salad.html" & echo [DELETED] Avocado-Salad.html
if exist "Caesar-Salad.html" del "Caesar-Salad.html" & echo [DELETED] Caesar-Salad.html
if exist "Greek-Salad.html" del "Greek-Salad.html" & echo [DELETED] Greek-Salad.html
if exist "Tomato-Salad.html" del "Tomato-Salad.html" & echo [DELETED] Tomato-Salad.html
if exist "CheeseCake.html" del "CheeseCake.html" & echo [DELETED] CheeseCake.html
if exist "CassavaCake.html" del "CassavaCake.html" & echo [DELETED] CassavaCake.html
if exist "BananaWithChocolate.html" del "BananaWithChocolate.html" & echo [DELETED] BananaWithChocolate.html
if exist "Classic-Strawberry-Shortcake.html" del "Classic-Strawberry-Shortcake.html" & echo [DELETED] Classic-Strawberry-Shortcake.html
if exist "Tasty-Mozarella-Buns.html" del "Tasty-Mozarella-Buns.html" & echo [DELETED] Tasty-Mozarella-Buns.html
if exist "Mushroom-Pizza.html" del "Mushroom-Pizza.html" & echo [DELETED] Mushroom-Pizza.html
if exist "Kare-kare.html" del "Kare-kare.html" & echo [DELETED] Kare-kare.html

REM Delete blog HTML files
if exist "Kitchen-Hacks.html" del "Kitchen-Hacks.html" & echo [DELETED] Kitchen-Hacks.html
if exist "5-Ways.html" del "5-Ways.html" & echo [DELETED] 5-Ways.html
if exist "Bites.html" del "Bites.html" & echo [DELETED] Bites.html
if exist "Spice.html" del "Spice.html" & echo [DELETED] Spice.html

REM Also delete old HTML files that are now PHP
if exist "index.html" del "index.html" & echo [DELETED] index.html
if exist "All-Recipes.html" del "All-Recipes.html" & echo [DELETED] All-Recipes.html
if exist "Blogs.html" del "Blogs.html" & echo [DELETED] Blogs.html

echo.
echo ========================================
echo Cleanup complete!
echo ========================================
echo.
echo Old files have been deleted.
echo Your site now uses the new dynamic PHP files.
echo.
pause
