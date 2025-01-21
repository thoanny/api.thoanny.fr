<?php

namespace App\Controller\Admin\OnceHuman;

use App\Entity\OnceHuman\Specialization;
use App\Form\Admin\OnceHuman\SpecializationType;
use App\Repository\OnceHuman\SpecializationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/once-human/specializations')]
final class SpecializationController extends AbstractController
{
    #[Route(name: 'app_admin_once_human_specialization_index', methods: ['GET'])]
    public function index(SpecializationRepository $specializationRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $specializations = $paginator->paginate(
            $specializationRepository->findAll(),
            $request->query->getInt('page', 1),
            50
        );
        return $this->render('admin/once_human/specialization/index.html.twig', [
            'specializations' => $specializations,
        ]);
    }

    #[Route('/new', name: 'app_admin_once_human_specialization_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $specialization = new Specialization();
        $form = $this->createForm(SpecializationType::class, $specialization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($specialization);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_specialization_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/specialization/new.html.twig', [
            'specialization' => $specialization,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_specialization_show', methods: ['GET'])]
    public function show(Specialization $specialization): Response
    {
        return $this->render('admin/once_human/specialization/show.html.twig', [
            'specialization' => $specialization,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_once_human_specialization_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Specialization $specialization, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpecializationType::class, $specialization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_specialization_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/specialization/edit.html.twig', [
            'specialization' => $specialization,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_specialization_delete', methods: ['POST'])]
    #[IsGranted(['ROLE_ADMIN'])]
    public function delete(Request $request, Specialization $specialization, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specialization->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($specialization);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_once_human_specialization_index', [], Response::HTTP_SEE_OTHER);
    }
}
