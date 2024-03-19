<?php

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
}

require_once '../classes/model/User.php';
require_once '../classes/repo/UserRepo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            // User is a passenger, redirect to the passenger profile
            header('Location: passenger/profile.php');
        
        } elseif ($userType === 'company') {
            // User is a company, redirect to the company profile
            header('Location: company/profile.php');
        }
        exit();
    } else {
        // Registration failed
        // echo "Registration failed. Please try again.";
    }
}

?>
