<?php

namespace App\Controller;

use App\Entity\Album;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $albums = $this->entityManager->getRepository(Album::class)->findBy([], ['releasedAt' => 'DESC']);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'albums' => $albums,
        ]);
    }

    #[Route('/album/{id}', name: 'album_details')]
    public function show($id): Response
    {
        // Mostrar els detalls de l'album
        $album = $this->entityManager->getRepository(Album::class)->find($id);

        return $this->render('home/album_details.html.twig', [
            'album' => $album,
        ]);
    }

    #[Route('/like/{id}', name: 'like_album')]
    public function like($id): Response
    {

        $album = $this->entityManager->getRepository(Album::class)->find($id);

        if (!$album) {
            throw $this->createNotFoundException("No s'ha trobat l'àlbum amb id:".$id);
        }

        // Incrementar el contador de likes
        $album->incrementLikes();

        // Guardar en la BDA
        $this->entityManager->flush();

        // Redirigir a la home
        return $this->redirectToRoute('app_home');
    }
}
