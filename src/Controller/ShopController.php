<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\SubCategory;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\SubCategoryRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/boutique", name="shop_")
 */
class ShopController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ProductRepository $pr): Response
    {
        // for ($i=0; $i < 10; $i++) { 
            // dump(date("Ymdhis"));
            dump(date_timestamp_get(new DateTime()));
        // }
        dump(uniqid("qsb-"));
        return $this->render('shop/index.html.twig', [
            'products' => $pr->findAll(),
        ]);
    }

    /**
     * @Route("/{slug}", name="category")
     */
    public function category(Category $category): Response
    {
        $products = [];
        foreach ($category->getSubCategories() as $subCategory)
        {
            foreach ($subCategory->getProducts() as $product) {
                $products[] = $product;
            }
        }
        return $this->render('shop/index.html.twig', [
            'products' => $products,
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{category_slug}/{slug}", name="sub_category")
     */
    public function subCategory(CategoryRepository $categoryRepository, SubCategoryRepository $subCategoryRepository, $category_slug, $slug): Response
    {
        $products = [];
        $subCategory = null;
        
        try
        {
            $category = $categoryRepository->findOneBySlug($category_slug);
            $subCategory = $subCategoryRepository->findOneBy(['category' => $category->getId(), 'slug' => $slug]);
            foreach ($subCategory->getProducts() as $product)
            {
                $products[] = $product;
            }
        }
        catch (\Throwable $th)
        {
            throw $this->createNotFoundException();
        }
        
        return $this->render('shop/index.html.twig', [
            'products' => $products,
            'subCategory' => $subCategory,
        ]);
    }
}
