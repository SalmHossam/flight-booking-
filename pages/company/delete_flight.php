<?php

require_once '../../classes/repo/FlightRepo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['flightId'])) {
        $flightId = htmlspecialchars($_POST['flightId']);

        // Create an instance of the FlightRepo
        $flightRepo = new FlightRepo();

        // Attempt to delete the flight
        if ($flightRepo->deleteFlight($flightId)) {
            // Redirect to the home page
            header('Location: home.php');
            exit();
        } else {
            echo 'Failed to delete flight.';
        }
    } else {
        echo 'Flight ID not provided.';
    }
} else {
    echo 'Invalid request method.';
}
?>

