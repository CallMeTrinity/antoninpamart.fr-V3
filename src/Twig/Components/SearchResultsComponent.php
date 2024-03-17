<?php

namespace App\Twig\Components;

use App\Repository\ProjectRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('SearchResults')]
class SearchResultsComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(
        private ProjectRepository $projectRepository
    ) {
    }

    public function getProjects(): array
    {
        return $this->projectRepository->findByQuery($this->query);
    }
}
