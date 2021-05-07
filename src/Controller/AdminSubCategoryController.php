<?php

namespace App\Controller;

use App\Entity\SubCategory;
use App\Form\SubCategoryType;
use App\Repository\SubCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/subcategory", name="admin_sub_category_")
 */
class AdminSubCategoryController extends AbstractController
{
    private $subCategoryRepository;

    public function __construct(SubCategoryRepository $subCategoryRepository)
    {
        $this->subCategoryRepository = $subCategoryRepository;
    }

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
     * @Route("/create", name="create")
     */
    public function create(Request $request, EntityManagerInterface $manager, FlashyNotifier $flashy): Response
    {
        $subCategory = new SubCategory();

        $form = $this->createForm(SubCategoryType::class, $subCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($subCategory);
            $manager->flush();
            $flashy->success('Nouvelle sous-categorie ajouté avec succèes');
            return $this->redirectToRoute("admin_sub_category_index");
        }

        return $this->render('admin/sub_category/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(SubCategory $subCategory, Request $request, EntityManagerInterface $manager, FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(SubCategoryType::class, $subCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($subCategory);
            $manager->flush();
            $flashy->success('Sous-categorie modifié avec succèes');
            return $this->redirectToRoute("admin_sub_category_index");
        }

        return $this->render('admin/sub_category/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(SubCategory $subCategory): Response
    {
        $deleteForm = $this->createFormBuilder(['id' => $subCategory->getId()])
                            ->setAction($this->generateUrl('admin_sub_category_delete', ['id' => $subCategory->getId()]))
                            ->getForm();
        
        return $this->render('admin/sub_category/show.html.twig', [
            'subCategory' => $subCategory,
            'deleteForm' => $deleteForm->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(SubCategory $subCategory, Request $request, EntityManagerInterface $manager, FlashyNotifier $flashy): Response
    {
        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete'.$subCategory->getId(), $submittedToken))
        {
            if (!count($subCategory->getProducts()) > 0)
            {
                $manager->remove($subCategory);
                $manager->flush();
                $flashy->success('Sous-categorie supprimée avec succèes');
                return $this->redirectToRoute("admin_sub_category_index");
            }
            else
            {
                $flashy->error('Impossible de supprimer une sous-categorie avec des articles');
                return $this->redirectToRoute("admin_sub_category_show", ['id' => $subCategory->getId()]);
            }
        }
        throw $this->createAccessDeniedException();
    }

    /**
     * find subCategories by category id for AJAX
     * 
     * @Route("/find-by-category", name="find_by_category", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function AJAX_findByCatagory(Request $request): JsonResponse
    {
        $category = json_decode($request->getContent())->category;

        $subCategories = $this->subCategoryRepository->findBy(['category' => $category]);
        if ($subCategories)
        {
            $data = [];
            foreach ($subCategories as $subCategory)
            {
                $data[] = ['id' => $subCategory->getId(), 'name' => $subCategory->getName()];
            }
            return new JsonResponse($data);
        }
        return new JsonResponse(false);
    }
}
