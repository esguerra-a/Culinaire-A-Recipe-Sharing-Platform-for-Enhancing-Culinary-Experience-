<?php
/**
 * Read All Blogs API Endpoint
 * GET /api/blogs/read.php
 * Retrieves all blog posts with pagination support
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
    // Get pagination parameters
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 100;
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

    // Validate limit and offset
    $limit = max(1, min($limit, 100)); // Between 1 and 100
    $offset = max(0, $offset);

    $conn = getDBConnection();

    // Get total count
    $countStmt = $conn->query("SELECT COUNT(*) as total FROM blogs");
    $totalCount = $countStmt->fetch()['total'];

    // Get blogs
    $stmt = $conn->prepare("
        SELECT id, slug, title, author, excerpt, thumbnail_path,
               DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') as created_at,
               DATE_FORMAT(updated_at, '%Y-%m-%d %H:%i:%s') as updated_at
        FROM blogs
        ORDER BY created_at DESC
        LIMIT :limit OFFSET :offset
    ");

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $blogs = $stmt->fetchAll();

    sendResponse(200, [
        "success" => true,
        "count" => $totalCount,
        "returned" => count($blogs),
        "limit" => $limit,
        "offset" => $offset,
        "blogs" => $blogs
    ]);

} catch (Exception $e) {
    sendResponse(500, [
        "success" => false,
        "error" => "Failed to fetch blogs: " . $e->getMessage()
    ]);
}
?>
