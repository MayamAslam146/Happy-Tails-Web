<?php
/* ========================================
   HAPPY TAILS - PUPPY INQUIRY PROCESSOR
   ======================================== */

require_once 'config.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get and sanitize form data
    $user_name = sanitize_input($_POST['user_name']);
    $email = sanitize_input($_POST['email']);
    $phone = isset($_POST['phone']) ? sanitize_input($_POST['phone']) : '';
    $puppy_name = sanitize_input($_POST['puppy_name']);
    $message = isset($_POST['message']) ? sanitize_input($_POST['message']) : '';
    
    // Validation
    $errors = [];
    
    if (empty($user_name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($puppy_name)) {
        $errors[] = "Puppy name is required";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO puppy_inquiries (user_name, email, phone, puppy_name, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $user_name, $email, $phone, $puppy_name, $message);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Thank you for your interest! We'll get back to you soon about " . $puppy_name . ". 🐾";
            $stmt->close();
            redirect('available-puppies.html');
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }
    
    // If there are errors
    if (!empty($errors)) {
        $_SESSION['inquiry_errors'] = $errors;
        $_SESSION['inquiry_data'] = $_POST;
        redirect('available-puppies.html');
    }
    
} else {
    redirect('available-puppies.html');
}

$conn->close();
?>

