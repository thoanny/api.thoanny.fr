<?php

namespace App\Repository\PressReview;

use App\Entity\PressReview\Category;
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

    public function findRejected(): Query
    {
        return $this->createQueryBuilder('p')
            ->where('p.published_at <= :date')
            ->setParameter('date',  (new \DateTime())->modify('-2 months'))
            ->getQuery()
            ->getResult()
        ;
    }

    public function getPostsBy(int $currentCategory): Query
    {
        $q = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
        ;

        if($currentCategory) {
            $q
                ->leftJoin('p.category', 'c')
                ->andWhere('c.id = :category')
                ->setParameter('category', $currentCategory)
            ;
        }

        return $q->getQuery();
    }

    public function findForRSSFeed(Category $category)
    {
        return $this->createQueryBuilder('p')
            ->where('p.category = :category')
            ->setParameter('category', $category)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
