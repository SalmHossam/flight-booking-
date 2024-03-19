<?php

class User {
    private $id;
    private $name;
    private $username;
    private $email;
    private $password;
    private $tel;
    private $accountBalance;
    private $userType;

    public function __construct($name, $username, $email, $password, $tel, $userType) {
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->tel = $tel;
        $this->userType = $userType;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setName($name) {
        $this->name = $name;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setTel($tel) {
        $this->tel = $tel;
    }
    
    public function setAccountBalance($accountBalance) {
        $this->accountBalance = $accountBalance;
    }

    public function setUserType($userType) {
        $this->userType = $userType;
    }
    
    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getTel() {
        return $this->tel;
    }
    
    public function getUserType() {
        return $this->userType;
    }

    public function getAccountBalance() {
        return $this->accountBalance;
    }

}

?>
