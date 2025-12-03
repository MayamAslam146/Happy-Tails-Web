<?php
/* ========================================
   HAPPY TAILS - LOGIN PROCESSOR
   ======================================== */

require_once 'config.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get and sanitize form data
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;
    
    // Validation
    $errors = [];
    
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    // If no validation errors, check credentials
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, fullname, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password correct - set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['fullname'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'] ?? 'user';
                
                // Set remember me cookie if checked
                if ($remember) {
                    setcookie('user_email', $email, time() + (86400 * 30), "/"); // 30 days
                }
                
                $_SESSION['success_message'] = "Welcome back, " . $user['fullname'] . "!";
                $stmt->close();
                redirect('index.php');
            } else {
                $errors[] = "Invalid email or password";
            }
        } else {
            $errors[] = "Invalid email or password. Don't have an account? Please sign up first!";
        }
        $stmt->close();
    }
    
    // If there are errors, redirect back with message
    if (!empty($errors)) {
        $_SESSION['error_message'] = implode(' ', $errors);
        $_SESSION['login_email'] = $email;
        redirect('signin.php');
    }
    
} else {
    redirect('signin.php');
}

$conn->close();
?>

