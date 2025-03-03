<?php

namespace App\Controller\Api;

use App\Entity\PressReview\Category;
use App\Repository\PressReview\CategoryRepository;
use App\Repository\PressReview\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/{id}.{_format}', name: 'app_api_press_review_category', format: 'json')]
    public function category(Category $category, PostRepository $postRepository, SerializerInterface $serializer, Request $request): JsonResponse|Response
    {

        if($request->getRequestFormat() === 'xml') {
            return $this->render('press_review/category.xml.twig', [
                'category' => $category,
                'posts' => $postRepository->findForRSSFeed($category)
            ]);
        }

        return $this->json($serializer->normalize(
            $category,
            context: ['groups' => ['category_show']],
        ));
    }
}
