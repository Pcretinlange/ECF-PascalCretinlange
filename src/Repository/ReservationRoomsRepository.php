<?php

namespace App\Repository;

use App\Entity\ReservationRooms;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReservationRooms|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationRooms|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationRooms[]    findAll()
 * @method ReservationRooms[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRoomsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationRooms::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ReservationRooms $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(ReservationRooms $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findReservation($hotel, $hotelRoom, $startDate, $endDate)
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->innerJoin('a.hotels', 'h')
            ->innerJoin('a.hotelRooms', 'hr')
            ->where('h = :hotel')
            ->andWhere('hr = :hotelRoom')
            ->andWhere('(a.start_date BETWEEN :startDateFrom AND :startDateTo) OR (a.end_date BETWEEN :endDateFrom AND :endDateTo) OR (a.start_date < :startDateFrom AND a.end_date > :endDateTo)')
            ->setParameter('hotel', $hotel)
            ->setParameter('hotelRoom', $hotelRoom)
            ->setParameter('startDateFrom', $startDate)
            ->setParameter('startDateTo', $endDate)
            ->setParameter('endDateFrom', $startDate)
            ->setParameter('endDateTo', $endDate);


        return $queryBuilder->getQuery()->getResult();
    }
}
    // /**
    //  * @return ReservationRooms[] Returns an array of ReservationRooms objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReservationRooms
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
