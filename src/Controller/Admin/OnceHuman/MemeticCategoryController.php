<?php

namespace App\Controller\Admin\OnceHuman;

use App\Entity\OnceHuman\MemeticCategory;
use App\Form\Admin\OnceHuman\MemeticCategoryType;
use App\Repository\OnceHuman\MemeticCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/once-human/memetics-categories')]
final class MemeticCategoryController extends AbstractController
{
    #[Route(name: 'app_admin_once_human_memetic_category_index', methods: ['GET'])]
    public function index(MemeticCategoryRepository $memeticCategoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $categories = $paginator->paginate(
            $memeticCategoryRepository->findAll(),
            $request->query->getInt('page', 1),
            50
        );
        return $this->render('admin/once_human/memetic_category/index.html.twig', [
            'memetic_categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'app_admin_once_human_memetic_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $memeticCategory = new MemeticCategory();
        $form = $this->createForm(MemeticCategoryType::class, $memeticCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($memeticCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_memetic_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/memetic_category/new.html.twig', [
            'memetic_category' => $memeticCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_memetic_category_show', methods: ['GET'])]
    public function show(MemeticCategory $memeticCategory): Response
    {
        return $this->render('admin/once_human/memetic_category/show.html.twig', [
            'memetic_category' => $memeticCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_once_human_memetic_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MemeticCategory $memeticCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MemeticCategoryType::class, $memeticCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_memetic_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/memetic_category/edit.html.twig', [
            'memetic_category' => $memeticCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_memetic_category_delete', methods: ['POST'])]
    public function delete(Request $request, MemeticCategory $memeticCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$memeticCategory->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($memeticCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_once_human_memetic_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
