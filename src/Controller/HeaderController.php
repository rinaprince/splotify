<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HeaderController extends AbstractController
{
    #[Route('/header', name: 'app_header')]
    public function index(): Response
    {
        return $this->render('header/_header.html.twig', [
            'controller_name' => 'HeaderController',
        ]);
    }
}
