<?php
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
} 

require_once '../../classes/model/Passenger.php';
require_once '../../classes/repo/PassengerRepo.php';
require_once '../../includes/authentication.php';

$passengerId = $_SESSION['user_id'];
$passengerRepo = new PassengerRepo();

$passenger = $passengerRepo->getPassengerProfile($passengerId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome, Passenger!</title>
    <link rel="stylesheet" href="../../assets/css/pHomeStyle.css">
    <link rel="stylesheet" href="../../assets/libraries/jquery-ui/jquery-ui.min.css">
</head>
<body>

<div class="profile-container">
    <?php
    if ($passenger) {
        // Display passenger information
        echo "<h1>Welcome, {$passenger->getName()}!</h1>";
        echo "<p>Email: {$passenger->getEmail()}</p>";
        echo "<p>Tel: {$passenger->getTel()}</p>";
        echo "<img src='{$passenger->getPhoto()}' alt='Passenger Photo' class='profile-photo' />";

        // List of completed flights (you'll need to implement this logic)
        echo "<h2>Completed Flights</h2>";
        // Display completed flights here

        // Current flights (you'll need to implement this logic)
        echo "<h2>Current Flights</h2>";
        // Display current flights here

        // Profile link
        echo "<a href='profile.php'>View/Edit Profile</a>";

        // Search a flight link
        echo "<a href='search_flight.php'>Search for a Flight</a>";
    } else {
        echo "Failed to fetch passenger data.";
    }
    ?>
</div>

<script src="../../assets/libraries/jquery/jquery.min.js"></script>
<script src="../../assets/libraries/jquery-ui/jquery-ui.min.js"></script>
<script src="../../assets/js/scripts.js"></script>
</body>
</html>

