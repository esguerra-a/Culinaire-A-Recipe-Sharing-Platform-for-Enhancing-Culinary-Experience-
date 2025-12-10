<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Culinaire - Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="home-title-bar">
        <h1 class="index-title">CULINAIRE</h1>
        <nav class="nav-container" id="navLinks">
            <a id="chosen-nav-item" class="nav-item" aria-current="page">Home</a>
            <a href="all-recipes.php" class="nav-item">Recipes</a>
            <a href="blogs.php" class="nav-item">Blogs</a>
            <a href="AboutUs.html" class="nav-item">About Us</a>
        </nav>
        <div id="burger-menu" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <main class="main-container">
        <div class="header-container">
            <h1 class="main-header inria-serif-white"><b>Your Daily Dose of Flavor</b></h1>
            <h3 class="sub-header inria-serif-white">Satisfy your cravings with daily updated recipes</h3>
        </div>
    </main>

    <!-- Featured Recipes -->
    <section class="section-container">
        <h6 class="featured inter-green-20">Featured Recipes</h6>
        <div class="featured-recipes">
            <!-- Will be loaded dynamically -->
            <p style="text-align: center; padding: 20px;">Loading featured recipes...</p>
        </div>
    </section>

    <!-- Most Popular Categories -->
    <section id="popular" class="section-container-mustard-bg">
        <h2 class="section-header julius-green">Most Popular Categories</h2>
        <h4 class="section-subheader julius-green">Don't miss out on these top categories! Explore and enjoy cooking your favorites today!</h4>
        <div class="category-grid-container">
            <!-- Will be loaded dynamically -->
        </div>
    </section>

    <!-- Recently Added Recipes -->
    <section id="recently" class="section-container">
        <h2 class="section-header julius-green">For You Recipes</h2>
        <div class="wrap-flex-container recently-added-items-container">
            <!-- Will be loaded dynamically -->
            <p style="text-align: center; padding: 20px;">Loading recipes...</p>
        </div>
        <a href="all-recipes.php"><button class="view-button">View Recipes</button></a>
    </section>

    <!-- Latest Blogs -->
    <section id="blogs">
        <h2 class="section-header julius-green">Latest from the Blogs</h2>
        <div class="blogs-container">
            <!-- Will be loaded dynamically -->
            <p style="text-align: center; padding: 20px;">Loading blogs...</p>
        </div>
    </section>

    <!-- Stay Connected -->
    <div class="stay-connected section-container-mustard-bg">
        <h2 class="inter-green-light">STAY CONNECTED WITH</h2>
        <h2 class="footer-title"><strong>CULINAIRE</strong></h2>
        <div>
            <span id="facebook-logo"><a class="social-media-logo" href="https://www.facebook.com" target="_blank"><img src="Home_Images/facebook_logo.png" alt="facebook_logo"></a></span>
            <span id="x-logo"><a class="social-media-logo" href="https://www.x.com" target="_blank"><img src="Home_Images/x_logo.png" alt="x_logo"></a></span>
            <span id="instagram-logo"><a class="social-media-logo" href="https://www.instagram.com" target="_blank"><img src="Home_Images/instagram_logo.png" alt="instagram_logo"></a></span>
            <span id="linkedin-logo"><a class="social-media-logo" href="https://www.linkedin.com" target="_blank"><img src="Home_Images/linkedin_logo.png" alt="linkedin_logo"></a></span>
        </div>
    </div>

    <footer>
        Copyright &copy; Culinaire 2024. All Rights Reserved.
    </footer>

    <script src="scripts.js"></script>
    <script src="js/recipe-handler.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            await Promise.all([
                loadFeaturedRecipes(),
                loadCategories(),
                loadRecentRecipes(),
                loadLatestBlogs()
            ]);
        });

        /**
         * Load 3 random featured recipes from MealDB
         */
        async function loadFeaturedRecipes() {
            try {
                const meals = await MealDBAPI.getRandomMeals(3);
                const container = document.querySelector('.featured-recipes');
                container.innerHTML = '';

                meals.forEach((meal, index) => {
                    const div = document.createElement('div');
                    div.className = 'featured-item-container';
                    div.innerHTML = `
                        <a href="recipe.php?id=${meal.idMeal}"
                           id="featured-item-${index + 1}"
                           class="featured-item jost-semibold-30 item-container item-link"
                           style="background-image: url(${meal.strMealThumb})">
                            <h3 class="item-name">${meal.strMeal}</h3>
                        </a>
                    `;
                    container.appendChild(div);
                });
            } catch (error) {
                console.error('Error loading featured recipes:', error);
                document.querySelector('.featured-recipes').innerHTML = '<p>Unable to load featured recipes</p>';
            }
        }

        /**
         * Load categories from MealDB
         */
        async function loadCategories() {
            try {
                const allCategories = await MealDBAPI.getCategories();
                const container = document.querySelector('.category-grid-container');
                container.innerHTML = '';

                // Take first 6 categories
                const categories = allCategories.slice(0, 6);

                categories.forEach((category, index) => {
                    const div = document.createElement('div');
                    div.id = `${category.strCategory.toLowerCase()}-category`;
                    div.className = 'item-container category-item';
                    div.style.backgroundImage = `url(${category.strCategoryThumb})`;
                    div.innerHTML = `
                        <a href="all-recipes.php?category=${encodeURIComponent(category.strCategory)}" class="item-link jost-semibold-30" style="grid-column: span 2;">
                            <h3 class="item-name">${category.strCategory}</h3>
                        </a>
                    `;
                    container.appendChild(div);
                });
            } catch (error) {
                console.error('Error loading categories:', error);
            }
        }

        /**
         * Load 5 random recently added recipes
         */
        async function loadRecentRecipes() {
            try {
                const meals = await MealDBAPI.getRandomMeals(5);
                const container = document.querySelector('.recently-added-items-container');
                container.innerHTML = '';

                meals.forEach(meal => {
                    const div = document.createElement('div');
                    div.className = 'item-container recently-added-item';
                    div.style.backgroundImage = `url(${meal.strMealThumb})`;
                    div.innerHTML = `
                        <a href="recipe.php?id=${meal.idMeal}" class="item-link">
                            <h3 class="item-name jost-semibold-30">${meal.strMeal}</h3>
                        </a>
                    `;
                    container.appendChild(div);
                });
            } catch (error) {
                console.error('Error loading recent recipes:', error);
                document.querySelector('.recently-added-items-container').innerHTML = '<p>Unable to load recipes</p>';
            }
        }

        /**
         * Load latest 3 blogs from database
         */
        async function loadLatestBlogs() {
            try {
                const response = await fetch('api/blogs/read.php?limit=3');
                const data = await response.json();

                const container = document.querySelector('.blogs-container');
                container.innerHTML = '';

                if (data.success && data.blogs.length > 0) {
                    data.blogs.forEach(blog => {
                        const div = document.createElement('div');
                        div.className = 'blog-item';
                        div.innerHTML = `
                            <a href="blog-detail.php?slug=${blog.slug}" class="blog-link inter-black">
                                <img class="item-image" src="${blog.thumbnail_path}"
                                     alt="${blog.title}" width="230" height="143.24">
                                <div class="blog-text-wrapper">
                                    <h4 class="inter-black"><strong>${blog.author}</strong></h4>
                                    <p class="blog-text inter-black">${blog.title}</p>
                                </div>
                            </a>
                        `;
                        container.appendChild(div);
                    });
                } else {
                    container.innerHTML = '<p style="text-align: center;">No blogs available yet.</p>';
                }
            } catch (error) {
                console.error('Error loading blogs:', error);
                document.querySelector('.blogs-container').innerHTML = '<p>Unable to load blogs</p>';
            }
        }
    </script>
</body>
</html>
