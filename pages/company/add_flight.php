<?php

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
}

include_once '../../classes/model/Flight.php';
require_once '../../classes/repo/FlightRepo.php';

session_start();
$companyId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $flightName = $_POST['flight_name'];
    $itinerary = $_POST['itinerary'];
    $passengersLimit = $_POST['passengers_limit'];
    $fees = $_POST['fees'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
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

<!-- Add the form here -->
<form action="add_flight.php" method="post">
    <label for="flight_name">Flight Name:</label>
    <input type="text" name="flight_name" id="flight_name" required><br>

    <label for="itinerary">Itinerary:</label>
    <input type="text" name="itinerary" id="itinerary" required><br>

    <label for="passengers_limit">Passengers Limit:</label>
    <input type="number" name="passengers_limit" id="passengers_limit" required><br>

    <label for="fees">Fees:</label>
    <input type="number" name="fees" id="fees" required><br>

    <label for="start_time">Start Time:</label>
    <input type="datetime-local" name="start_time" id="start_time" required><br>

    <label for="end_time">End Time:</label>
    <input type="datetime-local" name="end_time" id="end_time" required><br>

    <label for="is_completed">Is Completed:</label>
    <input type="checkbox" name="is_completed" id="is_completed"><br>

    <button type="submit">Add Flight</button>
</form>