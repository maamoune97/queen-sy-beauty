<?php

namespace App\Entity;

use App\Repository\ProductOptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductOptionRepository::class)
 */
class ProductOption
{
    const FRENCHTYPE = [
        'required' => 'obligatoire',
        'optional' => 'Facultative'
    ];
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=ProductOptionField::class, mappedBy="productOption")
     */
    private $productOptionFields;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="options")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    public function __construct()
    {
        $this->productOptionFields = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|ProductOptionField[]
     */
    public function getProductOptionFields(): Collection
    {
        return $this->productOptionFields;
    }

    public function addProductOptionField(ProductOptionField $productOptionField): self
    {
        if (!$this->productOptionFields->contains($productOptionField)) {
            $this->productOptionFields[] = $productOptionField;
            $productOptionField->setProductOption($this);
        }

        return $this;
    }

    public function removeProductOptionField(ProductOptionField $productOptionField): self
    {
        if ($this->productOptionFields->removeElement($productOptionField)) {
            // set the owning side to null (unless already changed)
            if ($productOptionField->getProductOption() === $this) {
                $productOptionField->setProductOption(null);
            }
        }

        return $this;
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

    public function getFrenchType(): string
    {
        return self::FRENCHTYPE[$this->gettype()];
    }
}
