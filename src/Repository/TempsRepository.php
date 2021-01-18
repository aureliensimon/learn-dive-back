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

    public function findByProfondeur ($profondeurID, $tempsFond)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQueryBuilder();
        
        $query->select('t.palier3, t.palier6, t.palier9, t.palier12, t.palier15')
            ->from('App\Entity\Temps', 't')
            ->join('App\Entity\Profondeur', 'p', 'WITH', 't.profondeur_id = p.id ')
            ->where('p.id = :id AND t.temps = :fond')
            ->setParameter('id', $profondeurID)
            ->setParameter('fond', $tempsFond);


        return $query->getQuery()->getResult();   
    }

    public function findTempsApproximation ($table, $profondeur, $temps)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQueryBuilder();

        $query->select('t.palier3, t.palier6, t.palier9, t.palier12, t.palier15')
            ->from('App\Entity\Temps', 't')
            ->join('App\Entity\Profondeur', 'p','WITH','t.profondeur_id = p.id')
            ->where('p.table_plongee_id = :id AND p.profondeur = :profondeur AND t.temps >= :temps')
            ->setParameter('id', $table)
            ->setParameter('profondeur', $profondeur)
            ->setParameter('temps', $temps);

        return $query->getQuery()->getResult();   
    }
}