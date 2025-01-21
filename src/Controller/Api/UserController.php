<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    #[Route('/@me', name: 'app_api_user', methods: ['GET'])]
    #[IsGranted("ROLE_USER")]
    public function index(SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            data: $serializer->serialize($this->getUser(), 'json', ['groups' => 'api']),
            json: true
        );
    }
}
