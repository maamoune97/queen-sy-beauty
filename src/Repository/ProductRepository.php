<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductFilter;
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
    public function findAllVisibleQuery(?ProductFilter $filter = null): Query
    {
        $query = $this->findVisibleQuery();
        
        $query = $this->queryFilter($query, $filter);

        return $query->getQuery();
    }

    /**
     *
     * @param integer $subCategory
     * @return Query
     */
    public function findAllVisibleBySubCategoryQuery(int $subCategory, ?ProductFilter $filter = null): Query
    {
        $queryBuilder = $this->findVisibleQuery()
                            ->where('p.subCategory = :subcategory')
                            ->setParameter('subcategory', $subCategory)
                            ;
        
        $queryBuilder = $this->queryFilter($queryBuilder, $filter);
        
        return $queryBuilder->getQuery();
    }

    /**
     *
     * @param array $subCategories
     * @return Query
     */
    public function findAllVisibleByCategoryQuery(array $subCategories, ?ProductFilter $filter = null): Query
    {
        $queryBuilder = $this->findVisibleQuery()
                            ->andWhere('p.subCategory in (:subcategories)')
                            ->setParameter('subcategories', $subCategories);
        
        $queryBuilder = $this->queryFilter($queryBuilder, $filter);
                    
        return $queryBuilder->getQuery();
    }

    private function queryFilter(QueryBuilder $query, ?ProductFilter $filter = null): QueryBuilder
    {
        if ($filter)
        {
            $query->leftJoin('p.options', 'o')
                    ->leftJoin('o.productOptionFields', 'ofield');

            if ($filter->getSizes() || $filter->getColors())
            {
                $condition = "";

                // les taille
                foreach ($filter->getSizes() as $key => $size)
                {
                    $param = 'size'.$key;
                    if ($key == 0)
                    {
                        $condition .= "ofield.name = :$param ";
                    }
                    else
                    {
                        $condition .= "OR ofield.name = :$param ";
                    }
                }

                // les couleurs
                foreach ($filter->getColors() as $key => $color)
                {
                    $param = 'color'.$key;

                    if ($condition == "")
                    {
                        $condition .= "ofield.name LIKE :$param ";
                    }
                    else
                    {
                        $condition .= "OR ofield.name LIKE :$param ";
                    }
                }

                $query->andWhere($condition);

                foreach ($filter->getSizes() as $key => $size)
                {
                    $param = 'size'.$key;
                    $query->setParameter($param, $size);
                }

                foreach ($filter->getColors() as $key => $color)
                {
                    $param = 'color'.$key;
                    $query->setParameter($param, $color.'%');
                }
                
            }

            if ($filter->getMinPrice())
            {
                $query->andWhere("p.price > :min")
                      ->setParameter('min', $filter->getMinPrice());
            }

            if ($filter->getMaxPrice())
            {
                $query->andWhere("p.price < :max")
                      ->setParameter('max', $filter->getMaxPrice());
            }

            // les couleurs
            // if ($filter->getColors())
            // {
            //     $condition = "";
            //     foreach ($filter->getColors() as $key => $color)
            //     {
            //         $param = 'color'.$key;
            //         if ($key == 0)
            //         {
            //             $condition .= "ofield.name = :$param ";
            //         }
            //         else
            //         {
            //             $condition .= "OR ofield.name = :$param ";
            //         }
            //     }
            //     $query->andWhere($condition);

            //     foreach ($filter->getColors() as $key => $color)
            //     {
            //         $param = 'color'.$key;
            //         $query->setParameter($param, $color);
            //     }
                
            // }

        }

        return $query;
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
