<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Band;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(AlbumRepository $albumRepository): Response
    {
        $albums = $albumRepository->findBy([], ['releasedAt' => 'DESC']);

        return $this->render('home/index.html.twig', [
            'albums' => $albums,
        ]);
    }

    #[Route('/album/{id}', name: 'album_details')]
    public function show(Album $album): Response
    {
        // Mostrar els detalls de l'album
       // $album = $this->entityManager->getRepository(Album::class)->find($id);

        return $this->render('album/show.html.twig', [
            'album' => $album,
        ]);
    }

    #[Route('/band/{id}', name: 'band_details')]
    public function show2(Band $band): Response
    {

        return $this->render('band/show.html.twig', [
            'band' => $band,
        ]);
    }
}
