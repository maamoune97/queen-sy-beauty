<?php

namespace App\Controller;

use App\Entity\OrderSearch;
use App\Form\OrderSearchType;
use App\Repository\OrderRepository;
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
            //dd($orderSearch);
            dump($orderSearch);
        }
        else
        {   
            // $form->get('waitingStatus')->setAttributes(['attr' => ['checked', 'checked']]);
            
            // $form->get('waitingStatus')->config->options['attr'] = ['checked' => 'checked'];
            
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

        dump($orders);
        
        return $this->render('admin/order/index.html.twig', [
            'searchForm' => $form->createView(),
            'orders' => $orders
        ]);
    }
}
