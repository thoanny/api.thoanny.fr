<?php

namespace App\Controller\Admin\PressReview;

use App\Entity\PressReview\Issue;
use App\Form\Admin\PressReview\IssueType;
use App\Repository\PressReview\IssueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_ADMIN")]
#[Route('/admin/press-reviews/issues')]
final class IssueController extends AbstractController
{
    #[Route(name: 'app_admin_press_review_issue_index', methods: ['GET'])]
    public function index(IssueRepository $issueRepository): Response
    {
        return $this->render('admin/press_review/issue/index.html.twig', [
            'issues' => $issueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_press_review_issue_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $issue = new Issue();
        $form = $this->createForm(IssueType::class, $issue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($issue);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_press_review_issue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/press_review/issue/new.html.twig', [
            'issue' => $issue,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_press_review_issue_show', methods: ['GET'])]
    public function show(Issue $issue): Response
    {
        return $this->render('admin/press_review/issue/show.html.twig', [
            'issue' => $issue,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_press_review_issue_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Issue $issue, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IssueType::class, $issue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_press_review_issue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/press_review/issue/edit.html.twig', [
            'issue' => $issue,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_press_review_issue_delete', methods: ['POST'])]
    public function delete(Request $request, Issue $issue, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$issue->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($issue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_press_review_issue_index', [], Response::HTTP_SEE_OTHER);
    }
}
