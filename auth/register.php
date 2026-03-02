<?php
// Include database connection
require_once 'config.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data and remove extra spaces
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmPassword'];
    
    // Array to store errors
    $errors = [];
    
    // Validate username
    if (empty($username)) {
        $errors[] = "Username is required";
    } elseif (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters";
    }
    
    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Validate password
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    
    // Validate confirm password
    if ($password != $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    // If no errors, check if email already exists
    if (empty($errors)) {
        // Check if email exists
        $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
        if (mysqli_num_rows($check_email) > 0) {
            $errors[] = "Email already registered";
        }
        
        // Check if username exists
        $check_username = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username'");
        if (mysqli_num_rows($check_username) > 0) {
            $errors[] = "Username already taken";
        }
    }
    
    // If still no errors, insert into database
    if (empty($errors)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert query
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        
        if (mysqli_query($conn, $sql)) {
            // Start session to store success message
            session_start();
            
            // Set success message
            $_SESSION['registration_success'] = true;
            
            // Redirect to login page
            header("Location: ../login.php");
            exit;
        } else {
            $errors[] = "Registration failed: " . mysqli_error($conn);
        }
    }
    
    // If we get here, registration failed
    // Store errors and old input in session
    session_start();
    $_SESSION['register_errors'] = $errors;
    $_SESSION['old_input'] = [
        'username' => $username,
        'email' => $email
    ];
    
    // Redirect back to registration page
    header("Location: ../register.php");
    exit;
    
} else {
    // If someone tries to access directly without POST
    header("Location: ../register.php");
    exit;
}
?>