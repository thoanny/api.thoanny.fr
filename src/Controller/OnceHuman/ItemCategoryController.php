<?php

namespace App\Controller\OnceHuman;

use App\Repository\OnceHuman\ItemCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ItemCategoryController extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    #[Route('/once-human/items-categories', name: 'app_api_once_human_item_category_index', methods: ['GET'])]
    public function index(ItemCategoryRepository $categoryRepository): JsonResponse
    {
        return $this->json(
            [
                'categories' => $this->serializer->normalize($categoryRepository->findAll(), null, ['groups' => ['category_index']]),
            ]
        );
    }
}
