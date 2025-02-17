<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

final class UidController extends AbstractController
{
    #[Route('/uid', name: 'app_uid')]
    public function index(): JsonResponse
    {

        $namespace = Uuid::fromString(Uuid::NAMESPACE_URL);


        return $this->json(
            [
                'tides' => [
                    Uuid::v3($namespace, 'https://www.gamekult.com/actualite/tides-of-annihilation-le-jeu-d-action-chinois-se-presente-en-detail-3050862185.html'),
                ],
                'psspam' => [
                    Uuid::v3($namespace, 'https://gamergen.com/actualites/playstation-fait-enfin-grand-menage-jeux-spams-338820-1'),
                ]
            ]
        );
    }
}
