<?php
/**
 * Delete Blog API Endpoint
 * DELETE /api/blogs/delete.php
 * Deletes a blog post and its associated images
 */

require_once '../config.php';

// Handle DELETE request
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    sendResponse(405, [
        "success" => false,
        "error" => "Method not allowed. Use DELETE."
    ]);
}

try {
    // Parse DELETE data
    $_DELETE = json_decode(file_get_contents("php://input"), true);

    if (empty($_DELETE['id'])) {
        throw new Exception("Blog ID is required");
    }

    $conn = getDBConnection();

    // Get blog data to delete associated images
    $stmt = $conn->prepare("
        SELECT thumbnail_path, banner_path
        FROM blogs
        WHERE id = :id
    ");
    $stmt->execute([':id' => $_DELETE['id']]);
    $blog = $stmt->fetch();

    if (!$blog) {
        throw new Exception("Blog not found");
    }

    // Delete from database first
    $deleteStmt = $conn->prepare("DELETE FROM blogs WHERE id = :id");
    $deleteStmt->execute([':id' => $_DELETE['id']]);

    // Delete image files
    if ($blog['thumbnail_path']) {
        deleteFile($blog['thumbnail_path']);
    }

    if ($blog['banner_path']) {
        deleteFile($blog['banner_path']);
    }

    sendResponse(200, [
        "success" => true,
        "message" => "Blog deleted successfully"
    ]);

} catch (Exception $e) {
    sendResponse(400, [
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
?>
