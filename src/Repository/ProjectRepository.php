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

namespace App\Repository;

use App\Entity\Project;
use App\Exception\ProjectNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function listProjects(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.created_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws ProjectNotFoundException
     */
    public function deleteProject(int $id): void
    {
        $project = $this->find($id);

        if (!$project) {
            throw new ProjectNotFoundException('Le projet n\'existe pas.');
        }

        $this->getEntityManager()->remove($project);
        $this->getEntityManager()->flush();
    }

    public function findByQuery(?string $query): array
    {
        if (empty($query)) {
            return [];
        }

        return $this->createQueryBuilder('p')
            ->leftJoin('p.tags', 't')
            ->Where('p.name LIKE :query')
            ->orWhere('p.type LIKE :query')
            ->orWhere('t.name LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->orderBy('p.created_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findLast4Projects()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.created_at', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
        
    }
}
