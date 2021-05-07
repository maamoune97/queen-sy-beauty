<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\SubCategory;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
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
    public function create(?SubCategory $subCategory = null, EntityManagerInterface $manager, Request $request, FileUploaderService $FileUploaderService, FlashyNotifier $flashy): Response
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
            $flashy->success('Article créé avec succès');

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
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Product $product, EntityManagerInterface $manager, Request $request, FileUploaderService $FileUploaderService, FlashyNotifier $flashy): Response
    {
        $oldImageLogo = $product->getCoverImage();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $coverImage = $form->get("coverImage")->getData();
            if (!$coverImage && $oldImageLogo)
            {
                $product->setCoverImage($oldImageLogo);
            }
            else
            {
                $fileSystem = new Filesystem();
                $fileSystem->remove($product->getCoverImage());

                $newCoverImage = $FileUploaderService->upload($form->get('coverImage')->getData(), 'products');
                $product->setCoverImage($newCoverImage);
            }

            $manager->persist($product);
            $manager->flush();
            $flashy->success('Article modifié avec succès');
            return $this->redirectToRoute('admin_product_show', ['id' => $product->getId()]);
        }

        return $this->render('admin/product/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Product $product): Response
    {
        $deleteForm = $this->createFormBuilder(['id' => $product->getId()])
                            ->setAction($this->generateUrl('admin_product_delete', ['id' => $product->getId()]))
                            ->getForm();

        $visibilityForm = $this->createFormBuilder(['id' => $product->getId()])
                            ->setAction($this->generateUrl('admin_product_change_visibility', ['id' => $product->getId()]))
                            ->getForm();

        return $this->render('admin/product/show.html.twig', [
            'product' => $product,
            'deleteForm' => $deleteForm->createView(),
            'visibilityForm' => $visibilityForm->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Product $product, Request $request, EntityManagerInterface $manager, FlashyNotifier $flashy): Response
    {
        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $submittedToken))
        {
            if (!count($product->getProductPacks()) > 0)
            {
                $manager->remove($product);
                $manager->flush();
                $flashy->success('Article supprimée avec succèes');
                return $this->redirectToRoute("admin_product_index");
            }
            else
            {
                $flashy->error('Impossible de supprimer une article avec des commandes');
                return $this->redirectToRoute("admin_product_show", ['id' => $product->getId()]);
            }
        }
        throw $this->createAccessDeniedException();
    }

    /**
     * @Route("/change-visiblity/{id}", name="change_visibility", methods={"POST"})
     */
    public function changeVisiblity(Product $product, Request $request, EntityManagerInterface $manager, FlashyNotifier $flashy): Response
    {
        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('visibility'.$product->getId(), $submittedToken))
        {
            $product->setVisible(!$product->getVisible());
            $manager->persist($product);
            $manager->flush();
            if ($product->getVisible())
                $flashy->success('Article visible sur la catalogue');
            else
                $flashy->warning('Article masquée de la catalogue');

            return $this->redirectToRoute("admin_product_show", ['id' => $product->getId()]);
        }
        throw $this->createAccessDeniedException();
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
