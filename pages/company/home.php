<!-- home.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Home</title>
    <link rel="stylesheet" href="../../assets/css/company.css">
</head>
<body>

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
$companyId = htmlspecialchars($_SESSION['user_id']); // Escape session user ID

// Get company profile
$company = $companyRepo->getCompanyProfile($companyId);

// Output company information (Logo, name, etc.)
echo '<div>';
echo '<img src="' . htmlspecialchars($company->getLogoImg()) . '" alt="Company Logo">'; // Escape logo image
echo '<h1>' . htmlspecialchars($company->getName()) . '</h1>'; // Escape company name
echo '<p>' . htmlspecialchars($company->getBio()) . '</p>'; // Escape company bio
// Add more company information as needed
echo '</div>';

// List of Flights
$flights = $flightRepo->getAllFlightsByCompanyId($companyId);
    
echo '<table>';
echo '<thead>';
echo '<tr><th>ID</th><th>Name</th><th>Itinerary</th><th>Actions</th></tr>';
echo '</thead>';
echo '<tbody>';
foreach ($flights as $flight) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($flight->getId()) . '</td>'; // Escape flight ID
    echo '<td>' . htmlspecialchars($flight->getName()) . '</td>'; // Escape flight name
    echo '<td>' . htmlspecialchars($flight->getItinerary()) . '</td>'; // Escape itinerary
    echo '<td><a href="flight_details.php?id=' . htmlspecialchars($flight->getId()) . '">View Details</a></td>'; // Escape flight ID in URL
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';

// Profile and Messages links
echo '<div>';
echo '<a href="profile.php">Profile</a>';
echo '<a href="add_flight.php">Add Flight</a>';
echo '</div>';
?>

</body>
</html>