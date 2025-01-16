<?php

namespace App\Controller\OnceHuman;

use App\Entity\OnceHuman\Scenario;
use App\Repository\OnceHuman\ScenarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/once-human/scenarios')]
class ScenarioController extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    #[Route(name: 'app_api_once_human_scenario_index', methods: ['GET'])]
    public function index(ScenarioRepository $scenarioRepository): JsonResponse
    {
        return $this->json([
            'scenarios' => $this->serializer->normalize($scenarioRepository->findAll(), context: ['groups' => ['scenario_index']]),
        ]);
    }

    #[Route('/{id}', name: 'app_api_once_human_scenario_show', methods: ['GET'])]
    public function show(Scenario $scenario): JsonResponse
    {
        return $this->json([
            'scenario' => $this->serializer->normalize($scenario, context: ['groups' => ['scenario_show']]),
            'servers' => $this->serializer->normalize($scenario->getServers(), context: ['groups' => ['scenario_show_server']]),
        ]);
    }
}
