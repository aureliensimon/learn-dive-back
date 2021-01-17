<?php

namespace App\Repository;

use App\Entity\Temps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Temps|null find($id, $lockMode = null, $lockVersion = null)
 * @method Temps|null findOneBy(array $criteria, array $orderBy = null)
 * @method Temps[]    findAll()
 * @method Temps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TempsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Temps::class);
    }
    public function findApiAll()
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
    }

    public function findApiByID ($value): ?Temps
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}