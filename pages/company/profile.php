<?php

require_once '../../classes/model/Company.php';
require_once '../../classes/repo/CompanyRepo.php';

session_start();
$companyId = $_SESSION['user_id'];

// Create an instance of CompanyRepo
$companyRepo = new CompanyRepo();

// Get Company Profile
$company = $companyRepo->getCompanyProfile($companyId);

if ($company) {
    // Display company profile data
    // echo "Company ID: " . $Company->getId() . "<br>";
    echo "Name: " . $company->getName() . "<br>";
    echo "Username: " . $company->getUsername() . "<br>";
    echo "Email: " . $company->getEmail() . "<br>";
    echo "Phone: " . $company->getTel() . "<br>";
    echo "Bio: " . $company->getBio() . "<br>";
    echo "Address: " . $company->getAddress() . "<br>";
    // Display other profile data as needed
    
    // Update Company Profile
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updatedCompany = new Company(
            $_POST['name'],
            $_POST['username'],
            $_POST['email'],
            '',
            $_POST['tel'],
            $_POST['bio'],
            $_POST['address'],
            $_POST['location'],
            $_POST['logo_img']
        );
        $updatedCompany ->setId($companyId);

        // Update the company profile
        $companyRepo->updateCompanyProfile($updatedCompany);

        // Refresh the page to display updated data
        header("Location: profile.php");
        exit();
    }
    
    // Display a form to update company profile data
    ?>
    <form method="post" action="profile.php">
        Name: <input type="text" name="name" value="<?php echo $company->getName(); ?>"><br>
        Username: <input type="text" name="username" value="<?php echo $company->getUsername(); ?>"><br>
        Email: <input type="text" name="email" value="<?php echo $company->getEmail(); ?>"><br>
        Phone: <input type="text" name="tel" value="<?php echo $company->getTel(); ?>"><br>
        Bio: <input type="text" name="bio" value="<?php echo $company->getBio(); ?>"><br>
        Address: <input type="text" name="address" value="<?php echo $company->getAddress(); ?>"><br>
        Location: <input type="text" name="location" value="<?php echo $company->getLocation(); ?>"><br>
        Logo: <input type="text" name="logo_img" value="<?php echo $company->getLogoImg(); ?>"><br>
        <input type="submit" value="Update Profile">
    </form>
    <?php
    
} else {
    echo "Company not found.";
}

?>





