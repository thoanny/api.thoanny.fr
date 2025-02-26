<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

final class UidController extends AbstractController
{
    #[Route('/uid', name: 'app_api_uid')]
    public function index(): JsonResponse
    {
        return $this->json(Uuid::v7()->toBase58());
    }
}
