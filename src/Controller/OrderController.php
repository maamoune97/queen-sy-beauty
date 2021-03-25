<?php

namespace App\Controller;

use App\Entity\Order;
use App\Service\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/order/new", name="order_new")
     */
    public function new(CartService $cart): Response
    {

        return $this->render('order/new.html.twig', [
            'products' => $cart->getData(),
            'subtotalPrice' => $cart->getSubtotalPrice(),
        ]);
    }

    /**
     * @Route("/order/finalize", name="order_finalize")
     *
     * @return void
     */
    public function finalize(Request $request, SessionInterface $session) : Response
    {
        $order = new Order();

        return $this->render('order/finalize.html.twig', [

        ]);
    }
}
