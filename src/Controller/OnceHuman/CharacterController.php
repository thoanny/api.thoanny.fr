<?php

namespace App\Controller\OnceHuman;

use App\Repository\OnceHuman\CharacterRepository;
use App\Service\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/once-human/characters')]
class CharacterController extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer, private readonly Api $api)
    {
    }

    #[Route(name: 'app_api_once_human_character_index', methods: ['GET'])]
    public function index(CharacterRepository $characterRepository): JsonResponse
    {
        return $this->json([
            'characters' => $this->serializer->normalize(
                $characterRepository->findBy(['status' => 'public']),
                context: ['groups' => ['character_index']],
            )
        ]);
    }

    #[Route('/{token}', name: 'app_api_once_human_character_show', methods: ['GET'])]
    public function show($token, CharacterRepository $characterRepository): JsonResponse
    {
        $character = $characterRepository->findOneBy(['token' => $token]);
        if(!$character) {
            return $this->api->createNotFoundException('Personnage introuvable');
        }
        // TODO : Gérer les accès par droits
        if('public' !== $character->getStatus()) {
            return $this->api->createForbiddenException();
        }

        return $this->json([
            'character' => $this->serializer->normalize($character, context: ['groups' => ['character_show']]),
        ]);
    }
}
