<?php

namespace App\Controller\Admin\PressReview;

use App\Entity\PressReview\Tag;
use App\Form\Admin\PressReview\TagType;
use App\Repository\PressReview\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[IsGranted("ROLE_ADMIN")]
#[Route('/admin/press-reviews/tags')]
final class TagController extends AbstractController
{
    #[Route(name: 'app_admin_press_review_tag_index', methods: ['GET'])]
    public function index(TagRepository $tagRepository): Response
    {
        return $this->render('admin/press_review/tag/index.html.twig', [
            'tags' => $tagRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'app_admin_press_review_tag_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tag);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_press_review_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/press_review/tag/new.html.twig', [
            'tag' => $tag,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_press_review_tag_show', methods: ['GET'])]
    public function show(Tag $tag): Response
    {
        return $this->render('admin/press_review/tag/show.html.twig', [
            'tag' => $tag,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_press_review_tag_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tag $tag, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_press_review_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/press_review/tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_press_review_tag_delete', methods: ['POST'])]
    public function delete(Request $request, Tag $tag, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tag->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_press_review_tag_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/autocomplete/new', name: 'app_admin_press_review_tag_autocomplete_new', methods: ['POST'])]
    public function autocompleteAdd(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $tag = (new Tag())
            ->setName($request->request->getString('name'))
        ;
        $entityManager->persist($tag);
        $entityManager->flush();

        return $this->json(
            $serializer->normalize(
                $tag,
                context: ['groups' => ['tag_autocomplete_new']],
            )
        );
    }
}
