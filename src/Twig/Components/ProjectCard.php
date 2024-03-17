<?php

namespace App\Twig\Components;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class ProjectCard
{
    public Project $project;
    public int $id;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function getProject()
    {
        return $this->entityManager->getRepository(Project::class)->findOneBy(['id' => $this->id]);
    }

}
