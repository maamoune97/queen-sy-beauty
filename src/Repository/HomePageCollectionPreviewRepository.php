<?php

namespace App\Repository;

use App\Entity\HomePageCollectionPreview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HomePageCollectionPreview|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomePageCollectionPreview|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomePageCollectionPreview[]    findAll()
 * @method HomePageCollectionPreview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomePageCollectionPreviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomePageCollectionPreview::class);
    }

    // /**
    //  * @return HomePageCollectionPreview[] Returns an array of HomePageCollectionPreview objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HomePageCollectionPreview
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
