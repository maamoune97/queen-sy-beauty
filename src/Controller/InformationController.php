<?php

namespace App\Controller;

use App\Entity\ContactUs;
use App\Form\ContactUsType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/information", name="information_")
 */
class InformationController extends AbstractController
{
    /**
     * @Route("/nous-contacter", name="contact")
     */
    public function contact(Request $request, \Swift_Mailer  $mailer): Response
    {
        $contactUs = new ContactUs();
        $form = $this->createForm(ContactUsType::class, $contactUs);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $message = (new \Swift_Message('message de '.$contactUs->getFullName()))
            ->setFrom($contactUs->getEmail())
            ->setTo('maamoune97bv@gmail.com')
            ->setBody(
                $this->renderView(
                    // templates/emails/registration.html.twig
                    'partials/emails/_contact_us.html.twig',
                    [
                        'message' => $contactUs->getMessage(),
                        'email' => $contactUs->getEmail(),
                        'full_name' => $contactUs->getFullName(),
                    ]
                ),
                'text/html'
            )
            ;

            $mailer->send($message);


        }

        return $this->render('information/contact.html.twig', [
            'form' => $form->createView()
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
