<?php

/*
 * This file is part of the Pamart_PortfolioV3 project.
 *
 * (c) Antonin <contact@antoninpamart.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Twig\Components;

use App\Repository\ProjectRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class AllProjects
{
    use DefaultActionTrait;

    public array $projects;

    public function __construct(private readonly ProjectRepository $projectRepository)
    {
    }

    public function findProjects(): array
    {
        return $this->projectRepository->listProjects();
    }
}
