<?php

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
}
    
include_once '../../classes/model/Company.php'; 
include_once '../../classes/model/Flight.php';   
require_once '../../classes/repo/CompanyRepo.php';
require_once '../../classes/repo/FlightRepo.php';

// Create instances of the repositories
$companyRepo = new CompanyRepo();
$flightRepo = new FlightRepo();

//session_start();
$companyId = $_SESSION['user_id'];

// Get company profile
$company = $companyRepo->getCompanyProfile($companyId);

// List of Flights
$flights = $flightRepo->getAllFlightsByCompanyId($companyId);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Home</title>
    <link rel="stylesheet" href="../../assets/css/cHomeStyle.css">
    <link rel="stylesheet" href="../../assets/libraries/jquery-ui/jquery-ui.min.css">
</head>
<body>

<div class="company-container">

    <?php
    // Output company information (Logo, name, etc.)
    echo '<div class="company-info">';
    echo '<img src="' . $company->getLogoImg() . '" alt="Company Logo" class="company-logo">';
    echo '<h1>' . $company->getName() . '</h1>';
    echo '<p>' . $company->getBio() . '</p>';
    // Add more company information as needed
    echo '</div>';

    // List of Flights
    echo '<table class="flight-table">';
    echo '<thead>';
    echo '<tr><th>ID</th><th>Name</th><th>Itinerary</th><th>Actions</th></tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($flights as $flight) {
        echo '<tr>';
        echo '<td>' . $flight->getId() . '</td>';
        echo '<td>' . $flight->getName() . '</td>';
        echo '<td>' . $flight->getItinerary() . '</td>';
        echo '<td><a href="flight_details.php?id=' . $flight->getId() . '">View Details</a></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';

    // Profile and Messages links
    echo '<div class="company-links">';
    echo '<a href="profile.php">Profile</a>';
    echo '<a href="messages.php">Messages</a>';
    echo '<a href="add_flight.php">Add Flight</a>';
    echo '</div>';
    ?>

</div>

<script src="../../assets/libraries/jquery/jquery.min.js"></script>
<script src="../../assets/libraries/jquery-ui/jquery-ui.min.js"></script>
<script src="../../assets/js/scripts.js"></script>
</body>
</html>