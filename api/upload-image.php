<?php
require_once '../config/database.php';
header('Content-Type: application/json');

// Only allow POST and admin authentication
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Optional: check admin session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error']);
    exit;
}

$type = isset($_POST['type']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['type']) : 'general';
$allowedTypes = ['doctors', 'services', 'clinics', 'case_studies', 'general'];
if (!in_array($type, $allowedTypes)) $type = 'general';

$targetDir = "../assets/uploads/$type/";
if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

$upload = uploadImage($_FILES['file'], $type . '/');
if ($upload) {
    echo json_encode(['success' => true, 'path' => $upload, 'message' => 'Upload successful']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid file type or size']);
}
?>