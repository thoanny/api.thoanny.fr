<?php

namespace App\Controller\Api\Vestigia;

use App\Repository\Vestigia\AccountGoalRepository;
use App\Repository\Vestigia\AccountRepository;
use App\Repository\Vestigia\CharacterRepository;
use App\Repository\Vestigia\InventoryItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/vestigia')]
final class UserController extends AbstractController
{
    #[Route('/@me', name: 'app_api_vestigia_user')]
    #[IsGranted("ROLE_USER")]
    public function user(
        AccountRepository $accountRepository,
        AccountGoalRepository $accountGoalRepository,
        InventoryItemRepository $inventoryItemRepository,
        CharacterRepository $characterRepository,
        SerializerInterface $serializer
    ): JsonResponse
    {
        $user = $this->getUser();
        $account = $accountRepository->findOneBy(['user' => $user]);

        $goals = $accountGoalRepository->findBy(['account' => $account]);
        $inventory = $inventoryItemRepository->findBy(['account' => $account]);
        $currentCharacter = $characterRepository->findOneBy(['account' => $account, 'dead' => false]);

        return new JsonResponse([
            'account' => $serializer->normalize($account, context: ['groups' => ['me']]),
            'goals' => $goals ? $serializer->normalize($goals, context: ['groups' => ['me']]) : null,
            'inventory' => $inventory ? $serializer->normalize($inventory, context: ['groups' => ['me']]) : null,
            'character' => $serializer->normalize($currentCharacter, context: ['groups' => ['me']]),
        ]);
    }
}
