<?php

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
}

require_once '../classes/model/User.php';
require_once '../classes/repo/UserRepo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $tel = htmlspecialchars($_POST['tel']);
    $userType = htmlspecialchars($_POST['user_type']); // Update to match the select field name in the HTML

    $user = new User($name, $username, $email, $password, $tel, $userType);
    $userRepo = new UserRepo();

    $userId = $userRepo->register($user);

    if ($userId !== false) {
        $_SESSION['user_id'] = $userId;

        if ($userType === 'passenger') {
            // User is a passenger, redirect to the passenger profile
            header('Location: ./passenger/profile.php');

        } elseif ($userType === 'company') {
            // User is a company, redirect to the company profile
            header('Location: ./company/profile.php');
        }
        exit();
    } else {
        // Registration failed
        // echo "Registration failed. Please try again.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../asset/css/register.css">
    <title>Registration Form</title>
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
            width: 400px; /* Set a fixed width to the form container */
            margin: auto; /* Center the form container */
        }

        .form-container h1 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%; /* Make the button fill the container */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Registration Form</h1>
            <form id="registrationForm" action="../pages/register.php" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="username">User Name:</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="tel">Phone Number:</label>
                    <input type="tel" id="tel" name="tel" required>
                </div>

                <div class="form-group">
                    <label>Type:</label>
                    <select id="user_type" name="user_type" onchange="showInfoSection()">
                        <option value="company">Company</option>
                        <option value="passenger">Passenger</option>
                    </select>
                </div>

                <button type="submit">Register</button>
            </form>
        </div>
    </div>

    <script>
        function showInfoSection() {
            // Implement your logic here if needed
        }
    </script>
</body>
</html>
