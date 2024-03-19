<?php

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
}

require_once '../../classes/model/Passenger.php';
require_once '../../classes/repo/PassengerRepo.php';

$passengerId = $_SESSION['user_id'];

// Create an instance of PassengerRepo
$passengerRepo = new PassengerRepo();

// Get Passenger Profile
$passenger = $passengerRepo->getPassengerProfile($passengerId);

if ($passenger) {
    // Display passenger profile data
    // echo "Passenger ID: " . $passenger->getId() . "<br>";
    echo "Name: " . $passenger->getName() . "<br>";
    echo "Username: " . $passenger->getUsername() . "<br>";
    echo "Email: " . $passenger->getEmail() . "<br>";
    echo "Phone: " . $passenger->getTel() . "<br>";
    // Display other profile data as needed

    // Update Passenger Profile (Assuming you have form data to update the profile)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updatedPassenger = new Passenger(
            $_POST['name'],
            $_POST['username'],
            $_POST['email'],
            '',
            $_POST['tel'],
            $_POST['passportImg'],
            $_POST['photo']
        );
        $updatedPassenger->setId($passengerId);

        // Update the passenger profile
        $passengerRepo->updatePassengerProfile($updatedPassenger);

        // Refresh the page to display updated data
        header("Location: profile.php");
        exit();
    }

    // Display a form to update passenger profile data
    ?>
    <form method="post" action="profile.php">
        Name: <input type="text" name="name" value="<?php echo $passenger->getName(); ?>"><br>
        Username: <input type="text" name="username" value="<?php echo $passenger->getUsername(); ?>"><br>
        Email: <input type="text" name="email" value="<?php echo $passenger->getEmail(); ?>"><br>
        Phone: <input type="text" name="tel" value="<?php echo $passenger->getTel(); ?>"><br>
        Passport Image: <input type="text" name="passportImg" value="<?php echo $passenger->getPassportImg(); ?>"><br>
        Photo: <input type="text" name="photo" value="<?php echo $passenger->getPhoto(); ?>"><br>

        <input type="submit" value="Update Profile">
    </form>
    <?php
} else {
    echo "Passenger not found.";
}
?>

