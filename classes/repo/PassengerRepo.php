<?php

require_once '../../classes/model/Passenger.php';
require_once '../../includes/db_connection.php';
require_once '../../includes/authentication.php';

class PassengerRepo extends db_connection {
    
    public function getPassengerProfile($passengerId) {
        try {
            parent::connect();  // Connect to the database

            // Fetch passenger data
            $sql = "SELECT users.id, users.name, users.username, users.email, users.tel, passenger.passport_img, passenger.photo
                    FROM users
                    INNER JOIN passenger ON users.id = passenger.id
                    WHERE users.id = ?";
            $stmt = mysqli_prepare(parent::get_connect(), $sql);

            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "i", $passengerId);

                // Execute the statement
                mysqli_stmt_execute($stmt);

                // Fetch results
                mysqli_stmt_bind_result($stmt, $userId, $name, $username, $email, $tel, $passportImg, $photo);

                if (mysqli_stmt_fetch($stmt)) {
                    // Create a Passenger object and return
                    $passenger = new Passenger($name, $username, $email, '', $tel, $passportImg, $photo);
                    $passenger->setId($userId); // Set the ID

                    return $passenger;
                } else {
                    throw new Exception("Passenger not found.");
                }
            } else {
                throw new Exception("Failed to fetch passenger data.");
            }
        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, display a user-friendly message)
            echo "Error: " . $e->getMessage();
            return null;
        } finally {
            parent::disconnect();  // Disconnect from the database in all cases
        }
    }

    public function updatePassengerProfile(Passenger $passenger) {
        try {
            parent::connect();  // Connect to the database

            // Update passenger data
            $userSql = "UPDATE users
                    SET name = ?, username = ?, email = ?, tel = ?
                    WHERE id = ?";
            $userStmt = mysqli_prepare(parent::get_connect(), $userSql);

            if ($userStmt) {
                // Bind parameters
                mysqli_stmt_bind_param($userStmt, "ssssi", $passenger->getName(), $passenger->getUsername(), $passenger->getEmail(), $passenger->getTel(), $passenger->getId());

                // Execute the statement
                mysqli_stmt_execute($userStmt);

                // Update additional passenger data
                $passengerSql = "UPDATE passenger
                        SET passport_img = ?, photo = ?
                        WHERE id = ?";
                $passengerStmt = mysqli_prepare(parent::get_connect(), $passengerSql);

                if ($passengerStmt) {
                    // Bind parameters
                    mysqli_stmt_bind_param($passengerStmt, "ssi", $passenger->getPassportImg(), $passenger->getPhoto(), $passenger->getId());

                    // Execute the statement
                    mysqli_stmt_execute($passengerStmt);

                    echo "Passenger profile updated successfully.";
                } else {
                    throw new Exception("Failed to update passenger data.");
                }
            } else {
                throw new Exception("Failed to update user data.");
            }
        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, display a user-friendly message)
            echo "Error: " . $e->getMessage();
        } finally {
            parent::disconnect();  // Disconnect from the database in all cases
        }
    }

    // Add more functions as needed for passenger-related operations
}

?>