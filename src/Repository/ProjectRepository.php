<?php

namespace App\Repository;

use App\Entity\Project;
use App\Exception\ProjectNotFoundException;
use App\Exception\TagNotFoundException;
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
            ->Where('p.name LIKE :query')
            ->orWhere('p.type LIKE :query')
//            ->orWhere('p.tags LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->orderBy('p.created_at', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
