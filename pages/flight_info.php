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

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
}

// Check if the flight ID is provided in the URL
if (isset($_GET['id'])) {
    $flightId = $_GET['id'];

    // Create an instance of the FlightRepo
    $flightRepo = new FlightRepo();

    // Get the flight details by ID
    $flight = $flightRepo->getFlightById($flightId);

    if ($flight) {
        // Display flight details
        ?>
        <h1>Flight Details</h1>
        <p>ID: <?php echo htmlspecialchars($flight->getId()); ?></p>
        <p>Name: <?php echo htmlspecialchars($flight->getName()); ?></p>
        <p>Itinerary: <?php echo htmlspecialchars($flight->getItinerary()); ?></p>
        <p>Passengers Limit: <?php echo htmlspecialchars($flight->getPassengersLimit()); ?></p>
        <p>Fees: <?php echo htmlspecialchars($flight->getFees()); ?></p>
        <p>Start Time: <?php echo htmlspecialchars($flight->getStartTime()); ?></p>
        <p>End Time: <?php echo htmlspecialchars($flight->getEndTime()); ?></p>
        <p>Completed: <?php echo ($flight->isCompleted() ? 'Yes' : 'No'); ?></p>
        <!-- Add more details as needed -->
        <?php
    } else {
        echo 'Flight not found.';
    }
} else {
    echo 'Flight ID not provided.';
}
?>


</body>
</html>
