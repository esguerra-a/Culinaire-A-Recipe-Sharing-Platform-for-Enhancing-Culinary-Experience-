<?php
/**
 * Read Single Blog API Endpoint
 * GET /api/blogs/read-single.php
 * Retrieves a single blog post by slug or ID
 */

require_once '../config.php';

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendResponse(405, [
        "success" => false,
        "error" => "Method not allowed. Use GET."
    ]);
}

try {
    $conn = getDBConnection();

    // Check if slug or id is provided
    if (!empty($_GET['slug'])) {
        $stmt = $conn->prepare("
            SELECT id, slug, title, author, excerpt, content, thumbnail_path, banner_path,
                   DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') as created_at,
                   DATE_FORMAT(updated_at, '%Y-%m-%d %H:%i:%s') as updated_at
            FROM blogs
            WHERE slug = :slug
        ");
        $stmt->execute([':slug' => $_GET['slug']]);
    } elseif (!empty($_GET['id'])) {
        $stmt = $conn->prepare("
            SELECT id, slug, title, author, excerpt, content, thumbnail_path, banner_path,
                   DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') as created_at,
                   DATE_FORMAT(updated_at, '%Y-%m-%d %H:%i:%s') as updated_at
            FROM blogs
            WHERE id = :id
        ");
        $stmt->execute([':id' => $_GET['id']]);
    } else {
        throw new Exception("Blog slug or id is required");
    }

    $blog = $stmt->fetch();

    if (!$blog) {
        sendResponse(404, [
            "success" => false,
            "error" => "Blog not found"
        ]);
    }

    sendResponse(200, [
        "success" => true,
        "blog" => $blog
    ]);

} catch (Exception $e) {
    sendResponse(400, [
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
?>
