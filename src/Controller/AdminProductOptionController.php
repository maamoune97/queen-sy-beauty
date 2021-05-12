<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductOption;
use App\Form\ProductOptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product/option", name="admin_product_option_")
 */
class AdminProductOptionController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('admin/product_option/index.html.twig', [
            'controller_name' => 'AdminProductOptionController',
        ]);
    }

    /**
     * @Route("/create/{product}", name="create")
     */
    public function create(Request $request, EntityManagerInterface $manger, Product $product): Response
    {
        $productOption = new ProductOption();

        $form = $this->createForm(ProductOptionType::class, $productOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            foreach ($productOption->getProductOptionFields() as $optionField)
            {
                $optionField->setProductOption($productOption);
                $manger->persist($optionField);
            }
            $productOption->setProduct($product);
            $manger->persist($productOption);
            $manger->flush();

            return $this->redirectToRoute('admin_product_show', ['id' => $product->getId()]);
        }

        return $this->render('admin/product_option/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(ProductOption $productOption, Request $request, EntityManagerInterface $manger): Response
    {
        $form = $this->createForm(ProductOptionType::class, $productOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            foreach ($productOption->getProductOptionFields() as $optionField)
            {
                $optionField->setProductOption($productOption);
                $manger->persist($optionField);
            }
            
            $manger->persist($productOption);
            $manger->flush();

            return $this->redirectToRoute('admin_product_show', ['id' => $productOption->getProduct()->getId()]);
        }

        return $this->render('admin/product_option/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/add/{type}/in-product/{id}", name="add")
     *
     * @param Type $var
     * @return void
     */
    public function add(string $type,Product $product, Request $request, EntityManagerInterface $manger)
    {
        if (!in_array($type, ['color', 'size']))
        {
            throw $this->createNotFoundException();
        }

        $productOption = new ProductOption();
        $productOption->setType($type);

        $form = $this->createForm(ProductOptionType::class, $productOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            foreach ($productOption->getProductOptionFields() as $optionField)
            {
                $optionField->setProductOption($productOption);
                $manger->persist($optionField);
            }
            $productOption->setProduct($product);
            $manger->persist($productOption);
            $manger->flush();

            return $this->redirectToRoute('admin_product_show', ['id' => $product->getId()]);
        }

        return $this->render('admin/product_option/create.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
            'type' => $type == 'color' ? 'Couleur' : 'Taille',
        ]);

    }

}
