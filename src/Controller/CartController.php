<?php

namespace App\Controller;

use App\Repository\ProductOptionFieldRepository;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    /**
     * @Route("/cart", name="cart_show")
     */
    public function show(): Response
    {
        return $this->render('cart/show.html.twig', [
            'cart' => $this->cart->getData(),
            'subtotalPrice' => $this->cart->getSubtotalPrice(),
        ]);
    }

    /**
     * @Route("/cart/add", name="cart_add", methods={"POST"})
     */
    public function add(Request $request, ProductRepository $productRepository, ProductOptionFieldRepository $productOptionFieldRepository): Response
    {
        $productId = $request->get("product") ?? null;
        $quantity = $request->get("quantity") ?? null;
        if ($productId && $quantity)
        {
            try
            {
                $product = $productRepository->find($productId);
                $options = [];
                foreach ($product->getOptions() as $option)
                {
                    if ( $request->get( $option->getName() ) )
                    {
                        $name = $request->get( $option->getName() );

                        $optionField = $productOptionFieldRepository->findOneBy(['name' => $name, 'productOption' => $option->getId()]);
                        if ($optionField)
                        {
                            $options[] = $optionField;
                        }
                        // $options[$option->getName()] = $request->get( $option->getName() );
                    }
                }
                $this->cart->addProduct($productId, $quantity, $options);
            }
            catch (\Throwable $th)
            {
                throw $this->createNotFoundException();
                //insert a flash error message to say it failed
            }
        }
        return $this->redirectToRoute('cart_show');
    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id): Response
    {
        $this->cart->removeProduct($id);

        return $this->redirectToRoute('cart_show');
    }

    /**
     * @Route("/cart/update/{idProduct}/quantity/{number}", name="cart_update_qantity", methods={"POST"})
     */
    public function updateQuantity($idProduct, $number): Response
    {
        $this->cart->updateQuantity($idProduct, $number);

        return $this->redirectToRoute('cart_show');
    }
}
