<?php
require_once '../config/database.php';
header('Content-Type: application/json');

$sql = "SELECT id, name, address, phone, google_map_iframe, image FROM clinics ORDER BY name";
$result = mysqli_query($conn, $sql);
$clinics = [];
while ($row = mysqli_fetch_assoc($result)) {
    $clinics[] = $row;
}
echo json_encode($clinics);
?>