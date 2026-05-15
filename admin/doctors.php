<?php
// admin/doctors.php (Manage Doctors - Add/Edit/Delete)
require_once '../config/database.php';
require_once 'includes/auth.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM doctors WHERE id = $id");
    redirect('doctors.php');
}

// Fetch doctors with relations
$doctors = mysqli_query($conn, "SELECT d.*, c.name as clinic_name, cat.name as category_name 
                                FROM doctors d 
                                LEFT JOIN clinics c ON d.clinic_id = c.id 
                                LEFT JOIN categories cat ON d.category_id = cat.id 
                                ORDER BY d.id DESC");
?>
<?php include 'includes/header.php'; ?>
<div class="admin-container">
    <h2>Manage Doctors</h2>
    <a href="doctor-form.php" class="btn">Add New Doctor</a>
    <table border="1" cellpadding="10">
        <thead>
            <tr><th>ID</th><th>Image</th><th>Name</th><th>Category</th><th>Clinic</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($doctors)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><img src="../<?php echo $row['image']; ?>" width="50"></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo $row['category_name']; ?></td>
                <td><?php echo $row['clinic_name']; ?></td>
                <td>
                    <a href="doctor-form.php?edit=<?php echo $row['id']; ?>">Edit</a>
                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include 'includes/footer.php'; ?>