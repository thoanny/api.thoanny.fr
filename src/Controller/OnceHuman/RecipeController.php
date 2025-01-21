<?php

namespace App\Controller\OnceHuman;

use App\Entity\OnceHuman\Recipe;
use App\Repository\OnceHuman\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/once-human/recipes')]
class RecipeController extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    #[Route(name: 'app_api_once_human_recipe_index')]
    public function index(RecipeRepository $recipeRepository): JsonResponse
    {
        return $this->json(
            [
                'recipes' => $this->serializer->normalize($recipeRepository->findAll(), context: ['groups' => ['recipe_index']]),
            ]
        );
    }

    #[Route('/{id}', name: 'app_api_once_human_recipe_show', methods: ['GET'])]
    public function show(Recipe $recipe): JsonResponse
    {
        return $this->json([
            'recipe' => $this->serializer->normalize($recipe, context: ['groups' => ['recipe_show']]),
            'ingredients' => $this->serializer->normalize($recipe->getIngredients(), context: ['groups' => ['recipe_show_ingredient']]),
        ]);
    }
}
