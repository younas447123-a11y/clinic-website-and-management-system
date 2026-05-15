<?php
// api/book-appointment.php
require_once '../config/database.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_name = sanitize($_POST['patient_name']);
    $patient_email = sanitize($_POST['patient_email']);
    $patient_phone = sanitize($_POST['patient_phone']);
    $service_id = (int)$_POST['service_id'] ?: null;
    $doctor_id = (int)$_POST['doctor_id'];
    $appointment_date = sanitize($_POST['appointment_date']);
    $time_slot = sanitize($_POST['time_slot']);
    
    // Prevent double booking
    $check = mysqli_prepare($conn, "SELECT id FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND time_slot = ? AND status != 'cancelled'");
    mysqli_stmt_bind_param($check, "iss", $doctor_id, $appointment_date, $time_slot);
    mysqli_stmt_execute($check);
    if (mysqli_num_rows(mysqli_stmt_get_result($check)) > 0) {
        $response['message'] = 'Slot already booked.';
        echo json_encode($response);
        exit;
    }
    
    $stmt = mysqli_prepare($conn, "INSERT INTO appointments (patient_name, patient_email, patient_phone, service_id, doctor_id, appointment_date, time_slot, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
    mysqli_stmt_bind_param($stmt, "sssiiss", $patient_name, $patient_email, $patient_phone, $service_id, $doctor_id, $appointment_date, $time_slot);
    
    if (mysqli_stmt_execute($stmt)) {
        $response['success'] = true;
        $response['message'] = 'Appointment booked successfully!';
    } else {
        $response['message'] = 'Database error.';
    }
}
echo json_encode($response);
?>