<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductOptionFieldRepository;

/**
 * @ORM\Entity(repositoryClass=ProductOptionFieldRepository::class)
 */
class ProductOptionField
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=ProductOption::class, inversedBy="productOptionFields")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productOption;

    /**
     * @ORM\ManyToMany(targetEntity=ProductPack::class, mappedBy="optionFields")
     */
    private $productPacks;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $value;

    public function __construct()
    {
        $this->productPacks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProductOption(): ?ProductOption
    {
        return $this->productOption;
    }

    public function setProductOption(?ProductOption $productOption): self
    {
        $this->productOption = $productOption;

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
            $productPack->addOptionField($this);
        }

        return $this;
    }

    public function removeProductPack(ProductPack $productPack): self
    {
        if ($this->productPacks->removeElement($productPack)) {
            $productPack->removeOptionField($this);
        }

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
