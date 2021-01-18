<?php

namespace App\Repository;

use App\Entity\TablePlongee;
use App\Entity\Profondeur;
use App\Entity\Temps;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;

/**
 * @method TablePlongee|null find($id, $lockMode = null, $lockVersion = null)
 * @method TablePlongee|null findOneBy(array $criteria, array $orderBy = null)
 * @method TablePlongee[]    findAll()
 * @method TablePlongee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TablePlongeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, TablePlongee::class);
    }


    public function findApiAll() {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
    }

    public function findInfos ($id) {
        $eM = $this->getEntityManager();

        $query = $eM->createQueryBuilder();
        
        $query->select('t.id')
            ->from('App\Entity\TablePlongee', 't')
            ->where('t.id = :id')
            ->setParameter('id', $id);
        
        if (!$query->getQuery()->getResult(Query::HYDRATE_ARRAY)) {
            return NULL;
        }

        $query = $eM->createQueryBuilder();

        $tableInfos = array();
        
        $query->select('p.id, p.profondeur')
            ->from('App\Entity\Profondeur', 'p')
            ->where('p.table_plongee_id = :id')
            ->setParameter('id', $id);
        
        $listProfondeurs = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
        
        foreach($listProfondeurs as $profondeur) {
            $currentProfondeurID = $profondeur['id'];

            $query = $eM->createQueryBuilder();

            $query->select('DISTINCT t.temps, t.palier3, t.palier6, t.palier9, t.palier12, t.palier15')
                ->from('App\Entity\Temps', 't')
                ->where('t.profondeur_id = :id')
                ->setParameter('id', $currentProfondeurID);

            array_push($tableInfos, array('profondeur' => $profondeur['profondeur'], 'temps' => $query->getQuery()->getResult(Query::HYDRATE_ARRAY)));
        }

        return $tableInfos;
    }
}