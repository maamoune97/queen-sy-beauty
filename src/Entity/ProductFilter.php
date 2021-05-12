<?php

namespace App\Entity;


class ProductFilter
{
    /**
     * @var array
     */
    private $sizes = [];

    /**
     *
     * @var int
     */
    private $minPrice;

    /**
     * @var int
     */
    private $maxPrice;

    /**
     * @var array
     */
    private $colors = [];

    /**
     * @return array|null
     */
    public function getSizes(): ?array
    {
        return $this->sizes;
    }

    /**
     * @param array $sizes
     * @return self
     */
    public function setSizes(array $sizes): self
    {
        $this->sizes = $sizes;

        return $this;
    }

    /**
     * @return integer|null
     */
    public function getMinPrice(): ?int
    {
        return $this->minPrice;
    }

    /**
     * @param integer $minPrice
     * @return self
     */
    public function setMinPrice(int $minPrice): self
    {
        $this->minPrice = $minPrice;

        return $this;
    }

    /**
     * @return integer|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param integer $maxPrice
     * @return self
     */
    public function setMaxPrice(int $maxPrice): self
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getColors(): ?array
    {
        return $this->colors;
    }

    /**
     * @param array $colors
     * @return self
     */
    public function setColors(array $colors): self
    {
        $this->colors = $colors;

        return $this;
    }
}
