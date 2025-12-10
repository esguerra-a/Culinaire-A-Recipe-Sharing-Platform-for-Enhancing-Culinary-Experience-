<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Culinaire - Recipes</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    <section id="categories" class="recipes-page-section">
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search for a recipe..." name="search">
            <button type="button" id="searchButton"><i class="fa fa-search"></i></button>
        </div>
        <br>
        <h2 class="julius-black">Category</h2>
        <div class="carousel-container">
            <div class="carousel-wrapper">
                <button class="prev-btn" id="prevCategoryBtn"><i class="fa fa-chevron-left"></i></button>
                <div class="options-container">
                    <!-- Categories will be dynamically loaded here -->
                </div>
                <button class="next-btn" id="nextCategoryBtn"><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>
    </section>

    <section id="forYouRecipesSection" class="recipes-page-section">
        <div id="forYouRecipes">
            <h2 class="julius-green recipes-heading">Recipes</h2>
            <div class="recipes-grid-container">
                <!-- Recipes will be dynamically generated here -->
            </div>
            <div class="pagination" style="display: none;">
                <button id="prevGridBtn" class="pagination-btn">Prev</button>
                <button id="nextGridBtn" class="pagination-btn">Next</button>
            </div>
        </div>
    </section>

    <footer>
        Copyright &copy; Culinaire 2024. All Rights Reserved
    </footer>

    <script src="scripts.js"></script>
    <script src="js/recipe-handler.js"></script>
    <script>
        // State management
        let allCategories = [];
        let currentCategoryIndex = 0;
        let visibleCategoryCount = getVisibleCategoryCount();
        let currentCategory = null;
        let allMeals = [];
        let currentPage = 0;
        const mealsPerPage = 6;
        let slideDirection = '';
        let touchStartX = 0;
        let touchEndX = 0;

        /**
         * Get visible category count based on screen size
         */
        function getVisibleCategoryCount() {
            return window.innerWidth <= 768 ? 2 : 4;
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', async function() {
            await loadCategories();

            // Check if category parameter exists in URL
            const urlParams = new URLSearchParams(window.location.search);
            const categoryParam = urlParams.get('category');

            if (categoryParam && allCategories.length > 0) {
                // Find the category in our list
                const categoryIndex = allCategories.findIndex(cat => cat.strCategory === categoryParam);

                if (categoryIndex !== -1) {
                    // Navigate to the page containing this category
                    const pageIndex = Math.floor(categoryIndex / visibleCategoryCount);
                    currentCategoryIndex = pageIndex * visibleCategoryCount;
                    renderCategories();

                    // Auto-select the category
                    setTimeout(() => {
                        const categoryElement = document.querySelector(`[data-category="${categoryParam}"]`);
                        if (categoryElement) {
                            selectCategory(categoryParam, categoryElement);
                        }
                    }, 100);
                } else {
                    await loadDefaultRecipes();
                }
            } else {
                await loadDefaultRecipes();
            }

            setupEventListeners();
            setupKeyboardNavigation();
            setupTouchGestures();
            setupResizeHandler();
        });

        /**
         * Handle window resize to adjust visible categories
         */
        function setupResizeHandler() {
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    const newCount = getVisibleCategoryCount();
                    if (newCount !== visibleCategoryCount) {
                        visibleCategoryCount = newCount;
                        currentCategoryIndex = 0; // Reset to first page
                        renderCategories();
                    }
                }, 250);
            });
        }

        /**
         * Setup event listeners
         */
        function setupEventListeners() {
            document.getElementById('searchButton').addEventListener('click', searchRecipes);
            document.getElementById('searchInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchRecipes();
                }
            });

            document.getElementById('prevGridBtn').addEventListener('click', prevGrid);
            document.getElementById('nextGridBtn').addEventListener('click', nextGrid);
            document.getElementById('prevCategoryBtn').addEventListener('click', () => {
                slideDirection = 'left';
                prevCategory();
            });
            document.getElementById('nextCategoryBtn').addEventListener('click', () => {
                slideDirection = 'right';
                nextCategory();
            });
        }

        /**
         * Setup keyboard navigation
         */
        function setupKeyboardNavigation() {
            document.addEventListener('keydown', (e) => {
                // Only activate if not typing in input field
                if (document.activeElement.tagName === 'INPUT') return;

                if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    slideDirection = 'left';
                    prevCategory();
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    slideDirection = 'right';
                    nextCategory();
                }
            });
        }

        /**
         * Setup touch/swipe gestures for mobile
         */
        function setupTouchGestures() {
            const container = document.querySelector('.options-container');

            container.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            });

            container.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });
        }

        /**
         * Handle swipe gesture
         */
        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left - show next
                    slideDirection = 'right';
                    nextCategory();
                } else {
                    // Swipe right - show prev
                    slideDirection = 'left';
                    prevCategory();
                }
            }
        }

        /**
         * Load categories from MealDB
         */
        async function loadCategories() {
            const container = document.querySelector('.options-container');
            showLoadingSkeleton(container);

            allCategories = await MealDBAPI.getCategories();

            if (allCategories.length === 0) {
                container.innerHTML = '<p>Unable to load categories</p>';
                return;
            }

            renderCategories();
        }

        /**
         * Show loading skeleton for categories
         */
        function showLoadingSkeleton(container) {
            container.innerHTML = '';
            for (let i = 0; i < visibleCategoryCount; i++) {
                const skeleton = document.createElement('div');
                skeleton.className = 'skeleton-option';
                container.appendChild(skeleton);
            }
        }

        /**
         * Render visible categories in the carousel
         */
        function renderCategories() {
            const container = document.querySelector('.options-container');

            // Add slide animation class
            if (slideDirection) {
                container.classList.remove('slide-left', 'slide-right');
                void container.offsetWidth; // Force reflow
                container.classList.add(slideDirection === 'left' ? 'slide-left' : 'slide-right');
                slideDirection = '';
            }

            container.innerHTML = '';

            const endIndex = Math.min(currentCategoryIndex + visibleCategoryCount, allCategories.length);
            const visibleCategories = allCategories.slice(currentCategoryIndex, endIndex);

            visibleCategories.forEach((category, index) => {
                const option = document.createElement('div');
                option.className = 'option';
                option.style.backgroundImage = `url(${category.strCategoryThumb})`;
                option.dataset.category = category.strCategory;
                option.dataset.recipeCount = '25+ recipes'; // Placeholder - MealDB doesn't provide exact counts

                const heading = document.createElement('h5');
                heading.className = 'jost-semibold-30';
                heading.textContent = category.strCategory;
                option.appendChild(heading);

                option.addEventListener('click', () => selectCategory(category.strCategory, option));
                container.appendChild(option);
            });

        }

        /**
         * Navigate to previous set of categories (with infinite loop)
         */
        function prevCategory() {
            currentCategoryIndex -= visibleCategoryCount;

            // Loop to the end if we go below 0
            if (currentCategoryIndex < 0) {
                const totalPages = Math.ceil(allCategories.length / visibleCategoryCount);
                currentCategoryIndex = (totalPages - 1) * visibleCategoryCount;
            }

            renderCategories();

            // Re-apply selection if a category was selected
            if (currentCategory) {
                highlightSelectedCategory();
            }
        }

        /**
         * Navigate to next set of categories (with infinite loop)
         */
        function nextCategory() {
            currentCategoryIndex += visibleCategoryCount;

            // Loop back to start if we reach the end
            if (currentCategoryIndex >= allCategories.length) {
                currentCategoryIndex = 0;
            }

            renderCategories();

            // Re-apply selection if a category was selected
            if (currentCategory) {
                highlightSelectedCategory();
            }
        }

        /**
         * Highlight the currently selected category
         */
        function highlightSelectedCategory() {
            document.querySelectorAll('.option').forEach(opt => {
                if (opt.dataset.category === currentCategory) {
                    opt.classList.add('selected');
                } else {
                    opt.classList.remove('selected');
                }
            });
        }

        /**
         * Select a category
         */
        async function selectCategory(categoryName, element) {
            const container = document.querySelector('.recipes-grid-container');

            // Toggle selection
            if (currentCategory === categoryName) {
                currentCategory = null;
                element.classList.remove('selected');
                await loadDefaultRecipes();
            } else {
                // Remove previous selection
                document.querySelectorAll('.option').forEach(opt => opt.classList.remove('selected'));

                currentCategory = categoryName;
                element.classList.add('selected');

                // Load meals for this category
                RecipeRenderer.showLoading(container);
                const meals = await MealDBAPI.getMealsByCategory(categoryName);

                // Fetch full details for each meal (MealDB filter endpoint only returns limited data)
                const detailedMeals = [];
                for (const meal of meals.slice(0, 12)) { // Limit to 12 meals
                    const fullMeal = await MealDBAPI.getMealDetails(meal.idMeal);
                    if (fullMeal) detailedMeals.push(fullMeal);
                }

                allMeals = detailedMeals;
                currentPage = 0;
                renderMeals();

                // Auto-scroll to recipes section
                setTimeout(() => {
                    const recipesSection = document.getElementById('forYouRecipesSection');
                    recipesSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 300);
            }
        }

        /**
         * Load default recipes (random meals)
         */
        async function loadDefaultRecipes() {
            const container = document.querySelector('.recipes-grid-container');
            RecipeRenderer.showLoading(container);

            allMeals = await MealDBAPI.getRandomMeals(12);
            currentPage = 0;
            renderMeals();
        }

        /**
         * Render meals in the grid
         */
        function renderMeals() {
            const container = document.querySelector('.recipes-grid-container');
            container.innerHTML = '';

            const start = currentPage * mealsPerPage;
            const end = start + mealsPerPage;
            const mealsToShow = allMeals.slice(start, end);

            if (mealsToShow.length === 0) {
                RecipeRenderer.showNoResults(container);
                document.querySelector('.pagination').style.display = 'none';
                return;
            }

            mealsToShow.forEach(meal => {
                const item = RecipeRenderer.createRecipeGridItem(meal);
                container.appendChild(item);
            });

            // Show/hide pagination
            if (allMeals.length > mealsPerPage) {
                document.querySelector('.pagination').style.display = 'flex';
                updatePaginationButtons();
            } else {
                document.querySelector('.pagination').style.display = 'none';
            }
        }

        /**
         * Update pagination button states
         */
        function updatePaginationButtons() {
            const prevBtn = document.getElementById('prevGridBtn');
            const nextBtn = document.getElementById('nextGridBtn');

            prevBtn.disabled = currentPage === 0;
            nextBtn.disabled = (currentPage + 1) * mealsPerPage >= allMeals.length;
        }

        /**
         * Navigate to next page of recipes
         */
        function nextGrid() {
            if ((currentPage + 1) * mealsPerPage < allMeals.length) {
                currentPage++;
                renderMeals();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        /**
         * Navigate to previous page of recipes
         */
        function prevGrid() {
            if (currentPage > 0) {
                currentPage--;
                renderMeals();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        /**
         * Search recipes
         */
        async function searchRecipes() {
            const query = document.getElementById('searchInput').value.trim();
            const container = document.querySelector('.recipes-grid-container');

            if (query === '') {
                if (currentCategory) {
                    const meals = await MealDBAPI.getMealsByCategory(currentCategory);
                    const detailedMeals = [];
                    for (const meal of meals.slice(0, 12)) {
                        const fullMeal = await MealDBAPI.getMealDetails(meal.idMeal);
                        if (fullMeal) detailedMeals.push(fullMeal);
                    }
                    allMeals = detailedMeals;
                } else {
                    await loadDefaultRecipes();
                }
            } else {
                RecipeRenderer.showLoading(container);
                const meals = await MealDBAPI.searchMeals(query);
                allMeals = meals || [];
            }

            currentPage = 0;
            renderMeals();
        }
    </script>
</body>
</html>
