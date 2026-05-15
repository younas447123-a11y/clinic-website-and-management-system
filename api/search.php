<?php
require_once '../config/database.php';
header('Content-Type: application/json');

$keyword = isset($_GET['q']) ? sanitize($_GET['q']) : '';
$type = isset($_GET['type']) ? sanitize($_GET['type']) : 'all'; // all, doctors, services, case_studies

$results = [];

if ($type == 'all' || $type == 'doctors') {
    $sql = "SELECT id, name, 'doctor' as type, image, qualification as info FROM doctors WHERE name LIKE ? OR qualification LIKE ? LIMIT 10";
    $stmt = mysqli_prepare($conn, $sql);
    $like = "%$keyword%";
    mysqli_stmt_bind_param($stmt, "ss", $like, $like);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res)) {
        $results[] = $row;
    }
}

if ($type == 'all' || $type == 'services') {
    $sql = "SELECT id, name, 'service' as type, image, description as info FROM services WHERE name LIKE ? LIMIT 10";
    $stmt = mysqli_prepare($conn, $sql);
    $like = "%$keyword%";
    mysqli_stmt_bind_param($stmt, "s", $like);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res)) {
        $results[] = $row;
    }
}

if ($type == 'all' || $type == 'case_studies') {
    $sql = "SELECT id, title as name, 'case_study' as type, featured_image as image, description as info FROM case_studies WHERE title LIKE ? LIMIT 5";
    $stmt = mysqli_prepare($conn, $sql);
    $like = "%$keyword%";
    mysqli_stmt_bind_param($stmt, "s", $like);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res)) {
        $results[] = $row;
    }
}

echo json_encode(['success' => true, 'results' => $results]);
?>