<?php
require_once '../config/database.php';
require_once 'includes/auth.php';

$id = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$service = null;
if ($id) {
    $result = mysqli_query($conn, "SELECT * FROM services WHERE id = $id");
    $service = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $slug = sanitize(strtolower(str_replace(' ', '-', $name)));
    $category_id = (int)$_POST['category_id'];
    $description = sanitize($_POST['description']);
    $price = !empty($_POST['price']) ? (float)$_POST['price'] : null;
    $imagePath = $service['image'] ?? '';
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload = uploadImage($_FILES['image'], 'services/');
        if ($upload) $imagePath = $upload;
    }
    
    if ($id) {
        $stmt = mysqli_prepare($conn, "UPDATE services SET name=?, slug=?, category_id=?, description=?, price=?, image=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssisdsi", $name, $slug, $category_id, $description, $price, $imagePath, $id);
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO services (name, slug, category_id, description, price, image) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssisds", $name, $slug, $category_id, $description, $price, $imagePath);
    }
    mysqli_stmt_execute($stmt);
    redirect('services.php');
}

$categories = mysqli_query($conn, "SELECT id, name FROM categories WHERE type='service'");
?>
<?php include 'includes/header.php'; ?>
<h2><?php echo $id ? 'Edit' : 'Add'; ?> Service</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Name:</label><input type="text" name="name" value="<?php echo $service['name'] ?? ''; ?>" required>
    <label>Category:</label>
    <select name="category_id">
        <?php while($cat = mysqli_fetch_assoc($categories)): ?>
            <option value="<?php echo $cat['id']; ?>" <?php echo ($service['category_id'] ?? '') == $cat['id'] ? 'selected' : ''; ?>><?php echo $cat['name']; ?></option>
        <?php endwhile; ?>
    </select>
    <label>Description:</label><textarea name="description"><?php echo $service['description'] ?? ''; ?></textarea>
    <label>Price:</label><input type="number" step="0.01" name="price" value="<?php echo $service['price'] ?? ''; ?>">
    <label>Image:</label><input type="file" name="image">
    <button type="submit">Save</button>
</form>
<?php include 'includes/footer.php'; ?>s