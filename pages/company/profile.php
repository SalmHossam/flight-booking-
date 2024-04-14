
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path/to/styles.css">
    <link rel="stylesheet" href="../../assets/css/companyProfile.css">
</head>
<body>

<?php

require_once '../../classes/model/Company.php';
require_once '../../classes/repo/CompanyRepo.php';

session_start();
$companyId = htmlspecialchars($_SESSION['user_id']); // Escape session user ID

// Create an instance of CompanyRepo
$companyRepo = new CompanyRepo();

// Get Company Profile
$company = $companyRepo->getCompanyProfile($companyId);

if ($company) {
    // Display company profile data
    echo "Name: " . htmlspecialchars($company->getName()) . "<br>"; // Escape company name
    echo "Username: " . htmlspecialchars($company->getUsername()) . "<br>"; // Escape username
    echo "Email: " . htmlspecialchars($company->getEmail()) . "<br>"; // Escape email
    echo "Phone: " . htmlspecialchars($company->getTel()) . "<br>"; // Escape phone
    echo "Bio: " . htmlspecialchars($company->getBio()) . "<br>"; // Escape bio
    echo "Address: " . htmlspecialchars($company->getAddress()) . "<br>"; // Escape address
    // Display other profile data as needed
    
    // Update Company Profile
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updatedCompany = new Company(
            htmlspecialchars($_POST['name']), // Escape name
            htmlspecialchars($_POST['username']), // Escape username
            htmlspecialchars($_POST['email']), // Escape email
            '',
            htmlspecialchars($_POST['tel']), // Escape phone
            htmlspecialchars($_POST['bio']), // Escape bio
            htmlspecialchars($_POST['address']), // Escape address
            htmlspecialchars($_POST['location']), // Escape location
            htmlspecialchars($_POST['logo_img']) // Escape logo image
        );
        $updatedCompany->setId($companyId);

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


</body>
</html>

