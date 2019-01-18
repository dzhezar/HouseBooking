<?php

namespace App\Repository\Hotel;

use App\Entity\Category;
use App\Entity\Hotel;
use App\Hotel\HotelFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Hotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hotel|null findOneBy(array $criteria, array $orderBy = null)
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

    public function findFreeHotels(string $city, int $guests)
    {
        return $this->createQueryBuilder('h')
            ->leftJoin('App\Entity\BusyDays', 'b',
                \Doctrine\ORM\Query\Expr\Join::WITH, 'h.id = b.hotel')
            ->leftJoin('App\Entity\City', 'c',
                \Doctrine\ORM\Query\Expr\Join::WITH, 'h.city = c.id')
            ->where('c.name = :city')
            ->andWhere('h.capacity >= :guests')
            ->setParameters(['city' => $city,
                'guests' => $guests,
            ])
            ->getQuery()
            ->getResult();
    }

    public function findHotelById(string $id)
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function findNumberOfHotels(int $count)
    {
        return $this->createQueryBuilder('h')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }

    public function findBookedHotelsByUser(int $id)
    {
        return $this->createQueryBuilder('h')
            ->leftJoin('App\Entity\BusyDays', 'b',
                \Doctrine\ORM\Query\Expr\Join::WITH, 'h.id = b.hotel')
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

    public function filterHotels(HotelFilter $filter, int $cityId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select("h")
            ->from("App\Entity\Hotel", "h")
            ->where('h.city = :cityId')->setParameter('cityId',$cityId);

        if (!empty($filter->getCategories()->first())) {
            /* @var Collection $categoriesCollection */
            $categoriesCollection = $filter->getCategories();
            $categories = $categoriesCollection->map(function (Category $category) {
                return $category->getId();
            });
            $query->andWhere('h.category IN (:categories)')
                ->setParameter('categories', $categories, Connection::PARAM_INT_ARRAY);
        }
        $query->andWhere('h.price BETWEEN :priceMin AND :priceMax')->setParameter('priceMin', $filter->getPriceMin())
                                                                   ->setParameter( 'priceMax',$filter->getPriceMax());
        $query->andWhere('h.capacity BETWEEN :capacityMin AND :capacityMax')->setParameter('capacityMin',$filter->getCapacityMin())
                                                                            ->setParameter('capacityMax',$filter->getCapacityMax());


        return $query->getQuery()->getResult();
    }


//    public function findAllHotelsWithBusyDays()
//    {
//        $conn = $this->getEntityManager()->getConnection();
//        $sql = "
//            SELECT * FROM hotel h
//            LEFT JOIN busy_days bd ON h.id = bd.hotel_id
//            UNION
//            SELECT * FROM hotel h2
//            RIGHT JOIN busy_days bd2 ON h2.id = bd2.hotel_id
//        ";
//        $stmt = $conn->prepare($sql);
//        $stmt->execute();
//        return $stmt->fetchAll();
//    }

}

