<?php

namespace App\Controller\Api;

use App\Repository\MembershipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class MembershipController extends AbstractController
{
    #[Route('/tpotes', name: 'app_api_membership', methods: ['GET'])]
    public function index(MembershipRepository $membershipRepository, SerializerInterface $serializer): JsonResponse
    {
        return $this->json([
            'tpotes' => $serializer->normalize(
                $membershipRepository->findBy([], ['name' => 'ASC']),
                context: ['groups' => ['membership_index']],
            )
        ]);
    }
}
