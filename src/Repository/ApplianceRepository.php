<?php

namespace App\Repository;

use App\Entity\Appliance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Appliance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appliance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appliance[]    findAll()
 * @method Appliance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplianceRepository extends ServiceEntityRepository
{

    /**
     * @var Security
     */
    private $security;

    
    public function __construct(ManagerRegistry $registry,Security $security)
    {
        $this->security = $security;
        parent::__construct($registry, Appliance::class);
    }

    // /**
    //  * @return Appliance[] Returns an array of Appliance objects
    //  */
    
    public function findByOffice()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.office = :val')
            ->setParameter('val', $this->security->getUser()->getOffice())
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

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
