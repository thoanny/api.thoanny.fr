<?php

namespace App\Controller\OnceHuman\User;

use App\Repository\OnceHuman\CharacterRepository;
use App\Repository\OnceHuman\SpecializationRepository;
use App\Service\Api;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/once-human/user/specializations')]
#[IsGranted('ROLE_USER')]
final class SpecializationController extends AbstractController
{

    public function __construct(
        private Api $api,
        private SerializerInterface $serializer,
        private EntityManagerInterface $entityManager,
        private CharacterRepository $characterRepository,
        private SpecializationRepository $specializationRepository,
    )
    {
    }

    #[Route(name: 'app_api_once_human_user_specialization_edit', methods: ['GET', 'POST', 'DELETE'])]
    public function edit(Request $request): JsonResponse
    {
        $user = $this->getUser();

        if($request->isMethod('GET')) {
            return $this->json($this->serializer->normalize(
                $this->characterRepository->findBy(['user' => $user]),
                context: ['groups' => ['user_character_specialization']],
            ));
        }

        $data = json_decode($request->getContent());

        $character = $this->characterRepository->findOneBy(['id' => $data->character, 'user' => $user]);
        if(!$character) {
            return $this->api->createNotFoundException('Personnage introuvable.');
        }

        $specialization = $this->specializationRepository->findOneBy(['id' => $data->specialization]);
        if(!$specialization) {
            return $this->api->createNotFoundException('Spécialisation introuvable.');
        }

        if($request->isMethod('POST')) {
            if(count($character->getSpecializations()) >= 10) {
                return $this->api->createForbiddenException('Vous ne pouvez pas ajouter plus de spécialisations à ce personnage.');
            }
            $character->addSpecialization($specialization);
        } elseif ($request->isMethod('DELETE')) {
            $character->removeSpecialization($specialization);
        }

        $this->entityManager->flush();

        return $this->json($this->serializer->normalize(
            $character,
            context: ['groups' => ['user_character_specialization']],
        ));
    }

//    #[Route('/reset', name: 'app_api_once_human_user_specialization_reset', methods: ['DELETE'])]
//    public function reset(): JsonResponse
//    {
//    }
}
