<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function renderHome(): Response
    {
       return $this->render('home.html.twig');
    }
    #[Route('/a_propos')]
    public function renderAbout(): Response
    {
       return $this->render('pages/a_propos.twig');
    }

}