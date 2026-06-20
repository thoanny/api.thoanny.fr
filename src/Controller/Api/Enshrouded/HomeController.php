<?php

namespace App\Controller\Api\Enshrouded;

use App\Repository\Enshrouded\Item\ItemRepository;
use App\Repository\Enshrouded\Recipe\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/enshrouded', name: 'app_api_enshrouded_home')]
    public function index(ItemRepository $itemRepository, RecipeRepository $recipeRepository): JsonResponse
    {
        return $this->json([
            'items' => $itemRepository->getItemsCount(),
            'recipes' => $recipeRepository->getRecipesCount(),
        ]);
    }
}
