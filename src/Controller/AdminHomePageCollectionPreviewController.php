<?php

namespace App\Controller;

use App\Entity\HomePageCollectionPreview;
use App\Form\CollectionPreviewType;
use App\Repository\HomePageCollectionPreviewRepository;
use App\Service\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomePageCollectionPreviewController extends AbstractController
{
    /**
     * @Route("/admin/home/page/collection/preview", name="admin_home_page_collection_preview_index")
     */
    public function index(HomePageCollectionPreviewRepository $collectionPreviewRepo): Response
    {

        return $this->render('admin/home_page_collection_preview/index.html.twig', [
            'collectionsPreview' => $collectionPreviewRepo->findAll()
        ]);
    }

    /**
     * @Route("/admin/home/page/collection/preview/create", name="admin_home_page_collection_preview_create")
     */
    public function create(Request $request, EntityManagerInterface $manager, FileUploaderService $fileUploader): Response
    {
        $collectionPreview = new HomePageCollectionPreview();

        $form = $this->createForm(CollectionPreviewType::class, $collectionPreview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            foreach ($collectionPreview->getSubCategories() as $subCategory)
            {
                $manager->persist($subCategory);
            }

            foreach ($collectionPreview->getProducts() as $product)
            {
                $manager->persist($product);
            }
            
            $imagePath = $fileUploader->upload($form->get('image')->getData(), 'collections_preview');
            $collectionPreview->setImage($imagePath);

            $manager->persist($collectionPreview);
            $manager->flush();
            return $this->redirectToRoute('admin_home_page_collection_preview_index');
        }

        return $this->render('admin/home_page_collection_preview/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/home/page/collection/preview/delete/{id}", name="admin_home_page_collection_preview_delete")
     */
    public function delete(EntityManagerInterface $manager, HomePageCollectionPreview $collectionPreview = null): Response
    {
        if ($collectionPreview)
        {
            foreach ($collectionPreview->getProducts() as $product)
            {
                $collectionPreview->removeProduct($product);
                $manager->persist($product);
            }

            foreach ($collectionPreview->getSubCategories() as $subCategory)
            {
                $collectionPreview->removeSubCategory($subCategory);
                $manager->persist($subCategory);
            }
            $manager->remove($collectionPreview);
            
            $manager->flush();
        }
        return $this->redirectToRoute('admin_home_page_collection_preview_index');
    }
}
