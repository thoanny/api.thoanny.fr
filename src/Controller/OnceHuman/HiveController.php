<?php

namespace App\Controller\OnceHuman;

use App\Entity\OnceHuman\Hive;
use App\Repository\OnceHuman\HiveRepository;
use App\Service\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/once-human/hives')]
class HiveController extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer, private readonly Api $api)
    {
    }

    #[Route(name: 'app_api_once_human_hive_index', methods: ['GET'])]
    public function index(HiveRepository $hiveRepository): JsonResponse
    {
        return $this->json([
            'hives' => $this->serializer->normalize(
                $hiveRepository->findBy(['status' => 'public']),
                context: ['groups' => ['hive_index']],
            )
        ]);
    }

    #[Route('/{id}', name: 'app_api_once_human_hive_show', methods: ['GET'])]
    public function show(Hive $hive): JsonResponse
    {
        // TODO : Gérer les accès par droits
        if('public' !== $hive->getStatus()) {
            return $this->api->createForbiddenException();
        }

        $members = [];

        foreach($hive->getMembers() as $member) {
            switch($member->getStatus()) {
                case 'public':
                    $members[] = [
                        'id' => $member->getId(),
                        'name' => $member->getName()
                    ];
                    break;
                // TODO : Gérer les accès par droits
                case 'hidden':
                    $members[] = [
                        'id' => $member->getId(),
                        'name' => str_repeat('*', strlen($member->getName()))
                    ];
                    break;
                default: // private
                    $members[] = [
                        'id' => $member->getId(),
                        'name' => str_pad(substr($member->getName(), 0, 2), strlen($member->getName())-3, '*').substr($member->getName(), -1)
                    ];
                    break;
            }
        }

        return $this->json([
            'hive' => $this->serializer->normalize($hive, context: ['groups' => ['hive_show']]),
            'members' => $members,
        ]);
    }
}
