<?php

namespace App\Repository;

use App\Entity\Profondeur;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Profondeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profondeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profondeur[]    findAll()
 * @method Profondeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfondeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profondeur::class);
    }
    public function findApiAll()
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
    }

    public function findByProfondeur ($profondeur): ?Profondeur
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.profondeur = :profondeur')
            ->setParameter('profondeur', $profondeur)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findProfondeurApproximation ($table, $profondeur)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder();

        $query->select('p.id, p.profondeur')
            ->from('App\Entity\Profondeur', 'p')
            ->where('p.table_plongee_id = :table AND p.profondeur >= :profondeur')
            ->setMaxResults(1)
            ->setParameter('profondeur', $profondeur)
            ->setParameter('table', $table);

        return $query->getQuery()->getResult()[0];   
    }
}