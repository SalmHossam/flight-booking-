<?php

require_once '../../includes/db_connection.php';
require_once '../../includes/authentication.php';

class PassengerFlightsRepo extends db_connection {

    public function bookFlight($passengerId, $flightId) {
        try {
            parent::connect();  // Connect to the database

            // Check if the passenger has already booked the flight
            $checkSql = "SELECT id FROM passenger_flights WHERE passenger_id = ? AND flight_id = ?";
            $checkStmt = mysqli_prepare(parent::get_connect(), $checkSql);

            if ($checkStmt) {
                // Bind parameters
                mysqli_stmt_bind_param($checkStmt, "ii", $passengerId, $flightId);

                // Execute the statement
                mysqli_stmt_execute($checkStmt);

                // Get the result
                $checkResult = mysqli_stmt_get_result($checkStmt);

                // If the passenger has not booked the flight, proceed with booking
                if (mysqli_num_rows($checkResult) == 0) {
                    // Book the flight
                    $bookSql = "INSERT INTO passenger_flights (passenger_id, flight_id, status) VALUES (?, ?, 'Pending')";
                    $bookStmt = mysqli_prepare(parent::get_connect(), $bookSql);

                    if ($bookStmt) {
                        // Bind parameters
                        mysqli_stmt_bind_param($bookStmt, "ii", $passengerId, $flightId);

                        // Execute the statement
                        mysqli_stmt_execute($bookStmt);

                        echo "Flight booked successfully.";
                    } else {
                        throw new Exception("Failed to book the flight.");
                    }
                } else {
                    throw new Exception("Passenger has already booked the flight.");
                }
            } else {
                throw new Exception("Failed to check booking status.");
            }
        } catch (Exception $e) {
            // Handle exceptions
            echo "Error: " . $e->getMessage();
        } finally {
            parent::disconnect();  // Disconnect from the database in all cases
        }
    }
    
    public function getUsersByFlightId($flightId) {
    try {
        parent::connect();  // Connect to the database

        // Retrieve users' name, email, status, and tel associated with the specified flight ID
        $sql = "SELECT u.name, u.email, pf.status, u.tel
                FROM users u
                JOIN passenger p ON u.id = p.id
                JOIN passenger_flights pf ON p.id = pf.passenger_id
                WHERE pf.flight_id = ?";
        $stmt = mysqli_prepare(parent::get_connect(), $sql);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "i", $flightId);

            // Execute the statement
            mysqli_stmt_execute($stmt);

            // Get the result
            $result = mysqli_stmt_get_result($stmt);

            // Fetch all rows as an associative array
            $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

            return $users; // Return the result
        } else {
            throw new Exception("Failed to fetch users by flight ID.");
        }
    } catch (Exception $e) {
        // Handle exceptions
        echo "Error: " . $e->getMessage();
    } finally {
        parent::disconnect();  // Disconnect from the database in all cases
    }
}


}

?>
