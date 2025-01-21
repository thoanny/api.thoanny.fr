<?php

namespace App\Controller\Admin\OnceHuman;

use App\Entity\OnceHuman\Item;
use App\Form\Admin\OnceHuman\ItemType;
use App\Repository\OnceHuman\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/once-human/items')]
final class ItemController extends AbstractController
{
    #[Route(name: 'app_admin_once_human_item_index', methods: ['GET'])]
    public function index(ItemRepository $itemRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $items = $paginator->paginate(
            $itemRepository->findAll(),
            $request->query->getInt('page', 1),
            50
        );

        return $this->render('admin/once_human/item/index.html.twig', [
            'items' => $items,
        ]);
    }

    #[Route('/new', name: 'app_admin_once_human_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($item);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/item/new.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_item_show', methods: ['GET'])]
    public function show(Item $item): Response
    {
        return $this->render('admin/once_human/item/show.html.twig', [
            'item' => $item,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_once_human_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Item $item, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_once_human_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/once_human/item/edit.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_once_human_item_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Item $item, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($item);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_once_human_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
