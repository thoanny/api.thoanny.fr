<?php

namespace App\Controller\OnceHuman;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/once-human', name: 'app_api_once_human_index')]
    public function index(): JsonResponse
    {
        return $this->json([
            'routes' => [
                $this->generateUrl('app_api_once_human_item_index'),
                $this->generateUrl('app_api_once_human_item_show', ['id' => ':id']),
                $this->generateUrl('app_api_once_human_item_category_index'),
                $this->generateUrl('app_api_once_human_recipe_index'),
                $this->generateUrl('app_api_once_human_recipe_show', ['id' => ':id']),
                $this->generateUrl('app_api_once_human_scenario_index'),
                $this->generateUrl('app_api_once_human_scenario_show', ['id' => ':id']),
                $this->generateUrl('app_api_once_human_server_index'),
                $this->generateUrl('app_api_once_human_server_show', ['id' => ':id']),
            ]
        ]);
    }
}
