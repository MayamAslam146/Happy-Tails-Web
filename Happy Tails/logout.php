<?php
/* ========================================
   HAPPY TAILS - LOGOUT
   ======================================== */

// Start session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Destroy the session
session_destroy();

// Clear remember me cookie
if (isset($_COOKIE['user_email'])) {
    setcookie('user_email', '', time()-3600, '/');
}

// Redirect to home page
header("Location: index.php");
exit();
?>

