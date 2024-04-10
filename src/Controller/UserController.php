<?php

namespace App\Controller;

use App\Entity\Album;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/like/{id}', name: 'like_album')]
    public function like(int $id, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Només un user normal pot donar like.');

        $album = $this->entityManager->getRepository(Album::class)->find($id);

        if (!$album) {
            throw $this->createNotFoundException("No s'ha trobat àlbum amb:" . $id);
        }

        $user = $this->getUser();

        $user->addLike($album);

        $this->entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
}
