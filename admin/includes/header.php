<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Clinic Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin-style.css">
</head>
<body>
<!-- Mobile menu button -->
<button class="menu-toggle-btn" id="menuToggleBtn">
    <i class="fas fa-bars"></i>
</button>

<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <h3>Clinic<span style="font-weight:300">Admin</span></h3>
        </div>
        <nav class="admin-nav">
            <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="doctors.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'doctors.php' || basename($_SERVER['PHP_SELF']) == 'doctor-form.php' ? 'active' : ''; ?>">
                <i class="fas fa-user-md"></i> Doctors
            </a>
            <a href="services.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'services.php' || basename($_SERVER['PHP_SELF']) == 'service-form.php' ? 'active' : ''; ?>">
                <i class="fas fa-stethoscope"></i> Services
            </a>
            <a href="categories.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'active' : ''; ?>">
                <i class="fas fa-tags"></i> Categories
            </a>
            <a href="clinics.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'clinics.php' || basename($_SERVER['PHP_SELF']) == 'clinic-form.php' ? 'active' : ''; ?>">
                <i class="fas fa-building"></i> Clinics
            </a>
            <a href="case-studies.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'case-studies.php' || basename($_SERVER['PHP_SELF']) == 'case-study-form.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i> Case Studies
            </a>
            <a href="appointments.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'appointments.php' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-check"></i> Appointments
            </a>
            <a href="support-tickets.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'support-tickets.php' ? 'active' : ''; ?>">
                <i class="fas fa-headset"></i> Support Tickets
            </a>
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </aside>

    <!-- Main content -->
    <main class="admin-main">
        <div class="container">