<?php
require_once '../config/database.php';
require_once 'includes/auth.php';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    // Delete associated images first
    mysqli_query($conn, "DELETE FROM case_study_images WHERE case_study_id = $id");
    mysqli_query($conn, "DELETE FROM case_studies WHERE id = $id");
    redirect('case-studies.php');
}

$caseStudies = mysqli_query($conn, "SELECT cs.*, d.name as doctor_name FROM case_studies cs LEFT JOIN doctors d ON cs.doctor_id = d.id ORDER BY cs.id DESC");
?>
<?php include 'includes/header.php'; ?>
<h2>Manage Case Studies</h2>
<a href="case-study-form.php" class="btn">Add New Case Study</a>
<table border="1" cellpadding="8">
    <thead><tr><th>ID</th><th>Featured Image</th><th>Title</th><th>Doctor</th><th>Actions</th></tr></thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($caseStudies)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><img src="../<?php echo $row['featured_image']; ?>" width="50"></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo $row['doctor_name']; ?></td>
            <td>
                <a href="case-study-form.php?edit=<?php echo $row['id']; ?>">Edit</a> |
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete case study?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'includes/footer.php'; ?>