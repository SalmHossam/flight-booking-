<?php

require_once 'User.php';  

class Company extends User
{
    private $bio;
    private $address;
    private $location;
    private $logoImg;
    
    public function __construct($name, $username, $email, $password, $tel, $bio, $address, $location, $logoImg) {
        parent::__construct($name, $username, $email, $password, $tel, 'company');  // Call the parent constructor
        $this->bio = $bio;
        $this->address = $address;
        $this->location = $location;
        $this->logoImg = $logoImg;
    }

    // Setters
    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function setLogoImg($logoImg)
    {
        $this->logoImg = $logoImg;
    }

    // Getters
    public function getBio() {
        return $this->bio;
    }
    
    public function getAddress() {
        return $this->address;
    }
    public function getLocation() {
        return $this->location;
    }
    
    public function getLogoImg() {
        return $this->logoImg;
    }
}

?>