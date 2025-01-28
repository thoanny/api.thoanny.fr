<?php

namespace App\Controller;

use App\Repository\MembershipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[IsGranted('ROLE_USER')]
#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route(name: 'app_user')]
    public function index(RouterInterface $router, Request $request): Response
    {

        $session = $request->getSession();
        $state = $session->get('state');

        if(!$state) {
            $state = Uuid::v4()->toBase58();
            $session->set('state', $state);
        }

        $patreonQuery = http_build_query([
            'response_type' => 'code',
            'client_id' => $this->getParameter('patreon.client.id'),
            'redirect_uri' => $router->generate('app_user_patreon', referenceType: UrlGeneratorInterface::ABSOLUTE_URL),
            'state' => $state,
        ]);

        $twitchQuery = http_build_query([
            'client_id' => $this->getParameter('twitch.client.id'),
            'force_verify' => 'true',
            'redirect_uri' => $router->generate('app_user_twitch', referenceType: UrlGeneratorInterface::ABSOLUTE_URL),
            'response_type' => 'code',
            'state' => $state,
        ]);

        return $this->render('user/index.html.twig', [
            'patreon_link_url' => "https://www.patreon.com/oauth2/authorize?$patreonQuery",
            'twitch_link_url' => "https://id.twitch.tv/oauth2/authorize?$twitchQuery",
        ]);
    }

    #[Route('/patreon', name: 'app_user_patreon')]
    public function patreon(
        Request $request,
        HttpClientInterface $client,
        RouterInterface $router,
        EntityManagerInterface $entityManager,
        MembershipRepository $membershipRepository
    ): Response
    {
        if($request->query->get('state') !== $request->getSession()->get('state')) {
            $this->addFlash('danger', 'L\'état ne correspond pas, merci de réessayer.');
            return $this->redirectToRoute('app_user');
        }

        $request->getSession()->remove('state');

        $patreonQuery = http_build_query([
            'code' => $request->query->get('code'),
            'grant_type' => 'authorization_code',
            'client_id' => $this->getParameter('patreon.client.id'),
            'client_secret' => $this->getParameter('patreon.client.secret'),
            'redirect_uri' => $router->generate('app_user_patreon', referenceType: UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        try {
            $tokenRequest = $client->request('POST', "https://www.patreon.com/api/oauth2/token", [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body' => $patreonQuery,
            ]);

            $tokenContent = $tokenRequest->getContent();
            $tokenData = json_decode($tokenContent);

            if($tokenData->access_token) {
                $identityRequest = $client->request('GET', 'https://www.patreon.com/api/oauth2/v2/identity', [
                    'headers' => [
                        'Authorization' => "Bearer $tokenData->access_token",
                    ]
                ]);

                $identityContent = $identityRequest->getContent();
                $identityData = json_decode($identityContent);

                if($identityData->data->id) {
                    $this->getUser()->setPatreonUid($identityData->data->id);
                    $entityManager->flush();

                    $membershipExists = $membershipRepository->findOneBy(['network' => 'patreon', 'uid' => $identityData->data->id]);
                    if($membershipExists) {
                        $this->getUser()->addMembership($membershipExists);
                        $entityManager->flush();
                    }
                }
            }

            return $this->redirectToRoute('app_user');

        }catch(\Exception $e) {
            $this->addFlash('danger', $e->getMessage());
            return $this->redirectToRoute('app_user');
        }
    }

    #[Route('/patreon/unlink', name: 'app_user_patreon_unlink')]
    public function patreonUnlink(EntityManagerInterface $entityManager, MembershipRepository $membershipRepository): RedirectResponse
    {
        $user = $this->getUser();

        $user->setPatreonUid(null);
        $entityManager->flush();

        $membershipExists = $membershipRepository->findOneBy(['network' => 'patreon', 'user' => $user]);
        if($membershipExists) {
            $user->removeMembership($membershipExists);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Le compte Patreon a bien été délié.');
        return $this->redirectToRoute('app_user');
    }

    #[Route('/twitch', name: 'app_user_twitch')]
    public function twitch(
        Request $request,
        HttpClientInterface $client,
        RouterInterface $router,
        EntityManagerInterface $entityManager,
        MembershipRepository $membershipRepository
    ): Response
    {
        if($request->query->get('state') !== $request->getSession()->get('state')) {
            $this->addFlash('danger', 'L\'état ne correspond pas, merci de réessayer.');
            return $this->redirectToRoute('app_user');
        }

        $request->getSession()->remove('state');

        $twitchQuery = http_build_query([
            'code' => $request->query->get('code'),
            'grant_type' => 'authorization_code',
            'client_id' => $this->getParameter('twitch.client.id'),
            'client_secret' => $this->getParameter('twitch.client.secret'),
            'redirect_uri' => $router->generate('app_user_twitch', referenceType: UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        try {
            $tokenRequest = $client->request('POST', "https://id.twitch.tv/oauth2/token", [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body' => $twitchQuery,
            ]);

            $tokenContent = $tokenRequest->getContent();
            $tokenData = json_decode($tokenContent);

            if($tokenData->access_token) {
                $identityRequest = $client->request('GET', 'https://api.twitch.tv/helix/users', [
                    'headers' => [
                        'Authorization' => "Bearer $tokenData->access_token",
                        'Client-Id' => $this->getParameter('twitch.client.id'),
                    ]
                ]);

                $identityContent = $identityRequest->getContent();
                $identityData = json_decode($identityContent);

                if($identityData->data[0]->id) {
                    $this->getUser()->setTwitchUid($identityData->data[0]->id);
                    $entityManager->flush();

                    $membershipExists = $membershipRepository->findOneBy(['network' => 'twitch', 'uid' => $identityData->data[0]->id]);
                    if($membershipExists) {
                        $this->getUser()->addMembership($membershipExists);
                        $entityManager->flush();
                    }
                }
            }

            return $this->redirectToRoute('app_user');

        }catch(\Exception $e) {
            $this->addFlash('danger', $e->getMessage());
            return $this->redirectToRoute('app_user');
        }
    }

    #[Route('/twitch/unlink', name: 'app_user_twitch_unlink')]
    public function twitchUnlink(EntityManagerInterface $entityManager, MembershipRepository $membershipRepository): RedirectResponse
    {
        $user = $this->getUser();

        $user->setTwitchUid(null);
        $entityManager->flush();

        $membershipExists = $membershipRepository->findOneBy(['network' => 'twitch', 'user' => $user]);
        if($membershipExists) {
            $user->removeMembership($membershipExists);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Le compte Twitch a bien été délié.');
        return $this->redirectToRoute('app_user');
    }

}
