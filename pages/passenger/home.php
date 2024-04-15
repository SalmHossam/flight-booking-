<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
        }

        img {
            border-radius: 10px;
            margin-bottom: 10px;
        }

        h2 {
            color: #333;
        }

        a {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .button-container {
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            margin-right: 10px;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
} 

require_once '../../classes/model/Passenger.php';
require_once '../../classes/repo/PassengerRepo.php';

// Check if user is logged in
if(isset($_SESSION['user_id'])) {
    $passengerId = $_SESSION['user_id'];
    $passengerRepo = new PassengerRepo();

    // Retrieve passenger profile
    $passenger = $passengerRepo->getPassengerProfile($passengerId);

    if ($passenger) {
        // Display passenger information
        echo "<h1>Welcome, " . htmlspecialchars($passenger->getName()) . "!</h1>";
        echo "<p>Email: " . htmlspecialchars($passenger->getEmail()) . "</p>";
        echo "<p>Tel: " . htmlspecialchars($passenger->getTel()) . "</p>";
        echo "<img src='" . htmlspecialchars($passenger->getPhoto()) . "' alt='Passenger Photo' style='max-width: 200px; max-height: 200px;' />";
        
        // Display completed flights
        echo "<h2>Completed Flights</h2>";
        $completedFlights = $passengerRepo->getCompletedFlights($passengerId);
        if (!empty($completedFlights)) {
            foreach ($completedFlights as $flight) {
                // Display flight details
                echo "<p>Flight Number: " . htmlspecialchars($flight['flight_number']) . "</p>";
                echo "<p>Departure Time: " . htmlspecialchars($flight['departure_time']) . "</p>";
                echo "<p>Arrival Time: " . htmlspecialchars($flight['arrival_time']) . "</p>";
                echo "<p>Status: " . htmlspecialchars($flight['status']) . "</p>";
            }
        } else {
            echo "<p>No completed flights.</p>";
        }

        // Display current flights
        echo "<h2>Current Flights</h2>";
        $currentFlights = $passengerRepo->getCurrentFlights($passengerId);
        if (!empty($currentFlights)) {
            foreach ($currentFlights as $flight) {
                // Display flight details
                echo "<p>Flight Number: " . htmlspecialchars($flight['flight_number']) . "</p>";
                echo "<p>Departure Time: " . htmlspecialchars($flight['departure_time']) . "</p>";
                echo "<p>Arrival Time: " . htmlspecialchars($flight['arrival_time']) . "</p>";
                echo "<p>Status: " . htmlspecialchars($flight['status']) . "</p>";
            }
        } else {
            echo "<p>No current flights.</p>";
        }

        // Profile link
        echo "<a href='profile.php'>View/Edit Profile</a>";

        // Search a flight link
        echo "<a href='search_flight.php'>Search for a Flight</a>";
        // Button container
        echo "<div class='button-container'>";

        // Feedback button
        echo "<a href='../../assets/html/feedback.html' class='button'>Feedback</a>";

        // Contact Us button
        echo "<a href='../../assets/html/contactus.html' class='button'>Contact Us</a>";

        // About Us button
        echo "<a href='../../assets/html/aboutus.html' class='button'>About Us</a>";

        echo "</div>";
    } else {
        echo "<p class='error'>Failed to fetch passenger data.</p>";
    }
} else {
    echo "<p class='error'>User not logged in.</p>";
}
?>


</body>
</html>
