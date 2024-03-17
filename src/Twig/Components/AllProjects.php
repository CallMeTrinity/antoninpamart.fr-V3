<?php

namespace App\Twig\Components;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class AllProjects
{
    use DefaultActionTrait;

    public array $projects;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function findProjects(): array
    {
        return $this->entityManager->getRepository(Project::class)->listProjects();
    }
}
