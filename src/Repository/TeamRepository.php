<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    /**
     * @param array $ids
     * @return Team[]
     */
    public function findByInId(array $ids): array
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->where($qb->expr()->in('t.id', ':ids'))
            ->setParameter('ids', $ids)
        ;
        return $qb->getQuery()->getResult();
    }

    public function flush(Team $team): void
    {
        $em = $this->getEntityManager();
        $em->persist($team);
        $em->flush();
    }

    public function remove(Team $team): void
    {
        $em = $this->getEntityManager();
        $em->remove($team);
        $em->flush();
    }
}