<?php

namespace App\Controller\OnceHuman;

use App\Repository\OnceHuman\CharacterRepository;
use App\Repository\OnceHuman\HiveRepository;
use App\Repository\OnceHuman\ItemRepository;
use App\Repository\OnceHuman\RecipeRepository;
use App\Repository\OnceHuman\ServerRepository;
use App\Repository\OnceHuman\SpecializationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class StatController extends AbstractController
{
    #[Route('/once-human/stats', name: 'app_once_human_stat')]
    public function index(
        CharacterRepository $characterRepository,
        HiveRepository $hiveRepository,
        ItemRepository $itemRepository,
        RecipeRepository $recipeRepository,
        ServerRepository $serverRepository,
        SpecializationRepository $specializationRepository
    ): JsonResponse
    {
        return $this->json([
            'characters' => $characterRepository->getCount(),
            'hives' => $hiveRepository->getCount(),
            'items' => $itemRepository->getCount(),
            'recipes' => $recipeRepository->getCount(),
            'servers' => $serverRepository->getCount(),
            'specializations' => $specializationRepository->getCount(),
        ]);
    }
}
