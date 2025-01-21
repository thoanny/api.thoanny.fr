<?php

namespace App\Controller\Admin\OnceHuman;

use App\Entity\OnceHuman\SpecializationGroup;
use App\Form\Admin\OnceHuman\SpecializationGroupType;
use App\Repository\OnceHuman\SpecializationGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/once-human/specializations-groups')]
final class SpecializationGroupController extends AbstractController
{
    #[Route(name: 'app_admin_once_human_specialization_group_index', methods: ['GET'])]
    public function index(SpecializationGroupRepository $specializationGroupRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $groups = $paginator->paginate(
            $specializationGroupRepository->findAll(),
            $request->query->getInt('page', 1),
            50
        );
        return $this->render('admin/once_human/specialization_group/index.html.twig', [
            'specialization_groups' => $groups,
        ]);
    }

    #[Route('/new', name: 'app_admin_once_human_specialization_group_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $specializationGroup = new SpecializationGroup();
        $form = $this->createForm(SpecializationGroupType::class, $specializationGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($specializationGroup);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_specialization_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/specialization_group/new.html.twig', [
            'specialization_group' => $specializationGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_specialization_group_show', methods: ['GET'])]
    public function show(SpecializationGroup $specializationGroup): Response
    {
        return $this->render('admin/once_human/specialization_group/show.html.twig', [
            'specialization_group' => $specializationGroup,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_once_human_specialization_group_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SpecializationGroup $specializationGroup, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpecializationGroupType::class, $specializationGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_specialization_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/specialization_group/edit.html.twig', [
            'specialization_group' => $specializationGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_specialization_group_delete', methods: ['POST'])]
    public function delete(Request $request, SpecializationGroup $specializationGroup, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specializationGroup->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($specializationGroup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_once_human_specialization_group_index', [], Response::HTTP_SEE_OTHER);
    }
}
