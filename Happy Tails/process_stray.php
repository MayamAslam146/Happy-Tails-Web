<?php
/* ========================================
   HAPPY TAILS - STRAY REPORT PROCESSOR
   ======================================== */

require_once 'config.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get and sanitize form data - matching form field names from submit-stray.php
    $person_name = isset($_POST['reporter-name']) ? sanitize_input($_POST['reporter-name']) : (isset($_POST['name']) ? sanitize_input($_POST['name']) : '');
    $email = sanitize_input($_POST['email']);
    $phone = isset($_POST['contact-number']) ? sanitize_input($_POST['contact-number']) : (isset($_POST['phone']) ? sanitize_input($_POST['phone']) : '');
    $location = sanitize_input($_POST['location']);
    $puppy_condition = sanitize_input($_POST['condition']);
    $description = isset($_POST['message']) ? sanitize_input($_POST['message']) : (isset($_POST['description']) ? sanitize_input($_POST['description']) : '');
    $urgency = isset($_POST['urgency']) ? sanitize_input($_POST['urgency']) : 'medium';
    
    // Validation
    $errors = [];
    
    if (empty($person_name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    }
    
    if (empty($location)) {
        $errors[] = "Location is required";
    }
    
    if (empty($puppy_condition)) {
        $errors[] = "Puppy condition is required";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO stray_reports (person_name, email, phone, location, puppy_condition, description, urgency) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $person_name, $email, $phone, $location, $puppy_condition, $description, $urgency);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Thank you for reporting! Our rescue team will investigate this case immediately. Every report helps save a life! 🐶❤️";
            $stmt->close();
            redirect('submit-stray.php');
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }
    
    // If there are errors
    if (!empty($errors)) {
        $_SESSION['error_message'] = implode('. ', $errors);
        redirect('submit-stray.php');
    }
    
} else {
    redirect('submit-stray.php');
}

$conn->close();
?>

