<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Api;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    #[Route('/@me', name: 'app_api_user', methods: ['GET'])]
    #[IsGranted("ROLE_USER")]
    public function index(SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            data: $serializer->serialize($this->getUser(), 'json', ['groups' => 'api']),
            json: true
        );
    }

    #[Route('/user/create', name: 'app_api_user_create', methods: ['POST'])]
    public function appApiUserCreate(
        Request $request,
        UserPasswordHasherInterface $hasher,
        UserRepository $userRepository,
        EntityManagerInterface $em,
        Api $api): JsonResponse
    {
        $request = $api->transformJsonBody($request);
        $password = $request->get('password');
        $email = $request->get('email');
        $nickname = $request->get('nickname');

        if(empty($password) || empty($email) || empty($nickname)) {
            return $api->createBadRequestException("Password, Email and Nickname are required");
        }

        $exists = $userRepository->findByEmailOrNickname($email, $nickname);
        if($exists) {
            return $api->createConflictException("Email or Nickname already used");
        }

        $user = new User();
        $user->setPassword($hasher->hashPassword($user, $password));
        $user->setEmail($email);
        $user->setNickname($nickname);
        $user->setCreatedAt(new \DateTimeImmutable());

        $em->persist($user);
        $em-> flush();

        return $api->respondCreated(sprintf('Users %s successfully created', $user->getNickname()));
    }
}
