<?php

namespace App\Controller;

use App\Entity\Album;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/_header.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/like/{id}', name: 'like_album', methods: ['POST'])]
    public function like(int $id, Request $request): JsonResponse
    {
        $album = $this->entityManager->getRepository(Album::class)->find($id);

        if (!$album) {
            return new JsonResponse(['success' => false, 'message' => "Album no trobat amb l'id: $id"]);
        }

        $user = $this->getUser();

        $user->addLike($album);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['success' => true, 'message' => "S'ha fet like"]);
    }

    #[Route('/dislike/{id}', name: 'dislike_album', methods: ['POST'])]
    public function dislike(int $id, Request $request): JsonResponse
    {
        $album = $this->entityManager->getRepository(Album::class)->find($id);

        if (!$album) {
            return new JsonResponse(['success' => false, 'message' => "Album no trobat amb l'id: $id"]);
        }

        $user = $this->getUser();

        if ($user->getLikes()->contains($album)) {
            $user->removeLike($album);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return new JsonResponse(['success' => true, 'message' => "S'ha fet dislike"]);
    }
}
