<?php
namespace App\Service;

use App\Repository\CategoryRepository;

class GlobalRenderService
{
    private $categoryRepository;
    private $cartService;

    public function __construct(CategoryRepository $categoryRepository, CartService $cartService)
    {
        $this->categoryRepository = $categoryRepository;
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
}
