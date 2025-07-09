<?php

namespace App\Repository;

use App\Entity\Festival;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Festival>
 */
class FestivalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Festival::class);
    }

    //    /**
    //     * @return Festival[] Returns an array of Festival objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Festival
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getBySearchParam(?string $name, ?string $sort, ?string $startDate, ?string $endDate, ?string $sort_price): array
    {
        $query = $this->createQueryBuilder('f');

        if ($name) {
            $query->andWhere('f.name LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        }

        if ($sort === 'asc' || $sort === 'desc') {
            $query->orderBy('f.name', $sort);
        }

        if ($sort_price == 'asc' || $sort_price == 'desc') {
            $query->orderBy('f.price', $sort_price);
        }

        if ($startDate && $endDate) {
            $startDate = date_create($startDate);
            $endDate = date_create($endDate);

            $query->andWhere('f.start_date BETWEEN :startDate AND :endDate')
                ->setParameter('startDate', $startDate)
                ->setParameter('endDate', $endDate);
        }

        return $query->getQuery()->getResult();
    }

    public function getMostFeatured(): array
    {
        $most_featured = $this->findAll();

        usort($most_featured, function (Festival $a, Festival $b) {
            return count($b->getBookings()) <=> count($a->getBookings());
        });

        return $most_featured;
    }

    public function getBestDeals(): array
    {
        $best_deals = $this->findAll();

        usort($best_deals, function (Festival $a, Festival $b) {
            return $a->getPrice() <=> $b->getPrice();
        });

        return $best_deals;
    }
}
