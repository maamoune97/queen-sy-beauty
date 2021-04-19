<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\PlaceOrder;
use App\Entity\ProductPack;
use App\Entity\UnregisteredCustomer;
use App\Entity\User;
use App\Form\PlaceOrderType;
use App\Repository\ProductOptionFieldRepository;
use App\Security\AppAuthenticator;
use App\Service\CartService;
use App\Service\FormValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class OrderController extends AbstractController
{
    private $formValidator;

    public function __construct(FormValidatorService $formValidator)
    {
        $this->formValidator = $formValidator;
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/order/new", name="order_new")
     */
    public function new(CartService $cart): Response
    {

        return $this->render('order/new.html.twig', [
            
        ]);
    }

    /**
     * @Route("/commande/finaliser", name="order_finalize")
     *
     * @return void
     */
    public function finalize(CartService $cart, Request $request, EntityManagerInterface $manager, ProductOptionFieldRepository $productOptionFieldRepository, UserPasswordEncoderInterface $encoder, GuardAuthenticatorHandler $guardHandler, AppAuthenticator $authenticator) : Response
    {
        $placeOrder = new PlaceOrder();

        //préremplir le formulaire si l'utilisateur est authenttifié (connecté)
        if ($this->getUser())
        {
            $user = $this->getUser();
            $placeOrder->setLName($user->getLName())
                       ->setFName($user->getFName())
                       ->setEmail($user->getEmail())
                       ->setPhone($user->getPhoneNumber())
                        ;
        }

        $form = $this->createForm(PlaceOrderType::class, $placeOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$this->formValidator->phoneNumberValidate($form->get('phone')->getData()))
        {
            $form->get('phone')->addError(new FormError("Numéro de téléphone invalide"));
        }

        if ($form->isSubmitted() && $placeOrder->getCreateAccount())
        {
            if (!$placeOrder->getPassword())
            {
                $form->get('password')->addError(new FormError("Entrez un mot de passe"));
            }
            elseif (!$this->formValidator->isStrongPassword($placeOrder->getPassword()))
            {
                $form->get('password')->addError(new FormError("le mot de passe doit contenir au moins 1 majuscule, minuscule  1 chiffre et 8 caractères"));
            }
            if (!$placeOrder->getPasswordConfirm())
            {
                $form->get('passwordConfirm')->addError(new FormError("Confirmer le mot de passe"));
            }
        }

        if ($form->isSubmitted() && $form->isValid())
        {
            $order = new Order();
            $order->setPrice($cart->getSubtotalPrice())
                 ->setStatus(0)
                 ->setDeliveryAddress($placeOrder->getDeliveryAddress())
                 ->setPaymentMode($placeOrder->getPaymentMode())
                 ;
            
            foreach ($cart->getData() as $item)
            {
                $productPack = new ProductPack();
                $productPack->setProduct($item['product'])
                            ->setQuantity($item['quantity'])
                            ->setCommand($order)
                            ;
                
                foreach ($item['options'] as $option)
                {
                    $optionField = $productOptionFieldRepository->find($option->getId());
                    $optionField->addProductPack($productPack);
                    $manager->persist($optionField);
                }
                $manager->persist($productPack);
                
            }

            if ($this->getUser())
            {
                $order->setCustomer($this->getUser());
            }
            else
            {
                //si l'utilisateur créer un compte automatiquement
                if ($placeOrder->getCreateAccount())
                {
                    $user = new User();
                    $user->setLName($placeOrder->getFName())
                        ->setFName($placeOrder->getLName())
                        ->setPhoneNumber($placeOrder->getPhone())
                        ->setEmail($placeOrder->getEmail())
                        ->setPassword($encoder->encodePassword($user, $placeOrder->getPassword()));
                        
                        $manager->persist($user);
                        
                        $order->setCustomer($user);
                        
                        $manager->persist($order);
                        $manager->flush();

                        $cart->empty();

                        $guardHandler->authenticateUserAndHandleSuccess(
                            $user,
                            $request,
                            $authenticator,
                            'main' // firewall name in security.yaml
                        );

                        //rediriger vers sa nouvelle commande
                        return $this->redirectToRoute('shop_index');
                } 
                else
                {
                    $unregisteredCustomer = new UnregisteredCustomer();
                    $unregisteredCustomer->setFName($placeOrder->getLName())
                                        ->setLName($placeOrder->getFName())
                                        ->setEmail($placeOrder->getEmail())
                                        ->setPhoneNumber($placeOrder->getPhone())
                                        ;
                    $order->setCustomer($unregisteredCustomer);
                }
                
            }

            $manager->persist($order);
            $manager->flush();
            $cart->empty();
            dump('commande passé');
            // inseré un message pour que dire la commande est passé
        }

        return $this->render('order/finalize.html.twig', [
            'products' => $cart->getData(),
            'subTotalPrice' => $cart->getSubtotalPrice(),
            'form' => $form->createView()
        ]);
    }
    
}
