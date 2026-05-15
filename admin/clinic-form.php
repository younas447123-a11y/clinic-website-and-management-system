<?php
require_once '../config/database.php';
require_once 'includes/auth.php';

$id = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$clinic = null;
if ($id) {
    $result = mysqli_query($conn, "SELECT * FROM clinics WHERE id = $id");
    $clinic = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $slug = sanitize(strtolower(str_replace(' ', '-', $name)));
    $address = sanitize($_POST['address']);
    $phone = sanitize($_POST['phone']);
    $google_map_iframe = $_POST['google_map_iframe']; // raw HTML allowed but sanitize if needed
    $imagePath = $clinic['image'] ?? '';
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload = uploadImage($_FILES['image'], 'clinics/');
        if ($upload) $imagePath = $upload;
    }
    
    if ($id) {
        $stmt = mysqli_prepare($conn, "UPDATE clinics SET name=?, slug=?, address=?, phone=?, google_map_iframe=?, image=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssssssi", $name, $slug, $address, $phone, $google_map_iframe, $imagePath, $id);
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO clinics (name, slug, address, phone, google_map_iframe, image) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssss", $name, $slug, $address, $phone, $google_map_iframe, $imagePath);
    }
    mysqli_stmt_execute($stmt);
    redirect('clinics.php');
}
?>
<?php include 'includes/header.php'; ?>
<h2><?php echo $id ? 'Edit' : 'Add'; ?> Clinic</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Name:</label><input type="text" name="name" value="<?php echo $clinic['name'] ?? ''; ?>" required>
    <label>Address:</label><textarea name="address"><?php echo $clinic['address'] ?? ''; ?></textarea>
    <label>Phone:</label><input type="text" name="phone" value="<?php echo $clinic['phone'] ?? ''; ?>">
    <label>Google Map Iframe (embed code):</label><textarea name="google_map_iframe"><?php echo htmlspecialchars($clinic['google_map_iframe'] ?? ''); ?></textarea>
    <label>Image:</label><input type="file" name="image">
    <button type="submit">Save</button>
</form>
<?php include 'includes/footer.php'; ?>