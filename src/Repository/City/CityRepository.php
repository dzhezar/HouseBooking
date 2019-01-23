<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Repository\City;

use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|City find($id, $lockMode = null, $lockVersion = null)
 * @method null|City findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findFreeHotels()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, City::class);
    }

    public function findByName(string $name)
    {
        return $this->createQueryBuilder('c')
                  ->where('c.name LIKE :text')
                  ->setParameter('text', '%' . $name . '%')
                  ->getQuery()
                  ->getResult()
          ;
    }
}
