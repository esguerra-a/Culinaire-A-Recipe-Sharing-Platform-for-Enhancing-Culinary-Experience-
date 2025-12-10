<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Culinaire</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="recipe-detailed-style.css">
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

    <main>
        <header class="recipe-header">
            <div class="container-flex">
                <a href="blogs.php" class="back-link">← Back to Blogs</a>
            </div>
        </header>
        <div class="blog-detail-grid">
            <div>
                <div class="blog-detail-banner" id="blog-banner">
                    <div class="blog-detail-author">
                        <img class="user-icon"
                             src="https://s2.svgbox.net/hero-outline.svg?ic=user-circle"
                             alt="Author avatar" width="50" height="50">
                        <span class="jost-semibold-30" id="blog-author">Loading...</span>
                    </div>
                </div>

                <article class="blog-post">
                    <h1 id="blog-title">Loading...</h1>
                    <p class="blog-post-date" id="blog-date"></p>
                    <div id="blog-content"></div>

                    <div>
                        <a href="blog-edit.php?id=" id="edit-link">
                            <button class="view-button">Edit Blog</button>
                        </a>
                        <button class="view-button" onclick="deleteBlog()"
                                style="background-color: #d32f2f;">Delete Blog
                        </button>

                    </div>
                </article>
            </div>

            <aside class="blog-detail-sidebar">
                <h2>RECENT BLOGS</h2>
                <div id="recent-blogs-container">
                    <p>Loading...</p>
                </div>
            </aside>
        </div>
    </main>

    <div id="deleteModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:1000; align-items:center; justify-content:center;">
        <div style="background:white; padding:40px; border-radius:10px; max-width:500px; text-align:center;">
            <h2 class="jost-semibold-30">Confirm Delete</h2>
            <p class="jost-normal">Are you sure you want to delete this blog post? This action cannot be undone.</p>
            <div style="display: flex; gap: 15px; justify-content: center;">
                <button class="view-button" style="background-color: red;" onclick="confirmDelete()">Yes, Delete</button>
                <button class="view-button" onclick="closeDeleteModal()" style="background-color: #666;">Cancel</button>
            </div>
        </div>
    </div>

    <footer>
        Copyright &copy; Culinaire 2024. All Rights Reserved.
    </footer>

    <script src="scripts.js"></script>
    <script>
        let currentBlog = null;

        document.addEventListener('DOMContentLoaded', async function() {
            const urlParams = new URLSearchParams(window.location.search);
            const slug = urlParams.get('slug');

            if (!slug) {
                alert('No blog specified');
                window.location.href = 'blogs.php';
                return;
            }

            await loadBlog(slug);
            await loadRecentBlogs();
        });

        async function loadBlog(slug) {
            try {
                const response = await fetch(`api/blogs/read-single.php?slug=${slug}`);
                const data = await response.json();

                if (data.success && data.blog) {
                    currentBlog = data.blog;

                    document.title = `${data.blog.title} - Culinaire`;
                    document.getElementById('blog-title').textContent = data.blog.title;
                    document.getElementById('blog-author').textContent = data.blog.author;

                    const date = new Date(data.blog.created_at);
                    document.getElementById('blog-date').textContent = date.toLocaleDateString('en-US', {
                        year: 'numeric', month: 'long', day: 'numeric'
                    });

                    document.getElementById('blog-content').innerHTML = data.blog.content;
                    document.getElementById('blog-banner').style.backgroundImage = `url(${data.blog.banner_path})`;
                    document.getElementById('edit-link').href = `blog-edit.php?id=${data.blog.id}`;
                } else {
                    alert('Blog not found');
                    window.location.href = 'blogs.php';
                }
            } catch (error) {
                console.error('Error loading blog:', error);
                alert('Error loading blog');
                window.location.href = 'blogs.php';
            }
        }

        async function loadRecentBlogs() {
            try {
                const response = await fetch('api/blogs/read.php?limit=3');
                const data = await response.json();

                const container = document.getElementById('recent-blogs-container');
                container.innerHTML = '';

                if (data.success && data.blogs.length > 0) {
                    data.blogs.forEach(blog => {
                        if (currentBlog && blog.id === currentBlog.id) return;

                        const div = document.createElement('div');
                        div.innerHTML = `
                            <a href="blog-detail.php?slug=${blog.slug}" class="recent-post">
                                <img src="${blog.thumbnail_path}" alt="${blog.title}">
                                <h3>${blog.title}</h3>
                            </a>
                        `;
                        container.appendChild(div);
                    });

                    if (container.innerHTML === '') {
                        container.innerHTML = '<p>No other blogs available</p>';
                    }
                } else {
                    container.innerHTML = '<p>No blogs available</p>';
                }
            } catch (error) {
                console.error('Error loading recent blogs:', error);
            }
        }

        function deleteBlog() {
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        async function confirmDelete() {
            if (!currentBlog) return;

            try {
                const response = await fetch('api/blogs/delete.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: currentBlog.id })
                });

                const data = await response.json();

                if (data.success) {
                    alert('Blog deleted successfully');
                    window.location.href = 'blogs.php';
                } else {
                    alert('Error deleting blog: ' + data.error);
                    closeDeleteModal();
                }
            } catch (error) {
                console.error('Error deleting blog:', error);
                alert('Error deleting blog');
                closeDeleteModal();
            }
        }
    </script>
</body>
</html>
