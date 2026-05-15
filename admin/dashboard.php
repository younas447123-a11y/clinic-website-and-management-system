<?php
// admin/dashboard.php
require_once '../config/database.php';
require_once 'includes/auth.php';

// Get counts
$doctorCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM doctors"))['count'];
$serviceCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM services"))['count'];
$appointmentCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM appointments WHERE status='pending'"))['count'];
$ticketCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM support_tickets WHERE status='open'"))['count'];
?>
<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="admin.css">
<div class="dashboard">
    <h1>Dashboard</h1>
    <div class="stats">
        <div class="stat-card">Doctors: <?php echo $doctorCount; ?></div>
        <div class="stat-card">Services: <?php echo $serviceCount; ?></div>
        <div class="stat-card">Pending Appointments: <?php echo $appointmentCount; ?></div>
        <div class="stat-card">Open Tickets: <?php echo $ticketCount; ?></div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>