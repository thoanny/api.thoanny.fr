<?php

namespace App\Controller\OnceHuman;

use App\Repository\OnceHuman\ServerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/once-human/servers')]
class ServerController extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    #[Route(name: 'app_api_once_human_server_index', methods: ['GET'])]
    public function index(ServerRepository $serverRepository): JsonResponse
    {
        return $this->json([
            'servers' => $this->serializer->normalize($serverRepository->findAllForAPI(), context: ['groups' => ['server_index']]),
        ]);
    }

    #[Route('/{slug}', name: 'app_api_once_human_server_show', methods: ['GET'])]
    public function show($slug, ServerRepository $serverRepository): JsonResponse
    {
        $server = $serverRepository->findOneBy(['slug' => $slug]);
        if(!$server) {
            throw new NotFoundHttpException();
        }
        return $this->json([
            'server' => $this->serializer->normalize($server, context: ['groups' => ['server_show']]),
            'scenario' => $this->serializer->normalize($server->getScenario(), context: ['groups' => ['server_show_scenario']]),
        ]);
    }
}
