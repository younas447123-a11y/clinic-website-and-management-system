<?php
require_once '../config/database.php';
require_once 'includes/auth.php';

if (isset($_POST['update_ticket'])) {
    $ticket_id = (int)$_POST['ticket_id'];
    $status = sanitize($_POST['status']);
    $stmt = mysqli_prepare($conn, "UPDATE support_tickets SET status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "si", $status, $ticket_id);
    mysqli_stmt_execute($stmt);
    redirect('support-tickets.php');
}

$tickets = mysqli_query($conn, "SELECT * FROM support_tickets ORDER BY created_at DESC");
?>
<?php include 'includes/header.php'; ?>
<h2>Support Tickets</h2>
<table border="1" cellpadding="8">
    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Status</th><th>Created</th><th>Action</th></tr></thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($tickets)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo htmlspecialchars($row['subject']); ?></td>
            <td><?php echo nl2br(htmlspecialchars(substr($row['message'], 0, 100))); ?>...</td>
            <td><?php echo ucfirst($row['status']); ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="ticket_id" value="<?php echo $row['id']; ?>">
                    <select name="status">
                        <option value="open" <?php echo $row['status']=='open' ? 'selected' : ''; ?>>Open</option>
                        <option value="in_progress" <?php echo $row['status']=='in_progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="resolved" <?php echo $row['status']=='resolved' ? 'selected' : ''; ?>>Resolved</option>
                    </select>
                    <button type="submit" name="update_ticket">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'includes/footer.php'; ?>