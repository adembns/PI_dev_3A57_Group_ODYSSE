<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GuidedetailsController extends AbstractController
{
    #[Route('/guidedetails', name: 'app_guidedetails')]
    public function index(): Response
    {
        return $this->render('guidedetails/index.html.twig', [
            'controller_name' => 'GuidedetailsController',
        ]);
    }
}
