<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private $pr;
    private $session;

    public function __construct(ProductRepository $pr, SessionInterface $session)
    {
        $this->pr = $pr;
        $this->session = $session;
    }

    /**
     * return data of products in cart
     *
     * @return array
     */
    public function getData() : array
    {
        $products = $this->session->get('cart', []);
        $dataProducts = [];

        foreach ($products as $idProduct => $value) {
            $dataProducts[] = [
                'product' => $this->pr->find($idProduct),
                'quantity' => $value['quantity'],
                'options' => $value['options']
            ];
        }

        return $dataProducts;
    }

    /**
     * return total price of products in cart
     *
     * @return float
     */
    public function getSubtotalPrice() : float
    {
        $subtotalPrice = 0;

        foreach ($this->getData() as $dataProduct) {
            $subtotalPrice += $dataProduct['product']->getPrice() * $dataProduct['quantity'];
        }

        return $subtotalPrice;
    }

    /**
     * add product in cart
     *
     * @param integer $id
     * @param array|null $options
     * @return boolean
     */
    public function addProduct(int $id, int $quantity, ?array $options = []): bool
    {
        $done = false;
        $cart = $this->session->get('cart', []);

        if (empty($cart[$id]))
        {
            $cart[$id] = ['quantity' => $quantity, 'options' => $options];
            $done = true;
        }
        else
        {
            //Max quantity of one product is 9
            if ($cart[$id]['quantity'] < 9)
            {
                $cart[$id]['quantity'] += $quantity;
                $done = true;
            }
        }

        $this->session->set('cart', $cart);

        return $done;
    }

    /**
     * remove product in cart
     *
     * @param integer $id
     * @return boolean
     */
    public function removeProduct(int $id): bool
    {
        $done = false;
        $cart = $this->session->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = 1;
            unset($cart[$id]);
            $done = true;
        }

        $this->session->set('cart', $cart);

        return $done;
    }

    
    /**
     * Update quantity of product in cart
     *
     * @param integer $idProduct
     * @param integer $quantity
     * @return boolean
     */
    public function updateQuantity(int $idProduct, int $quantity): bool
    {
        $done = false;
        $cart = $this->session->get('cart', []);

        if (!empty($cart[$idProduct]))
        {
            $cart[$idProduct]['quantity'] = $quantity;
            $done = true;
        }

        $this->session->set('cart', $cart);

        return $done;
    }


    /**
     * get number of items in shopping-cart
     *
     * @return integer
     */
    public function getProductCount(): int
    {
        $cart = $this->session->get('cart', []);
        $count = 0;
        // dd($cart);
        foreach ($cart as $productId => $value) {
            $count += $value['quantity'];
        }
        return $count;
    }

    /**
     * empty the shopping cart
     *
     * @return void
     */
    public function empty(): void
    {
        $this->session->set('cart', []);
    }

}
