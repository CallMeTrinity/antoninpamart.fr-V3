<?php

namespace App\Controller;

use App\Entity\Moi;
use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AboutController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/a_propos', name: 'about')]
    public function renderAbout(): Response
    {
        return $this->render('/pages/a_propos.html.twig', [
                'advanced' => $this->entityManager->getRepository(Skill::class)->advancedSkills(),
                'intermediate' => $this->entityManager->getRepository(Skill::class)->intermediateSkills(),
                'basic' => $this->entityManager->getRepository(Skill::class)->baseSkills(),
                'info' => $this->entityManager->getRepository(Moi::class)->findAll()[0],
            ]
        );
    }

}