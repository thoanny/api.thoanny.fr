<?php

namespace App\Controller\Api\Enshrouded;

use App\Repository\Enshrouded\Recipe\CategoryRepository;
use App\Repository\Enshrouded\Recipe\RecipeRepository;
use App\Repository\Enshrouded\Recipe\SourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/enshrouded/recipes')]
final class RecipeController extends AbstractController
{
    #[Route('/', name: 'app_api_enshrouded_recipes', methods: ['GET'])]
    public function appApiEnshroudedRecipes(
        SerializerInterface $serializer,
        CategoryRepository $recipeCategoryRepository,
    ): JsonResponse
    {
        $recipes = $recipeCategoryRepository->findBy([], ['root' => 'ASC', 'lft' => 'ASC']);
        return new JsonResponse($serializer->serialize($recipes, 'json', ['groups' => ['recipes']]), 200, [], true);
    }

    #[Route('/sources', name: 'app_api_enshrouded_recipes_sources', methods: ['GET'])]
    public function appApiEnshroudedRecipesSources(
        SerializerInterface $serializer,
        SourceRepository $recipeSourceRepository
    ): JsonResponse
    {
        $sources = $recipeSourceRepository->findAll();
        return new JsonResponse($serializer->serialize($sources, 'json', ['groups' => ['recipes_sources']]), 200, [], true);
    }

    #[Route('/{id}', name: 'app_api_enshrouded_recipe', methods: ['GET'])]
    public function appApiEnsourdedRecipe($id, RecipeRepository $recipeRepository, SerializerInterface $serializer): JsonResponse {
        $recipe = $recipeRepository->findOneBy(['id'=>$id]);
        return new JsonResponse($serializer->serialize($recipe, 'json', ['groups' => ['recipe']]), 200, [], true);
    }
}
