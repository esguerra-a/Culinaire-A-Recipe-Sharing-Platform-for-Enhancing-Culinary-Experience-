<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Blog - Culinaire</title>
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
        <h1 class="julius-green">Create New Blog Post</h1>
        <p style="color: #666; margin-bottom: 30px;">Share your culinary knowledge and cooking tips with the community!</p>

        <div id="errorContainer" class="error-message"></div>

        <form id="blogForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Blog Title *</label>
                <input type="text" id="title" name="title" required
                       placeholder="e.g., 10 Essential Kitchen Tools for Beginners">
                <div class="form-hint">A catchy, descriptive title for your blog post</div>
            </div>

            <div class="form-group">
                <label for="author">Author Name *</label>
                <input type="text" id="author" name="author" required
                       placeholder="Your name">
            </div>

            <div class="form-group">
                <label for="excerpt">Short Description (Excerpt) *</label>
                <textarea id="excerpt" name="excerpt" required
                          placeholder="A brief summary of your blog post (1-2 sentences)"></textarea>
                <div class="form-hint">This will appear on the blog listing page</div>
            </div>

            <div class="form-group">
                <label for="content">Blog Content *</label>
                <textarea id="content" name="content" required
                          placeholder="Write your blog content here. You can use HTML tags like <p>, <strong>, <em>, etc."></textarea>
                <div class="form-hint">Use HTML for formatting. Wrap paragraphs in &lt;p&gt; tags.</div>
            </div>

            <div class="form-group">
                <label for="thumbnail">Thumbnail Image *</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*" required>
                <div class="form-hint">Recommended size: 560x400px (JPG, PNG, or WebP)</div>
            </div>

            <div class="form-group">
                <label for="banner">Banner Image *</label>
                <input type="file" id="banner" name="banner" accept="image/*" required>
                <div class="form-hint">Recommended size: 1200x400px (JPG, PNG, or WebP)</div>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn" id="submitBtn">
                    Create Blog Post
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
        document.getElementById('blogForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const errorContainer = document.getElementById('errorContainer');

            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.textContent = 'Creating...';
            errorContainer.style.display = 'none';

            const formData = new FormData(this);

            try {
                const response = await fetch('api/blogs/create.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    alert('Blog created successfully!');
                    window.location.href = `blog-detail.php?slug=${data.slug}`;
                } else {
                    errorContainer.textContent = 'Error: ' + data.error;
                    errorContainer.style.display = 'block';
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Create Blog Post';
                }
            } catch (error) {
                console.error('Error:', error);
                errorContainer.textContent = 'Error creating blog. Please try again.';
                errorContainer.style.display = 'block';
                submitBtn.disabled = false;
                submitBtn.textContent = 'Create Blog Post';
            }
        });
    </script>
</body>
</html>
