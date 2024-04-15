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
                $name = $passenger->getName();
                $username = $passenger->getUsername();
                $email = $passenger->getEmail();
                $tel = $passenger->getTel();
                $id = $passenger->getId();
    
                // Bind parameters
                mysqli_stmt_bind_param($userStmt, "ssssi", $name, $username, $email, $tel, $id);
    
                // Execute the statement
                mysqli_stmt_execute($userStmt);
    
                // Update additional passenger data
                $passengerSql = "UPDATE passenger
                        SET passport_img = ?, photo = ?
                        WHERE id = ?";
                $passengerStmt = mysqli_prepare(parent::get_connect(), $passengerSql);
    
                if ($passengerStmt) {
                    $passportImg = $passenger->getPassportImg();
                    $photo = $passenger->getPhoto();
                    $id = $passenger->getId();
    
                    // Bind parameters
                    mysqli_stmt_bind_param($passengerStmt, "ssi", $passportImg, $photo, $id);
    
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
    public function getCurrentFlights($passengerId) {
        try {
            parent::connect();  // Connect to the database
    
            // Fetch current flights for the passenger
            $sql = "SELECT name AS flight_number, start_time AS departure_time, end_time AS arrival_time, passenger_flights.status 
            FROM flights 
            INNER JOIN passenger_flights ON flights.id = passenger_flights.flight_id
            WHERE passenger_flights.passenger_id = ? AND passenger_flights.status = 'Pending'";
    
            $stmt = mysqli_prepare(parent::get_connect(), $sql);
    
            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "i", $passengerId);
    
                // Execute the statement
                mysqli_stmt_execute($stmt);
    
                // Fetch results
                mysqli_stmt_bind_result($stmt, $flightNumber, $departureTime, $arrivalTime, $status);
    
                $currentFlights = [];
    
                // Fetch all current flights for the passenger
                while (mysqli_stmt_fetch($stmt)) {
                    // Create a flight object and add it to the current flights array
                    $flight = [
                        'flight_number' => $flightNumber,
                        'departure_time' => $departureTime,
                        'arrival_time' => $arrivalTime,
                        'status' => $status
                    ];
                    $currentFlights[] = $flight;
                }
    
                // Return the current flights array
                return $currentFlights;
            } else {
                throw new Exception("Failed to prepare current flights statement: " . mysqli_error(parent::get_connect()));
            }
        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, display a user-friendly message)
            echo "Error: " . $e->getMessage();
            return null;
        } finally {
            parent::disconnect();  // Disconnect from the database in all cases
        }
    }
    
    public function getCompletedFlights($passengerId) {
        try {
            parent::connect();  // Connect to the database
    
            // Fetch completed flights for the passenger
            $sql = "SELECT name AS flight_number, start_time AS departure_time, end_time AS arrival_time, completed AS status 
            FROM flights 
            INNER JOIN passenger_flights ON flights.id = passenger_flights.flight_id
            WHERE passenger_flights.passenger_id = ? AND passenger_flights.status = 'Completed'";
    
            $stmt = mysqli_prepare(parent::get_connect(), $sql);
    
            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "i", $passengerId);
    
                // Execute the statement
                mysqli_stmt_execute($stmt);
    
                // Fetch results
                mysqli_stmt_bind_result($stmt, $flightNumber, $departureTime, $arrivalTime, $status);
    
                $completedFlights = [];
    
                // Fetch all completed flights for the passenger
                while (mysqli_stmt_fetch($stmt)) {
                    // Create a flight object and add it to the completed flights array
                    $flight = [
                        'flight_number' => $flightNumber,
                        'departure_time' => $departureTime,
                        'arrival_time' => $arrivalTime,
                        'status' => $status
                    ];
                    $completedFlights[] = $flight;
                }
    
                // Return the completed flights array
                return $completedFlights;
            } else {
                throw new Exception("Failed to prepare completed flights statement: " . mysqli_error(parent::get_connect()));
            }
        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, display a user-friendly message)
            echo "Error: " . $e->getMessage();
            return null;
        } finally {
            parent::disconnect();  // Disconnect from the database in all cases
        }
    }
    
    
   
    // Add more functions as needed for passenger-related operations
}
