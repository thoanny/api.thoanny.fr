<?php

namespace App\Controller\Api\Vestigia;

use App\Entity\Vestigia\AccountGoal;
use App\Repository\Vestigia\AccountGoalRepository;
use App\Repository\Vestigia\AccountRepository;
use App\Repository\Vestigia\GoalRepository;
use App\Service\Api;
use App\Service\VestigiaInventory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/vestigia/goals')]
final class GoalController extends AbstractController
{
    #[Route('/', name: 'app_api_vestigia_goals', methods: ['GET'])]
    public function index(GoalRepository $goalRepository, SerializerInterface $serializer): JsonResponse
    {
        $goals = $goalRepository->findAll();
        return $this->json($serializer->normalize($goals, context: ['groups' => ['goals']]));
    }

    /**
     * @throws \Exception
     */
    #[Route('/add', name: 'app_api_vestigia_goal_add', methods: ['POST'])]
    #[IsGranted("ROLE_USER")]
    public function add(
        AccountRepository $accountRepository,
        GoalRepository $goalRepository,
        AccountGoalRepository $accountGoalRepository,
        SerializerInterface $serializer,
        Request $request,
        Api $api,
        EntityManagerInterface $entityManager,
        VestigiaInventory $vestigiaInventory,
    ): JsonResponse
    {
        $user = $this->getUser();
        $account = $accountRepository->findOneBy(['user' => $user]);
        if(!$account) {
            return $api->createNotFoundException('Account not found');
        }

        $request = $api->transformJsonBody($request);
        $goalId = $request->get('goalId');
        $date = $request->get('date');

        $goal = $goalRepository->findOneBy(['id' => $goalId]);
        if(!$goal) {
            return $api->createNotFoundException('Goal not found');
        }

        $accountGoal = $accountGoalRepository->findOneBy(['account' => $account, 'goal' => $goal]);
        if(!$accountGoal) {
            $accountGoal = (new AccountGoal())
                ->setAccount($account)
                ->setGoal($goal)
                ->setStatus('rewarded')
                ->setUpdatedAt( new \DateTimeImmutable($date) )
            ;
            $entityManager->persist($accountGoal);
            $entityManager->flush();
            $vestigiaInventory->addITem($goal->getRewardQuantity(), $goal->getRewardItem(), $account);
        } else {
            if($accountGoal->getUpdatedAt()->format('Y-m-d') === $date) {
                return $api->createConflictException('Already validated');
            } else {
                $accountGoal
                    ->setUpdatedAt(new \DateTimeImmutable($date))
                    ->setStatus('rewarded')
                ;
                $entityManager->flush();
                $vestigiaInventory->addITem($goal->getRewardQuantity(), $goal->getRewardItem(), $account);
            }
        }

        return $this->json($serializer->normalize($accountGoal, context: ['groups' => ['goal']]));
    }
}
