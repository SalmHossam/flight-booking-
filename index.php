<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
}
echo "w";
require_once '../classes/model/User.php';
echo "w";
echo "w";
require_once '../classes/repo/UserRepo.php';
echo "w";

// Login Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User('', '', $email, $password, '', '');
    $userRepo = new UserRepo();

    $loginResult = $userRepo->login($user);

    if ($loginResult !== false) {
        $_SESSION['user_id'] = $loginResult['user_id'];
        if ($loginResult['user_type'] === 'passenger') {
            header('Location: passenger/home.php');
        } elseif ($loginResult['user_type'] === 'company') {
            header('Location: company/home.php');
        }
        exit();
    } else {
        $loginError = "Login failed. Please try again.";
    }
}

// Registration Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tel = $_POST['tel'];
    $userType = $_POST['userType'];

    $user = new User($name, $username, $email, $password, $tel, $userType);
    $userRepo = new UserRepo();

    $userId = $userRepo->register($user);

    if ($userId !== false) {
        $_SESSION['user_id'] = $userId;

        if ($userType === 'passenger') {
            header('Location: passenger/profile.php');
        } elseif ($userType === 'company') {
            header('Location: company/profile.php');
        }
        exit();
    } else {
        $registrationError = "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
</head>
<body>

    <h1>Welcome to Your Website</h1>

    <!-- Login Form -->
    <h2>Login</h2>
    <form method="post" action="">
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <input type="submit" name="login" value="Login">
    </form>
    <?php if (isset($loginError)) echo "<p>$loginError</p>"; ?>

    <!-- Registration Form -->
    <h2>Register</h2>
    <form method="post" action="">
        <label>Name: <input type="text" name="name" required></label><br>
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <label>Phone Number: <input type="tel" name="tel" required></label><br>
        <label>User Type:
            <select name="userType">
                <option value="passenger">Passenger</option>
                <option value="company">Company</option>
            </select>
        </label><br>
        <input type="submit" name="register" value="Register">
    </form>
    <?php if (isset($registrationError)) echo "<p>$registrationError</p>"; ?>

</body>
</html>
