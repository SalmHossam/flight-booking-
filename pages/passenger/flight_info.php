<!-- flight_info.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Information</title>
    <link rel="stylesheet" href="../../assets/css/flight_info.css">
</head>
<body>
<?php
// Include the necessary classes and files
require_once '../../classes/model/Flight.php';
require_once '../../classes/repo/FlightRepo.php';
require_once '../../classes/repo/PassengerFlightsRepo.php';

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
        echo '<p>Completed: ' . (htmlspecialchars($flight->isCompleted() ? 'Yes' : 'No')) . '</p>';
        // Add more details as needed

        // Display booking form
        echo '<h2>Book This Flight</h2>';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="flightId" value="' . $flightId . '">';
        echo '<button type="submit" name="book">Book Now</button>';
        echo '</form>';

        // Check if the booking form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book'])) {
            // Check if the user is logged in
            if (isset($_SESSION['user_id'])) {
                $passengerId = htmlspecialchars($_SESSION['user_id']);

                // Create an instance of PassengerFlightsRepo
                $passengerFlightsRepo = new PassengerFlightsRepo();

                // Call the bookFlight method
                $passengerFlightsRepo->bookFlight($passengerId, $flightId);
            } else {
                // Redirect to the login page or handle as needed
                echo 'You need to log in to book a flight.';
            }
        }
    } else {
        echo 'Flight not found.';
    }
} else {
    echo 'Flight ID not provided.';
}
?>

</body>
</html>

