<?php

namespace App\Controller\Admin\OnceHuman;

use App\Entity\OnceHuman\Memetic;
use App\Form\Admin\OnceHuman\MemeticType;
use App\Repository\OnceHuman\MemeticRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/once-human/memetics')]
final class MemeticController extends AbstractController
{
    #[Route(name: 'app_admin_once_human_memetic_index', methods: ['GET'])]
    public function index(MemeticRepository $memeticRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $memetics = $paginator->paginate(
            $memeticRepository->findBy([], ['name' => 'ASC']),
            $request->query->getInt('page', 1),
            50
        );
        return $this->render('admin/once_human/memetic/index.html.twig', [
            'memetics' => $memetics,
        ]);
    }

    #[Route('/new', name: 'app_admin_once_human_memetic_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $memetic = new Memetic();
        $form = $this->createForm(MemeticType::class, $memetic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($memetic);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_memetic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/memetic/new.html.twig', [
            'memetic' => $memetic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_memetic_show', methods: ['GET'])]
    public function show(Memetic $memetic): Response
    {
        return $this->render('admin/once_human/memetic/show.html.twig', [
            'memetic' => $memetic,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_once_human_memetic_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Memetic $memetic, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MemeticType::class, $memetic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_memetic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/memetic/edit.html.twig', [
            'memetic' => $memetic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_memetic_delete', methods: ['POST'])]
    public function delete(Request $request, Memetic $memetic, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$memetic->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($memetic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_once_human_memetic_index', [], Response::HTTP_SEE_OTHER);
    }
}
