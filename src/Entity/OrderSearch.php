<?php

namespace App\Entity;

class OrderSearch
{
    /**
     *
     * @var int|null
     */
    private $waitingStatus;

    /**
     *
     * @var int|null
     */
    private $paidStatus;

    /**
     *
     * @var int|null
     */
    private $receivedStatus;

    /**
     *
     * @var int|null
     */
    private $allStatus;

    /**
     *
     * @var int|null
     */
    private $sort;

    /**
     *
     * @var string|null
     */
    private $client;

    /**
     *
     * @var date|null
     */
    private $dateMin;

    /**
     *
     * @var date|null
     */
    private $dateMax;

    

    /**
     * Get the value of waitingStatus
     *
     * @return  int|null
     */ 
    public function getWaitingStatus()
    {
        return $this->waitingStatus;
    }

    /**
     * Set the value of waitingStatus
     *
     * @param  int|null  $waitingStatus
     *
     * @return  self
     */ 
    public function setWaitingStatus($waitingStatus)
    {
        $this->waitingStatus = $waitingStatus;

        return $this;
    }

    /**
     * Get the value of paidStatus
     *
     * @return  int|null
     */ 
    public function getPaidStatus()
    {
        return $this->paidStatus;
    }

    /**
     * Set the value of paidStatus
     *
     * @param  int|null  $paidStatus
     *
     * @return  self
     */ 
    public function setPaidStatus($paidStatus)
    {
        $this->paidStatus = $paidStatus;

        return $this;
    }

    /**
     * Get the value of receivedStatus
     *
     * @return  int|null
     */ 
    public function getReceivedStatus()
    {
        return $this->receivedStatus;
    }

    /**
     * Set the value of receivedStatus
     *
     * @param  int|null  $receivedStatus
     *
     * @return  self
     */ 
    public function setReceivedStatus($receivedStatus)
    {
        $this->receivedStatus = $receivedStatus;

        return $this;
    }

    /**
     * Get the value of allStatus
     *
     * @return  int|null
     */ 
    public function getAllStatus()
    {
        return $this->allStatus;
    }

    /**
     * Set the value of allStatus
     *
     * @param  int|null  $allStatus
     *
     * @return  self
     */ 
    public function setAllStatus($allStatus)
    {
        $this->allStatus = $allStatus;

        return $this;
    }

    /**
     * Get the value of sort
     *
     * @return  int|null
     */ 
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set the value of sort
     *
     * @param  int|null  $sort
     *
     * @return  self
     */ 
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get the value of client
     *
     * @return  string|null
     */ 
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set the value of client
     *
     * @param  string|null  $client
     *
     * @return  self
     */ 
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get the value of dateMin
     *
     * @return  date|null
     */ 
    public function getDateMin()
    {
        return $this->dateMin;
    }

    /**
     * Set the value of dateMin
     *
     * @param  date|null  $dateMin
     *
     * @return  self
     */ 
    public function setDateMin($dateMin)
    {
        $this->dateMin = $dateMin;

        return $this;
    }

    /**
     * Get the value of dateMax
     *
     * @return  date|null
     */ 
    public function getDateMax()
    {
        return $this->dateMax;
    }

    /**
     * Set the value of dateMax
     *
     * @param  date|null  $dateMax
     *
     * @return  self
     */ 
    public function setDateMax($dateMax)
    {
        $this->dateMax = $dateMax;

        return $this;
    }
}
