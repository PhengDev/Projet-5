<?php

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface;

class EntityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Property::class);
    }
    
    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                "SELECT * FROM App:Entity e WHERE e.foo LIKE :str"
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }
}