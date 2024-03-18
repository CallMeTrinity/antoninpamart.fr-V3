<?php

/*
 * This file is part of the AntoninPamartPortfolioV3 project.
 *
 * (c) Antonin <contact@antoninpamart.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

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
