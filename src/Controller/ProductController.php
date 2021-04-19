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
        // redirect to best url if necessary
        if ($product->getSlug() !== $slug)
        {
            return $this->redirectToRoute('product_show', [
                'slug' => $product->getSlug(), 
                'id' => $product->getId()
            ], 301);
        }
        
        // find similar products
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
        // end find similar products

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'sameProducts' => $sameProducts,
        ]);
    }
}
