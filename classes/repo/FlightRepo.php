<?php

require_once '../../classes/model/Flight.php';
require_once '../../includes/db_connection.php';
require_once '../../includes/authentication.php';

class FlightRepo extends db_connection {

    public function addFlight(Flight $flight) {
        try {
            parent::connect();  // Connect to the database

            // Create and execute the query to add a new flight
            $sql = "INSERT INTO flights (company_id, name, itinerary, passengers_limit, fees, start_time, end_time, completed) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare(parent::get_connect(), $sql);

            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param(
                    $stmt,
                    "isssdsdi",
                    $flight->getCompanyId(),
                    $flight->getName(),
                    $flight->getItinerary(),
                    $flight->getPassengersLimit(),
                    $flight->getFees(),
                    $flight->getStartTime(),
                    $flight->getEndTime(),
                    $flight->isCompleted()
                );

                // Execute the statement
                mysqli_stmt_execute($stmt);

                // Get the last inserted ID
                $lastInsertId = mysqli_insert_id(parent::get_connect());

                // Set the ID of the Flight object
                $flight->setId($lastInsertId);

                return $flight;
            } else {
                throw new Exception("Failed to add flight.");
            }
        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, display a user-friendly message)
            echo "Add Flight failed: " . $e->getMessage();
            return false;
        } finally {
            parent::disconnect();  // Disconnect from the database in all cases
        }
    }

    public function getFlightById($flightId) {
        try {
            parent::connect();  // Connect to the database

            // Create and execute the query to get a flight by ID
            $sql = "SELECT * FROM flights WHERE id = ?";
            $stmt = mysqli_prepare(parent::get_connect(), $sql);

            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "i", $flightId);

                // Execute the statement
                mysqli_stmt_execute($stmt);

                // Get the result
                $result = mysqli_stmt_get_result($stmt);

                // Map the result to a Flight object
                if ($flight = $this->mapFlight(mysqli_fetch_assoc($result))) {
                    return $flight;
                } else {
                    throw new Exception("Flight not found.");
                }
            } else {
                throw new Exception("Failed to get flight by ID.");
            }
        } catch (Exception $e) {
            // Handle exceptions
            echo "Get Flight by ID failed: " . $e->getMessage();
            return false;
        } finally {
            parent::disconnect();
        }
    }
    
    public function searchFlights($from, $to) {
    try {
        parent::connect();  // Connect to the database

        // Create and execute the query to search for flights
        $sql = "SELECT * FROM flights WHERE itinerary LIKE ? AND itinerary LIKE ?";
        $stmt = mysqli_prepare(parent::get_connect(), $sql);

        if ($stmt) {
            $from = $from . ' -%'; // Match from the beginning
            $to = '%- ' . $to;     // Match at the end

            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ss", $from, $to);

            // Execute the statement
            mysqli_stmt_execute($stmt);

            // Get the result
            $result = mysqli_stmt_get_result($stmt);

            // Map the results to an array of Flight objects
            $flights = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $flight = $this->mapFlight($row);
                if ($flight) {
                    $flights[] = $flight;
                }
            }

            return $flights;
        } else {
            throw new Exception("Failed to search for flights.");
        }
    } catch (Exception $e) {
        // Handle exceptions
        echo "Flight search failed: " . $e->getMessage();
        return [];
    } finally {
        parent::disconnect();
    }
}




    public function getAllFlights() {
        try {
            parent::connect();  // Connect to the database

            // Create and execute the query to get all flights
            $sql = "SELECT * FROM flights";
            $result = mysqli_query(parent::get_connect(), $sql);

            // Map the results to an array of Flight objects
            $flights = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $flight = $this->mapFlight($row);
                if ($flight) {
                    $flights[] = $flight;
                }
            }

            return $flights;
        } catch (Exception $e) {
            // Handle exceptions
            echo "Get All Flights failed: " . $e->getMessage();
            return false;
        } finally {
            parent::disconnect();
        }
    }
    
    public function getAllFlightsByCompanyId($company_id) {
        try {
            parent::connect();  // Connect to the database

            // Create and execute the query to get flights for a specific company_id
            $sql = "SELECT * FROM flights WHERE company_id = ?";
            $stmt = mysqli_prepare(parent::get_connect(), $sql);
        
            // Bind the parameter
            mysqli_stmt_bind_param($stmt, "i", $company_id);
        
            // Execute the query
            mysqli_stmt_execute($stmt);
        
            // Get the results
            $result = mysqli_stmt_get_result($stmt);

            // Map the results to an array of Flight objects
            $flights = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $flight = $this->mapFlight($row);
                if ($flight) {
                    $flights[] = $flight;
                }
            }

            return $flights;
        } catch (Exception $e) {
            // Handle exceptions
            echo "Get Flights by Company ID failed: " . $e->getMessage();
            return false;
        } finally {
            parent::disconnect();
        }
    }

    public function updateFlight(Flight $flight) {
        try {
            parent::connect();  // Connect to the database

            // Create and execute the query to update a flight
            $sql = "UPDATE flights 
                    SET company_id=?, name=?, itinerary=?, passengers_limit=?, fees=?, start_time=?, end_time=?, completed=? 
                    WHERE id=?";
            $stmt = mysqli_prepare(parent::get_connect(), $sql);

            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param(
                    $stmt,
                    "isssdsdii",
                    $flight->getCompanyId(),
                    $flight->getName(),
                    $flight->getItinerary(),
                    $flight->getPassengersLimit(),
                    $flight->getFees(),
                    $flight->getStartTime(),
                    $flight->getEndTime(),
                    $flight->isCompleted(),
                    $flight->getId()
                );

                // Execute the statement
                mysqli_stmt_execute($stmt);

                return $flight;
            } else {
                throw new Exception("Failed to update flight.");
            }
        } catch (Exception $e) {
            // Handle exceptions
            echo "Update Flight failed: " . $e->getMessage();
            return false;
        } finally {
            parent::disconnect();
        }
    }

    public function deleteFlight($flightId) {
        try {
            parent::connect();  // Connect to the database

            // Create and execute the query to delete a flight
            $sql = "DELETE FROM flights WHERE id = ?";
            $stmt = mysqli_prepare(parent::get_connect(), $sql);

            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "i", $flightId);

                // Execute the statement
                mysqli_stmt_execute($stmt);

                return true;
            } else {
                throw new Exception("Failed to delete flight.");
            }
        } catch (Exception $e) {
            // Handle exceptions
            echo "Delete Flight failed: " . $e->getMessage();
            return false;
        } finally {
            parent::disconnect();
        }
    }

    // Helper function to map database result to Flight object
    private function mapFlight($row) {
        if ($row) {
            $flight = new Flight(
                $row['company_id'],
                $row['name'],
                $row['itinerary'],
                $row['passengers_limit'],
                $row['fees'],
                $row['start_time'],
                $row['end_time'],
                $row['completed']
            );

            // Set the ID
            $flight->setId($row['id']);

            // Set additional properties if needed
            $flight->setPassengersRegistered($row['passengers_registered']);
            $flight->setPassengersPending($row['passengers_pending']);

            return $flight;
        } else {
            return null;
        }
    }
}

?>


