<?php

namespace App\Repository;

use App\Entity\Appartment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Appartment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appartment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appartment[]    findAll()
 * @method Appartment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appartment::class);
    }

    // /**
    //  * @return Appartment[] Returns an array of Appartment objects
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
    public function findOneBySomeField($value): ?Appartment
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
