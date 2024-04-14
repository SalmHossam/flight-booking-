<?php

require_once '../../classes/model/Flight.php';
require_once '../../includes/db_connection.php';
require_once '../../includes/authentication.php';

class FlightRepo extends db_connection
{
    // Add a new flight to the database
    public function addFlight(Flight $flight)
{
    try {
        parent::connect(); // Connect to the database

        $sql = "INSERT INTO flights (company_id, name, itinerary, passengers_limit, fees, start_time, end_time) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare(parent::get_connect(), $sql);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "issidss", $flight->getCompanyId(), $flight->getName(), $flight->getItinerary(), $flight->getPassengersLimit(), $flight->getFees(), $flight->getStartTime(), $flight->getEndTime());

            // Execute the statement
            mysqli_stmt_execute($stmt);

            // Retrieve the last inserted ID
            $lastInsertedId = mysqli_insert_id(parent::get_connect());

            // Set the ID in the Flight object
            $flight->setId($lastInsertedId);
        } else {
            throw new Exception("Failed to prepare the statement.");
        }
    } catch (Exception $e) {
        // Handle exceptions (e.g., log the error, display a user-friendly message)
        echo "Error: " . $e->getMessage();
    } finally {
        parent::disconnect(); // Disconnect from the database in all cases
    }
}

    // Get details of a specific flight by its ID
    public function getFlightById($flightId)
    {
        try {
            parent::connect(); // Connect to the database

            $sql = "SELECT * FROM flights WHERE id = ?";
            $stmt = mysqli_prepare(parent::get_connect(), $sql);

            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "i", $flightId);

                // Execute the statement
                mysqli_stmt_execute($stmt);

                // Fetch results
                $result = parent::fetchStatement($stmt);

                if ($result) {
                    return $this->mapFlight($result);
                }
            } else {
                throw new Exception("Failed to prepare the statement.");
            }

            return null;
        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, display a user-friendly message)
            echo "Error: " . $e->getMessage();
            return null;
        } finally {
            parent::disconnect(); // Disconnect from the database in all cases
        }
    }

    // Get a list of all flights
    public function getAllFlights()
    {
        try {
            parent::connect(); // Connect to the database

            $sql = "SELECT * FROM flights";
            $stmt = mysqli_prepare(parent::get_connect(), $sql);

            if ($stmt) {
                // Execute the statement
                mysqli_stmt_execute($stmt);

                // Fetch results
                $results = parent::fetchAllStatement($stmt);

                $flights = [];

                foreach ($results as $result) {
                    $flights[] = $this->mapFlight($result);
                }

                return $flights;
            } else {
                throw new Exception("Failed to prepare the statement.");
            }
        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, display a user-friendly message)
            echo "Error: " . $e->getMessage();
            return [];
        } finally {
            parent::disconnect(); // Disconnect from the database in all cases
        }
    }

    // Update flight details
    public function updateFlight(Flight $flight)
    {
        try {
            parent::connect(); // Connect to the database

            $sql = "UPDATE flights 
                      SET company_id = ?, name = ?, itinerary = ?, passengers_limit = ?, fees = ?, start_time = ?, end_time = ?, completed = ?
                      WHERE id = ?";
            $stmt = mysqli_prepare(parent::get_connect(), $sql);

            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "issssdssi", $flight->getCompanyId(), $flight->getName(), $flight->getItinerary(), $flight->getPassengersLimit(), $flight->getFees(), $flight->getStartTime(), $flight->getEndTime(), $flight->isCompleted(), $flight->getId());

                // Execute the statement
                mysqli_stmt_execute($stmt);
            } else {
                throw new Exception("Failed to prepare the statement.");
            }
        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, display a user-friendly message)
            echo "Error: " . $e->getMessage();
        } finally {
            parent::disconnect(); // Disconnect from the database in all cases
        }
    }

    // Delete a flight by its ID
    public function deleteFlight($flightId)
    {
        try {
            parent::connect(); // Connect to the database

            $sql= "DELETE FROM flights WHERE id = ?";

            $stmt = mysqli_prepare(parent::get_connect(), $sql);

            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "i", $flightId);

                // Execute the statement
                mysqli_stmt_execute($stmt);

            } else {
                throw new Exception("Failed to prepare the statement.");
            }
        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, display a user-friendly message)
            echo "Error: " . $e->getMessage();
        } finally {
            parent::disconnect(); // Disconnect from the database in all cases
        }
    }

    // Helper function to map database result to Flight object
    private function mapFlight($result)
    {
        return new Flight(
            $result['company_id'],
            $result['name'],
            $result['itinerary'],
            $result['passengers_limit'],
            $result['fees'],
            $result['start_time'],
            $result['end_time'],
            $result['completed']
        );
    }
}

?>

