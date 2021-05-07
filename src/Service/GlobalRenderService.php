<?php
namespace App\Service;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\SubCategoryRepository;

class GlobalRenderService
{
    private $categoryRepository;
    private $subCategoryRepository;
    private $productRepository;
    private $cartService;

    public function __construct(CategoryRepository $categoryRepository, CartService $cartService, SubCategoryRepository $subCategoryRepository, ProductRepository $productRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->subCategoryRepository = $subCategoryRepository;
        $this->productRepository = $productRepository;
        $this->cartService = $cartService;
    }

    public function findAllCategories()
    {
        return $this->categoryRepository->findAll();
    }

    public function getCartProductCount()
    {
        return $this->cartService->getProductCount();
    }

    public function getCartSubTotalPrice()
    {
        return $this->cartService->getSubtotalPrice();
    }

    public function getCartData()
    {
        return $this->cartService->getData();
    }

    public function getCategoryCount(): int
    {
        return $this->categoryRepository->count([]);
    }

    public function getSubCategoryCount(): int
    {
        return $this->subCategoryRepository->count([]);
    }

    public function getProductCount(): int
    {
        return $this->productRepository->count([]);
    }
}
