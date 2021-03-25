<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 * @ORM\HasLifecycleCallbacks()
 */
class Order
{
    const STATUS = [
        0 => 'en attente',
        1 => 'Paiment confirmé',
        2 => 'Delivrée'
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     */
    private $registeredCustomer;

    /**
     * @ORM\OneToOne(targetEntity=UnregisteredCustomer::class, inversedBy="command", cascade={"persist", "remove"})
     */
    private $unregisteredCustomer;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=ProductPack::class, mappedBy="command", orphanRemoval=true)
     */
    private $productPacks;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deliveryAddress;

    public function __construct()
    {
        $this->productPacks = new ArrayCollection();
    }

    
    /**
     * Permet d'initialiser la date de la commande
     *
     * @ORM\PrePersist
     * 
     * @return void
     */
    public function initializeCreatedAt()
    {
        if(empty($this->getCreatedAt()))
        {
            $this->setCreatedAt(new DateTime());
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegisteredCustomer(): ?User
    {
        return $this->registeredCustomer;
    }

    public function setRegisteredCustomer(?User $registeredCustomer): self
    {
        $this->registeredCustomer = $registeredCustomer;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUnregisteredCustomer(): ?UnregisteredCustomer
    {
        return $this->unregisteredCustomer;
    }

    public function setUnregisteredCustomer(?UnregisteredCustomer $unregisteredCustomer): self
    {
        $this->unregisteredCustomer = $unregisteredCustomer;

        return $this;
    }

    public function getStatusText(): ?string
    {
        return self::STATUS[$this->status];
    }

    /**
     *
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface 
    {
        return $this->registeredCustomer ? $this->registeredCustomer : $this->unregisteredCustomer;
    }

    /**
     *
     * @param CustomerInterface $customer
     * @return self
     */
    public function setCustomer(CustomerInterface $customer): self
    {
        if ($customer instanceof User)
        {
            $this->setRegisteredCustomer($customer);
        }
        elseif($customer instanceof UnregisteredCustomer)
        {
            $this->setUnregisteredCustomer($customer);
        }
        return $this;
    }

    /**
     * @return Collection|ProductPack[]
     */
    public function getProductPacks(): Collection
    {
        return $this->productPacks;
    }

    public function addProductPack(ProductPack $productPack): self
    {
        if (!$this->productPacks->contains($productPack)) {
            $this->productPacks[] = $productPack;
            $productPack->setCommand($this);
        }

        return $this;
    }

    public function removeProductPack(ProductPack $productPack): self
    {
        if ($this->productPacks->removeElement($productPack)) {
            // set the owning side to null (unless already changed)
            if ($productPack->getCommand() === $this) {
                $productPack->setCommand(null);
            }
        }

        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?string $deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }
}
