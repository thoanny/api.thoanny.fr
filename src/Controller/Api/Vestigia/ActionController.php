<?php

namespace App\Controller\Api\Vestigia;

use App\Repository\Vestigia\AccountRepository;
use App\Repository\Vestigia\ItemRepository;
use App\Service\Api;
use App\Service\VestigiaInventory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[IsGranted('ROLE_USER')]
#[Route('/vestigia/actions')]
final class ActionController extends AbstractController
{
    /**
     * Appelé lorsque l'utilisateur fait l'action d'ouvrir un objet avec une table de loots
     * @param ItemRepository $itemRepository
     * @param AccountRepository $accountRepository
     * @param Api $api
     * @param Request $request
     * @param VestigiaInventory $vestigiaInventory
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/open', name: 'app_api_vestigia_action_open', methods: ['POST'])]
    public function open(
        ItemRepository $itemRepository,
        AccountRepository $accountRepository,
        Api $api,
        Request $request,
        VestigiaInventory $vestigiaInventory,
        SerializerInterface $serializer,
    ): JsonResponse
    {
        $user = $this->getUser();
        $account = $accountRepository->findOneBy(['user' => $user]);
        if(!$account) {
            return $api->createNotFoundException('Account not found');
        }

        try {
            $request = $api->transformJsonBody($request);
            $itemId = $request->get('itemId');
            $item = $itemRepository->findOneBy(['id' => $itemId]);

            $loots = [];
            foreach ($item->getLoots() as $entry) {
                if ($entry->getChance() === 100 || ($entry->getChance() < 100 && random_int(1, 100) <= $entry->getChance())) {
                    $quantity = $entry->getMin() === $entry->getMax()
                        ? $entry->getMin()
                        : random_int($entry->getMin(), $entry->getMax());
                    $vestigiaInventory->addITem($quantity, $entry->getRewardItem(), $account);
                    $loots[] = [
                        'item' => $serializer->normalize($entry->getRewardItem(), context: ['groups' => ['loot']]),
                        'quantity' => $quantity
                    ];
                }
            }
            $vestigiaInventory->removeItem(1, $item, $account);
            return $this->json($loots);
        } catch (\Exception) {
            return $api->createBadRequestException();
        }
    }

    /**
     * Appelé lorsque l'utilisateur fait l'action de consommer un objet avec une table de ressources
     * Les ressources sont liées aux caractéristiques du personnage
     * @return JsonResponse
     */
    #[Route('/consume', name: 'app_api_vestigia_action_consume', methods: ['POST'])]
    public function consume(): JsonResponse
    {
        // TODO
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Api/Vestigia/ActionController.php',
        ]);
    }
}
