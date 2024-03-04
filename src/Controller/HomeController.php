<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{

    #[Route('home', 'home.html.twig')]
    public function renderHome(): Response
    {
       return $this->render('home');
    }

}