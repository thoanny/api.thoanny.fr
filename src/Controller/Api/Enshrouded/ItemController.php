<?php

namespace App\Controller\Api\Enshrouded;

use App\Repository\Enshrouded\Item\CategoryRepository;
use App\Repository\Enshrouded\Item\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/enshrouded/items')]
final class ItemController extends AbstractController
{
    #[Route('/', name: 'app_api_enshrouded_items', methods: ['GET'])]
    public function appApiEnshroudedItems(SerializerInterface $serializer, ItemRepository $itemRepository): JsonResponse
    {
        $items = $itemRepository->findby([], ['name' => 'ASC']);
        return new JsonResponse($serializer->serialize($items, 'json', ['groups' => ['items']]), 200, [], true);
    }

    #[Route('/categories', name: 'app_api_enshrouded_items_categories', methods: ['GET'])]
    public function appApiEnshroudedItemsCategories(SerializerInterface $serializer, CategoryRepository $categoryRepository): JsonResponse
    {
        $categories = $categoryRepository->findBy([], ['name' => 'ASC']);
        return new JsonResponse($serializer->serialize($categories, 'json', ['groups' => ['categories']]), 200, [], true);
    }

    #[Route('/{id}', name: 'app_api_enshrouded_item', methods: ['GET'])]
    public function appApiEnshroudedItem($id, SerializerInterface $serializer, ItemRepository $itemRepository): JsonResponse
    {
        $item = $itemRepository->findOneBy(['id' => $id]);
        return new JsonResponse($serializer->serialize($item, 'json', ['groups' => ['item']]), 200, [], true);
    }
}
