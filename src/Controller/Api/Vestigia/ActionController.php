<?php

namespace App\Controller\Api\Vestigia;

use App\Repository\Vestigia\ItemRepository;
use App\Service\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/vestigia/actions')]
final class ActionController extends AbstractController
{
    /**
     * Appelé lorsque l'utilisateur fait l'action d'ouvrir un objet avec une table de loots
     * @return JsonResponse
     */
    #[Route('/open', name: 'app_api_vestigia_action_open', methods: ['POST'])]
    public function open(ItemRepository $itemRepository, Api $api, Request $request): JsonResponse
    {
        $request = $api->transformJsonBody($request);
        $itemId = $request->get('itemId');
        $item = $itemRepository->findOneBy(['id' => $itemId]);

        dd($item);

        // TODO : se baser sur l'inventaire du joueur !
        // TODO : Faire le tirage au sort

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Api/Vestigia/ActionController.php',
        ]);
    }

    /**
     * Appelé lorsque l'utilisateur fait l'action de consommer un objet avec une table de ressources
     * Les ressources sont liées aux caractéristiques du personnage
     * @return JsonResponse
     */
    #[Route('/consume', name: 'app_api_vestigia_action_consume', methods: ['POST'])]
    public function consume(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Api/Vestigia/ActionController.php',
        ]);
    }
}
