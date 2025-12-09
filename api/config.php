<?php
/**
 * Culinaire API Configuration File
 * Database connection, constants, and helper functions
 */

// Set headers for API responses
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'culinaire_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// File upload configuration
define('UPLOAD_DIR', __DIR__ . '/../uploads/blogs/');
define('THUMBNAIL_DIR', UPLOAD_DIR . 'thumbnails/');
define('BANNER_DIR', UPLOAD_DIR . 'banners/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp', 'gif']);

/**
 * Get database connection using PDO
 * @return PDO Database connection object
 */
function getDBConnection() {
    try {
        $conn = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        return $conn;
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "error" => "Database connection failed: " . $e->getMessage()
        ]);
        exit();
    }
}

/**
 * Generate URL-friendly slug from title
 * @param string $title The title to convert to slug
 * @return string URL-friendly slug
 */
function generateSlug($title) {
    // Convert to lowercase
    $slug = strtolower(trim($title));

    // Replace non-alphanumeric characters with hyphens
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);

    // Replace multiple hyphens with single hyphen
    $slug = preg_replace('/-+/', '-', $slug);

    // Remove leading and trailing hyphens
    $slug = trim($slug, '-');

    return $slug;
}

/**
 * Validate image upload
 * @param array $file The $_FILES array element
 * @return array Array of error messages (empty if valid)
 */
function validateImage($file) {
    $errors = [];

    // Check if file was uploaded
    if (!isset($file['error']) || is_array($file['error'])) {
        $errors[] = "Invalid file upload";
        return $errors;
    }

    // Check for upload errors
    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $errors[] = "File size exceeds limit";
            break;
        case UPLOAD_ERR_NO_FILE:
            $errors[] = "No file uploaded";
            break;
        default:
            $errors[] = "Upload error occurred";
            break;
    }

    // Check file size
    if ($file['size'] > MAX_FILE_SIZE) {
        $errors[] = "File size exceeds 5MB limit";
    }

    // Check file extension
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ALLOWED_EXTENSIONS)) {
        $errors[] = "Invalid file type. Allowed: " . implode(', ', ALLOWED_EXTENSIONS);
    }

    // Verify it's actually an image
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    if (!in_array($mimeType, $allowedMimeTypes)) {
        $errors[] = "File is not a valid image";
    }

    return $errors;
}

/**
 * Upload image file to specified directory
 * @param array $file The $_FILES array element
 * @param string $targetDir Target directory (THUMBNAIL_DIR or BANNER_DIR)
 * @param string $filename Desired filename (without extension)
 * @return array ['success' => bool, 'path' => string|null, 'error' => string|null]
 */
function uploadImage($file, $targetDir, $filename) {
    // Validate image
    $errors = validateImage($file);
    if (!empty($errors)) {
        return [
            'success' => false,
            'path' => null,
            'error' => implode(", ", $errors)
        ];
    }

    // Get file extension
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Generate unique filename
    $uniqueFilename = $filename . '-' . time() . '.' . $ext;

    // Full path
    $targetPath = $targetDir . $uniqueFilename;

    // Create directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // Return relative path from project root
        $relativePath = str_replace(__DIR__ . '/../', '', $targetPath);
        $relativePath = str_replace('\\', '/', $relativePath); // Fix Windows paths

        return [
            'success' => true,
            'path' => $relativePath,
            'error' => null
        ];
    } else {
        return [
            'success' => false,
            'path' => null,
            'error' => "Failed to move uploaded file"
        ];
    }
}

/**
 * Delete file from filesystem
 * @param string $filePath Relative path to file
 * @return bool True if deleted or doesn't exist, false on error
 */
function deleteFile($filePath) {
    $fullPath = __DIR__ . '/../' . $filePath;

    if (file_exists($fullPath)) {
        return unlink($fullPath);
    }

    return true; // File doesn't exist, so consider it "deleted"
}

/**
 * Send JSON response and exit
 * @param int $statusCode HTTP status code
 * @param array $data Response data
 */
function sendResponse($statusCode, $data) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit();
}
?>
