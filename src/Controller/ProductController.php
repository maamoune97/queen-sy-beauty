<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @Route("/show/{slug}/{id}", name="product_show")
     */
    public function show(Product $product, $slug): Response
    {
        if ($product->getSlug() !== $slug)
        {
            return $this->redirectToRoute('product_show', [
                'slug' => $product->getSlug(), 
                'id' => $product->getId()
            ], 301);
        }
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
