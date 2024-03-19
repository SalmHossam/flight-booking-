<?php

require_once '../classes/model/User.php';
require_once '../includes/db_connection.php';
require_once '../includes/authentication.php';

class UserRepo extends db_connection {

    public function register(User $user) {
        try {
            // Validate user type
            if (!in_array($user->getUserType(), ['company', 'passenger'])) {
                throw new Exception("Invalid user type.");
            }

            // Check if the user is already registered
            $auth = new authentication();
            if ($auth->is_user_registered($user->getUsername(), $user->getEmail(), $user->getTel())) {
                throw new Exception("User with the same username, email, or tel already exists.");
            }

            parent::connect();  // Connect to the database

            // Hash the password
            $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);

            // Insert user data into the 'users' table
            $sql = "INSERT INTO users (name, username, email, password, tel, user_type) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare(parent::get_connect(), $sql);

            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "ssssss", $user->getName(), $user->getUsername(), $user->getEmail(), $hashedPassword, $user->getTel(), $user->getUserType());

                // Execute the statement
                mysqli_stmt_execute($stmt);

                // Get the last inserted ID
                $lastInsertId = mysqli_insert_id(parent::get_connect());

                // Insert additional data based on user type
                if ($user->getUserType() === 'company') {
                    $sql = "INSERT INTO company (id) VALUES (?)";
                } elseif ($user->getUserType() === 'passenger') {
                    $sql = "INSERT INTO passenger (id) VALUES (?)";
                }

                // Check if the query was successful
                if (isset($sql)) {
                    $stmt = mysqli_prepare(parent::get_connect(), $sql);
                    if ($stmt) {
                        // Bind parameters
                        mysqli_stmt_bind_param($stmt, "i", $lastInsertId);

                        // Execute the statement
                        mysqli_stmt_execute($stmt);
                    }
                }

                // Registration succeeded
                echo "Registration successful.";
                return $lastInsertId;
            } else {
                throw new Exception("Failed to insert user data.");
            }
        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, display a user-friendly message)
            echo "Registration failed: " . $e->getMessage();
            // Registration failed
            return false;
        } finally {
            parent::disconnect();  // Disconnect from the database in all cases
        }
    }

    public function login(User $user) {
        try {
            parent::connect(); // Connect to the database

            // Fetch user data based on the provided email
            $sql = "SELECT id, user_type, password FROM users WHERE email = ?";
            $stmt = mysqli_prepare(parent::get_connect(), $sql);

            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "s", $user->getEmail());

                // Execute the statement
                mysqli_stmt_execute($stmt);

                // Fetch results
                mysqli_stmt_bind_result($stmt, $userId, $userType, $hashedPassword);

                if (mysqli_stmt_fetch($stmt)) {
                    // Verify the password
                    if (password_verify($user->getPassword(), $hashedPassword)) {
                            // Password is correct, set up the user session or other authentication logic
                        // For now, let's just return an array with user ID and user type
                        return ['user_id' => $userId, 'user_type' => $userType];
                    } else {
                        throw new Exception("Incorrect password.");
                    }
                } else {
                    throw new Exception("User not found.");
                }
            } else {
                throw new Exception("Failed to fetch user data.");
            }
        } catch (Exception $e) {
            echo "Login failed: " . $e->getMessage();
            return false;
        } finally {
            parent::disconnect();
        }
    }

}

?>
