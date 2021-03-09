<?php

namespace App\Controller;

use App\Entity\SubCategory;
use App\Form\SubCategoryType;
use App\Repository\SubCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/subcategory", name="admin_sub_category_")
 */
class AdminSubCategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SubCategoryRepository $subCategoryRepository): Response
    {
        return $this->render('admin/sub_category/index.html.twig', [
            'subCategories' => $subCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(SubCategory $subCategory): Response
    {
        return $this->render('admin/sub_category/show.html.twig', [
            'subCategory' => $subCategory,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $subCategory = new SubCategory();

        $form = $this->createForm(SubCategoryType::class, $subCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($subCategory);
            $manager->flush();
            return $this->redirectToRoute("admin_sub_category_index");
        }

        return $this->render('admin/sub_category/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
