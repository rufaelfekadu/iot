<?php

namespace App\Repository;

use App\Entity\Appliance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Appliance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appliance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appliance[]    findAll()
 * @method Appliance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplianceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appliance::class);
    }

    // /**
    //  * @return Appliance[] Returns an array of Appliance objects
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
    public function findOneBySomeField($value): ?Appliance
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
