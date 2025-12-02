<?php
/* ========================================
   HAPPY TAILS - ADOPTION REQUEST PROCESSOR
   ======================================== */

require_once 'config.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get and sanitize form data
    $adopter_name = sanitize_input($_POST['full-name']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $address = sanitize_input($_POST['address']);
    $living_situation = sanitize_input($_POST['living-situation']);
    $experience = isset($_POST['experience']) ? sanitize_input($_POST['experience']) : '';
    $reason = sanitize_input($_POST['reason']);
    $puppy_name = isset($_POST['puppy-name']) ? sanitize_input($_POST['puppy-name']) : 'Not specified';
    
    // Validation
    $errors = [];
    
    if (empty($adopter_name)) {
        $errors[] = "Full name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    }
    
    if (empty($address)) {
        $errors[] = "Address is required";
    }
    
    if (empty($living_situation)) {
        $errors[] = "Living situation is required";
    }
    
    if (empty($reason)) {
        $errors[] = "Reason for adoption is required";
    } elseif (strlen($reason) < 20) {
        $errors[] = "Please provide a more detailed reason (at least 20 characters)";
    }
    
    // Check if agreement checkbox is checked
    if (!isset($_POST['agreement'])) {
        $errors[] = "You must agree to provide love and care";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO adoption_requests (adopter_name, email, phone, address, living_situation, experience, reason, puppy_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $adopter_name, $email, $phone, $address, $living_situation, $experience, $reason, $puppy_name);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Adoption request submitted! We're so excited! Our team will contact you soon to discuss the next steps. 🐾";
            $stmt->close();
            redirect('adopt-puppy.php');
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }
    
    // If there are errors
    if (!empty($errors)) {
        $_SESSION['error_message'] = implode('. ', $errors);
        redirect('adopt-puppy.php');
    }
    
} else {
    redirect('adopt-puppy.php');
}

$conn->close();
?>

