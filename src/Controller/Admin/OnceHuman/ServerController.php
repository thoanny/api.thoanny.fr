<?php

namespace App\Controller\Admin\OnceHuman;

use App\Entity\OnceHuman\Server;
use App\Form\Admin\OnceHuman\ServerType;
use App\Repository\OnceHuman\ServerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/once-human/servers')]
final class ServerController extends AbstractController
{
    #[Route(name: 'app_admin_once_human_server_index', methods: ['GET'])]
    public function index(ServerRepository $serverRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $servers = $paginator->paginate(
            $serverRepository->findAll(),
            $request->query->getInt('page', 1),
            50
        );

        return $this->render('admin/once_human/server/index.html.twig', [
            'servers' => $servers,
        ]);
    }

    #[Route('/new', name: 'app_admin_once_human_server_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $server = new Server();
        $form = $this->createForm(ServerType::class, $server);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($server);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_server_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/server/new.html.twig', [
            'server' => $server,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_server_show', methods: ['GET'])]
    public function show(Server $server): Response
    {
        return $this->render('admin/once_human/server/show.html.twig', [
            'server' => $server,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_once_human_server_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Server $server, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServerType::class, $server);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_server_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/server/edit.html.twig', [
            'server' => $server,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_server_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Server $server, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$server->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($server);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_once_human_server_index', [], Response::HTTP_SEE_OTHER);
    }
}
