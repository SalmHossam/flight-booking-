<?php

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
}

require_once '../classes/model/User.php';
require_once '../classes/repo/UserRepo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User('', '', $email, $password, '', '');
    $userRepo = new UserRepo();

    $loginResult = $userRepo->login($user);

    if ($loginResult !== false) {
        $_SESSION['user_id'] = $loginResult['user_id'];
        if ($loginResult['user_type'] === 'passenger') {
            // User is a passenger, redirect to the passenger dashboard
            header('Location: passenger/home.php'); 
      
        } elseif ($loginResult['user_type'] === 'company') {
            // User is a company, redirect to the company home
            header('Location: company/home.php');
        }
        exit();
    } else {
        // Login failed, display an error message or redirect to the login page
        // echo "Login failed. Please try again.";
    }
}

?>