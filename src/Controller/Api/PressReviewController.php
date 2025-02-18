<?php

namespace App\Controller\Api;

use App\Entity\PressReview\Category;
use App\Entity\PressReview\Issue;
use App\Repository\PressReview\CategoryRepository;
use App\Repository\PressReview\IssueRepository;
use App\Repository\PressReview\PostRepository;
use App\Service\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/press-reviews')]
final class PressReviewController extends AbstractController
{
    #[Route(name: 'app_api_press_review_index')]
    public function index(CategoryRepository $categoryRepository, SerializerInterface $serializer): JsonResponse
    {
        return $this->json(
            $serializer->normalize(
                $categoryRepository->findAll(),
                context: ['groups' => ['category_index']],
            )
        );
    }

    #[Route('/categories/{id}', name: 'app_api_press_review_category')]
    public function category(Category $category, CategoryRepository $categoryRepository, IssueRepository $issueRepository, SerializerInterface $serializer): JsonResponse
    {
        return $this->json([
            'category' => $serializer->normalize(
                $category,
                context: ['groups' => ['category_show']],
            ),
            'issues' => $serializer->normalize(
                $issueRepository->findPublishedByCategory($category),
                context: ['groups' => ['category_show_issues']],
            )
        ]);
    }

    #[Route('/issues/{id}', name: 'app_api_press_review_issue')]
    public function issue(Issue $issue, PostRepository $postRepository, SerializerInterface $serializer, Api $api): JsonResponse
    {
        if(!$issue->getPublishedAt()) {
            return $api->createNotFoundException('Édition introuvable');
        }

        return $this->json([
            'issue' => $serializer->normalize(
                $issue,
                context: ['groups' => ['issue_show']],
            ),
            'posts' => $serializer->normalize(
                $postRepository->findReviewedByIssue($issue),
                context: ['groups' => ['issue_show_posts']],
            ),
        ]);
    }
}
