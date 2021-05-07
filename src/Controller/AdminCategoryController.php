<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
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
    public function create(Request $request, EntityManagerInterface $manager, FlashyNotifier $flashy): Response
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
            $flashy->success('Nouvelle categorie ajouté avec succèes');
            return $this->redirectToRoute("admin_category_index");
        }

        return $this->render('admin/category/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id} ", name="edit")
     */
    public function edit(Category $category, Request $request, EntityManagerInterface $manager, FlashyNotifier $flashy): Response
    {
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
            $flashy->success('Categorie modifié avec succèes');
            return $this->redirectToRoute("admin_category_index");
        }

        return $this->render('admin/category/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Category $category): Response
    {
        $deleteForm = $this->createFormBuilder(['id' => $category->getId()])
                            ->setAction($this->generateUrl('admin_category_delete', ['id' => $category->getId()]))
                            ->getForm();

        return $this->render('admin/category/show.html.twig', [
            'category' => $category,
            'deleteForm' => $deleteForm->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Category $category, Request $request, EntityManagerInterface $manager, FlashyNotifier $flashy): Response
    {
        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $submittedToken))
        {
            if (!count($category->getSubCategories()) > 0)
            {
                $manager->remove($category);
                $manager->flush();
                $flashy->success('Categorie supprimée avec succèes');
                return $this->redirectToRoute("admin_category_index");
            }
            else
            {
                $flashy->error('Impossible de supprimer une categorie avec des sous-categories');
                return $this->redirectToRoute("admin_category_show", ['id' => $category->getId()]);
            }
        }
        throw $this->createAccessDeniedException();
    }

}
