<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[Broadcast]
#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $project_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $project_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $project_description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $project_cover = null;

    #[ORM\Column(length: 255, nullable: true, options: ['default' => 'https://github.com/CallMeTrinity'])]
    private ?string $project_resource;

    #[ORM\Column(nullable: true)]
    private ?string $project_created_at = null;


    public function setId(?int $id): static
    {
        $this->id = $id;
        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectName(): ?string
    {
        return $this->project_name;
    }

    public function setProjectName(string $project_name): static
    {
        $this->project_name = $project_name;

        return $this;
    }

    public function getProjectType(): ?string
    {
        return $this->project_type;
    }

    public function setProjectType(?string $project_type): static
    {
        $this->project_type = $project_type;

        return $this;
    }

    public function getProjectDescription(): ?string
    {
        return $this->project_description;
    }

    public function setProjectDescription(?string $project_description): static
    {
        $this->project_description = $project_description;

        return $this;
    }

    public function getProjectCover(): ?string
    {
        return $this->project_cover;
    }

    public function setProjectCover(?string $project_cover): static
    {
        $this->project_cover = $project_cover;

        return $this;
    }

    public function getProjectResource(): ?string
    {
        return $this->project_resource;
    }

    public function setProjectResource(?string $project_resource): static
    {
        $this->project_resource = $project_resource;

        return $this;
    }

    public function getProjectCreatedAt(): ?string
    {
        return $this->project_created_at;
    }

    public function setProjectCreatedAt(?string $project_created_at): static
    {
        $this->project_created_at = $project_created_at;

        return $this;
    }
}
