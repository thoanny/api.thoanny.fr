<?php

namespace App\Controller\Admin;

use App\Entity\Membership;
use App\Form\Admin\MembershipType;
use App\Repository\MembershipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/memberships')]
final class MembershipController extends AbstractController
{
    #[Route(name: 'app_admin_membership_index', methods: ['GET'])]
    public function index(MembershipRepository $membershipRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $memberships = $paginator->paginate(
            $membershipRepository->findAll(),
            $request->query->getInt('page', 1),
            50
        );

        return $this->render('admin/membership/index.html.twig', [
            'memberships' => $memberships,
        ]);
    }

    #[Route('/new', name: 'app_admin_membership_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $membership = new Membership();
        $form = $this->createForm(MembershipType::class, $membership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($membership);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_membership_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/membership/new.html.twig', [
            'membership' => $membership,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_membership_show', methods: ['GET'])]
    public function show(Membership $membership): Response
    {
        return $this->render('admin/membership/show.html.twig', [
            'membership' => $membership,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_membership_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Membership $membership, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MembershipType::class, $membership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_membership_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/membership/edit.html.twig', [
            'membership' => $membership,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_membership_delete', methods: ['POST'])]
    public function delete(Request $request, Membership $membership, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membership->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($membership);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_membership_index', [], Response::HTTP_SEE_OTHER);
    }
}
