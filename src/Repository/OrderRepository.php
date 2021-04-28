<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\OrderSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    public function findbyCriteria(OrderSearch $orderSearch)
    {
        $query = $this->createQueryBuilder('o');

        //filtré par les statut
        if ($orderSearch->getAllStatus() == false)
        {
            if ($orderSearch->getWaitingStatus())
            {
                $query->orWhere('o.status = :waitingStatus')
                      ->setParameter('waitingStatus', '1');
            }
            if ($orderSearch->getPaidStatus())
            {
                $query->orWhere('o.status = :paidStatus')
                      ->setParameter('paidStatus', '2');
            }
            if ($orderSearch->getReceivedStatus())
            {
                $query->orWhere('o.status = :receivedStatus')
                      ->setParameter('receivedStatus', '3');
            }
        }

        //Trié
        switch ($orderSearch->getSort())
        {            
            case 2:
                $query->orderBy('o.price', 'DESC');
                break;
            
            case 3:
                $query->orderBy('o.price', 'ASC');
                break;
            
            case 4:
                $query->orderBy('o.createdAt', 'DESC');
                break;
            
            default:
                $query->orderBy('o.createdAt', 'ASC');
                break;
        }

        // filtré par date
        if ($orderSearch->getDateMin())
        {
            $query->andWhere('o.createdAt >= :dateMin')
                  ->setParameter('dateMin', $orderSearch->getDateMin()->settime(0,0));
        }

        if ($orderSearch->getDateMax())
        {
            $query->andWhere('o.createdAt <= :dateMax')
                  ->setParameter('dateMax', $orderSearch->getDateMax()->settime(23,59,59));
        }

        // filtré par client
        if ($orderSearch->getClient())
        {
            $query
                ->leftJoin('o.registeredCustomer', 'r')
                ->leftJoin('o.unregisteredCustomer', 'u')
                ->andWhere('u.fName LIKE :client OR u.lName LIKE :client OR u.phoneNumber = :phone OR
                            r.fName LIKE :client OR r.lName LIKE :client OR r.phoneNumber = :phone OR
                            o.orderNumber = :orderNum')
                ->setParameter('client', '%'.$orderSearch->getClient().'%')
                ->setParameter('phone', $orderSearch->getClient())
                ->setParameter('orderNum', $orderSearch->getClient())
                ;
        }

        return $query->getQuery()
                     ->getResult();
    }


    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
