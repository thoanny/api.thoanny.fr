<?php

namespace App\Controller\Api\Vestigia;

use App\Repository\Vestigia\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/vestigia/items')]
final class ItemController extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    #[Route('/', name: 'app_api_vestigia_items')]
    public function index(ItemRepository $itemRepository): JsonResponse
    {
        $items = $itemRepository->findAll();
        return new JsonResponse(
            $this->serializer->serialize($items, 'json', ['groups' => ['items']]),
            json: true
        );
    }
}
