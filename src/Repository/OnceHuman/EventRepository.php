<?php

namespace App\Repository\OnceHuman;

use App\Entity\OnceHuman\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    //    /**
    //     * @return Event[] Returns an array of Event objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findCurrentEvents()
    {
        $start = date('Y-m-d', strtotime('last monday'));
        $end = date('Y-m-d', strtotime('next week sunday'));

        return $this->createQueryBuilder('e')
            ->where('e.startAt < :start AND e.endAt > :start')
            ->orWhere('e.startAt >= :start AND e.startAt <= :end')
            ->setParameters(new ArrayCollection(array(
                new Parameter('start', $start),
                new Parameter('end', $end)
            )))
            ->getQuery()
            ->getResult()
        ;
    }
}
