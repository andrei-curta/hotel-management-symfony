<?php

namespace App\Repository;

use App\Entity\AppartmentPricing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AppartmentPricing|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppartmentPricing|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppartmentPricing[]    findAll()
 * @method AppartmentPricing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppartmentPricingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppartmentPricing::class);
    }

    // /**
    //  * @return AppartmentPricing[] Returns an array of AppartmentPricing objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AppartmentPricing
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
