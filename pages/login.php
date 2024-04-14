<?php

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
}

require_once '../classes/model/User.php';
require_once '../classes/repo/UserRepo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']); // Update to match the input field name in the HTML
    $password = htmlspecialchars($_POST['password']);

    $user = new User('', '', $email, $password, '', '');
    $userRepo = new UserRepo();

    $loginResult = $userRepo->login($user);
    
    if ($loginResult !== false) {
        $_SESSION['user_id'] = $loginResult['user_id'];
        if ($loginResult['user_type'] === 'passenger') {
            // User is a passenger, redirect to the passenger dashboard
            header('Location: ./passenger/home.php');
            exit();
        } elseif ($loginResult['user_type'] === 'company') {
            // User is a company, redirect to the company home
            header('Location: ./company/home.php');
            exit();
        }
    } else {
        // Login failed, display an error message or redirect to the login page
         echo "Login failed. Please try again.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/login.css">
  <style>
    /* Add the CSS styles here */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .form-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    .btn-primary {
        background-color: #4caf50;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    a {
        text-decoration: none;
        color: #4caf50;
    }

    a:hover {
        text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="form-container">
      <form id="signup" class="form" action="../pages/login.php" method="post">
        <h2>Login</h2>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="text" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
        <div class="form-group">
          <span>Don't have an account?</span>
          <a href="register.php">Register</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
