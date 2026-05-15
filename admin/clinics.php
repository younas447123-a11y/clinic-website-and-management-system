v<?php
require_once '../config/database.php';
require_once 'includes/auth.php';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM clinics WHERE id = $id");
    redirect('clinics.php');
}

$clinics = mysqli_query($conn, "SELECT * FROM clinics ORDER BY name");
?>
<?php include 'includes/header.php'; ?>
<h2>Manage Clinics</h2>
<a href="clinic-form.php" class="btn">Add New Clinic</a>
<table border="1" cellpadding="8">
    <thead><tr><th>ID</th><th>Image</th><th>Name</th><th>Address</th><th>Phone</th><th>Actions</th></tr></thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($clinics)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><img src="../<?php echo $row['image']; ?>" width="50"></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo substr(htmlspecialchars($row['address']), 0, 50); ?>...</td>
            <td><?php echo $row['phone']; ?></td>
            <td>
                <a href="clinic-form.php?edit=<?php echo $row['id']; ?>">Edit</a> |
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete clinic?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'includes/footer.php'; ?>