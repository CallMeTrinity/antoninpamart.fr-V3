<?php

namespace App\Twig\Components;

use App\Repository\ProjectRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('_project')]
class ProjectComponent
{
    public int $id;
public function __construct(private readonly ProjectRepository $projectRepository)
{
}

    public function getProject()
    {
        return $this->projectRepository->findOneBy(['id' => $this->id]);
    }
}