<?php

namespace App\Repository;

use App\Entity\ProductOptionField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductOptionField|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductOptionField|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductOptionField[]    findAll()
 * @method ProductOptionField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductOptionFieldRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductOptionField::class);
    }

    // /**
    //  * @return ProductOptionField[] Returns an array of ProductOptionField objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductOptionField
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
