<?php
require_once 'config.php';

// Check if user is admin
if (!isAdmin()) {
    $_SESSION['error_message'] = "Access denied. Admin privileges required.";
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Happy Tails 🐾</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/png" href="assets/images/logo.png">
    <style>
        .admin-nav {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-lavender));
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        .admin-nav ul {
            display: flex;
            justify-content: center;
            gap: 2rem;
            list-style: none;
            flex-wrap: wrap;
        }
        .admin-nav a {
            color: white;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .admin-nav a:hover {
            background: rgba(255,255,255,0.2);
        }
        .admin-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }
        .admin-card {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 4px 15px var(--shadow);
            text-align: center;
            transition: all 0.3s ease;
        }
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px var(--shadow-hover);
        }
        .admin-card h3 {
            font-size: 3rem;
            color: var(--primary-orange);
            margin-bottom: 0.5rem;
        }
        .admin-card p {
            color: var(--text-brown);
            font-weight: 600;
        }
        .admin-card a {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1.5rem;
            background: var(--gradient-peach);
            color: white;
            border-radius: 10px;
            font-weight: 500;
        }
        .welcome-admin {
            background: linear-gradient(135deg, var(--light-purple), var(--bg-cream));
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-logo">
                <img src="assets/images/logo.png" alt="Happy Tails Logo">
                <span>Happy Tails Admin</span>
            </div>
            <ul class="navbar-menu">
                <li><a href="index.php">Public Site</a></li>
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="logout.php" style="color: var(--secondary-lavender);">Logout</a></li>
            </ul>
        </div>
    </nav>

    <?php if (isset($_SESSION['success_message'])): ?>
    <div style="background: linear-gradient(135deg, #4CAF50, #45a049); color: white; padding: 1.5rem; text-align: center; font-weight: 500;">
        <strong>✅ <?php echo htmlspecialchars($_SESSION['success_message']); ?></strong>
    </div>
    <?php unset($_SESSION['success_message']); endif; ?>

    <div class="admin-nav">
        <div class="container">
            <ul>
                <li><a href="admin.php">📊 Dashboard</a></li>
                <li><a href="admin_users.php">👥 Users</a></li>
                <li><a href="admin_adoptions.php">🐾 Adoptions</a></li>
                <li><a href="admin_contacts.php">📧 Messages</a></li>
                <li><a href="admin_strays.php">🐕 Stray Reports</a></li>
            </ul>
        </div>
    </div>

    <main class="section">
        <div class="container">
            <div class="welcome-admin">
                <h1>🎯 Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
                <p style="font-size: 1.2rem; color: var(--text-light);">Admin Dashboard - Manage Happy Tails</p>
            </div>

            <?php
            // Get statistics
            $total_users = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
            $total_adoptions = $conn->query("SELECT COUNT(*) as count FROM adoption_requests")->fetch_assoc()['count'];
            $total_contacts = $conn->query("SELECT COUNT(*) as count FROM contact_messages")->fetch_assoc()['count'];
            $total_strays = $conn->query("SELECT COUNT(*) as count FROM stray_reports")->fetch_assoc()['count'];
            
            $pending_adoptions = $conn->query("SELECT COUNT(*) as count FROM adoption_requests WHERE status='pending'")->fetch_assoc()['count'];
            $pending_strays = $conn->query("SELECT COUNT(*) as count FROM stray_reports WHERE status='pending'")->fetch_assoc()['count'];
            ?>

            <div class="admin-stats">
                <div class="admin-card">
                    <h3><?php echo $total_users; ?></h3>
                    <p>Total Users</p>
                    <a href="admin_users.php">Manage →</a>
                </div>

                <div class="admin-card">
                    <h3><?php echo $total_adoptions; ?></h3>
                    <p>Adoption Requests</p>
                    <p style="color: var(--primary-orange); font-size: 0.9rem; margin-top: 0.5rem;">
                        <?php echo $pending_adoptions; ?> Pending
                    </p>
                    <a href="admin_adoptions.php">View →</a>
                </div>

                <div class="admin-card">
                    <h3><?php echo $total_contacts; ?></h3>
                    <p>Contact Messages</p>
                    <a href="admin_contacts.php">View →</a>
                </div>

                <div class="admin-card">
                    <h3><?php echo $total_strays; ?></h3>
                    <p>Stray Reports</p>
                    <p style="color: var(--primary-orange); font-size: 0.9rem; margin-top: 0.5rem;">
                        <?php echo $pending_strays; ?> Pending
                    </p>
                    <a href="admin_strays.php">Manage →</a>
                </div>
            </div>

            <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 15px var(--shadow); margin-top: 2rem;">
                <h2 style="color: var(--primary-orange); margin-bottom: 1rem;">📋 Quick Actions</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <a href="admin_adoptions.php?filter=pending" class="btn btn-primary">Review Pending Adoptions</a>
                    <a href="admin_strays.php?filter=pending" class="btn btn-secondary">Check New Stray Reports</a>
                    <a href="admin_contacts.php?filter=new" class="btn btn-outline">Read New Messages</a>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">Happy Tails Admin</div>
                <p class="footer-tagline">Administrative Dashboard 🐾</p>
            </div>
            <div class="footer-copyright">
                <p>&copy; 2025 Happy Tails. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>

