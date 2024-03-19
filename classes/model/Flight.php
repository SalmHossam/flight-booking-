<?php

class Flight
{
    private $id;
    private $companyId;
    private $name;
    private $itinerary;
    private $passengersLimit;
    private $passengersRegistered;
    private $passengersPending;
    private $fees;
    private $startTime;
    private $endTime;
    private $completed;

    public function __construct($companyId, $name, $itinerary, $passengersLimit, $fees, $startTime, $endTime, $completed = false) {
        $this->companyId = $companyId;
        $this->name = $name;
        $this->itinerary = $itinerary;
        $this->passengersLimit = $passengersLimit;
        $this->fees = $fees;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->completed = $completed;
    }
    
    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setItinerary($itinerary)
    {
        $this->itinerary = $itinerary;
    }

    public function setPassengersLimit($passengersLimit)
    {
        $this->passengersLimit = $passengersLimit;
    }
    
    public function setPassengersRegistered($passengersRegistered)
    {
        $this->passengersRegistered = $passengersRegistered;
    }

    public function setPassengersPending($passengersPending)
    {
        $this->passengersPending = $passengersPending;
    }

    public function setFees($fees)
    {
        $this->fees = $fees;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    public function isCompleted()
    {
        return $this->completed;
    }

    public function setCompleted($completed)
    {
        $this->completed = $completed;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getCompanyId()
    {
        return $this->companyId;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function getItinerary()
    {
        return $this->itinerary;
    }
    
    public function getPassengersLimit()
    {
        return $this->passengersLimit;
    }
    
    public function getPassengersRegistered()
    {
        return $this->passengersRegistered;
    }

    public function getPassengersPending()
    {
        return $this->passengersPending;
    }
    
    public function getFees()
    {
        return $this->fees;
    }
    
    public function getStartTime()
    {
        return $this->startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }   
}

?>
