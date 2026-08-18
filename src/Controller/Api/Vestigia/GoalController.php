<?php

namespace App\Controller\Api\Vestigia;

use App\Repository\Vestigia\GoalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/vestigia/goals')]
final class GoalController extends AbstractController
{
    #[Route('/', name: 'app_api_vestigia_goals')]
    public function index(GoalRepository $goalRepository, SerializerInterface $serializer): JsonResponse
    {
        $goals = $goalRepository->findAll();
        return $this->json($serializer->normalize($goals, context: ['groups' => ['goals']]));
    }
}
