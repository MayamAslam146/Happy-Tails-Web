<?php
require_once 'config.php';

if (!isAdmin()) {
    redirect('index.php');
}

// Handle delete user
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $user_id = (int)$_GET['delete'];
    
    // Don't allow deleting yourself
    if ($user_id != $_SESSION['user_id']) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "User deleted successfully!";
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "You cannot delete your own account!";
    }
    redirect('admin_users.php');
}

// Get all users
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Panel</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .admin-table {
            width: 100%;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px var(--shadow);
        }
        .admin-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .admin-table th {
            background: var(--gradient-peach);
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }
        .admin-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--light-purple);
        }
        .admin-table tr:hover {
            background: var(--bg-cream);
        }
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .badge-admin {
            background: var(--primary-orange);
            color: white;
        }
        .badge-user {
            background: var(--light-purple);
            color: var(--text-brown);
        }
        .action-btn {
            padding: 0.4rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            text-decoration: none;
            display: inline-block;
            margin: 0 0.25rem;
        }
        .btn-delete {
            background: #ff4444;
            color: white;
        }
        .btn-delete:hover {
            background: #cc0000;
        }
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
                <li><a href="index.php">Public Site</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <?php if (isset($_SESSION['success_message'])): ?>
    <div style="background: linear-gradient(135deg, #4CAF50, #45a049); color: white; padding: 1.2rem; text-align: center;">
        <strong>✅ <?php echo htmlspecialchars($_SESSION['success_message']); ?></strong>
    </div>
    <?php unset($_SESSION['success_message']); endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
    <div style="background: linear-gradient(135deg, #ff6b6b, #ff4444); color: white; padding: 1.2rem; text-align: center;">
        <strong>⚠️ <?php echo htmlspecialchars($_SESSION['error_message']); ?></strong>
    </div>
    <?php unset($_SESSION['error_message']); endif; ?>

    <main class="section">
        <div class="container">
            <h1 style="color: var(--primary-orange); margin-bottom: 2rem;">👥 Manage Users</h1>

            <div class="admin-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $users->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                            <td>
                                <span class="badge <?php echo ($user['role'] == 'admin') ? 'badge-admin' : 'badge-user'; ?>">
                                    <?php echo strtoupper($user['role'] ?? 'user'); ?>
                                </span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <a href="admin_users.php?delete=<?php echo $user['id']; ?>" 
                                   class="action-btn btn-delete"
                                   onclick="return confirm('Delete this user?')">Delete</a>
                                <?php else: ?>
                                <span style="color: var(--text-light);">Current User</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>

