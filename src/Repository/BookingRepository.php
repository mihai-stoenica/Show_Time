<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    //    /**
    //     * @return Booking[] Returns an array of Booking objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Booking
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function computeTotalRevenue()
    {
        $bookings = $this->findAll();
        $total = 0;
        foreach ($bookings as $booking) {
            $total += $booking->getFestival()->getPrice();
        }

        return $total;
    }

    public function getNonGuestRevenue(): float
    {
        $bookings = $this->findAll();
        $nonGuestRevenue = 0;
        foreach ($bookings as $booking) {
            if ($booking->getUser() != null) {
                $nonGuestRevenue += $booking->getFestival()->getPrice();
            }
        }
        return $nonGuestRevenue;
    }

    public function getGuestCount(): float
    {
        $bookings = $this->findAll();
        $guestCount = 0;
        foreach ($bookings as $booking) {
            if ($booking->getUser() == null) {
                $guestCount += 1;
            }
        }
        return $guestCount;
    }


}
