<?php
namespace App\Service;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GlobalRenderService
{
    private $categoryRepository;
    private $session;

    public function __construct(CategoryRepository $categoryRepository, SessionInterface $session)
    {
        $this->categoryRepository = $categoryRepository;
        $this->session = $session;
    }

    public function findAllCategories()
    {
        return $this->categoryRepository->findAll();
    }

    public function getCartProductCount()
    {
        $cart = $this->session->get('cart', []);
        $count = 0;
        foreach ($cart as $productId => $quantity) {
            $count += $quantity;
        }
        return $count;
    }
}
