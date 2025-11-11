<?php

namespace App\Repository;

use App\Entity\PermitWatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PermitWatch>
 */
class PermitWatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PermitWatch::class);
    }

    /**
     * Find all active permit watches with their related entities fully loaded
     * 
     * @return PermitWatch[]
     */
    public function findActiveWithRelations(): array
    {
        return $this->createQueryBuilder('pw')
            ->select('pw', 'u', 'ep')
            ->leftJoin('pw.user', 'u')
            ->leftJoin('pw.entryPoint', 'ep')
            ->where('pw.isActive = :active')
            ->setParameter('active', true)
            ->getQuery()
            ->getResult();
    }
}
