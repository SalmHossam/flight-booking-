<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 20px;
        }

        h1, h2 {
            color: #333;
        }

        form {
            max-width: 400px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            color: #555;
        }

        .no-flights {
            color: #555;
            font-style: italic;
        }
    </style>
</head>
<body>

<!-- search_flight.php -->
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
            <li><a href='flight_info.php?id=<?= htmlspecialchars($flight->getId()) ?>'><?= htmlspecialchars($flight->getName()) ?> - <?= htmlspecialchars($flight->getItinerary()) ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<!-- Display all flights -->
<?php if (!empty($allFlights)) : ?>
    <h2>All Flights:</h2>
    <ul>
        <?php foreach ($allFlights as $flight) : ?>
            <li><a href='flight_info.php?id=<?= htmlspecialchars($flight->getId()) ?>'><?= htmlspecialchars($flight->getName()) ?> - <?= htmlspecialchars($flight->getItinerary()) ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p class="no-flights">No flights available.</p>
<?php endif; ?>


</body>
</html>
