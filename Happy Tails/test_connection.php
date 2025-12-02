<?php
/* ========================================
   DATABASE CONNECTION TEST
   ======================================== */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Database Connection Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #FFF9F3;
        }
        .success {
            background: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .error {
            background: #f44336;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .info {
            background: #F49B42;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #F49B42;
            color: white;
        }
        h1 {
            color: #5A3E2B;
        }
    </style>
</head>
<body>
    <h1>🐾 Happy Tails - Database Connection Test</h1>
    
    <?php
    // Database Configuration
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'happytails');
    
    // Test connection
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $conn->set_charset("utf8mb4");
        
        echo '<div class="success">✅ Database Connection Successful!</div>';
        echo '<div class="info">Database: <strong>' . DB_NAME . '</strong></div>';
        echo '<div class="info">Host: <strong>' . DB_HOST . '</strong></div>';
        
        // Check if tables exist
        echo '<h2>📋 Database Tables:</h2>';
        $result = $conn->query("SHOW TABLES");
        
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Table Name</th><th>Status</th></tr>';
            
            while ($row = $result->fetch_array()) {
                $table_name = $row[0];
                echo '<tr>';
                echo '<td>' . $table_name . '</td>';
                echo '<td style="color: green;">✓ Exists</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<div class="error">⚠️ No tables found. Please import happytails.sql</div>';
        }
        
        // Check user count
        $user_count = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
        echo '<div class="info">👥 Total Users: <strong>' . $user_count . '</strong></div>';
        
        // Check if test user exists
        $test_user = $conn->query("SELECT * FROM users WHERE email = 'test@happytails.org'")->fetch_assoc();
        if ($test_user) {
            echo '<div class="success">✅ Test user exists: <strong>' . $test_user['email'] . '</strong></div>';
        } else {
            echo '<div class="error">⚠️ Test user not found. Please import happytails.sql again.</div>';
        }
        
        $conn->close();
        
    } catch (mysqli_sql_exception $e) {
        echo '<div class="error">❌ Database Connection Failed!</div>';
        echo '<div class="error">Error: ' . $e->getMessage() . '</div>';
        echo '<div class="info"><strong>Possible Solutions:</strong>';
        echo '<ul>';
        echo '<li>Make sure MySQL is running in XAMPP</li>';
        echo '<li>Check if database "happytails" exists</li>';
        echo '<li>Import happytails.sql using phpMyAdmin</li>';
        echo '<li>Verify database credentials in config.php</li>';
        echo '</ul></div>';
    }
    ?>
    
    <hr>
    <p style="text-align: center; color: #5A3E2B;">
        If everything looks good, you can proceed to test the website: 
        <br>
        <a href="index.php" style="color: #F49B42; font-weight: bold;">Go to Homepage</a>
    </p>
</body>
</html>

