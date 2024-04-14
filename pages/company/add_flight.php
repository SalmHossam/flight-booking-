<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Flight</title>
    <link rel="stylesheet" href="../../assets/css/addFlight.css">
</head>
<body>

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
}

include_once '../../classes/model/Flight.php';
require_once '../../classes/repo/FlightRepo.php';

session_start();
$companyId = htmlspecialchars($_SESSION['user_id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $flightName = htmlspecialchars($_POST['flight_name']);
    $itinerary = htmlspecialchars($_POST['itinerary']);
    $passengersLimit = htmlspecialchars($_POST['passengers_limit']);
    $fees = htmlspecialchars($_POST['fees']);
    $startTime = htmlspecialchars($_POST['start_time']);
    $endTime = htmlspecialchars($_POST['end_time']);
    $isCompleted = isset($_POST['is_completed']) ? 1 : 0; // Assuming is_completed is a checkbox

    // Validate form data (perform validation as needed)

    // Create a Flight object
    $flight = new Flight($companyId, $flightName, $itinerary, $passengersLimit, $fees, $startTime, $endTime, $isCompleted);

    // Create an instance of the FlightRepo
    $flightRepo = new FlightRepo();

    // Add the flight
    $addedFlight = $flightRepo->addFlight($flight);

    if ($addedFlight) {
        // Redirect back to the home page
        header("Location: home.php");
        exit(); // Ensure that no further code is executed after the header
    } else {
        echo "Failed to add flight.";
    }
}
?>
<div class="container">
    <div class="form-container">
        <h1>Add Flight</h1>
        <form id="addFlightForm" class="flight-form" action="../../pages/company/add_flight.php" method="post">
            <label for="flight_name">Flight Name:</label>
            <input type="text" name="flight_name" id="flight_name" required>

            <label for="itinerary">Itinerary:</label>
            <input type="text" name="itinerary" id="itinerary" required>

            <label for="passengers_limit">Passengers Limit:</label>
            <input type="number" name="passengers_limit" id="passengers_limit" required>

            <label for="fees">Fees:</label>
            <input type="number" name="fees" id="fees" required>

            <label for="start_time">Start Time:</label>
            <input type="datetime-local" name="start_time" id="start_time" required>

            <label for="end_time">End Time:</label>
            <input type="datetime-local" name="end_time" id="end_time" required>

            <label for="is_completed">Is Completed:</label>
            <input type="checkbox" name="is_completed" id="is_completed">

            <button type="submit">Add Flight</button>
        </form>
    </div>
</div>

</body>
</html>
