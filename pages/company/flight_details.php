<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Details</title>
    <link rel="stylesheet" href="../../assets/css/flight_details.css">
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        color: #333;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }
</style>
</head>
<body>

<?php
// Include the necessary classes and files
require_once '../../classes/model/Flight.php';
require_once '../../classes/repo/FlightRepo.php';
require_once '../../classes/repo/PassengerFlightsRepo.php'; // Add this line

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
}

// Check if the flight ID is provided in the URL
if (isset($_GET['id'])) {
    $flightId = htmlspecialchars($_GET['id']);

    // Create an instance of the FlightRepo
    $flightRepo = new FlightRepo();

    // Get the flight details by ID
    $flight = $flightRepo->getFlightById($flightId);

    if ($flight) {
        // Display flight details
        echo '<h1>Flight Details</h1>';
        echo '<p>ID: ' . htmlspecialchars($flight->getId()) . '</p>';
        echo '<p>Name: ' . htmlspecialchars($flight->getName()) . '</p>';
        echo '<p>Itinerary: ' . htmlspecialchars($flight->getItinerary()) . '</p>';
        echo '<p>Passengers Limit: ' . htmlspecialchars($flight->getPassengersLimit()) . '</p>';
        echo '<p>Fees: ' . htmlspecialchars($flight->getFees()) . '</p>';
        echo '<p>Start Time: ' . htmlspecialchars($flight->getStartTime()) . '</p>';
        echo '<p>End Time: ' . htmlspecialchars($flight->getEndTime()) . '</p>';
        echo '<p>Completed: ' . (htmlspecialchars($flight->isCompleted()) ? 'Yes' : 'No') . '</p>';
        // Add more details as needed

        // Display list of users associated with the flight
        $passengerFlightsRepo = new PassengerFlightsRepo();
        echo '<h2>Passengers</h2>';

        $passengers = $passengerFlightsRepo->getUsersByFlightId($flightId);

        // Check if the array is not empty
        if (!empty($passengers)) {
            echo '<table border="1">';
            echo '<tr>';
            echo '<th>Name</th>';
            echo '<th>Email</th>';
            echo '<th>Telephone</th>';
            echo '<th>Status</th>';
            echo '</tr>';

            foreach ($passengers as $passenger) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($passenger['name']) . '</td>';
                echo '<td>' . htmlspecialchars($passenger['email']) . '</td>';
                echo '<td>' . htmlspecialchars($passenger['tel']) . '</td>';
                echo '<td>' . htmlspecialchars($passenger['status']) . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'No passengers booked for this flight.';
        }

        // Add a delete button
        echo '<form method="post" action="delete_flight.php">';
        echo '<input type="hidden" name="flightId" value="' . $flightId . '">';
        echo '<input type="submit" value="Delete Flight">';
        echo '</form>';
    } else {
        echo 'Flight not found.';
    }
} else {
    echo 'Flight ID not provided.';
}
?>


</body>
</html>
