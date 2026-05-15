<?php
// api/get-slots.php - Get available time slots for a doctor on a specific date
require_once '../config/database.php';
header('Content-Type: application/json');

$doctorId = (int)$_GET['doctor_id'];
$date = $_GET['date'];

if (!$doctorId || !$date) {
    echo json_encode([]);
    exit;
}

// Get day of week: 0=Monday (adjust if needed)
$dayOfWeek = date('N', strtotime($date)) - 1;

// Fetch doctor's schedule for that day
$stmt = mysqli_prepare($conn, "SELECT start_time, end_time, slot_duration FROM doctor_schedule WHERE doctor_id = ? AND day_of_week = ?");
mysqli_stmt_bind_param($stmt, "ii", $doctorId, $dayOfWeek);
mysqli_stmt_execute($stmt);
$schedule = mysqli_stmt_get_result($stmt);
$slotRow = mysqli_fetch_assoc($schedule);

if (!$slotRow) {
    echo json_encode([]);
    exit;
}

$start = new DateTime($slotRow['start_time']);
$end = new DateTime($slotRow['end_time']);
$duration = $slotRow['slot_duration']; // minutes
$slots = [];

while ($start < $end) {
    $slotTime = $start->format('H:i:s');
    // Check if already booked
    $bookedStmt = mysqli_prepare($conn, "SELECT id FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND time_slot = ? AND status != 'cancelled'");
    mysqli_stmt_bind_param($bookedStmt, "iss", $doctorId, $date, $slotTime);
    mysqli_stmt_execute($bookedStmt);
    $booked = mysqli_stmt_get_result($bookedStmt);
    if (mysqli_num_rows($booked) == 0) {
        $slots[] = $slotTime;
    }
    $start->modify("+$duration minutes");
}
echo json_encode($slots);
?>