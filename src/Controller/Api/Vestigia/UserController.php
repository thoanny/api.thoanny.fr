<?php

namespace App\Controller\Api\Vestigia;

use App\Entity\User;
use App\Entity\Vestigia\Account;
use App\Entity\Vestigia\Character;
use App\Repository\Vestigia\AccountGoalRepository;
use App\Repository\Vestigia\AccountRepository;
use App\Repository\Vestigia\CharacterRepository;
use App\Repository\Vestigia\InventoryItemRepository;
use App\Service\Api;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/vestigia')]
final class UserController extends AbstractController
{

    public function __construct(
        protected readonly CharacterRepository $characterRepository
    )
    {
    }

    private function createCharacter(Account $account, $avatar = null): Character
    {
        $defaults = $this->getParameter('vestigia.character.defaults');
        $totalCharacters = $account->getCharacters()->count();
        $previousCharacter = $this->characterRepository->findOneBy(['account' => $account, 'dead' => true], ['id' => 'DESC']);

        $character = (new Character())
            ->setIteration($totalCharacters+1)
            ->setDead(false)
            ->setHpMin($defaults['hpMin'])
            ->setHpMax($defaults['hpMax'])
            ->setAtk($defaults['atk'])
            ->setDef($defaults['def'])
            ->setApMin($defaults['apMin'])
            ->setApMax($defaults['apMax'])
            ->setLvl(1)
            ->setXp(0)
        ;

        if($avatar) {
            $character
                ->setAvatarBody($avatar['body'])
                ->setAvatarHead($avatar['head'])
                ->setAvatarFace($avatar['face'])
                ->setAvatarHairs($avatar['hairs'] ?: '')
                ->setAvatarAccessory($avatar['accessory'] ?: '')
            ;
        } elseif($previousCharacter) {
            $character
                ->setAvatarBody($previousCharacter->getAvatarBody())
                ->setAvatarHead($previousCharacter->getAvatarHead())
                ->setAvatarFace($previousCharacter->getAvatarFace())
                ->setAvatarHairs($previousCharacter->getAvatarHairs())
                ->setAvatarAccessory($previousCharacter->getAvatarAccessory())
            ;
        }

        return $character;
    }

    #[Route('/@me', name: 'app_api_vestigia_user')]
    #[IsGranted("ROLE_USER")]
    public function user(
        AccountRepository $accountRepository,
        AccountGoalRepository $accountGoalRepository,
        InventoryItemRepository $inventoryItemRepository,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
    ): JsonResponse
    {
        $user = $this->getUser();
        $account = $accountRepository->findOneBy(['user' => $user]);

        $goals = $accountGoalRepository->findBy(['account' => $account]);
        $inventory = $inventoryItemRepository->findBy(['account' => $account]);
        $currentCharacter = $this->characterRepository->findOneBy(['account' => $account, 'dead' => false]);

        if($account && !$currentCharacter) {
            $currentCharacter = $this->createCharacter($account);
            $account->addCharacter($currentCharacter);
            $entityManager->flush();
        }

        return new JsonResponse([
            'account' => $serializer->normalize($account, context: ['groups' => ['me']]),
            'goals' => $goals ? $serializer->normalize($goals, context: ['groups' => ['me']]) : null,
            'inventory' => $inventory ? $serializer->normalize($inventory, context: ['groups' => ['me']]) : null,
            'character' => $serializer->normalize($currentCharacter, context: ['groups' => ['me']]),
        ]);
    }

    /**
     * Création du compte Vestigia si inexistant
     * @param AccountRepository $accountRepository
     * @param Api $api
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    #[Route('/create-account', name: 'app_api_vestigia_create_account', methods: ['POST'])]
    #[IsGranted("ROLE_USER")]
    public function createAccount(
        AccountRepository $accountRepository,
        Api $api,
        Request $request,
        EntityManagerInterface $entityManager,
    ): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $account = $accountRepository->findOneBy(['user' => $user]);
        if($account) {
            return $api->createForbiddenException('Account already exists');
        }

        $request = $api->transformJsonBody($request);
        $nickname = $request->get('nickname');
        $avatar = $request->get('avatar');

        $account = $accountRepository->findOneBy(['nickname' => $nickname]);
        if($account) {
            return $api->createConflictException('Choose another nickname');
        }

        $account = (new Account())
            ->setNickname($nickname)
            ->setUser($user)
        ;

       $account->addCharacter($this->createCharacter($account, $avatar));

        $entityManager->persist($account);
        $entityManager->flush();

        return $api->respondCreated('Account created');
    }

    #[Route('/update-avatar', name: 'app_api_vestigia_update_avatar', methods: ['POST'])]
    #[IsGranted("ROLE_USER")]
    public function updateAvatar(
        Api $api,
        Request $request,
        AccountRepository $accountRepository,
        EntityManagerInterface $entityManager,
    ): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        $account = $accountRepository->findOneBy(['user' => $user]);
        if(!$account) {
            return $api->createNotFoundException('Account not found');
        }

        $currentCharacter = $this->characterRepository->findOneBy(['account' => $account, 'dead' => false]);
        if(!$currentCharacter) {
            return $api->createNotFoundException('Current character not found');
        }

        $request = $api->transformJsonBody($request);
        $avatar = $request->get('avatar');
        $currentCharacter
            ->setAvatarBody($avatar['body'])
            ->setAvatarHead($avatar['head'])
            ->setAvatarFace($avatar['face'])
            ->setAvatarHairs($avatar['hairs'] ?: '')
            ->setAvatarAccessory($avatar['accessory'] ?: '')
        ;

        $entityManager->flush();
        return $api->respondOk();
    }
}
