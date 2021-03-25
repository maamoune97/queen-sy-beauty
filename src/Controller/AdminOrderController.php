<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderSearch;
use App\Form\OrderSearchType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/order", name="admin_order_")
 */
class AdminOrderController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(OrderRepository $or, Request $request): Response
    {
        $orderSearch = new OrderSearch();

        $form = $this->createForm(OrderSearchType::class, $orderSearch);
        $form->handleRequest($request);

        $orders = null;

        if ($form->isSubmitted()) 
        {
            $orders = $or->findbyCriteria($orderSearch);
        }
        else
        {               
            $form->remove('waitingStatus');
            $form->add('waitingStatus', 
                        CheckboxType::class,
                        [
                            'label' => 'En attente',
                            'required' => false,
                            'attr' => [
                                'checked' => 'checked'
                            ]
                        ]
                    );
            $orders = $or->findBy(['status' => 0], ['createdAt' => 'ASC']);
        }
        
        return $this->render('admin/order/index.html.twig', [
            'searchForm' => $form->createView(),
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     *
     * @param Order $order
     * @return Response
     */
    public function show(Order $order): Response
    {
        return $this->render("admin/order/show.html.twig", [
            'order' => $order
        ]);
    }

    /**
     * @Route("/confirm-payment/{id}", name="confirm_payment")
     *
     * @param Order $order
     * @return Response
     */
    public function ConfirmPayment(Order $order, EntityManagerInterface $manager): Response
    {
        $order->setStatus(1);

        $manager->persist($order);
        $manager->flush();

        return $this->redirectToRoute("admin_order_index");
    }
}
