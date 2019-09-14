<?php

namespace App\Repository;

use App\Entity\RelayPoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RelayPoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelayPoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelayPoint[]    findAll()
 * @method RelayPoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelayPointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelayPoint::class);
    }

    // /**
    //  * @return RelayPoint[] Returns an array of RelayPoint objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RelayPoint
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
