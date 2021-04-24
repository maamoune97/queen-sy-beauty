<?php

namespace App\Controller;

use App\Entity\SubCategory;
use App\Form\SubCategoryType;
use App\Repository\SubCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
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
