<?php

namespace App\Controller\OnceHuman;

use App\Entity\OnceHuman\Event;
use App\Repository\OnceHuman\EventRepository;
use App\Service\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/once-human/events')]
final class EventController extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    #[Route(name: 'app_api_once_human_event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository): JsonResponse
    {
        return $this->json([
            'events' => $this->serializer->normalize(
                $eventRepository->findCurrentEvents(),
                context: ['groups' => ['event_index']],
            )
        ]);
    }
}
