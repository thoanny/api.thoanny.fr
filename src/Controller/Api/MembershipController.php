<?php

namespace App\Controller\Api;

use App\Entity\Membership;
use App\Repository\MembershipRepository;
use App\Service\Api;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/tpotes', name: 'app_api_membership_post', methods: ['POST'])]
    public function addMembership(
        MembershipRepository $membershipRepository,
        Api $api,
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        $token = $request->headers->get('X-Token');
        if($this->getParameter('automation.token') !== $token) {
            return $api->createUnauthorizedException();
        }

        $request = $api->transformJsonBody($request);
        $network = $request->get('network');
        $uid = $request->get('uid');
        $name = $request->get('name');
        $active = $request->get('active');

        if(!$network || !$uid || !$name || !$active) {
            return $api->createBadRequestException();
        }

        $isActive = $active === 'True' || $active === true;

        $exists = $membershipRepository->findOneBy(['network' => $network, 'uid' => $uid]);
        if($exists) {
            $exists
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setActive($isActive)
                ->setName($name)
            ;
            $entityManager->flush();
            return $api->respondOk();
        }

        $membership = (new Membership())
            ->setNetwork($network)
            ->setActive($isActive)
            ->setName($name)
            ->setUid($uid)
            ->setUpdatedAt(new \DateTimeImmutable())
        ;
        $entityManager->persist($membership);
        $entityManager->flush();

        return $api->respondCreated();
    }

    #[Route('/tpotes', name: 'app_api_membership_delete', methods: ['DELETE'])]
    public function removeMembership(
        MembershipRepository $membershipRepository,
        Request $request,
        Api $api,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        $token = $request->headers->get('X-Token');
        if($this->getParameter('automation.token') !== $token) {
            return $api->createUnauthorizedException();
        }

        $network = $request->query->getAlpha('network');
        $uid = $request->query->getInt('uid');

        if(!$network || !$uid) {
            return $api->createBadRequestException();
        }

        $exists = $membershipRepository->findOneBy(['network' => $network, 'uid' => $uid]);
        if(!$exists) {
            return $api->createNotFoundException();
        }

        $entityManager->remove($exists);
        $entityManager->flush();

        return $api->respondOk();
    }

}
