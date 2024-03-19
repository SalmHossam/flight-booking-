<?php

require_once '../../classes/repo/FlightRepo.php';

// Create an instance of FlightRepo
$flightRepo = new FlightRepo();

// Initialize variables
$searchResults = [];
$allFlights = [];

// Check if form is submitted for search
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    // Get the search parameters from the form
    $from = $_POST['from'];
    $to = $_POST['to'];

    // Perform the search
    $searchResults = $flightRepo->searchFlights($from, $to);
}

// Display all flights
$allFlights = $flightRepo->getAllFlights();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search</title>
    <link rel="stylesheet" href="../../assets/css/searchFlightStyle.css">
</head>
<body>

<h1>Search for a Flight</h1>

<form method="post" action="">
    <label for="from">From:</label>
    <input type="text" name="from" required>

    <label for="to">To:</label>
    <input type="text" name="to" required>

    <button type="submit" name="search">Search</button>
</form>

<!-- Display search results -->
<?php if (!empty($searchResults)) : ?>
    <h2>Search Results:</h2>
    <ul>
        <?php foreach ($searchResults as $flight) : ?>
            <li><a href='flight_info.php?id=<?= $flight->getId() ?>'><?= $flight->getName() ?> - <?= $flight->getItinerary() ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<!-- Display all flights -->
<?php if (!empty($allFlights)) : ?>
    <h2>All Flights:</h2>
    <ul>
        <?php foreach ($allFlights as $flight) : ?>
            <li><a href='flight_info.php?id=<?= $flight->getId() ?>'><?= $flight->getName() ?> - <?= $flight->getItinerary() ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>No flights available.</p>
<?php endif; ?>

</body>
</html>
