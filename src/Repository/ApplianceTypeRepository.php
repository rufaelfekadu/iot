<?php

namespace App\Repository;

use App\Entity\ApplianceType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApplianceType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApplianceType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApplianceType[]    findAll()
 * @method ApplianceType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplianceTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApplianceType::class);
    }

    // /**
    //  * @return ApplianceType[] Returns an array of ApplianceType objects
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
    public function findOneBySomeField($value): ?ApplianceType
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
