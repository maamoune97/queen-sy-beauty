<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Query Returns a Query of visible products
     */
    public function findAllVisibleQuery(): Query
    {
        return $this->findVisibleQuery()
                    ->getQuery()
                    ;
    }

    /**
     *
     * @param integer $subCategory
     * @return Query
     */
    public function findAllVisibleBySubCategoryQuery(int $subCategory): Query
    {
        return $this->findVisibleQuery()
                    ->where('p.subCategory = :subcategory')
                    ->setParameter('subcategory', $subCategory)
                    ->getQuery()
                    ;
    }

    /**
     *
     * @param array $subCategories
     * @return Query
     */
    public function findAllVisibleByCategoryQuery(array $subCategories): Query
    {
        return $this->findVisibleQuery()
                    ->andWhere('p.subCategory in (:subcategories)')
                    ->setParameter('subcategories', $subCategories)
                    ->getQuery()
                    ;
    }


    /**
     * Returns a QueryBuilder of Product objects
     *
     * @return QueryBuilder
     */
    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
                    ->where('p.visible = true')
                    ;
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
