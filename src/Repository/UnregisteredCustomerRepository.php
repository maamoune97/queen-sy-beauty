<?php

namespace App\Repository;

use App\Entity\UnregisteredCustomer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UnregisteredCustomer|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnregisteredCustomer|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnregisteredCustomer[]    findAll()
 * @method UnregisteredCustomer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnregisteredCustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnregisteredCustomer::class);
    }

    // /**
    //  * @return UnregisteredCustomer[] Returns an array of UnregisteredCustomer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UnregisteredCustomer
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
