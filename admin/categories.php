<?php
require_once '../config/database.php';
require_once 'includes/auth.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
    redirect('categories.php');
}

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_category'])) {
    $name = sanitize($_POST['name']);
    $type = sanitize($_POST['type']);
    $slug = sanitize(strtolower(str_replace(' ', '-', $name)));
    $id = (int)$_POST['cat_id'];
    
    if ($id > 0) {
        $stmt = mysqli_prepare($conn, "UPDATE categories SET name=?, type=?, slug=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sssi", $name, $type, $slug, $id);
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO categories (name, type, slug) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $type, $slug);
    }
    mysqli_stmt_execute($stmt);
    redirect('categories.php');
}

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY type, name");
?>
<?php include 'includes/header.php'; ?>
<h2>Manage Categories</h2>

<form method="POST" style="margin-bottom:20px;">
    <input type="hidden" name="cat_id" id="cat_id" value="0">
    <input type="text" name="name" id="cat_name" placeholder="Category Name" required>
    <select name="type" id="cat_type">
        <option value="doctor">Doctor Category</option>
        <option value="service">Service Category</option>
    </select>
    <button type="submit" name="save_category">Add Category</button>
</form>

<table border="1" cellpadding="8">
    <thead><tr><th>ID</th><th>Name</th><th>Type</th><th>Actions</th></tr></thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($categories)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo $row['type']; ?></td>
            <td>
                <button onclick="editCategory(<?php echo $row['id']; ?>, '<?php echo addslashes($row['name']); ?>', '<?php echo $row['type']; ?>')">Edit</button>
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete category?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<script>
function editCategory(id, name, type) {
    document.getElementById('cat_id').value = id;
    document.getElementById('cat_name').value = name;
    document.getElementById('cat_type').value = type;
}
</script>
<?php include 'includes/footer.php'; ?>