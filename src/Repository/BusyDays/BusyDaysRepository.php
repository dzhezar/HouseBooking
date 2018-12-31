<?php

namespace App\Repository\BusyDays;

use App\Entity\BusyDays;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BusyDays|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusyDays|null findOneBy(array $criteria, array $orderBy = null)
 * @method BusyDays[]    findAll()
 * @method BusyDays[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BusyDaysRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BusyDays::class);
    }

    // /**
    //  * @return BusyDays[] Returns an array of BusyDays objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BusyDays
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
