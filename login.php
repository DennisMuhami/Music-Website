<?php
session_start();

// Get errors from session if they exist
$errors = isset($_SESSION['login_errors']) ? $_SESSION['login_errors'] : [];
$old_email = isset($_SESSION['old_email']) ? $_SESSION['old_email'] : '';

// Check for registration success message
$registration_success = isset($_SESSION['registration_success']) ? $_SESSION['registration_success'] : false;

// Clear all session data after retrieving
unset($_SESSION['login_errors']);
unset($_SESSION['old_email']);
unset($_SESSION['registration_success']);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Musically</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg,
          #1a1a2e 0%,
          #16213e 50%,
          #0f3460 100%);
      background-attachment: fixed;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
      overflow: hidden;
    }

    /* Animated Background Circles */
    body::before {
      content: "";
      position: absolute;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle,
          rgba(255, 0, 110, 0.15),
          transparent);
      border-radius: 50%;
      top: -200px;
      right: -200px;
      animation: float 6s ease-in-out infinite;
    }

    body::after {
      content: "";
      position: absolute;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle,
          rgba(131, 56, 236, 0.15),
          transparent);
      border-radius: 50%;
      bottom: -150px;
      left: -150px;
      animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-30px);
      }
    }

    .login-container {
      background: rgba(10, 10, 26, 0.9);
      backdrop-filter: blur(20px);
      padding: 48px;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
      width: 100%;
      max-width: 450px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      position: relative;
      z-index: 10;
      animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .logo {
      text-align: center;
      margin-bottom: 40px;
    }

    .logo i {
      font-size: 56px;
      background: linear-gradient(135deg, #ff006e, #8338ec);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .logo h1 {
      color: #ffffff;
      font-size: 32px;
      margin-top: 16px;
      font-weight: 700;
    }

    .form-group {
      margin-bottom: 24px;
    }

    label {
      display: block;
      color: #ffffff;
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 8px;
    }

    input[type="email"],
    input[type="password"],
    input[type="text"] {
      width: 100%;
      padding: 16px;
      border: 2px solid rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      background-color: rgba(255, 255, 255, 0.05);
      color: #ffffff;
      font-size: 16px;
      transition: all 0.3s ease;
    }

    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="text"]:focus {
      outline: none;
      border-color: #8338ec;
      background-color: rgba(255, 255, 255, 0.08);
      box-shadow: 0 0 0 4px rgba(131, 56, 236, 0.1);
    }

    input::placeholder {
      color: rgba(255, 255, 255, 0.4);
    }

    .btn-login {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, #ff006e, #8338ec);
      color: #ffffff;
      border: none;
      border-radius: 50px;
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 32px;
      box-shadow: 0 8px 20px rgba(131, 56, 236, 0.3);
    }

    .btn-login:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(131, 56, 236, 0.4);
    }

    .btn-login:active {
      transform: translateY(-1px);
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 32px 0;
      color: rgba(255, 255, 255, 0.5);
    }

    .divider::before,
    .divider::after {
      content: "";
      flex: 1;
      height: 1px;
      background: linear-gradient(to right,
          transparent,
          rgba(255, 255, 255, 0.2),
          transparent);
    }

    .divider span {
      padding: 0 16px;
      font-size: 14px;
    }

    .signup-link {
      text-align: center;
      margin-top: 24px;
      color: rgba(255, 255, 255, 0.6);
    }

    .signup-link a {
      color: #ff006e;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .signup-link a:hover {
      color: #8338ec;
      text-decoration: underline;
    }

    .error-message {
      background: linear-gradient(135deg,
          rgba(255, 0, 0, 0.8),
          rgba(220, 0, 78, 0.8));
      color: #ffffff;
      padding: 14px;
      border-radius: 12px;
      margin-bottom: 20px;
      display: none;
      font-size: 14px;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 16px;
    }

    .remember-me input[type="checkbox"] {
      width: 18px;
      height: 18px;
      cursor: pointer;
      accent-color: #8338ec;
    }

    .remember-me label {
      margin-bottom: 0;
      font-weight: normal;
      color: rgba(255, 255, 255, 0.7);
      cursor: pointer;
    }

    .back-home {
      text-align: center;
      margin-bottom: 24px;
    }

    .back-home a {
      color: rgba(255, 255, 255, 0.6);
      text-decoration: none;
      font-size: 14px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: color 0.3s ease;
    }

    .back-home a:hover {
      color: #ffffff;
    }

    @media (max-width: 480px) {
      .login-container {
        padding: 32px 24px;
      }

      .logo h1 {
        font-size: 28px;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="back-home">
      <a href="home.php">
        <i class="fas fa-arrow-left"></i>
        Back to Home
      </a>
    </div>

    <div class="logo">
      <i class="fas fa-music"></i>
      <h1>Log in to Musically</h1>
    </div>

    <!-- Success message -->
    <?php if ($registration_success): ?>
    <div style="background: linear-gradient(135deg, rgba(40, 167, 69, 0.9), rgba(0, 200, 100, 0.9)); 
                color: #ffffff; 
                padding: 14px; 
                border-radius: 12px; 
                margin-bottom: 20px; 
                font-size: 14px; 
                border: 1px solid rgba(255, 255, 255, 0.2);
                text-align: center;">
      <i class="fas fa-check-circle"></i>
      Registration successful! Please log in with your credentials.
    </div>
    <?php endif; ?>

    <!-- Error messages -->
    <?php if (!empty($errors)): ?>
    <div class="error-message" style="display: block">
      <?php foreach ($errors as $error): ?>
      <div>
        <?php echo $error; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <!-- Keep the hidden div for JavaScript if needed -->
    <div class="error-message" id="errorMessage" style="display: none">
      Invalid email or password
    </div>
    <?php endif; ?>

    <!-- This form will be handled by login.php later -->
    <form id="loginForm" action="auth/login.php" method="POST">
      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" id="email" name="email" required placeholder="Enter your email"
          value="<?php echo htmlspecialchars($old_email); ?>" />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required placeholder="Enter your password" minlength="6" />
      </div>

      <div class="remember-me">
        <input type="checkbox" id="remember" name="remember" />
        <label for="remember">Remember me</label>
      </div>

      <button type="submit" class="btn-login">Log In</button>
    </form>

    <div class="divider">
      <span>or</span>
    </div>

    <div class="signup-link">
      Don't have an account?
      <a href="register.html">Sign up for Musically</a>
    </div>
  </div>

  <script>
    // Simple client-side validation
    // document.getElementById('loginForm').addEventListener('submit', function(e) {
    //     // When PHP is added, this will submit to login.php
    //     // For now, prevent submission and show demo
    //     e.preventDefault();

    //     const email = document.getElementById('email').value;
    //     const password = document.getElementById('password').value;

    //     // Basic validation
    //     if (!email || !password) {
    //         document.getElementById('errorMessage').style.display = 'block';
    //         document.getElementById('errorMessage').textContent = 'Please fill in all fields';
    //         return;
    //     }

    //     // Demo mode - redirect to main page
    //     // When Person A adds PHP, remove this and let the form submit normally
    //     alert('Demo mode: Login form ready for PHP backend!\n\nPerson A will add:\n- Database connection\n- Password verification with password_verify()\n- Session management with session_start()');

    //     // For demo, redirect to main page
    //     // window.location.href = 'index.html';
    // });
  </script>
</body>

</html>
</head>

</html>