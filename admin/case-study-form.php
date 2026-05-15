<?php
require_once '../config/database.php';
require_once 'includes/auth.php';

$id = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$caseStudy = null;
if ($id) {
    $result = mysqli_query($conn, "SELECT * FROM case_studies WHERE id = $id");
    $caseStudy = mysqli_fetch_assoc($result);
}

// Handle main form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_case'])) {
    $title = sanitize($_POST['title']);
    $slug = sanitize(strtolower(str_replace(' ', '-', $title)));
    $doctor_id = (int)$_POST['doctor_id'];
    $service_id = !empty($_POST['service_id']) ? (int)$_POST['service_id'] : null;
    $description = sanitize($_POST['description']);
    $featuredImage = $caseStudy['featured_image'] ?? '';
    
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] == 0) {
        $upload = uploadImage($_FILES['featured_image'], 'case_studies/');
        if ($upload) $featuredImage = $upload;
    }
    
    if ($id) {
        $stmt = mysqli_prepare($conn, "UPDATE case_studies SET title=?, slug=?, doctor_id=?, service_id=?, description=?, featured_image=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssiissi", $title, $slug, $doctor_id, $service_id, $description, $featuredImage, $id);
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO case_studies (title, slug, doctor_id, service_id, description, featured_image) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssiiss", $title, $slug, $doctor_id, $service_id, $description, $featuredImage);
    }
    mysqli_stmt_execute($stmt);
    if (!$id) $id = mysqli_insert_id($conn);
    redirect("case-study-form.php?edit=$id");
}

// Handle gallery image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_gallery'])) {
    $case_id = (int)$_POST['case_id'];
    $caption = sanitize($_POST['caption']);
    $is_before = isset($_POST['is_before']) ? 1 : 0;
    if (isset($_FILES['gallery_image']) && $_FILES['gallery_image']['error'] == 0) {
        $upload = uploadImage($_FILES['gallery_image'], 'case_studies/');
        if ($upload) {
            $stmt = mysqli_prepare($conn, "INSERT INTO case_study_images (case_study_id, image_path, caption, is_before) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "issi", $case_id, $upload, $caption, $is_before);
            mysqli_stmt_execute($stmt);
        }
    }
    redirect("case-study-form.php?edit=$case_id");
}

// Delete gallery image
if (isset($_GET['del_img'])) {
    $img_id = (int)$_GET['del_img'];
    mysqli_query($conn, "DELETE FROM case_study_images WHERE id = $img_id");
    redirect("case-study-form.php?edit=$id");
}

$doctors = mysqli_query($conn, "SELECT id, name FROM doctors");
$services = mysqli_query($conn, "SELECT id, name FROM services");
$gallery = [];
if ($id) {
    $gallery = mysqli_query($conn, "SELECT * FROM case_study_images WHERE case_study_id = $id");
}
?>
<?php include 'includes/header.php'; ?>
<h2><?php echo $id ? 'Edit' : 'Add'; ?> Case Study</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="save_case" value="1">
    <label>Title:</label><input type="text" name="title" value="<?php echo $caseStudy['title'] ?? ''; ?>" required>
    <label>Doctor:</label>
    <select name="doctor_id">
        <option value="">-- Select Doctor --</option>
        <?php while($doc = mysqli_fetch_assoc($doctors)): ?>
            <option value="<?php echo $doc['id']; ?>" <?php echo ($caseStudy['doctor_id'] ?? '') == $doc['id'] ? 'selected' : ''; ?>><?php echo $doc['name']; ?></option>
        <?php endwhile; ?>
    </select>
    <label>Service (optional):</label>
    <select name="service_id">
        <option value="">-- Select Service --</option>
        <?php while($serv = mysqli_fetch_assoc($services)): ?>
            <option value="<?php echo $serv['id']; ?>" <?php echo ($caseStudy['service_id'] ?? '') == $serv['id'] ? 'selected' : ''; ?>><?php echo $serv['name']; ?></option>
        <?php endwhile; ?>
    </select>
    <label>Description:</label><textarea name="description"><?php echo $caseStudy['description'] ?? ''; ?></textarea>
    <label>Featured Image:</label><input type="file" name="featured_image">
    <button type="submit">Save Case Study</button>
</form>

<?php if($id): ?>
    <hr>
    <h3>Gallery Images</h3>
    <form method="POST" enctype="multipart/form-data" style="margin-bottom:20px;">
        <input type="hidden" name="case_id" value="<?php echo $id; ?>">
        <label>Image:</label><input type="file" name="gallery_image" required>
        <label>Caption:</label><input type="text" name="caption">
        <label><input type="checkbox" name="is_before"> Before image</label>
        <button type="submit" name="add_gallery">Add Image</button>
    </form>
    <div class="gallery-preview">
        <?php while($img = mysqli_fetch_assoc($gallery)): ?>
            <div style="display:inline-block; margin:10px;">
                <img src="../<?php echo $img['image_path']; ?>" width="100"><br>
                <p><?php echo $img['caption']; ?> (<?php echo $img['is_before'] ? 'Before' : 'After'; ?>)</p>
                <a href="?edit=<?php echo $id; ?>&del_img=<?php echo $img['id']; ?>" onclick="return confirm('Delete image?')">Delete</a>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>