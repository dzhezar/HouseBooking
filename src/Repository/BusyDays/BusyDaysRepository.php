<?php

namespace App\Repository\BusyDays;

use App\Entity\BusyDays;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BusyDays|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusyDays|null findOneBy(array $criteria, array $orderBy = null)
 * @method BusyDays[]    findAll()
 * @method BusyDays[]    findFreeHotels()
 * @method BusyDays[]    findBookedHotelsByUser(int $id)
 * @method BusyDays[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BusyDaysRepository extends ServiceEntityRepository implements BusyDaysRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BusyDays::class);
    }

    public function findAllWithHotels($start, $finish)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.hotel', 'h')
            ->addSelect('h')
            ->where('b.date between :start and :finish')
            ->setParameters(['start' => $start, 'finish' => $finish])
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBusyHotels(array $parameter)
    {
       $dates = "('" . implode("','" , $parameter) . "')";

        $this->createQueryBuilder('b')
            ->innerJoin('b.hotel','h')
            ->addSelect('h')
            ->where('b.date IN (:dates)')
            ->setParameter('dates', $dates)
            ->getQuery()
            ->getResult()
            ;
    }
}
