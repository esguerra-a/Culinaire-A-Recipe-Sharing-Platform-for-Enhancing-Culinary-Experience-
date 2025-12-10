<?php
/**
 * Create Blog API Endpoint
 * POST /api/blogs/create.php
 * Creates a new blog post with image uploads
 */

require_once '../config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(405, [
        "success" => false,
        "error" => "Method not allowed. Use POST."
    ]);
}

try {
    // Validate required fields
    $required = ['title', 'author', 'excerpt', 'content'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Validate thumbnail image
    if (empty($_FILES['thumbnail'])) {
        throw new Exception("Thumbnail image is required");
    }

    // Validate banner image
    if (empty($_FILES['banner'])) {
        throw new Exception("Banner image is required");
    }

    // Generate slug from title
    $slug = generateSlug($_POST['title']);

    // Check if slug already exists
    $conn = getDBConnection();
    $checkStmt = $conn->prepare("SELECT id FROM blogs WHERE slug = :slug");
    $checkStmt->execute([':slug' => $slug]);

    if ($checkStmt->fetch()) {
        // Slug exists, append timestamp to make it unique
        $slug = $slug . '-' . time();
    }

    // Upload thumbnail
    $thumbnailResult = uploadImage($_FILES['thumbnail'], THUMBNAIL_DIR, $slug . '-thumb');
    if (!$thumbnailResult['success']) {
        throw new Exception("Thumbnail upload failed: " . $thumbnailResult['error']);
    }

    // Upload banner
    $bannerResult = uploadImage($_FILES['banner'], BANNER_DIR, $slug . '-banner');
    if (!$bannerResult['success']) {
        // Cleanup thumbnail if banner upload fails
        deleteFile($thumbnailResult['path']);
        throw new Exception("Banner upload failed: " . $bannerResult['error']);
    }

    // Insert into database
    $stmt = $conn->prepare("
        INSERT INTO blogs (slug, title, author, excerpt, content, thumbnail_path, banner_path)
        VALUES (:slug, :title, :author, :excerpt, :content, :thumbnail_path, :banner_path)
    ");

    $stmt->execute([
        ':slug' => $slug,
        ':title' => $_POST['title'],
        ':author' => $_POST['author'],
        ':excerpt' => $_POST['excerpt'],
        ':content' => $_POST['content'],
        ':thumbnail_path' => $thumbnailResult['path'],
        ':banner_path' => $bannerResult['path']
    ]);

    $blogId = $conn->lastInsertId();

    sendResponse(201, [
        "success" => true,
        "message" => "Blog created successfully",
        "blog_id" => $blogId,
        "slug" => $slug
    ]);

} catch (Exception $e) {
    sendResponse(400, [
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
?>
