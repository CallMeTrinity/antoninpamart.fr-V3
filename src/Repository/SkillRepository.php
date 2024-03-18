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

use App\Entity\Skill;
use App\Exception\SkillNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Skill>
 *
 * @method Skill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skill[]    findAll()
 * @method Skill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skill::class);
    }

    public function advancedSkills()
    {
        return $this->createQueryBuilder('s')
            ->select('s.name')
            ->where('s.mastery = 2')
            ->getQuery()
            ->getResult()
        ;
    }

    public function intermediateSkills()
    {
        return $this->createQueryBuilder('s')
            ->select('s.name')
            ->where('s.mastery = 1')
            ->getQuery()
            ->getResult()
        ;
    }

    public function baseSkills()
    {
        return $this->createQueryBuilder('s')
            ->select('s.name')
            ->where('s.mastery = 0')
            ->getQuery()
            ->getResult()
        ;
    }

    public function deleteSkill(int $id): void
    {
        $skill = $this->find($id);

        if (!$skill) {
            throw new SkillNotFoundException('La compétence n\'existe pas.');
        }

        $this->getEntityManager()->remove($skill);
        $this->getEntityManager()->flush();
    }

    //    /**
    //     * @return Skill[] Returns an array of Skill objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Skill
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
