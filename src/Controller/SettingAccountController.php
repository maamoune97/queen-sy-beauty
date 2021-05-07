<?php

namespace App\Controller;

use App\Entity\PasswordSetting;
use App\Form\GeneralSettingType;
use App\Form\PasswordSettingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SettingAccountController extends AbstractController
{
    /**
     * @Route("/parametre/generale", name="setting_account_general")
     * @IsGranted("ROLE_USER")
     */
    public function general(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(GeneralSettingType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();
            // insert message flash
        }

        return $this->render('setting_account/general.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/parametre/securite", name="setting_account_security")
     * @IsGranted("ROLE_USER")
     */
    public function password(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();
        $passwordSetting = new PasswordSetting();
        $form = $this->createForm(PasswordSettingType::class, $passwordSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword($encoder->encodePassword($user, $passwordSetting->getNew()));
            $manager->persist($user);
            $manager->flush();
            // insert message flash
        }

        return $this->render('setting_account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
