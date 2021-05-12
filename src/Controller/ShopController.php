<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\ProductFilter;
use App\Form\ProductFilterType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\SubCategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/boutique", name="shop_")
 */
class ShopController extends AbstractController
{
    private $productRepo;
    private $categoryRepo;
    private $subCategoryRepo;
    private $paginator;

    /**
     *
     * @param ProductRepository $productRepo
     * @param CategoryRepository $categoryRepo
     * @param SubCategoryRepository $subCategoryRepo
     * @param PaginatorInterface $paginator
     */
    public function __construct(ProductRepository $productRepo, CategoryRepository $categoryRepo, SubCategoryRepository $subCategoryRepo, PaginatorInterface $paginator)
    {
        $this->productRepo = $productRepo;
        $this->subCategoryRepo = $subCategoryRepo;
        $this->categoryRepo = $categoryRepo;
        $this->paginator = $paginator;
    }
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {

        $productFilter = new ProductFilter();
        $form = $this->createForm(ProductFilterType::class, $productFilter);

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $products = $this->paginator->paginate(
                $this->productRepo->findAllVisibleQuery($productFilter), /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                12 /*limit per page*/
            );
        }
        else
        {
            $products = $this->paginator->paginate(
                $this->productRepo->findAllVisibleQuery(), /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                12 /*limit per page*/
            );
        }


        return $this->render('shop/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="category")
     */
    public function category(Category $category, Request $request): Response
    {

        $subCategoriesId = [];
        foreach ($category->getSubCategories() as $subCategory)
        {
            $subCategoriesId[] = $subCategory->getId();
        }

        $productFilter = new ProductFilter();
        $form = $this->createForm(ProductFilterType::class, $productFilter);

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $products = $this->paginator->paginate(
                $this->productRepo->findAllVisibleByCategoryQuery($subCategoriesId, $productFilter), /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                12 /*limit per page*/
            );
        }
        else
        {
            
            $products = $this->paginator->paginate(
                $this->productRepo->findAllVisibleByCategoryQuery($subCategoriesId), /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                12 /*limit per page*/
            );
        }
        


        return $this->render('shop/index.html.twig', [
            'products' => $products,
            'category' => $category,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{category_slug}/{slug}", name="sub_category")
     */
    public function subCategory($category_slug, $slug, Request $request): Response
    {        
        try
        {
            $category = $this->categoryRepo->findOneBySlug($category_slug);
            $subCategory = $this->subCategoryRepo->findOneBy(['category' => $category->getId(), 'slug' => $slug]);


            $productFilter = new ProductFilter();
            $form = $this->createForm(ProductFilterType::class, $productFilter);

            $form->handleRequest($request);

            if ($form->isSubmitted())
            {
                $products = $this->paginator->paginate(
                    $this->productRepo->findAllVisibleBySubCategoryQuery($subCategory->getId(), $productFilter), /* query NOT result */
                    $request->query->getInt('page', 1), /*page number*/
                    12 /*limit per page*/
                );
            }
            else
            {
                $products = $this->paginator->paginate(
                    $this->productRepo->findAllVisibleBySubCategoryQuery($subCategory->getId()), /* query NOT result */
                    $request->query->getInt('page', 1), /*page number*/
                    12 /*limit per page*/
                );
            }

        }
        catch (\Throwable $th)
        {
            throw $this->createNotFoundException();
        }
        
        return $this->render('shop/index.html.twig', [
            'products' => $products,
            'subCategory' => $subCategory,
            'form' => $form->createView()
        ]);
    }
}
