<?php

/*
 * This file is part of the antoninpamart.fr-V3 project.
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
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('SearchResults')]
class SearchResultsComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(
        private readonly ProjectRepository $projectRepository
    ) {
    }

    public function getProjects(): array
    {
        if (empty($this->query)) {
            return $this->projectRepository->listProjects();
        }

        return $this->projectRepository->findByQuery($this->query);
    }

    #[LiveAction]
    public function setQuery(#[LiveArg] string $query): void
    {
        $this->query = $query;
    }
}
