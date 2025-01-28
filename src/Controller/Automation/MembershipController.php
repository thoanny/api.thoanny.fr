<?php

namespace App\Controller\Automation;

use App\Entity\Membership;
use App\Repository\MembershipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class MembershipController extends AbstractController
{
    #[Route('/automation/memberships/{type<twitch|patreon>}', name: 'app_automation_membership', methods: ['POST'])]
    public function index(string $type, Request $request, MembershipRepository $membershipRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $token = $request->query->get('token');
        if($this->getParameter('automation.token') !== $token) {
            return $this->json(['code' => 401, 'message' => 'Unauthorized'], 401);
        }

        $data = json_decode($request->request->get('data'));

        if($data) {

            foreach($membershipRepository->findBy(['network' => $type, 'active' => true]) as $member) {
                $member
                    ->setActive(false)
                    ->setUpdatedAt(new \DateTimeImmutable())
                ;
                $entityManager->persist($member);
            }
            $entityManager->flush();

            if('twitch' === $type) {
                foreach($data as $member) {

                    if($member->broadcaster_id === $member->user_id) {
                        continue;
                    }

                    $membershipExists = $membershipRepository->findOneBy(['network' => $type, 'uid' => $member->user_id]);
                    if(!$membershipExists) {
                        $membership = (new Membership())
                            ->setNetwork($type)
                            ->setActive(true)
                            ->setName($member->user_name)
                            ->setUid($member->user_id)
                            ->setUpdatedAt(new \DateTimeImmutable())
                        ;
                        $entityManager->persist($membership);
                    } else {
                        $membershipExists
                            ->setActive(true)
                            ->setUpdatedAt(new \DateTimeImmutable())
                        ;
                        $entityManager->persist($membershipExists);
                    }
                    $entityManager->flush();
                }
            } else {
                foreach($data as $member) {
                    $membershipExists = $membershipRepository->findOneBy(['network' => $type, 'uid' => $member->relationships->user->data->id]);
                    if(!$membershipExists) {
                        $membership = (new Membership())
                            ->setNetwork($type)
                            ->setActive($member->attributes->last_charge_status === 'Paid')
                            ->setName($member->attributes->full_name)
                            ->setUid($member->relationships->user->data->id)
                            ->setUpdatedAt(new \DateTimeImmutable())
                        ;
                        $entityManager->persist($membership);
                    } else {
                        $membershipExists
                            ->setActive($member->attributes->last_charge_status === 'Paid')
                            ->setUpdatedAt(new \DateTimeImmutable())
                        ;
                        $entityManager->persist($membershipExists);
                    }
                    $entityManager->flush();
                }
            }

        }

        return $this->json([
            'code' => 200,
            'message' => 'OK',
        ]);
    }
}
