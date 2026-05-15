<?php
require_once '../config/database.php';
require_once 'includes/auth.php';

$id = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$doctor = null;
if ($id) {
    $result = mysqli_query($conn, "SELECT * FROM doctors WHERE id = $id");
    $doctor = mysqli_fetch_assoc($result);
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $slug = sanitize(strtolower(trim(preg_replace('/[^a-zA-Z0-9-]+/', '-', $name))));
    $category_id = (int)$_POST['category_id'];
    $clinic_id = (int)$_POST['clinic_id'];
    $bio = sanitize($_POST['bio']);
    $experience = sanitize($_POST['experience']);
    $qualification = sanitize($_POST['qualification']);
    $featured = isset($_POST['featured']) ? 1 : 0;
    
    $imagePath = $doctor['image'] ?? '';
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload = uploadImage($_FILES['image'], 'doctors/');
        if ($upload) {
            // Delete old image if exists
            if ($imagePath && file_exists('../' . $imagePath)) {
                unlink('../' . $imagePath);
            }
            $imagePath = $upload;
        } else {
            $error = "Image upload failed. Allowed types: JPG, PNG, GIF, WEBP (max 2MB)";
        }
    }
    
    if (empty($error)) {
        if ($id) {
            $stmt = mysqli_prepare($conn, "UPDATE doctors SET name=?, slug=?, category_id=?, clinic_id=?, image=?, bio=?, experience=?, qualification=?, featured=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "ssiisssssi", $name, $slug, $category_id, $clinic_id, $imagePath, $bio, $experience, $qualification, $featured, $id);
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO doctors (name, slug, category_id, clinic_id, image, bio, experience, qualification, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssiissssi", $name, $slug, $category_id, $clinic_id, $imagePath, $bio, $experience, $qualification, $featured);
        }
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = $id ? 'Doctor updated successfully' : 'Doctor added successfully';
            redirect('doctors.php');
        } else {
            $error = "Database error: " . mysqli_error($conn);
        }
    }
}

$categories = mysqli_query($conn, "SELECT id, name FROM categories WHERE type='doctor' ORDER BY name");
$clinics = mysqli_query($conn, "SELECT id, name FROM clinics ORDER BY name");
?>
<?php include 'includes/header.php'; ?>
<h2><?php echo $id ? 'Edit' : 'Add'; ?> Doctor</h2>

<?php if ($error): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Full Name *</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($doctor['name'] ?? ''); ?>" required>
    
    <label>Category (Specialization) *</label>
    <select name="category_id" required>
        <option value="">-- Select Category --</option>
        <?php while($cat = mysqli_fetch_assoc($categories)): ?>
            <option value="<?php echo $cat['id']; ?>" <?php echo ($doctor['category_id'] ?? '') == $cat['id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($cat['name']); ?>
            </option>
        <?php endwhile; ?>
    </select>
    
    <label>Clinic / Branch *</label>
    <select name="clinic_id" required>
        <option value="">-- Select Clinic --</option>
        <?php while($cl = mysqli_fetch_assoc($clinics)): ?>
            <option value="<?php echo $cl['id']; ?>" <?php echo ($doctor['clinic_id'] ?? '') == $cl['id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($cl['name']); ?>
            </option>
        <?php endwhile; ?>
    </select>
    
    <label>Profile Image</label>
    <?php if ($id && !empty($doctor['image'])): ?>
        <div class="current-image">
            <img src="../<?php echo $doctor['image']; ?>" width="100" style="border-radius:8px; margin-bottom:10px;">
            <p>Current image</p>
        </div>
    <?php endif; ?>
    <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp">
    <small>Leave empty to keep current image. Max size 2MB.</small>
    
    <label>Bio / Introduction</label>
    <textarea name="bio" rows="4"><?php echo htmlspecialchars($doctor['bio'] ?? ''); ?></textarea>
    
    <label>Experience (years & details)</label>
    <textarea name="experience" rows="3"><?php echo htmlspecialchars($doctor['experience'] ?? ''); ?></textarea>
    
    <label>Qualification (Degrees, certifications)</label>
    <textarea name="qualification" rows="3"><?php echo htmlspecialchars($doctor['qualification'] ?? ''); ?></textarea>
    
    <div style="margin: 15px 0;">
        <label>
            <input type="checkbox" name="featured" value="1" <?php echo (isset($doctor['featured']) && $doctor['featured'] == 1) ? 'checked' : ''; ?>>
            <strong>Mark as Featured Doctor</strong> (shows on homepage)
        </label>
    </div>
    
    <div style="margin-top: 1rem;">
        <button type="submit" class="btn btn-primary"><?php echo $id ? 'Update' : 'Save'; ?> Doctor</button>
        <a href="doctors.php" class="btn">Cancel</a>
    </div>
</form>
<?php include 'includes/footer.php'; ?>