<?php
require_once '../config/database.php';
require_once 'includes/auth.php';

// Delete service
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM services WHERE id = $id");
    redirect('services.php');
}

$services = mysqli_query($conn, "SELECT s.*, c.name as category_name FROM services s LEFT JOIN categories c ON s.category_id = c.id ORDER BY s.id DESC");
?>
<?php include 'includes/header.php'; ?>
<h2>Manage Services</h2>
<a href="service-form.php" class="btn">Add New Service</a>
<table border="1" cellpadding="8">
    <thead>
        <tr><th>ID</th><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Actions</th></tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($services)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><img src="../<?php echo $row['image']; ?>" width="50"></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo $row['category_name']; ?></td>
            <td><?php echo $row['price'] ? '$'.$row['price'] : '-'; ?></td>
            <td>
                <a href="service-form.php?edit=<?php echo $row['id']; ?>">Edit</a> |
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete service?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'includes/footer.php'; ?>