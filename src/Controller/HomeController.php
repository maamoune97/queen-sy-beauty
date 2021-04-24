<?php

namespace App\Controller;

use App\Repository\HomePageCollectionPreviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(HomePageCollectionPreviewRepository $homePageCollectionPreviewRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'collectionsPreview' => $homePageCollectionPreviewRepository->findAll()
        ]);
    }
}
