<?php
require_once '../config/database.php';
header('Content-Type: application/json');

$categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$doctorId = isset($_GET['doctor_id']) ? (int)$_GET['doctor_id'] : 0;

$sql = "SELECT id, name, description, price FROM services WHERE 1=1";
$params = [];
$types = "";

if ($categoryId > 0) {
    $sql .= " AND category_id = ?";
    $params[] = $categoryId;
    $types .= "i";
}
if ($doctorId > 0) {
    $sql .= " AND id IN (SELECT service_id FROM doctor_services WHERE doctor_id = ?)";
    $params[] = $doctorId;
    $types .= "i";
}
$sql .= " ORDER BY name";

$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$services = [];
while ($row = mysqli_fetch_assoc($result)) {
    $services[] = $row;
}
echo json_encode($services);
?>