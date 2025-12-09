/**
 * Culinaire - MealDB API Integration
 * Handles all recipe data fetching and rendering
 */

// MealDB API Handler
const MealDBAPI = {
    baseURL: 'https://www.themealdb.com/api/json/v1/1/',

    /**
     * Fetch all categories from MealDB
     * @returns {Promise<Array>} Array of category objects
     */
    async getCategories() {
        try {
            const response = await fetch(`${this.baseURL}categories.php`);
            if (!response.ok) throw new Error('Failed to fetch categories');
            const data = await response.json();
            return data.categories || [];
        } catch (error) {
            console.error('Error fetching categories:', error);
            return [];
        }
    },

    /**
     * Search meals by name
     * @param {string} query - Search query
     * @returns {Promise<Array>} Array of meal objects
     */
    async searchMeals(query) {
        try {
            const response = await fetch(`${this.baseURL}search.php?s=${encodeURIComponent(query)}`);
            if (!response.ok) throw new Error('Search failed');
            const data = await response.json();
            return data.meals || [];
        } catch (error) {
            console.error('Error searching meals:', error);
            return [];
        }
    },

    /**
     * Get meals filtered by category
     * @param {string} category - Category name
     * @returns {Promise<Array>} Array of meal objects
     */
    async getMealsByCategory(category) {
        try {
            const response = await fetch(`${this.baseURL}filter.php?c=${encodeURIComponent(category)}`);
            if (!response.ok) throw new Error('Failed to fetch meals by category');
            const data = await response.json();
            return data.meals || [];
        } catch (error) {
            console.error('Error fetching meals by category:', error);
            return [];
        }
    },

    /**
     * Get detailed information about a meal by ID
     * @param {string} mealId - Meal ID
     * @returns {Promise<Object|null>} Meal object or null
     */
    async getMealDetails(mealId) {
        try {
            const response = await fetch(`${this.baseURL}lookup.php?i=${mealId}`);
            if (!response.ok) throw new Error('Failed to fetch meal details');
            const data = await response.json();
            return data.meals ? data.meals[0] : null;
        } catch (error) {
            console.error('Error fetching meal details:', error);
            return null;
        }
    },

    /**
     * Get random meals
     * @param {number} count - Number of random meals to fetch
     * @returns {Promise<Array>} Array of meal objects
     */
    async getRandomMeals(count = 3) {
        const meals = [];
        const promises = [];

        for (let i = 0; i < count; i++) {
            promises.push(
                fetch(`${this.baseURL}random.php`)
                    .then(response => response.json())
                    .then(data => data.meals ? data.meals[0] : null)
                    .catch(error => {
                        console.error('Error fetching random meal:', error);
                        return null;
                    })
            );
        }

        const results = await Promise.all(promises);
        return results.filter(meal => meal !== null);
    },

    /**
     * Parse ingredients from meal object
     * @param {Object} meal - Meal object from MealDB
     * @returns {Array} Array of ingredient objects with {ingredient, measure}
     */
    parseIngredients(meal) {
        const ingredients = [];

        for (let i = 1; i <= 20; i++) {
            const ingredient = meal[`strIngredient${i}`];
            const measure = meal[`strMeasure${i}`];

            if (ingredient && ingredient.trim()) {
                ingredients.push({
                    ingredient: ingredient.trim(),
                    measure: measure ? measure.trim() : ''
                });
            }
        }

        return ingredients;
    },

    /**
     * Parse instructions into steps
     * @param {string} instructions - Raw instruction text
     * @returns {Array} Array of instruction steps
     */
    parseInstructions(instructions) {
        if (!instructions) return [];

        // Split by newlines and filter empty lines
        let steps = instructions
            .split(/\r?\n/)
            .filter(step => step.trim().length > 0)
            .map(step => {
                // Remove various step numbering formats:
                // "STEP 1:", "Step 1.", "Step 1 -", "1.", "1)", "1 -", etc.
                return step
                    .replace(/^(STEP\s*)?\d+[\s.:)\-]+/i, '')  // Handles: STEP 1:, Step 1., 1., 1), 1 -
                    .replace(/^(STEP\s*)\d+$/i, '')            // Handles: just "STEP 1" or "1"
                    .trim();
            })
            .filter(step => step.length > 0 && !/^\d+$/.test(step)); // Remove steps that are just numbers

        // If no newlines, try splitting by periods followed by capital letters
        if (steps.length === 1) {
            steps = instructions
                .split(/\.\s+(?=[A-Z])/)
                .filter(step => step.trim().length > 0)
                .map(step => {
                    return step
                        .replace(/^(STEP\s*)?\d+[\s.:)\-]+/i, '')
                        .trim();
                })
                .filter(step => step.length > 0);
        }

        return steps.length > 0 ? steps : [instructions];
    }
};

// Recipe Renderer - Handles DOM manipulation for recipes
const RecipeRenderer = {
    /**
     * Create a recipe grid item (card) for recipe listing
     * @param {Object} meal - Meal object from MealDB
     * @returns {HTMLElement} Recipe card element
     */
    createRecipeGridItem(meal) {
        const item = document.createElement('div');
        item.className = 'recipes-grid-item recipes';

        const link = document.createElement('a');
        link.href = `recipe.php?id=${meal.idMeal}`;

        const imageDiv = document.createElement('div');
        imageDiv.className = 'recipes-grid-item-image';
        imageDiv.style.backgroundImage = `url(${meal.strMealThumb})`;
        link.appendChild(imageDiv);

        const textWrapper = document.createElement('div');
        textWrapper.className = 'text-wrapper';

        const title = document.createElement('h2');
        title.className = 'recipe-title jost-normal';
        title.textContent = meal.strMeal;
        textWrapper.appendChild(title);

        const description = document.createElement('p');
        description.className = 'recipe-description jost-normal';
        // Use category as description since MealDB doesn't provide descriptions
        description.textContent = `Delicious ${meal.strCategory || 'recipe'}`;
        textWrapper.appendChild(description);

        link.appendChild(textWrapper);
        item.appendChild(link);

        return item;
    },

    /**
     * Render full recipe details on recipe page
     * @param {Object} meal - Meal object from MealDB with full details
     */
    renderRecipeDetail(meal) {
        // Update page title
        document.title = `${meal.strMeal} - Culinaire`;

        // Update recipe header
        const titleElement = document.querySelector('.recipe-title');
        if (titleElement) {
            titleElement.textContent = meal.strMeal;
        }

        const descElement = document.querySelector('.recipe-description');
        if (descElement) {
            descElement.textContent = `${meal.strArea || ''} ${meal.strCategory || ''} recipe`.trim();
        }

        const heroImage = document.querySelector('.hero');
        if (heroImage) {
            heroImage.src = meal.strMealThumb;
            heroImage.alt = meal.strMeal;
        }

        // Update meta information
        const metaItems = document.querySelectorAll('.meta-item');
        if (metaItems.length >= 2) {
            // Category
            metaItems[0].innerHTML = `<strong>CATEGORY</strong><br>${meal.strCategory || 'N/A'}`;

            // Region (replacing TIME since MealDB doesn't have time)
            metaItems[1].innerHTML = `<strong>REGION</strong><br>${meal.strArea || 'International'}`;

            // Hide third meta item if it exists (was calories)
            if (metaItems[2]) {
                metaItems[2].style.display = 'none';
            }
        }

        // Render ingredients
        const ingredients = MealDBAPI.parseIngredients(meal);
        const ingredientsList = document.querySelector('.ingredients');
        if (ingredientsList) {
            ingredientsList.innerHTML = '';
            ingredients.forEach(item => {
                const li = document.createElement('li');
                li.textContent = `${item.measure} ${item.ingredient}`.trim();
                ingredientsList.appendChild(li);
            });
        }

        // Render instructions
        const steps = MealDBAPI.parseInstructions(meal.strInstructions);
        const instructionsSection = document.querySelector('.instructions');
        if (instructionsSection) {
            // Clear existing steps (keep iframe if it exists)
            const existingSteps = instructionsSection.querySelectorAll('.step');
            existingSteps.forEach(step => step.remove());

            // Update YouTube video if available
            const iframe = instructionsSection.querySelector('iframe');
            if (meal.strYoutube && iframe) {
                // Extract video ID from YouTube URL
                const videoId = meal.strYoutube.split('v=')[1]?.split('&')[0] ||
                               meal.strYoutube.split('/').pop();
                if (videoId) {
                    iframe.src = `https://www.youtube.com/embed/${videoId}`;
                    iframe.style.display = 'block';
                } else {
                    iframe.style.display = 'none';
                }
            } else if (iframe) {
                iframe.style.display = 'none';
            }

            // Add instruction steps
            steps.forEach((stepText, index) => {
                const stepDiv = document.createElement('div');
                stepDiv.className = 'step';
                stepDiv.innerHTML = `
                    <strong>Step ${index + 1}.</strong>
                    <p>${stepText}</p>
                `;
                instructionsSection.appendChild(stepDiv);
            });
        }
    },

    /**
     * Show loading spinner
     * @param {HTMLElement} container - Container to show spinner in
     */
    showLoading(container) {
        container.innerHTML = '<div class="loading-spinner"></div>';
    },

    /**
     * Show error message
     * @param {HTMLElement} container - Container to show error in
     * @param {string} message - Error message
     */
    showError(container, message) {
        container.innerHTML = `
            <div class="error-message">
                <h3>Oops! Something went wrong</h3>
                <p>${message || 'Unable to load recipes. Please try again later.'}</p>
                <button class="view-button" onclick="location.reload()">Retry</button>
            </div>
        `;
    },

    /**
     * Show "no results" message
     * @param {HTMLElement} container - Container to show message in
     */
    showNoResults(container) {
        container.innerHTML = `
            <div class="no-results-message">
                <p>No recipes found. Try a different search or category.</p>
            </div>
        `;
    }
};

// Export for use in other files if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { MealDBAPI, RecipeRenderer };
}
