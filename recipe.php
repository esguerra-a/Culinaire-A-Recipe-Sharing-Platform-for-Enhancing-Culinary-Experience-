<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe - Culinaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="recipe-detailed-style.css">
</head>
<body>
    <header class="non-index-title-bar">
        <h1 class="non-index-title"><strong>CULINAIRE</strong></h1>
        <nav class="non-index-nav-container" id="navLinks">
          <a href="index.php" class="non-index-nav-item">Home</a>
          <a href="all-recipes.php" id="chosen-nav-item" class="non-index-nav-item" aria-current="page">Recipes</a>
          <a href="blogs.php" class="non-index-nav-item">Blogs</a>
          <a href="AboutUs.html" class="non-index-nav-item">About Us</a>
        </nav>
        <div id="burger-menu" onclick="toggleMenu()">
          <span></span>
          <span></span>
          <span></span>
        </div>
    </header>

    <header class="recipe-header">
        <div class="container-flex">
            <a href="all-recipes.php" class="back-link">← Back to Recipes</a>
            <div id="recipe-info">
                <h1 class="recipe-title">Loading...</h1>
                <p class="recipe-description">Please wait while we load the recipe...</p>
            </div>
        </div>
        <img src="" class="hero" alt="Recipe Image">
    </header>

    <div class="recipe-meta">
        <div class="meta-item">
            <strong>CATEGORY</strong><br>
            <span id="category-value">-</span>
        </div>
        <div class="meta-item">
            <strong>REGION</strong><br>
            <span id="region-value">-</span>
        </div>
    </div>

    <main class="recipe-content">
        <section>
            <h2>INGREDIENTS</h2>
            <ul class="ingredients">
                <li>Loading ingredients...</li>
            </ul>
        </section>

        <section class="instructions">
            <h2>INSTRUCTIONS</h2>
            <iframe
                src=""
                frameborder="0"
                width="424"
                height="238"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                style="display: none;">
            </iframe>
            <div class="step">
                <p>Loading instructions...</p>
            </div>
        </section>
    </main>

    <section id="suggested-recipes">
        <h2>SUGGESTED RECIPES</h2>
        <div class="background-suggested-recipes">
            <div class="recipe-cards">
                <!-- Suggested recipes will be loaded here -->
            </div>
        </div>
    </section>

    <footer>
        <p>Copyright © 2024 Culinaire. All Rights Reserved</p>
    </footer>

    <script src="scripts.js"></script>
    <script src="js/recipe-handler.js"></script>
    <script>
        // Load recipe on page load
        document.addEventListener('DOMContentLoaded', async function() {
            const urlParams = new URLSearchParams(window.location.search);
            const mealId = urlParams.get('id');

            if (!mealId) {
                alert('No recipe ID provided');
                window.location.href = 'all-recipes.php';
                return;
            }

            try {
                // Load main recipe
                const meal = await MealDBAPI.getMealDetails(mealId);

                if (meal) {
                    RecipeRenderer.renderRecipeDetail(meal);
                    await loadSuggestedRecipes(meal.strCategory);
                } else {
                    alert('Recipe not found');
                    window.location.href = 'all-recipes.php';
                }
            } catch (error) {
                console.error('Error loading recipe:', error);
                alert('Error loading recipe. Please try again.');
                window.location.href = 'all-recipes.php';
            }
        });

        /**
         * Load suggested recipes from the same category
         * @param {string} category - Category name
         */
        async function loadSuggestedRecipes(category) {
            try {
                const meals = await MealDBAPI.getMealsByCategory(category);
                const container = document.querySelector('.recipe-cards');
                container.innerHTML = '';

                // Get current recipe ID to exclude it
                const urlParams = new URLSearchParams(window.location.search);
                const currentMealId = urlParams.get('id');

                // Filter out current recipe and take first 3
                const suggestedMeals = meals
                    .filter(meal => meal.idMeal !== currentMealId)
                    .slice(0, 3);

                if (suggestedMeals.length === 0) {
                    // If no meals in category, get random meals
                    const randomMeals = await MealDBAPI.getRandomMeals(3);
                    suggestedMeals.push(...randomMeals);
                }

                suggestedMeals.forEach(meal => {
                    const card = document.createElement('div');
                    card.className = 'recipe-card';
                    card.innerHTML = `
                        <a href="recipe.php?id=${meal.idMeal}">
                            <img src="${meal.strMealThumb}"
                                 alt="${meal.strMeal}"
                                 class="suggested-recipe-image">
                            <h3 class="suggested-recipe-title">${meal.strMeal}</h3>
                        </a>
                    `;
                    container.appendChild(card);
                });
            } catch (error) {
                console.error('Error loading suggested recipes:', error);
            }
        }
    </script>
</body>
</html>
