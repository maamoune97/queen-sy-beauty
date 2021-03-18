<?php

namespace App\Entity;

interface CustomerInterface
{
    /**
     * Get the value of lName
     */ 
    public function getLName(): ?string;

    /**
     * Set the value of lName
     *
     * @return  self
     */ 
    public function setLName(String $lName);

    /**
     * Get the value of fName
     */ 
    public function getFName(): ?string;

    /**
     * Set the value of fName
     *
     * @return  self
     */ 
    public function setFName(String $fName);

    /**
     * Get the value of email
     */ 
    public function getEmail(): ?string;

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail(String $email);

    /**
     * Get the value of phoneNumber
     */ 
    public function getPhoneNumber(): ?string;

    /**
     * Set the value of phoneNumber
     *
     * @return  self
     */ 
    public function setPhoneNumber(String $phoneNumber);
}
