<?php
require_once 'config.php';

if (!isAdmin()) {
    redirect('index.php');
}

// Handle status update
if (isset($_GET['update']) && isset($_GET['status'])) {
    $id = (int)$_GET['update'];
    $status = sanitize_input($_GET['status']);
    
    $stmt = $conn->prepare("UPDATE stray_reports SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Stray report status updated to: " . ucfirst($status);
    }
    $stmt->close();
    redirect('admin_strays.php');
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM stray_reports WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Stray report deleted successfully!";
    }
    $stmt->close();
    redirect('admin_strays.php');
}

// Get filter
$filter = isset($_GET['filter']) ? sanitize_input($_GET['filter']) : '';
$query = "SELECT * FROM stray_reports";
if (!empty($filter)) {
    $query .= " WHERE status = '$filter'";
}
$query .= " ORDER BY created_at DESC";
$strays = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stray Reports - Admin Panel</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .admin-table { width: 100%; background: white; border-radius: 15px; overflow-x: auto; box-shadow: 0 4px 15px var(--shadow); }
        .admin-table table { width: 100%; border-collapse: collapse; }
        .admin-table th { background: var(--gradient-peach); color: white; padding: 1rem; text-align: left; }
        .admin-table td { padding: 1rem; border-bottom: 1px solid var(--light-purple); }
        .admin-table tr:hover { background: var(--bg-cream); }
        .badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 500; }
        .badge-pending { background: #ffc107; color: #000; }
        .badge-investigating { background: #2196F3; color: white; }
        .badge-rescued { background: #4CAF50; color: white; }
        .badge-closed { background: #999; color: white; }
        .action-btn { padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.8rem; margin: 0 0.2rem; display: inline-block; color: white; }
        .btn-investigate { background: #2196F3; }
        .btn-rescued { background: #4CAF50; }
        .btn-close { background: #999; }
        .btn-delete { background: #f44336; }
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
            <h1 style="color: var(--primary-orange); margin-bottom: 1rem;">🐕 Stray Puppy Reports</h1>

            <div class="filter-bar">
                <a href="admin_strays.php" class="btn btn-outline">All Reports</a>
                <a href="admin_strays.php?filter=pending" class="btn" style="background: #ffc107; color: #000;">Pending</a>
                <a href="admin_strays.php?filter=investigating" class="btn" style="background: #2196F3; color: white;">Investigating</a>
                <a href="admin_strays.php?filter=rescued" class="btn" style="background: #4CAF50; color: white;">Rescued</a>
                <a href="admin_strays.php?filter=closed" class="btn" style="background: #999; color: white;">Closed</a>
            </div>

            <div class="admin-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Reporter</th>
                            <th>Contact</th>
                            <th>Location</th>
                            <th>Condition</th>
                            <th>Urgency</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($strays->num_rows > 0): ?>
                            <?php while ($stray = $strays->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $stray['id']; ?></td>
                                <td><?php echo htmlspecialchars($stray['person_name']); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($stray['phone']); ?><br>
                                    <small><?php echo htmlspecialchars($stray['email'] ?? 'N/A'); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($stray['location']); ?></td>
                                <td style="max-width: 200px;">
                                    <small><?php echo htmlspecialchars(substr($stray['puppy_condition'], 0, 60)); ?>...</small>
                                </td>
                                <td><?php echo ucfirst($stray['urgency']); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $stray['status']; ?>">
                                        <?php echo ucfirst($stray['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('M d', strtotime($stray['created_at'])); ?></td>
                                <td>
                                    <?php if ($stray['status'] == 'pending'): ?>
                                    <a href="?update=<?php echo $stray['id']; ?>&status=investigating" class="action-btn btn-investigate">Investigate</a>
                                    <?php endif; ?>
                                    <?php if ($stray['status'] == 'investigating'): ?>
                                    <a href="?update=<?php echo $stray['id']; ?>&status=rescued" class="action-btn btn-rescued">Rescued</a>
                                    <?php endif; ?>
                                    <?php if ($stray['status'] != 'closed'): ?>
                                    <a href="?update=<?php echo $stray['id']; ?>&status=closed" class="action-btn btn-close">Close</a>
                                    <?php endif; ?>
                                    <a href="?delete=<?php echo $stray['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Delete report?')">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 2rem; color: var(--text-light);">
                                    No stray reports found.
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

