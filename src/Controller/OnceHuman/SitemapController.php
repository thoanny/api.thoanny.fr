<?php

namespace App\Controller\OnceHuman;

use App\Repository\OnceHuman\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class SitemapController extends AbstractController
{
    #[Route('/once-human/sitemap', name: 'app_api_once_human_sitemap')]
    public function index(ItemRepository $itemRepository): JsonResponse
    {
        $locs = [];

        // Items
        foreach ($itemRepository->findAll() as $item) {
            $locs[] = ['loc' => "/items/{$item->getId()}"];
        }

        return $this->json($locs);
    }
}
