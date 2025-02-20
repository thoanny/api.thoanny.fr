<?php

namespace App\Repository\OnceHuman;

use App\Entity\OnceHuman\Server;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Server>
 */
class ServerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Server::class);
    }

//    /**
//     * @return Server[] Returns an array of Server objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Server
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findAllForAPI()
    {
        $limit = (new \DateTime())->modify('-4 months');
        return $this->createQueryBuilder('s')
            ->orderBy('s.startAt', 'DESC')
            ->where('s.startAt >= :limit')
            ->orWhere('s.startAt IS NULL')
            ->setParameter('limit', $limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getCount()
    {
        $limit = (new \DateTime())->modify('-4 months');
        return $this->createQueryBuilder('s')
            ->select('COUNT(s) AS total')
            ->where('s.startAt >= :limit')
            ->andWhere('s.closed = :false')
            ->setParameter('limit', $limit)
            ->setParameter('false', false)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
