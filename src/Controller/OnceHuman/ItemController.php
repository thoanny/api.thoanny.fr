<?php

namespace App\Controller\OnceHuman;

use App\Entity\OnceHuman\Item;
use App\Repository\OnceHuman\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/once-human/items')]
class ItemController extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    #[Route(name: 'app_api_once_human_item_index', methods: ['GET'])]
    public function index(ItemRepository $itemRepository): JsonResponse
    {
        return $this->json(
            $this->serializer->normalize($itemRepository->findBy([], ['name' => 'ASC']), context: ['groups' => ['item_index']]),
        );
    }

    #[Route('/{id}', name: 'app_api_once_human_item_show', methods: ['GET'])]
    public function show(Item $item): JsonResponse
    {
        return $this->json([
            'item' => $this->serializer->normalize($item, context: ['groups' => ['item_show']]),
            'scenarios' => $this->serializer->normalize($item->getScenario(), context: ['groups' => ['item_show_scenario']]),
            'recipes' => $this->serializer->normalize($item->getRecipes(), context: ['groups' => ['item_show_recipe']]),
        ]);
    }
}
