<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog - Culinaire</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .form-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: var(--green);
            font-family: 'Julius Sans One', sans-serif;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-family: 'Jost', sans-serif;
            font-size: 16px;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--green);
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        .form-group textarea#content {
            min-height: 300px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .submit-btn {
            background-color: var(--green);
            color: white;
            border: none;
            padding: 14px 40px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            font-family: 'Jost', sans-serif;
            font-weight: 600;
        }

        .submit-btn:hover {
            opacity: 0.9;
        }

        .submit-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .cancel-btn {
            background-color: #666;
        }

        .form-hint {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }

        .error-message {
            color: #d32f2f;
            margin-top: 10px;
            padding: 10px;
            background: #ffebee;
            border-radius: 5px;
            display: none;
        }

        .current-image {
            max-width: 200px;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
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

    <div class="form-container">
        <h1 class="julius-green">Edit Blog Post</h1>
        <p style="color: #666; margin-bottom: 30px;">Update your blog post content</p>

        <div id="errorContainer" class="error-message"></div>

        <form id="blogForm">
            <input type="hidden" id="blog-id" name="id">

            <div class="form-group">
                <label for="title">Blog Title *</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="author">Author Name *</label>
                <input type="text" id="author" name="author" required>
            </div>

            <div class="form-group">
                <label for="excerpt">Short Description (Excerpt) *</label>
                <textarea id="excerpt" name="excerpt" required></textarea>
            </div>

            <div class="form-group">
                <label for="content">Blog Content *</label>
                <textarea id="content" name="content" required></textarea>
                <div class="form-hint">Use HTML for formatting. Wrap paragraphs in &lt;p&gt; tags.</div>
            </div>

            <div class="form-group">
                <label>Current Thumbnail</label>
                <img id="current-thumbnail" class="current-image" alt="Current thumbnail">
                <div class="form-hint" style="margin-top: 10px;">Images cannot be changed when editing. To change images, delete and recreate the blog post.</div>
            </div>

            <div class="form-group">
                <label>Current Banner</label>
                <img id="current-banner" class="current-image" alt="Current banner">
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn" id="submitBtn">
                    Update Blog Post
                </button>
                <a href="blogs.php">
                    <button type="button" class="submit-btn cancel-btn">Cancel</button>
                </a>
            </div>
        </form>
    </div>

    <footer>
        Copyright &copy; Culinaire 2024. All Rights Reserved.
    </footer>

    <script src="scripts.js"></script>
    <script>
        let currentBlog = null;

        document.addEventListener('DOMContentLoaded', async function() {
            const urlParams = new URLSearchParams(window.location.search);
            const blogId = urlParams.get('id');

            if (!blogId) {
                alert('No blog ID provided');
                window.location.href = 'blogs.php';
                return;
            }

            await loadBlog(blogId);
        });

        async function loadBlog(blogId) {
            try {
                const response = await fetch(`api/blogs/read-single.php?id=${blogId}`);
                const data = await response.json();

                if (data.success && data.blog) {
                    currentBlog = data.blog;

                    document.getElementById('blog-id').value = data.blog.id;
                    document.getElementById('title').value = data.blog.title;
                    document.getElementById('author').value = data.blog.author;
                    document.getElementById('excerpt').value = data.blog.excerpt;
                    document.getElementById('content').value = data.blog.content;

                    document.getElementById('current-thumbnail').src = data.blog.thumbnail_path;
                    document.getElementById('current-banner').src = data.blog.banner_path;
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

        document.getElementById('blogForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const errorContainer = document.getElementById('errorContainer');

            submitBtn.disabled = true;
            submitBtn.textContent = 'Updating...';
            errorContainer.style.display = 'none';

            const formData = {
                id: document.getElementById('blog-id').value,
                title: document.getElementById('title').value,
                author: document.getElementById('author').value,
                excerpt: document.getElementById('excerpt').value,
                content: document.getElementById('content').value
            };

            const urlEncodedData = new URLSearchParams(formData).toString();

            try {
                const response = await fetch('api/blogs/update.php', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: urlEncodedData
                });

                const data = await response.json();

                if (data.success) {
                    alert('Blog updated successfully!');
                    const updatedResponse = await fetch(`api/blogs/read-single.php?id=${formData.id}`);
                    const updatedData = await updatedResponse.json();
                    if (updatedData.success) {
                        window.location.href = `blog-detail.php?slug=${updatedData.blog.slug}`;
                    } else {
                        window.location.href = 'blogs.php';
                    }
                } else {
                    errorContainer.textContent = 'Error: ' + data.error;
                    errorContainer.style.display = 'block';
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Update Blog Post';
                }
            } catch (error) {
                console.error('Error:', error);
                errorContainer.textContent = 'Error updating blog. Please try again.';
                errorContainer.style.display = 'block';
                submitBtn.disabled = false;
                submitBtn.textContent = 'Update Blog Post';
            }
        });
    </script>
</body>
</html>
