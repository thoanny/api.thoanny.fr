<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('page/home.html.twig');
    }

    #[Route('/legal-notice', name: 'app_legal_notice')]
    public function legalNotice(): Response
    {
        // https://fr.orson.io
        return $this->render('page/legal-notice.html.twig');
    }
}
