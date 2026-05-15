<?php
// config/database.php
// Database configuration and connection

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'clinic_system');

function uploadImage($file, $targetDir, $maxSize = 2 * 1024 * 1024) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $fileName = time() . '_' . basename($file['name']);
    
    // Create absolute path from project root
    $uploadPath = __DIR__ . '/../assets/uploads/' . $targetDir;
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }
    
    $targetPath = $uploadPath . $fileName;
    
    if ($file['error'] !== UPLOAD_ERR_OK) return false;
    if ($file['size'] > $maxSize) return false;
    if (!in_array($file['type'], $allowedTypes)) return false;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return 'assets/uploads/' . $targetDir . $fileName;
    }
    return false;
}
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8mb4");

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper functions
function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($input)));
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function isAdmin() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

