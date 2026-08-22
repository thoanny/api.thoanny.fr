<?php

namespace App\Repository\Vestigia;

use App\Entity\Vestigia\Account;
use App\Entity\Vestigia\AccountGoal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccountGoal>
 */
class AccountGoalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountGoal::class);
    }

    //    /**
    //     * @return AccountGoal[] Returns an array of AccountGoal objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AccountGoal
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findAccountGoals(Account $account)
    {
        $results = $this->createQueryBuilder('ag')
            ->select('g.id AS goalId', 'ag.updatedAt AS date', 'ag.status')
            ->leftJoin('ag.goal', 'g')
            ->where('ag.account = :account')
            ->setParameter('account', $account)
            ->getQuery()
            ->getResult()
        ;

        return array_map(/**
         * @throws \Exception
         */ function ($goal) {
            $goal['date'] = $goal['date']->format('Y-m-d');
            return $goal;
        }, $results);
    }
}
