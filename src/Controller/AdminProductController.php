<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\SubCategory;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product", name="admin_product_")
*/
class AdminProductController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('admin/product/index.html.twig', [
            'products' => $productRepository->findAll()
        ]);
    }

    /**
     * @Route("/create/{subCategory}", name="create")
     */
    public function create(?SubCategory $subCategory = null, EntityManagerInterface $manager, Request $request, FileUploaderService $FileUploaderService): Response
    {
        $product = new Product();
        
        if ($subCategory)
        {
            $product->setSubCategory($subCategory);
        }

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $coverImageUrl = $FileUploaderService->upload($form->get('coverImage')->getData(), 'products');
            $product->setCoverImage($coverImageUrl);

            $manager->persist($product);
            $manager->flush();

            if ($subCategory)
            {
                return $this->redirectToRoute('admin_sub_category_show', ['id' => $subCategory->getId()]);
            }
            return $this->redirectToRoute('admin_product_show', ['id' => $product->getId()]);
        }

        return $this->render('admin/product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Product $product): Response
    {
        return $this->render('admin/product/show.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * find subCategories by category id for AJAX
     * 
     * @Route("/find-by-sub-categories", name="find_by_sub_categories", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function AJAX_findBySubCatagories(Request $request, ProductRepository $productRepository): JsonResponse
    {
        $products = json_decode($request->getContent())->subCategories;

        $products = $productRepository->findBy(['subCategory' => $products]);
        if ($products)
        {
            $data = [];
            foreach ($products as $products)
            {
                $data[] = ['id' => $products->getId(), 'name' => $products->getName(), 'subCategory' => $products->getSubCategory()->getName()];
            }
            return new JsonResponse($data);
        }
        return new JsonResponse(false);
    }
}
