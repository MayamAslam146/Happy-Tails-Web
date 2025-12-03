<?php
require_once 'config.php';

if (!isAdmin()) {
    redirect('index.php');
}

// Handle status update
if (isset($_GET['update']) && isset($_GET['status'])) {
    $id = (int)$_GET['update'];
    $status = sanitize_input($_GET['status']);
    
    $stmt = $conn->prepare("UPDATE adoption_requests SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Adoption request status updated to: " . ucfirst($status);
    }
    $stmt->close();
    redirect('admin_adoptions.php');
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM adoption_requests WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Adoption request deleted successfully!";
    }
    $stmt->close();
    redirect('admin_adoptions.php');
}

// Get filter
$filter = isset($_GET['filter']) ? sanitize_input($_GET['filter']) : '';
$query = "SELECT * FROM adoption_requests";
if (!empty($filter)) {
    $query .= " WHERE status = '$filter'";
}
$query .= " ORDER BY created_at DESC";
$adoptions = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Adoptions - Admin Panel</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .admin-table { width: 100%; background: white; border-radius: 15px; overflow-x: auto; box-shadow: 0 4px 15px var(--shadow); }
        .admin-table table { width: 100%; border-collapse: collapse; min-width: 800px; }
        .admin-table th { background: var(--gradient-peach); color: white; padding: 1rem; text-align: left; }
        .admin-table td { padding: 1rem; border-bottom: 1px solid var(--light-purple); }
        .admin-table tr:hover { background: var(--bg-cream); }
        .badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 500; display: inline-block; }
        .badge-pending { background: #ffc107; color: #000; }
        .badge-reviewing { background: #2196F3; color: white; }
        .badge-approved { background: #4CAF50; color: white; }
        .badge-rejected { background: #f44336; color: white; }
        .action-btn { padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.8rem; margin: 0 0.2rem; display: inline-block; color: white; }
        .btn-approve { background: #4CAF50; }
        .btn-reject { background: #f44336; }
        .btn-review { background: #2196F3; }
        .btn-delete { background: #999; }
        .filter-bar { margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .filter-btn { padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-size: 0.9rem; }
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
            <h1 style="color: var(--primary-orange); margin-bottom: 1rem;">🐾 Adoption Requests</h1>
            
            <div class="filter-bar">
                <a href="admin_adoptions.php" class="filter-btn btn-outline">All</a>
                <a href="admin_adoptions.php?filter=pending" class="filter-btn" style="background: #ffc107; color: #000;">Pending</a>
                <a href="admin_adoptions.php?filter=reviewing" class="filter-btn" style="background: #2196F3; color: white;">Reviewing</a>
                <a href="admin_adoptions.php?filter=approved" class="filter-btn" style="background: #4CAF50; color: white;">Approved</a>
                <a href="admin_adoptions.php?filter=rejected" class="filter-btn" style="background: #f44336; color: white;">Rejected</a>
            </div>

            <div class="admin-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Adopter</th>
                            <th>Email/Phone</th>
                            <th>Puppy</th>
                            <th>Living</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($adoptions->num_rows > 0): ?>
                            <?php while ($adoption = $adoptions->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $adoption['id']; ?></td>
                                <td><?php echo htmlspecialchars($adoption['adopter_name']); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($adoption['email']); ?><br>
                                    <small><?php echo htmlspecialchars($adoption['phone']); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($adoption['puppy_name'] ?? 'Not specified'); ?></td>
                                <td><?php echo htmlspecialchars($adoption['living_situation'] ?? 'N/A'); ?></td>
                                <td style="max-width: 200px;">
                                    <small><?php echo htmlspecialchars(substr($adoption['reason'], 0, 80)); ?>...</small>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $adoption['status']; ?>">
                                        <?php echo ucfirst($adoption['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($adoption['created_at'])); ?></td>
                                <td>
                                    <?php if ($adoption['status'] != 'approved'): ?>
                                    <a href="?update=<?php echo $adoption['id']; ?>&status=approved" class="action-btn btn-approve">✓ Approve</a>
                                    <?php endif; ?>
                                    <?php if ($adoption['status'] != 'rejected'): ?>
                                    <a href="?update=<?php echo $adoption['id']; ?>&status=rejected" class="action-btn btn-reject">✗ Reject</a>
                                    <?php endif; ?>
                                    <a href="?delete=<?php echo $adoption['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Delete this request?')">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 2rem; color: var(--text-light);">
                                    No adoption requests found.
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

