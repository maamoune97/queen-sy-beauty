<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/show/{slug}/{id}", name="product_show")
     */
    public function show(Product $product, $slug, ProductRepository $productRepository): Response
    {
        if ($product->getSlug() !== $slug)
        {
            return $this->redirectToRoute('product_show', [
                'slug' => $product->getSlug(), 
                'id' => $product->getId()
            ], 301);
        }

        $sameProducts = $productRepository->findBySubCategory($product->getSubCategory());

        foreach ($sameProducts as $key => $sameProduct)
        {
            if ($sameProduct->getId() === $product->getId())
            {
                unset($sameProducts[$key]);
                break;
            }
        }
        shuffle($sameProducts);
        $sameProducts = array_slice($sameProducts,0,4);
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'sameProducts' => $sameProducts,
        ]);
    }
}
