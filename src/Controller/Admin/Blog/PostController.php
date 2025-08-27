<?php

namespace App\Controller\Admin\Blog;

use App\Entity\Blog\Post;
use App\Form\Admin\Blog\PostType;
use App\Repository\Blog\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/blog/posts')]
final class PostController extends AbstractController
{
    #[Route(name: 'app_admin_blog_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('admin/blog/post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_blog_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_blog_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/blog/post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_blog_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('admin/blog/post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_blog_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_blog_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/blog/post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_blog_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_blog_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
