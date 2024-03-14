<?php

namespace App\Controller;

use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/contact', name: 'contact')]
    public function renderContact(): Response
    {
       return $this->render('pages/contact.html.twig', [
           'advanced' => $this->entityManager->getRepository(Skill::class)->advancedSkills(),
           'intermediate' => $this->entityManager->getRepository(Skill::class)->intermediateSkills(),
           'basic' => $this->entityManager->getRepository(Skill::class)->baseSkills(),
       ]);
    }

}