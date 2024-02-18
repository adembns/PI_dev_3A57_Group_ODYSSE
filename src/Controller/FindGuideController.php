<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FindGuideController extends AbstractController
{
    #[Route('/findguide', name: 'app_find_guide')]
    public function index(): Response
    {
        return $this->render('find_guide/index.html.twig', [
            'controller_name' => 'FindGuideController',
        ]);
    }
}
