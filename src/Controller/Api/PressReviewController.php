<?php

namespace App\Controller\Api;

use App\Entity\PressReview\Category;
use App\Repository\PressReview\CategoryRepository;
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
    public function category(Category $category, SerializerInterface $serializer): JsonResponse
    {
        return $this->json([
            'category' => $serializer->normalize(
                $category,
                context: ['groups' => ['category_show']],
            ),
        ]);
    }
}
