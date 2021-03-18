<?php

namespace App\Entity;

use App\Repository\UnregisteredCustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UnregisteredCustomerRepository::class)
 */
class UnregisteredCustomer implements CustomerInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $fName;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, mappedBy="unregisteredCustomer", cascade={"persist", "remove"})
     */
    private $command;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLName(): ?string
    {
        return $this->lName;
    }

    public function setLName(string $lName): self
    {
        $this->lName = $lName;

        return $this;
    }

    public function getFName(): ?string
    {
        return $this->fName;
    }

    public function setFName(string $fName): self
    {
        $this->fName = $fName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCommand(): ?Order
    {
        return $this->command;
    }

    public function setCommand(?Order $command): self
    {
        // unset the owning side of the relation if necessary
        if ($command === null && $this->command !== null) {
            $this->command->setUnregisteredCustomer(null);
        }

        // set the owning side of the relation if necessary
        if ($command !== null && $command->getUnregisteredCustomer() !== $this) {
            $command->setUnregisteredCustomer($this);
        }

        $this->command = $command;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fName.' '.$this->lName;
    }
}
