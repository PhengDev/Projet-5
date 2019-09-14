<?php

namespace App\Repository;

use App\Entity\UserAdresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserAdresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAdresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAdresse[]    findAll()
 * @method UserAdresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAdresseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserAdresse::class);
    }

    // /**
    //  * @return UserAdresse[] Returns an array of UserAdresse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserAdresse
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
