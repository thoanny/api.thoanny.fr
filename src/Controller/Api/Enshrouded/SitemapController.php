<?php

namespace App\Controller\Api\Enshrouded;

use App\Repository\Enshrouded\Item\ItemRepository;
use App\Repository\Enshrouded\Recipe\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class SitemapController extends AbstractController
{
    #[Route('/enshrouded/sitemap', name: 'app_api_enshrouded_sitemap', methods: ['GET'])]
    public function appApiEnshroudedSitemap(ItemRepository $itemRepository, RecipeRepository $recipeRepository): JsonResponse
    {
        $sitemap = [];

        $items = $itemRepository->getItemsId();
        foreach($items as $item) {
            $sitemap[] = ["loc" => "/items/{$item['id']}"];
        }

        $recipes = $recipeRepository->getItemsId();
        foreach($recipes as $recipe) {
            $sitemap[] = ["loc" => "/recipes/{$recipe['id']}"];
        }

        return $this->json($sitemap);
    }
}
