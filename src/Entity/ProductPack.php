<?php

namespace App\Entity;

use App\Repository\ProductPackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductPackRepository::class)
 */
class ProductPack
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="productPacks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="productPacks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $command;

    /**
     * @ORM\ManyToMany(targetEntity=ProductOptionField::class, inversedBy="productPacks")
     */
    private $optionFields;

    public function __construct()
    {
        $this->optionFields = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCommand(): ?Order
    {
        return $this->command;
    }

    public function setCommand(?Order $command): self
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return Collection|ProductOptionFIeld[]
     */
    public function getOptionFields(): Collection
    {
        return $this->optionFields;
    }

    public function addOptionField(ProductOptionFIeld $optionField): self
    {
        if (!$this->optionFields->contains($optionField)) {
            $this->optionFields[] = $optionField;
        }

        return $this;
    }

    public function removeOptionField(ProductOptionFIeld $optionField): self
    {
        $this->optionFields->removeElement($optionField);

        return $this;
    }
}
