<?php
// Start session
session_start();

// Include database connection
require_once 'config.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;
    
    // Array to store errors
    $errors = [];
    
    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    
    // Validate password
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    // If no errors, check credentials
    if (empty($errors)) {
        // Query to find user by email
        $sql = "SELECT id, username, email, password FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct - login successful
                
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['logged_in'] = true;
                
                // Set remember me cookie if checked
                if ($remember) {
                    // Cookie will expire in 30 days (86400 seconds * 30 days)
                    setcookie('remember_email', $email, time() + (86400 * 30), '/');
                } else {
                    // Clear remember me cookie if it exists
                    if (isset($_COOKIE['remember_email'])) {
                        setcookie('remember_email', '', time() - 3600, '/');
                    }
                }
                
                // Redirect to home page
                header("Location: ../home.php");
                exit;
                
            } else {
                // Wrong password
                $errors[] = "Invalid email or password";
            }
        } else {
            // Email not found
            $errors[] = "Invalid email or password";
        }
    }
    
    // If we get here, login failed
    // Store errors and old input in session
    $_SESSION['login_errors'] = $errors;
    $_SESSION['old_email'] = $email;
    
    // Redirect back to login page
    header("Location: ../login.php");
    exit;
    
} else {
    // If someone tries to access directly without POST
    header("Location: ../login.php");
    exit;
}
?>