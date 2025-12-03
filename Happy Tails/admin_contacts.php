<?php
require_once 'config.php';

if (!isAdmin()) {
    redirect('index.php');
}

// Handle status update
if (isset($_GET['update']) && isset($_GET['status'])) {
    $id = (int)$_GET['update'];
    $status = sanitize_input($_GET['status']);
    
    $stmt = $conn->prepare("UPDATE contact_messages SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Message marked as: " . ucfirst($status);
    }
    $stmt->close();
    redirect('admin_contacts.php');
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Message deleted successfully!";
    }
    $stmt->close();
    redirect('admin_contacts.php');
}

// Get filter
$filter = isset($_GET['filter']) ? sanitize_input($_GET['filter']) : '';
$query = "SELECT * FROM contact_messages";
if (!empty($filter)) {
    $query .= " WHERE status = '$filter'";
}
$query .= " ORDER BY created_at DESC";
$messages = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages - Admin Panel</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .admin-table { width: 100%; background: white; border-radius: 15px; overflow-x: auto; box-shadow: 0 4px 15px var(--shadow); }
        .admin-table table { width: 100%; border-collapse: collapse; }
        .admin-table th { background: var(--gradient-peach); color: white; padding: 1rem; text-align: left; }
        .admin-table td { padding: 1rem; border-bottom: 1px solid var(--light-purple); }
        .admin-table tr:hover { background: var(--bg-cream); }
        .badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 500; }
        .badge-new { background: #4CAF50; color: white; }
        .badge-read { background: #2196F3; color: white; }
        .badge-replied { background: #9C27B0; color: white; }
        .action-btn { padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.8rem; margin: 0 0.2rem; display: inline-block; color: white; }
        .btn-read { background: #2196F3; }
        .btn-replied { background: #9C27B0; }
        .btn-delete { background: #999; }
        .filter-bar { margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-logo">
                <img src="assets/images/logo.png" alt="Logo">
                <span>Happy Tails Admin</span>
            </div>
            <ul class="navbar-menu">
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <?php if (isset($_SESSION['success_message'])): ?>
    <div style="background: linear-gradient(135deg, #4CAF50, #45a049); color: white; padding: 1.2rem; text-align: center;">
        <strong>✅ <?php echo htmlspecialchars($_SESSION['success_message']); ?></strong>
    </div>
    <?php unset($_SESSION['success_message']); endif; ?>

    <main class="section">
        <div class="container">
            <h1 style="color: var(--primary-orange); margin-bottom: 1rem;">📧 Contact Messages</h1>

            <div class="filter-bar">
                <a href="admin_contacts.php" class="btn btn-outline">All Messages</a>
                <a href="admin_contacts.php?filter=new" class="btn btn-primary">New</a>
                <a href="admin_contacts.php?filter=read" class="btn btn-secondary">Read</a>
                <a href="admin_contacts.php?filter=replied" class="btn btn-outline">Replied</a>
            </div>

            <div class="admin-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email/Phone</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($messages->num_rows > 0): ?>
                            <?php while ($msg = $messages->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $msg['id']; ?></td>
                                <td><?php echo htmlspecialchars($msg['name']); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($msg['email']); ?><br>
                                    <small><?php echo htmlspecialchars($msg['phone'] ?? 'N/A'); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                                <td style="max-width: 300px;">
                                    <small><?php echo htmlspecialchars(substr($msg['message'], 0, 100)); ?>...</small>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $msg['status']; ?>">
                                        <?php echo ucfirst($msg['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($msg['created_at'])); ?></td>
                                <td>
                                    <?php if ($msg['status'] == 'new'): ?>
                                    <a href="?update=<?php echo $msg['id']; ?>&status=read" class="action-btn btn-read">Mark Read</a>
                                    <?php endif; ?>
                                    <?php if ($msg['status'] != 'replied'): ?>
                                    <a href="?update=<?php echo $msg['id']; ?>&status=replied" class="action-btn btn-replied">Mark Replied</a>
                                    <?php endif; ?>
                                    <a href="?delete=<?php echo $msg['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Delete this message?')">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 2rem; color: var(--text-light);">
                                    No contact messages found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 2rem;">
                <a href="admin.php" class="btn btn-outline">← Back to Dashboard</a>
            </div>
        </div>
    </main>
</body>
</html>

