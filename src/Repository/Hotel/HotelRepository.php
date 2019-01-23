<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Repository\Hotel;

use App\Dto\HotelFilter;
use App\Dto\HotelSearchForm;
use App\Entity\Category;
use App\Entity\Hotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|Hotel find($id, $lockMode = null, $lockVersion = null)
 * @method null|Hotel findOneBy(array $criteria, array $orderBy = null)
 * @method Hotel[]    findAll()
 * @method Hotel[]    findBusyHotels($dates)
 * @method Hotel[]    findAllWithHotels($start,$finish)
 * @method Hotel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelRepository extends ServiceEntityRepository implements HotelRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Hotel::class);
    }

    public function findAllWithCategories()
    {
        return $this->createQueryBuilder('h')
            ->innerJoin('h.category', 'c')
            ->addSelect('c')
            ->getQuery()
            ->getResult();
    }

    public function findAllByCategory(string $category)
    {
        return $this->createQueryBuilder('h')
            ->innerJoin('h.category', 'c')
            ->addSelect('c')
            ->andWhere('c.name = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function findAllFiltered(HotelSearchForm $form, HotelFilter $filterDto)
    {
        $query =  $this->createQueryBuilder('h')
            ->leftJoin(
                'App\Entity\BusyDays',
                'b',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'h.id = b.hotel'
            )
            ->leftJoin(
                'App\Entity\City',
                'c',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'h.city = c.id'
            )
            ->where('c.name = :city')
            ->andWhere('h.isPublished = 1')
            ->andWhere('h.capacity >= :guests')
            ->setParameters(['city' => $form->getCity(),
                'guests' => $form->getGuests(),
            ]);

        if (!empty($filterDto->getCategory()->first())) {
            /* @var Collection $categoriesCollection */
            $categoriesCollection = $filterDto->getCategory();
            $categories = $categoriesCollection->map(function (Category $category) {
                return $category->getId();
            });

            $query->andWhere('h.category IN (:categories)')
                ->setParameter('categories', $categories, Connection::PARAM_INT_ARRAY);
        }
        $query->andWhere('h.price BETWEEN :priceMin AND :priceMax')->setParameter('priceMin', $filterDto->getPriceMin())->setParameter('priceMax', $filterDto->getPriceMax());

        $query->andWhere('h.capacity BETWEEN :capacityMin AND :capacityMax')->setParameter('capacityMin', $filterDto->getCapacityMin())
            ->setParameter('capacityMax', $filterDto->getCapacityMax());

        return $query->getQuery()->getResult();
    }

    public function findHotelById(int $id)
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function findNumberOfHotels(int $count)
    {
        return $this->createQueryBuilder('h')
            ->where('h.isPublished = 1')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }

    public function findBookedHotelsByUser(int $id)
    {
        return $this->createQueryBuilder('h')
            ->leftJoin(
                'App\Entity\BusyDays',
                'b',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'h.id = b.hotel'
            )
            ->where('b.user = :user')
            ->setParameter('user', $id)
            ->distinct()
            ->getQuery()
            ->getResult();
    }

    public function findOwnedHotelsByUser(int $id)
    {
        return $this->createQueryBuilder('h')
            ->innerJoin('h.owner', 'o')
            ->where('o.id = :owner')
            ->setParameter('owner', $id)
            ->getQuery()
            ->getResult();
    }
}
