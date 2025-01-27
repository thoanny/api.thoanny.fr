<?php

namespace App\Controller\Admin\OnceHuman;

use App\Entity\OnceHuman\ItemCategory;
use App\Form\Admin\OnceHuman\ItemCategoryType;
use App\Repository\OnceHuman\ItemCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/once-human/items-categories')]
final class ItemCategoryController extends AbstractController
{
    #[Route(name: 'app_admin_once_human_item_category_index', methods: ['GET'])]
    public function index(ItemCategoryRepository $itemCategoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $itemCategories = $paginator->paginate(
            $itemCategoryRepository->findBy([], ['name' => 'ASC']),
            $request->query->getInt('page', 1),
            50
        );

        return $this->render('admin/once_human/item_category/index.html.twig', [
            'item_categories' => $itemCategories,
        ]);
    }

    #[Route('/new', name: 'app_admin_once_human_item_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $itemCategory = new ItemCategory();
        $form = $this->createForm(ItemCategoryType::class, $itemCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($itemCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_item_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/item_category/new.html.twig', [
            'item_category' => $itemCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_item_category_show', methods: ['GET'])]
    public function show(ItemCategory $itemCategory): Response
    {
        return $this->render('admin/once_human/item_category/show.html.twig', [
            'item_category' => $itemCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_once_human_item_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ItemCategory $itemCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItemCategoryType::class, $itemCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_item_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/item_category/edit.html.twig', [
            'item_category' => $itemCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_item_category_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, ItemCategory $itemCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemCategory->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($itemCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_once_human_item_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
