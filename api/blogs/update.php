<?php
/**
 * Update Blog API Endpoint
 * PUT /api/blogs/update.php
 * Updates an existing blog post
 */

require_once '../config.php';

// Handle PUT request
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    sendResponse(405, [
        "success" => false,
        "error" => "Method not allowed. Use PUT."
    ]);
}

try {
    // Parse PUT data
    $_PUT = [];
    parse_str(file_get_contents("php://input"), $_PUT);

    // Check if ID is provided
    if (empty($_PUT['id'])) {
        throw new Exception("Blog ID is required");
    }

    $conn = getDBConnection();

    // Build dynamic update query based on provided fields
    $updateFields = [];
    $params = [':id' => $_PUT['id']];

    $allowedFields = ['title', 'author', 'excerpt', 'content'];
    foreach ($allowedFields as $field) {
        if (isset($_PUT[$field]) && trim($_PUT[$field]) !== '') {
            $updateFields[] = "$field = :$field";
            $params[":$field"] = $_PUT[$field];
        }
    }

    if (empty($updateFields)) {
        throw new Exception("No fields to update");
    }

    // Update slug if title changed
    if (isset($_PUT['title'])) {
        $newSlug = generateSlug($_PUT['title']);

        // Check if new slug conflicts with another blog
        $checkStmt = $conn->prepare("SELECT id FROM blogs WHERE slug = :slug AND id != :id");
        $checkStmt->execute([':slug' => $newSlug, ':id' => $_PUT['id']]);

        if ($checkStmt->fetch()) {
            // Slug exists, append timestamp
            $newSlug = $newSlug . '-' . time();
        }

        $updateFields[] = "slug = :slug";
        $params[':slug'] = $newSlug;
    }

    // Execute update
    $sql = "UPDATE blogs SET " . implode(', ', $updateFields) . " WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    if ($stmt->rowCount() === 0) {
        // Check if blog exists
        $checkStmt = $conn->prepare("SELECT id FROM blogs WHERE id = :id");
        $checkStmt->execute([':id' => $_PUT['id']]);

        if (!$checkStmt->fetch()) {
            throw new Exception("Blog not found");
        }

        // Blog exists but no changes were made
        sendResponse(200, [
            "success" => true,
            "message" => "No changes were made"
        ]);
    }

    sendResponse(200, [
        "success" => true,
        "message" => "Blog updated successfully"
    ]);

} catch (Exception $e) {
    sendResponse(400, [
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
?>
