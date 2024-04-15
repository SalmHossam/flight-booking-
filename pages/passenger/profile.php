<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
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
    // Display passenger profile data with output encoding
    echo "<h1>Passenger Profile</h1>";
    echo "Name: " . htmlspecialchars($passenger->getName()) . "<br>";
    echo "Username: " . htmlspecialchars($passenger->getUsername()) . "<br>";
    echo "Email: " . htmlspecialchars($passenger->getEmail()) . "<br>";
    echo "Phone: " . htmlspecialchars($passenger->getTel()) . "<br>";
    // Display other profile data as needed

    // Update Passenger Profile (Assuming you have form data to update the profile)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updatedPassenger = new Passenger(
            htmlspecialchars($_POST['name']),
            htmlspecialchars($_POST['username']),
            htmlspecialchars($_POST['email']),
            '',
            htmlspecialchars($_POST['tel']),
            htmlspecialchars($_POST['passportImg']),
            htmlspecialchars($_POST['photo'])
        );
        $updatedPassenger->setId($passengerId);

        // Update the passenger profile
        $passengerRepo->updatePassengerProfile($updatedPassenger);

        // Refresh the page to display updated data
        header("Location: profile.php");
        exit();
    }

    // Display a form to update passenger profile data with output encoding
    ?>
    <form method="post" action="./profile.php">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($passenger->getName()); ?>">

        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($passenger->getUsername()); ?>">

        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($passenger->getEmail()); ?>">

        <label for="tel">Phone:</label>
        <input type="text" name="tel" value="<?php echo htmlspecialchars($passenger->getTel()); ?>">

        <label for="passportImg">Passport Image:</label>
        <input type="text" name="passportImg" value="<?php echo htmlspecialchars($passenger->getPassportImg()); ?>">

        <label for="photo">Photo:</label>
        <input type="text" name="photo" value="<?php echo htmlspecialchars($passenger->getPhoto()); ?>">

        <input type="submit" value="Update Profile">
    </form>
    <?php
} else {
    echo "<p class='error'>Passenger not found.</p>";
}
?>

</body>
</html>
