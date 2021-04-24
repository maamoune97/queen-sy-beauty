<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SubCategoryRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * @ORM\Entity(repositoryClass=SubCategoryRepository::class)
 * @HasLifecycleCallbacks
 */
class SubCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="subCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="subCategory", orphanRemoval=true)
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity=HomePageCollectionPreview::class, inversedBy="subCategories")
     */
    private $homePageCollectionPreview;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }


    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeSlug()
    {
        $slug = (new AsciiSlugger())->slug($this->getName());

        if (!$this->getSlug() || $this->getSlug() !== $slug)
        {
            $this->setSlug($slug);
        }
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setSubCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getSubCategory() === $this) {
                $product->setSubCategory(null);
            }
        }

        return $this;
    }

    public function getHomePageCollectionPreview(): ?HomePageCollectionPreview
    {
        return $this->homePageCollectionPreview;
    }

    public function setHomePageCollectionPreview(?HomePageCollectionPreview $homePageCollectionPreview): self
    {
        $this->homePageCollectionPreview = $homePageCollectionPreview;

        return $this;
    }
}
