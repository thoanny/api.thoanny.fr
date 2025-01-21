<?php

namespace App\Controller\OnceHuman;

use App\Repository\OnceHuman\MemeticRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/once-human/memetics')]
class MemeticController extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    #[Route(name: 'app_api_once_human_memetic_index', methods: ['GET'])]
    public function index(MemeticRepository $memeticRepository): JsonResponse
    {
        return $this->json([
            'memetics' => $this->serializer->normalize(
                $memeticRepository->findAll(),
                context: ['groups' => ['memetic_index']]
            )
        ]);
    }
}
