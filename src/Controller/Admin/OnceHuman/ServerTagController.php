<?php

namespace App\Controller\Admin\OnceHuman;

use App\Entity\OnceHuman\ServerTag;
use App\Form\Admin\OnceHuman\ServerTagType;
use App\Repository\OnceHuman\ServerTagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/once-human/servers-tags')]
final class ServerTagController extends AbstractController
{
    #[Route(name: 'app_admin_once_human_server_tag_index', methods: ['GET'])]
    public function index(ServerTagRepository $serverTagRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $serverTags = $paginator->paginate(
            $serverTagRepository->findAll(),
            $request->query->getInt('page', 1),
            50
        );
        return $this->render('admin/once_human/server_tag/index.html.twig', [
            'server_tags' => $serverTags,
        ]);
    }

    #[Route('/new', name: 'app_admin_once_human_server_tag_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $serverTag = new ServerTag();
        $form = $this->createForm(ServerTagType::class, $serverTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($serverTag);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_server_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/server_tag/new.html.twig', [
            'server_tag' => $serverTag,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_server_tag_show', methods: ['GET'])]
    public function show(ServerTag $serverTag): Response
    {
        return $this->render('admin/once_human/server_tag/show.html.twig', [
            'server_tag' => $serverTag,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_once_human_server_tag_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServerTag $serverTag, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServerTagType::class, $serverTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_server_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/server_tag/edit.html.twig', [
            'server_tag' => $serverTag,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_server_tag_delete', methods: ['POST'])]
    #[IsGranted(['ROLE_ADMIN'])]
    public function delete(Request $request, ServerTag $serverTag, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serverTag->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($serverTag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_once_human_server_tag_index', [], Response::HTTP_SEE_OTHER);
    }
}
