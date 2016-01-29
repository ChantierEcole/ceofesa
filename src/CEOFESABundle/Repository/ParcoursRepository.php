<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class ParcoursRepository extends EntityRepository
{
	public function getParcours($idStructure,$idOF,$idModule,$idModuleType)
    {
        return $this
        ->createQueryBuilder('par')
        ->innerJoin('par.prcDcont','dcnt')
        ->innerJoin('dcnt.cntDaf','daf')
        ->innerJoin('dcnt.cntTiers','trs')
        ->where('par.prcStructure = :IdOF')
        ->andWhere('par.prcModule = :IdModule')
        ->andWhere('par.prcType = :IdModuleType')
        ->andWhere('daf.dafStructure = :IdStructure')
        ->setParameters(array('IdStructure' => $idStructure, 'IdOF' => $idOF, 'IdModule' => $idModule, 'IdModuleType' => $idModuleType))
        ->orderBy('trs.trsNom', 'ASC')
        ;
    }

    /**
     * @param $idStructure
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getParcoursByStructure($idStructure)
    {
        return $this
            ->createQueryBuilder('par')
            ->innerJoin('par.prcDcont','dcnt')
            ->innerJoin('dcnt.cntDaf','daf')
            ->where('daf.dafStructure = :IdStructure')
            ->setParameters(array('IdStructure' => $idStructure))
            ;
    }

    /**
     * @param $idStructure
     * @param $date
     * @return array
     */
    public function getParcoursByStructureAndDate($idStructure, $date)
    {
        return $this
            ->createQueryBuilder('par')
            ->select('par, dcnt, daf', 'psc')
            ->innerJoin('par.prcDcont','dcnt')
            ->innerJoin('dcnt.cntDaf','daf')
            ->leftJoin('par.prcPresence', 'psc')
            ->where('daf.dafStructure = :IdStructure')
            ->andWhere('daf.dafDatedebut <= :dateDebut')
            ->andWhere('daf.dafDatefin >= :dateFin')
            ->setParameter('IdStructure', $idStructure)
            ->setParameter('dateDebut', $date->format('Y-m-01'))
            ->setParameter('dateFin', $date->format('Y-m-t'))
            ->getQuery()->getResult()
            ;
    }


    public function getParcoursAndSessions($idStructure, $idOF, $idModule, $idModuleType, $date)
    {
        $qb = $this->getParcours($idStructure, $idOF, $idModule, $idModuleType);

        $qb->addSelect('pre', 'ses')
            ->innerJoin('par.prcPresence', 'pre')
            ->innerJoin('pre.pscSession', 'ses')
            ->andWhere('ses.sesDate >= :dateMin')
            ->andWhere('ses.sesDate <= :dateMax')
            ->setParameter('dateMin', new \DateTime($date->format('Y-m-01')))
            ->setParameter('dateMax', new \DateTime($date->format('Y-m-t')))
            ->orderBy('ses.sesDate', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function getDcontTotalHeures($dcont)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('sum(t.prcNombreheure as total')
        ->where('t.prcDcont = :dcont')
        ->setParameter('dcont', $dcont)
        ;
        $result = $qb->getQuery()->getSingleScalarResult();
        return $result;
    }
}