<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/cart", name="cart_show")
     */
    public function show(): Response
    {
        return $this->render('cart/show.html.twig', [
            'products' => $this->cartService->getData(),
            'subtotalPrice' => $this->cartService->getSubtotalPrice(),
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id): Response
    {
        $this->cartService->addProduct($id);

        return $this->redirectToRoute('cart_show');
    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id): Response
    {
        $this->cartService->removeProduct($id);

        return $this->redirectToRoute('cart_show');
    }

    /**
     * @Route("/cart/update/{idProduct}/quantity/{number}", name="cart_update_qantity", methods={"POST"})
     */
    public function updateQuantity($idProduct, $number): Response
    {
        $this->cartService->updateQuantity($idProduct, $number);

        return $this->redirectToRoute('cart_show');
    }
}
