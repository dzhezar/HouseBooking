<?php

namespace App\Repository\Hotel;

use App\Entity\Hotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Hotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hotel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hotel[]    findAll()
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
            ->innerJoin('h.category','c')
            ->addSelect('c')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByCategory(string $category)
    {
        return $this->createQueryBuilder('h')
            ->innerJoin('h.category','c')
            ->addSelect('c')
            ->andWhere('c.name = :category')
            ->setParameter('category',$category)
            ->getQuery()
            ->getResult()
            ;
    }
}
