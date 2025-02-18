<?php

namespace App\Controller\Automation;

use App\Entity\PressReview\Post;
use App\Repository\PressReview\CategoryRepository;
use App\Repository\PressReview\PostRepository;
use App\Service\Url;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

#[Route('/automation/press-reviews')]
final class PressReviewController extends AbstractController
{
    #[Route(name: 'app_automation_press_review_index', methods: ['GET'])]
    public function index(PostRepository $postRepository, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $token = $request->query->get('token');
        if($this->getParameter('automation.token') !== $token) {
            return $this->json(['code' => 401, 'message' => 'Unauthorized'], 401);
        }

        return $this->json(
            $serializer->normalize(
                $postRepository->findAccepted(),
                context: ['groups' => ['automation_index']],
            )
        );
    }

    #[Route(name: 'app_automation_press_review_new', methods: ['POST'])]
    public function new(
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        Url $url,
    ): JsonResponse
    {
        $token = $request->query->get('token');
        if($this->getParameter('automation.token') !== $token) {
            return $this->json(['code' => 401, 'message' => 'Unauthorized'], 401);
        }

        $categoryId = $request->request->get('category');
        $category = $categoryRepository->findOneBy(['id' => $categoryId]);
        if(!$category) {
            return $this->json(['code' => 400, 'message' => 'Catégorie inconnue'], 400);
        }

        $total = 0;
        $data = json_decode($request->request->get('data'));
        if($data) {
            $namespace = Uuid::fromString(Uuid::NAMESPACE_URL);

            foreach($data as $p) {
                $link = $url->getCleanUrl($p->link);
                $uid = Uuid::v3($namespace, $link);
                $exists = $postRepository->findOneBy(['uid' => $uid]);
                if(!$exists) {
                    $post = (new Post())
                        ->setTitle($p->title)
                        ->setSource($p->source ?? null)
                        ->setLink($link)
                        ->setThumbnail($p->thumbnail ?? null)
                        ->setPublishedAt(new \DateTimeImmutable($p->published_at))
                        ->setStatus('todo')
                        ->setUid($uid)
                        ->setCategory($category);
                    ;
                    $total++;
                    $entityManager->persist($post);
                }
            }

            $entityManager->flush();
        }

        return $this->json(['code' => 200, 'message' => sprintf('%d articles ajoutés', $total)]);
    }

    #[Route('/excerpt', name: 'app_automation_press_review_excerpt', methods: ['POST'])]
    public function excerpt(PostRepository $postRepository, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $token = $request->query->get('token');
        if($this->getParameter('automation.token') !== $token) {
            return $this->json(['code' => 401, 'message' => 'Unauthorized'], 401);
        }

        $total = 0;
        $data = json_decode($request->request->get('data'));
        if($data) {
            foreach($data as $p) {
                $post = $postRepository->findOneBy(['id' => $p->id, 'status' => 'accepted']);
                if($post) {
                    $post
                        ->setDescription($p->description)
                        ->setStatus('drafted')
                    ;
                    $total++;
                }
            }
        }

        $entityManager->flush();

        return $this->json(['code' => 200, 'message' => sprintf('%d articles mis à jour', $total)]);
    }

    #[Route(name: 'app_automation_press_review_delete', methods: ['DELETE'])]
    public function delete(PostRepository $postRepository, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $token = $request->query->get('token');
        if($this->getParameter('automation.token') !== $token) {
            return $this->json(['code' => 401, 'message' => 'Unauthorized'], 401);
        }

        $posts = $postRepository->findRejected();
        foreach($posts as $post) {
            $entityManager->remove($post);
        }
        $entityManager->flush();

        return $this->json(['code' => 200, 'message' => sprintf('%d articles supprimés', count($posts))]);
    }
}
