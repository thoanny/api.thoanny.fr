<?php

namespace App\Controller\OnceHuman;

use App\Repository\OnceHuman\SpecializationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/once-human/specializations')]
class SpecializationController extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    #[Route(name: 'app_api_once_human_specialization_index', methods: ['GET'])]
    public function index(SpecializationRepository $specializationRepository): JsonResponse
    {
        return $this->json([
            'specializations' => $this->serializer->normalize(
                $specializationRepository->findBy([], ['name' => 'ASC']),
                context: ['groups' => ['specialization_index']]
            )
        ]);
    }
}
