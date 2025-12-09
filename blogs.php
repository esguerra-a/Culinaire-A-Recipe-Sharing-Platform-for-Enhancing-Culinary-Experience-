<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Culinaire - Blogs</title>
</head>
<body>
    <header class="non-index-title-bar">
        <h1 class="non-index-title">CULINAIRE</h1>
        <nav class="non-index-nav-container" id="navLinks">
          <a href="index.php" class="non-index-nav-item">Home</a>
          <a href="all-recipes.php" class="non-index-nav-item">Recipes</a>
          <a href="blogs.php" id="chosen-nav-item" class="non-index-nav-item" aria-current="page">Blogs</a>
          <a href="AboutUs.html" class="non-index-nav-item">About Us</a>
        </nav>
        <div id="burger-menu" onclick="toggleMenu()">
          <span></span>
          <span></span>
          <span></span>
        </div>
    </header>

    <main class="main-container">
        <div id="blogs-header-container" class="header-container">
            <h1 class="main-header inria-serif-white"><b>BLOGS</b></h1>
            <h3 class="sub-header inria-serif-white">Cooking Tips & Reviews</h3>
        </div>

        <section class="section-container">
            <div style="text-align: right; margin-bottom: 20px;">
                <a href="blog-create.php">
                    <button class="view-button">Create New Blog</button>
                </a>
            </div>

            <div id="blogs-grid-container" class="grid-container">
                <!-- Blogs will be loaded here dynamically -->
                <p style="text-align: center; padding: 40px;">Loading blogs...</p>
            </div>
        </section>
    </main>

    <footer>
        Copyright &copy; 2024 Culinaire. All Rights Reserved.
    </footer>

    <script src="scripts.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', loadBlogs);

        async function loadBlogs() {
            try {
                const response = await fetch('api/blogs/read.php');
                const data = await response.json();

                const container = document.getElementById('blogs-grid-container');
                container.innerHTML = '';

                if (data.success && data.blogs.length > 0) {
                    data.blogs.forEach(blog => {
                        const article = document.createElement('article');
                        article.className = 'grid-item';
                        article.innerHTML = `
                            <img class="item-image" src="${blog.thumbnail_path}"
                                 alt="${blog.title}" width="560" height="400">
                            <h3 class="jost-semibold-30">${blog.title}</h3>
                            <p class="inter-black">${blog.excerpt}</p>
                            <div class="flex-container">
                                <img class="user-icon"
                                     src="https://s2.svgbox.net/hero-outline.svg?ic=user-circle"
                                     alt="Author avatar" width="50" height="50">
                                <h4 class="inria-serif-black">${blog.author}</h4>
                            </div>
                            <a href="blog-detail.php?slug=${blog.slug}">
                                <button class="view-button">Read More</button>
                            </a>
                        `;
                        container.appendChild(article);
                    });
                } else {
                    container.innerHTML = `
                        <div style="text-align: center; padding: 40px;">
                            <p>No blogs available yet.</p>
                            <p><a href="blog-create.php"><button class="view-button">Create the First Blog</button></a></p>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error loading blogs:', error);
                document.getElementById('blogs-grid-container').innerHTML = `
                    <div style="text-align: center; padding: 40px;">
                        <p>Error loading blogs. Please try again later.</p>
                        <button class="view-button" onclick="loadBlogs()">Retry</button>
                    </div>
                `;
            }
        }
    </script>
</body>
</html>
