/**
 * Culinaire - Main JavaScript File
 * Contains utility functions for the website
 */

/**
 * Toggle mobile navigation menu
 */
function toggleMenu() {
    const burgerMenu = document.getElementById("burger-menu");
    const navContainer = document.getElementById("navLinks");
    burgerMenu.classList.toggle("toggled");
    navContainer.classList.toggle("active");
}

// Note: All recipe-related functionality has been migrated to:
// - js/recipe-handler.js (MealDB API integration)
// - all-recipes.php (dynamic recipe loading)
// - recipe.php (dynamic recipe detail page)
// - index.php (homepage dynamic content)
