<?php

class db_connection {
    
    private $server = "localhost";
    private $username = "root";
    private $password = "Salma@2001";
    private $db = "flight_booking_db";
    private $connect;

    public function connect() {
        try {
            $this->connect = mysqli_connect($this->server, $this->username, $this->password, $this->db);

            if (!$this->connect) {
                throw new Exception(mysqli_connect_error());
            }
        } catch (Exception $e) {
            // Log the error or handle it appropriately (e.g., show a user-friendly message)
            die("Connection error: " . $e->getMessage());
        }
    }

    public function disconnect() {
        try {
            if (isset($this->connect)) {
                if (!mysqli_close($this->connect)) {
                    throw new Exception(mysqli_error($this->connect));
                }
            }
        } catch (Exception $e) {
            // Log the error or handle it appropriately (e.g., show a user-friendly message)
            die("Disconnection error: " . $e->getMessage());
        }
    }

    public function get_connect() {
        return $this->connect;
    }
    
    public function fetchStatement($stmt)
    {
        try {
            $result = mysqli_stmt_get_result($stmt);

            if (!$result) {
                throw new Exception(mysqli_error($this->connect));
            }

            return mysqli_fetch_assoc($result);
        } catch (Exception $e) {
            // Log the error or handle it appropriately (e.g., show a user-friendly message)
            die("Fetch statement error: " . $e->getMessage());
        }
    }

    public function fetchAllStatement($stmt)
    {
        try {
            $result = mysqli_stmt_get_result($stmt);

            if (!$result) {
                throw new Exception(mysqli_error($this->connect));
            }

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } catch (Exception $e) {
            // Log the error or handle it appropriately (e.g., show a user-friendly message)
            die("Fetch all statement error: " . $e->getMessage());
        }
    }

}

?>