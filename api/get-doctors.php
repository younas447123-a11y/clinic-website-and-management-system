<?php
// api/get-doctors.php - Fetch doctors for AJAX booking flow
require_once '../config/database.php';
header('Content-Type: application/json');

$serviceId = isset($_GET['service_id']) ? (int)$_GET['service_id'] : 0;
$clinicId = isset($_GET['clinic_id']) ? (int)$_GET['clinic_id'] : 0;

$sql = "SELECT d.id, d.name, d.image, d.qualification, c.name as clinic_name 
        FROM doctors d 
        LEFT JOIN doctor_services ds ON d.id = ds.doctor_id 
        LEFT JOIN clinics c ON d.clinic_id = c.id 
        WHERE 1=1";
$params = [];
$types = "";

if ($serviceId > 0) {
    $sql .= " AND ds.service_id = ?";
    $params[] = $serviceId;
    $types .= "i";
}
if ($clinicId > 0) {
    $sql .= " AND d.clinic_id = ?";
    $params[] = $clinicId;
    $types .= "i";
}
$sql .= " GROUP BY d.id";

$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$doctors = [];
while ($row = mysqli_fetch_assoc($result)) {
    $doctors[] = $row;
}
echo json_encode($doctors);
?>