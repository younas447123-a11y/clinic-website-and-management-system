<?php
require_once '../config/database.php';
require_once 'includes/auth.php';

// Update status
if (isset($_POST['update_status'])) {
    $app_id = (int)$_POST['app_id'];
    $status = sanitize($_POST['status']);
    $stmt = mysqli_prepare($conn, "UPDATE appointments SET status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "si", $status, $app_id);
    mysqli_stmt_execute($stmt);
    redirect('appointments.php');
}

$appointments = mysqli_query($conn, "SELECT a.*, d.name as doctor_name, s.name as service_name 
                                     FROM appointments a 
                                     LEFT JOIN doctors d ON a.doctor_id = d.id 
                                     LEFT JOIN services s ON a.service_id = s.id 
                                     ORDER BY a.appointment_date DESC, a.time_slot ASC");
?>
<?php include 'includes/header.php'; ?>
<h2>Appointments</h2>
<table border="1" cellpadding="8">
    <thead>
        <tr><th>ID</th><th>Patient</th><th>Doctor</th><th>Service</th><th>Date</th><th>Time</th><th>Status</th><th>Action</th></tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($appointments)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['patient_name']); ?><br><small><?php echo $row['patient_email']; ?></small></td>
            <td><?php echo $row['doctor_name']; ?></td>
            <td><?php echo $row['service_name'] ?? '-'; ?></td>
            <td><?php echo date('d M Y', strtotime($row['appointment_date'])); ?></td>
            <td><?php echo date('h:i A', strtotime($row['time_slot'])); ?></td>
            <td><?php echo ucfirst($row['status']); ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="app_id" value="<?php echo $row['id']; ?>">
                    <select name="status">
                        <option value="pending" <?php echo $row['status']=='pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="confirmed" <?php echo $row['status']=='confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                        <option value="completed" <?php echo $row['status']=='completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="cancelled" <?php echo $row['status']=='cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                    <button type="submit" name="update_status">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'includes/footer.php'; ?>