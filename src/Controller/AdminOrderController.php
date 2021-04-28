<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderSearch;
use App\Form\OrderSearchType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
            $orders = $or->findBy(['status' => 1], ['createdAt' => 'ASC']);
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
        switch ($order->getStatus())
        {
            case 1:
                $toStatus = 2;
                break;

            case 2:
                $toStatus = 3;
                break;
            
            default:
                $toStatus = 0;
                break;
        }

        $formData = [
                    'orderNumber' => $order->getOrderNumber(),    
                    'fromStatus' => $order->getStatus(),    
                    'toStatus' => $toStatus,    
                ];

        $form = $this->createFormBuilder($formData)
                    ->setAction($this->generateUrl('admin_order_handle_status'))
                    ->add('orderNumber', HiddenType::class)
                    ->add('fromStatus', HiddenType::class)
                    ->add('toStatus', HiddenType::class)
                    ->getForm()
                    ;

        $cancellationForm = $this->createFormBuilder($formData)
                    ->setAction($this->generateUrl('admin_order_cancellation'))
                    ->add('orderNumber', HiddenType::class)
                    ->getForm()
                    ;

        return $this->render("admin/order/show.html.twig", [
            'order' => $order,
            'form' => $form->createView(),
            'cancellationForm' => $cancellationForm->createView(),
            'toStatus' => $toStatus,
        ]);
    }

    /**
     * @Route("/cancellation", name="cancellation")
     *
     * @return Response
     */
    public function cancellation(EntityManagerInterface $manager, Request $request, OrderRepository $or): Response
    {
        try
        {
            $form = $request->request->get('form');
            $order = $or->findOneByOrderNumber($form['orderNumber']);

            $order->setStatus(0);
            $manager->persist($order);
            $manager->flush();
            return $this->redirectToRoute("admin_order_index");
        } 
        catch (\Throwable $th)
        {
            throw $this->createAccessDeniedException();
        }

    }

    /**
     * @Route("/handle-status", name="handle_status")
     *
     * @return Response
     */
    public function handleStatus(EntityManagerInterface $manager, Request $request, OrderRepository $or): Response
    {
        try
        {
            $form = $request->request->get('form');
    
            $order = $or->findOneByOrderNumber($form['orderNumber']);

            $order->setStatus($form['toStatus']);
            $manager->persist($order);
            $manager->flush();
            return $this->redirectToRoute("admin_order_index");
        } 
        catch (\Throwable $th)
        {
            throw $this->createAccessDeniedException();
        }

    }
}
