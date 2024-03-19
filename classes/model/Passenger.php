<?php

require_once 'User.php';  

class Passenger extends User {
    
    private $passportImg;
    private $photo;

    public function __construct($name, $username, $email, $password, $tel, $passportImg, $photo) {
        parent::__construct($name, $username, $email, $password, $tel, 'passenger');  // Call the parent constructor
        $this->passportImg = $passportImg;
        $this->photo = $photo;
    }

    // Setters
    public function setPassportImg($passportImg) {
        $this->passportImg = $passportImg;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
    }
    
    // Getters
    public function getPassportImg() {
        return $this->passportImg;
    }
    
    public function getPhoto() {
        return $this->photo;
    }
}

?>