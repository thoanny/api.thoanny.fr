<?php

namespace App\Controller\Admin\PressReview;

use App\Entity\PressReview\Post;
use App\Form\Admin\PressReview\PostType;
use App\Repository\PressReview\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Uid\Uuid;

#[IsGranted("ROLE_ADMIN")]
#[Route('/admin/press-reviews/posts')]
final class PostController extends AbstractController
{
    #[Route(name: 'app_admin_press_review_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $status = [
            'todo' => 'À faire',
            'rejected' => 'Rejeté',
            'accepted' => 'Accepté',
            'drafted' => 'Rédigé',
            'reviewed' => 'Révisé',
            'all' => 'Tous',
        ];

        $currentStatus = array_key_first($status);
        $_status = $request->query->get('status');
        if($_status !== null && in_array($_status, array_keys($status))) {
            $currentStatus = $_status;
        }

        $posts = $paginator->paginate(
            $currentStatus === 'all' ? $postRepository->findBy([], ['id' => 'DESC']) : $postRepository->findBy(['status' => $currentStatus], ['id' => 'DESC']),
            $request->query->get('page', 1),
            50
        );

        return $this->render('admin/press_review/post/index.html.twig', [
            'posts' => $posts,
            'status' => $status,
            'currentStatus' => $currentStatus,
        ]);
    }

    #[Route('/new', name: 'app_admin_press_review_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $namespace = Uuid::fromString(Uuid::NAMESPACE_URL);
            $post->setUid(Uuid::v3($namespace, $form->get('link')->getData())); // TODO : clean l'URL, retirer params

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_press_review_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/press_review/post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_press_review_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('admin/press_review/post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_press_review_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_press_review_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/press_review/post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/accept', name: 'app_admin_press_review_post_accept', methods: ['GET'])]
    public function accept(Post $post, EntityManagerInterface $entityManager): Response
    {
        $post->setStatus('accepted');
        $entityManager->flush();
        return $this->redirectToRoute('app_admin_press_review_post_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/reject', name: 'app_admin_press_review_post_reject', methods: ['GET'])]
    public function reject(Post $post, EntityManagerInterface $entityManager): Response
    {
        $post->setStatus('rejected');
        $entityManager->flush();
        return $this->redirectToRoute('app_admin_press_review_post_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_admin_press_review_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_press_review_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
