<?php

namespace App\Controller\OnceHuman\User;

use App\Entity\OnceHuman\Character;
use App\Repository\OnceHuman\CharacterRepository;
use App\Repository\OnceHuman\ServerRepository;
use App\Service\Api;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/once-human/user/characters')]
#[IsGranted('ROLE_USER')]
final class CharacterController extends AbstractController
{
    #[Route(name: 'app_api_once_human_user_character_index', methods: ['GET'])]
    public function index(CharacterRepository $characterRepository, SerializerInterface $serializer): JsonResponse
    {
        return $this->json($serializer->normalize(
            $characterRepository->findBy(['user' => $this->getUser()]),
            context: ['groups' => ['user_character_index']],
        ));
    }

    #[Route('/new', name: 'app_api_once_human_user_character_new', methods: ['POST'])]
    public function new(
        CharacterRepository $characterRepository,
        ServerRepository $serverRepository,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        Api $api,
        Request $request
    ): JsonResponse
    {
        $user = $this->getUser();

        $limit = 1;
        if($user->isMember()) {
            $limit = 3;
        }

        $userCharacters = $characterRepository->findBy(['user' => $user]);
        if(count($userCharacters) >= $limit) {
            return $api->createForbiddenException('Limite de personnages atteinte.');
        }

        $data = json_decode($request->getContent());

        $server = null;
        if($data->server) {
            $server = $serverRepository->findOneBy(['id' => $data->server]);
        }

        $character = (new Character())
            ->setServer($server)
            ->setUser($user)
            ->setName($data->name)
            ->setStatus( in_array($data->status, ['private', 'hidden', 'public']) ? $data->status : 'private' )
            ->setDiscordUid($data->discord ?? null)
            ->setIngameUid($data->ingame ?? null)
        ;

        $entityManager->persist($character);
        $entityManager->flush();

        return $this->json($serializer->normalize(
            $characterRepository->findBy(['user' => $user]),
            context: ['groups' => ['user_character_index']],
        ));
    }

    #[Route('/edit/{id}', name: 'app_api_once_human_user_character_edit', methods: ['POST'])]
    public function edit(
        Character $character,
        CharacterRepository $characterRepository,
        ServerRepository $serverRepository,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        Api $api,
        Request $request
    ): JsonResponse
    {
        $user = $this->getUser();

        if($user !== $character->getUser()) {
            return $api->createForbiddenException('Impossible de modifier ce personnage.');
        }

        $data = json_decode($request->getContent());

        $server = null;
        if($data->server) {
            $server = $serverRepository->findOneBy(['id' => $data->server]);
        }

        $character
            ->setServer($server)
            ->setName($data->name)
            ->setStatus( in_array($data->status, ['private', 'hidden', 'public']) ? $data->status : 'private' )
            ->setDiscordUid($data->discord ?? null)
            ->setIngameUid($data->ingame ?? null)
        ;

        $entityManager->persist($character);
        $entityManager->flush();

        return $this->json($serializer->normalize(
            $characterRepository->findBy(['user' => $user]),
            context: ['groups' => ['user_character_index']],
        ));
    }

    #[Route('/delete/{id}', name: 'app_api_once_human_user_character_delete', methods: ['DELETE'])]
    public function delete(
        Character $character,
        CharacterRepository $characterRepository,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        Api $api,
    ): JsonResponse
    {
        $user = $this->getUser();

        if($character->getUser() !== $user) {
            return $api->createForbiddenException('Impossible de supprimer ce personnage.');
        }

        $entityManager->remove($character);
        $entityManager->flush();

        return $this->json($serializer->normalize(
            $characterRepository->findBy(['user' => $user]),
            context: ['groups' => ['user_character_index']],
        ));
    }
}
