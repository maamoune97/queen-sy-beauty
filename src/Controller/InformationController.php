<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/information", name="information_")
 */
class InformationController extends AbstractController
{
    /**
     * @Route("/nous-contacter", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('information/contact.html.twig', [
            
        ]);
    }
    /**
     * @Route("/a-propos-de-nous", name="about_us")
     */
    public function aboutUs(): Response
    {
        return $this->render('information/about_us.html.twig', [
            
        ]);
    }
}
