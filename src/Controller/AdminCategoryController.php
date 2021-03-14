<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category", name="admin_category_")
 */
class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(CategoryRepository $cr): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $cr->findAll(),
        ]);
    }

   
    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $category = new Category();

        $form = $this->createFormBuilder($category)
                    ->add('name', TextType::class, [
                        'label' => 'Nom',
                        'attr' => [
                            'placeholder' => 'ex: Femmes, Homme, Enfant, ...'
                        ]
                    ])
                    ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute("admin_category_index");
        }

        return $this->render('admin/category/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Category $category): Response
    {
        return $this->render('admin/category/show.html.twig', [
            'category' => $category,
        ]);
    }

}
