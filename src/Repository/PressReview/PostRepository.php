<?php

namespace App\Repository\PressReview;

use App\Entity\PressReview\Issue;
use App\Entity\PressReview\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

//    /**
//     * @return Post[] Returns an array of Post objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findRejected()
    {
        return $this->createQueryBuilder('p')
            ->where('p.published_at <= :date')
            ->andWhere('p.status = :status')
            ->setParameters(new ArrayCollection([
                new Parameter('date',  (new \DateTime())->modify('-15 days')),
                new Parameter('status', 'rejected')]
            ))
            ->getQuery()
            ->getResult()
        ;
    }

    public function findReviewedByIssue(Issue $issue)
    {
        return $this->createQueryBuilder('p')
            ->where('p.issue = :issue')
            ->andWhere('p.status = :status')
            ->orderBy('p.lvl', 'ASC')
            ->addOrderBy('p.published_at', 'ASC')
            ->setParameters(new ArrayCollection([
                new Parameter('issue', $issue),
                new Parameter('status', 'reviewed')
            ]))
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAccepted()
    {
        return $this->createQueryBuilder('p')
            ->where('p.status = :status')
            ->setParameter('status', 'accepted')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getPostsBy(string|null $currentStatus, int $currentCategory): Query
    {
        $q = $this->createQueryBuilder('p')
            ->orderBy('p.lvl', 'ASC')
            ->orderBy('p.published_at', 'ASC')
        ;

        if($currentStatus && $currentStatus !== 'all') {
            $q
                ->andWhere('p.status = :status')
                ->setParameter('status', $currentStatus)
            ;
        }

        if($currentCategory) {
            $q
                ->leftJoin('p.category', 'c')
                ->andWhere('c.id = :category')
                ->setParameter('category', $currentCategory)
            ;
        }

        return $q->getQuery();
    }
}
