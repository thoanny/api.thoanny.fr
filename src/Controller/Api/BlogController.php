<?php

namespace App\Controller\Api;

use App\Entity\Blog\Category;
use App\Entity\Blog\Post;
use App\Entity\Blog\Tag;
use App\Repository\Blog\CategoryRepository;
use App\Repository\Blog\PostRepository;
use App\Repository\Blog\TagRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/blog')]
final class BlogController extends AbstractController
{

    private $limit = 10;
    #[Route('/posts', name: 'app_api_blog_post_index')]
    public function post_index(
        PostRepository $postRepository,
        SerializerInterface $serializer,
        PaginatorInterface $paginator,
        Request $request
    ): JsonResponse
    {
        $posts = $paginator->paginate(
            $postRepository->createQueryBuilder('p')
                ->where('p.status = :status')
                ->setParameter('status', 'published')
                ->orderBy('p.publishedAt', 'DESC'),
            $request->query->getInt('page', 1),
            $this->limit
        );

        $next = ($posts->getCurrentPageNumber() * $posts->getItemNumberPerPage() < $posts->getTotalItemCount()) ? $posts->getCurrentPageNumber()+1 : false;

        return $this->json([
            'posts' => $serializer->normalize(
                $posts->getItems(),
                context: ['groups' => ['post_index']],
            ),
            'next' => $next
        ]);
    }

    #[Route('/posts/{slug}', name: 'app_api_blog_post_show')]
    public function post_show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Post $post,
        SerializerInterface $serializer,
    ): JsonResponse
    {
        return $this->json(
            $serializer->normalize(
                $post,
                context: ['groups' => ['post_show']],
            ),
        );
    }

    #[Route('/categories/{slug}', name: 'app_api_blog_category_show')]
    public function category_show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Category $category,
        SerializerInterface $serializer,
        PaginatorInterface $paginator,
        Request $request,
        PostRepository $postRepository
    ): JsonResponse
    {
        $posts = $paginator->paginate(
            $postRepository->createQueryBuilder('p')
                ->innerJoin('p.categories', 'c' )
                ->where('c = :category')
                ->andWhere('p.status = :status')
                ->setParameter('category', $category)
                ->setParameter('status', 'published')
                ->orderBy('p.publishedAt', 'DESC'),
            $request->query->getInt('page', 1),
            $this->limit
        );

        $next = ($posts->getCurrentPageNumber() * $posts->getItemNumberPerPage() < $posts->getTotalItemCount()) ? $posts->getCurrentPageNumber()+1 : false;

        return $this->json([
            'category' => $serializer->normalize(
                $category,
                context: ['groups' => ['category_show']],
            ),
            'posts' => $serializer->normalize(
                $posts,
                context: ['groups' => ['post_index']],
            ),
            'next' => $next
        ]);
    }

    #[Route('/tags/{slug}', name: 'app_api_blog_tag_show')]
    public function tag_show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Tag $tag,
        SerializerInterface $serializer,
        PaginatorInterface $paginator,
        Request $request,
        PostRepository $postRepository
    ): JsonResponse
    {
        $posts = $paginator->paginate(
            $postRepository->createQueryBuilder('p')
                ->innerJoin('p.tags', 't' )
                ->where('t = :tag')
                ->andWhere('p.status = :status')
                ->setParameter('tag', $tag)
                ->setParameter('status', 'published')
                ->orderBy('p.publishedAt', 'DESC'),
            $request->query->getInt('page', 1),
            $this->limit
        );

        $next = ($posts->getCurrentPageNumber() * $posts->getItemNumberPerPage() < $posts->getTotalItemCount()) ? $posts->getCurrentPageNumber()+1 : false;

        return $this->json([
            'tag' => $serializer->normalize(
                $tag,
                context: ['groups' => ['tag_show']],
            ),
            'posts' => $serializer->normalize(
                $posts,
                context: ['groups' => ['post_index']],
            ),
            'next' => $next
        ]);
    }

    #[Route('/sitemap', name: 'app_api_blog_sitemap')]
    public function index(
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository
    ): JsonResponse
    {
        $locs = [];

        $posts = $postRepository->createQueryBuilder('p')
            ->select('p.slug', 'p.publishedAt', 'p.updatedAt')
            ->where('p.status = :status')
            ->setParameter('status', 'published')
            ->getQuery()
            ->getResult();

        $categories = $categoryRepository->createQueryBuilder('c')
            ->select('c.slug')
            ->innerJoin('c.posts', 'p')
            ->where('p.status = :status')
            ->groupBy('c')
            ->setParameter('status', 'published')
            ->getQuery()
            ->getResult();

        $tags = $tagRepository->createQueryBuilder('t')
            ->select('t.slug')
            ->innerJoin('t.posts', 'p')
            ->where('p.status = :status')
            ->groupBy('t')
            ->setParameter('status', 'published')
            ->getQuery()
            ->getResult();

        return $this->json([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }
}
