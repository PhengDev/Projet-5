<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @return Array
     */
    public function findAllVisible(): array
    {
        return $this->findVisibleQuery()
        ->orderBy('p.id', 'DESC')
        ->getQuery()
        ->getResult()
    ;
    }

    public function findLatest(): array
    {
        return $this->findVisibleQuery()
        ->setMaxResults(4)
        ->orderBy('p.id', 'DESC')
        ->getQuery()
        ->getResult()
    ;
    }
    
    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
        ->where('p.sold = false')
    ;
    }

    public function findPropertyByString($str): array
    {
        return  $this->getEntityManager()
        ->createQuery(
            'SELECT e
            FROM App:Property e
            WHERE e.title LIKE :str'
        )
        ->setParameter('str', '%'.$str.'%')
        ->setMaxResults(6)
        ->getResult();
    }
    
    /**
     * @return Query
     */
    public function findAllByNameAscQuery(): Query
    {
        return $this->findByNameAscQuery()
            ->getQuery();
    }
    /**
     * @param $array
     * @return Property[]
     */
    public function findArray($array): array
    {
        return $this->findByNameAscQuery()
            ->andWhere('p.id IN (:array)')
            ->setParameter('array', $array)
            ->getQuery()
            ->getResult();
    }
    /**
     * @return QueryBuilder
     */
    private function findByNameAscQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.title', 'ASC');
    }
    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
