<?php

require_once '../../classes/model/Company.php';
require_once '../../includes/db_connection.php';
require_once '../../includes/authentication.php';

class CompanyRepo extends db_connection {
    
    public function getCompanyProfile($companyId) {
        try {
            parent::connect();  // Connect to the database

            // Fetch company data
            $sql = "SELECT users.id, users.name, users.username, users.email, users.tel, company.bio, company.address , company.location , company.logo_img
                    FROM users
                    INNER JOIN company ON users.id = company.id
                    WHERE users.id = ?";
            $stmt = mysqli_prepare(parent::get_connect(), $sql);

            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "i", $companyId);

                // Execute the statement
                mysqli_stmt_execute($stmt);

                // Fetch results
                mysqli_stmt_bind_result($stmt, $userId, $name, $username, $email, $tel, $bio, $address , $location , $logoImg);

                if (mysqli_stmt_fetch($stmt)) {
                    // Create a Company object and return
                    $company = new Company($name, $username, $email, '', $tel, $bio, $address , $location , $logoImg);
                    $company->setId($userId); // Set the ID

                    return $company;
                } else {
                    throw new Exception("Company not found.");
                }
            } else {
                throw new Exception("Failed to fetch company data.");
            }
        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, display a user-friendly message)
            echo "Error: " . $e->getMessage();
            return null;
        } finally {
            parent::disconnect();  // Disconnect from the database in all cases
        }
    }

    public function updateCompanyProfile(Company $company) {
        try {
            parent::connect();  // Connect to the database

            // Update company data
            $userSql = "UPDATE users
                        SET name = ?, username = ?, email = ?, tel = ?
                        WHERE id = ?";
            $userStmt = mysqli_prepare(parent::get_connect(), $userSql);

            if ($userStmt) {
                // Bind parameters
                mysqli_stmt_bind_param($userStmt, "ssssi", $company->getName(), $company->getUsername(), $company->getEmail(), $company->getTel(), $company->getId());

                // Execute the statement
                mysqli_stmt_execute($userStmt);

                // Update additional company data
                $companySql = "UPDATE company
                               SET bio = ?, address = ?, location = ?, logo_img = ?
                               WHERE id = ?";
                $companyStmt = mysqli_prepare(parent::get_connect(), $companySql);

                if ($companyStmt) {
                    // Bind parameters
                    mysqli_stmt_bind_param($companyStmt, "ssssi", $company->getBio(), $company->getAddress(), $company->getLocation(), $company->getLogoImg(), $company->getId());

                    // Execute the statement
                    mysqli_stmt_execute($companyStmt);

                    echo "Company profile updated successfully.";
                } else {
                    throw new Exception("Failed to update company data.");
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

}

?>