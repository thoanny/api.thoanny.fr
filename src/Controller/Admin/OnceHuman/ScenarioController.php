<?php

namespace App\Controller\Admin\OnceHuman;

use App\Entity\OnceHuman\Scenario;
use App\Form\Admin\OnceHuman\ScenarioType;
use App\Repository\OnceHuman\ScenarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/once-human/scenarios')]
final class ScenarioController extends AbstractController
{
    #[Route(name: 'app_admin_once_human_scenario_index', methods: ['GET'])]
    public function index(ScenarioRepository $scenarioRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $scenarios = $paginator->paginate(
            $scenarioRepository->findAll(),
            $request->query->getInt('page', 1),
            50
        );

        return $this->render('admin/once_human/scenario/index.html.twig', [
            'scenarios' => $scenarios,
        ]);
    }

    #[Route('/new', name: 'app_admin_once_human_scenario_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $scenario = new Scenario();
        $form = $this->createForm(ScenarioType::class, $scenario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($scenario);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_scenario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/scenario/new.html.twig', [
            'scenario' => $scenario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_scenario_show', methods: ['GET'])]
    public function show(Scenario $scenario): Response
    {
        return $this->render('admin/once_human/scenario/show.html.twig', [
            'scenario' => $scenario,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_once_human_scenario_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Scenario $scenario, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ScenarioType::class, $scenario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_scenario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/scenario/edit.html.twig', [
            'scenario' => $scenario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_scenario_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Scenario $scenario, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scenario->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($scenario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_once_human_scenario_index', [], Response::HTTP_SEE_OTHER);
    }
}
